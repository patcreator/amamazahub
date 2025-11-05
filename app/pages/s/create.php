   <?php
// structure.php
$structureFile = 'app/system/api/structure.json'; // or structure.xml
if (file_exists($structureFile)) {
    $ext = pathinfo($structureFile, PATHINFO_EXTENSION);
    if ($ext === 'json') {
        $tables = json_decode(file_get_contents($structureFile), true);
    } elseif ($ext === 'xml') {
        $xml = simplexml_load_file($structureFile);
        $tables = json_decode(json_encode($xml), true);
    }
} else {
    die("Structure file not found");
}
?>

<div class="py-6 dark:bg-gray-800 bg-white mx-8 rounded-3xl mt-9">

    <!-- Table Selector -->
    <label class="block dark:text-gray-200 mb-2 font-semibold text-gray-700 px-6 text-xl"><i class="mdi mdi-plus-circle"></i> Register new data</label>
    <div class="p-1 border-b mb-5 dark:border-gray-600"></div>
    <div class="px-6">
    <select id="tableSelect" class="border dark:border-gray-600 p-2 rounded mb-4 w-full">
            <option value="">-- Open --</option>
        <?php foreach ($tables as $tableName => $tableData): ?>
            <option value="<?= $tableName ?>"><?= $tableName ?></option>
        <?php endforeach; ?>
    </select>
    </div>

    <!-- Container for dynamic form -->
    <div id="formContainer" class="px-6 mx-6 py-5 rounded-lg"></div>

</div>

<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    $('#tableSelect').on('change', function() {
        let table = $(this).val();
        if (!table) {
            $('#formContainer').html('');
            return;
        }

        // Fetch form via AJAX
        $.ajax({
            url: '<?= $path ?>app/system/api/create/get_form.php', // a new PHP file that returns form HTML
            method: 'GET',
            data: { table: table },
            success: function(response) {
                $('#formContainer').html(response);
            },
            error: function(xhr) {
                // alert(JSON.stringify(xhr));
                showMessage('Failed to load form','error');
            }
        });
    });

    // Delegate submit event because form is loaded dynamically
    $(document).on('submit', '#dynamicForm', function(e) {
        e.preventDefault();
        let form = $(this);
        $.ajax({
            url: '<?= $path ?>app/system/api/create/save_form.php', // handles insert/update
            method: 'POST',
            data: form.serialize(),
            success: function(res) {
                if (res.success) {
                    showMessage(res.message,'success');
                    form[0].reset();
                    $('[name="id"]').val(randomIntInclusive(999,9999));
                }else{
                    showMessage(res.message,'error');
                }
                
                
            },
            error: function() {
                showMessage('Failed to save.','error');
            }
        });
    });
});


// float in [min, max)
const randomFloat = (min, max) => Math.random() * (max - min) + min;

// int in [min, max] inclusive
function randomIntInclusive(min, max) {
  min = Math.ceil(min); 
  max = Math.floor(max);
  return Math.floor(Math.random() * (max - min + 1)) + min;
}

// int in [min, max) exclusive upper bound
const randomInt = (min, max) => Math.floor(Math.random() * (max - min)) + min;

// random array element
const choice = arr => arr[Math.floor(Math.random() * arr.length)];

// crypto: secure integer in [0, range)
function secureRandomRange(range) {
  if (!Number.isInteger(range) || range <= 0 || range > 0xFFFFFFFF) throw new Error('range must be integer 1..2^32-1');
  const arr = new Uint32Array(1);
  const maxUint = 0xFFFFFFFF;
  const threshold = (maxUint - (maxUint % range)) >>> 0;
  while (true) {
    crypto.getRandomValues(arr);
    const r = arr[0];
    if (r < threshold) return r % range;
  }
}

</script>

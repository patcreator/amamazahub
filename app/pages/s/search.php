<?php
$structureFile = 'app/system/api/structure.json';
$tables = [];

if (file_exists($structureFile)) {
    $json = json_decode(file_get_contents($structureFile), true);
    $tables = isset($json['tables']) ? $json['tables'] : array_keys($json);
}
?>
<title>Search. $project_name</title>
<div class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 p-6 mt-9">

<div class="max-w-5xl mx-auto">
  <h1 class="text-2xl font-bold mb-6">Dynamic Table Search</h1>

  <!-- Search Form -->
  <div class="flex flex-wrap gap-3 mb-6">
    <select id="ds_table" class="px-4 py-2 rounded border bg-white dark:bg-gray-800 dark:border-gray-700">
      <option value="">-- Select Table --</option>
      <?php foreach ($tables as $t): ?>
        <option value="<?= htmlspecialchars($t) ?>"><?= htmlspecialchars(ucfirst($t)) ?></option>
      <?php endforeach; ?>
    </select>

    <select id="ds_column" class="px-4 py-2 rounded border bg-white dark:bg-gray-800 dark:border-gray-700">
      <option value="">-- Select Column --</option>
    </select>

    <input type="text" id="ds_search" placeholder="Type or use voice..." 
           class="flex-grow px-4 py-2 border rounded dark:bg-gray-800 dark:border-gray-700">

    <button id="ds_search_btn" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Search</button>
    <button id="vs_start" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">🎤 Voice</button>
  </div>

  <!-- Suggestions -->
  <ul id="ds_suggestions" class="mb-4 border rounded bg-white dark:bg-gray-800 max-h-60 overflow-y-auto hidden"></ul>

  <!-- Main Content Area -->
  <div id="ds_main_content" class="bg-white dark:bg-gray-800 rounded p-4 shadow"></div>
</div>

<script>
// --- Update columns when table changes ---
$('#ds_table').on('change', function() {
  const table = $(this).val();
  $('#ds_column').empty().append('<option value="">-- Select Column --</option>');

  if (!table) return;

  // Load structure.json for selected table columns
  $.get('<?= $path.$structureFile ?>', function(data) {
    const columns = data[table]?.columns || [];
    columns.forEach(col => {
      $('#ds_column').append(`<option value="${col.name}">${col.name}</option>`);
    });
  });
});

// --- Live search suggestions ---
let suggestionTimeout = null;
$('#ds_search').on('input', function() {
  clearTimeout(suggestionTimeout);
  const table = $('#ds_table').val();
  const column = $('#ds_column').val();
  const query = $(this).val();
  if (!table || !column || !query) {
    $('#ds_suggestions').hide();
    return;
  }

  suggestionTimeout = setTimeout(() => {
    $.get('<?= $path ?>app/system/api/search_in_table.php', { ajax: 1, table: table, column: column, q: query }, function(data) {
      const ul = $('#ds_suggestions');
      ul.empty();
      if (data.length === 0) {
        ul.hide();
        return;
      }
      data.forEach(row => {
        const display = row[column] ?? '';
        const li = $('<li></li>').text(display)
                     .addClass('px-4 py-2 hover:bg-gray-200 dark:hover:bg-gray-700 cursor-pointer')
                     .on('click', function() {
                        searchData();
                     });
        ul.append(li);
      });
      ul.show();
    });
  }, 300);
});

// --- Search button click ---
$('#ds_search_btn').on('click', function() {
  searchData();
});
function searchData(){
    const table = $('#ds_table').val();
  const column = $('#ds_column').val();
  const query = $('#ds_search').val();
  if (!table || !column || !query) return;

  $.get('<?= $path ?>app/system/api/search_in_table.php', 
    { ajax: 1, table: table, column: column, q: query }, 
    function(data) {
      $('#ds_suggestions').hide();
      const content = $('#ds_main_content');
      content.empty();

      if (!data || data.length === 0) {
        content.text('No results found.');
        return;
      }

      // Create table element
      const tableElem = $('<table class="min-w-full border border-gray-300 rounded-lg text-sm bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100"></table>');
      const thead = $('<thead class="bg-gray-100 dark:bg-gray-800"></thead>');
      const tbody = $('<tbody></tbody>');

      // Get column names from first result
      const columns = Object.keys(data[0]);

      // Build table header
      let headerRow = $('<tr></tr>');
      columns.forEach(col => {
        headerRow.append(`<th class="border px-2 py-1 text-left font-semibold">${col}</th>`);
      });
      // Add 'Action' column
      headerRow.append('<th class="border px-2 py-1 text-left font-semibold">Action</th>');
      thead.append(headerRow);
      tableElem.append(thead);

      // Build table body rows
      data.forEach(row => {
        let tr = $('<tr class="even:bg-gray-50 dark:even:bg-gray-800"></tr>');
        columns.forEach(col => {
          tr.append(`<td class="border px-2 py-1">${row[col] ?? ''}</td>`);
        });

        // Action link column
        const actionLink = `<a href="<?= $path ?>s/content?e=${encodeURIComponent(table)}&col=${encodeURIComponent(column)}" class="text-blue-600 hover:underline">Open link</a>`;
        tr.append(`<td class="border px-2 py-1">${actionLink}</td>`);

        tbody.append(tr);
      });

      tableElem.append(tbody);
      content.append(tableElem);
    }
  );
}

// --- Voice search ---
let recognition;
if ('webkitSpeechRecognition' in window || 'SpeechRecognition' in window) {
  const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
  recognition = new SpeechRecognition();
  recognition.lang = 'en-US';
  recognition.interimResults = false;
  recognition.maxAlternatives = 1;

  $('#vs_start').on('click', function() {
    if (!recognition) return alert('Voice recognition not supported');
    recognition.start();
  });

  recognition.onresult = function(event) {
    const transcript = event.results[0][0].transcript;
    $('#ds_search').val(transcript).trigger('input');
  };

  recognition.onerror = function(event) {
    alert('Voice recognition error: ' + event.error);
  };
}
</script>

</section>
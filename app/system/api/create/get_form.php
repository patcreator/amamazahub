<?php
$structureFile = '../structure.json';
include '../../../api/db_helper.php';
include '../../../api/ajax.php';

$tables = json_decode(file_get_contents($structureFile), true);

$selectedTable = $_GET['table'] ?? null;
if (!$selectedTable || !isset($tables[$selectedTable])) {
    echo '<p class="text-red-500">Table not found</p>';
    exit;
}

$table = $tables[$selectedTable];
$columns = $table['columns'];
$permissions = $table['permission'];

if (empty($permissions['insert'])) {
    echo '<p class="text-gray-500">You do not have permission to insert data</p>';
    exit;
}

echo '<h2 class="text-xl font-bold mb-4">Add New ' . htmlspecialchars($selectedTable) . '</h2>';
echo '<form id="dynamicForm" class="space-y-4" enctype="multipart/form-data">';
echo '<input type="hidden" name="table" value="'.htmlspecialchars($selectedTable).'">';
$dataPk = '';
foreach ($columns as $col) {
    $name = $col['name'];
    $type = strtolower($col['type']);
    $inputType = strtolower($col['input_type'] ?? 'text');
    $default = $col['default'] ?? '';
    $placeholder = $col['placeholder'] ?? '';
    $isNull = $col['is_null'] ?? false;
    $min = $col['min'] ?? null;
    $max = $col['max'] ?? null;
    $fkTable = $col['fk_table'] ?? null;
    $fkColumnSend = $col['fk_column_to_send'] ?? null;
    $fkColumnView = $col['fk_column_to_view'] ?? null;
    if ($col['primary_key']) {$default = hexdec(bin2hex(random_bytes(3)));$dataPk='data-pk';}
    // Skip auto or timestamp fields
    if (in_array($name, ['created_at', 'updated_at']) ||
        strtoupper($col['type']) == 'SERIAL' || stripos($default, 'current_timestamp') !== false ||
        ($col['auto_increment'] ?? false)) {
        continue;
    }

    $requiredMark = $isNull ? '' : '<span class="text-red-500">*</span>';
    $optionalText = $isNull ? ' (Optional)' : '';
    $ph = htmlspecialchars($placeholder . $optionalText);

    echo '<div>';
    echo '<label class="block font-medium mb-1">' . htmlspecialchars($name) . ' ' . $requiredMark . '</label>';

    // 🔹 FOREIGN KEY dropdown (if defined)
    if ($fkTable && $fkColumnSend && $fkColumnView) {
        echo fetch_select($fkTable,$fkColumnView,$fkColumnSend);
    }

    // 🔹 ENUM / SET → dropdown
    elseif (preg_match("/enum|set/i", $type)) {
        preg_match("/\((.*?)\)/", $type, $matches);
        $options = isset($matches[1]) ? str_getcsv(str_replace("'", "", $matches[1])) : [];
        echo '<select name="'.htmlspecialchars($name).'" class="border dark:border-gray-600  p-2 rounded w-full">';
        foreach ($options as $opt) {
            $selected = ($opt == $default) ? 'selected' : '';
            echo '<option value="'.htmlspecialchars($opt).'" '.$selected.'>'.htmlspecialchars(ucfirst($opt)).'</option>';
        }
        echo '</select>';
    }

    // 🔹 File inputs (image, video, pdf, audio, etc.)
    elseif (in_array($inputType, ['file', 'image', 'video', 'audio', 'pdf'])) {
        $icon = match($inputType) {
            'image' => "<i class='fa fa-image text-blue-400'></i>",
            'video' => "<i class='fa fa-video text-green-400'></i>",
            'audio' => "<i class='fa fa-music text-purple-400'></i>",
            'pdf' => "<i class='fa fa-file-pdf text-red-400'></i>",
            default => "<i class='fa fa-file text-gray-400'></i>"
        };
        echo "
        <div class='border-2 border-dashed border-gray-400 p-4 rounded text-center cursor-pointer file-drop-area'>
            $icon
            <p class='mt-2 text-sm text-gray-500'>Click or drag & drop to upload $inputType</p>
            <input type='file' name='$name' class='hidden file-input' accept='" . ($inputType !== 'file' ? "$inputType/*" : "*") . "'>
        </div>";
    }

    // 🔹 JSON → textarea
    elseif (stripos($type, 'json') !== false) {
        $defaultJson = $default ?: "{'key':'value'}";
        echo '<textarea name="'.htmlspecialchars($name).'" placeholder="'.$ph.'" class="border dark:border-gray-600  p-2 rounded w-full" rows="4">'
            . htmlspecialchars($defaultJson) . '</textarea>';
    }

    // 🔹 Numeric → number input with min/max
    elseif (preg_match("/int|float|double|decimal/i", $type)) {
        $attr = '';
        if ($min !== null) $attr .= ' min="'.$min.'"';
        if ($max !== null) $attr .= ' max="'.$max.'"';
        echo '<input type="number" name="'.htmlspecialchars($name).'" value="'.htmlspecialchars($default).'" placeholder="'.$ph.'" '.$attr.' class="border dark:border-gray-600  p-2 rounded w-full">';
    }

    // 🔹 Boolean / Tinyint → Flowbite toggle switch
    elseif (preg_match("/tinyint|boolean/i", $type)) {
        echo '
        <label class="inline-flex items-center cursor-pointer">
          <input type="checkbox" name="'.htmlspecialchars($name).'" value="1" class="sr-only peer">
          <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 
                      dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 
                      peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full 
                      peer-checked:after:border-white after:content-[\'\'] after:absolute after:top-[2px] 
                      after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full 
                      after:h-5 after:w-5 after:transition-all dark:border-gray-600 
                      peer-checked:bg-blue-600 dark:peer-checked:bg-blue-600"></div>
        </label>';
    }

    // 🔹 Blob → file upload
    elseif (stripos($type, 'blob') !== false) {
        echo '<input type="file" name="'.htmlspecialchars($name).'" class="border dark:border-gray-600  p-2 rounded w-full">';
    }

    // 🔹 Default text input
    else {
        echo '<input type="'.htmlspecialchars($inputType).'" name="'.htmlspecialchars($name).'" value="'.htmlspecialchars($default).'" placeholder="'.$ph.'"  class="border dark:border-gray-600  p-2 rounded w-full">';
    }

    echo '</div>';
}

echo '<button type="submit" class="bg-red-500 hover:bg-red-700 text-white px-4 py-2 rounded">Save</button>';
echo '</form>';
?>

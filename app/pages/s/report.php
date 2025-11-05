        <?php
// Load structure.json to get table names
$structureFile = 'app/system/api/structure.json';
$tables = [];
$table = $_GET['get']??'';
if (file_exists($structureFile)) {
    $json = json_decode(file_get_contents($structureFile), true);
    if (isset($json['tables']) && is_array($json['tables'])) {
        $tables = $json['tables'];
    } else {
        $tables = array_keys($json); // fallback if structure is like {table: {...}}
    }
}
?>

  <title><?= $site_name ?> . reports . <?= $table ?></title>
<section class="bg-white mx-9 rounded-3xl dark:bg-slate-900 text-slate-800 dark:text-slate-100 min-h-screen p-6 shadow-xl mt-9">

<div class="max-w-6xl mx-auto">
  <header class="flex justify-between ms-9 items-center mb-6">
    <div>
      <h1 class="text-2xl font-semibold">Reports Center</h1>
      <p class="text-sm text-slate-500">Choose a table to view its reports.</p>
    </div>
  </header>

  <!-- Table Selector -->
  <div class="flex gap-3 mb-6 ms-9">
    <select onchange="location.href='<?= $path?>s/Report?get='+this.value" id="tableSelector" class="px-4 py-2 rounded-lg border bg-white dark:bg-slate-800 dark:border-slate-700 text-sm">
      <option value="">-- Select Table --</option>
      <?php foreach ($tables as $t): ?>
        <option value="<?= htmlspecialchars($t) ?>"><?= htmlspecialchars(ucfirst($t)) ?></option>
      <?php endforeach; ?>
    </select>
  </div>

  
  <!-- Content Area -->
  <div id="contentArea">
    <?php if (file_exists('app/crud/reports/'.$table.'.php')) include_once 'app/crud/reports/'.$table.'.php'; ?>
  </div>
</div>
</section>
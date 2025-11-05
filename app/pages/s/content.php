<?php

$structureFile = 'app/system/api/structure.json';

if (!file_exists($structureFile)) {
    die("Structure file not found");
}

// Load structure data (JSON or XML)
$ext = pathinfo($structureFile, PATHINFO_EXTENSION);
if ($ext === 'json') {
    $tables = json_decode(file_get_contents($structureFile), true);
} elseif ($ext === 'xml') {
    $xml = simplexml_load_file($structureFile);
    $tables = json_decode(json_encode($xml), true);
} else {
    die("Unsupported file format");
}

// Pre-fetch record counts for each table
$tableCounts = [];
foreach ($tables as $tableName => $tableData) {
    try {
        $stmt = $pdo->query("SELECT COUNT(1) FROM `$tableName`");
        $tableCounts[$tableName] = (int) $stmt->fetchColumn();
    } catch (Exception $e) {
        $tableCounts[$tableName] = null;
    }
}
?>

<style>
  .card-gradient {
    /*background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);*/

  }
  .summary-hover {
    transition: all 0.3s ease;
    position: relative;
  }
  .summary-hover:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
  }
  .card-content {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    opacity: 0;
    transform: translateY(10px);
    pointer-events: none;
    transition: opacity 0.25s ease, transform 0.25s ease;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
  }
  .card.active .card-content {
    opacity: 1;
    transform: translateY(0);
    pointer-events: auto;
  }
  .z-index{
    z-index:100000000000000000000000 !important;
  }
</style>

<section class=" py-8">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
  <h1 class="text-2xl font-bold mb-3">Contents</h1>

  <?php if (isset($_GET['e'])): $e=trim($_GET['e']); ?>
    <?php if (file_exists("app/crud/fetch/$e.php")): ?>
      <?php include_once "app/crud/fetch/$e.php"; ?>
    <?php else: ?>
      <?php include_once "app/system/errors/404.html"; ?>
    <?php endif ?>
  <?php else: ?>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 relative">
    <?php foreach ($tables as $tableName => $tableData): 
        $columns = $tableData['columns'] ?? [];
        $count = $tableCounts[$tableName];
        $numColumns = count($columns);
        $pk = [];
        $uniqueCount = 0;
        $nullableCount = 0;

        foreach ($columns as $col) {
            if (!empty($col['primary_key']) && $col['primary_key'] === true) $pk[] = $col['name'];
            if (!empty($col['is_unique']) && $col['is_unique'] === true) $uniqueCount++;
            if (empty($col['default'])) $nullableCount++;
        }
    ?>
      <article tabindex="0" class="card relative rounded-lg shadow-lg overflow-visible transition-all duration-300 summary-hover rounded-2xl">
        <div class="card-header flex  p-6 bg-white dark:bg-slate-700 h-[10rem] cursor-pointer rounded-2xl">
          <i class="<?= $icons[$tableName]??'fa fa-table' ?> fa-2x me-5"></i>
          <div>
            <h3 class="text-xl font-bold mb-2"><?= ucfirst(str_replace('_', ' ', htmlspecialchars($tableName))) ?></h3>
          <p class="text-sm opacity-90 mb-4">
            <?= $count !== null ? number_format($count) . ' rows' : 'Error fetching count' ?>
          </p>
          <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white bg-opacity-20">
            View Details
          </span>
          </div>
        </div>

        <div class="card-content p-6 rounded-xl bg-white dark:bg-slate-700">
          <div class="flex gap-3 mt-4">
            <a href="<?= $path ?>s/Create?e=<?= urlencode($tableName) ?>" 
               class="flex items-center gap-2 bg-green-600 text-white px-3 py-2 rounded hover:bg-green-700 transition">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
              </svg>
              Add
            </a>

            <a href="<?= $path ?>s/content?e=<?= urlencode($tableName) ?>" 
               class="flex items-center gap-2 bg-blue-600 text-white px-3 py-2 rounded hover:bg-blue-700 transition">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              Open
            </a>
          </div>
        </div>
      </article>
    <?php endforeach; ?>
  </div>
  <?php endif ?>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
  const cards = document.querySelectorAll(".card");

  cards.forEach(card => {
    const header = card.querySelector(".card-header");

    header.addEventListener("click", e => {
      e.stopPropagation();
      const isActive = card.classList.contains("active");
      cards.forEach(c => c.classList.remove("active","z-index"));
      if (!isActive) card.classList.add("active","z-index");
    });

    card.addEventListener("keydown", e => {
      if (["Enter", " "].includes(e.key)) {
        e.preventDefault();
        card.classList.toggle("active");
      }
    });
  });

  document.addEventListener("click", e => {
    if (!e.target.closest(".card")) cards.forEach(c => c.classList.remove("active"));
  });

  document.addEventListener("keydown", e => {
    if (e.key === "Escape") cards.forEach(c => c.classList.remove("active"));
  });
});
</script>
</section>
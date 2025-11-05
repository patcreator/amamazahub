<?php
  $stmt = $pdo->query("SELECT * FROM user_profile");
  $user_profile = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php
$now = new DateTime();
$today = $now->format('Y-m-d');
$thisWeek = $now->format('W');
$thisMonth = $now->format('m');
$thisYear = $now->format('Y');

$counts = [
  'today' => 0,
  'week' => 0,
  'month' => 0,
  'year' => 0,
  'years' => []
];

foreach ($user_profile as $item) {
  $createdAt = new DateTime($item['created_at']);
  $itemYear = $createdAt->format('Y');

  if ($createdAt->format('Y-m-d') === $today) {
    $counts['today']++;
  }
  if ($createdAt->format('W') === $thisWeek && $createdAt->format('Y') === $thisYear) {
    $counts['week']++;
  }
  if ($createdAt->format('m') === $thisMonth && $createdAt->format('Y') === $thisYear) {
    $counts['month']++;
  }
  if ($createdAt->format('Y') === $thisYear) {
    $counts['year']++;
  }

  // Grouping by year for the 'years' dataset
  if (!isset($counts['years'][$itemYear])) {
    $counts['years'][$itemYear] = 0;
  }
  $counts['years'][$itemYear]++;
}
?>
<div class="bg-white dark:bg-gray-800 dark:border-gray-800 border mx-5 my-6 py-8 px-4 rounded-3xl my-5">
<!-- fontawesome + mdi -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://cdn.jsdelivr.net/npm/@mdi/font@7.1.96/css/materialdesignicons.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- jquery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<!-- DataTables CSS (latest) -->
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.7/css/dataTables.dataTables.min.css">

<!-- DataTables JS (latest) -->
<script src="https://cdn.datatables.net/2.1.7/js/dataTables.min.js"></script>

    <h1 class="text-2xl font-bold mb-6 px-8">user_profile</h1>

    <!-- Tabs -->
    <div class="tabs flex flex-wrap gap-2 mb-4 ml-4">
      <button type="button" class="tabBtn px-4 py-2 flex items-center gap-2" data-tab="tables">
        <i class="mdi mdi-table"></i> Table
      </button>
      <button type="button" class="tabBtn px-4 py-2 flex items-center gap-2" data-tab="charts">
        <i class="mdi mdi-chart-bar"></i> Charts
      </button>
      <button type="button" class="tabBtn px-4 py-2 flex items-center gap-2" data-tab="grid">
        <i class="mdi mdi-grid"></i> Grid
      </button>
      <button type="button" class="tabBtn px-4 py-2 flex items-center gap-2" data-tab="list">
        <i class="mdi mdi-format-list-bulleted"></i> List
      </button>
      <button type="button" class="tabBtn px-4 py-2 flex items-center gap-2" data-tab="print">
        <i class="mdi mdi-printer"></i> Print
      </button>
      <button type="button" class="tabBtn px-4 py-2 flex items-center gap-2" data-tab="import">
        <i class="mdi mdi-database-import"></i> Import
      </button>
      <button type="button" class="tabBtn px-4 py-2 flex items-center gap-2" data-tab="export">
        <i class="mdi mdi-database-export"></i> Export
      </button>
      <button type="button" class="tabBtn px-4 py-2 flex items-center gap-2" data-tab="share">
        <i class="mdi mdi-share-variant"></i> Share
      </button>
    </div>

    <hr class="dark:border-gray-700">

    <!-- Bulk Actions -->
    <select id="bulkActions" class="ml-8 mb-4 px-2 mt-5 py-1 dark:bg-gray-800 border border-2 rounded">
      <option value="">Bulk Actions</option>
      <option value="edit">Edit</option>
      <option value="copy">Copy</option>
      <option value="delete">Delete</option>
      <option value="view">View</option>
      <option value="export">Export</option>
    </select>
    <button id="applyBulkAction" class="px-4 py-2 bg-gray-500 text-white rounded">Apply</button>

    <!-- Add user_profile Button -->
    <a href="#" id="adduser_profileBtn" class="mb-4 ml-8 px-4 py-2 bg-blue-500 text-white rounded inline-block">
      Add user_profile
    </a>

    <!-- Reusable Modal -->
    <div id="user_profileModal" class="fixed inset-0 w-full h-full bg-white dark:bg-gray-900 dark:text-white z-50 overflow-y-auto hidden">
      <div class="flex items-center justify-between p-4 border-b dark:border-gray-700">
        <button class="modal-close flex items-center text-gray-700 dark:text-gray-300 hover:text-black dark:hover:text-white">
          <i class="fa fa-arrow-left mr-2"></i> Back
        </button>
        <h2 class="text-xl font-bold" id="modalTitle">user_profile</h2>
        <span></span>
      </div>
      <div class="p-6 max-w-2xl mx-auto" id="modalContent"></div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto px-8 pt-2">
      <div id="tab-tables">
        <table id="user_profileTable" class="display min-w-full bg-white rounded shadow w-full text-sm text-left text-gray-700 dark:text-gray-200">
          <thead>
            <tr>
              <th class="border-0 bg-gray-100 px-4 py-4 dark:bg-gray-800 text-left"><input type="checkbox" id="selectAll"></th>
              <th class="border-0 bg-gray-100 px-4 py-4 dark:bg-gray-800 text-left bg-gray-100 dark:bg-gray-800 font-semibold text-gray-700 dark:text-gray-300 px-4 py-3">#</th>
               
        <th class="border-0 bg-gray-100 px-4 py-4 dark:bg-gray-800 text-left bg-gray-100 dark:bg-gray-800 font-semibold text-gray-700 dark:text-gray-300 px-4 py-3">id</th>
 
        <th class="border-0 bg-gray-100 px-4 py-4 dark:bg-gray-800 text-left bg-gray-100 dark:bg-gray-800 font-semibold text-gray-700 dark:text-gray-300 px-4 py-3">user_id</th>
 
        <th class="border-0 bg-gray-100 px-4 py-4 dark:bg-gray-800 text-left bg-gray-100 dark:bg-gray-800 font-semibold text-gray-700 dark:text-gray-300 px-4 py-3">first_name</th>
 
        <th class="border-0 bg-gray-100 px-4 py-4 dark:bg-gray-800 text-left bg-gray-100 dark:bg-gray-800 font-semibold text-gray-700 dark:text-gray-300 px-4 py-3">last_name</th>
 
        <th class="border-0 bg-gray-100 px-4 py-4 dark:bg-gray-800 text-left bg-gray-100 dark:bg-gray-800 font-semibold text-gray-700 dark:text-gray-300 px-4 py-3">username</th>
 
        <th class="border-0 bg-gray-100 px-4 py-4 dark:bg-gray-800 text-left bg-gray-100 dark:bg-gray-800 font-semibold text-gray-700 dark:text-gray-300 px-4 py-3">email</th>
 
        <th class="border-0 bg-gray-100 px-4 py-4 dark:bg-gray-800 text-left bg-gray-100 dark:bg-gray-800 font-semibold text-gray-700 dark:text-gray-300 px-4 py-3">phone</th>
 
        <th class="border-0 bg-gray-100 px-4 py-4 dark:bg-gray-800 text-left bg-gray-100 dark:bg-gray-800 font-semibold text-gray-700 dark:text-gray-300 px-4 py-3">avatar_url</th>
 
        <th class="border-0 bg-gray-100 px-4 py-4 dark:bg-gray-800 text-left bg-gray-100 dark:bg-gray-800 font-semibold text-gray-700 dark:text-gray-300 px-4 py-3">bio</th>
 
        <th class="border-0 bg-gray-100 px-4 py-4 dark:bg-gray-800 text-left bg-gray-100 dark:bg-gray-800 font-semibold text-gray-700 dark:text-gray-300 px-4 py-3">gender</th>
 
        <th class="border-0 bg-gray-100 px-4 py-4 dark:bg-gray-800 text-left bg-gray-100 dark:bg-gray-800 font-semibold text-gray-700 dark:text-gray-300 px-4 py-3">date_of_birth</th>
 
        <th class="border-0 bg-gray-100 px-4 py-4 dark:bg-gray-800 text-left bg-gray-100 dark:bg-gray-800 font-semibold text-gray-700 dark:text-gray-300 px-4 py-3">country</th>
 
        <th class="border-0 bg-gray-100 px-4 py-4 dark:bg-gray-800 text-left bg-gray-100 dark:bg-gray-800 font-semibold text-gray-700 dark:text-gray-300 px-4 py-3">city</th>
 
        <th class="border-0 bg-gray-100 px-4 py-4 dark:bg-gray-800 text-left bg-gray-100 dark:bg-gray-800 font-semibold text-gray-700 dark:text-gray-300 px-4 py-3">state</th>
 
        <th class="border-0 bg-gray-100 px-4 py-4 dark:bg-gray-800 text-left bg-gray-100 dark:bg-gray-800 font-semibold text-gray-700 dark:text-gray-300 px-4 py-3">zip_code</th>
 
        <th class="border-0 bg-gray-100 px-4 py-4 dark:bg-gray-800 text-left bg-gray-100 dark:bg-gray-800 font-semibold text-gray-700 dark:text-gray-300 px-4 py-3">social_links</th>
 
        <th class="border-0 bg-gray-100 px-4 py-4 dark:bg-gray-800 text-left bg-gray-100 dark:bg-gray-800 font-semibold text-gray-700 dark:text-gray-300 px-4 py-3">created_at</th>
 
        <th class="border-0 bg-gray-100 px-4 py-4 dark:bg-gray-800 text-left bg-gray-100 dark:bg-gray-800 font-semibold text-gray-700 dark:text-gray-300 px-4 py-3">updated_at</th>
 
        <th class="border-0 bg-gray-100 px-4 py-4 dark:bg-gray-800 text-left bg-gray-100 dark:bg-gray-800 font-semibold text-gray-700 dark:text-gray-300 px-4 py-3">status</th>

              

              <th class="border-0 bg-gray-100 px-4 py-4 dark:bg-gray-800 text-left bg-gray-100 dark:bg-gray-800 font-semibold text-gray-700 dark:text-gray-300 px-4 py-3">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php $i=1; foreach($user_profile as $item): ?>
            <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 hover:dark:bg-gray-700">
                <td class="border-0 px-4 py-4 dark:bg-gray-800"><input type="checkbox" class="rowCheckbox" data-id="<?= $item['id'] ?>"></td>
                <td class="border-0 px-4 py-4 dark:bg-gray-800"><?= $i++ ?></td>
                 <td class="editable" data-id="<?= $item['id'] ?>" data-field="id" data-values='20'><?= htmlspecialchars($item['id']) ?></td> <td class="editable" data-id="<?= $item['id'] ?>" data-field="user_id" data-values='20'><?= htmlspecialchars($item['user_id']) ?></td> <td class="editable" data-id="<?= $item['id'] ?>" data-field="first_name" data-values='100'><?= htmlspecialchars($item['first_name']) ?></td> <td class="editable" data-id="<?= $item['id'] ?>" data-field="last_name" data-values='100'><?= htmlspecialchars($item['last_name']) ?></td> <td class="editable" data-id="<?= $item['id'] ?>" data-field="username" data-values='50'><?= htmlspecialchars($item['username']) ?></td> <td class="editable" data-id="<?= $item['id'] ?>" data-field="email" data-values='150'><?= htmlspecialchars($item['email']) ?></td> <td class="editable" data-id="<?= $item['id'] ?>" data-field="phone" data-values='20'><?= htmlspecialchars($item['phone']) ?></td> <td class="editable" data-id="<?= $item['id'] ?>" data-field="avatar_url" data-values='500'><?= htmlspecialchars($item['avatar_url']) ?></td> <td class="editable" data-id="<?= $item['id'] ?>" data-field="bio" data-values=''><?= htmlspecialchars($item['bio']) ?></td> <td class="editable" data-id="<?= $item['id'] ?>" data-field="gender" data-values='<option>male</option><option>female</option><option>other</option>'><?= htmlspecialchars($item['gender']) ?></td> <td class="editable" data-id="<?= $item['id'] ?>" data-field="date_of_birth" data-values=''><?= htmlspecialchars($item['date_of_birth']) ?></td> <td class="editable" data-id="<?= $item['id'] ?>" data-field="country" data-values='100'><?= htmlspecialchars($item['country']) ?></td> <td class="editable" data-id="<?= $item['id'] ?>" data-field="city" data-values='100'><?= htmlspecialchars($item['city']) ?></td> <td class="editable" data-id="<?= $item['id'] ?>" data-field="state" data-values='100'><?= htmlspecialchars($item['state']) ?></td> <td class="editable" data-id="<?= $item['id'] ?>" data-field="zip_code" data-values='20'><?= htmlspecialchars($item['zip_code']) ?></td> <td class="editable" data-id="<?= $item['id'] ?>" data-field="social_links" data-values=''><?= htmlspecialchars($item['social_links']) ?></td> <td class="editable" data-id="<?= $item['id'] ?>" data-field="created_at" data-values=''><?= htmlspecialchars($item['created_at']) ?></td> <td class="editable" data-id="<?= $item['id'] ?>" data-field="updated_at" data-values=''><?= htmlspecialchars($item['updated_at']) ?></td> <td class="editable" data-id="<?= $item['id'] ?>" data-field="status" data-values='<option>male</option><option>female</option><option>other</option><option>active</option><option>not-active</option>'><?= htmlspecialchars($item['status']) ?></td>
                <td class="border-0 px-4 py-4 dark:bg-gray-800">
                  <button class="viewBtn p-2 hover:bg-gray-100 rounded-full" data-id="<?= $item['id'] ?>" title="view"><i class="mdi-24px mdi mdi-eye"></i></button>
                  <button class="editBtn p-2 hover:bg-gray-100 rounded-full" data-id="<?= $item['id'] ?>" title="edit"><i class="mdi-24px mdi mdi-pen"></i></button>
                  <button class="deleteBtn p-2 hover:bg-gray-100 rounded-full" data-id="<?= $item['id'] ?>" title="delete"><i class="mdi-24px mdi mdi-delete"></i></button>
                </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <!-- Charts Tab -->
<div id="tab-charts" class="hidden px-8 pt-4">
  <canvas id="user_profileChart" height="120"></canvas>
</div>

<!-- Grid Tab -->
<div id="tab-grid" class="hidden px-8 pt-4">
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
    <?php foreach($user_profile as $item): ?>
       
      <div
        class="group bg-white dark:bg-gray-800 rounded-lg shadow-md border border-transparent hover:border-blue-500 focus-within:border-blue-500 active:border-blue-700 transition duration-300 overflow-hidden"
        x-data="{ open: false }"
      >
        <img
          src="<?= htmlspecialchars($item['image'] ?? 'https://placehold.co/600x400') ?>"
          alt="user_profile Image"
          class="w-full h-40 object-cover"
        />
        <div class="p-4">
          <h3 class="text-lg font-bold text-blue-600"><?= htmlspecialchars($item['id']) ?></h3>
          <p class="text-gray-600 dark:text-gray-300"><?= htmlspecialchars($item['user_id']??'') ?></p>
          <p class="text-sm text-gray-500 dark:text-gray-400">Status: <?= htmlspecialchars($item['first_name']??'') ?></p>

          <div class="mt-4">
            <button
              @click="open = !open"
              class="text-sm text-blue-500 hover:text-blue-700 focus:outline-none focus:underline"
            >
              <span x-show="!open">More &darr;</span>
              <span x-show="open">Less &uarr;</span>
            </button>

            <div
              x-show="open"
              x-transition
              class="mt-2 text-gray-700 dark:text-gray-300 text-sm"
            >

              <p><?= htmlspecialchars($item['status'] ?? '') ?></p>
            </div>
          </div>
        </div>
      </div>

    <?php endforeach; ?>
  </div>
</div>


<!-- List Tab -->
<div id="tab-list" class="hidden px-8 pt-4">
  <ul class="space-y-4">
    <?php foreach($user_profile as $item): ?>
       
<li class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 hover:border-blue-500 transition">
        <div class="flex items-center space-x-4">
          <!-- Optional user_profile Image -->
          <img
            src="<?= htmlspecialchars($item['image'] ?? 'https://placehold.co/600x400') ?>"
            alt="Image"
            class="w-10 h-10 rounded-full object-cover"
          />

          <!-- user_profile Info -->
          <div>
            <p class="font-semibold text-blue-600 dark:text-blue-400"><?= htmlspecialchars($item['id']) ?></p>
            <p class="font-semibold text-blue-600 dark:text-blue-400"><?= htmlspecialchars($item['user_id']) ?></p>
            <p class="font-semibold text-blue-600 dark:text-blue-400"><?= htmlspecialchars($item['first_name']) ?></p>







          <div class="mt-4">
            <button
              @click="open = !open"
              class="text-sm text-blue-500 hover:text-blue-700 focus:outline-none focus:underline"
            >
              <span x-show="!open">More &darr;</span>
              <span x-show="open">Less &uarr;</span>
            </button>

            <div
              x-show="open"
              x-transition
              class="mt-2 text-gray-700 dark:text-gray-300 text-sm"
            >

              <p><?= htmlspecialchars($item['status'] ?? '') ?></p>
            </div>
          </div>









          </div>
        </div>
      </li>

    <?php endforeach; ?>
  </ul>
</div>




<!-- Print Tab -->
<div id="tab-print" class="hidden px-8 pt-4 print:block">
  <!-- Print Button (visible only on screen, hidden in print) -->
  <div class="mb-4 no-print">
    <button onclick="window.print()" class="bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600 transition">
      Print this table
    </button>
  </div>

  <!-- Printable Table -->
  <div class="overflow-auto">
    <table id="user_profileTable" class="min-w-full bg-white rounded shadow text-sm">
      <thead>
        <tr>
          <th class="bg-gray-100 px-4 py-2 text-left dark:bg-gray-800">#</th>
           
        <th class="border-0 bg-gray-100 px-4 py-4 dark:bg-gray-800 text-left bg-gray-100 dark:bg-gray-800 font-semibold text-gray-700 dark:text-gray-300 px-4 py-3">id</th>
 
        <th class="border-0 bg-gray-100 px-4 py-4 dark:bg-gray-800 text-left bg-gray-100 dark:bg-gray-800 font-semibold text-gray-700 dark:text-gray-300 px-4 py-3">user_id</th>
 
        <th class="border-0 bg-gray-100 px-4 py-4 dark:bg-gray-800 text-left bg-gray-100 dark:bg-gray-800 font-semibold text-gray-700 dark:text-gray-300 px-4 py-3">first_name</th>
 
        <th class="border-0 bg-gray-100 px-4 py-4 dark:bg-gray-800 text-left bg-gray-100 dark:bg-gray-800 font-semibold text-gray-700 dark:text-gray-300 px-4 py-3">last_name</th>
 
        <th class="border-0 bg-gray-100 px-4 py-4 dark:bg-gray-800 text-left bg-gray-100 dark:bg-gray-800 font-semibold text-gray-700 dark:text-gray-300 px-4 py-3">username</th>
 
        <th class="border-0 bg-gray-100 px-4 py-4 dark:bg-gray-800 text-left bg-gray-100 dark:bg-gray-800 font-semibold text-gray-700 dark:text-gray-300 px-4 py-3">email</th>
 
        <th class="border-0 bg-gray-100 px-4 py-4 dark:bg-gray-800 text-left bg-gray-100 dark:bg-gray-800 font-semibold text-gray-700 dark:text-gray-300 px-4 py-3">phone</th>
 
        <th class="border-0 bg-gray-100 px-4 py-4 dark:bg-gray-800 text-left bg-gray-100 dark:bg-gray-800 font-semibold text-gray-700 dark:text-gray-300 px-4 py-3">avatar_url</th>
 
        <th class="border-0 bg-gray-100 px-4 py-4 dark:bg-gray-800 text-left bg-gray-100 dark:bg-gray-800 font-semibold text-gray-700 dark:text-gray-300 px-4 py-3">bio</th>
 
        <th class="border-0 bg-gray-100 px-4 py-4 dark:bg-gray-800 text-left bg-gray-100 dark:bg-gray-800 font-semibold text-gray-700 dark:text-gray-300 px-4 py-3">gender</th>
 
        <th class="border-0 bg-gray-100 px-4 py-4 dark:bg-gray-800 text-left bg-gray-100 dark:bg-gray-800 font-semibold text-gray-700 dark:text-gray-300 px-4 py-3">date_of_birth</th>
 
        <th class="border-0 bg-gray-100 px-4 py-4 dark:bg-gray-800 text-left bg-gray-100 dark:bg-gray-800 font-semibold text-gray-700 dark:text-gray-300 px-4 py-3">country</th>
 
        <th class="border-0 bg-gray-100 px-4 py-4 dark:bg-gray-800 text-left bg-gray-100 dark:bg-gray-800 font-semibold text-gray-700 dark:text-gray-300 px-4 py-3">city</th>
 
        <th class="border-0 bg-gray-100 px-4 py-4 dark:bg-gray-800 text-left bg-gray-100 dark:bg-gray-800 font-semibold text-gray-700 dark:text-gray-300 px-4 py-3">state</th>
 
        <th class="border-0 bg-gray-100 px-4 py-4 dark:bg-gray-800 text-left bg-gray-100 dark:bg-gray-800 font-semibold text-gray-700 dark:text-gray-300 px-4 py-3">zip_code</th>
 
        <th class="border-0 bg-gray-100 px-4 py-4 dark:bg-gray-800 text-left bg-gray-100 dark:bg-gray-800 font-semibold text-gray-700 dark:text-gray-300 px-4 py-3">social_links</th>
 
        <th class="border-0 bg-gray-100 px-4 py-4 dark:bg-gray-800 text-left bg-gray-100 dark:bg-gray-800 font-semibold text-gray-700 dark:text-gray-300 px-4 py-3">created_at</th>
 
        <th class="border-0 bg-gray-100 px-4 py-4 dark:bg-gray-800 text-left bg-gray-100 dark:bg-gray-800 font-semibold text-gray-700 dark:text-gray-300 px-4 py-3">updated_at</th>
 
        <th class="border-0 bg-gray-100 px-4 py-4 dark:bg-gray-800 text-left bg-gray-100 dark:bg-gray-800 font-semibold text-gray-700 dark:text-gray-300 px-4 py-3">status</th>

        </tr>
      </thead>
      <tbody>
        <?php $i = 1; foreach($user_profile as $item): ?>
        <tr class="border-t">
          <td class="px-4 py-2 dark:bg-gray-800"><?= $i++ ?></td>
           
          <td class="px-4 py-2 dark:bg-gray-800"><?= htmlspecialchars($item['id']) ?></td>
 
          <td class="px-4 py-2 dark:bg-gray-800"><?= htmlspecialchars($item['user_id']) ?></td>
 
          <td class="px-4 py-2 dark:bg-gray-800"><?= htmlspecialchars($item['first_name']) ?></td>
 
          <td class="px-4 py-2 dark:bg-gray-800"><?= htmlspecialchars($item['last_name']) ?></td>
 
          <td class="px-4 py-2 dark:bg-gray-800"><?= htmlspecialchars($item['username']) ?></td>
 
          <td class="px-4 py-2 dark:bg-gray-800"><?= htmlspecialchars($item['email']) ?></td>
 
          <td class="px-4 py-2 dark:bg-gray-800"><?= htmlspecialchars($item['phone']) ?></td>
 
          <td class="px-4 py-2 dark:bg-gray-800"><?= htmlspecialchars($item['avatar_url']) ?></td>
 
          <td class="px-4 py-2 dark:bg-gray-800"><?= htmlspecialchars($item['bio']) ?></td>
 
          <td class="px-4 py-2 dark:bg-gray-800"><?= htmlspecialchars($item['gender']) ?></td>
 
          <td class="px-4 py-2 dark:bg-gray-800"><?= htmlspecialchars($item['date_of_birth']) ?></td>
 
          <td class="px-4 py-2 dark:bg-gray-800"><?= htmlspecialchars($item['country']) ?></td>
 
          <td class="px-4 py-2 dark:bg-gray-800"><?= htmlspecialchars($item['city']) ?></td>
 
          <td class="px-4 py-2 dark:bg-gray-800"><?= htmlspecialchars($item['state']) ?></td>
 
          <td class="px-4 py-2 dark:bg-gray-800"><?= htmlspecialchars($item['zip_code']) ?></td>
 
          <td class="px-4 py-2 dark:bg-gray-800"><?= htmlspecialchars($item['social_links']) ?></td>
 
          <td class="px-4 py-2 dark:bg-gray-800"><?= htmlspecialchars($item['created_at']) ?></td>
 
          <td class="px-4 py-2 dark:bg-gray-800"><?= htmlspecialchars($item['updated_at']) ?></td>
 
          <td class="px-4 py-2 dark:bg-gray-800"><?= htmlspecialchars($item['status']) ?></td>

        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>


<!-- Import Tab -->
<div id="tab-import" class="hidden px-8 pt-4">
  <form id="importForm" enctype="multipart/form-data">
    <label for="importFile" class="block mb-2 text-sm font-medium">Upload CSV or SQL</label>
    <input type="hidden" name="action" value="import">
    <input
      type="file"
      id="importFile"
      name="file"
      accept=".csv, .sql"
      class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
      required
    />
    <button
      type="submit"
      class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition"
    >
      Upload
    </button>
  </form>

  <!-- Feedback messages -->
  <div id="importMessage" class="mt-4 text-sm"></div>
</div>


<!-- Export Tab -->
<div id="tab-export" class="hidden px-8 pt-4 h-1/3">
  <a href="<?= $path?>app/crud/api/user_profile.php?action=export" class="bg-green-500 text-white px-4 py-2 rounded">Export All user_profile</a>
</div>

<!-- Share Tab -->
<div id="tab-share" class="hidden px-8 pt-4 space-y-6">
  <!-- Copy Link -->
  <div>
    <p class="mb-2 text-sm font-semibold">Copy link to share:</p>
    <div class="flex items-center space-x-2">
      <input
        id="shareLink"
        type="text"
        class="w-full border px-3 py-2 rounded text-sm"
        value="<?= $_SERVER['REQUEST_URI']?>&share=true"
        readonly
        onclick="this.select()"
      />
      <button
        onclick="copyLink()"
        class="bg-blue-500 text-white px-3 py-2 text-sm rounded hover:bg-blue-600 transition"
      >
        Copy
      </button>
    </div>
    <p id="copyStatus" class="text-green-500 text-sm mt-1 hidden">Link copied!</p>
  </div>

  <!-- Share Buttons - Redesigned -->
<div>
  <p class="mb-2 text-sm font-semibold">Share via:</p>
  <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
    
    <!-- Email -->
    <a href="mailto:?subject=Check this out&body=<?= $_SERVER['REQUEST_URI']?>&share=true" target="_blank"
      class="flex flex-col items-center justify-center border rounded-lg p-4 hover:shadow transition">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-700 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H8m0 0l4-4m-4 4l4 4" />
      </svg>
      <span class="text-sm font-medium text-gray-700">Email</span>
    </a>

    <!-- WhatsApp -->
    <a href="https://wa.me/?text=<?= $_SERVER['REQUEST_URI']?>&share=true" target="_blank"
      class="flex flex-col items-center justify-center border rounded-lg p-4 hover:shadow transition">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-700 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h2l1 2 2-2h2l1 2 2-2h2l1 2 2-2h2" />
      </svg>
      <span class="text-sm font-medium text-gray-700">WhatsApp</span>
    </a>

    <!-- Facebook -->
    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $_SERVER['REQUEST_URI']?>&share=true" target="_blank"
      class="flex flex-col items-center justify-center border rounded-lg p-4 hover:shadow transition">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-700 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z" />
      </svg>
      <span class="text-sm font-medium text-gray-700">Facebook</span>
    </a>

    <!-- Twitter (X) -->
    <a href="https://x.com/intent/tweet?url=<?= $_SERVER['REQUEST_URI']?>&share=true" target="_blank"
      class="flex flex-col items-center justify-center border rounded-lg p-4 hover:shadow transition">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-700 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path d="M17.5 6.5L6.5 17.5M6.5 6.5L17.5 17.5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
      <span class="text-sm font-medium text-gray-700">X (Twitter)</span>
    </a>

    <!-- LinkedIn -->
    <a href="https://www.linkedin.com/shareArticle?url=<?= $_SERVER['REQUEST_URI']?>&share=true" target="_blank"
      class="flex flex-col items-center justify-center border rounded-lg p-4 hover:shadow transition">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-700 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path d="M16 8a6 6 0 016 6v5h-4v-5a2 2 0 00-4 0v5h-4v-9h4v1.2a4 4 0 013-1.2zM2 9h4v12H2zM4 3a2 2 0 110 4 2 2 0 010-4z" />
      </svg>
      <span class="text-sm font-medium text-gray-700">LinkedIn</span>
    </a>

    <!-- Instagram (just link to IG) -->
    <a href="https://www.instagram.com/" target="_blank"
      class="flex flex-col items-center justify-center border rounded-lg p-4 hover:shadow transition">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-700 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <rect x="2" y="2" width="20" height="20" rx="5" ry="5" />
        <circle cx="12" cy="12" r="3.5" />
        <circle cx="17.5" cy="6.5" r="1" />
      </svg>
      <span class="text-sm font-medium text-gray-700">Instagram</span>
    </a>

  </div>
</div>


  <!-- QR Code -->
  <div class="text-center mt-6">
    <p class="mb-2 text-sm font-semibold">Scan or download QR code:</p>
    <a
      href="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=<?= $_SERVER['REQUEST_URI']?>&share=true"
      download="ShareQR.png"
      class="inline-block"
    >
      <img
        src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=<?= $_SERVER['REQUEST_URI']?>&share=true"
        alt="QR Code"
        class="w-40 h-40 mx-auto rounded border shadow"
      />
      <p class="text-blue-500 mt-2 hover:underline">Download Me</p>
    </a>
  </div>
</div>

</div>


<script>

$('.tabBtn').on('click', function() {
  var tab = $(this).data('tab');
  
  // Hide all tab contents
  $('[id^="tab-"]').hide();

  // Show selected
  $('#tab-' + tab).fadeIn(150);

  // Optional: Highlight active tab
  $('.tabBtn').removeClass('bg-blue-500 text-white').addClass('bg-gray-200 dark:bg-gray-700');
  $(this).addClass('bg-blue-500 text-white').removeClass('bg-gray-200 dark:bg-gray-700');
});

$('.tabBtn[data-tab="tables"]').trigger('click');










$(document).ready(function(){
const ctx = document.getElementById('user_profileChart');
if (ctx) {
  const chart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: [
        "Today",
        "This Week",
        "This Month",
        "This Year",
        ...<?= json_encode(array_keys($counts['years'])) ?>
      ],
      datasets: [{
        label: 'user_profile Created',
        data: [
          <?= $counts['today'] ?>,
          <?= $counts['week'] ?>,
          <?= $counts['month'] ?>,
          <?= $counts['year'] ?>,
          ...<?= json_encode(array_values($counts['years'])) ?>
        ],
        backgroundColor: [
          'rgba(59, 130, 246, 0.7)',
          'rgba(96, 165, 250, 0.7)',
          'rgba(147, 197, 253, 0.7)',
          'rgba(191, 219, 254, 0.7)',
          ...Array(<?= count($counts['years']) ?>).fill('rgba(59, 130, 246, 0.5)')
        ],
        borderColor: 'rgba(59, 130, 246, 1)',
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { display: false }
      },
      scales: {
        y: {
          beginAtZero: true,
          title: { display: true, text: 'user_profile Count' }
        }
      }
    }
  });
}



  // --- Toast ---
  function showToast(message,type='success'){
    const toast = $('<div class="fixed top-5 right-5 p-4 rounded shadow text-white z-50"></div>');
    toast.text(message).addClass(type==='success'?'bg-green-500':'bg-red-500');
    $('body').append(toast);
    setTimeout(()=> toast.fadeOut(500, ()=> toast.remove()),3000);
  }




$(document).on('click', 'td.editable', function () {
  let td = $(this);
  if (td.find('input, select').length) return; // Already editing

  let originalValue = td.text().trim();
  let field = td.data('field');
  let id = td.data('id');
  let values = td.data('values');
  let ref = td.data('ref');
  let input;

  if (field === 'enum') {
    input = $(`
      <select class="w-full p-1 border rounded">
        ${values}
      </select>
    `);
    input.val(originalValue.toLowerCase());
  }else if (field === 'set') {
    input = $(`
      <select class="w-full p-1 border rounded multiple">
        ${values}
      </select>
    `);
    input.val(originalValue.toLowerCase());
  }else if (field === 'fk') {
    input = $(`
      <select data-ref="ref" class="w-full p-1 border rounded">
        ${values}
      </select>
    `);
    input.val(originalValue.toLowerCase());
  } else if (field === 'datetime' || field ==='timestamp') {
    input = $(`<input type="datetime-local" class="w-full p-1 border rounded" />`);
    let date = new Date(originalValue);
    let iso = date.toISOString().slice(0, 16); // "YYYY-MM-DDTHH:MM"
    input.val(iso);
  } else if (field === 'time') {
    input = $(`<input type="time" class="w-full p-1 border rounded" />`);
    let date = new Date(originalValue);
    let iso = date.toISOString().slice(10, 16); // "HH:MM"
    input.val(iso);
  } else if (field === 'date') {
    input = $(`<input type="date" class="w-full p-1 border rounded" />`);
    let date = new Date(originalValue);
    let iso = date.toISOString().slice(0, 10); // "YYYY-MM-DD"
    input.val(iso);
  } else if (field === 'email') {
    input = $(`<input type="email" maxlength="${values}" class="w-full p-1 border rounded" value="${originalValue}" />`);
  } else if (field === 'year') {
    input = $(`<input type="number" maxlength="4" minlength="4" min="1901" max="2155" class="w-full p-1 border rounded" value="${originalValue}" />`);
  } else if (field === 'int' || field === 'bigint'  || field === 'mediumint'  || field === 'tinyint' ) {
    input = $(`<input type="number" maxlength="${values}" class="w-full p-1 border rounded" value="${originalValue}" />`);
  } else if (field === 'some_number_field') {
    input = $(`<input type="number" maxlength="${values}" class="w-full p-1 border rounded" value="${originalValue}" />`);
  } else if (field === 'decimal' || field === 'float' || field === 'double') {
    input = $(`<input type="number" maxlength="${values}" step='0.0000' class="w-full p-1 border rounded" value="${originalValue}" />`);
  } else {
    input = $(`<input type="text" maxlength="${values}" class="w-full p-1 border rounded" value="${originalValue}" />`);
  }

  td.html(input);
  input.focus();

  // Save on blur or Enter
  input.on('blur keydown', function (e) {
    if (e.type === 'blur' || (e.type === 'keydown' && e.key === 'Enter')) {
      let newValue = input.val();

      // If datetime, convert to string for DB
      if (field === 'timestamp' || field === 'datetime' || field === 'created_at') {
        newValue = new Date(newValue).toISOString().slice(0, 19).replace('T', ' ');
      }

      $.post('<?= $path?>app/crud/api/user_profile.php', {
        action: 'inline_update',
        id: id,
        field: field,
        value: newValue
      }, function (res) {
        if (res.success) {
          showToast('Updated');
          td.text(newValue);
        } else {
          showToast(res.message, 'error');
          td.text(originalValue); // revert
        }
      }, 'json').fail((xhr) => {
        alert(JSON.stringify(xhr));
        showToast('Server error', 'error');
        td.text(originalValue); // revert
      });
    }
  });
});










  // --- Modal open/close ---
  function openModal(title,content){
    $('#modalTitle').text(title);
    $('#modalContent').html(content);
    $('#user_profileModal').hide().removeClass('hidden').fadeIn(200);
  }

  $(document).on('click','.modal-close', function(){
    $('#user_profileModal').fadeOut(200,function(){ $(this).addClass('hidden'); });
  });

  // --- Add user_profile ---
  $('#adduser_profileBtn').click(function(e){
    e.preventDefault();
      
    $.post('<?= $path?>app/crud/forms/create/user_profile.php', function(res){
      if(res){
        openModal('Add user_profile',res);
      } else showToast(res.message,'error');
    }).fail(()=>showToast('Server error:Register Data failed ','error'));

  });

  // --- Submit Add ---
  $(document).on('submit','#adduser_profileForm', function(e){
    e.preventDefault();
    $.post('<?= $path?>app/crud/api/user_profile.php', $(this).serialize()+'&action=insert', function(res){
      if(res.success){
        showToast(res.message);
        $('#user_profileModal').fadeOut(200,function(){ $(this).addClass('hidden'); });
        // $("#user_profileTable").load(location.href + " #user_profileTable");
        window.location.reload();
      } else { showToast(res.message,'error'); }
    },'json').fail(()=>showToast('Server error','error'));
  });

  // --- Save & Continue ---
  $(document).on('click','#saveContinueBtn', function(){
    $.post('<?= $path?>app/crud/api/user_profile.php', $('#adduser_profileForm').serialize()+'&action=insert', function(res){
      if(res.success){
        showToast(res.message);
        // $("#user_profileTable").load(location.href + " #user_profileTable");
        window.location.reload();
        $('#adduser_profileForm')[0].reset();
      } else {showToast(res.message,'error');}
    },'json').fail(()=>showToast('Server error','error'));
  });

// --- View user_profile ---
$(document).on('click','.viewBtn', function(){
    let id=$(this).data('id');
    $.post('<?= $path?>app/crud/api/user_profile.php',{action:'view',id}, function(res){
      if(res.success){
        let html = `
          <div class="bg-blue-500 text-white p-4 rounded mb-4 text-lg font-semibold">
            user_profile
          </div>
          <div class="grid grid-cols-2 gap-6 bg-white dark:bg-gray-800 p-6 rounded shadow">
            <p class="text-gray-700 dark:text-gray-200"><strong>id:</strong> ${res.data.id}</p><p class="text-gray-700 dark:text-gray-200"><strong>user_id:</strong> ${res.data.user_id}</p><p class="text-gray-700 dark:text-gray-200"><strong>first_name:</strong> ${res.data.first_name}</p><p class="text-gray-700 dark:text-gray-200"><strong>last_name:</strong> ${res.data.last_name}</p><p class="text-gray-700 dark:text-gray-200"><strong>username:</strong> ${res.data.username}</p><p class="text-gray-700 dark:text-gray-200"><strong>email:</strong> ${res.data.email}</p><p class="text-gray-700 dark:text-gray-200"><strong>phone:</strong> ${res.data.phone}</p><p class="text-gray-700 dark:text-gray-200"><strong>avatar_url:</strong> ${res.data.avatar_url}</p><p class="text-gray-700 dark:text-gray-200"><strong>bio:</strong> ${res.data.bio}</p><p class="text-gray-700 dark:text-gray-200"><strong>gender:</strong> ${res.data.gender}</p><p class="text-gray-700 dark:text-gray-200"><strong>date_of_birth:</strong> ${res.data.date_of_birth}</p><p class="text-gray-700 dark:text-gray-200"><strong>country:</strong> ${res.data.country}</p><p class="text-gray-700 dark:text-gray-200"><strong>city:</strong> ${res.data.city}</p><p class="text-gray-700 dark:text-gray-200"><strong>state:</strong> ${res.data.state}</p><p class="text-gray-700 dark:text-gray-200"><strong>zip_code:</strong> ${res.data.zip_code}</p><p class="text-gray-700 dark:text-gray-200"><strong>social_links:</strong> ${res.data.social_links}</p><p class="text-gray-700 dark:text-gray-200"><strong>created_at:</strong> ${res.data.created_at}</p><p class="text-gray-700 dark:text-gray-200"><strong>updated_at:</strong> ${res.data.updated_at}</p><p class="text-gray-700 dark:text-gray-200"><strong>status:</strong> ${res.data.status}</p>
          <div class="flex justify-end mt-4">
            <button type="button" class="modal-close bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">Close</button>
          </div>
        `;
        openModal('View user_profile', html);
      } else showToast(res.message,'error');
    },'json').fail(()=>showToast('Server error','error'));
});


  // --- Edit user_profile ---
  $(document).on('click','.editBtn', function(){
    let id=$(this).data('id');
    $.get('<?= $path?>app/crud/forms/update/user_profile.php', {id}, function(res){
        openModal('Edit user_profile',res);
    }).fail(()=>showToast('Server error','error'));
  });


  // --- Submit Edit ---
  $(document).on('submit','#edituser_profileForm', function(e){
    e.preventDefault();
    $.post('<?= $path?>app/crud/api/user_profile.php', $(this).serialize()+'&action=edit', function(res){
      if(res.success){
        showToast(res.message);
        $('#user_profileModal').fadeOut(200,function(){ $(this).addClass('hidden'); });
        // $("#user_profileTable").load(location.href + " #user_profileTable");
        window.location.reload();
      } else showToast(res.message,'error');
    },'json').fail(()=>showToast('Server error','error'));
  });

  // --- Delete user_profile ---
  $(document).on('click','.deleteBtn', function(){
    let id=$(this).data('id');
    let html=`
      <p>Are you sure you want to delete this user_profile?</p>
      <div class="flex justify-end gap-3 mt-4">
        <button id="confirmDeleteBtn" data-id="${id}" class="bg-red-500 text-white px-6 py-2 rounded">Delete</button>
        <button type="button" class="modal-close bg-gray-500 text-white px-6 py-2 rounded">Cancel</button>
      </div>`;
    openModal('Confirm Delete',html);
  });

  $(document).on('click','#confirmDeleteBtn', function(){
    let id=$(this).data('id');
    $.post('<?= $path?>app/crud/api/user_profile.php',{action:'delete',id}, function(res){
      if(res.success){
        showToast(res.message);
        $('#user_profileModal').fadeOut(200,function(){ $(this).addClass('hidden'); });
        // $("#user_profileTable").load(location.href + " #user_profileTable");
        window.location.reload();
      } else showToast(res.message,'error');
    },'json').fail(()=>showToast('Server error','error'));
  });











  // --- Bulk Actions ---
$('#applyBulkAction').on('click', function(){
    var action = $('#bulkActions').val();
    var ids = $('.rowCheckbox:checked').map(function(){ return $(this).data('id'); }).get();
    if(!action) return alert('Select a bulk action.');
    if(ids.length === 0) return alert('Select at least one row.');







    if(action === 'copy'){
        // Bulk Copy: fetch each user_profile data
        $.post('<?= $path?>app/crud/api/user_profile.php',{action:'bulk_view', ids: ids}, function(res){
            if(res.success){
                let html = '<form id="bulkCopyForm">';
                res.data.forEach(user_profile => {
                    html += `
                        <div class="bg-white dark:bg-gray-800 p-4 rounded shadow mb-4">
                            <h3 class="font-bold text-lg mb-2 text-green-500">Copy user_profile</h3>
                            <input type="hidden" name="ids[]" value="${user_profile.id}">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                        <label for="id">id</label>
                        <input type="id" id="id" name="id[${user_profile.id}]" value="${user_profile.id}" class="w-full p-2 border rounded mb-2">
                    </div><div>
                        <label for="user_id">user_id</label>
                        <input type="user_id" id="user_id" name="user_id[${user_profile.id}]" value="${user_profile.user_id}" class="w-full p-2 border rounded mb-2">
                    </div><div>
                        <label for="first_name">first_name</label>
                        <input type="first_name" id="first_name" name="first_name[${user_profile.id}]" value="${user_profile.first_name}" class="w-full p-2 border rounded mb-2">
                    </div><div>
                        <label for="last_name">last_name</label>
                        <input type="last_name" id="last_name" name="last_name[${user_profile.id}]" value="${user_profile.last_name}" class="w-full p-2 border rounded mb-2">
                    </div><div>
                        <label for="username">username</label>
                        <input type="username" id="username" name="username[${user_profile.id}]" value="${user_profile.username}" class="w-full p-2 border rounded mb-2">
                    </div><div>
                        <label for="email">email</label>
                        <input type="email" id="email" name="email[${user_profile.id}]" value="${user_profile.email}" class="w-full p-2 border rounded mb-2">
                    </div><div>
                        <label for="phone">phone</label>
                        <input type="phone" id="phone" name="phone[${user_profile.id}]" value="${user_profile.phone}" class="w-full p-2 border rounded mb-2">
                    </div><div>
                        <label for="avatar_url">avatar_url</label>
                        <input type="avatar_url" id="avatar_url" name="avatar_url[${user_profile.id}]" value="${user_profile.avatar_url}" class="w-full p-2 border rounded mb-2">
                    </div><div>
                        <label for="bio">bio</label>
                        <input type="bio" id="bio" name="bio[${user_profile.id}]" value="${user_profile.bio}" class="w-full p-2 border rounded mb-2">
                    </div><div>
                        <label for="gender">gender</label>
                        <input type="gender" id="gender" name="gender[${user_profile.id}]" value="${user_profile.gender}" class="w-full p-2 border rounded mb-2">
                    </div><div>
                        <label for="date_of_birth">date_of_birth</label>
                        <input type="date_of_birth" id="date_of_birth" name="date_of_birth[${user_profile.id}]" value="${user_profile.date_of_birth}" class="w-full p-2 border rounded mb-2">
                    </div><div>
                        <label for="country">country</label>
                        <input type="country" id="country" name="country[${user_profile.id}]" value="${user_profile.country}" class="w-full p-2 border rounded mb-2">
                    </div><div>
                        <label for="city">city</label>
                        <input type="city" id="city" name="city[${user_profile.id}]" value="${user_profile.city}" class="w-full p-2 border rounded mb-2">
                    </div><div>
                        <label for="state">state</label>
                        <input type="state" id="state" name="state[${user_profile.id}]" value="${user_profile.state}" class="w-full p-2 border rounded mb-2">
                    </div><div>
                        <label for="zip_code">zip_code</label>
                        <input type="zip_code" id="zip_code" name="zip_code[${user_profile.id}]" value="${user_profile.zip_code}" class="w-full p-2 border rounded mb-2">
                    </div><div>
                        <label for="social_links">social_links</label>
                        <input type="social_links" id="social_links" name="social_links[${user_profile.id}]" value="${user_profile.social_links}" class="w-full p-2 border rounded mb-2">
                    </div><div>
                        <label for="created_at">created_at</label>
                        <input type="created_at" id="created_at" name="created_at[${user_profile.id}]" value="${user_profile.created_at}" class="w-full p-2 border rounded mb-2">
                    </div><div>
                        <label for="updated_at">updated_at</label>
                        <input type="updated_at" id="updated_at" name="updated_at[${user_profile.id}]" value="${user_profile.updated_at}" class="w-full p-2 border rounded mb-2">
                    </div><div>
                        <label for="status">status</label>
                        <input type="status" id="status" name="status[${user_profile.id}]" value="${user_profile.status}" class="w-full p-2 border rounded mb-2">
                    </div>
                            </div>
                        </div>
                    `;
                });

                html += `<div class="flex justify-end gap-3 mt-4">
                            <button id="bulkCopySaveBtn" class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600">Save as New</button>
                            <button type="button" class="modal-close bg-gray-500 text-white px-6 py-2 rounded">Cancel</button>
                         </div></form>`;

                openModal('Bulk Copy user_profile', html);
            } else showToast(res.message,'error');
        },'json').fail(()=>showToast('Server error','error'));
    }



    else if(action === 'delete'){
        let html = `<p>Are you sure you want to delete selected user_profile?</p>
                    <div class="flex justify-end gap-3 mt-4">
                      <button id="bulkDeleteBtn" class="bg-red-500 text-white px-6 py-2 rounded">Delete</button>
                      <button type="button" class="modal-close bg-gray-500 text-white px-6 py-2 rounded">Cancel</button>
                    </div>`;
        openModal('Confirm Bulk Delete', html);
    }


      else if(action === 'view'){
          $.post('<?= $path?>app/crud/api/user_profile.php',{action:'bulk_view', ids: ids}, function(res){
              if(res.success){
                  let html = '';
                  res.data.forEach(user_profile => {
                      html += `<div class="bg-white dark:bg-gray-800 p-4 rounded shadow mb-4">
                                  <p>id: ${user_profile.id}</p><p>user_id: ${user_profile.user_id}</p><p>first_name: ${user_profile.first_name}</p><p>last_name: ${user_profile.last_name}</p><p>username: ${user_profile.username}</p><p>email: ${user_profile.email}</p><p>phone: ${user_profile.phone}</p><p>avatar_url: ${user_profile.avatar_url}</p><p>bio: ${user_profile.bio}</p><p>gender: ${user_profile.gender}</p><p>date_of_birth: ${user_profile.date_of_birth}</p><p>country: ${user_profile.country}</p><p>city: ${user_profile.city}</p><p>state: ${user_profile.state}</p><p>zip_code: ${user_profile.zip_code}</p><p>social_links: ${user_profile.social_links}</p><p>created_at: ${user_profile.created_at}</p><p>updated_at: ${user_profile.updated_at}</p><p>status: ${user_profile.status}</p>
                                </div>`;
                  });
                  html += `<div class="flex justify-end mt-4">
                              <button type="button" class="modal-close bg-gray-500 text-white px-6 py-2 rounded">Close</button>
                          </div>`;
                  openModal('View user_profile', html);
              }
          },'json');
      }

      else if(action === 'export'){
          let idsParam = ids.join(',');
          window.location.href = `<?= $path?>app/crud/api/user_profile.php?action=bulk_export&ids=${idsParam}`;
      }


    else if(action === 'edit'){
        // Bulk Edit: fetch each user_profile's data
        $.post('<?= $path?>app/crud/api/user_profile.php',{action:'bulk_view', ids: ids}, function(res){
            if(res.success){
                // Create forms for each user_profile
                let html = '';
                res.data.forEach(user_profile => {
                    html += `
                        <div class="bg-white dark:bg-gray-800 p-4 rounded shadow mb-4">
                            <h3 class="font-bold text-lg mb-2 text-blue-500">Edit user_profile</h3>
                            <input type="hidden" name="ids[]" value="${user_profile.id}">
                            <div class="grid grid-cols-2 gap-4">
                             <div>
                        <label for="id" class="block text-gray-700 dark:text-gray-200">id</label>
                        <input type="id" id="id" name="id[${user_profile.id}]" value="${user_profile.id}" class="w-full p-2 border rounded mb-2" required>
                      </div>
        <div>
                        <label for="user_id" class="block text-gray-700 dark:text-gray-200">user_id</label>
                        <input type="user_id" id="user_id" name="user_id[${user_profile.id}]" value="${user_profile.user_id}" class="w-full p-2 border rounded mb-2" required>
                      </div>
        <div>
                        <label for="first_name" class="block text-gray-700 dark:text-gray-200">first_name</label>
                        <input type="first_name" id="first_name" name="first_name[${user_profile.id}]" value="${user_profile.first_name}" class="w-full p-2 border rounded mb-2" required>
                      </div>
        <div>
                        <label for="last_name" class="block text-gray-700 dark:text-gray-200">last_name</label>
                        <input type="last_name" id="last_name" name="last_name[${user_profile.id}]" value="${user_profile.last_name}" class="w-full p-2 border rounded mb-2" required>
                      </div>
        <div>
                        <label for="username" class="block text-gray-700 dark:text-gray-200">username</label>
                        <input type="username" id="username" name="username[${user_profile.id}]" value="${user_profile.username}" class="w-full p-2 border rounded mb-2" required>
                      </div>
        <div>
                        <label for="email" class="block text-gray-700 dark:text-gray-200">email</label>
                        <input type="email" id="email" name="email[${user_profile.id}]" value="${user_profile.email}" class="w-full p-2 border rounded mb-2" required>
                      </div>
        <div>
                        <label for="phone" class="block text-gray-700 dark:text-gray-200">phone</label>
                        <input type="phone" id="phone" name="phone[${user_profile.id}]" value="${user_profile.phone}" class="w-full p-2 border rounded mb-2" required>
                      </div>
        <div>
                        <label for="avatar_url" class="block text-gray-700 dark:text-gray-200">avatar_url</label>
                        <input type="avatar_url" id="avatar_url" name="avatar_url[${user_profile.id}]" value="${user_profile.avatar_url}" class="w-full p-2 border rounded mb-2" required>
                      </div>
        <div>
                        <label for="bio" class="block text-gray-700 dark:text-gray-200">bio</label>
                        <input type="bio" id="bio" name="bio[${user_profile.id}]" value="${user_profile.bio}" class="w-full p-2 border rounded mb-2" required>
                      </div>
        <div>
                        <label for="gender" class="block text-gray-700 dark:text-gray-200">gender</label>
                        <input type="gender" id="gender" name="gender[${user_profile.id}]" value="${user_profile.gender}" class="w-full p-2 border rounded mb-2" required>
                      </div>
        <div>
                        <label for="date_of_birth" class="block text-gray-700 dark:text-gray-200">date_of_birth</label>
                        <input type="date_of_birth" id="date_of_birth" name="date_of_birth[${user_profile.id}]" value="${user_profile.date_of_birth}" class="w-full p-2 border rounded mb-2" required>
                      </div>
        <div>
                        <label for="country" class="block text-gray-700 dark:text-gray-200">country</label>
                        <input type="country" id="country" name="country[${user_profile.id}]" value="${user_profile.country}" class="w-full p-2 border rounded mb-2" required>
                      </div>
        <div>
                        <label for="city" class="block text-gray-700 dark:text-gray-200">city</label>
                        <input type="city" id="city" name="city[${user_profile.id}]" value="${user_profile.city}" class="w-full p-2 border rounded mb-2" required>
                      </div>
        <div>
                        <label for="state" class="block text-gray-700 dark:text-gray-200">state</label>
                        <input type="state" id="state" name="state[${user_profile.id}]" value="${user_profile.state}" class="w-full p-2 border rounded mb-2" required>
                      </div>
        <div>
                        <label for="zip_code" class="block text-gray-700 dark:text-gray-200">zip_code</label>
                        <input type="zip_code" id="zip_code" name="zip_code[${user_profile.id}]" value="${user_profile.zip_code}" class="w-full p-2 border rounded mb-2" required>
                      </div>
        <div>
                        <label for="social_links" class="block text-gray-700 dark:text-gray-200">social_links</label>
                        <input type="social_links" id="social_links" name="social_links[${user_profile.id}]" value="${user_profile.social_links}" class="w-full p-2 border rounded mb-2" required>
                      </div>
        <div>
                        <label for="created_at" class="block text-gray-700 dark:text-gray-200">created_at</label>
                        <input type="created_at" id="created_at" name="created_at[${user_profile.id}]" value="${user_profile.created_at}" class="w-full p-2 border rounded mb-2" required>
                      </div>
        <div>
                        <label for="updated_at" class="block text-gray-700 dark:text-gray-200">updated_at</label>
                        <input type="updated_at" id="updated_at" name="updated_at[${user_profile.id}]" value="${user_profile.updated_at}" class="w-full p-2 border rounded mb-2" required>
                      </div>
        <div>
                        <label for="status" class="block text-gray-700 dark:text-gray-200">status</label>
                        <input type="status" id="status" name="status[${user_profile.id}]" value="${user_profile.status}" class="w-full p-2 border rounded mb-2" required>
                      </div>
        
                            </div>
                        </div>
                    `;
                });

                html += `<div class="flex justify-end gap-3 mt-4">
                            <button id="bulkSaveBtn" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">Save</button>
                            <button type="button" class="modal-close bg-gray-500 text-white px-6 py-2 rounded">Cancel</button>
                         </div>`;

                openModal('Bulk Edit user_profile', html);
            } else showToast(res.message,'error');
        },'json').fail(()=>showToast('Server error','error'));
    } else {
        alert('Bulk action not implemented yet.');
    }
});



$(document).on('click','#bulkDeleteBtn', function(){
    let ids = $('.rowCheckbox:checked').map(function(){ return $(this).data('id'); }).get();
    $.post('<?= $path?>app/crud/api/user_profile.php',{action:'bulk_delete',ids:ids}, function(res){
        if(res.success){
            showToast(res.message);
            $('#user_profileModal').fadeOut(200,function(){ $(this).addClass('hidden'); });
            // $("#user_profileTable").load(location.href + " #user_profileTable");
            window.location.reload();
        } else showToast(res.message,'error');
    },'json');
});


$(document).on('click','#bulkCopySaveBtn', function(e){
    e.preventDefault();
    let formData = { action: 'bulk_copy', ids: [] };
    $('#modalContent').find('input[name="ids[]"]').each(function(){
        formData.ids.push($(this).val());
    });

// Collect all user_profile fields
const excluded = ['id', 'user_id', 'first_name', 'last_name', 'username', 'email', 'phone', 'avatar_url', 'bio', 'gender', 'date_of_birth', 'country', 'city', 'state', 'zip_code', 'social_links', 'created_at', 'updated_at', 'status'];

$('#modalContent').find('input, select').each(function() {
    if (!excluded.some(key => this.name.includes(key))) {
        formData[this.name] = $(this).val();
    }
});

    $.post('<?= $path?>app/crud/api/user_profile.php', formData, function(res){
        if(res.success){
            showToast(res.message);
            $('#user_profileModal').fadeOut(200,function(){ $(this).addClass('hidden'); });
            // $("#user_profileTable").load(location.href + " #user_profileTable");
            window.location.reload();
        } else {showToast(res.message,'error');}
    },'json').fail((xhr)=>showToast(JSON.stringify(xhr)+'Server error','error'));
});






// --- Save Bulk Edit ---
$(document).on('click','#bulkSaveBtn', function(){
      let formData = { action: 'bulk_edit', ids: [] };

      $('#modalContent').find('input[name="ids[]"]').each(function(){
          formData.ids.push($(this).val());
      });

    // Collect all user_profile fields
    const excluded = ['id','user_id','first_name','last_name','username','email','phone','avatar_url','bio','gender','date_of_birth','country','city','state','zip_code','social_links','created_at','updated_at','status'];

    $('#modalContent').find('input, select').each(function() {
        if (!excluded.some(key => this.name.includes(key))) {
            formData[this.name] = $(this).val();
        }
    });


    formData['action'] = 'bulk_edit';

    $.post('<?= $path?>app/crud/api/user_profile.php', formData, function(res){
        if(res.success){
            showToast(res.message);
            $('#user_profileModal').fadeOut(200,function(){ $(this).addClass('hidden'); });
            // $("#user_profileTable").load(location.href + " #user_profileTable");
            window.location.reload();
        } else showToast(res.message,'error');
    },'json').fail((xhr)=>showToast(JSON.stringify(xhr)+':Server error','error'));
});


// If all individual checkboxes are checked, check header; otherwise, uncheck
$(document).on('change', '.rowCheckbox', function() {
    var allChecked = $('.rowCheckbox').length === $('.rowCheckbox:checked').length;
    $('#selectAll').prop('checked', allChecked);
});



// Select/Deselect all checkboxes
$('#selectAll').on('change', function() {
    var checked = $(this).is(':checked');
    $('.rowCheckbox').prop('checked', checked);
});


});
</script>


<script>
$('#importForm').on('submit', function(e) {
  e.preventDefault();

  const fileInput = $('#importFile')[0];
  const file = fileInput.files[0];

  // Check if a file is selected
  if (!file) {
    $('#importMessage').html('<p class="text-red-500">Please select a file.</p>');
    return;
  }

  // Validate file type
  const allowedExtensions = ['csv', 'sql'];
  const fileExtension = file.name.split('.').pop().toLowerCase();

  if (!allowedExtensions.includes(fileExtension)) {
    $('#importMessage').html('<p class="text-red-500">Only CSV or SQL files are allowed.</p>');
    return;
  }

  const formData = new FormData(this);

  $.ajax({
    url: '<?= $path?>app/crud/api/user_profile.php',
    type: 'POST',
    data: formData,
    contentType: false,
    processData: false,
    beforeSend: function() {
      $('#importMessage').html('<p class="text-blue-500">Uploading...</p>');
    },
    success: function(response) {
      // alert(response);
      if (response.success) {
       $('#importMessage').html('<p class="text-green-600">' + response.message + '</p>');
      }else{
       $('#importMessage').html('<p class="text-red-600">' + response.message + '</p>');
      }
    },
    error: function(xhr) {
      $('#importMessage').html('<p class="text-red-500">Error: ' + xhr.responseText + '</p>');
    }
  });
});
</script>
<script>
  function copyLink() {
    const input = document.getElementById('shareLink');
    input.select();
    input.setSelectionRange(0, 99999);
    document.execCommand('copy');

    const status = document.getElementById('copyStatus');
    status.classList.remove('hidden');
    setTimeout(() => status.classList.add('hidden'), 2000);
  }
</script>


<script>
$(document).ready(function(){

  // Initialize DataTable
  let table = new DataTable('#user_profileTable', {
    pageLength: 5,
    lengthMenu: [5, 10, 20, 50, { label: "All", value: -1 }],
    searching: true,
    ordering: true,
    paging: true,
    responsive: true,
    autoWidth: false,
    columnDefs: [
      { orderable: false, targets: [0, 6] } // disable sort on checkbox + actions
    ],
    language: {
      lengthMenu: "Show _MENU_ entries",
      search: "Search:",
      paginate: {
        next: "›",
        previous: "‹"
      }
    }
  });

  // Handle dark mode styling
  function applyDarkMode(){
    if($('html').hasClass('dark')){
      $('#user_profileTable').addClass('stripe hover text-gray-200 bg-gray-900');
    } else {
      $('#user_profileTable').removeClass('text-gray-200 bg-gray-900');
    }
  }

  applyDarkMode();

  // If your site toggles dark mode dynamically, re-apply styles
  const observer = new MutationObserver(applyDarkMode);
  observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });

});


$(document).on('keydown', function(event) {
    if (event.key === "Escape" || event.keyCode === 27) {
        $('.modal.show').modal('hide');
    }
});

</script>




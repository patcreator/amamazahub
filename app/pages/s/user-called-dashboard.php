<?php
  $stmt = $pdo->query("SELECT id, username, email, password, created_at, updated_at, status FROM users");
  $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

foreach ($users as $user) {
  $createdAt = new DateTime($user['created_at']);
  $userYear = $createdAt->format('Y');

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
  if (!isset($counts['years'][$userYear])) {
    $counts['years'][$userYear] = 0;
  }
  $counts['years'][$userYear]++;
}
?>
<div class="bg-white dark:bg-gray-800 dark:border-gray-800 border mx-5 my-6 py-8 px-4 rounded-3xl my-5">
<!-- fontawesome + mdi -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://cdn.jsdelivr.net/npm/@mdi/font@7.1.96/css/materialdesignicons.min.css" rel="stylesheet">

<!-- jquery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <h1 class="text-2xl font-bold mb-6 px-8">Users Table</h1>

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

    <!-- Add User Button -->
    <a href="#" id="addUserBtn" class="mb-4 ml-8 px-4 py-2 bg-blue-500 text-white rounded inline-block">
      Add User
    </a>

    <!-- Reusable Modal -->
    <div id="userModal" class="fixed inset-0 w-full h-full bg-white dark:bg-gray-900 dark:text-white z-50 overflow-y-auto hidden">
      <div class="flex items-center justify-between p-4 border-b dark:border-gray-700">
        <button class="modal-close flex items-center text-gray-700 dark:text-gray-300 hover:text-black dark:hover:text-white">
          <i class="fa fa-arrow-left mr-2"></i> Back
        </button>
        <h2 class="text-xl font-bold" id="modalTitle">User</h2>
        <span></span>
      </div>
      <div class="p-6 max-w-2xl mx-auto" id="modalContent"></div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto px-8 pt-2">
      <div id="tab-tables">
        <table id="usersTable" class="display min-w-full bg-white rounded shadow w-full text-sm text-left text-gray-700 dark:text-gray-200">
          <thead>
            <tr>
              <th class="border-0 bg-gray-100 px-4 py-4 dark:bg-gray-800 text-left"><input type="checkbox" id="selectAll"></th>
              <th class="border-0 bg-gray-100 px-4 py-4 dark:bg-gray-800 text-left bg-gray-100 dark:bg-gray-800 font-semibold text-gray-700 dark:text-gray-300 px-4 py-3">#</th>
              <th class="border-0 bg-gray-100 px-4 py-4 dark:bg-gray-800 text-left bg-gray-100 dark:bg-gray-800 font-semibold text-gray-700 dark:text-gray-300 px-4 py-3">Username</th>
              <th class="border-0 bg-gray-100 px-4 py-4 dark:bg-gray-800 text-left bg-gray-100 dark:bg-gray-800 font-semibold text-gray-700 dark:text-gray-300 px-4 py-3">Email</th>
              <th class="border-0 bg-gray-100 px-4 py-4 dark:bg-gray-800 text-left bg-gray-100 dark:bg-gray-800 font-semibold text-gray-700 dark:text-gray-300 px-4 py-3">Created At</th>
              <th class="border-0 bg-gray-100 px-4 py-4 dark:bg-gray-800 text-left bg-gray-100 dark:bg-gray-800 font-semibold text-gray-700 dark:text-gray-300 px-4 py-3">Status</th>
              <th class="border-0 bg-gray-100 px-4 py-4 dark:bg-gray-800 text-left bg-gray-100 dark:bg-gray-800 font-semibold text-gray-700 dark:text-gray-300 px-4 py-3">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php $i=1; foreach($users as $user): ?>
            <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 hover:dark:bg-gray-700">
              <td class="border-0 px-4 py-4 dark:bg-gray-800"><input type="checkbox" class="rowCheckbox" data-id="<?= $user['id'] ?>"></td>
              <td class="border-0 px-4 py-4 dark:bg-gray-800"><?= $i++ ?></td>
              <td class="editable" data-id="<?= $user['id'] ?>" data-field="username"><?= htmlspecialchars($user['username']) ?></td>
              <td class="editable" data-id="<?= $user['id'] ?>" data-field="email"><?= htmlspecialchars($user['email']) ?></td>
              <td class="editable" data-id="<?= $user['id'] ?>" data-field="created_at"><?= htmlspecialchars($user['created_at']) ?></td>
              <td class="editable" data-id="<?= $user['id'] ?>" data-field="status"><?= htmlspecialchars($user['status']) ?></td>
              <td class="border-0 px-4 py-4 dark:bg-gray-800">
                <button class="viewBtn p-2 hover:bg-gray-100 rounded-full" data-id="<?= $user['id'] ?>" title="view"><i class="mdi-24px mdi mdi-eye"></i></button>
                <button class="editBtn p-2 hover:bg-gray-100 rounded-full" data-id="<?= $user['id'] ?>" title="edit"><i class="mdi-24px mdi mdi-pen"></i></button>
                <button class="deleteBtn p-2 hover:bg-gray-100 rounded-full" data-id="<?= $user['id'] ?>" title="delete"><i class="mdi-24px mdi mdi-delete"></i></button>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <!-- Charts Tab -->
<div id="tab-charts" class="hidden px-8 pt-4">
  <canvas id="userChart" height="120"></canvas>
</div>

<!-- Grid Tab -->
<div id="tab-grid" class="hidden px-8 pt-4">
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
    <?php foreach($users as $user): ?>
      <div
        class="group bg-white dark:bg-gray-800 rounded-lg shadow-md border border-transparent hover:border-blue-500 focus-within:border-blue-500 active:border-blue-700 transition duration-300 overflow-hidden"
        x-data="{ open: false }"
      >
        <img
          src="<?= htmlspecialchars($user['image'] ?? 'https://placehold.co/600x400') ?>"
          alt="User Image"
          class="w-full h-40 object-cover"
        />
        <div class="p-4">
          <h3 class="text-lg font-bold text-blue-600"><?= htmlspecialchars($user['username']) ?></h3>
          <p class="text-gray-600 dark:text-gray-300"><?= htmlspecialchars($user['email']) ?></p>
          <p class="text-sm text-gray-500 dark:text-gray-400">Status: <?= htmlspecialchars($user['status']) ?></p>

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
              <p><?= htmlspecialchars($user['bio'] ?? 'No additional information provided.') ?></p>
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
    <?php foreach($users as $user): ?>
      <li class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 hover:border-blue-500 transition">
        <div class="flex items-center space-x-4">
          <!-- Optional User Image -->
          <img
            src="<?= htmlspecialchars($user['image'] ?? 'https://placehold.co/600x400') ?>"
            alt="User Image"
            class="w-10 h-10 rounded-full object-cover"
          />

          <!-- User Info -->
          <div>
            <p class="font-semibold text-blue-600 dark:text-blue-400"><?= htmlspecialchars($user['username']) ?></p>
            <p class="text-sm text-gray-600 dark:text-gray-300"><?= htmlspecialchars($user['email']) ?></p>
            <p class="text-xs text-gray-500 dark:text-gray-400">Status: <?= htmlspecialchars($user['status']) ?></p>
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
    <table id="usersTable" class="min-w-full bg-white rounded shadow text-sm">
      <thead>
        <tr>
          <th class="bg-gray-100 px-4 py-2 text-left dark:bg-gray-800">#</th>
          <th class="bg-gray-100 px-4 py-2 text-left dark:bg-gray-800">Username</th>
          <th class="bg-gray-100 px-4 py-2 text-left dark:bg-gray-800">Email</th>
          <th class="bg-gray-100 px-4 py-2 text-left dark:bg-gray-800">Created At</th>
          <th class="bg-gray-100 px-4 py-2 text-left dark:bg-gray-800">Status</th>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; foreach($users as $user): ?>
        <tr class="border-t">
          <td class="px-4 py-2 dark:bg-gray-800"><?= $i++ ?></td>
          <td class="px-4 py-2 dark:bg-gray-800"><?= htmlspecialchars($user['username']) ?></td>
          <td class="px-4 py-2 dark:bg-gray-800"><?= htmlspecialchars($user['email']) ?></td>
          <td class="px-4 py-2 dark:bg-gray-800"><?= htmlspecialchars($user['created_at']) ?></td>
          <td class="px-4 py-2 dark:bg-gray-800"><?= htmlspecialchars($user['status']) ?></td>
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
    url: '/PDT-NEW/projects/pdo/app/crud/api/users.php',
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

<!-- Export Tab -->
<div id="tab-export" class="hidden px-8 pt-4 h-1/3">
  <a href="/PDT-NEW/projects/pdo/app/crud/api/users.php?action=export" class="bg-green-500 text-white px-4 py-2 rounded">Export All Users</a>
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
        value="https://yourapp.com/users/share"
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
    <a href="mailto:?subject=Check this out&body=https://yourapp.com/users/share" target="_blank"
      class="flex flex-col items-center justify-center border rounded-lg p-4 hover:shadow transition">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-700 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H8m0 0l4-4m-4 4l4 4" />
      </svg>
      <span class="text-sm font-medium text-gray-700">Email</span>
    </a>

    <!-- WhatsApp -->
    <a href="https://wa.me/?text=https://yourapp.com/users/share" target="_blank"
      class="flex flex-col items-center justify-center border rounded-lg p-4 hover:shadow transition">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-700 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h2l1 2 2-2h2l1 2 2-2h2l1 2 2-2h2" />
      </svg>
      <span class="text-sm font-medium text-gray-700">WhatsApp</span>
    </a>

    <!-- Facebook -->
    <a href="https://www.facebook.com/sharer/sharer.php?u=https://yourapp.com/users/share" target="_blank"
      class="flex flex-col items-center justify-center border rounded-lg p-4 hover:shadow transition">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-700 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z" />
      </svg>
      <span class="text-sm font-medium text-gray-700">Facebook</span>
    </a>

    <!-- Twitter (X) -->
    <a href="https://x.com/intent/tweet?url=https://yourapp.com/users/share" target="_blank"
      class="flex flex-col items-center justify-center border rounded-lg p-4 hover:shadow transition">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-700 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path d="M17.5 6.5L6.5 17.5M6.5 6.5L17.5 17.5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
      <span class="text-sm font-medium text-gray-700">X (Twitter)</span>
    </a>

    <!-- LinkedIn -->
    <a href="https://www.linkedin.com/shareArticle?url=https://yourapp.com/users/share" target="_blank"
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
      href="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=https://yourapp.com/users/share"
      download="ShareQR.png"
      class="inline-block"
    >
      <img
        src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=https://yourapp.com/users/share"
        alt="QR Code"
        class="w-40 h-40 mx-auto rounded border shadow"
      />
      <p class="text-blue-500 mt-2 hover:underline">Download Me</p>
    </a>
  </div>
</div>

</div>
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


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
const ctx = document.getElementById('userChart');
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
        label: 'Users Created',
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
          title: { display: true, text: 'User Count' }
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
  let input;

  if (field === 'status') {
    input = $(`
      <select class="w-full p-1 border rounded">
        <option value="active">Active</option>
        <option value="inactive">Inactive</option>
      </select>
    `);
    input.val(originalValue.toLowerCase());
  } else if (field === 'created_at') {
    input = $(`<input type="datetime-local" class="w-full p-1 border rounded" />`);
    let date = new Date(originalValue);
    let iso = date.toISOString().slice(0, 16); // "YYYY-MM-DDTHH:MM"
    input.val(iso);
  } else if (field === 'email') {
    input = $(`<input type="email" class="w-full p-1 border rounded" value="${originalValue}" />`);
  } else if (field === 'username') {
    input = $(`<input type="text" class="w-full p-1 border rounded" value="${originalValue}" />`);
  } else if (field === 'some_number_field') {
    input = $(`<input type="number" class="w-full p-1 border rounded" value="${originalValue}" />`);
  } else {
    input = $(`<input type="text" class="w-full p-1 border rounded" value="${originalValue}" />`);
  }

  td.html(input);
  input.focus();

  // Save on blur or Enter
  input.on('blur keydown', function (e) {
    if (e.type === 'blur' || (e.type === 'keydown' && e.key === 'Enter')) {
      let newValue = input.val();

      // If datetime, convert to string for DB
      if (field === 'created_at') {
        newValue = new Date(newValue).toISOString().slice(0, 19).replace('T', ' ');
      }

      $.post('/PDT-NEW/projects/pdo/app/crud/api/users.php', {
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
    $('#userModal').hide().removeClass('hidden').fadeIn(200);
  }

  $(document).on('click','.modal-close', function(){
    $('#userModal').fadeOut(200,function(){ $(this).addClass('hidden'); });
  });

  // --- Add User ---
  $('#addUserBtn').click(function(e){
    e.preventDefault();
    let html = `
      <form id="addUserForm">
        <input type="text" name="username" placeholder="Username" required class="w-full mb-4 p-3 border rounded">
        <input type="email" name="email" placeholder="Email" required class="w-full mb-4 p-3 border rounded">
        <input type="password" name="password" placeholder="Password" required class="w-full mb-4 p-3 border rounded">
        <div class="flex justify-end gap-3 mt-4">
          <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded">Save</button>
          <button type="button" id="saveContinueBtn" class="bg-blue-500 text-white px-6 py-2 rounded">Save & Continue</button>
          <button type="reset" class="bg-gray-500 text-white px-6 py-2 rounded">Reset</button>
          <button type="button" class="modal-close bg-gray-500 text-white px-6 py-2 rounded">Close</button>
        </div>
      </form>`;
    openModal('Add User',html);
  });

  // --- Submit Add ---
  $(document).on('submit','#addUserForm', function(e){
    e.preventDefault();
    $.post('/PDT-NEW/projects/pdo/app/crud/api/users.php', $(this).serialize()+'&action=insert', function(res){
      if(res.success){
        showToast(res.message);
        $('#userModal').fadeOut(200,function(){ $(this).addClass('hidden'); });
        $("#usersTable").load(location.href + " #usersTable");
      } else { showToast(res.message,'error'); }
    },'json').fail(()=>showToast('Server error','error'));
  });

  // --- Save & Continue ---
  $(document).on('click','#saveContinueBtn', function(){
    $.post('/PDT-NEW/projects/pdo/app/crud/api/users.php', $('#addUserForm').serialize()+'&action=insert', function(res){
      if(res.success){
        showToast(res.message);
        $("#usersTable").load(location.href + " #usersTable");
        $('#addUserForm')[0].reset();
      } else showToast(res.message,'error');
    },'json').fail(()=>showToast('Server error','error'));
  });

// --- View User ---
$(document).on('click','.viewBtn', function(){
    let id=$(this).data('id');
    $.post('/PDT-NEW/projects/pdo/app/crud/api/users.php',{action:'view',id}, function(res){
      if(res.success){
        let html = `
          <div class="bg-blue-500 text-white p-4 rounded mb-4 text-lg font-semibold">
            User Profile
          </div>
          <div class="grid grid-cols-2 gap-6 bg-white dark:bg-gray-800 p-6 rounded shadow">
            <div>
              <p class="text-gray-700 dark:text-gray-200"><strong>Username:</strong> ${res.data.username}</p>
              <p class="text-gray-700 dark:text-gray-200"><strong>Email:</strong> ${res.data.email}</p>
              <p class="text-gray-700 dark:text-gray-200"><strong>Status:</strong> <span class="capitalize">${res.data.status}</span></p>
            </div>
            <div>
              <p class="text-gray-700 dark:text-gray-200"><strong>Created At:</strong> ${res.data.created_at}</p>
              <p class="text-gray-700 dark:text-gray-200"><strong>Updated At:</strong> ${res.data.updated_at}</p>
            </div>
          </div>
          <div class="flex justify-end mt-4">
            <button type="button" class="modal-close bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">Close</button>
          </div>
        `;
        openModal('View User', html);
      } else showToast(res.message,'error');
    },'json').fail(()=>showToast('Server error','error'));
});


  // --- Edit User ---
  $(document).on('click','.editBtn', function(){
    let id=$(this).data('id');
    $.post('/PDT-NEW/projects/pdo/app/crud/api/users.php',{action:'view',id}, function(res){
      if(res.success){
        let html=`
          <form id="editUserForm">
            <input type="hidden" name="id" value="${res.data.id}">
            <input type="text" name="username" value="${res.data.username}" required class="w-full mb-4 p-3 border rounded">
            <input type="email" name="email" value="${res.data.email}" required class="w-full mb-4 p-3 border rounded">
            <select name="status" class="w-full mb-4 p-3 border rounded">
              <option value="active" ${res.data.status==='active'?'selected':''}>Active</option>
              <option value="inactive" ${res.data.status==='inactive'?'selected':''}>Inactive</option>
            </select>
            <div class="flex justify-end gap-3 mt-4">
              <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded">Save</button>
              <button type="button" class="modal-close bg-gray-500 text-white px-6 py-2 rounded">Close</button>
            </div>
          </form>`;
        openModal('Edit User',html);
      } else showToast(res.message,'error');
    },'json').fail(()=>showToast('Server error','error'));
  });

  // --- Submit Edit ---
  $(document).on('submit','#editUserForm', function(e){
    e.preventDefault();
    $.post('/PDT-NEW/projects/pdo/app/crud/api/users.php', $(this).serialize()+'&action=edit', function(res){
      if(res.success){
        showToast(res.message);
        $('#userModal').fadeOut(200,function(){ $(this).addClass('hidden'); });
        $("#usersTable").load(location.href + " #usersTable");
      } else showToast(res.message,'error');
    },'json').fail(()=>showToast('Server error','error'));
  });

  // --- Delete User ---
  $(document).on('click','.deleteBtn', function(){
    let id=$(this).data('id');
    let html=`
      <p>Are you sure you want to delete this user?</p>
      <div class="flex justify-end gap-3 mt-4">
        <button id="confirmDeleteBtn" data-id="${id}" class="bg-red-500 text-white px-6 py-2 rounded">Delete</button>
        <button type="button" class="modal-close bg-gray-500 text-white px-6 py-2 rounded">Cancel</button>
      </div>`;
    openModal('Confirm Delete',html);
  });

  $(document).on('click','#confirmDeleteBtn', function(){
    let id=$(this).data('id');
    $.post('/PDT-NEW/projects/pdo/app/crud/api/users.php',{action:'delete',id}, function(res){
      if(res.success){
        showToast(res.message);
        $('#userModal').fadeOut(200,function(){ $(this).addClass('hidden'); });
        $("#usersTable").load(location.href + " #usersTable");
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
        // Bulk Copy: fetch each user's data
        $.post('/PDT-NEW/projects/pdo/app/crud/api/users.php',{action:'bulk_view', ids: ids}, function(res){
            if(res.success){
                let html = '<form id="bulkCopyForm">';
                res.data.forEach(user => {
                    html += `
                        <div class="bg-white dark:bg-gray-800 p-4 rounded shadow mb-4">
                            <h3 class="font-bold text-lg mb-2 text-green-500">Copy User: ${user.username}</h3>
                            <input type="hidden" name="ids[]" value="${user.id}">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label>Username</label>
                                    <input type="text" name="username[${user.id}]" value="${user.username}" class="w-full p-2 border rounded mb-2">
                                </div>
                                <div>
                                    <label>Email</label>
                                    <input type="email" name="email[${user.id}]" value="${user.email}" class="w-full p-2 border rounded mb-2">
                                </div>
                                <div>
                                    <label>Status</label>
                                    <input type="text" name="status[${user.id}]" value="${user.status}" class="w-full p-2 border rounded mb-2">
                                </div>
                            </div>
                        </div>
                    `;
                });

                html += `<div class="flex justify-end gap-3 mt-4">
                            <button id="bulkCopySaveBtn" class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600">Save as New</button>
                            <button type="button" class="modal-close bg-gray-500 text-white px-6 py-2 rounded">Cancel</button>
                         </div></form>`;

                openModal('Bulk Copy Users', html);
            } else showToast(res.message,'error');
        },'json').fail(()=>showToast('Server error','error'));
    }



    else if(action === 'delete'){
        let html = `<p>Are you sure you want to delete selected users?</p>
                    <div class="flex justify-end gap-3 mt-4">
                      <button id="bulkDeleteBtn" class="bg-red-500 text-white px-6 py-2 rounded">Delete</button>
                      <button type="button" class="modal-close bg-gray-500 text-white px-6 py-2 rounded">Cancel</button>
                    </div>`;
        openModal('Confirm Bulk Delete', html);
    }


      else if(action === 'view'){
          $.post('/PDT-NEW/projects/pdo/app/crud/api/users.php',{action:'bulk_view', ids: ids}, function(res){
              if(res.success){
                  let html = '';
                  res.data.forEach(user => {
                      html += `<div class="bg-white dark:bg-gray-800 p-4 rounded shadow mb-4">
                                  <h3 class="font-bold text-lg mb-2 text-blue-500">${user.username}</h3>
                                  <p>Email: ${user.email}</p>
                                  <p>Status: ${user.status}</p>
                                </div>`;
                  });
                  html += `<div class="flex justify-end mt-4">
                              <button type="button" class="modal-close bg-gray-500 text-white px-6 py-2 rounded">Close</button>
                          </div>`;
                  openModal('View Users', html);
              }
          },'json');
      }

      else if(action === 'export'){
          let idsParam = ids.join(',');
          window.location.href = `/PDT-NEW/projects/pdo/app/crud/api/users.php?action=bulk_export&ids=${idsParam}`;
      }


    else if(action === 'edit'){
        // Bulk Edit: fetch each user's data
        $.post('/PDT-NEW/projects/pdo/app/crud/api/users.php',{action:'bulk_view', ids: ids}, function(res){
            if(res.success){
                // Create forms for each user
                let html = '';
                res.data.forEach(user => {
                    html += `
                        <div class="bg-white dark:bg-gray-800 p-4 rounded shadow mb-4">
                            <h3 class="font-bold text-lg mb-2 text-blue-500">Edit User: ${user.username}</h3>
                            <input type="hidden" name="ids[]" value="${user.id}">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-gray-700 dark:text-gray-200">Username</label>
                                    <input type="text" name="username[${user.id}]" value="${user.username}" class="w-full p-2 border rounded mb-2" required>
                                </div>
                                <div>
                                    <label class="block text-gray-700 dark:text-gray-200">Email</label>
                                    <input type="email" name="email[${user.id}]" value="${user.email}" class="w-full p-2 border rounded mb-2" required>
                                </div>
                                <div>
                                    <label class="block text-gray-700 dark:text-gray-200">Status</label>
                                    <select name="status[${user.id}]" class="w-full p-2 border rounded mb-2">
                                        <option value="active" ${user.status==='active'?'selected':''}>Active</option>
                                        <option value="inactive" ${user.status==='inactive'?'selected':''}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    `;
                });

                html += `<div class="flex justify-end gap-3 mt-4">
                            <button id="bulkSaveBtn" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">Save</button>
                            <button type="button" class="modal-close bg-gray-500 text-white px-6 py-2 rounded">Cancel</button>
                         </div>`;

                openModal('Bulk Edit Users', html);
            } else showToast(res.message,'error');
        },'json').fail(()=>showToast('Server error','error'));
    } else {
        alert('Bulk action not implemented yet.');
    }
});



$(document).on('click','#bulkDeleteBtn', function(){
    let ids = $('.rowCheckbox:checked').map(function(){ return $(this).data('id'); }).get();
    $.post('/PDT-NEW/projects/pdo/app/crud/api/users.php',{action:'bulk_delete',ids:ids}, function(res){
        if(res.success){
            showToast(res.message);
            $('#userModal').fadeOut(200,function(){ $(this).addClass('hidden'); });
            $("#usersTable").load(location.href + " #usersTable");
        } else showToast(res.message,'error');
    },'json');
});


$(document).on('click','#bulkCopySaveBtn', function(e){
    e.preventDefault();
    let formData = { action: 'bulk_copy', ids: [] };
    $('#modalContent').find('input[name="ids[]"]').each(function(){
        formData.ids.push($(this).val());
    });

// Collect all user fields
    $('#modalContent').find('input, select').each(function(){
        if(this.name.includes('username') || this.name.includes('email') || this.name.includes('status')){
            formData[this.name] = $(this).val();
        }
    });


    $.post('/PDT-NEW/projects/pdo/app/crud/api/users.php', formData, function(res){
        if(res.success){
            showToast(res.message);
            $('#userModal').fadeOut(200,function(){ $(this).addClass('hidden'); });
            $("#usersTable").load(location.href + " #usersTable");
        } else showToast(res.message,'error');
    },'json').fail((xhr)=>showToast(JSON.stringify(xhr)+'Server error','error'));
});






// --- Save Bulk Edit ---
$(document).on('click','#bulkSaveBtn', function(){
      let formData = { action: 'bulk_edit', ids: [] };

      $('#modalContent').find('input[name="ids[]"]').each(function(){
          formData.ids.push($(this).val());
      });

    // Collect all user fields
    $('#modalContent').find('input, select').each(function(){
        if(this.name.includes('username') || this.name.includes('email') || this.name.includes('status')){
            formData[this.name] = $(this).val();
        }
    });
    formData['action'] = 'bulk_edit';

    $.post('/PDT-NEW/projects/pdo/app/crud/api/users.php', formData, function(res){
        if(res.success){
            showToast(res.message);
            $('#userModal').fadeOut(200,function(){ $(this).addClass('hidden'); });
            $("#usersTable").load(location.href + " #usersTable");
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
<!-- DataTables CSS (latest) -->
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.7/css/dataTables.dataTables.min.css">

<!-- DataTables JS (latest) -->
<script src="https://cdn.datatables.net/2.1.7/js/dataTables.min.js"></script>

<script>
$(document).ready(function(){

  // Initialize DataTable
  let table = new DataTable('#usersTable', {
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
      $('#usersTable').addClass('stripe hover text-gray-200 bg-gray-900');
    } else {
      $('#usersTable').removeClass('text-gray-200 bg-gray-900');
    }
  }

  applyDarkMode();

  // If your site toggles dark mode dynamically, re-apply styles
  const observer = new MutationObserver(applyDarkMode);
  observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });

});
</script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

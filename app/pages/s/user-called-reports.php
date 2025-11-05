
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div class="bg-slate-50 dark:bg-slate-800 mx-6 rounded-3xl min-h-screen p-6">
  <div class="max-w-7xl mx-auto">
    <header class="flex justify-between items-center mb-6">
      <div>
        <h1 class="text-2xl font-semibold">Registered Users — Report</h1>
        <p class="text-sm text-slate-500">Overview with filters, charts, and CSV export.</p>
      </div>
      <button id="exportCSV" class="px-3 py-2 bg-sky-600 text-white rounded-md shadow-sm hover:bg-sky-700 text-sm">
        Export CSV
      </button>
    </header>

    <!-- Filters -->
    <div class="flex flex-wrap gap-2 mb-4">
      <input id="search" type="text" placeholder="Search username or email..."
        class="flex-1 px-3 py-2 border rounded-md bg-white dark:bg-slate-800 dark:border-slate-700" />
      <select id="statusFilter" class="px-3 py-2 border rounded-md bg-white dark:bg-slate-800 dark:border-slate-700">
        <option value="">All statuses</option>
        <option>active</option>
        <option>pending</option>
        <option>suspended</option>
        <option>deleted</option>
      </select>
      <select id="sortBy" class="px-3 py-2 border rounded-md bg-white dark:bg-slate-800 dark:border-slate-700">
        <option value="created_at">Created At</option>
        <option value="updated_at">Updated At</option>
        <option value="username">Username</option>
      </select>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-sm overflow-x-auto">
      <table id="usersTable" class="min-w-full divide-y">
        <thead class="bg-slate-50 dark:bg-slate-800 text-xs text-slate-500">
          <tr>
            <th class="p-3 text-left">Username / Email</th>
            <th class="p-3 text-left">Status</th>
            <th class="p-3 text-left">Created At</th>
            <th class="p-3 text-left">Updated At</th>
          </tr>
        </thead>
        <tbody id="tableBody" class="divide-y text-sm"></tbody>
      </table>
    </div>

    <!-- Charts -->
    <div class="grid md:grid-cols-2 gap-6 mt-8">
      <div class="bg-white dark:bg-slate-700 p-4 rounded-2xl shadow-sm">
        <h3 class="text-sm font-medium mb-2">Signups — last 12 months</h3>
        <canvas id="signupChart" height="120"></canvas>
      </div>
      <div class="bg-white dark:bg-slate-700 p-4 rounded-2xl shadow-sm">
        <h3 class="text-sm font-medium mb-2">Status distribution</h3>
        <canvas id="statusChart" height="120"></canvas>
      </div>
    </div>
  </div>

<script>
let users = [];

function fetchUsers() {
  $.get('/PDT-NEW/projects/pdo/app/system/api/users-report.php', {
    ajax: 1,
    query: $('#search').val(),
    status: $('#statusFilter').val(),
    sort: $('#sortBy').val()
  }, function(data) {
    users = data;
    renderTable();
    updateCharts();
  });
}

function renderTable() {
  const tbody = $('#tableBody').empty();
  users.forEach(u => {
    tbody.append(`
      <tr class="hover:bg-slate-50 dark:bg-slate-800">
        <td class="p-3"><div class="font-medium">${u.username}</div><div class="text-xs text-slate-400">${u.email}</div></td>
        <td class="p-3 ${u.status === 'active' ? 'text-green-600' : 'text-slate-600'}">${u.status}</td>
        <td class="p-3">${u.created_at}</td>
        <td class="p-3">${u.updated_at}</td>
      </tr>
    `);
  });
}

let signupChartInstance, statusChartInstance;
function updateCharts() {
  // Status distribution
  const statusCounts = {};
  users.forEach(u => statusCounts[u.status] = (statusCounts[u.status] || 0) + 1);
  if (statusChartInstance) statusChartInstance.destroy();
  statusChartInstance = new Chart($('#statusChart'), {
    type: 'pie',
    data: {
      labels: Object.keys(statusCounts),
      datasets: [{ data: Object.values(statusCounts), backgroundColor: ['#60A5FA','#34D399','#FBBF24','#F87171','#C084FC'] }]
    }
  });

  // Signups per month (last 12 months)
  const months = [...Array(12).keys()].map(i => {
    const d = new Date(); d.setMonth(d.getMonth() - i);
    return d.toLocaleString('default', { month: 'short', year: 'numeric' });
  }).reverse();
  const signupData = months.map(m => users.filter(u => u.signup_month === m).length);
  if (signupChartInstance) signupChartInstance.destroy();
  signupChartInstance = new Chart($('#signupChart'), {
    type: 'line',
    data: { labels: months, datasets: [{ label: 'Signups', data: signupData, borderColor: '#2563EB', fill: false }] }
  });
}

function exportCSV() {
  if (!users.length) return;
  const csv = [Object.keys(users[0]).join(',')]
    .concat(users.map(u => Object.values(u).join(',')))
    .join('\n');
  const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
  const url = URL.createObjectURL(blob);
  const a = document.createElement('a');
  a.href = url; a.download = 'users-report.csv'; a.click();
}

$('#search, #statusFilter, #sortBy').on('change keyup', fetchUsers);
$('#exportCSV').on('click', exportCSV);

// Initial load
fetchUsers();
</script>
</div>
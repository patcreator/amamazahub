<?php
// Auto-generated report page for table: feedback
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>feedback Report</title>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
body { background: #f9fafb; font-family: system-ui, sans-serif; color: #111; }
section { padding: 2rem; }
table.dataTable { width: 100%; font-size: 0.9rem; }
h1 { font-size: 1.5rem; font-weight: 600; }
button { cursor: pointer; }
.chart-container { background: #fff; border-radius: 12px; padding: 1rem; box-shadow: 0 1px 4px rgba(0,0,0,0.1); }
</style>
</head>
<body>

<section>
  <header style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;">
    <div>
      <h1>feedback — Report</h1>
      <p style="color:#6b7280;font-size:0.9rem;">Auto-generated data report with charts & CSV export</p>
    </div>
    <button id="exportCSV" style="background:#2563EB;color:#fff;padding:0.5rem 1rem;border:none;border-radius:6px;">Export CSV</button>
  </header>

  <div style="background:#fff;border-radius:12px;padding:1rem;box-shadow:0 1px 3px rgba(0,0,0,0.08);overflow-x:auto;">
    <table id="reportTable" class="display">
      <thead><tr>
        <th>Id</th>
        <th>User id</th>
        <th>Name</th>
        <th>Email</th>
        <th>Subject</th>
        <th>Message</th>
        <th>Rating</th>
        <th>Type</th>
        <th>Status</th>
        <th>Created at</th>
        <th>Updated at</th>      </tr></thead>
      <tbody></tbody>
    </table>
  </div>

  <div class="grid" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(350px,1fr));gap:1.5rem;margin-top:2rem;">    <div class="chart-container">
      <h3 style="font-size:0.9rem;margin-bottom:0.5rem;">Records Created — last 12 months</h3>
      <canvas id="createdChart" height="120"></canvas>
    </div>    <div class="chart-container">
      <h3 style="font-size:0.9rem;margin-bottom:0.5rem;">Status Distribution</h3>
      <canvas id="statusChart" height="120"></canvas>
    </div>  </div>
</section>

<script>
$(function() {
  let records = [];
  const table = $('#reportTable').DataTable({
    ajax: {
      url: '<?= $path ?>app/crud/reports/api/feedback.php?ajax=1',
      dataSrc: ''
    },
    columns: [
      { data: 'id' },
      { data: 'user_id' },
      { data: 'name' },
      { data: 'email' },
      { data: 'subject' },
      { data: 'message' },
      { data: 'rating' },
      { data: 'type' },
      { data: 'status' },
      { data: 'created_at' },
      { data: 'updated_at' },    ]
  });

  table.on('xhr.dt', function(e, settings, json, xhr) {
    records = json;
    updateCharts();
  });

  function updateCharts() {    // --- Status Distribution ---
    const statusCounts = {};
    records.forEach(r => statusCounts[r.status] = (statusCounts[r.status] || 0) + 1);
    if (window.statusChartInstance) window.statusChartInstance.destroy();
    window.statusChartInstance = new Chart($('#statusChart'), {
      type: 'pie',
      data: {
        labels: Object.keys(statusCounts),
        datasets: [{ data: Object.values(statusCounts), backgroundColor: ['#3B82F6','#10B981','#F59E0B','#EF4444','#8B5CF6'] }]
      }
    });
    // --- Created Records per Month ---
    const months = [...Array(12).keys()].map(i => {
      const d = new Date(); d.setMonth(d.getMonth() - i);
      return d.toLocaleString('default', { month: 'short', year: 'numeric' });
    }).reverse();

    const monthlyCounts = months.map(m => records.filter(r => {
      const date = new Date(r.created_at);
      const label = date.toLocaleString('default', { month: 'short', year: 'numeric' });
      return label === m;
    }).length);

    if (window.createdChartInstance) window.createdChartInstance.destroy();
    window.createdChartInstance = new Chart($('#createdChart'), {
      type: 'line',
      data: { labels: months, datasets: [{ label: 'Records Created', data: monthlyCounts, borderColor: '#2563EB', fill: false }] }
    });  }

  // --- CSV Export ---
  $('#exportCSV').on('click', function() {
    const data = table.rows({ search: 'applied' }).data().toArray();
    if (!data.length) return;
    const csv = [Object.keys(data[0]).join(',')]
      .concat(data.map(r => Object.values(r).join(',')))
      .join('\n');
    const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url; a.download = 'feedback-report.csv'; a.click();
  });
});
</script>

</body>
</html>
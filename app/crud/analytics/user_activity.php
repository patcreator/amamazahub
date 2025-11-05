    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <?php
// Helper function to get counts for a period
function getCount($pdo, $period) {
    switch($period) {
        case 'today':
            $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM user_activity WHERE DATE(created_at) = CURDATE()");
            break;
        case 'yesterday':
            $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM user_activity WHERE DATE(created_at) = CURDATE() - INTERVAL 1 DAY");
            break;
        case 'week':
            $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM user_activity WHERE YEARWEEK(created_at,1) = YEARWEEK(CURDATE(),1)");
            break;
        case 'last_week':
            $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM user_activity WHERE YEARWEEK(created_at,1) = YEARWEEK(CURDATE(),1) - 1");
            break;
        case 'month':
            $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM user_activity WHERE MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())");
            break;
        case 'last_month':
            $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM user_activity WHERE MONTH(created_at) = MONTH(CURDATE() - INTERVAL 1 MONTH) AND YEAR(created_at) = YEAR(CURDATE() - INTERVAL 1 MONTH)");
            break;
        case 'year':
            $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM user_activity WHERE YEAR(created_at) = YEAR(CURDATE())");
            break;
        case 'last_year':
            $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM user_activity WHERE YEAR(created_at) = YEAR(CURDATE()) - 1");
            break;
        case 'all':
        default:
            $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM user_activity");
            break;
    }

    $stmt->execute();
    return (int)$stmt->fetch()['total'];
}

// Get counts
$today = getCount($pdo,'today');
$yesterday = getCount($pdo,'yesterday');
$week = getCount($pdo,'week');
$last_week = getCount($pdo,'last_week');
$month = getCount($pdo,'month');
$last_month = getCount($pdo,'last_month');
$year = getCount($pdo,'year');
$last_year = getCount($pdo,'last_year');
$all_user_activity = getCount($pdo,'all');

// Optional: percentage changes
$today_change = $yesterday ? round((($today - $yesterday)/$yesterday)*100) : 0;
$week_change = $last_week ? round((($week - $last_week)/$last_week)*100) : 0;
$month_change = $last_month ? round((($month - $last_month)/$last_month)*100) : 0;
$year_change = $last_year ? round((($year - $last_year)/$last_year)*100) : 0;
?>

    <style>
        /* Custom styles for charts and select */
        .chart-container {
            position: relative;
            height: 400px;
            width: 100%;
        }
        /* Custom Select Styles */
        .custom-select {
            position: relative;
            display: inline-block;
            width: 200px;
        }
        .custom-select .select-button {
            background: transparent;
            border: 1px solid #678;
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            width: 100%;
            text-align: left;
            cursor: pointer;
            font-size: 1rem;
            color: #374151;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: border-color 0.2s;
        }
        .custom-select .select-button:hover {
            border-color: #3b82f6;
        }
        .custom-select .select-button::after {
            content: '▼';
            font-size: 0.75rem;
            color: #6b7280;
            transition: transform 0.2s;
        }
        .custom-select.open .select-button::after {
            transform: rotate(180deg);
        }
        .custom-select .select-options {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background-color: transparent;
            border: 1px solid #678;
            border-top: none;
            border-radius: 0 0 0.5rem 0.5rem;
            max-height: 200px;
            overflow-y: auto;
            z-index: 10;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.2s;
            backdrop-filter: blur(10px);
        }
        .custom-select.open .select-options {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        .custom-select .select-option {
            padding: 0.75rem 1rem;
            cursor: pointer;
            color: #678;
            transition: background-color 0.2s;
        }
        .custom-select .select-option:hover {
            background-color: #f3f4f6;
        }
        .custom-select .select-option.selected {
            background-color: #dbeafe;
            color: #1e40af;
        }
    </style>
<div class="p-5 mt-9">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold mb-8 text-gray-800 dark:text-gray-300">user_activity  Registration Dashboard</h1>
        

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    <!-- Today -->
    <div class="dark:bg-gray-800 bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-lg font-semibold dark:text-gray-300 text-gray-700 mb-2">user_activity Registered Today</h2>
        <p class="text-3xl font-bold text-blue-600"><?= number_format($today) ?></p>
        <p class="text-sm dark:text-gray-200 text-gray-500 mt-1"><?= $today_change >= 0 ? '+' : '' ?><?= $today_change ?>% rom yesterday</p>
    </div>
    
    <!-- This Week -->
    <div class="dark:bg-gray-800 bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-lg font-semibold dark:text-gray-300 text-gray-700 mb-2">user_activity This Week</h2>
        <p class="text-3xl font-bold text-green-600"><?= number_format($week) ?></p>
        <p class="text-sm dark:text-gray-200 text-gray-500 mt-1"><?= $week_change >= 0 ? '+' : '' ?><?= $week_change ?>% rom last week</p>
    </div>
    
    <!-- This Month -->
    <div class="dark:bg-gray-800 bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-lg font-semibold dark:text-gray-300 text-gray-700 mb-2">user_activity This Month</h2>
        <p class="text-3xl font-bold text-purple-600"><?= number_format($month) ?></p>
        <p class="text-sm dark:text-gray-200 text-gray-500 mt-1"><?= $month_change >= 0 ? '+' : '' ?><?= $month_change ?>% rom last month</p>
    </div>
    
    <!-- This Year -->
    <div class="dark:bg-gray-800 bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-lg font-semibold dark:text-gray-300 text-gray-700 mb-2">user_activity This Year</h2>
        <p class="text-3xl font-bold text-orange-600"><?= number_format($year) ?></p>
        <p class="text-sm dark:text-gray-200 text-gray-500 mt-1"><?= $year_change >= 0 ? '+' : '' ?><?= $year_change ?>% rom last year</p>
    </div>
    
    <!-- All user_activity -->
    <div class="dark:bg-gray-800 bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-lg font-semibold dark:text-gray-300 text-gray-700 mb-2">All user_activity (Total)</h2>
        <p class="text-3xl font-bold text-indigo-600"><?= number_format($all_user_activity) ?></p>
        <p class="text-sm dark:text-gray-200 text-gray-500 mt-1">Lifetime total</p>
    </div>
</div>


        
        <!-- Dynamic Chart: user_activity by Selected Period (Line Chart) -->
        <div class="dark:bg-gray-800 bg-white p-6 rounded-lg shadow-md mb-8">
                            <!-- Custom Select for Time Period -->
        <div class="flex justify-start mb-8">
            <div class="custom-select" id="periodSelect">
                <button class="select-button" id="selectButton">
                    <span id="selectedOption">All</span>
                </button>
                <div class="select-options" id="selectOptions">
                    <div class="select-option" data-period="day">Day</div>
                    <div class="select-option" data-period="week">Week</div>
                    <div class="select-option" data-period="month">Month</div>
                    <div class="select-option" data-period="year">Year</div>
                    <div class="select-option" data-period="years">Years</div>
                    <div class="select-option selected" data-period="all">All</div>
                </div>
            </div>
        </div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-300 mb-4" id="chartTitle">user_activity Registered by Period</h2>
            <div class="chart-container">
                <canvas id="periodChart"></canvas>
            </div>
        </div>
        
        <!-- Pie Chart for Breakdown (This Period vs. Prior) -->
        <div class="dark:bg-gray-800 bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-300 mb-4" id="pieTitle">Registration Breakdown (This Period vs. Prior)</h2>
            <div class="chart-container">
                <canvas id="breakdownChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        // Sample data for different periods
        const periodData = {
            day: {
                labels: ['00:00', '04:00', '08:00', '12:00', '16:00', '20:00'],
                data: [5, 15, 30, 25, 20, 5], // Hourly today
                title: 'user_activity Registered Today (Hourly)'
            },
            week: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                data: [50, 70, 80, 90, 100, 60, 50], // Daily this week
                title: 'user_activity Registered This Week (Daily)'
            },
            month: {
                labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                data: [400, 500, 600, 500], // Weekly this month
                title: 'user_activity Registered This Month (Weekly)'
            },
            year: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                data: [500, 600, 800, 900, 1000, 1100, 1200, 900, 800, 700, 600, 900], // Monthly this year (partial)
                title: 'user_activity Registered This Year (Monthly)'
            },
            years: {
                labels: ['2019', '2020', '2021', '2022', '2023', '2024'],
                data: [3000, 5000, 8000, 12000, 15000, 10000], // Yearly all time
                title: 'user_activity Registered by Year'
            },
            all: {
                labels: ['This Year', 'Prior Years'],
                data: [10000, 40000], // Total breakdown
                title: 'All user_activity Breakdown'
            }
        };

        let currentChart; // To destroy and recreate charts
        let currentBreakdownChart;

        // Initialize charts with default "all" period
        function initCharts(period = 'all') {
    fetch(`<?= $path?>app/crud/api/dashboard_user_activity.php?period=${period}`)
        .then(res => res.json())
        .then(data => {
            updateChartTitle(data.title);

            // Dynamic chart
            const ctx = document.getElementById('periodChart').getContext('2d');
            if(currentChart) currentChart.destroy();
            const chartType = (period === 'all') ? 'pie' : 'line';
            currentChart = new Chart(ctx, {
                type: chartType,
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'user_activity Registered',
                        data: data.data,
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: period === 'all' ? ['rgb(59, 130, 246)', 'rgb(156, 163, 175)'] : 'rgba(59, 130, 246, 0.1)',
                        tension: 0.1,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: period === 'all' ? {} : { y: { beginAtZero: true } },
                    plugins: { legend: { display: period !== 'all' } }
                }
            });

            // Pie chart
            const pieCtx = document.getElementById('breakdownChart').getContext('2d');
            if(currentBreakdownChart) currentBreakdownChart.destroy();
            currentBreakdownChart = new Chart(pieCtx, {
                type: 'pie',
                data: {
                    labels: period === 'all' ? ['Total user_activity', 'Inactive/Other'] : ['This Period','Prior Periods'],
                    datasets: [{
                        data: data.data,
                        backgroundColor: ['rgb(59, 130, 246)','rgb(156, 163, 175)']
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });

            document.getElementById('pieTitle').textContent = period === 'all' ? 'All user_activity Breakdown' : `Registration Breakdown (This ${period} vs. Prior)`;
        });
}

        function updateChartTitle(title) {
            document.getElementById('chartTitle').textContent = title;
        }

        function updateBreakdownChart(period) {
            const ctx = document.getElementById('breakdownChart').getContext('2d');
            if (currentBreakdownChart) {
                currentBreakdownChart.destroy();
            }

            let labels = ['This Period', 'Prior Periods'];
            let data = [periodData[period].data.reduce((a, b) => a + b, 0), 50000 - periodData[period].data.reduce((a, b) => a + b, 0)]; // Approximate prior

            if (period === 'all') {
                labels = ['Total user_activity', 'Inactive/Other'];
                data = [50000, 0]; // Full total
            }

            currentBreakdownChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        data: data,
                        backgroundColor: ['rgb(59, 130, 246)', 'rgb(156, 163, 175)'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top'
                        },
                        title: {
                            display: true,
                            text: period === 'all' ? 'All user_activity Total' : `Breakdown for ${period.charAt(0).toUpperCase() + period.slice(1)}`
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = ((context.parsed / total) * 100).toFixed(1);
                                    return `${context.label}: ${context.parsed.toLocaleString()} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });

            document.getElementById('pieTitle').textContent = period === 'all' ? 'All user_activity Breakdown' : `Registration Breakdown (This ${period} vs. Prior)`;
        }

        // Custom Select Functionality
        const selectContainer = document.getElementById('periodSelect');
        const selectButton = document.getElementById('selectButton');
        const selectOptions = document.getElementById('selectOptions');
        const selectedOption = document.getElementById('selectedOption');

        selectButton.addEventListener('click', () => {
            const isOpen = selectContainer.classList.contains('open');
            selectContainer.classList.toggle('open', !isOpen);
            selectOptions.classList.toggle('hidden', isOpen); // For accessibility/fallback
        });

        // Close select when clicking outside
        document.addEventListener('click', (e) => {
            if (!selectContainer.contains(e.target)) {
                selectContainer.classList.remove('open');
                selectOptions.classList.add('hidden');
            }
        });

        // Handle option selection
        selectOptions.querySelectorAll('.select-option').forEach(option => {
            option.addEventListener('click', (e) => {
                e.preventDefault();
                const period = option.dataset.period;
                selectedOption.textContent = option.textContent;
                
                // Update selected class
                selectOptions.querySelectorAll('.select-option').forEach(opt => opt.classList.remove('selected'));
                option.classList.add('selected');
                
                // Close dropdown
                selectContainer.classList.remove('open');
                selectOptions.classList.add('hidden');
                
                // Update charts
                initCharts(period);
            });
        });

        // Initialize with default "all"
        initCharts('all');




    </script>
</div>
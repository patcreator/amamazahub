<?php
    header("Content-Type:application/json");
    include '../system/cogs/functions.php';
    include '../api/db_helper.php';
    /**
     * LIST OF HTML VALIABLE TO BE RETURNED
     */
$path = "/PDT0/";
$help = ' <h1 class="text-2xl">The list of command</h1> <ul class="ms-12 mt-5"> <li><i class="fa fa-code me-2"></i> Create file [the path and the name of file (from parent file)]</li> <li><i class="fa fa-code me-2"></i> Create directory [the path and the name of directory (from parent file)]</li> <li><i class="fa fa-code me-2"></i> Sql: (the sql you want to run)</li> <li><i class="fa fa-code me-2"></i> Open: (everything in navigation example:home, about,file-manager,...)</li> <li><i class="fa fa-code me-2"></i> Delete file or directory (Put the full path of directory)</li> <li><i class="fa fa-code me-2"></i> Change settings (the name of settings)</li> <li><i class="fa fa-code me-2"></i> Copy file or director (full path to copy) to (full new path)</li> <li><i class="fa fa-code me-2"></i> Echo to display message</li> <li><i class="fa fa-code me-2"></i> Exist to close cmd</li> <li><i class="fa fa-code me-2"></i> Close  to  browser</li> <li><i class="fa fa-code me-2"></i> Kill me to delete you project</li> <li><i class="fa fa-code me-2"></i> Go to (full path) to go to those path</li> <li><i class="fa fa-code me-2"></i> Help to get help for this cmd</li> <li><i class="fa fa-code me-2"></i> PDT GENERATE CRUD [the name of table] (this will help to create 4 pages and changes the structure.json by adding the file after making backup of in in settings/backup/structure-yyy-mm-dd-hh-ii-ss.json)</li> <li><i class="fa fa-code me-2"></i> PDT GENERATE  ADD|EDIT [the name of table] (this will help to create page of add or edit and  changes the structure.json by adding the file after making backup of in in settings/backup/forms/edit|Add/structure-yyy-mm-dd-hh-ii-ss.json)</li> <li><i class="fa fa-code me-2"></i> PDT GENERATE  SELECT [the name of table] (this will help to create page of add or edit and  changes the structure.json by adding the file after making backup of in in settings/backup/forms/edit|Add/structure-yyy-mm-dd-hh-ii-ss.json)</li> <li><i class="fa fa-code me-2"></i> PDT GENERATE  DELETE [the name of table] (this will help to create page of add or edit and  changes the structure.json by adding the file after making backup of in in settings/backup/forms/edit|Add/structure-yyy-mm-dd-hh-ii-ss.json)</li> <li><i class="fa fa-code me-2"></i> PDT GENERATE  SELECT, DELETE, EDIT, INSERT [the name of table] (this will help to create page the pages according to actions and  changes the structure.json by adding the file after making backup of in in settings/backup/forms/edit|Add|select|create/ structure-yyy-mm-dd-hh-ii-ss.json)</li> <li><i class="fa fa-code me-2"></i> DELETE|UPDATE|SELECT USER, ROLES, ACCESS [username] (from the users table this will be executed)</li> <li><i class="fa fa-code me-2"></i> HISTORY OF TABLE</li> <li><i class="fa fa-code me-2"></i> ANALYSTICS OF TABLE NAME</li> <li><i class="fa fa-code me-2"></i> OPEN PAGE [name from navigation]</li> <li><i class="fa fa-code me-2"></i> REMOVE FUCTIONALITY {the name of functionality example newsletter, file-manger,contact-us}</li> <li><i class="fa fa-code me-2"></i> ADD API {name:\'the name\',Key:\'the key\',DESC:\'description\'}</li> <li><i class="fa fa-code me-2"></i> Open shortcurts</li> <li><i class="fa fa-code me-2"></i> Shortcuts(to show the list of shortcuts)</li> <li><i class="fa fa-code me-2"></i> RUn shortcuts [\'shortcurt\',\'ALT|SHIFT|CTRL + anything\'](to show the list of shortcuts)</li> <li><i class="fa fa-code me-2"></i> CHATBOT OPEN AI BOT</li> <li><i class="fa fa-code me-2"></i> OPEN structure.json (this will open form that can be customizable to change structure.json)</li> <li><i class="fa fa-code me-2"></i> RESTORE structure.json year-month-day</li> <li><i class="fa fa-code me-2"></i> EDIT structure.json year-month-day</li> <li><i class="fa fa-code me-2"></i> OPEN EDITOR</li> <li><i class="fa fa-code me-2"></i> OPEN SQL</li> <li><i class="fa fa-code me-2"></i> OPEN DATABASE</li> <li><i class="fa fa-code me-2"></i> OPEN FILEMANAGER</li> <li><i class="fa fa-code me-2"></i> OPEN .htaccess</li> <li><i class="fa fa-code me-2"></i> OPEN .env</li> </ul>';


    function sendMessage($message = null, $success = 0){
        echo json_encode([
                "message"=>$message,
                'success'=>$success
        ]);
        exit;
    }
    function backup_structure()
    {
        copy('../../app/system/api/structure.json', '../../app/system/settings/backup/structure'.date("Y-m-d.H-i-s").'.json');
    }
    /**
     * CRUD OPERATION 
     */
    class crud
    {
        private $table;
        private $columns;
        private $pk;
        function __construct($table)
        {
            $this->table = $table;
            $this->columns = executeQuery("DESC $this->table")['data'];
            $this->pk = getPk($this->table);
        }

        public function create_all()
        {
            $format_output = format_output($this->columns, '@for
                $likeParts[] = "*Field LIKE ?";
                @end');
            $ths = format_output($this->columns, '@for
                <th>*Field</th>
                @end');
            $chart_data = format_output($this->columns, '@for
                { data: \'*Field\' },
                @end');

            $this->create_file("../crud/analytics/$this->table.php", '<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <?php
// Helper function to get counts for a period
function getCount($pdo, $period) {
    switch($period) {
        case \'today\':
            $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM '.$this->table.' WHERE DATE(created_at) = CURDATE()");
            break;
        case \'yesterday\':
            $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM '.$this->table.' WHERE DATE(created_at) = CURDATE() - INTERVAL 1 DAY");
            break;
        case \'week\':
            $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM '.$this->table.' WHERE YEARWEEK(created_at,1) = YEARWEEK(CURDATE(),1)");
            break;
        case \'last_week\':
            $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM '.$this->table.' WHERE YEARWEEK(created_at,1) = YEARWEEK(CURDATE(),1) - 1");
            break;
        case \'month\':
            $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM '.$this->table.' WHERE MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())");
            break;
        case \'last_month\':
            $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM '.$this->table.' WHERE MONTH(created_at) = MONTH(CURDATE() - INTERVAL 1 MONTH) AND YEAR(created_at) = YEAR(CURDATE() - INTERVAL 1 MONTH)");
            break;
        case \'year\':
            $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM '.$this->table.' WHERE YEAR(created_at) = YEAR(CURDATE())");
            break;
        case \'last_year\':
            $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM '.$this->table.' WHERE YEAR(created_at) = YEAR(CURDATE()) - 1");
            break;
        case \'all\':
        default:
            $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM '.$this->table.'");
            break;
    }

    $stmt->execute();
    return (int)$stmt->fetch()[\'total\'];
}

// Get counts
$today = getCount($pdo,\'today\');
$yesterday = getCount($pdo,\'yesterday\');
$week = getCount($pdo,\'week\');
$last_week = getCount($pdo,\'last_week\');
$month = getCount($pdo,\'month\');
$last_month = getCount($pdo,\'last_month\');
$year = getCount($pdo,\'year\');
$last_year = getCount($pdo,\'last_year\');
$all_'.$this->table.' = getCount($pdo,\'all\');

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
            content: \'▼\';
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
        <h1 class="text-3xl font-bold mb-8 text-gray-800 dark:text-gray-300">'.$this->table.'  Registration Dashboard</h1>
        

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    <!-- Today -->
    <div class="dark:bg-gray-800 bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-lg font-semibold dark:text-gray-300 text-gray-700 mb-2">'.$this->table.' Registered Today</h2>
        <p class="text-3xl font-bold text-red-600"><?= number_format($today) ?></p>
        <p class="text-sm dark:text-gray-200 text-gray-500 mt-1"><?= $today_change >= 0 ? \'+\' : \'\' ?><?= $today_change ?>% rom yesterday</p>
    </div>
    
    <!-- This Week -->
    <div class="dark:bg-gray-800 bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-lg font-semibold dark:text-gray-300 text-gray-700 mb-2">'.$this->table.' This Week</h2>
        <p class="text-3xl font-bold text-green-600"><?= number_format($week) ?></p>
        <p class="text-sm dark:text-gray-200 text-gray-500 mt-1"><?= $week_change >= 0 ? \'+\' : \'\' ?><?= $week_change ?>% rom last week</p>
    </div>
    
    <!-- This Month -->
    <div class="dark:bg-gray-800 bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-lg font-semibold dark:text-gray-300 text-gray-700 mb-2">'.$this->table.' This Month</h2>
        <p class="text-3xl font-bold text-purple-600"><?= number_format($month) ?></p>
        <p class="text-sm dark:text-gray-200 text-gray-500 mt-1"><?= $month_change >= 0 ? \'+\' : \'\' ?><?= $month_change ?>% rom last month</p>
    </div>
    
    <!-- This Year -->
    <div class="dark:bg-gray-800 bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-lg font-semibold dark:text-gray-300 text-gray-700 mb-2">'.$this->table.' This Year</h2>
        <p class="text-3xl font-bold text-orange-600"><?= number_format($year) ?></p>
        <p class="text-sm dark:text-gray-200 text-gray-500 mt-1"><?= $year_change >= 0 ? \'+\' : \'\' ?><?= $year_change ?>% rom last year</p>
    </div>
    
    <!-- All '.$this->table.' -->
    <div class="dark:bg-gray-800 bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-lg font-semibold dark:text-gray-300 text-gray-700 mb-2">All '.$this->table.' (Total)</h2>
        <p class="text-3xl font-bold text-indigo-600"><?= number_format($all_'.$this->table.') ?></p>
        <p class="text-sm dark:text-gray-200 text-gray-500 mt-1">Lifetime total</p>
    </div>
</div>


        
        <!-- Dynamic Chart: '.$this->table.' by Selected Period (Line Chart) -->
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
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-300 mb-4" id="chartTitle">'.$this->table.' Registered by Period</h2>
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
                labels: [\'00:00\', \'04:00\', \'08:00\', \'12:00\', \'16:00\', \'20:00\'],
                data: [5, 15, 30, 25, 20, 5], // Hourly today
                title: \''.$this->table.' Registered Today (Hourly)\'
            },
            week: {
                labels: [\'Mon\', \'Tue\', \'Wed\', \'Thu\', \'Fri\', \'Sat\', \'Sun\'],
                data: [50, 70, 80, 90, 100, 60, 50], // Daily this week
                title: \''.$this->table.' Registered This Week (Daily)\'
            },
            month: {
                labels: [\'Week 1\', \'Week 2\', \'Week 3\', \'Week 4\'],
                data: [400, 500, 600, 500], // Weekly this month
                title: \''.$this->table.' Registered This Month (Weekly)\'
            },
            year: {
                labels: [\'Jan\', \'Feb\', \'Mar\', \'Apr\', \'May\', \'Jun\', \'Jul\', \'Aug\', \'Sep\', \'Oct\', \'Nov\', \'Dec\'],
                data: [500, 600, 800, 900, 1000, 1100, 1200, 900, 800, 700, 600, 900], // Monthly this year (partial)
                title: \''.$this->table.' Registered This Year (Monthly)\'
            },
            years: {
                labels: [\'2019\', \'2020\', \'2021\', \'2022\', \'2023\', \'2024\'],
                data: [3000, 5000, 8000, 12000, 15000, 10000], // Yearly all time
                title: \''.$this->table.' Registered by Year\'
            },
            all: {
                labels: [\'This Year\', \'Prior Years\'],
                data: [10000, 40000], // Total breakdown
                title: \'All '.$this->table.' Breakdown\'
            }
        };

        let currentChart; // To destroy and recreate charts
        let currentBreakdownChart;

        // Initialize charts with default "all" period
        function initCharts(period = \'all\') {
    fetch(`<?= $path?>app/crud/api/dashboard_'.$this->table.'.php?period=${period}`)
        .then(res => res.json())
        .then(data => {
            updateChartTitle(data.title);

            // Dynamic chart
            const ctx = document.getElementById(\'periodChart\').getContext(\'2d\');
            if(currentChart) currentChart.destroy();
            const chartType = (period === \'all\') ? \'pie\' : \'line\';
            currentChart = new Chart(ctx, {
                type: chartType,
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: \''.$this->table.' Registered\',
                        data: data.data,
                        borderColor: \'rgb(59, 130, 246)\',
                        backgroundColor: period === \'all\' ? [\'rgb(59, 130, 246)\', \'rgb(156, 163, 175)\'] : \'rgba(59, 130, 246, 0.1)\',
                        tension: 0.1,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: period === \'all\' ? {} : { y: { beginAtZero: true } },
                    plugins: { legend: { display: period !== \'all\' } }
                }
            });

            // Pie chart
            const pieCtx = document.getElementById(\'breakdownChart\').getContext(\'2d\');
            if(currentBreakdownChart) currentBreakdownChart.destroy();
            currentBreakdownChart = new Chart(pieCtx, {
                type: \'pie\',
                data: {
                    labels: period === \'all\' ? [\'Total '.$this->table.'\', \'Inactive/Other\'] : [\'This Period\',\'Prior Periods\'],
                    datasets: [{
                        data: data.data,
                        backgroundColor: [\'rgb(59, 130, 246)\',\'rgb(156, 163, 175)\']
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });

            document.getElementById(\'pieTitle\').textContent = period === \'all\' ? \'All '.$this->table.' Breakdown\' : `Registration Breakdown (This ${period} vs. Prior)`;
        });
}

        function updateChartTitle(title) {
            document.getElementById(\'chartTitle\').textContent = title;
        }

        function updateBreakdownChart(period) {
            const ctx = document.getElementById(\'breakdownChart\').getContext(\'2d\');
            if (currentBreakdownChart) {
                currentBreakdownChart.destroy();
            }

            let labels = [\'This Period\', \'Prior Periods\'];
            let data = [periodData[period].data.reduce((a, b) => a + b, 0), 50000 - periodData[period].data.reduce((a, b) => a + b, 0)]; // Approximate prior

            if (period === \'all\') {
                labels = [\'Total '.$this->table.'\', \'Inactive/Other\'];
                data = [50000, 0]; // Full total
            }

            currentBreakdownChart = new Chart(ctx, {
                type: \'pie\',
                data: {
                    labels: labels,
                    datasets: [{
                        data: data,
                        backgroundColor: [\'rgb(59, 130, 246)\', \'rgb(156, 163, 175)\'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: \'top\'
                        },
                        title: {
                            display: true,
                            text: period === \'all\' ? \'All '.$this->table.' Total\' : `Breakdown for ${period.charAt(0).toUpperCase() + period.slice(1)}`
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

            document.getElementById(\'pieTitle\').textContent = period === \'all\' ? \'All '.$this->table.' Breakdown\' : `Registration Breakdown (This ${period} vs. Prior)`;
        }

        // Custom Select Functionality
        const selectContainer = document.getElementById(\'periodSelect\');
        const selectButton = document.getElementById(\'selectButton\');
        const selectOptions = document.getElementById(\'selectOptions\');
        const selectedOption = document.getElementById(\'selectedOption\');

        selectButton.addEventListener(\'click\', () => {
            const isOpen = selectContainer.classList.contains(\'open\');
            selectContainer.classList.toggle(\'open\', !isOpen);
            selectOptions.classList.toggle(\'hidden\', isOpen); // For accessibility/fallback
        });

        // Close select when clicking outside
        document.addEventListener(\'click\', (e) => {
            if (!selectContainer.contains(e.target)) {
                selectContainer.classList.remove(\'open\');
                selectOptions.classList.add(\'hidden\');
            }
        });

        // Handle option selection
        selectOptions.querySelectorAll(\'.select-option\').forEach(option => {
            option.addEventListener(\'click\', (e) => {
                e.preventDefault();
                const period = option.dataset.period;
                selectedOption.textContent = option.textContent;
                
                // Update selected class
                selectOptions.querySelectorAll(\'.select-option\').forEach(opt => opt.classList.remove(\'selected\'));
                option.classList.add(\'selected\');
                
                // Close dropdown
                selectContainer.classList.remove(\'open\');
                selectOptions.classList.add(\'hidden\');
                
                // Update charts
                initCharts(period);
            });
        });

        // Initialize with default "all"
        initCharts(\'all\');




    </script>
</div>');



            $this->create_file("../crud/api/dashboard_$this->table.php", '<?php
include_once \'../../system/cogs/db.php\'; 
function getDataByPeriod($pdo, $period) {
    switch($period) {
        case \'day\':
            $stmt = $pdo->prepare("SELECT HOUR(created_at) AS hour, COUNT(*) AS total FROM `'.$this->table.'` WHERE DATE(created_at) = CURDATE() GROUP BY HOUR(created_at) ORDER BY hour");
            $stmt->execute();
            $result = $stmt->fetchAll();
            $labels = [];
            $data = [];
            for ($i = 0; $i < 24; $i+=4) {
                $labels[] = sprintf("%d:00", $i);
                $found = false;
                foreach ($result as $row) {
                    if ((int)$row[\'hour\'] === $i) {
                        $data[] = (int)$row[\'total\'];
                        $found = true;
                        break;
                    }
                }
                if (!$found) $data[] = 0;
            }
            $title = \''.$this->table.' Registered Today (Hourly)\';
            break;

        case \'week\':
            $stmt = $pdo->prepare("SELECT DAYOFWEEK(created_at) AS day, COUNT(*) AS total FROM '.$this->table.' WHERE YEARWEEK(created_at,1) = YEARWEEK(CURDATE(),1) GROUP BY day ORDER BY day");
            $stmt->execute();
            $result = $stmt->fetchAll();
            $labels = [\'Mon\',\'Tue\',\'Wed\',\'Thu\',\'Fri\',\'Sat\',\'Sun\'];
            $data = array_fill(0, 7, 0);
            foreach ($result as $row) {
                $data[$row[\'day\']-2 >=0 ? $row[\'day\']-2 : 6] = (int)$row[\'total\'];
            }
            $title = \''.$this->table.' Registered This Week (Daily)\';
            break;

        case \'month\':
            $stmt = $pdo->prepare("SELECT WEEK(created_at,1) AS week, COUNT(*) AS total FROM '.$this->table.' WHERE MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE()) GROUP BY week ORDER BY week");
            $stmt->execute();
            $result = $stmt->fetchAll();
            $labels = [\'Week 1\',\'Week 2\',\'Week 3\',\'Week 4\'];
            $data = array_fill(0, 4, 0);
            foreach ($result as $row) {
                $w = (int)$row[\'week\'] - (int)date(\'W\', strtotime(date(\'Y-m-01\')));
                if ($w >= 0 && $w < 4) $data[$w] = (int)$row[\'total\'];
            }
            $title = \''.$this->table.' Registered This Month (Weekly)\';
            break;

        case \'year\':
            $stmt = $pdo->prepare("SELECT MONTH(created_at) AS month, COUNT(*) AS total FROM '.$this->table.' WHERE YEAR(created_at) = YEAR(CURDATE()) GROUP BY month ORDER BY month");
            $stmt->execute();
            $result = $stmt->fetchAll();
            $labels = [\'Jan\',\'Feb\',\'Mar\',\'Apr\',\'May\',\'Jun\',\'Jul\',\'Aug\',\'Sep\',\'Oct\',\'Nov\',\'Dec\'];
            $data = array_fill(0, 12, 0);
            foreach ($result as $row) {
                $data[$row[\'month\']-1] = (int)$row[\'total\'];
            }
            $title = \''.$this->table.' Registered This Year (Monthly)\';
            break;

        case \'years\':
            $stmt = $pdo->prepare("SELECT YEAR(created_at) AS year, COUNT(*) AS total FROM '.$this->table.' GROUP BY year ORDER BY year");
            $stmt->execute();
            $result = $stmt->fetchAll();
            $labels = [];
            $data = [];
            foreach ($result as $row) {
                $labels[] = $row[\'year\'];
                $data[] = (int)$row[\'total\'];
            }
            $title = \''.$this->table.' Registered by Year\';
            break;

        case \'all\':
        default:
            $stmt = $pdo->query("SELECT COUNT(*) AS total FROM '.$this->table.'");
            $total = $stmt->fetch()[\'total\'];
            $labels = [\'This Year\',\'Prior Years\'];
            $stmt2 = $pdo->prepare("SELECT COUNT(*) AS total FROM '.$this->table.' WHERE YEAR(created_at) = YEAR(CURDATE())");
            $stmt2->execute();
            $thisYear = $stmt2->fetch()[\'total\'];
            $data = [$thisYear, $total - $thisYear];
            $title = \'All '.$this->table.' Breakdown\';
            break;
    }

    return [\'labels\' => $labels, \'data\' => $data, \'title\' => $title];
}

// Example usage: return JSON for AJAX
if(isset($_GET[\'period\'])) {
    header(\'Content-Type: application/json\');
    echo json_encode(getDataByPeriod($pdo, $_GET[\'period\']));
    exit;
}
?>
');
            $get_trim_post = format_output($this->columns, "@for 
                    \$id = trim(\$_POST['*Field'] ?? '');
                @end");

            $params_with_qoutes = format_output($this->columns, "@for 
                    '*Field',
                @end");
            $params_with_qoutes = rtrim($params_with_qoutes);
            $insert_values = format_output($this->columns, "@for 
                    *Field,
                @end");
            $insert_values = rtrim($insert_values);
            $insert_execute_values = format_output($this->columns, "@for 
                    \$*Field,
                @end");
            $insert_execute_values = rtrim($insert_execute_values);
            $insert_placeholder = format_output($this->columns, "@for 
                    ?,
                @end");
            $insert_placeholder = rtrim($insert_placeholder);


            $update_placeholder = format_output($this->columns, "@for 
                   *Field=?, 
                @end");
            $update_placeholder = rtrim($update_placeholder);

            $execute_insert_with_select_val_u = format_output($this->columns, "@for 
                \$u[\'*Field\'],
                @end");
            $execute_insert_with_select_val_u = rtrim($execute_insert_with_select_val_u);
            $update_array_marge_valiables = format_output($this->columns, "@for 
                \$*Field,
                @end");
            $update_array_marge_valiables = rtrim($update_array_marge_valiables,',');
// Extract column names from $this->columns
            $fields = array_column($this->columns, 'Field'); // gives you ['id', 'name', 'status', ...]
            $column_1 = $fields[0] ?? null;
            $column_2 = $fields[1] ?? null;
            $column_3 = $fields[2] ?? null;
            $column_x = array_slice($this->columns, 3, null, true);
            $pk = getPk($this->table);
            $this->create_file("../crud/fetch/$this->table.php", '
                <?php
  $stmt = $pdo->query("SELECT * FROM '.$this->table.'");
  $'.$this->table.' = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php
$now = new DateTime();
$today = $now->format(\'Y-m-d\');
$thisWeek = $now->format(\'W\');
$thisMonth = $now->format(\'m\');
$thisYear = $now->format(\'Y\');

$counts = [
  \'today\' => 0,
  \'week\' => 0,
  \'month\' => 0,
  \'year\' => 0,
  \'years\' => []
];

foreach ($'.$this->table.' as $item) {
  $createdAt = new DateTime($item[\'created_at\']);
  $itemYear = $createdAt->format(\'Y\');

  if ($createdAt->format(\'Y-m-d\') === $today) {
    $counts[\'today\']++;
  }
  if ($createdAt->format(\'W\') === $thisWeek && $createdAt->format(\'Y\') === $thisYear) {
    $counts[\'week\']++;
  }
  if ($createdAt->format(\'m\') === $thisMonth && $createdAt->format(\'Y\') === $thisYear) {
    $counts[\'month\']++;
  }
  if ($createdAt->format(\'Y\') === $thisYear) {
    $counts[\'year\']++;
  }

  // Grouping by year for the \'years\' dataset
  if (!isset($counts[\'years\'][$itemYear])) {
    $counts[\'years\'][$itemYear] = 0;
  }
  $counts[\'years\'][$itemYear]++;
}
$columns = ['.rtrim(format_output($this->columns,'@for\'*Field\',@end'),',').'];
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

    <h1 class="text-2xl font-bold mb-6 px-8">'.$this->table.'</h1>

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

    <!-- Add '.$this->table.' Button -->
    <a href="#" id="add'.$this->table.'Btn" class="mb-4 ml-8 px-4 py-2 bg-red-500 text-white rounded inline-block">
      Add '.$this->table.'
    </a>

    <!-- Reusable Modal -->
    <div id="'.$this->table.'Modal" class="fixed inset-0 w-full h-full bg-white dark:bg-gray-900 dark:text-white z-50 overflow-y-auto hidden">
      <div class="flex items-center justify-between p-4 border-b dark:border-gray-700">
        <button class="modal-close flex items-center text-gray-700 dark:text-gray-300 hover:text-black dark:hover:text-white">
          <i class="fa fa-arrow-left mr-2"></i> Back
        </button>
        <h2 class="text-xl font-bold" id="modalTitle">'.$this->table.'</h2>
        <span></span>
      </div>
      <div class="p-6 max-w-2xl mx-auto" id="modalContent"></div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto px-8 pt-2">
      <div id="tab-tables">
        <table id="'.$this->table.'Table" class="display min-w-full bg-white rounded shadow w-full text-sm text-left text-gray-700 dark:text-gray-200">
          <thead>
            <tr>
              <th class="border-0 bg-gray-100 px-4 py-4 dark:bg-gray-800 text-left"><input type="checkbox" id="selectAll"></th>
              <th class="border-0 bg-gray-100 px-4 py-4 dark:bg-gray-800 text-left bg-gray-100 dark:bg-gray-800 font-semibold text-gray-700 dark:text-gray-300 px-4 py-3">#</th>
               <?php foreach ($columns as $col): ?>
                  <th class="border-0 bg-gray-100 px-4 py-4 dark:bg-gray-800 text-left bg-gray-100 dark:bg-gray-800 font-semibold text-gray-700 dark:text-gray-300 px-4 py-3"><?= $col ?></th>
                 
               <?php endforeach ?>
               <th class="border-0 bg-gray-100 px-4 py-4 dark:bg-gray-800 text-left bg-gray-100 dark:bg-gray-800 font-semibold text-gray-700 dark:text-gray-300 px-4 py-3">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php $i=1; foreach($'.$this->table.' as $item): ?>
            <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 hover:dark:bg-gray-700">
                <td class="border-0 px-4 py-4 dark:bg-gray-800"><input type="checkbox" class="rowCheckbox" data-id="<?= $item[\'id\'] ?>"></td>

                <td class="border-0 px-4 py-4 dark:bg-gray-800"><?= $i++ ?></td>

                 '.format_output($this->columns, "@for
                    <td class=\"editable\" data-id=\"<?= \$item['$pk'] ?>\" data-field=\"*Field\" data-values=''><?= htmlspecialchars(\$item['*Field']) ?></td>
                    @end").'
                <td class="border-0 px-4 py-4 dark:bg-gray-800">
                  <button class="viewBtn p-2 hover:bg-gray-100 rounded-full" data-id="<?= $item[\''.$pk.'\'] ?>" title="view"><i class="mdi-24px mdi mdi-eye"></i></button>
                  <button class="editBtn p-2 hover:bg-gray-100 rounded-full" data-id="<?= $item[\''.$pk.'\'] ?>" title="edit"><i class="mdi-24px mdi mdi-pen"></i></button>
                  <button class="deleteBtn p-2 hover:bg-gray-100 rounded-full" data-id="<?= $item[\''.$pk.'\'] ?>" title="delete"><i class="mdi-24px mdi mdi-delete"></i></button>
                </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <!-- Charts Tab -->
<div id="tab-charts" class="hidden px-8 pt-4">
  <canvas id="'.$this->table.'Chart" height="120"></canvas>
</div>

<!-- Grid Tab -->
<div id="tab-grid" class="hidden px-8 pt-4">
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
    <?php foreach($'.$this->table.' as $key => $item): ?>
      <div
        class="group bg-white dark:bg-gray-800 rounded-lg shadow-md border border-transparent hover:border-red-500 focus-within:border-red-500 active:border-red-700 transition duration-300 overflow-hidden"
        x-data="{ open: false }"
      >
        <img
          src="<?= htmlspecialchars($item[\'image\'] ?? \'https://placehold.co/600x400\') ?>"
          alt="'.$this->table.' Image"
          class="w-full h-40 object-cover"
        />
        <div class="p-4">
          <h3 class="text-lg font-bold text-red-600"><?= htmlspecialchars($item[\''.$column_1.'\']) ?></h3>
          <p class="text-gray-600 dark:text-gray-300"><?= htmlspecialchars($item[\''.$column_2.'\']??\'\') ?></p>
          <p class="text-sm text-gray-500 dark:text-gray-400">Status: <?= htmlspecialchars($item[\''.$column_3.'\']??\'\') ?></p>

          <div class="mt-4">
            <button
              @click="open = !open"
              class="text-sm text-red-500 hover:text-red-700 focus:outline-none focus:underline"
            >
              <span x-show="!open">More &darr;</span>
              <span x-show="open">Less &uarr;</span>
            </button>

            <div
              x-show="open"
              x-transition
              class="mt-2 text-gray-700 dark:text-gray-300 text-sm"
            >

              '.format_output($column_x,'@for<p><?= htmlspecialchars($item[\'*Field\'] ?? \'\') ?></p> @end').'
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
    <?php foreach($'.$this->table.' as $item): ?>
       
<li class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 hover:border-red-500 transition">
        <div class="flex items-center space-x-4">
          <!-- Optional '.$this->table.' Image -->
          <img
            src="<?= htmlspecialchars($item[\'image\'] ?? \'https://placehold.co/600x400\') ?>"
            alt="Image"
            class="w-10 h-10 rounded-full object-cover"
          />

          <!-- '.$this->table.' Info -->
          <div>
            <p class="font-semibold text-red-600 dark:text-red-400"><?= htmlspecialchars($item[\''.$column_1.'\']) ?></p>
            <p class="font-semibold text-red-600 dark:text-red-400"><?= htmlspecialchars($item[\''.$column_2.'\']) ?></p>
            <p class="font-semibold text-red-600 dark:text-red-400"><?= htmlspecialchars($item[\''.$column_3.'\']) ?></p>







          <div class="mt-4">
            <button
              @click="open = !open"
              class="text-sm text-red-500 hover:text-red-700 focus:outline-none focus:underline"
            >
              <span x-show="!open">More &darr;</span>
              <span x-show="open">Less &uarr;</span>
            </button>

            <div
              x-show="open"
              x-transition
              class="mt-2 text-gray-700 dark:text-gray-300 text-sm"
            >
                '.format_output($column_x,'@for<p><?= htmlspecialchars($item[\'*Field\'] ?? \'\') ?></p> @end').'
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
    <button onclick="window.print()" class="bg-red-500 text-white px-4 py-2 rounded shadow hover:bg-red-600 transition">
      Print this table
    </button>
  </div>

  <!-- Printable Table -->
  <div class="overflow-auto">
    <table id="'.$this->table.'Table" class="min-w-full bg-white rounded shadow text-sm">
      <thead>
        <tr>
          <th class="bg-gray-100 px-4 py-2 text-left dark:bg-gray-800">#</th>
         '.format_output($this->columns,'@for<th class="border-0 bg-gray-100 px-4 py-4 dark:bg-gray-800 text-left bg-gray-100 dark:bg-gray-800 font-semibold text-gray-700 dark:text-gray-300 px-4 py-3">*Field</th> @end').'
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; foreach($'.$this->table.' as $item): ?>
        <tr class="border-t">
          <td class="px-4 py-2 dark:bg-gray-800"><?= $i++ ?></td>
            '.format_output($column_x,'@for<td class="px-4 py-2 dark:bg-gray-800"><?= htmlspecialchars($item[\'*Field\']) ?></td>@end').'
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
      class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:bg-red-50 file:text-red-700 hover:file:bg-red-100"
      required
    />
    <button
      type="submit"
      class="mt-4 bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition"
    >
      Upload
    </button>
  </form>

  <!-- Feedback messages -->
  <div id="importMessage" class="mt-4 text-sm"></div>
</div>


<!-- Export Tab -->
<div id="tab-export" class="hidden px-8 pt-4 h-1/3">
  <a href="<?= $path?>app/crud/api/'.$this->table.'.php?action=export" class="bg-green-500 text-white px-4 py-2 rounded">Export All '.$this->table.'</a>
</div>

<!-- Share Tab -->
<div id="tab-share" class="hidden px-8 pt-4 space-y-6">

</div>

</div>


<script>
$.post(\'<?= $path ?>/app/crud/fetch/widgets/share.php\', function(res){
  $("#tab-share").html(res);
});
$(\'.tabBtn\').on(\'click\', function() {
  var tab = $(this).data(\'tab\');
  
  // Hide all tab contents
  $(\'[id^="tab-"]\').hide();

  // Show selected
  $(\'#tab-\' + tab).fadeIn(150);

  // Optional: Highlight active tab
  $(\'.tabBtn\').removeClass(\'bg-red-500 text-white\').addClass(\'bg-gray-200 dark:bg-gray-700\');
  $(this).addClass(\'bg-red-500 text-white\').removeClass(\'bg-gray-200 dark:bg-gray-700\');
});

$(\'.tabBtn[data-tab="tables"]\').trigger(\'click\');










$(document).ready(function(){
const ctx = document.getElementById(\''.$this->table.'Chart\');
if (ctx) {
  const chart = new Chart(ctx, {
    type: \'bar\',
    data: {
      labels: [
        "Today",
        "This Week",
        "This Month",
        "This Year",
        ...<?= json_encode(array_keys($counts[\'years\'])) ?>
      ],
      datasets: [{
        label: \''.$this->table.' Created\',
        data: [
          <?= $counts[\'today\'] ?>,
          <?= $counts[\'week\'] ?>,
          <?= $counts[\'month\'] ?>,
          <?= $counts[\'year\'] ?>,
          ...<?= json_encode(array_values($counts[\'years\'])) ?>
        ],
        backgroundColor: [
          \'rgba(59, 130, 246, 0.7)\',
          \'rgba(96, 165, 250, 0.7)\',
          \'rgba(147, 197, 253, 0.7)\',
          \'rgba(191, 219, 254, 0.7)\',
          ...Array(<?= count($counts[\'years\']) ?>).fill(\'rgba(59, 130, 246, 0.5)\')
        ],
        borderColor: \'rgba(59, 130, 246, 1)\',
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
          title: { display: true, text: \''.$this->table.' Count\' }
        }
      }
    }
  });
}



  // --- Toast ---
  function showToast(message,type=\'success\'){
    const toast = $(\'<div class="fixed top-5 right-5 p-4 rounded shadow text-white z-50"></div>\');
    toast.text(message).addClass(type===\'success\'?\'bg-green-500\':\'bg-red-500\');
    $(\'body\').append(toast);
    setTimeout(()=> toast.fadeOut(500, ()=> toast.remove()),3000);
  }




$(document).on(\'click\', \'td.editable\', function () {
  let td = $(this);
  if (td.find(\'input, select\').length) return; // Already editing

  let originalValue = td.text().trim();
  let field = td.data(\'field\');
  let id = td.data(\'id\');
  let values = td.data(\'values\');
  let ref = td.data(\'ref\');
  let input;

  if (field === \'enum\') {
    input = $(`
      <select class="w-full p-1 border rounded">
        ${values}
      </select>
    `);
    input.val(originalValue.toLowerCase());
  }else if (field === \'set\') {
    input = $(`
      <select class="w-full p-1 border rounded multiple">
        ${values}
      </select>
    `);
    input.val(originalValue.toLowerCase());
  }else if (field === \'fk\') {
    input = $(`
      <select data-ref="ref" class="w-full p-1 border rounded">
        ${values}
      </select>
    `);
    input.val(originalValue.toLowerCase());
  } else if (field === \'datetime\' || field ===\'timestamp\') {
    input = $(`<input type="datetime-local" class="w-full p-1 border rounded" />`);
    let date = new Date(originalValue);
    let iso = date.toISOString().slice(0, 16); // "YYYY-MM-DDTHH:MM"
    input.val(iso);
  } else if (field === \'time\') {
    input = $(`<input type="time" class="w-full p-1 border rounded" />`);
    let date = new Date(originalValue);
    let iso = date.toISOString().slice(10, 16); // "HH:MM"
    input.val(iso);
  } else if (field === \'date\') {
    input = $(`<input type="date" class="w-full p-1 border rounded" />`);
    let date = new Date(originalValue);
    let iso = date.toISOString().slice(0, 10); // "YYYY-MM-DD"
    input.val(iso);
  } else if (field === \'email\') {
    input = $(`<input type="email" maxlength="${values}" class="w-full p-1 border rounded" value="${originalValue}" />`);
  } else if (field === \'year\') {
    input = $(`<input type="number" maxlength="4" minlength="4" min="1901" max="2155" class="w-full p-1 border rounded" value="${originalValue}" />`);
  } else if (field === \'int\' || field === \'bigint\'  || field === \'mediumint\'  || field === \'tinyint\' ) {
    input = $(`<input type="number" maxlength="${values}" class="w-full p-1 border rounded" value="${originalValue}" />`);
  } else if (field === \'some_number_field\') {
    input = $(`<input type="number" maxlength="${values}" class="w-full p-1 border rounded" value="${originalValue}" />`);
  } else if (field === \'decimal\' || field === \'float\' || field === \'double\') {
    input = $(`<input type="number" maxlength="${values}" step=\'0.0000\' class="w-full p-1 border rounded" value="${originalValue}" />`);
  } else {
    input = $(`<input type="text" maxlength="${values}" class="w-full p-1 border rounded" value="${originalValue}" />`);
  }

  td.html(input);
  input.focus();

  // Save on blur or Enter
  input.on(\'blur keydown\', function (e) {
    if (e.type === \'blur\' || (e.type === \'keydown\' && e.key === \'Enter\')) {
      let newValue = input.val();

      // If datetime, convert to string for DB
      if (field === \'timestamp\' || field === \'datetime\' || field === \'created_at\') {
        newValue = new Date(newValue).toISOString().slice(0, 19).replace(\'T\', \' \');
      }

      $.post(\'<?= $path?>app/crud/api/'.$this->table.'.php\', {
        action: \'inline_update\',
        id: id,
        field: field,
        value: newValue
      }, function (res) {
        if (res.success) {
          showToast(\'Updated\');
          td.text(newValue);
        } else {
          showToast(res.message, \'error\');
          td.text(originalValue); // revert
        }
      }, \'json\').fail((xhr) => {
        alert(JSON.stringify(xhr));
        showToast(\'Server error\', \'error\');
        td.text(originalValue); // revert
      });
    }
  });
});










  // --- Modal open/close ---
  function openModal(title,content){
    $(\'#modalTitle\').text(title);
    $(\'#modalContent\').html(content);
    $(\'#'.$this->table.'Modal\').hide().removeClass(\'hidden\').fadeIn(200);
  }

  $(document).on(\'click\',\'.modal-close\', function(){
    $(\'#'.$this->table.'Modal\').fadeOut(200,function(){ $(this).addClass(\'hidden\'); });
  });

  // --- Add '.$this->table.' ---
  $(\'#add'.$this->table.'Btn\').click(function(e){
    e.preventDefault();
      
    $.post(\'<?= $path?>app/crud/forms/create/'.$this->table.'.php\', function(res){
      if(res){
        openModal(\'Add '.$this->table.'\',res);
      } else showToast(res.message,\'error\');
    }).fail(()=>showToast(\'Server error:Register Data failed \',\'error\'));

  });

  // --- Submit Add ---
  $(document).on(\'submit\',\'#add'.$this->table.'Form\', function(e){
    e.preventDefault();
    $.post(\'<?= $path?>app/crud/api/'.$this->table.'.php\', $(this).serialize()+\'&action=insert\', function(res){
      if(res.success){
        showToast(res.message);
        $(\'#'.$this->table.'Modal\').fadeOut(200,function(){ $(this).addClass(\'hidden\'); });
        // $("#'.$this->table.'Table").load(location.href + " #'.$this->table.'Table");
        window.location.reload();
      } else { showToast(res.message,\'error\'); }
    },\'json\').fail(()=>showToast(\'Server error\',\'error\'));
  });

  // --- Save & Continue ---
  $(document).on(\'click\',\'#saveContinueBtn\', function(){
    $.post(\'<?= $path?>app/crud/api/'.$this->table.'.php\', $(\'#add'.$this->table.'Form\').serialize()+\'&action=insert\', function(res){
      if(res.success){
        showToast(res.message);
        // $("#'.$this->table.'Table").load(location.href + " #'.$this->table.'Table");
        window.location.reload();
        $(\'#add'.$this->table.'Form\')[0].reset();
      } else {showToast(res.message,\'error\');}
    },\'json\').fail(()=>showToast(\'Server error\',\'error\'));
  });

// --- View '.$this->table.' ---
$(document).on(\'click\',\'.viewBtn\', function(){
    let id=$(this).data(\'id\');
    $.post(\'<?= $path?>app/crud/api/'.$this->table.'.php\',{action:\'view\',id}, function(res){
      if(res.success){
        let html = `
          <div class="bg-red-500 text-white p-4 rounded mb-4 text-lg font-semibold">
            '.$this->table.'
          </div>
          <div class="grid grid-cols-2 gap-6 bg-white dark:bg-gray-800 p-6 rounded shadow">
            '.format_output($this->columns,'@for<p class="text-gray-700 dark:text-gray-200"><strong>*Field:</strong> ${res.data.*Field}</p> @end').'
          <div class="flex justify-end mt-4">
            <button type="button" class="modal-close bg-red-500 text-white px-6 py-2 rounded hover:bg-red-600">Close</button>
          </div>
        `;
        openModal(\'View '.$this->table.'\', html);
      } else showToast(res.message,\'error\');
    },\'json\').fail(()=>showToast(\'Server error\',\'error\'));
});


  // --- Edit '.$this->table.' ---
  $(document).on(\'click\',\'.editBtn\', function(){
    let id=$(this).data(\'id\');
    $.get(\'<?= $path?>app/crud/forms/update/'.$this->table.'.php\', {id}, function(res){
        openModal(\'Edit '.$this->table.'\',res);
    }).fail(()=>showToast(\'Server error\',\'error\'));
  });


  // --- Submit Edit ---
  $(document).on(\'submit\',\'#edit'.$this->table.'Form\', function(e){
    e.preventDefault();
    $.post(\'<?= $path?>app/crud/api/'.$this->table.'.php\', $(this).serialize()+\'&action=edit\', function(res){
      if(res.success){
        showToast(res.message);
        $(\'#'.$this->table.'Modal\').fadeOut(200,function(){ $(this).addClass(\'hidden\'); });
        // $("#'.$this->table.'Table").load(location.href + " #'.$this->table.'Table");
        window.location.reload();
      } else showToast(res.message,\'error\');
    },\'json\').fail(()=>showToast(\'Server error\',\'error\'));
  });

  // --- Delete '.$this->table.' ---
  $(document).on(\'click\',\'.deleteBtn\', function(){
    let id=$(this).data(\'id\');
    let html=`
      <p>Are you sure you want to delete this '.$this->table.'?</p>
      <div class="flex justify-end gap-3 mt-4">
        <button id="confirmDeleteBtn" data-id="${id}" class="bg-red-500 text-white px-6 py-2 rounded">Delete</button>
        <button type="button" class="modal-close bg-gray-500 text-white px-6 py-2 rounded">Cancel</button>
      </div>`;
    openModal(\'Confirm Delete\',html);
  });

  $(document).on(\'click\',\'#confirmDeleteBtn\', function(){
    let id=$(this).data(\'id\');
    $.post(\'<?= $path?>app/crud/api/'.$this->table.'.php\',{action:\'delete\',id}, function(res){
      if(res.success){
        showToast(res.message);
        $(\'#'.$this->table.'Modal\').fadeOut(200,function(){ $(this).addClass(\'hidden\'); });
        // $("#'.$this->table.'Table").load(location.href + " #'.$this->table.'Table");
        window.location.reload();
      } else showToast(res.message,\'error\');
    },\'json\').fail(()=>showToast(\'Server error\',\'error\'));
  });











  // --- Bulk Actions ---
$(\'#applyBulkAction\').on(\'click\', function(){
    var action = $(\'#bulkActions\').val();
    var ids = $(\'.rowCheckbox:checked\').map(function(){ return $(this).data(\'id\'); }).get();
    if(!action) return alert(\'Select a bulk action.\');
    if(ids.length === 0) return alert(\'Select at least one row.\');







    if(action === \'copy\'){
        // Bulk Copy: fetch each '.$this->table.' data
        $.post(\'<?= $path?>app/crud/api/'.$this->table.'.php\',{action:\'bulk_view\', ids: ids}, function(res){
            if(res.success){
                let html = \'<form id="bulkCopyForm">\';
                res.data.forEach('.$this->table.' => {
                    html += `
                    <div class="bg-white dark:bg-gray-800 p-4 rounded shadow mb-4">
                        <h3 class="font-bold text-lg mb-2 text-green-500">Copy '.$this->table.'</h3>
                        <input type="hidden" name="ids[]" value="${'.$this->table.'.id}">
                        <div class="grid grid-cols-2 gap-4">
                        '.format_output($this->columns,'@for
                            <div>
                                <label for="*Field">*Field</label>
                                <input type="text" id="*Field" name="*Field[${'.$this->table.'.id}]" value="${'.$this->table.'.*Field}" class="w-full p-2 border rounded mb-2">
                            </div> @end').'
                        </div>
                    </div>
                    `;
                });

                html += `<div class="flex justify-end gap-3 mt-4">
                            <button id="bulkCopySaveBtn" class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600">Save as New</button>
                            <button type="button" class="modal-close bg-gray-500 text-white px-6 py-2 rounded">Cancel</button>
                         </div></form>`;

                openModal(\'Bulk Copy '.$this->table.'\', html);
            } else showToast(res.message,\'error\');
        },\'json\').fail(()=>showToast(\'Server error\',\'error\'));
    }



    else if(action === \'delete\'){
        let html = `<p>Are you sure you want to delete selected '.$this->table.'?</p>
                    <div class="flex justify-end gap-3 mt-4">
                      <button id="bulkDeleteBtn" class="bg-red-500 text-white px-6 py-2 rounded">Delete</button>
                      <button type="button" class="modal-close bg-gray-500 text-white px-6 py-2 rounded">Cancel</button>
                    </div>`;
        openModal(\'Confirm Bulk Delete\', html);
    }


      else if(action === \'view\'){
          $.post(\'<?= $path?>app/crud/api/'.$this->table.'.php\',{action:\'bulk_view\', ids: ids}, function(res){
              if(res.success){
                  let html = \'\';
                  res.data.forEach('.$this->table.' => {
                      html += `<div class="bg-white dark:bg-gray-800 p-4 rounded shadow mb-4">
                                  '.format_output($this->columns,'@for
                                        <p>*Field: ${'.$this->table.'.*Field}</p>
                                    @end').'
                                </div>`;
                  });
                  html += `<div class="flex justify-end mt-4">
                              <button type="button" class="modal-close bg-gray-500 text-white px-6 py-2 rounded">Close</button>
                          </div>`;
                  openModal(\'View '.$this->table.'\', html);
              }
          },\'json\');
      }

      else if(action === \'export\'){
          let idsParam = ids.join(\',\');
          window.location.href = `<?= $path?>app/crud/api/'.$this->table.'.php?action=bulk_export&ids=${idsParam}`;
      }


    else if(action === \'edit\'){
        // Bulk Edit: fetch each '.$this->table.'\'s data
        $.post(\'<?= $path?>app/crud/api/'.$this->table.'.php\',{action:\'bulk_view\', ids: ids}, function(res){
            if(res.success){
                // Create forms for each '.$this->table.'
                let html = \'\';
                res.data.forEach('.$this->table.' => {
                    html += `
                        <div class="bg-white dark:bg-gray-800 p-4 rounded shadow mb-4">
                            <h3 class="font-bold text-lg mb-2 text-red-500">Edit '.$this->table.'</h3>
                            <input type="hidden" name="ids[]" value="${'.$this->table.'.id}">
                            <div class="grid grid-cols-2 gap-4">

                                '.format_output($column_x,'@for
                                        <div>
                                            <label for="*Field" class="block text-gray-700 dark:text-gray-200">*Field</label>
                                            <input type="text" id="*Field" name="*Field[${'.$this->table.'.id}]" value="${'.$this->table.'.*Field}" class="w-full p-2 border rounded mb-2" required>
                                        </div> 
                                    @end').'
        
                            </div>
                        </div>
                    `;
                });

                html += `<div class="flex justify-end gap-3 mt-4">
                            <button id="bulkSaveBtn" class="bg-red-500 text-white px-6 py-2 rounded hover:bg-red-600">Save</button>
                            <button type="button" class="modal-close bg-gray-500 text-white px-6 py-2 rounded">Cancel</button>
                         </div>`;

                openModal(\'Bulk Edit '.$this->table.'\', html);
            } else showToast(res.message,\'error\');
        },\'json\').fail(()=>showToast(\'Server error\',\'error\'));
    } else {
        alert(\'Bulk action not implemented yet.\');
    }
});



$(document).on(\'click\',\'#bulkDeleteBtn\', function(){
    let ids = $(\'.rowCheckbox:checked\').map(function(){ return $(this).data(\'id\'); }).get();
    $.post(\'<?= $path?>app/crud/api/'.$this->table.'.php\',{action:\'bulk_delete\',ids:ids}, function(res){
        if(res.success){
            showToast(res.message);
            $(\'#'.$this->table.'Modal\').fadeOut(200,function(){ $(this).addClass(\'hidden\'); });
            // $("#'.$this->table.'Table").load(location.href + " #'.$this->table.'Table");
            window.location.reload();
        } else showToast(res.message,\'error\');
    },\'json\');
});


$(document).on(\'click\',\'#bulkCopySaveBtn\', function(e){
    e.preventDefault();
    let formData = { action: \'bulk_copy\', ids: [] };
    $(\'#modalContent\').find(\'input[name="ids[]"]\').each(function(){
        formData.ids.push($(this).val());
    });

// Collect all '.$this->table.' fields
const excluded = ['.trim(format_output($this->columns,'@for
    \'*Field\',
    @end'),',').'];

$(\'#modalContent\').find(\'input, select\').each(function() {
    if (!excluded.some(key => this.name.includes(key))) {
        formData[this.name] = $(this).val();
    }
});

    $.post(\'<?= $path?>app/crud/api/'.$this->table.'.php\', formData, function(res){
        if(res.success){
            showToast(res.message);
            $(\'#'.$this->table.'Modal\').fadeOut(200,function(){ $(this).addClass(\'hidden\'); });
            // $("#'.$this->table.'Table").load(location.href + " #'.$this->table.'Table");
            window.location.reload();
        } else {showToast(res.message,\'error\');}
    },\'json\').fail((xhr)=>showToast(JSON.stringify(xhr)+\'Server error\',\'error\'));
});






// --- Save Bulk Edit ---
$(document).on(\'click\',\'#bulkSaveBtn\', function(){
      let formData = { action: \'bulk_edit\', ids: [] };

      $(\'#modalContent\').find(\'input[name="ids[]"]\').each(function(){
          formData.ids.push($(this).val());
      });

    // Collect all '.$this->table.' fields
    const excluded = ['.trim(format_output($this->columns,'@for
    \'*Field\',
    @end'),',').'];

    $(\'#modalContent\').find(\'input, select\').each(function() {
        if (!excluded.some(key => this.name.includes(key))) {
            formData[this.name] = $(this).val();
        }
    });


    formData[\'action\'] = \'bulk_edit\';

    $.post(\'<?= $path?>app/crud/api/'.$this->table.'.php\', formData, function(res){
        if(res.success){
            showToast(res.message);
            $(\'#'.$this->table.'Modal\').fadeOut(200,function(){ $(this).addClass(\'hidden\'); });
            // $("#'.$this->table.'Table").load(location.href + " #'.$this->table.'Table");
            window.location.reload();
        } else showToast(res.message,\'error\');
    },\'json\').fail((xhr)=>showToast(JSON.stringify(xhr)+\':Server error\',\'error\'));
});


// If all individual checkboxes are checked, check header; otherwise, uncheck
$(document).on(\'change\', \'.rowCheckbox\', function() {
    var allChecked = $(\'.rowCheckbox\').length === $(\'.rowCheckbox:checked\').length;
    $(\'#selectAll\').prop(\'checked\', allChecked);
});



// Select/Deselect all checkboxes
$(\'#selectAll\').on(\'change\', function() {
    var checked = $(this).is(\':checked\');
    $(\'.rowCheckbox\').prop(\'checked\', checked);
});


});
</script>


<script>
$(\'#importForm\').on(\'submit\', function(e) {
  e.preventDefault();

  const fileInput = $(\'#importFile\')[0];
  const file = fileInput.files[0];

  // Check if a file is selected
  if (!file) {
    $(\'#importMessage\').html(\'<p class="text-red-500">Please select a file.</p>\');
    return;
  }

  // Validate file type
  const allowedExtensions = [\'csv\', \'sql\'];
  const fileExtension = file.name.split(\'.\').pop().toLowerCase();

  if (!allowedExtensions.includes(fileExtension)) {
    $(\'#importMessage\').html(\'<p class="text-red-500">Only CSV or SQL files are allowed.</p>\');
    return;
  }

  const formData = new FormData(this);

  $.ajax({
    url: \'<?= $path?>app/crud/api/'.$this->table.'.php\',
    type: \'POST\',
    data: formData,
    contentType: false,
    processData: false,
    beforeSend: function() {
      $(\'#importMessage\').html(\'<p class="text-red-500">Uploading...</p>\');
    },
    success: function(response) {
      // alert(response);
      if (response.success) {
       $(\'#importMessage\').html(\'<p class="text-green-600">\' + response.message + \'</p>\');
      }else{
       $(\'#importMessage\').html(\'<p class="text-red-600">\' + response.message + \'</p>\');
      }
    },
    error: function(xhr) {
      $(\'#importMessage\').html(\'<p class="text-red-500">Error: \' + xhr.responseText + \'</p>\');
    }
  });
});
</script>



<script>
$(document).ready(function(){

  // Initialize DataTable
  let table = new DataTable(\'#'.$this->table.'Table\', {
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
    if($(\'html\').hasClass(\'dark\')){
      $(\'#'.$this->table.'Table\').addClass(\'stripe hover text-gray-200 bg-gray-900\');
    } else {
      $(\'#'.$this->table.'Table\').removeClass(\'text-gray-200 bg-gray-900\');
    }
  }

  applyDarkMode();

  // If your site toggles dark mode dynamically, re-apply styles
  const observer = new MutationObserver(applyDarkMode);
  observer.observe(document.documentElement, { attributes: true, attributeFilter: [\'class\'] });

});


$(document).on(\'keydown\', function(event) {
    if (event.key === "Escape" || event.keyCode === 27) {
        $(\'.modal.show\').modal(\'hide\');
    }
});

</script>
');
            $this->create_file("../crud/reports/$this->table.php", '
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>'.$this->table.' Report</title>
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
      <h1>'.$this->table.' — Report</h1>
      <p style="color:#6b7280;font-size:0.9rem;">Auto-generated data report with charts & CSV export</p>
    </div>
    <button id="exportCSV" style="background:#2563EB;color:#fff;padding:0.5rem 1rem;border:none;border-radius:6px;">Export CSV</button>
  </header>

  <div style="background:#fff;border-radius:12px;padding:1rem;box-shadow:0 1px 3px rgba(0,0,0,0.08);overflow-x:auto;">
    <table id="reportTable" class="display">
      <thead>
      <tr>
        '.$ths.'
      </tr>
      </thead>
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
  const table = $(\'#reportTable\').DataTable({
    ajax: {
      url: \'<?= $path ?>app/crud/reports/api/'.$this->table.'.php?ajax=1\',
      dataSrc: \'\'
    },
    columns: [
      '.$chart_data.'    ]
  });

  table.on(\'xhr.dt\', function(e, settings, json, xhr) {
    records = json;
    updateCharts();
  });

  function updateCharts() {    // --- Status Distribution ---
    const statusCounts = {};
    records.forEach(r => statusCounts[r.status] = (statusCounts[r.status] || 0) + 1);
    if (window.statusChartInstance) window.statusChartInstance.destroy();
    window.statusChartInstance = new Chart($(\'#statusChart\'), {
      type: \'pie\',
      data: {
        labels: Object.keys(statusCounts),
        datasets: [{ data: Object.values(statusCounts), backgroundColor: [\'#3B82F6\',\'#10B981\',\'#F59E0B\',\'#EF4444\',\'#8B5CF6\'] }]
      }
    });
    // --- Created Records per Month ---
    const months = [...Array(12).keys()].map(i => {
      const d = new Date(); d.setMonth(d.getMonth() - i);
      return d.toLocaleString(\'default\', { month: \'short\', year: \'numeric\' });
    }).reverse();

    const monthlyCounts = months.map(m => records.filter(r => {
      const date = new Date(r.created_at);
      const label = date.toLocaleString(\'default\', { month: \'short\', year: \'numeric\' });
      return label === m;
    }).length);

    if (window.createdChartInstance) window.createdChartInstance.destroy();
    window.createdChartInstance = new Chart($(\'#createdChart\'), {
      type: \'line\',
      data: { labels: months, datasets: [{ label: \'Records Created\', data: monthlyCounts, borderColor: \'#2563EB\', fill: false }] }
    });  }

  // --- CSV Export ---
  $(\'#exportCSV\').on(\'click\', function() {
    const data = table.rows({ search: \'applied\' }).data().toArray();
    if (!data.length) return;
    const csv = [Object.keys(data[0]).join(\',\')]
      .concat(data.map(r => Object.values(r).join(\',\')))
      .join(\'\n\');
    const blob = new Blob([csv], { type: \'text/csv;charset=utf-8;\' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement(\'a\');
    a.href = url; a.download = \''.$this->table.'-report.csv\'; a.click();
  });
});
</script>

</body>
</html>');
            $this->create_file("../crud/reports/api/$this->table.php", '<?php
// Auto-generated report API for table: '.$this->table.'

require_once \'../../../system/cogs/db.php\';
// Handle AJAX request
if (isset($_GET[\'ajax\'])) {
    header(\'Content-Type: application/json\');

    $query = $_GET[\'query\'] ?? \'\';
    $status = $_GET[\'status\'] ?? \'\';
    $sort = $_GET[\'sort\'] ?? \'\';
    $dir = $_GET[\'dir\'] ?? \'DESC\';

    $sql = "SELECT * FROM `'.$this->table.'`";
    $params = [];
    if ($query) {
        $likeParts = [];
        '.$format_output.'
        $sql .= " AND (" . implode(\' OR \', $likeParts) . ")";
        foreach ($likeParts as $lp) { $params[] = "%$query%"; }
    }
    if ($status) {
        $sql .= " AND status = ?";
        $params[] = $status;
    }
    $allowedSort = [\''.$pk.'\',\'created_at\',\'updated_at\'];
    if (!in_array($sort, $allowedSort)) {
        $sort = $allowedSort[0];
    }
    $dir = strtoupper($dir) === \'ASC\' ? \'ASC\' : \'DESC\';
    $sql .= " ORDER BY $sort $dir";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Optional: Add created_month if created_at exists
    if (in_array(\'created_at\', array_keys($rows[0] ?? []))) {
        foreach ($rows as &$r) {
            $r[\'created_month\'] = date(\'M Y\', strtotime($r[\'created_at\']));
        }
    }

    echo json_encode($rows);
    exit;
}
?>');
        }

        private function create_file($filename='', $content = '')
        {
            return file_put_contents($filename, $content);
        }

        public function create_add_form(){
            $content = generateForm($this->table);
            $this->create_file("../crud/forms/create/$this->table.php", $content);
            return true;
        }

        public function create_update_form(){
                $content = '<?php
$id = $_GET[\'id\'] ?? null;
if (!$id) { die(\'Missing id\'); }
include_once \'../../../system/cogs/functions.php\';$row = fetchData("SELECT * FROM `'.$this->table.'` WHERE `id` = ?", [$id])[0] ?? null;
if (!$row) { die(\'Record not found\'); }
?>
<div class="max-w-3xl mx-auto mt-8 bg-white p-6 rounded-lg shadow-md"><form id="edit'.$this->table.'Form" method="POST" action="/update/'.$this->table.'?id=<?= $id ?>" class="space-y-6">
        
                    ';
                $columns = executeQuery("DESC $this->table")['data'];
                $content .= format_output($this->columns, '@for
                            <div>
                                <label class=\'block text-sm font-medium text-gray-700 mb-1\' for=\'*Field\'>*Field</label>
                                <input type=\'*Type\' id=\'*Field\' name=\'*Field\' required 
                                    value=\'<?= htmlspecialchars($row["*Field"] ?? "") ?>\'
                                     placeholder="Enter *Field" 
                                    
                                    class=\'mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-red-200 focus:border-red-400\' />
                            </div>
                    @end');

                $content .= '
                <div>
            <button type="submit" class="w-full bg-red-600 text-white py-2 rounded hover:bg-red-700 transition">
                Update '.$this->table.'
            </button>
        </div>
    </form>
    </div>';
            $this->create_file("../crud/forms/update/$this->table.php", $content);
            return true;
        }
        public function create_crud_api(){
            $columns = executeQuery("DESC $this->table")['data'];
            $get_trim_post = format_output($this->columns, "@for 
                    \$id = trim(\$_POST['*Field'] ?? '');
                @end");

            $params_with_qoutes = format_output($this->columns, "@for 
                    '*Field',
                @end");
            $params_with_qoutes = rtrim($params_with_qoutes);
            $insert_values = format_output($this->columns, "@for 
                    *Field,
                @end");
            $insert_values = rtrim($insert_values);
            $insert_execute_values = format_output($this->columns, "@for 
                    \$*Field,
                @end");
            $insert_execute_values = rtrim($insert_execute_values);
            $insert_placeholder = format_output($this->columns, "@for 
                    ?,
                @end");
            $insert_placeholder = rtrim($insert_placeholder);


            $update_placeholder = format_output($this->columns, "@for 
                   *Field=?, 
                @end");
            $update_placeholder = rtrim($update_placeholder);

            $execute_insert_with_select_val_u = format_output($this->columns, "@for 
                \$u[\'*Field\'],
                @end");
            $execute_insert_with_select_val_u = rtrim($execute_insert_with_select_val_u);
            $update_array_marge_valiables = format_output($this->columns, "@for 
                \$*Field,
                @end");
            $update_array_marge_valiables = rtrim($update_array_marge_valiables,',');


$pk = getPk($this->table);
$content = '<?php
header(\'Content-Type: application/json\');
include_once \'../../system/cogs/db.php\'; 


if(isset($_GET[\'action\']) && $_GET[\'action\']==\'bulk_export\' && !empty($_GET[\'ids\'])){
    $ids = implode(\',\', array_map(\'intval\', explode(\',\', $_GET[\'ids\'])));
    $stmt = $pdo->query("SELECT * FROM '.$this->table.' WHERE '.$pk.' IN ($ids)");
    $'.$this->table.' = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Export CSV
    header(\'Content-Type: text/csv\');
    header(\'Content-Disposition: attachment;filename='.$this->table.'_export.csv\');
    $output = fopen(\'php://output\',\'w\');
    fputcsv($output, array_keys($'.$this->table.'[0])); // Header row
    foreach($'.$this->table.' as $row){
        fputcsv($output, $row);
    }
    fclose($output);
    exit;
}

if (isset($_GET[\'action\']) && $_GET[\'action\']==\'export\'){
            // export all '.$this->table.' as CSV
            $stmt = $pdo->query("SELECT * FROM '.$this->table.'");
            $'.$this->table.' = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $filename = \''.$this->table.'_export_\'.date(\'Ymd_His\').\'.csv\';
            header(\'Content-Type: text/csv\');
            header(\'Content-Disposition: attachment; filename="\'.$filename.\'"\');
            $out = fopen(\'php://output\', \'w\');
            fputcsv($out, array_keys($'.$this->table.'[0]));
            foreach($'.$this->table.' as $u) fputcsv($out, $u);
            fclose($out);
            exit;

}



$action = $_POST[\'action\'] ?? \'\';
$response = [\'success\' => false, \'message\' => \'Invalid action\'];

// Helper: fetch JSON input for bulk actions
$ids = $_POST[\'ids\'] ?? [];
if(is_string($ids)) $ids = explode(\',\', $ids);

// Helper: validate email
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function isNot($a = []) {
    foreach ($a as $item){
        if(!$item){
            throw new Exception("$item field are required.");
        }
    }
}


function isUnique($table, $field, $value) {
    global $pdo;

    // Basic validation to prevent SQL injection via table/field names
    $allowedChars = \'/^[a-zA-Z0-9_]+$/\';
    if (!preg_match($allowedChars, $table) || !preg_match($allowedChars, $field)) {
        throw new Exception("Invalid table or field name");
    }

    $sql = "SELECT COUNT(*) FROM `$table` WHERE `$field` = :value";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([\':value\' => $value]);

    $count = $stmt->fetchColumn();

    // If count is 0, the value is unique (not found in DB)
    return $count == 0;
}

function isUniqueLoop($table, $data) {
    foreach ($data as $field => $value) {
        if (isUnique($table, $field, $value)) {
            return [
                \'success\' => true,
                \'message\' => "Field \'$field\' with value \'$value\' is unique.",
                \'field\'   => $field,
                \'value\'   => $value
            ];
        }
    }

    // If no field was unique
    return [
        \'success\' => false,
        \'message\' => "No unique fields found.",
        \'field\'   => null,
        \'value\'   => null
    ];
}


function unique_cols($table){
    global $pdo;
    // 2. Get table description
    $stmt = $pdo->query("DESCRIBE `$table`");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 3. Extract only unique columns
    $unique_cols = [];
    foreach ($columns as $col) {
        if ($col[\'Key\'] === \'UNI\') {
            $unique_cols[] = $col[\'Field\'];
        }
    }
    return $unique_cols;
}


function autoIsUniqueChecker($table) {
    global $pdo;

    // 1. Validate table name
    if (!preg_match(\'/^[a-zA-Z0-9_]+$/\', $table)) {
        throw new Exception("Invalid table name.");
    }

    // 2. Get table description
    $stmt = $pdo->query("DESCRIBE `$table`");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 3. Extract only unique columns
    $unique_cols = [];
    foreach ($columns as $col) {
        if ($col[\'Key\'] === \'UNI\') {
            $unique_cols[] = $col[\'Field\'];
        }
    }

    // 4. Filter POST data to keep only fields that are unique in DB
    $data_to_check = [];
    foreach ($_POST as $key => $value) {
        if (in_array($key, $unique_cols, true)) {
            $data_to_check[$key] = $value;
        }
    }

    // 5. If no unique columns in POST, return early
    if (empty($data_to_check)) {
        return [
            \'success\' => true,
            \'message\' => "No unique columns found in POST data to check.",
            \'field\' => null,
            \'value\' => null
        ];
    }

    // 6. Loop through and check each unique column
    foreach ($data_to_check as $field => $value) {
        if (!isUnique($table, $field, $value)) {
            return [
                \'success\' => false,
                \'message\' => "Value \'$value\' for field \'$field\' already exists in table \'$table\'.",
                \'field\' => $field,
                \'value\' => $value
            ];
        }
    }

    // 7. If all unique fields pass
    return [
        \'success\' => true,
        \'message\' => "All unique fields are unique.",
        \'field\' => null,
        \'value\' => null
    ];
}




try {
    switch($action) {

        case \'insert\':
             '.$get_trim_post.'
            isNot(['.$params_with_qoutes.']);
            // Check if column exists
            
            $stmt = $pdo->prepare("INSERT INTO '.$this->table.' ('.$insert_values.') VALUES ('.$insert_placeholder.')");
            if($stmt->execute(['.$insert_execute_values.'])) {
                $response = [\'success\'=>true, \'message\'=>\''.$this->table.' added successfully\', \'id\'=>$pdo->lastInsertId()];
            } else {
                throw new Exception("Failed to insert '.$this->table.'");
            }
            break;

        case \'edit\':
            $id = intval($_POST[\'id\'] ?? \'unknow\');
            '.$get_trim_post.'
        
            isNot(['.$params_with_qoutes.']);
            
            $stmt = $pdo->prepare("UPDATE '.$this->table.' SET '.$update_placeholder.' WHERE '.$pk.'=?");
            if($stmt->execute(['.$insert_execute_values.', '.$pk.'])) {
                $response = [\'success\'=>true, \'message\'=>\''.$this->table.' updated successfully\'];
            } else {
                throw new Exception("Failed to update '.$this->table.'");
            }
            break;

        case \'delete\':
            $id = intval($_POST[\'id\'] ?? \'unknow\');
            if($id == \'unknow\') throw new Exception("Invalid ID");
            $stmt = $pdo->prepare("DELETE FROM '.$this->table.' WHERE '.$pk.'=?");
            if($stmt->execute([$id])) {
                $response = [\'success\'=>true, \'message\'=>\'Data has been removed!\'];
            } else {
                throw new Exception("Failed to delete data with id : $id");
            }
            break;

        case \'view\':
            $id = intval($_POST[\'id\'] ?? \'unknow\');
            if($id == \'unknow\') throw new Exception("Invalid ID");
            $stmt = $pdo->prepare("SELECT * FROM '.$this->table.' WHERE '.$pk.'=?");
            $stmt->execute([$id]);
            $'.$this->table.' = $stmt->fetch(PDO::FETCH_ASSOC);
            if($'.$this->table.') $response = [\'success\'=>true, \'data\'=>$'.$this->table.'];
            else throw new Exception("'.$this->table.' not found");
            break;

        case \'bulk_view\':
            $ids = $_POST[\'ids\']; // array of IDs
            $in  = str_repeat(\'?,\', count($ids) - 1) . \'?\';
            $stmt = $pdo->prepare("SELECT * FROM '.$this->table.' WHERE id IN ($in)");
            $stmt->execute($ids);
            $'.$this->table.' = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode([\'success\'=>true, \'data\'=>$'.$this->table.']);
            exit;

        case \'bulk_edit\':
            foreach($_POST[\'ids\'] as $id){
                $stmt = $pdo->prepare("UPDATE '.$this->table.' SET '.$update_placeholder.' WHERE '.$pk.'=?");
                $stmt->execute(['.$insert_execute_values.' '.$pk.']);
            }
            echo json_encode([\'success\'=>true,\'message\'=>\'Data updated successfully\']);
            exit;

        case \'copy\':
            $id = intval($_POST[\'id\'] ?? \'unknow\');
            if($id == \'unknow\') throw new Exception("Invalid ID");
            $stmt = $pdo->prepare("SELECT * FROM '.$this->table.' WHERE '.$pk.'=?");
            $stmt->execute([$id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if(!$row) throw new Exception("Data not found");

            $stmt = $pdo->prepare("INSERT INTO '.$this->table.' ('.$insert_values.') VALUES ('.$insert_placeholder.')");
            $stmt->execute(['.$insert_execute_values.']);
            $response = [\'success\'=>true, \'message\'=>\'new data is recorded\', \'id\'=>$pdo->lastInsertId()];
            break;
        case \'bulk_copy\':
            if(empty($ids)) throw new Exception("No IDs provided");
            foreach($_POST[\'ids\'] as $id){
                '.$get_trim_post.'
        
                isNot(['.$params_with_qoutes.']);
                
                $stmt = $pdo->prepare("INSERT INTO '.$this->table.' ('.$insert_values.') VALUES ('.$insert_placeholder.')");
                $stmt->execute(['.$insert_execute_values.']);
            }
            $response = [\'success\'=>true,\'message\'=>\'data copied successfully\'];
            break;
        case \'bulk_delete\':
            if(empty($ids)) throw new Exception("No IDs provided");
            $placeholders = implode(\',\', array_fill(0, count($ids), \'?\'));
            $stmt = $pdo->prepare("DELETE FROM '.$this->table.' WHERE id IN ($placeholders)");
            $stmt->execute($ids);
            $response = [\'success\'=>true, \'message\'=>count($ids).\' '.$this->table.' deleted\'];
            break;

        case \'copy_many\':
            if(empty($ids)) throw new Exception("No IDs provided");
            $stmt = $pdo->prepare("SELECT * FROM '.$this->table.' WHERE id IN (".implode(\',\', array_fill(0,count($ids),\'?\')).")");
            $stmt->execute($ids);
            $'.$this->table.' = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($'.$this->table.' as $u){
                $stmt2 = $pdo->prepare("INSERT INTO '.$this->table.' ('.$insert_values.') VALUES ('.$insert_placeholder.')");
                $stmt2->execute(['.$execute_insert_with_select_val_u.']);
            }
            $response = [\'success\'=>true, \'message\'=>count($'.$this->table.').\' data copied (registed)\'];
            break;
            case \'import\':
                    if (!isset($_FILES[\'file\']) || $_FILES[\'file\'][\'error\'] !== UPLOAD_ERR_OK) {
                        http_response_code(400);
                        echo \'File upload failed.\';
                        exit;
                    }

                    $file = $_FILES[\'file\'];
                    $ext = strtolower(pathinfo($file[\'name\'], PATHINFO_EXTENSION));

                    if (!in_array($ext, [\'csv\', \'sql\'])) {
                        http_response_code(400);
                        echo \'Invalid file type. Only CSV and SQL files are allowed.\';
                        exit;
                    }

                    // Save file to temporary location (you can change this path)
                    $uploadDir = \'../../system/filemanager/imports/\';
                    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

                    $destination = $uploadDir . basename($file[\'name\']);
                    if (move_uploaded_file($file[\'tmp_name\'], $destination)) {
                        $response = [\'success\'=>true, \'message\'=>\'File uploaded successfully: \' . htmlspecialchars($file[\'name\'])];
                    // =========================
                    // Handle SQL file
                    // =========================
                    if ($ext === \'sql\') {
                        try {
                            $sql = file_get_contents($destination);
                            $pdo->exec($sql);
                            $response = [\'success\'=>false, \'message\'=>\'SQL file imported successfully.\'];
                        } catch (PDOException $e) {
                            http_response_code(500);
                            $response = [\'success\'=>false, \'message\'=>\'SQL import error: \' . $e->getMessage()];
                        }
                        exit;
                    }

                    // =========================
                    //  Handle CSV file
                    // =========================
                    if ($ext === \'csv\') {
                        $handle = fopen($destination, \'r\');
                        if ($handle === false) {
                            http_response_code(500);
                            $response = [\'success\'=>false, \'message\'=>\'Could not open CSV file.\'];
                            exit;
                        }

                        $headers = fgetcsv($handle); // First row: column headers
                        if (!$headers) {
                            http_response_code(400);
                            $response = [\'success\'=>false, \'message\'=>\'Invalid CSV format, first row must be header.\'];
                            exit;
                        }

                        // Prepare insert query dynamically based on headers
                        $placeholders = implode(\', \', array_fill(0, count($headers), \'?\'));
                        $columns = implode(\', \', array_map(fn($h) => "`" . trim($h) . "`", $headers));
                        $stmt = $pdo->prepare("INSERT INTO '.$this->table.' ($columns) VALUES ($placeholders)");

                        $rowCount = 0;
                        while (($row = fgetcsv($handle)) !== false) {
                            // Skip empty rows
                            if (count(array_filter($row)) === 0) continue;

                            try {
                                $stmt->execute($row);
                                $rowCount++;
                            } catch (PDOException $e) {
                                $response = [\'success\'=>false, \'message\'=>"To import please your file  must be sql(insert) or csv(first row is header). "];
                            }
                        }

                    } else {
                        http_response_code(500);
                        $response = [\'success\'=>false, \'message\'=>\'Failed to move uploaded file.\'];
                    }
                }

            break;
        case \'update_many\':
            if(empty($ids)) throw new Exception("No IDs provided");
            '.$get_trim_post.'
        
            if(!$status) throw new Exception("all field with * is required.");
            $stmt = $pdo->prepare("UPDATE '.$this->table.' SET '.$update_placeholder.' WHERE id IN (".implode(\',\', array_fill(0,count($ids),\'?\')).")");
            $stmt->execute(array_merge(['.$update_array_marge_valiables.' ], $ids));
            $response = [\'success\'=>true, \'message\'=>count($ids).\' data updated in '.$this->table.'\'];
            break;
        case \'inline_update\':
            $id = intval($_POST[\'id\']);
            $field = $_POST[\'field\'];
            $value = $_POST[\'value\'];

            $allowed_fields = ['.$params_with_qoutes.'];
            if (!in_array($field, $allowed_fields)) {
                echo json_encode([\'success\' => false, \'message\' => \'Invalid field\']);
                exit;
            }

            $unique = isUniqueLoop(\''.$this->table.'\',[$field=>$value]);

            $unique_cols = unique_cols(\''.$this->table.'\'); 
            if (in_array($field, $unique_cols)) {
                $unique = isUnique($table, $field, $value);
            }else{
                $unique = false;
            }

            if ($unique) {
                echo json_encode([\'message\' => $field." exists",\'success\' => false]);
                exit;
            }else{
                $stmt = $pdo->prepare("UPDATE '.$this->table.' SET `$field` = :value WHERE id = :id");
                $success = $stmt->execute([\'value\' => $value, \'id\' => $id]);
                echo json_encode([\'message\' => \'Data updated\',\'success\' => $success]);
                
               exit;
            }
            
        default:
            throw new Exception("Unknown action");

    }

} catch(Exception $e){
    $response = [\'success\'=>false, \'message\'=>$e->getMessage()];
}

echo json_encode($response);
?>
                    ';
            $this->create_file("../crud/api/$this->table.php", $content);
            return true;
        }
    }


    $message = '';$success = '';
    if(isset($_POST['input']) || isset($_GET['input'])){
        $request = strtolower($_POST['input']??$_GET['input']??'');
        if (empty($request)) {
            sendMessage("Request Something", false);
        }else{
                // Assume $request contains the input command string

                    if (preg_match('/^PDT GENERATE CRUD\s+/i', $request)) {
                        $remaining = preg_replace('/^PDT GENERATE CRUD\s+/i', '', $request);

                        $table = rtrim($remaining,';');
                        backup_structure();
                        $crud = new crud($table);
                        $crud->create_add_form();
                        $crud->create_update_form();
                        $crud->create_crud_api();
                        $crud->create_all();
                        sendMessage("PDT GENERATE CRUD DONE", 1);

                    } elseif (preg_match('/^PDT GENERATE ADD\|EDIT\s+/i', $request)) {
                        $remaining = preg_replace('/^PDT GENERATE ADD\|EDIT\s+/i', '', $request);
                        sendMessage($remaining, 1);

                    } elseif (preg_match('/^PDT GENERATE SELECT\s+/i', $request)) {
                        $remaining = preg_replace('/^PDT GENERATE SELECT\s+/i', '', $request);
                        sendMessage($remaining, 1);

                    } elseif (preg_match('/^PDT GENERATE DELETE\s+/i', $request)) {
                        $remaining = preg_replace('/^PDT GENERATE DELETE\s+/i', '', $request);
                        sendMessage($remaining, 1);

                    } elseif (preg_match('/^PDT GENERATE SELECT,\s*DELETE,\s*EDIT,\s*INSERT\s+/i', $request)) {
                        $remaining = preg_replace('/^PDT GENERATE SELECT,\s*DELETE,\s*EDIT,\s*INSERT\s+/i', '', $request);
                        sendMessage($remaining, 1);

                    } elseif (preg_match('/^(DELETE|UPDATE|SELECT)\s+USER,\s*ROLES,\s*ACCESS\s+/i', $request)) {
                        $remaining = preg_replace('/^(DELETE|UPDATE|SELECT)\s+USER,\s*ROLES,\s*ACCESS\s+/i', '', $request);
                        sendMessage($remaining, 1);

                    } elseif (preg_match('/^HISTORY OF TABLE\s*/i', $request)) {
                        $remaining = preg_replace('/^HISTORY OF TABLE\s*/i', '', $request);
                        sendMessage($remaining, 1);

                    } elseif (preg_match('/^ANALYSTICS OF TABLE\s*/i', $request)) {
                        $remaining = preg_replace('/^ANALYSTICS OF TABLE\s*/i', '', $request);
                        sendMessage($remaining, 1);

                    } elseif (preg_match('/^OPEN PAGE\s+/i', $request)) {
                        $remaining = preg_replace('/^OPEN PAGE\s+/i', '', $request);
                        sendMessage($remaining, 1);

                    } elseif (preg_match('/^REMOVE FUNCTIONALITY\s+/i', $request)) {
                        $remaining = preg_replace('/^REMOVE FUNCTIONALITY\s+/i', '', $request);
                        sendMessage($remaining, 1);

                    } elseif (preg_match('/^ADD API\s+/i', $request)) {
                        $remaining = preg_replace('/^ADD API\s+/i', '', $request);
                        sendMessage($remaining, 1);

                    } elseif (preg_match('/^OPEN SHORTCURTS$/i', $request)) {
                        $remaining = preg_replace('/^OPEN SHORTCURTS$/i', '', $request);
                        sendMessage($remaining, 1);

                    } elseif (preg_match('/^SHORTCUTS$/i', $request)) {
                        $remaining = preg_replace('/^SHORTCUTS$/i', '', $request);
                        sendMessage($remaining, 1);

                    } elseif (preg_match('/^RUN SHORTCURTS\s+\[.*\]$/i', $request)) {
                        $remaining = preg_replace('/^RUN SHORTCURTS\s+/i', '', $request);
                        sendMessage($remaining, 1);

                    } elseif (preg_match('/^CHATBOT OPEN AI BOT$/i', $request)) {
                        $remaining = preg_replace('/^CHATBOT OPEN AI BOT$/i', '', $request);
                        sendMessage($remaining, 1);

                    } elseif (preg_match('/^OPEN structure\.json$/i', $request)) {
                        $remaining = preg_replace('/^OPEN structure\.json$/i', '', $request);
                        sendMessage($remaining, 1);

                    } elseif (preg_match('/^RESTORE structure\.json\s+\d{4}-\d{2}-\d{2}$/i', $request)) {
                        $remaining = preg_replace('/^RESTORE structure\.json\s+/i', '', $request);
                        sendMessage($remaining, 1);

                    } elseif (preg_match('/^EDIT structure\.json\s+\d{4}-\d{2}-\d{2}$/i', $request)) {
                        $remaining = preg_replace('/^EDIT structure\.json\s+/i', '', $request);
                        sendMessage($remaining, 1);

                    }elseif (in_array($request, ['help', 'exit', 'close'])) {
                        switch ($request) {
                            case 'help':
                                sendMessage($help, true);
                                break;
                            case 'exit':
                                sendMessage('<a class="p-2 bg-red-200 rounded shadow text-gray-600" href="'.$path.'" onclick="return confirm(\'Are you sure you want to close this tab\')">Close this Tab</a><script>window.close();</scrip>', true);
                                break;
                            case 'close':
                                sendMessage('<a class="p-2 bg-red-200 rounded shadow text-gray-600" href="https://example.com" onclick="return confirm(\'Are you sure you want to close this browser\')">Close this Browser</a>', true);
                                break;
                                break;
                            default:
                                sendMessage("Invalid keyword try 'help', 'exit', 'close'", false);
                                break;
                        }
            }elseif (preg_match("/^open .(env|htaccess)+$/", $request)) {
               $txt = str_replace('open ', '', $request);
               $url = $path.$txt;
               sendMessage('<script>window.open("'.$url.'","_blank",`width=500px,height=500px,left=20px,top=20px,resizable=yes,scrollbars=yes`)</script>', true); 
            }elseif (preg_match("/^echo|print\s(.+)$/", $request)) {
               $txt = str_replace('echo ', '', $request);
               $txt = str_replace('print ', '', $request);
               $txt = trim($txt);
               sendMessage($txt, true); 
            }elseif (preg_match("/^open:\s*/i", $request)) {
               $txt = preg_replace("/^open:\s*/i", '', $request);
               $url = $path."s/$txt";
               sendMessage('<script>window.open("'.$url.'","_blank")</script>', true);

            }elseif (preg_match("/^create\s(file|folder|page|dir)\s(.+)$/", $request)) {
               $url = preg_replace("/^create\s(file|folder|page|dir)\s*/i", '', $request);
               $url = trim($url);
               if (preg_match("/^create\sfile\s*/", $request)) {
                    if (!file_exists("../../$url")) {
                        if(file_put_contents("../../$url", '')) sendMessage('<i>📄</i>File '.$url.' created',1); 
                        else sendMessage('<i>📄</i>File '.$url.' not created',0); 
                    }else{
                        sendMessage('<i>📄</i>File '.$url.' Exists',0); 
                    }
               }else{
                   

                    if (!file_exists("../../$url")) {
                         if(mkdir("../../$url")){
                            sendMessage('<i>📂</i>Directory '.$url.' created',1);
                        }else{
                            sendMessage('<i>📂</i>Directory '.$url.' not created',0);
                        } 
                    }else{
                        sendMessage('<i>📂</i>Directory '.$url.' Exists',0); 
                    }
               }
            }elseif (preg_match("/^(delete|del)\s+(file|folder|dir|directory|repository)\s*/i", $request)) {
    // Remove the matched "delete/del file/folder/..." prefix
    $url = preg_replace("/^(delete|del)\s+(file|folder|dir|directory|repository)\s*/i", '', $request);

    // Trim any leftover whitespace
    $url = trim($url);


               if (preg_match("/^(delete|del)\s+(file)\s*/i", $request)) {
                    if (file_exists("../../$url")) {
                        if(unlink("../../$url")) sendMessage('<i>📄</i>File '.$url.' removed',1); 
                        else sendMessage('<i>📄</i>File '.$url.' not deleted',0); 
                    }else{
                        sendMessage('<i>📄</i>File '.$url.' not found',0); 
                    }
               }else{
                    if (file_exists("../../$url")) {
                         if(deleteFolder("../../$url")){
                            sendMessage('<i>📂</i>Directory '.$url.' deleted',1);
                        }else{
                            sendMessage('<i>📂</i>Directory '.$url.' not deleted',0);
                        }
                    }else{
                        sendMessage('<i>📂</i>Directory '.$url.' Not Exists',0); 
                    }
               }

}elseif (preg_match("/^(mkdir)\s*/i", $request)) {
    // Remove the matched "delete/del file/folder/..." prefix
    $url = preg_replace("/^(mkdir)\s*/i", '', $request);
    // Trim any leftover whitespace
    $url = trim($url);
    if (!file_exists("../../$url")) {
         if(mkdir("../../$url")){
            sendMessage('<i>📂</i>Directory '.$url.' created',1);
        }else{
            sendMessage('<i>📂</i>Directory '.$url.' not created',0);
        }
    }else{
        sendMessage('<i>📂</i>Directory '.$url.' Not Exists',0); 
    }

}elseif (preg_match("/^sql:\s*/i", $request)) {
               include '../system/cogs/db.php';
               $query = preg_replace("/^sql:\s*/i", '', $request);
                if (empty($query)) {
                    sendMessage('<strong>🗨️</strong>Query can not be empty');
                    exit;
                }

                // Split queries by semicolon ; and remove empty entries
                $queries = array_filter(array_map('trim', explode(';', $query)));

                $message_container = '';
                $data_container = '';

                foreach ($queries as $q) {
                    if (empty($q)) continue;

                    try {
                        // Check if query returns data (SELECT, SHOW, DESCRIBE, EXPLAIN)
                        if (preg_match('/^(select|show|desc|describe|explain)/i', $q)) {
                            $stmt = $pdo->query($q);
                            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            $json_data = htmlspecialchars(json_encode($data, JSON_PRETTY_PRINT));

                            // Build table header and rows
                            if (!empty($data)) {
                                $headers = array_keys($data[0]);
                                $table = '<table class="shadow bg-white dark:bg-gray-900 text-gray-900 dark:text-white my-5 border-collapse w-full">';
                                $table .= '<thead><tr>';
                                foreach ($headers as $h) {
                                    $table .= "<th class='border dark:border-gray-600 px-4 py-2'>{$h}</th>";
                                }
                                $table .= '</tr></thead><tbody>';
                                foreach ($data as $row) {
                                    $table .= '<tr>';
                                    foreach ($row as $cell) {
                                        $table .= "<td class='border dark:border-gray-600 px-4 py-2'>{$cell}</td>";
                                    }
                                    $table .= '</tr>';
                                }
                                $table .= '</tbody></table>';
                            } else {
                                $table = '<p>No data returned.</p>';
                            }

                            $data_container .= "
                            <details class='relative border dark:border-gray-600 p-4 rounded shadow my-5 bg-white dark:bg-gray-900'>
                                <summary class='cursor-pointer font-semibold flex justify-between'>
                                   <div><strong>Query:</strong> <code>{$q}</code></div>
                                    <button onclick='this.closest(\"details\").remove()' class='ml-4 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-white rounded px-2 py-1'>×</button>
                                </summary>
                                <div class='mt-2'>
                                    <details>
                                        <summary class='cursor-pointer'>Json output</summary>
                                        <div>
                                            <pre class='overflow-x-auto'><code>data: {$json_data}</code></pre>
                                        </div>
                                    </details>
                                    <details>
                                        <summary class='cursor-pointer'>Table</summary>
                                        <div>
                                            {$table}
                                        </div>
                                    </details>
                                    
                                </div>
                            </details>
                            ";

                        } else {
                            $rows = $pdo->exec($q);
                            $message_container .= "
                                <div class='relative border dark:border-gray-600 p-4 rounded shadow my-5 bg-white dark:bg-gray-900'>
                                    <button onclick='this.parentElement.remove()' class='absolute top-2 right-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-white rounded px-2 py-1'>×</button>
                                    <strong>Query:</strong> <code>{$q}</code>
                                    <p>😀 Query executed successfully. Rows affected: {$rows}</p>
                                </div>
                            ";
                        }
                    } catch (PDOException $e) {
                        $message_container .= "
                            <div class='relative border dark:border-gray-600 p-4 rounded shadow my-5 bg-red-100 dark:bg-red-800'>
                                <button onclick='this.parentElement.remove()' class='absolute top-2 right-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-white rounded px-2 py-1'>×</button>
                                <strong>Query:</strong> <code>{$q}</code>
                                <p>❌ Error: {$e->getMessage()}</p>
                            </div>
                        ";
                    }
                }

                // Send both containers together
                sendMessage($message_container . $data_container, true);
            }elseif (preg_match("/^goto .(.+)$/", $request)) {
               $txt = str_replace('goto ', '', $request);
               $url = $path.$txt;
               sendMessage('<script>window.open("'.$url.'","_blank")</script>', true); 
}elseif (preg_match("/^(copy)\s+(file|folder|dir|directory)\s+/i", $request)) {
    // Example: copy file /path/source.txt to /path/dest.txt

    // Remove leading command (copy file/folder/dir/directory)
    $clean = preg_replace("/^(copy)\s+(file|folder|dir|directory|repository)\s+/i", '', $request);

    // Split by the keyword "to"
    $parts = preg_split("/\s+to\s+/i", $clean);

    if (count($parts) === 2) {
        $source = trim($parts[0]);
        $source = "../../$source";
        $destination = trim($parts[1]);
        $destination = "../../$destination";
        if (is_dir($source)) {
            // Use your existing folder copy function
            copyFolder($source, $destination);
            sendMessage("📁 Folder copied from <code>{$source}</code> to <code>{$destination}</code> successfully.", 1);
        } elseif (is_file($source)) {
            // Copy single file
            if (copy($source, $destination)) {
                sendMessage("📄 File copied from <code>{$source}</code> to <code>{$destination}</code> successfully.", 1);
            } else {
                sendMessage("❌ Failed to copy file from <code>{$source}</code> to <code>{$destination}</code>.", 0);
            }
        } else {
            sendMessage("⚠️ Source path <code>{$source}</code> not found.", 0);
        }
    } else {
        sendMessage("❌ Invalid syntax. Use: <br><code>copy file [source] to [destination]</code>", 0);
    }
}elseif (preg_match("/^open (editor|sql|database|filemanagereditor|sql|database|filemanager|dashboard|search|create|content|analytics|history|profile|settings|explore|report|help|feedback|query|cmd)+$/", $request)) {
        $txt = str_replace('open ', '', $request);
        if ($txt == 'sql') $txt = 'query';
       $url = $path.'s/'.$txt;
       sendMessage('<script>window.open("'.$url.'","_blank")</script>', true); 
}else{
    sendMessage('Invalid request', true);
}
  }
}else{
    sendMessage("Bad Request", false);
}
?>
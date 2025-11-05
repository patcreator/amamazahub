<?php
include_once '../../system/cogs/db.php'; 
function getDataByPeriod($pdo, $period) {
    switch($period) {
        case 'day':
            $stmt = $pdo->prepare("SELECT HOUR(created_at) AS hour, COUNT(*) AS total FROM `user_profile` WHERE DATE(created_at) = CURDATE() GROUP BY HOUR(created_at) ORDER BY hour");
            $stmt->execute();
            $result = $stmt->fetchAll();
            $labels = [];
            $data = [];
            for ($i = 0; $i < 24; $i+=4) {
                $labels[] = sprintf("%d:00", $i);
                $found = false;
                foreach ($result as $row) {
                    if ((int)$row['hour'] === $i) {
                        $data[] = (int)$row['total'];
                        $found = true;
                        break;
                    }
                }
                if (!$found) $data[] = 0;
            }
            $title = 'user_profile Registered Today (Hourly)';
            break;

        case 'week':
            $stmt = $pdo->prepare("SELECT DAYOFWEEK(created_at) AS day, COUNT(*) AS total FROM user_profile WHERE YEARWEEK(created_at,1) = YEARWEEK(CURDATE(),1) GROUP BY day ORDER BY day");
            $stmt->execute();
            $result = $stmt->fetchAll();
            $labels = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];
            $data = array_fill(0, 7, 0);
            foreach ($result as $row) {
                $data[$row['day']-2 >=0 ? $row['day']-2 : 6] = (int)$row['total'];
            }
            $title = 'user_profile Registered This Week (Daily)';
            break;

        case 'month':
            $stmt = $pdo->prepare("SELECT WEEK(created_at,1) AS week, COUNT(*) AS total FROM user_profile WHERE MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE()) GROUP BY week ORDER BY week");
            $stmt->execute();
            $result = $stmt->fetchAll();
            $labels = ['Week 1','Week 2','Week 3','Week 4'];
            $data = array_fill(0, 4, 0);
            foreach ($result as $row) {
                $w = (int)$row['week'] - (int)date('W', strtotime(date('Y-m-01')));
                if ($w >= 0 && $w < 4) $data[$w] = (int)$row['total'];
            }
            $title = 'user_profile Registered This Month (Weekly)';
            break;

        case 'year':
            $stmt = $pdo->prepare("SELECT MONTH(created_at) AS month, COUNT(*) AS total FROM user_profile WHERE YEAR(created_at) = YEAR(CURDATE()) GROUP BY month ORDER BY month");
            $stmt->execute();
            $result = $stmt->fetchAll();
            $labels = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
            $data = array_fill(0, 12, 0);
            foreach ($result as $row) {
                $data[$row['month']-1] = (int)$row['total'];
            }
            $title = 'user_profile Registered This Year (Monthly)';
            break;

        case 'years':
            $stmt = $pdo->prepare("SELECT YEAR(created_at) AS year, COUNT(*) AS total FROM user_profile GROUP BY year ORDER BY year");
            $stmt->execute();
            $result = $stmt->fetchAll();
            $labels = [];
            $data = [];
            foreach ($result as $row) {
                $labels[] = $row['year'];
                $data[] = (int)$row['total'];
            }
            $title = 'user_profile Registered by Year';
            break;

        case 'all':
        default:
            $stmt = $pdo->query("SELECT COUNT(*) AS total FROM user_profile");
            $total = $stmt->fetch()['total'];
            $labels = ['This Year','Prior Years'];
            $stmt2 = $pdo->prepare("SELECT COUNT(*) AS total FROM user_profile WHERE YEAR(created_at) = YEAR(CURDATE())");
            $stmt2->execute();
            $thisYear = $stmt2->fetch()['total'];
            $data = [$thisYear, $total - $thisYear];
            $title = 'All user_profile Breakdown';
            break;
    }

    return ['labels' => $labels, 'data' => $data, 'title' => $title];
}

// Example usage: return JSON for AJAX
if(isset($_GET['period'])) {
    header('Content-Type: application/json');
    echo json_encode(getDataByPeriod($pdo, $_GET['period']));
    exit;
}
?>

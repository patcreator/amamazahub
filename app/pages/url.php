 <?php
    $page = $_GET['page'] ?? 'Dashboard';
    $allowed_pages = ['s/Dashboard', 's/Search', 's/Create', 's/Content', 's/Analytics', 's/History', 's/Profile', 's/Settings', 's/Explore', 's/Report', 's/Help', 's/feedback', 's/sql-runner'];
    if (in_array($page, $allowed_pages)) {
        $page = strtolower($page);
        if($page==='s/dashboard'){
            if file_exists("$page.php") include_once "$page.php";
            elseif file_exists("$page.html") include_once "$page.html";
            else echo "<div class='p-6 text-center'>$page Page not found</div>";
        }else{
            if file_exists("$page.php") include_once "$page.php";
            elseif file_exists("$page.html") include_once "$page.html";
            else echo "<div class='p-6 text-center'>$page Page not found</div>";
        }
    } else {
        http_response_code(404);
        echo "<div class='p-6 text-center'>$page Page not found</div>";
    }
?> 
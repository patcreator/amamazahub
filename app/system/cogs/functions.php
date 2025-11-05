<?php
function login($pdo = null, $username = null, $password = null){
    if (empty($pdo) || empty($username) || empty($password)) {
        return sendMessage('They are missing data', 0);
    } else {
        if(!preg_match("/[a-zA-Z0-9\.\-\@\_]{3,}/",$username)){
            return sendMessage('Username only letters, number are allowed', 0);
            exit;
        }
        $stmt = $pdo->prepare("SELECT id from users where username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if($user && password_verify($password, $user['password'])){
            return sendMessage('You are logged in ', 1,['redirect'=>'/']);
        }else{
            return sendMessage('Invalid username or password', 0);
        }
    }
    
}


function connect(){
    include_once  'db.php';
    global $pdo;
    return $pdo;
}
function error_message(){
    return '<div class="p-2 shadow mx-auto w-1/4 mt-2">
                    <p class="text-3xl  text-center text-gray-400 mx-auto flex justify-center items-center flex-col font-lighter h[150px]"><i class="fa text-4xl text-red-500 fa-exclamation-triangle"></i>Something went wrong</p>
                </div>';;
}
function signup($pdo = null, ...$data){
    if (empty($pdo) || empty($data)) {
        return sendMessage('They are missing data', 0);
    } else {

        $stmt = $pdo->prepare("Insert from users where username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if($user && password_verify($password, $user['password'])){
            return sendMessage('You are logged in ', 1,['redirect'=>'/']);
        }else{
            return sendMessage('Invalid username or password', 0);
        }
    }
    
}
function fetchData($sql, $params){
    include_once "db.php";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $stmt = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $stmt;
}

?>

<?php
    function sm_str($str,$len = 10)
    {
        if (strlen($str) > $len) {
            return substr($str, 0,$len)."...";
        }else{
            return $str;
        }
    }
    function x_pre_print_r($array,$die = 0){
        echo "<pre>";
           print_r($array);
        echo "</pre>";
        echo "<br />_________________________Array values___________________________<br />";
        if ($die) {
            die();
        }
     }

     function isDateValid($date) {
    $parts = explode('-', $date); // Assume format is Y-m-d
    if (count($parts) === 3) {
        [$year, $month, $day] = $parts;
        return checkdate((int)$month, (int)$day, (int)$year);
    }
    return false;
}

/*change language using this*/
    function __setLang__($lang){
        $_SESSION['current_lang'] = $lang;
    }

    /*capitalize First letter in sentent */
    function __upcase_1_letter ($lang_array)
    {
        foreach ($lang_array as $key => $value) {
            $newArray[ucfirst($key)] = ucfirst($value); 
        }
        return $newArray;
    }
    

function __create_lang()
{
        /*language*/
    if (!isset($_SESSION['current_lang'])) {
        $_SESSION['current_lang'] = 'en';
    }
    /*the current language default is kn/en*/
    $lang = $_SESSION['current_lang'];
    /*include file that has array*/
    if (file_exists("languages/$lang.php")) {
        require_once "languages/$lang.php"; 
    }elseif (file_exists("../languages/$lang.php")){
        require_once "../languages/$lang.php";  
    }
    
    /*store it in glob valiable*/
    define('array_of_lang', $langarray??[]);
    /*you will create file called add to language */
}
__create_lang(); 
/*function to translate*/
    function __lng__($str){
        if ($_SESSION['current_lang'] == 'en') {
            echo ucfirst($str);
        }
        else{
            $new_array = __upcase_1_letter(constant('array_of_lang'));
            echo $new_array[ucfirst($str)]??ucfirst($str);
        }
    } 






    function zipFolder($folderPath, $zipFilePath, $zipDirName = false) {
    if (!$zipDirName) {
        $zipDirName = uniqid();
    }
    $zip = new ZipArchive();
    // Open the archive file
    if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
        $folderPath = realpath($folderPath);

        // Recursive function to add files to the zip
        $addFolderToZip = function($folderPath, $zip, $basePath, $zipDirName) use (&$addFolderToZip) {
            $files = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($folderPath, RecursiveDirectoryIterator::SKIP_DOTS),
                RecursiveIteratorIterator::LEAVES_ONLY
            );

            foreach ($files as $file) {
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($basePath) + 1);

                if (!$file->isDir()) {
                    // Add file to the archive under 'my_zip' directory
                    $zip->addFile($filePath, $zipDirName . '/' . $relativePath);
                }
            }
        };

        // Add the folder and its contents to the zip under 'my_zip' directory
        $addFolderToZip($folderPath, $zip, $folderPath, $zipDirName);

        // Close the archive
        $zip->close();

        // Provide a link to download the zip file
        $zipFileLink = str_replace($_SERVER['DOCUMENT_ROOT'], '', realpath($zipFilePath)); // Relative path for download link
        // return json_encode();
        return [
                'status' => 1,
                'success' => true,
                'message'=> "<a href='$zipFilePath' download='".$zipFilePath."' class='btn btn-info'>Download Zip</a>",
                'path'=> $zipFilePath
        ];

    } else {
        // json_encode();
        return [
                'status' => 1,
                'success' => false,
                'message'=> "Failed to create the zip file."
        ];
    }
}
// Usage
// $folderToZip = __DIR__ . '/myproject';   // Folder to zip
// $outputZip = __DIR__ . '/my_zip_output.zip'; // Output zip file
// zipFolder($folderToZip, $outputZip);




function copyFolder($source, $destination) {
    if (!is_dir($source)) {
        return false;
    }

    $dir = opendir($source);
    @mkdir($destination);
    
    while (false !== ($file = readdir($dir))) {
        if (($file != '.') && ($file != '..')) {
            if (is_dir($source . '/' . $file)) {
                copyFolder($source . '/' . $file, $destination . '/' . $file);
            } else {
                copy($source . '/' . $file, $destination . '/' . $file);
            }
        }
    }
    closedir($dir);
    return 1;
    //echo "copy $source to $destination done at ".date("D,M Y H:i:s")."<br>";
}





function deleteFolder($dir) {
    if (!is_dir($dir)) {
        return false;
    }

    $files = array_diff(scandir($dir), ['.', '..']);
    foreach ($files as $file) {
        (is_dir("$dir/$file")) ? deleteFolder("$dir/$file") : unlink("$dir/$file");
    }
    rmdir($dir);
    return true;
}
// --user it---
// Zipping a folder
//zipFolder('path/to/source/folder', 'path/to/destination.zip');

// Copying a folder
//copyFolder('path/to/source/folder', 'path/to/destination/folder');

// Deleting a folder
//deleteFolder('path/to/folder');


        function x_make_directories($dir_path){
                if (is_array($dir_path)) {
                    foreach ($dir_path as $dir) {
                        if (!is_dir($dir)) {
                            if (!mkdir($dir)) {
                                return 0;
                            }
                        }
                    }
                    return 1;                   
                }

                if (!is_dir($dir_path)) {
                    if (!mkdir($dir_path)) {
                        echo "Not created";
                    }
                }
                return 1;           
    }
    function x_make_file($file_path,$content,$overwrite = 0){
            /*make includes file*/
                if (!file_exists($file_path)) {
                    $file = fopen($file_path, 'w');
                    if (fwrite($file, $content)) {
                        //echo "$file_path  is created at ".date('D,M Y  H:i s');
                        //echo " sec<br>";
                        return 1;

                    }
                    else{
                        echo " $file_path  not created";
                        echo "<br>";
                    }
                }
                else{
                    if ($overwrite) {
                        unlink($file_path);
                        x_make_file($file_path,$content,0);
                    }else{
                        //echo "$file_path/cogs/db.php exist";
                    }
                    
                }           
    }
    

    function x_create_db($db = '')
    {
        $con = mysqli_connect("localhost","root","");
        $xquery = mysqli_query($con,"SHOW DATABASES LIKE '$db'");
        if (mysqli_num_rows($xquery) == 0) {
            mysqli_query($con,"CREATE DATABASE $db") or die('database not created');
        }
    }
    
    function xquery_runner($query)
    {
            $query = trim($query);
            if (preg_match("/^SELECT|UPDATE|DELETE|SHOW|DESC|DESCRIBE|COMMIT|ALTER|INSERT|EXECUTE(.*)/i", $query)) {
                $pdo = connect();
                try {
                     $execute = $pdo->query($query);
                       return 1;
                } catch (Exception $e) {
                    $_SESSION['mysqli_error'] = $e->getMessage();
                    return false;
                }
            }else{
                 $_SESSION['mysqli_error'] = "INVALID SQL";
                 return false;
            }
            
    }
    
    function pdt_query($query){
        xquery_runner($query);
    }
    
    function xredirect($url){
            header('location:'.$url);
    }
    function x_open_url($url = './'){
        echo "<script>window.location.href='".$url."'</script>";
    }
    function x_retrivedata($query, $isAssoc = true)
    {
        $pdo = connect();
        $msg = error_message();
        $execute = $pdo->query($query);
        $execute->execute();
        if ($isAssoc) {
            $retriveData = $execute->fetchAll(PDO::FETCH_ASSOC);
        }else{
            $retriveData = $execute->fetchAll(PDO::FETCH_NUM);
        }
        return $retriveData;
    }

        function x_retrive_tb_data($query)
        {
            
           $pdo = connect();
           $msg = error_message();
            $execute = $pdo->query($query);
            $execute->execute();
            $retriveData = $execute->fetchAll();
            return $retriveData;
        }
        function x_table_rows($tb){
            $pdo = connect();
            $execute = $pdo->query("SELECT * FROM $tb");
            $execute->execute();
            $retriveData = $execute->fetchAll(PDO::FETCH_ASSOC);
            return count($retriveData);
        }

        function x_num_rows($query){
            $pdo = connect();
            $execute = $pdo->query($query);
            $execute->execute();
            $retriveData = $execute->fetchAll(PDO::FETCH_ASSOC);
            return count($retriveData);
        }

        function x_num_cols($query){
            $pdo = connect();
            $execute = $pdo->query($query);
            $execute->execute();
            $retriveData = $execute->fetchAll(PDO::FETCH_ASSOC);
            if ($retriveData) {
                return count($retriveData[0]);
            }else{
                return 0;
            }   
        }

        function x_encrypt_data($data){
            if (is_array($data)) {
                $returned_data = [];
                foreach ($data as $value) {
                    array_push($returned_data, base64_encode($value));
                }
                return $returned_data;
            }else{
                return base64_encode($data);
            }
        }

        function x_decrypt_data($data){
            if (is_array($data)) {
                $returned_data = [];
                foreach ($data as $value) {
                    array_push($returned_data, base64_decode($value));
                }
                return $returned_data;
            }else{
                return base64_decode($data);
            }
        }
 ?>
<?php 
    function x_font_color($value)
    {
        $color = substr($value,1);
        $color = str_split($color);
        $color = array_chunk($color, 2);
        $max = max(hexdec($color[0][0]), hexdec($color[1][0]) , hexdec($color[2][0]));
        if ($max > 10) {
            return "black !important";
        }else{
            return "white !important";
        }   
    }
 ?>
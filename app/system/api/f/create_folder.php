<?php
if(isset($_POST['folderName'])){
    $folderName = preg_replace('/[^a-zA-Z0-9_-]/', '', $_POST['folderName']);
    $path = '../../filemanager/uploads/' . $folderName;

    if(!is_dir($path)){
        mkdir($path, 0777, true);
        echo "Folder '$folderName' created.";
    } else {
        echo "Folder already exists.";
    }
} else {
    echo "Folder name is required.";
}
?>

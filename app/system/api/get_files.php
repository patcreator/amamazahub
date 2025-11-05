<?php 
  $path = $_POST['path']??'../../../';
  function getData($path, $type = 'all'){
    $files = [];
    $folders = [];
    foreach (scandir($path) as $item) {
        if ($item === '.' || $item === '..') continue; // Skip current and parent directory

        $fullPath = $path . DIRECTORY_SEPARATOR . $item;

        if (is_dir($fullPath)) {
            $folders[] = $item; // Add to folders array
        } else {
            $files[] = $item; // Add to files array
        }
    }

    if ($type == 'all') {
      return array_merge($folders,$files);
    }elseif ($type == 'files') {
      return $files;
    }else{
      return $folders;
    }
  }
  header("Content-type:application/json");
  // echo json_encode([
  //   'files'=>getData($path, 'files'),
  //   'dirs'=>getData($path,'dirs')
  // ]);
  echo json_encode([
    'message'=>$path
  ]);
 ?>
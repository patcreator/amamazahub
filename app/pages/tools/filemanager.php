
  <style>
    .file-item:hover {
      background-color: rgba(255, 255, 255, 0.1);
    }
  </style>
<?php 
$path = $_GET['path']??'../../../';
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
    return [];
  }elseif ($type == 'files') {
    return $files;
  }else{
    return $folders;
  }
}

?>
<div class="h-screen flex flex-col">

  <!-- Top Bar -->
  <div class="flex items-center justify-between bg-gray-100 dark:bg-gray-800 px-4 py-2 border-b border-gray-200 dark:border-gray-700">
    <div class="flex items-center space-x-2">
      <div class="text-lg font-semibold">FILE MANAGER</div>
      <input type="text" name="path" value="/PDT-NEW/projects/pdo/" id="path" class="dark:bg-gray-800 dark:text-gray-200 p-2 rounded shadow border">
      <button class="bg-gray-200 hover:bg-gray-300 rounded shadow border text-gray-700 p-2">Change</button>
    </div>
    <div class="flex items-center space-x-2">
      <button class="bg-gray-100 dark:bg-gray-800 px-3 py-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700">New</button>
      <button class="bg-gray-100 dark:bg-gray-800 px-3 py-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700">Sort</button>
      <button class="bg-gray-100 dark:bg-gray-800 px-3 py-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700">View</button>
    </div>
  </div>

  <!-- Body -->
  <div class="flex flex-1 overflow-hidden">

    <!-- Sidebar -->
    <div class="w-56 bg-gray-100 dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 p-3 overflow-y-auto">
      <ul id="ul-container" class="space-y-1 text-sm">
        <?php 
          foreach (getData("$path",'dirs') as $dir) {
           ?>
            <li onclick="getFiles('<?= $path.$dir ?>/')" class="py-1 px-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 cursor-pointer"><?= $dir ?></li>
           <?php 
          }
         ?>
      </ul>
    </div>

    <!-- Main Area -->
    <div class="flex-1 p-4 overflow-y-auto">
      <div id="files-container" class="grid grid-cols-6 gap-4">
        <?php 
          foreach (getData($path,'dirs') as $fd) {
            ?>
            <!-- Folders -->
              <div onclick='getFiles("<?= $path.$fd?>/")' class="file-item text-center p-2 rounded cursor-pointer">
                <img src="https://cdn-icons-png.flaticon.com/512/716/716784.png" class="w-12 mx-auto" />
                <div class="text-xs mt-1 truncate"><?= $fd ?></div>
              </div>
            <?php
          }
         ?>
         <?php 
          foreach (getData($path,'files') as $fl) {
            ?>
            <!-- Files -->
            <div class="file-item text-center p-2 rounded cursor-pointer">
              <img src="https://cdn-icons-png.flaticon.com/512/607/607674.png" class="w-12 mx-auto" />
              <div class="text-xs mt-1 truncate"><?= $fl ?></div>
            </div>
            <?php
          }
         ?>
      </div>
    </div>
  </div>

  <script>
  function renderFiles(res, parentPath) {
  let dirsHTML = '';
  let filesHTML = '';
  let ulHtml = '';

  if (res.dirs && res.dirs.length) {
    res.dirs.forEach(function(folder) {
      dirsHTML += `
        <div onclick="getFiles('${parentPath + folder}/');" class="file-item text-center p-2 rounded cursor-pointer">
          <img src="https://cdn-icons-png.flaticon.com/512/716/716784.png" class="w-12 mx-auto" />
          <div class="text-xs mt-1 truncate">${folder}</div>
        </div>`;
        ulHtml += `<ul class="ms-2"><li onclick="getFiles('${parentPath + folder}/');" class="py-1 px-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 cursor-pointer">${folder}</li></ul>`;
    });
    
  }

  if (res.files && res.files.length) {
    res.files.forEach(function(file) {
      filesHTML += `
        <div class="file-item text-center p-2 rounded cursor-pointer">
          <img src="https://cdn-icons-png.flaticon.com/512/607/607674.png" class="w-12 mx-auto" />
          <div class="text-xs mt-1 truncate">${file}</div>
        </div>`;
    });
  }

  $('#files-container').html(dirsHTML + filesHTML);
  $('#ul-container').html(ulHtml);
}


function getFiles(path){
  $.post('/PDT-NEW/projects/pdo/app/system/api/get_files.php', { path }, function(res) {
      renderFiles(res, path);
    }).fail(function() {
      showMessage('Failed to load files');
    }); 
}


  </script>

</div>

<?php 
    $dir_path = $_GET['path']??'./';
    if(empty($dir_path)) $dir_path = './';
  ?>
<link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
 <div class="this-container p-5 bg-white dark:bg-slate-800 dark:text-gray-100 shadow-md rounded-2xl mx-5">
    <?php 
        if (!file_exists($dir_path)) { echo '
<div id="alert-2" class="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
  <svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
  </svg>
  <span class="sr-only">Info</span>
  <div class="ms-3 text-sm font-medium">
    File  or folder not found
  </div>
  <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-2" aria-label="Close">
    <span class="sr-only">Close</span>
    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
    </svg>
  </button>
</div>
';$dir_path='./'; }
    if (is_dir($dir_path)) {
        $dir_path = rtrim($dir_path,'/').'/';
    }else{
        $dir_path='./';
    }
     ?>
<form class="grid grid-cols-12 bg-gray-50 dark:bg-slate-800 dark:text-gray-100 p-2 shadow-md mb-3 w-full rounded">
    <div class="flex col-span-2">
        <a href="<?= $path.'s/filemanager'?>" class="bg-red-500 hover:bg-red-700 text-white ms-3 fa fa-folder h-10 w-10 rounded-full flex items-center justify-center"></a>

        <a href="<?= $path.'s/filemanager?path='.substr($dir_path, 0, strpos($dir_path, basename($dir_path).'/')); ?>" class="bg-red-500 hover:bg-red-700 text-white ms-3 fa fa-arrow-up h-10 w-10 rounded-full flex items-center justify-center"></a>
    </div>
    <div class="col-span-4">
        <input type="text" name="path" id="path" value="<?= $dir_path ?>" class="ms-auto  bg-gray-50 text-slate-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5  inline-flex items-center justify-center dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700 w-full border border-2 border-red-500" placeholder="Enter path and click search" /> 
    </div>
    <div>
        <button class="p-2 bg-red-500 hover:bg-red-700 text-white rounded-md ms-3">Go to</button>
    </div>
    <div class="col-span-5 flex justify-end">
        <input type="text" name="path" id="seach-bar" class="ms-auto w-auto bg-gray-50 text-slate-500 rounded-lg focus:ring-2 focus:ring-gray-400 p-1.5  inline-flex items-center justify-center dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 w-full border border-2 border-gray-500" placeholder="Search data" />
        <button class="fa fa-search -ms-7 text-gray-400" disabled></button>
    </div>
</form>
<!-- Delete Confirmation Modal -->
<div id="deleteFolderModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 max-h-full">
  <div class="relative p-4 w-full max-w-md max-h-full">
    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
      <div class="p-6 text-center">
        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
          Are you sure you want to delete this folder?
        </h3>
        <button data-modal-hide="deleteFolderModal" type="button" class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 mr-2">
          Yes, Delete
        </button>
        <button onclick="location.reload();" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5">
          Cancel
        </button>
      </div>
    </div>
  </div>
</div>



<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 p-5" id="files-container">
    
<?php 
    $ar = @scandir($dir_path);
    $files = array_diff($ar, ['..','.']);
    if (empty($files)) {
        echo<<<HTML


<div class="w-full col-span-4 p-4 text-center bg-white border border-gray-200 rounded-lg shadow-sm sm:p-8 dark:bg-gray-800 dark:border-gray-700">
    <a href="#"  data-modal-target="upload-file-modal" data-modal-toggle="upload-file-modal" class="mdi mdi-upload-multiple fa-7x"></a>
    <h5 class="mb-2 text-3xl font-bold text-gray-900 dark:text-white">Directory is empty</h5>
    <p class="mb-5 text-base text-gray-500 sm:text-lg dark:text-gray-400">The file of folder you are looking for is empty add file or folder.</p>
    <div class="items-center justify-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4 rtl:space-x-reverse">
        <a href="#"  data-modal-target="create-folder-modal" data-modal-toggle="create-folder-modal" class="w-full sm:w-auto bg-gray-800 hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-300 text-white rounded-lg inline-flex items-center justify-center px-4 py-2.5 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700">
            <i class="uil uil-folder-plus fa-2x me-2"></i>
            <div class="text-left rtl:text-right">
                <div class="mb-1 text-xs">Click to</div>
                <div class="-mt-1 font-sans text-sm font-semibold">Create folder</div>
            </div>
        </a>
        <a href="#"  data-modal-target="create-file-modal" data-modal-toggle="create-file-modal" class="w-full sm:w-auto bg-gray-800 hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-300 text-white rounded-lg inline-flex items-center justify-center px-4 py-2.5 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700">
            <i class="uil uil-file-plus fa-2x me-2"></i>
            <div class="text-left rtl:text-right">
                <div class="mb-1 text-xs">Click to </div>
                <div class="-mt-1 font-sans text-sm font-semibold">Create file</div>
            </div>
        </a>
    </div>
</div>

HTML;
    }
    foreach ($files as $key => $value) {
        $full_path = $dir_path.$value;
        if (is_dir($full_path)) {
            echo    '<div style="user-select:none;" id="card'.$key.'" class="mb-5 relative text-center shadow-md rounded-md border dark:border-gray-600 hover:shadow-lg py-4  hover:bg-gray-50 dark:hover:bg-gray-700" >

<button id="dropdownMenuIconButton" data-dropdown-toggle="dropdownDots'.$key.'" class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600 absolute top-0 end-0 m-2" type="button">
<svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
<path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/>
</svg>
</button>

<!-- Dropdown menu -->
<div id="dropdownDots'.$key.'" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow border w-44 dark:bg-gray-700 dark:divide-gray-600">
    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200 text-start" aria-labelledby="dropdownMenuIconButton">
          <li>
            <a href="'.$path.'s/filemanager?path='.$full_path.'/" class="flex items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
              <i class="fa fa-folder-open mr-2"></i> Open
            </a>
          </li>
          <li>
            <a href="#" data-path="'.$full_path.'" class="flex copyUrlBtn items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
              <i class="fa fa-copy mr-2"></i> Copy
            </a>
          </li>
          <li>
            <a href="#" onclick="shareFile(event, \''.$full_path.'\')" class="flex items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
              <i class="fa fa-share-alt mr-2"></i> Share
            </a>
          </li>
          <li>
            <a href="#" data-path="'.$full_path.'" class="flex download_folder download-folder-btn items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
              <i class="fa fa-download mr-2"></i> Download
            </a>
          </li>
          <li>
            <a href="#" data-path="'.$full_path.'" data-modal-target="fileInfoModal" data-modal-toggle="fileInfoModal" class="flex info-btn items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
              <i class="fa fa-info-circle mr-2"></i> Info
            </a>
          </li>
          <li>
            <a href="#" data-path="'.$full_path.'" data-parent="card'.$key.'" class="flex items-center del-folder-btn px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
              <i class="fa fa-trash mr-2"></i> Delete
            </a>
          </li>
          <li>
            <a href="#" data-path="'.$full_path.'" data-parent="card'.$key.'" class="flex select-btn items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
              <i class="fa fa-check-square mr-2"></i> Checkbox
            </a>
          </li>

    </ul>
</div>

            <a href="'.$path.'s/filemanager?path='.$full_path.'/" class="text-5xl" >📂</a><br>
            <span data-name="'.str_replace('_',"\n",$value).'" class="dark:text-gray-300 text-gray-700">'.$value.'</span>
            </div>';
        } else {
            $file_size = filesize($full_path);
            $file_type = pathinfo($full_path)['extension']??'';
            $icons = [
                'php'=>'mdi mdi-language-php',
                'html'=>'mdi mdi-language-html5',
                'css'=>'mdi mdi-language-css3',
                'java'=>'mdi mdi-language-java',
                'js'=>'mdi mdi-language-javascript',
                'json'=>'mdi mdi-language-json',
                'slq'=>'mdi mdi-language-sql',
                'xml'=>'mdi mdi-language-xml',
                'py'=>'mdi mdi-language-python',
                'cpp'=>'mdi mdi-language-cpp',
                'cshap'=>'mdi mdi-language-cshap',
                'go'=>'mdi mdi-language-go',
                'ruby'=>'mdi mdi-language-ruby',

                'pdf'       => 'mdi mdi-file-pdf-box',
                'doc'      => 'mdi mdi-file-word',
                'docx'     => 'mdi mdi-file-word',
                'xls'      => 'mdi mdi-file-excel',
                'xlsx'     => 'mdi mdi-file-excel',
                'ppt'      => 'mdi mdi-file-powerpoint',
                'pptx'     => 'mdi mdi-file-powerpoint',
                'txt'      => 'mdi mdi-file-document-outline',
                'rtf'      => 'mdi mdi-file-document',
                'csv'      => 'mdi mdi-file-delimited',
                'odt'      => 'mdi mdi-file-document',
                'ods'      => 'mdi mdi-file-table-box',
                'odp'      => 'mdi mdi-file-presentation-box',
                'epub'     => 'mdi mdi-book-open-page-variant',
                'pages'    => 'mdi mdi-file-document-edit',
                'key'      => 'mdi mdi-presentation',
                'numbers'  => 'mdi mdi-file-chart',

                'mp3'   => 'mdi mdi-music',
                'wav'   => 'mdi mdi-music-note',
                'ogg'   => 'mdi mdi-music-note',
                'm4a'   => 'mdi mdi-music-note',
                'flac'  => 'mdi mdi-music-note',
                'aac'   => 'mdi mdi-music-note',
                'wma'   => 'mdi mdi-music-note',
                'aiff'  => 'mdi mdi-music-note',
                'alac'  => 'mdi mdi-music-note',
                'amr'   => 'mdi mdi-microphone',
                'mid'   => 'mdi mdi-piano',
                'midi'  => 'mdi mdi-piano',
                'opus'  => 'mdi mdi-music',

                'mp4'   => 'mdi mdi-video',
                'mov'   => 'mdi mdi-video',
                'avi'   => 'mdi mdi-video',
                'wmv'   => 'mdi mdi-video',
                'flv'   => 'mdi mdi-video',
                'mkv'   => 'mdi mdi-video',
                'webm'  => 'mdi mdi-video',
                'mpeg'  => 'mdi mdi-video',
                'mpg'   => 'mdi mdi-video',
                '3gp'   => 'mdi mdi-cellphone-play',
                'm4v'   => 'mdi mdi-video',
                'ogv'   => 'mdi mdi-video',
                'ts'    => 'mdi mdi-video',
                'vob'   => 'mdi mdi-movie-open',
            ];

            if (in_array($file_type, [ 'jpg','jpeg','png','gif','webp','bmp','tiff','tif','svg','heic','heif','ico','avif','raw','psd','ai','eps'])) {

                 $icon = '<img src="'.$path.$full_path.'" class="h-32 block mx-auto w-32 rounded-md shadow">';

            }elseif (in_array($file_type, ['mp4','mov','avi','wmv','flv','mkv','webm','mpeg','mpg','3gp','m4v','ogv','ts','vob'])) {
                 $_icon = $icons[$file_type]??'';
                 $icon = '<i class="'.$_icon.' fa fa-movie "></i>';

            }elseif (in_array($file_type, ['mp3','wav','ogg','m4a','flac','aac','wma','aiff','alac','amr','mid','midi','opus'])) {

                 $_icon = $icons[$file_type]??'';
                 $icon = '<i class="'.$_icon.' fa fa-audio " ></i>';


            }elseif (in_array($file_type, ['pdf','doc','docx','xls','xlsx','ppt','pptx','txt','rtf','csv','odt','ods','odp','epub','pages','key','numbers'])) {
                 $_icon = $icons[$file_type]??'';
                 $icon = '<i class="'.$_icon.' fa fa-file-document" ></i>';

            }elseif (in_array($file_type, array_keys($icons))) {
                $_icon = $icons[$file_type]??'';
                $icon = '<i class="'.$_icon.' fa fa-file"></i>';

            }else{

                $icon = '<span>📄</span>';

            }
                echo  '<div style="user-select:none;" data-full-path="'.$path.$full_path.'" class="mb-5 relative text-center file-card shadow-md rounded-md border dark:border-gray-600 py-4 px-4">
<button id="dropdownMenuIconButton" data-dropdown-toggle="dropdownDots'.$key.'" class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600 absolute top-0 end-0 m-2" type="button">
<svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
<path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/>
</svg>
</button>

<!-- Dropdown menu -->
<div id="dropdownDots'.$key.'" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow border w-44 dark:bg-gray-700 dark:divide-gray-600">
    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200 text-start" aria-labelledby="dropdownMenuIconButton">
          <li>
            <a href="#" data-modal-target="open-file-modal" data-modal-toggle="open-file-modal" data-path="'.$path.$full_path.'" class="flex open-file-btn items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
              <i class="fa fa-folder-open mr-2"></i> Open
            </a>
          </li>
          <li>
            <a href="#" data-path="'.$full_path.'" data-modal-target="edit-content-modal" data-modal-toggle="edit-content-modal" class="flex edit-btn items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
              <i class="fa fa-edit mr-2"></i> Edit
            </a>
          </li>
          <li>
            <a href="#" data-path="'.$full_path.'" class="flex copyUrlBtn items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
              <i class="fa fa-copy mr-2"></i> Copy
            </a>
          </li>
          <li>
            <a href="#" onclick="shareFile(event, \''.$full_path.'\')" class="flex items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
              <i class="fa fa-share-alt mr-2"></i> Share
            </a>
          </li>
          <li>
            <a href="#" data-path="'.$full_path.'" class="flex download-btn items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
              <i class="fa fa-download mr-2"></i> Download
            </a>
          </li>
          <li>
            <a href="#" data-path="'.$full_path.'" data-modal-target="fileInfoModal" data-modal-toggle="fileInfoModal" class="flex info-btn items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
              <i class="fa fa-info-circle mr-2"></i> Info
            </a>
          </li>
          <li>
            <a href="#" data-path="'.$full_path.'" data-parent="card'.$key.'" class="flex items-center del-btn px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
              <i class="fa fa-trash mr-2"></i> Delete
            </a>
          </li>
          <li>
            <a href="#" data-path="'.$full_path.'" data-parent="card'.$key.'" class="flex select-btn items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
              <i class="fa fa-check-square mr-2"></i> Checkbox
            </a>
          </li>

    </ul>
</div>
                    <div class="text-7xl dark:text-gray-100 text-gray-900">'.$icon.'</div>
                    <span data-name="'.str_replace('_',"\n",$value).'" class="dark:text-gray-100 text-gray-900">'.str_replace('_',"\n",$value).'</span>
                </div>';


        }
        
    }
 ?>
</div>
</div>


<script>
$(document).ready(function() {
  // Listen for typing in the search input
  $('#seach-bar').on('input', function() {
    const query = $(this).val().toLowerCase().trim();

    // Select all file/folder cards
    const $cards = $('#files-container > div');

    $cards.each(function() {
      const name = $(this).find('[data-name]').data('name')?.toLowerCase() || '';

      // Match data-name with search text
      if (name.includes(query)) {
        // Show matching items with animation
        if ($(this).is(':hidden')) {
          $(this).stop(true, true).slideDown(200);
        }
      } else {
        // Hide non-matching items
        if ($(this).is(':visible')) {
          $(this).stop(true, true).slideUp(200);
        }
      }
    });
  });
});
</script>

<script>
$('.copyUrlBtn').on('click', function(e) {
    e.preventDefault(); // prevent the default link behavior

    // Get current page URL
    const url = $(this).data('path');

    // Copy to clipboard
    navigator.clipboard.writeText(url)
        .then(() => {
            showMessage('URL copied to clipboard!','success');
        })
        .catch(err => {
            console.error('Failed to copy: ', err);
        });
});
</script>














<!-- Flowbite Modal -->
<div id="fileInfoModal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
  <div class="relative p-4 w-full max-w-md h-full md:h-auto">
    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
      <!-- Close button -->
      <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="fileInfoModal">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
        </svg>
      </button>
      <!-- Modal content -->
      <div class="p-6 space-y-4">
        <h3 class="text-lg font-medium text-gray-900 dark:text-white flex items-center">
          <i class="fa fa-file mr-2"></i> File Info
        </h3>
        <ul class="space-y-2 text-gray-700 dark:text-gray-300" id="fileInfoContent">
          <!-- JS will inject details here -->
        </ul>
      </div>
    </div>
  </div>
</div>

<!-- jQuery & Flowbite should be included -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/flowbite@1.8.0/dist/flowbite.js"></script>

<script>
    let files = [];
$(function() {
    // Function to create list items for file details
    function buildFileInfoList(data) {
        const details = [
            { label: "Name", value: data.name, icon: "fa fa-file" },
            { label: "Type", value: data.type, icon: "fa fa-info-circle" },
            { label: "Path", value: data.path, icon: "fa fa-folder" },
            { label: "Size", value: data.size_mb ? data.size_mb + " MB" : "-", icon: "fa fa-weight-hanging" },
            { label: "Is File", value: data.is_file ? "Yes" : "No", icon: "fa fa-file" },
            { label: "Is Directory", value: data.is_dir ? "Yes" : "No", icon: "fa fa-folder" },
            { label: "Created At", value: data.created_at ? new Date(data.created_at*1000).toLocaleString() : "-", icon: "fa fa-calendar-plus" },
            { label: "Modified At", value: data.modified_at ? new Date(data.modified_at*1000).toLocaleString() : "-", icon: "fa fa-edit" },
            { label: "Accessed At", value: data.accessed_at ? new Date(data.accessed_at*1000).toLocaleString() : "-", icon: "fa fa-clock" },
            { label: "Permissions", value: data.perms_human || "-", icon: "fa fa-lock" },
            { label: "Owner", value: data.owner_name || data.owner_uid || "-", icon: "fa fa-user" },
            { label: "Group", value: data.group_name || data.group_gid || "-", icon: "fa fa-users" },
            { label: "Inode", value: data.inode || "-", icon: "fa fa-hashtag" }
        ];

        return details.map(d => 
            `<li class="flex items-center space-x-2">
                <i class="${d.icon} w-5"></i>
                <span class="font-semibold">${d.label}:</span>
                <span>${d.value}</span>
            </li>`
        ).join('');
    }

    // Event delegation for all current & future del-btns
    $(document).on("click", ".del-btn", function(e) {
        e.preventDefault();
        const filePath = $(this).data("path");

        $.getJSON(`<?= $path ?>app/api/api.php?action=file_delete&file=${encodeURIComponent(filePath)}`)
        .done(function(data) {
            if (data.success) {
                showMessage(data.message, 'success');
                setTimeout(()=>window.location.reload(), 1500);
                $("#"+$(this).data("parent")).remove();
            }else{
                showMessage(data.message, 'error');
            }
        })
        .fail(function(xhr) {
            // alert(JSON.stringify(xhr));
            showMessage("Failed to delete file.");
        });
    });





let folderToDelete = null;

// Click on delete folder button
document.querySelectorAll('.del-folder-btn').forEach(btn => {
  btn.addEventListener('click', function(e) {
    e.preventDefault();
    folderToDelete = {
      path: this.dataset.path,
      parent: this.dataset.parent
    };

    // Show Flowbite modal
    const modalEl = document.getElementById('deleteFolderModal');
    const modal = new Modal(modalEl);
    modal.show();
  });
});

// Confirm deletion
document.querySelector('#deleteFolderModal [data-modal-hide="deleteFolderModal"][type="button"]').addEventListener('click', function() {
  if (!folderToDelete) return;

  // Call API to delete folder
  fetch(`<?= $path ?>app/api/api.php?action=file_delete&file=${encodeURIComponent(folderToDelete.path)}`)
    .then(res => res.json())
    .then(data => {
      showMessage(data.message, 'success'); // you can replace with showMessage()
      if (data.success) {
        location.reload();
        // Optionally remove the folder element from DOM
        const parentCard = document.getElementById(folderToDelete.parent);
        if (parentCard) parentCard.remove();
      }
    })
    .catch(err => console.error(err));

  folderToDelete = null;
});


















    // Event delegation for all current & future select-btns
    $(document).on("click", ".select-btn", function(e) {
        e.preventDefault();
        // files[] = $(this).data("path");
        $("#"+$(this).data("parent")).toggleClass('bg-gray-300 dark:bg-slate-500');
        $("#"+$(this).data("parent")).data('selected');
    });

    // Event delegation for all current & future info-btns
    $(document).on("click", ".info-btn", function(e) {
        e.preventDefault();
        const filePath = $(this).data("path");

        $.getJSON(`<?= $path ?>app/api/api.php?action=file_detail&file=${encodeURIComponent(filePath)}`)
        .done(function(data) {
            $("#fileInfoContent").html(buildFileInfoList(data));
        })
        .fail(function(xhr) {
            alert(JSON.stringify(xhr));
            showMessage("Failed to fetch file details.");
        });
    });

        // Event delegation for all current & future open-file-btns
    $(document).on("click", ".open-file-btn", function(e) {
        e.preventDefault();
        const filePath = $(this).data("path");
        $("#open-file-title, #open-file-content").html("");
        $("#open-file-title").html(`Open ${filePath}`);
        $("#open-file-content").html(`<iframe class="h-[70vh] rounded-xl w-full" src="${filePath}"></iframe>`);
    });
// Event delegation for all current & future open-file-btns
    $(document).on("dblclick", ".file-card", function() {
        const filePath = $(this).data("full-path");
        $("#open-file-title, #open-file-content").html("");
        $("#open-file-title").html(`Open ${filePath}`);
        $("#open-file-content").html(`<iframe class="h-[70vh] rounded-xl w-full" src="${filePath}"></iframe>`);
        $("#realbtn").click();

    });
    // Event delegation for all current & future edit-btns
    $(document).on("click", ".edit-btn", function(e) {
        e.preventDefault();
        const filePath = $(this).data("path");

        $.getJSON(`<?= $path ?>app/api/api.php?action=file_edit&file=${encodeURIComponent(filePath)}`)
        .done(function(data) {
            $(".save-change-btn").val('');
            $("#edit-file-title, #edit-file-content").html("");
            showMessage(data.message,data.success?'success':'error');
            $("#edit-file-title").html(`Edit ${filePath}`);
            $("#edit-file-content").html(data.data);
            $(".save-change-btn").data('path', filePath);
        })
        .fail(function(xhr) {
            // alert(JSON.stringify(xhr));
            showMessage("Failed to fetch file content to edit.");
        });
    });
});   
 // Event delegation for all current & future edit-btns
    $(document).on("click", ".save-change-btn", function(e) {
        e.preventDefault();
        const filePath = $(this).data("path");
        $.post(`<?= $path ?>app/api/api.php?action=save_file_edited_content&file=${encodeURIComponent(filePath)}`,{
            content:$('#edit-file-content').val()
        })
        .done(function(data) {
            showMessage(data.message,data.success?'success':'error');
        })
        .fail(function(xhr) {
            // alert(JSON.stringify(xhr));
            showMessage("Failed to fetch file content to edit.");
        });
    });
</script>










<!-- Main modal -->
<div id="open-file-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 max-h-full">
    <div class="relative p-4 w-full max-w-9xl max-h-full" >
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700 h-[90vh]">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                <h3 id="open-file-title" class="text-lg  font-semibold text-gray-900 dark:text-white">
                    ...
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="open-file-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5" id="open-file-content">
                ...
            </div>
        </div>
    </div>
</div> 







<!-- Main modal -->
<div id="edit-content-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 max-h-full">
    <div class="relative p-4 w-full max-w-9xl max-h-full" >
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700 h-[90vh]">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                <h3 id="edit-file-title" class="text-lg  font-semibold text-gray-900 dark:text-white">
                    Edit file
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="edit-content-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5">
                <div class="grid gap-4 mb-4 grid-cols-1">
                    <div>
                        <label for="edit-file-content" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">CONTENT</label>
                        <textarea id="edit-file-content" rows="15" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write ..."></textarea>                    
                    </div>
                </div>
               <div class="flex justify-end">
                    <button  class="save-change-btn mr-2 text-white inline-flex items-center bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                    <i class=" fa fa-edit"></i>
                    SAVE CHANGE
                </button>
                <button  data-modal-toggle="edit-content-modal" type="button" class="save-change-btn mr-2 text-white inline-flex items-center bg-gray-700 hover:bg-gray-900 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-600 dark:hover:bg-gray-900 dark:focus:ring-red-800">
                CLOSE
                </button>

               </div>
            </div>
        </div>
    </div>
</div> 








<!-- =================== CREATE FOLDER MODAL =================== -->
<div id="create-folder-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 max-h-full">
  <div class="relative p-4 w-full max-w-md max-h-full">
    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
      <div class="flex items-center justify-between p-4 border-b rounded-t dark:border-gray-600">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
          Create New Folder
        </h3>
        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="create-folder-modal">
          <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1l12 12M13 1L1 13"/>
          </svg>
        </button>
      </div>
      <form id="createFolderForm" class="p-4 space-y-4">
        <div>
          <label for="folderName" class="block text-sm font-medium text-gray-900 dark:text-white">Folder Name</label>
          <input type="text" id="folderName" name="folderName" class="block w-full p-2 border rounded-md dark:bg-gray-600 dark:border-gray-500 dark:text-white" placeholder="New Folder" required />
        </div>
        <div class="flex justify-end">
          <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg">Create</button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- =================== CREATE FILE MODAL =================== -->
<div id="create-file-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 max-h-full">
  <div class="relative p-4 w-full max-w-md max-h-full">
    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
      <div class="flex items-center justify-between p-4 border-b rounded-t dark:border-gray-600">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
          Create New File
        </h3>
        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="create-file-modal">
          <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1l12 12M13 1L1 13"/>
          </svg>
        </button>
      </div>
      <form id="createFileForm" class="p-4 space-y-4">
        <div>
          <label for="fileName" class="block text-sm font-medium text-gray-900 dark:text-white">File Name (with extension)</label>
          <input type="text" id="fileName" name="fileName" class="block w-full p-2 border rounded-md dark:bg-gray-600 dark:border-gray-500 dark:text-white" placeholder="example.txt" required />
        </div>
        <div>
          <label for="fileContent" class="block text-sm font-medium text-gray-900 dark:text-white">Content (optional)</label>
          <textarea id="fileContent" name="fileContent" rows="5" class="block w-full p-2 border rounded-md dark:bg-gray-600 dark:border-gray-500 dark:text-white" placeholder="Write something..."></textarea>
        </div>
        <div class="flex justify-end">
          <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg">Create</button>
        </div>
      </form>
    </div>
  </div>
</div>



<!-- =================== FILE UPLOADER MODAL (Dropzone) =================== -->
<div id="upload-file-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 max-h-full">
  <div class="relative p-4 w-full max-w-2xl max-h-full">
    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
      <div class="flex items-center justify-between p-4 border-b rounded-t dark:border-gray-600">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Upload Files</h3>
        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="upload-file-modal">
          <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1l12 12M13 1L1 13"/>
          </svg>
        </button>
      </div>
      <div class="p-6">
        <form action="<?= $path ?>app/api/api.php?action=file_upload&path=<?= urlencode($dir_path) ?>" class="dropzone border-2 border-dashed border-red-400 rounded-xl bg-gray-50 dark:bg-gray-800 dark:border-gray-500" id="fileUploadDropzone"></form>
      </div>
    </div>
  </div>
</div>

<!-- =================== ACTION BUTTONS (TOP TOOLBAR) =================== -->
<div class="fixed bottom-6 right-6 flex flex-col space-y-3 z-40">
  <button data-modal-target="upload-file-modal" data-modal-toggle="upload-file-modal" class="bg-red-600 hover:bg-red-700 text-white p-3 rounded-full shadow-lg"><i class="fa fa-upload"></i></button>
  <button data-modal-target="create-folder-modal" data-modal-toggle="create-folder-modal" class="bg-red-600 hover:bg-red-700 text-white p-3 rounded-full shadow-lg"><i class="fa fa-folder-plus"></i></button>
  <button data-modal-target="create-file-modal" data-modal-toggle="create-file-modal" class="bg-red-600 hover:bg-red-700 text-white p-3 rounded-full shadow-lg"><i class="fa fa-file"></i></button>
</div>










<script>
$(document).ready(function() {
  $('.download-btn').on('click', function(e) {
    e.preventDefault(); // prevent default link behavior

    var path = $(this).data('path'); // get the path from data-path
    var fileName = path.split('/').pop(); // extract filename

    // Create a temporary link and trigger download
    var a = document.createElement('a');
    a.href = path;
    a.download = fileName;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
  });
});


  // Create folder
  $(".download-folder-btn").on("click", function(e) {
    e.preventDefault();
    const path = $(this).data('path');
    $.getJSON(`<?= $path ?>app/api/api.php?action=download_folder&file=${path}`)
      .done(function(data) {
$(".this-container").prepend(`
        <div id="alert-additional-content-5" class="p-4 border border-gray-300 my-4 rounded-lg bg-gray-50 dark:border-gray-600 dark:bg-gray-800" role="alert">
          <div class="flex items-center">
            <svg class="shrink-0 w-4 h-4 me-2 dark:text-gray-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
              <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <span class="sr-only">Info</span>
            <h3 class="text-lg font-medium text-gray-800 dark:text-gray-300">The link has been created click to download Download</h3>
          </div>
          <div class="mt-2 mb-4 text-sm text-gray-800 dark:text-gray-300">
            ${data.message}
          </div>
          <div class="flex">
            <a href="/PDT0/${path}.zip" class="text-white zip-download-delete bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-xs px-3 py-1.5 me-2 text-center inline-flex items-center dark:bg-gray-600 dark:hover:bg-gray-500 dark:focus:ring-gray-800">
              <svg class="me-2 h-3 w-3 dark:text-gray-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 14">
                <path d="M10 0C4.612 0 0 5.336 0 7c0 1.742 3.546 7 10 7 6.454 0 10-5.258 10-7 0-1.664-4.612-7-10-7Zm0 10a3 3 0 1 1 0-6 3 3 0 0 1 0 6Z"/>
              </svg>
              download
            </a>
            <button type="button" onclick="$('#alert-additional-content-5').remove()" class="text-gray-800 bg-transparent border border-gray-700 hover:bg-gray-800 hover:text-white focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-xs px-3 py-1.5 text-center dark:border-gray-600 dark:hover:bg-gray-600 dark:focus:ring-gray-800 dark:text-gray-300 dark:hover:text-white" data-dismiss-target="#alert-additional-content-5" aria-label="Close">
              Dismiss
            </button>
          </div>
        </div>
`);
        // if (data.success) ;
        // setTimeout(() => location.reload(), 3000)
      });
  });


  // Create folder
  $(".zip-download-delete").on("click", function(e) {
    e.preventDefault();
    const path = $(this).data('path');
    $.getJSON(`<?= $path ?>app/api/api.php?action=delete_download_folder&file=${path}`)
      .done(function(data) {
        if (data.success) showMessage('Download has been started','success');;
      });
      $('#alert-additional-content-5').remove();
  });


</script>


<script>
function shareFile(event, path) {
  event.preventDefault(); // Prevent default link behavior
  if (navigator.share) {
    navigator.share({
      title: 'Check this file',
      url: path
    }).then(() => {
      showMessage('Shared successfully','success');
    }).catch((error) => {
      showMessage('Error sharing:'+error);
    });
  } else {
    showMessage('Sharing not supported on this browser');
  }
}
</script>


<button data-modal-target="open-file-modal" data-modal-toggle="open-file-modal" id="realbtn" class="hidden"></button>
<script>


  // Create folder
  $("#createFolderForm").on("submit", function(e) {
    e.preventDefault();
    const folder = $("#folderName").val();
    $.getJSON(`<?= $path ?>app/api/api.php?action=create_folder&file=<?= urlencode($dir_path) ?>&name=${encodeURIComponent(folder)}`)
      .done(function(data) {
        showMessage(data.message, data.success ? 'success' : 'error');
        if (data.success) setTimeout(() => location.reload(), 1000);
      });
  });

  // Create file
  $("#createFileForm").on("submit", function(e) {
    e.preventDefault();
    const file = $("#fileName").val();
    const content = $("#fileContent").val();
    $.post(`<?= $path ?>app/api/api.php?action=create_file`, { 
      path: "<?= $dir_path ?>", 
      name: file, 
      content: content 
    }, function(data) {
        showMessage(data.message, data.success ? 'success' : 'error');
        if (data.success) setTimeout(() => location.reload(), 1000);
    }).fail(function (xhr) {
        alert(JSON.stringify(xhr));
        showMessage('Error creating file', 'error');
    });
  });

</script>
<script>
Dropzone.autoDiscover = false;

$(function() {
  const myDropzone = new Dropzone("#fileUploadDropzone", {
    paramName: "file",
    maxFilesize: 100, // MB
    acceptedFiles: null,
    init: function() {
      this.on("success", function(file, response) {
        let data;
        try {
          // Dropzone sometimes parses automatically, sometimes not
          data = (typeof response === "string") ? JSON.parse(response) : response;
        } catch (e) {
          console.error("Invalid JSON from server:", response);
          showMessage("Upload complete (response not JSON)", "success");
          setTimeout(() => window.location.reload(), 1000);
          return;
        }

        if (data.success) {
          showMessage(data.message || "File uploaded successfully", "success");
        } else {
          showMessage(data.message || "Upload failed", "error");
        }

        // Reload folder view after a short delay
        setTimeout(() => window.location.reload(), 1000);
      });

      this.on("error", function(file, errorMessage) {
        // Dropzone error responses differ by version
        const msg = typeof errorMessage === "string"
          ? errorMessage
          : (errorMessage.message || "Upload failed");
        showMessage(msg, "error");
        console.error("Dropzone error:", errorMessage);
      });

      this.on("queuecomplete", function() {
        console.log("All uploads complete");
      });
    }
  });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
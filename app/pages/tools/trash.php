
  <style>
    .folder:hover {
      background-color: #2a2a2a;
    }
    .folder-icon {
      font-size: 4rem;
      color: #f9d65d;
    }
  </style>
<div class="min-h-screen flex flex-col">

  <!-- Top Bar -->
  <div class="bg-neutral-900 flex items-center justify-between px-4 py-2 border-b border-neutral-800">
    <div class="flex items-center space-x-3">
      <i class="mdi mdi-laptop text-xl"></i>
      <span class="text-sm font-medium">This PC</span>
      <i class="mdi mdi-chevron-right"></i>
      <span class="text-sm font-medium">Windows-SSD (C:)</span>
    </div>
    <div class="flex items-center space-x-3">
      <i class="mdi mdi-magnify text-xl cursor-pointer"></i>
      <input type="text" id="search" placeholder="Search Windows-SSD (C:)" class="bg-neutral-800 text-sm px-3 py-1 rounded-md outline-none">
    </div>
  </div>

  <!-- Toolbar -->
  <div class="bg-neutral-800 text-gray-300 px-4 py-2 flex justify-between items-center border-b border-neutral-700">
    <div class="space-x-4">
      <button class="hover:text-white"><i class="mdi mdi-plus"></i> New</button>
      <button class="hover:text-white"><i class="mdi mdi-content-cut"></i></button>
      <button class="hover:text-white"><i class="mdi mdi-content-copy"></i></button>
      <button class="hover:text-white"><i class="mdi mdi-content-paste"></i></button>
      <button class="hover:text-white"><i class="mdi mdi-delete"></i></button>
    </div>
    <div class="space-x-2">
      <button class="hover:text-white"><i class="mdi mdi-view-grid-outline"></i></button>
      <button class="hover:text-white"><i class="mdi mdi-view-list-outline"></i></button>
    </div>
  </div>

  <!-- File Grid -->
  <div id="fileGrid" class="p-6 grid grid-cols-6 gap-6">
    <!-- Example Folder -->
    <div class="folder p-3 rounded-xl flex flex-col items-center cursor-pointer">
      <i class="mdi mdi-folder-outline folder-icon"></i>
      <span class="text-sm mt-2 truncate">Program Files</span>
    </div>
    <div class="folder p-3 rounded-xl flex flex-col items-center cursor-pointer">
      <i class="mdi mdi-folder-outline folder-icon"></i>
      <span class="text-sm mt-2 truncate">xampp</span>
    </div>
    <div class="folder p-3 rounded-xl flex flex-col items-center cursor-pointer">
      <i class="mdi mdi-folder-outline folder-icon"></i>
      <span class="text-sm mt-2 truncate">Users</span>
    </div>
    <div class="folder p-3 rounded-xl flex flex-col items-center cursor-pointer">
      <i class="mdi mdi-file-outline text-5xl text-gray-400"></i>
      <span class="text-sm mt-2 truncate">DumpStack.log</span>
    </div>
  </div>

  <script>
    // Simple folder selection
    $(".folder").on("click", function () {
      $(".folder").removeClass("bg-neutral-700");
      $(this).addClass("bg-neutral-700");
    });

    // Search filter
    $("#search").on("keyup", function () {
      var value = $(this).val().toLowerCase();
      $("#fileGrid .folder").filter(function () {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
  </script>

</div>

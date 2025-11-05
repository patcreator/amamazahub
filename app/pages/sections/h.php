<?php include_once "app/auth/isAuth.php";?>
<?php 
   $path = "/PDT0/";
   $bk = '<button onclick="window.history.back()" title="back" class="my-2 mx-2 bg-gray-200 dark:bg-gray-800 dark:text-gray-200 h-5 w-5 p-5 flex items-center justify-center hover:bg-red-300 rounded-xl"><i class="fa fa-angle-left"></i></button>';
   $site_name = "PDT0";
   $project_description = 'This proect is all about  content managment system and it is the final project before edit the missing parts to the projects';
   $keywords = 'This, proect, is, all, about, , content, managment, system, and, it, is, the, final, project, before, edit, the, missing, parts, to, the, projects';
   $domain_name = 'https://www.mysite.com';
   $twitter = 'PDT0';
   $author = 'patcreator';
   $logo = '<svg class="w-8 h-8 text-red-600" fill="currentColor" viewBox="0 0 24 24">
        <path d="M12 2C7.03 2 3 6.03 3 11c0 3.63 2.28 6.74 5.5 8.05-.08-.68-.15-1.72.03-2.46.17-.71 1.1-4.55 1.1-4.55s-.28-.57-.28-1.41c0-1.32.77-2.3 1.73-2.3.82 0 1.22.62 1.22 1.36 0 .83-.53 2.07-.8 3.22-.23.96.49 1.74 1.46 1.74 1.75 0 3.1-1.85 3.1-4.53 0-2.37-1.7-4.03-4.13-4.03-2.81 0-4.46 2.11-4.46 4.29 0 .85.33 1.77.74 2.26.08.1.09.19.06.29-.07.32-.23 1.03-.26 1.17-.04.17-.13.2-.31.12-1.17-.55-1.90-2.25-1.90-3.62 0-2.94 2.14-5.64 6.16-5.64 3.33 0 5.92 2.38 5.92 5.56 0 3.31-2.09 5.98-4.99 5.98-1.0 0-1.93-.52-2.25-1.13l-.61 2.33c-.22.87-.81 1.96-1.21 2.62.91.28 1.87.43 2.87.43 4.97 0 9-4.03 9-9s-4.03-9-9-9z" />
      </svg>';
   $company_name = 'PATCREATOR';
   $isIconsOpen = $_SESSION['icons']??1;
   if ($isIconsOpen) {
     $class0 = ''; $class1 = 'w-64'; $class2 = 'max-w-4xl w-full'; $class3 = 'md:ml-64 ';
   }else{
    $class0 = 'hidden'; $class1 = ''; $class2 = ''; $class3 = 'md:ml-32';
   }

       $tables = ['contacts','feedback','help_articles','help_topics','history','jobs','notes','notifications','pdt_districtcoordinator','pdt_provincecoordinator','pdt_sectorcoordinator','pdt_super_admin','search_index','settings','subscribers','todos','user_activity','user_profile','users']; $icons = ['contacts' => 'fa fa-info-circle', 'feedback' => 'fa fa-message', 'help_articles' => 'fa fa-file-alt', 'help_topics' => 'fa fa-question-circle', 'history' => 'fa fa-history', 'jobs' => 'fa fa-briefcase', 'notes' => 'fa fa-edit', 'notifications' => 'fa fa-bell', 'pdt_districtcoordinator' => 'fa fa-user', 'pdt_provincecoordinator' => 'fa fa-map', 'pdt_sectorcoordinator' => 'fa fa-briefcase', 'pdt_super_admin' => 'fa fa-user', 'search_index' => 'fa fa-search', 'settings' => 'fa fa-cog', 'subscribers' => 'fa fa-envelope', 'todos' => 'fa fa-list', 'user_activity' => 'mdi mdi-history', 'user_profile' => 'fa fa-user', 'users'=> 'fa fa-users' ];
// File: app/system/api/load_settings.php

// Path to your settings.json file
$settingsFile = 'app/system/api/settings.json';

// Check if file exists
if (!file_exists($settingsFile)) {
    die('Settings file not found.');
}



// Get and decode JSON
$jsonData = file_get_contents($settingsFile);
$config = json_decode($jsonData, true);

// Check if JSON parsed correctly
if ($config === null) {
    die('Error parsing JSON: ' . json_last_error_msg());
}

// Example: Access some config values
$config['database'];
$config['project']['name'];
$primary_color = $config['config']['primary_color'];
$accent_color = $config['config']['accent_color'];
 ?>

<?php include_once "app/system/cogs/db.php";?>
<?php include_once "app/system/cogs/functions.php";?>
<?php include_once "app/system/api/get_profile.php";?>
<?php include 'app/api/db_helper.php';?>
<?php 
    $url = $active_user['avatar_url']??'';
    $img = $path."app/system/filemanager/images/avatars/".$url;
    $img = empty($url)?$path.'app/system/filemanager/images/avatars/default.jpeg':$img;



// Fetch all settings and load into $settings associative array
$stmt = $pdo->query("SELECT * FROM settings");
$settings = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $settings[$row['name']] = [
        'id' => $row['id'],
        'name' => $row['name'],
        'value' => $row['value'],
        'type' => $row['type'],
        'status' => $row['status']
    ];
}

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <!-- <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" /> -->


  <!-- Dropzone JS + CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>

  <script>
    tailwind.config = {
      darkMode: 'class',
    };
  </script>



  <style>
    *{
      accent-color: <?= $accent_color ?>;
    }
    .masonry {
      column-count: 4;
      column-gap: 1rem;
    }
    .masonry-item {
      break-inside: avoid;
      margin-bottom: 1rem;
      display: inline-block;
      width: 100%;
    }
    @media (max-width: 1024px) {
      .masonry {
        column-count: 3;
      }
    }
    @media (max-width: 768px) {
      .masonry {
        column-count: 2;
      }
    }
    @media (max-width: 480px) {
      .masonry {
        column-count: 1;
      }
    }
    .sidebar-open {
      transform: translateX(0) !important;
    }
    .dropdown-content {
      display: none;
    }
    .dropdown-open .dropdown-content {
      display: block;
    }
  </style>
  <style>
  @media print {
    body * {
      visibility: hidden;
    }

    #tab-print, #tab-print * {
      visibility: visible;
    }

    #tab-print {
      position: absolute;
      left: 0;
      top: 0;
      width: 100%;
      padding: 0;
      margin: 0;
    }

    .no-print {
      display: none !important;
    }
  }
</style>
<style>

/* Opt-in to customizable styling */
select,
::picker(select) {
  appearance: base-select;
  width: initial;
}

/* Style the select button */
select {
  border: 1px solid #ccc;
  padding: 8px 12px;
  border-radius: 4px;

}

/* Style the dropdown menu (the picker) */
::picker(select) {
  border: 1px solid transparent;
  background: #f9f9f9;
  border-radius: 4px;
  box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
}

/* Style the options within the menu */
option {
  padding: 8px 12px;
  background: white;
}

/* Highlight options on hover or focus */
option:hover,
option:focus {
  background: #e0e0e0;
}
::picker-icon{
    content: '';
    color: rgba(0, 0, 0, 1.0);
}
::checkmark{
    content: '*';
    color: red;
}

/* Scrollbar styling for WebKit browsers (Chrome, Safari, Edge) */
.scrollbar::-webkit-scrollbar {
  width: 8px;
}

.scrollbar::-webkit-scrollbar-track {
  background: transparent; /* Tailwind gray-100 */
}

.scrollbar::-webkit-scrollbar-thumb {
  background-color: #6b7280; /* Tailwind gray-500 */
  border-radius: 9999px;
  /*border: 2px solid #f3f4f6;*/
}

.scrollbar::-webkit-scrollbar-thumb:hover {
  background-color: #374151; /* Tailwind gray-700 */
}

/* Firefox scrollbar */
html {
  /*scrollbar-width: thin;*/
  scrollbar-color: #6b7280 transparent;
}


</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.46.0/dist/apexcharts.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<!-- Material Design Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.2.96/css/materialdesignicons.min.css">

<!-- Unicons -->
<link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

<!-- Dripicons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dripicons/webfont/webfont.css">

  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="description" content="<?= $project_description ?>"/>
  <meta name="keywords" content="<?= $keywords ?>"/>
  <meta name="author" content="<?= $author ?>" />

  <!-- Open Graph / Facebook / WhatsApp -->
  <meta property="og:title" content="<?= $site_name ?> "/>
  <meta property="og:description" content="<?= $project_description ?>"/>
  <meta property="og:image" content="<?= $domain_name ?>app/settings/preview.jpg"/>
  <meta property="og:url" content="<?= $domain_name ?>"/>
  <meta property="og:type" content="website"/>

  <!-- Twitter / X -->
  <meta name="twitter:card" content="summary_large_image"/>
  <meta name="twitter:title" content="<?= $site_name ?>"/>
  <meta name="twitter:description" content="<?= $project_description ?>"/>
  <meta name="twitter:image" content="<?= $domain_name ?>app/settings/preview.jpg"/>
  <meta name="twitter:site" content="@<?= $twitter?>"/>

  <!-- App / Mobile Support -->
  <meta name="theme-color" content="#ffffff"/>
  <meta name="mobile-web-app-capable" content="yes"/>
  <meta name="apple-mobile-web-app-capable" content="yes"/>
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
  <meta name="apple-mobile-web-app-title" content="<?= $project_name ?>"/>
  <link rel="manifest" href="<?= $path?>manifest.json"/>

  <!-- Favicons -->
  <link rel="icon" type="image/png" sizes="32x32" href="<?= $path?>app/system/filemanager/favicons/favicon-32x32.png"/>
  <link rel="icon" type="image/png" sizes="16x16" href="<?= $path?>app/system/filemanager/favicons/favicon-16x16.png"/>
  <link rel="apple-touch-icon" sizes="180x180" href="<?= $path?>app/system/filemanager/favicons/apple-touch-icon.png"/>
  <link rel="mask-icon" href="<?= $path?>app/system/filemanager/favicons/safari-pinned-tab.svg" color="#e60023"/>
  <meta name="msapplication-TileColor" content="#ffffff"/>
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-colors duration-300">

  <!-- HEADER -->
  <header class="fixed top-0 left-0 w-full z-30 bg-white dark:bg-gray-800 shadow px-4 py-2 flex items-center justify-between">
    <div class="flex">

      <button class="hover:bg-gray-100 p-2 rounded-full px-3 hover:text-red-500" onclick="toggleIcons()"><i class="dripicons-menu"></i></button>
    <!-- Logo -->
    <a href = '<?= $path?>' class="flex items-center space-x-2">
        <?= $logo ?>
      <span class="text-xl font-bold text-gray-800 dark:text-white"><?= $site_name ?></span>
    </a>
    </div>

    
<script>
  function toggleIcons() {
    $('[data-txt]').toggleClass('hidden');$('#sidebar').toggleClass('w-64');$('#dashboardSection').toggleClass('max-w-4xl w-full');$('#main-content').toggleClass('md:ml-64 md:ml-32');
    $.post('app/api/toggleSessions.php',{icons:true});
  }
</script>






<!-- Search Container -->
<div class="flex-1 mx-4 max-w-2xl relative">
  <div class="relative w-full">
    <!-- Search Input -->
    <input
      id="headerSearchInput"
      type="text"
      placeholder="Search"
      class="w-full pl-4 pr-12 py-2 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-red-500"
    />

    <!-- Voice Search Button -->
    <button
      id="voiceSearchBtn"
      class="absolute right-8 top-1/2 transform -translate-y-1/2 text-gray-500 dark:text-gray-300 hover:text-red-500"
      title="Search by voice"
    >
      <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round"
          d="M12 1a3 3 0 00-3 3v7a3 3 0 006 0V4a3 3 0 00-3-3zM19 10v2a7 7 0 01-14 0v-2m7 8v4m-4 0h8" />
      </svg>
    </button>

    <!-- Search Button -->
    <button
      id="headerSearchBtn"
      class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 dark:text-gray-300 hover:text-red-500"
    >
      <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round"
          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
      </svg>
    </button>
  </div>

  <!-- Dropdown -->
  <div
    id="searchDropdown"
    class="hidden absolute left-0 top-full mt-1 w-full bg-white dark:bg-gray-800 shadow rounded-lg z-50"
  >
    <ul id="searchResults"></ul>
  </div>
</div>

<script>
  const input = document.getElementById('headerSearchInput');
  const dropdown = document.getElementById('searchDropdown');
  const resultsList = document.getElementById('searchResults');
  const voiceBtn = document.getElementById('voiceSearchBtn');

  // --- Live Search (AJAX to backend) ---
  input.addEventListener('input', async () => {
    const query = input.value.trim();
    if (query.length < 2) {
      dropdown.classList.add('hidden');
      return;
    }

    // Fetch top 5 results from backend
    const res = await fetch(`<?= $path?>search_suggestions?q=${encodeURIComponent(query)}`);
    const results = await res.json();

    resultsList.innerHTML = results
      .map(
        (r) => `
        <li>
          <a href="${r.url}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">
            <span class="font-semibold">${r.title}</span>
            <span class="block text-sm text-gray-500">${r.keywords}</span>
          </a>
        </li>`
      )
      .join('');

    dropdown.classList.remove('hidden');
  });

  // Hide dropdown when clicking outside
  document.addEventListener('click', (e) => {
    if (!e.target.closest('.relative')) dropdown.classList.add('hidden');
  });

  // --- Voice Search ---
  if ('webkitSpeechRecognition' in window || 'SpeechRecognition' in window) {
    const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
    const recognition = new SpeechRecognition();
    recognition.lang = 'en-US';
    recognition.continuous = false;

    voiceBtn.addEventListener('click', () => {
      recognition.start();
      voiceBtn.classList.add('text-red-500');
    });

    recognition.onresult = (event) => {
      const transcript = event.results[0][0].transcript;
      input.value = transcript;
      voiceBtn.classList.remove('text-red-500');
      input.dispatchEvent(new Event('input')); // Trigger search
    };

    recognition.onerror = () => {
      voiceBtn.classList.remove('text-red-500');
      showMessage('Raise your tone...');
    };
  } else {
    voiceBtn.style.display = 'none';
  }
</script>




















    <!-- Right: icons -->
    <div class="flex items-center space-x-3">
      <!-- Create icon -->
      <a href="<?= $path ?>s/Create" class="p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700">
        <svg class="w-6 h-6 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
        </svg>
      </a>








      <!-- Notification -->
      <div class="relative">
        <button id="notifBtn" class="p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700">
          <svg class="w-6 h-6 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
          </svg>
        </button>
        <div id="notifDropdown" class="dropdown-content absolute right-0 top-full mt-1 w-60 bg-white dark:bg-gray-800 shadow-3xl border dark:border-gray-700 rounded-lg">
          <div>
            <a href="<?= $path ?>n/notification1" class="px-4 block py-2 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer rounded-t-lg rounded-b-none">Notification Notification 1</a>
            <a href="<?= $path ?>n/notification1" class="px-4 block py-2 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">Notification Notification 2</a>
            <a href="<?= $path ?>n/notification1" class="px-4 block py-2 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer rounded-t-none rounded-b-lg">Notification Notification 3</a>
          </div>
        </div>
      </div>

      <!-- Profile -->
      <div class="relative">
        <button id="profileBtn" class="p-1 rounded-full hover:ring-2 ring-red-500">
          <img src="<?= $img ?>" alt="User Avatar" class="w-8 h-8 rounded-full">
        </button>
        <div id="profileDropdown" class="dropdown-content absolute right-0 top-full mt-1 w-48 bg-white dark:bg-gray-800 shadow-lg dark:border-gray-700 border rounded-lg">
          <div>
            <a href="<?= $path?>s/profile" class="px-4 py-2 block hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer rounded-t-lg rounded-b-none">
            <i class="mdi mdi-account me-3"></i> Profile</a>
            <a href="<?= $path?>s/settings" class="px-4 py-2 block hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">
            <i class="mdi mdi-cogs me-3"></i> Settings</a>
            <a href="<?= $path?>s/explore" class="px-4 py-2 block hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">
            <i class="mdi mdi-robot me-3"></i> Explore</a>
            <div class="border-t border-gray-200 dark:border-gray-700"></div>
            <a href="<?= $path?>s/report" class="px-4 py-2 block hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">
            <i class="mdi mdi-history me-3"></i> Report history</a>
            <a href="<?= $path?>s/help" class="px-4 py-2 block hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer
              "><i class="mdi mdi-help me-3"></i> Help</a>
            <a href="<?= $path?>s/feedback" class="px-4 py-2 block hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">
            <i class="mdi mdi-message me-3"></i> Send feedback</a>
            <a href="<?= $path?>logout/" class="px-4 py-2 block hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer rounded-t-none rounded-b-lg">
            <i class="mdi mdi-logout me-3"></i> Logout</a>
          </div>
        </div>
      </div>
    </div>
  </header>

  <!-- SIDEBAR -->
  <button id="sidebarToggle" class="md:hidden fixed top-16 left-4 z-30 p-2 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
    <svg class="w-6 h-6 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
    </svg>
  </button>

<!-- Lucide CDN -->
<script src="https://unpkg.com/lucide@latest"></script>

<nav style="margin-top:56px;" id="sidebar" class="fixed left-0 top-0 h-[91%] <?= $class1 ?>  bg-white dark:bg-gray-800 shadow-lg z-20 transform-translate-x-full md:translate-x-0 transition-transform duration-300 overflow-y-auto scrollbar">
  <div class="p-4">
    <ul class="space-y-2">
        <!-- Extra Section -->
      <li class="mt-4"><span class="text-gray-500 dark:text-gray-400 uppercase text-xs">Extra</span></li>

      <li>
        <a title="Dashboard" href="<?= $path?>s/Dashboard" class="flex items-center px-3 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700">
          <i title="Dashboard" data-lucide="home" class="w-5 h-5 mr-3 text-gray-600 dark:text-gray-300"></i>

          <span data-txt class="<?= $class0 ?>">Dashboard</span>

        </a>
      </li>

      <li>
        <a title="Search" href="<?= $path?>s/Search" class="flex items-center px-3 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700">
          <i title="Search" data-lucide="search" class="w-5 h-5 mr-3 text-gray-600 dark:text-gray-300"></i>

          <span data-txt class="<?= $class0 ?>">Search</span>
        </a>
      </li>

      <li>
        <a title="Create" href="<?= $path?>s/Create" class="flex items-center px-3 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700">
          <i title="Create" data-lucide="plus-square" class="w-5 h-5 mr-3 text-gray-600 dark:text-gray-300"></i>

          <span data-txt class="<?= $class0 ?>">Create</span>
        </a>
      </li>

      <li>
        <a title="Content" href="<?= $path?>s/Content" class="flex items-center px-3 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700">
          <i title="Content" data-lucide="file-text" class="w-5 h-5 mr-3 text-gray-600 dark:text-gray-300"></i>

          <span data-txt class="<?= $class0 ?>">Content</span>
        </a>
      </li>

      <li>
        <a title="Analytics" href="<?= $path?>s/Analytics" class="flex items-center px-3 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700">
          <i title="Analytics" data-lucide="bar-chart-2" class="w-5 h-5 mr-3 text-gray-600 dark:text-gray-300"></i>

          <span data-txt class="<?= $class0 ?>">Analytics</span>
        </a>
      </li>
      <!-- You Section -->
      <li><span class="text-gray-500 dark:text-gray-400 uppercase text-xs">You</span></li>

      <li>
        <a title="History" href="<?= $path?>s/History" class="flex items-center px-3 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700">
          <i title="History" data-lucide="list" class="w-5 h-5 mr-3 text-gray-600 dark:text-gray-300"></i>

          <span data-txt class="<?= $class0 ?>">History</span>
        </a>
      </li>

      <!-- Your Section -->
      <li class="mt-4"><span class="text-gray-500 dark:text-gray-400 uppercase text-xs">Your</span></li>

      <li>
        <a title="Profile" href="<?= $path?>s/Profile" class="flex items-center px-3 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700">
          <i title="Profile" data-lucide="user" class="w-5 h-5 mr-3 text-gray-600 dark:text-gray-300"></i>

          <span data-txt class="<?= $class0 ?>">Profile</span>
        </a>
      </li>

      <li>
        <a title="Settings" href="<?= $path?>s/Settings" class="flex items-center px-3 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700">
          <i title="Settings" data-lucide="settings" class="w-5 h-5 mr-3 text-gray-600 dark:text-gray-300"></i>

          <span data-txt class="<?= $class0 ?>">Settings</span>
        </a>
      </li>

      <li>
        <a title="Explore" href="<?= $path?>s/Explore" class="flex items-center px-3 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700">
          <i title="Explore" data-lucide="compass" class="w-5 h-5 mr-3 text-gray-600 dark:text-gray-300"></i>

          <span data-txt class="<?= $class0 ?>">Explore</span>
        </a>
      </li>

      <!-- Settings Section -->
      <li class="mt-4"><span class="text-gray-500 dark:text-gray-400 uppercase text-xs">Settings</span></li>

      <li>
        <a title="Report" href="<?= $path?>s/Report" class="flex items-center px-3 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700">
          <i title="Report" data-lucide="flag" class="w-5 h-5 mr-3 text-gray-600 dark:text-gray-300"></i>

          <span data-txt class="<?= $class0 ?>">Report</span>
        </a>
      </li>

      <li>
        <a title="Help" href="<?= $path?>s/Help" class="flex items-center px-3 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700">
          <i title="Help" data-lucide="help-circle" class="w-5 h-5 mr-3 text-gray-600 dark:text-gray-300"></i>

          <span data-txt class="<?= $class0 ?>">Help</span>
        </a>
      </li>

      <li>
        <a title="Send" href="<?= $path?>s/feedback" class="flex items-center px-3 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700">
          <i title="Send feedback" data-lucide="message-square" class="w-5 h-5 mr-3 text-gray-600 dark:text-gray-300"></i>

          <span data-txt class="<?= $class0 ?>">Send feedback</span>
        </a>
      </li>

      <li>
        <a title="Sql runner" href="<?= $path?>s/query" class="flex items-center px-3 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700">
          <i title="Sql runner" class="w-5 h-5 mr-3 text-gray-600 dark:text-gray-300 fa fa-code"></i>

          <span data-txt class="<?= $class0 ?>">SQL runner</span>
        </a>
      </li>

      <li>
        <a title="File Manager" href="<?= $path?>s/filemanager" class="flex items-center px-3 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700">
          <i title="File Manager" class="w-5 h-5 mr-3 text-gray-600 dark:text-gray-300 fa fa-folder"></i>

          <span data-txt class="<?= $class0 ?>">File Manager</span>
        </a>
      </li>
      <li>
        <a title="cmd" href="<?= $path?>s/cmd" class="flex items-center px-3 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700">
          <i title="cmd" class="w-5 h-5 mr-3 text-gray-600 dark:text-gray-300 fa fa-terminal"></i>

          <span data-txt class="<?= $class0 ?>">CMD</span>
        </a>
      </li>

      <li>
        <button title="Dark Mode" id="darkModeToggle" class="flex items-center w-full px-3 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700">
          <i title="Dark Mode" data-lucide="moon" id="darkModeIcon" class="w-5 h-5 mr-3 text-gray-600 dark:text-gray-300"></i>

          <span data-txt class="<?= $class0 ?>"><span id="darkModeText">Dark Mode</span></span>
        </button>
      </li>
    </ul>
  </div>
</nav>

<script>
  lucide.createIcons();
</script>


  <!-- overlay for mobile -->
  <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-10 hidden md:hidden"></div>

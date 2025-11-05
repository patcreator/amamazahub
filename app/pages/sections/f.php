<!-- FOOTER -->
 <footer class="bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 mt-8  hidden">
    <div class="max-w-6xl mx-auto px-4 py-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
      <div>
        <h3 class="font-semibold mb-2"><?= $company_name?></h3>
        <ul>
          <li><a href="#" class="hover:text-red-500">About</a></li>
          <li><a href="#" class="hover:text-red-500">Press</a></li>
          <li><a href="#" class="hover:text-red-500">Contact us</a></li>
          <li><a href="#" class="hover:text-red-500">Creators</a></li>
        </ul>
      </div>
      <div>
        <h3 class="font-semibold mb-2">More</h3>
        <ul>
          <li><a href="#" class="hover:text-red-500">Advertise</a></li>
          <li><a href="#" class="hover:text-red-500">Developers</a></li>
          <li><a href="#" class="hover:text-red-500">Terms</a></li>
          <li><a href="#" class="hover:text-red-500">Privacy Policy & Safety</a></li>
        </ul>
      </div>
      <div>
        <h3 class="font-semibold mb-2">How it works</h3>
        <ul>
          <li><a href="#" class="hover:text-red-500">How this website works</a></li>
          <li><a href="#" class="hover:text-red-500">Test new features</a></li>
        </ul>
      </div>
      <div class="col-span-1 sm:col-span-2 lg:col-span-1 flex items-end justify-center lg:justify-end">
        <p class="text-sm">&copy; 2025 Company</p>
      </div>
    </div>
  </footer>



 <!-- Alert Container -->
<div id="alert-container" class="z-50 fixed top-10 left-0 w-full text-center"></div>

<!-- Heroicons CDN -->
<script src="https://unpkg.com/heroicons@2.0.18/dist/heroicons.min.js"></script>

<script>
  const colors = {
    success: 'bg-green-500 text-white',
    error: 'bg-red-500 text-white',
    warning: 'bg-yellow-400 text-black',
    info: 'bg-blue-500 text-white',
    dark: 'bg-gray-800 text-white',
    light: 'bg-gray-200 text-black'
  };

const icons = {
    success: `<span class="inline-flex items-center justify-center h-4 w-4 rounded-full border-1 border border-current mr-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
              </span>`,
    error: `<span class="inline-flex items-center justify-center h-4 w-4 rounded-full border-1 border border-current mr-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </span>`,
    warning: `<span class="inline-flex items-center justify-center h-4 w-4 rounded-full border-1 border border-current mr-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M12 2a10 10 0 11-10 10A10 10 0 0112 2z" />
                </svg>
              </span>`,
    info: `<span class="inline-flex items-center justify-center h-4 w-4 rounded-full border-1 border border-current mr-2">
             <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 1010 10A10 10 0 0012 2z" />
             </svg>
           </span>`,
    light: `<span class="inline-flex items-center justify-center h-4 w-4 rounded-full border-1 border border-current mr-2">
             <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 1010 10A10 10 0 0012 2z" />
             </svg>
           </span>`,
    dark: `<span class="inline-flex items-center justify-center h-4 w-4 rounded-full border-1 border border-current mr-2">
             <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 1010 10A10 10 0 0012 2z" />
             </svg>
           </span>`
  };

  function showMessage(message, type = 'error', time = 2000) {
    const alertContainer = document.getElementById('alert-container');
    const alert = document.createElement('span');
    alert.className = `shadow-lg transform transition-all duration-300 translate-y-[-20px] rounded-lg px-4 py-2 mb-3 inline-flex items-center justify-center ${colors[type] || colors.info}`;
    alert.innerHTML = `${icons[type] || ''}${message}`;

    alertContainer.appendChild(alert);
    alertContainer.classList.remove('opacity-0');
    // Show animation
    setTimeout(() => alertContainer.classList.add('opacity-100'), 10);

    // Hide after timeout
    setTimeout(() => {
       alertContainer.classList.add('opacity-0');
       alertContainer.innerHTML = '';
    }, time);
  }
</script>



  <!-- SCRIPTS -->
  <script>
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');

    sidebarToggle.addEventListener('click', () => {
      sidebar.classList.add('sidebar-open');
      overlay.classList.remove('hidden');
      sidebarToggle.classList.add('hidden');
    });
    function closeSidebar() {
      sidebar.classList.remove('sidebar-open');
      overlay.classList.add('hidden');
      sidebarToggle.classList.remove('hidden');
    }
    overlay.addEventListener('click', closeSidebar);

    // Dropdown toggles
    const headerSearchInput = document.getElementById('headerSearchInput');
    const searchDropdown = document.getElementById('searchDropdown');
    headerSearchInput.addEventListener('focus', () => {
      searchDropdown.parentElement.classList.add('dropdown-open');
    });
    headerSearchInput.addEventListener('blur', () => {
      setTimeout(() => {
        searchDropdown.parentElement.classList.remove('dropdown-open');
      }, 200);
    });

    const notifBtn = document.getElementById('notifBtn');
    const notifDropdown = document.getElementById('notifDropdown');
    notifBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      notifDropdown.parentElement.classList.toggle('dropdown-open');
      profileDropdown.parentElement.classList.remove('dropdown-open');
    });

    const profileBtn = document.getElementById('profileBtn');
    const profileDropdown = document.getElementById('profileDropdown');
    profileBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      profileDropdown.parentElement.classList.toggle('dropdown-open');
      notifDropdown.parentElement.classList.remove('dropdown-open');
    });

    window.addEventListener('click', () => {
      notifDropdown.parentElement.classList.remove('dropdown-open');
      profileDropdown.parentElement.classList.remove('dropdown-open');
    });

    if (localStorage.getItem('theme') === 'dark') {
      document.documentElement.classList.add('dark');
    }


    const darkModeToggle = document.getElementById('darkModeToggle');

darkModeToggle.addEventListener('click', () => {
  document.documentElement.classList.toggle('dark');

  // Save preference in localStorage
  if (document.documentElement.classList.contains('dark')) {
    localStorage.setItem('theme', 'dark');
  } else {
    localStorage.setItem('theme', 'light');
  }
});

  </script>
<script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <?php  include 'app/api/ajax.php'; ?>
<script>
  if ("serviceWorker" in navigator) {
    navigator.serviceWorker.register("<?= $path?>service-worker.js")
      .then(() => console.log("Service Worker registered"))
      .catch(err => console.error("SW failed:", err));
  }
</script>

</body>
</html>

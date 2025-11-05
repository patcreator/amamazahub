
<div class="min-h-screen bg-gray-100 mx-6  dark:bg-gray-800 text-gray-900 p-6  rounded-3xl border dark:border-gray-700 py-8">
  <div class="max-w-6xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
      <h1 class="text-3xl font-bold dark:text-gray-200">Settings Dashboard</h1>
      <p class="text-gray-500 mt-2">Manage your application settings and preferences</p>
    </div>

    <!-- Tabs -->
    <div class="border-b border-gray-300 dark:border-gray-700 mb-6">
      <div class="flex space-x-1">
        <button class="tab-btn px-4 py-2 text-sm font-medium rounded-t-md bg-red-600 text-white" data-tab="general">General</button>
        <button class="tab-btn px-4 py-2 text-sm font-medium rounded-t-md bg-gray-200 text-gray-600" data-tab="account">Account</button>
        <button class="tab-btn px-4 py-2 text-sm font-medium rounded-t-md bg-gray-200 text-gray-600" data-tab="notifications">Notifications</button>
        <button class="tab-btn px-4 py-2 text-sm font-medium rounded-t-md bg-gray-200 text-gray-600" data-tab="privacy">Privacy</button>
        <button class="tab-btn px-4 py-2 text-sm font-medium rounded-t-md bg-gray-200 text-gray-600" data-tab="appearance">Appearance</button>
      </div>
    </div>

    <!-- Settings Sections -->
    <div class="bg-white dark:bg-gray-700 dark:text-gray-300 dark:border-gray-700   rounded-lg border border-gray-300 p-6">
      <!-- General Tab -->
      <div class="tab-content" id="tab-general">
        <h2 class="text-xl font-semibold mb-6">General Settings</h2>




        <div>
          <form id="settingsForm" class="space-y-6">
            
            <!-- Site Logo -->
            <div>
              <label class="block font-medium text-gray-700 dark:text-gray-200">Logo</label>
              <div class="flex items-center gap-4 mt-2">
                <img id="logoPreview" src="<?= htmlspecialchars($settings['logo']['value'] ?? 'default.png') ?>" class="w-16 h-16 object-cover rounded" alt="Logo">
                <input type="file" id="logoUpload" accept="image/*" class="border rounded p-2">
              </div>
            </div>

            <!-- Site Name -->
            <div>
              <label class="block font-medium text-gray-700 dark:text-gray-200">Website Name</label>
              <input type="text" data-id="<?= $settings['name']['id'] ?>" value="<?= htmlspecialchars($settings['name']['value'] ?? '') ?>"
                class="setting-input w-full mt-2 p-2 border rounded bg-gray-50 dark:bg-gray-700 dark:text-gray-100">
            </div>

            <!-- Description -->
            <div>
              <label class="block font-medium text-gray-700 dark:text-gray-200">Description</label>
              <textarea data-id="<?= $settings['description']['id'] ?>" class="setting-input w-full mt-2 p-2 border rounded bg-gray-50 dark:bg-gray-700 dark:text-gray-100"><?= htmlspecialchars($settings['description']['value'] ?? '') ?></textarea>
            </div>

            <!-- Author -->
            <div>
              <label class="block font-medium text-gray-700 dark:text-gray-200">Author</label>
              <input type="text" data-id="<?= $settings['author']['id'] ?>" value="<?= htmlspecialchars($settings['author']['value'] ?? '') ?>"
                class="setting-input w-full mt-2 p-2 border rounded bg-gray-50 dark:bg-gray-700 dark:text-gray-100">
            </div>

            <!-- URL -->
            <div>
              <label class="block font-medium text-gray-700 dark:text-gray-200">Website URL</label>
              <input type="text" data-id="<?= $settings['url']['id'] ?>" value="<?= htmlspecialchars($settings['url']['value'] ?? '') ?>"
                class="setting-input w-full mt-2 p-2 border rounded bg-gray-50 dark:bg-gray-700 dark:text-gray-100">
            </div>

            <!-- Toggle Settings -->
            <div class="grid md:grid-cols-2 gap-4">
              <?php
              $toggles = [
                'sidebar_menu' => 'Show Sidebar Menu',
                'header_menu' => 'Show Header Menu',
                'footer_show' => 'Show Footer',
                'dark_mode' => 'Dark Mode',
                'about_us_link' => 'Show About Us Link',
                'terms_link' => 'Show Terms Link',
                'policies_link' => 'Show Policies Link',
                'create_user' => 'Allow User Creation'
              ];

              foreach ($toggles as $key => $label): ?>
                <div class="flex items-center justify-between bg-gray-100 dark:bg-gray-700 p-3 rounded">
                  <span class="text-gray-800 dark:text-gray-100"><?= $label ?></span>
                  <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" data-id="<?= $settings[$key]['id'] ?>"
                           class="setting-toggle sr-only"
                           <?= ($settings[$key]['value'] ?? '0') == '1' ? 'checked' : '' ?>>
                    <div class="w-11 h-6 bg-gray-300 rounded-full peer peer-checked:bg-blue-600 transition"></div>
                    <div class="absolute left-0.5 top-0.5 bg-white w-5 h-5 rounded-full peer-checked:translate-x-5 transition"></div>
                  </label>
                </div>
              <?php endforeach; ?>
            </div>

          </form>

          <div id="msgBox" class="mt-6 text-sm text-center"></div>
        </div>


<script>
// Change text or textarea instantly
document.querySelectorAll('.setting-input').forEach(input => {
  input.addEventListener('change', async e => {
    const id = e.target.dataset.id;
    const newValue = e.target.value;
    await updateSetting(id, newValue);
  });
});

// Change toggles
document.querySelectorAll('.setting-toggle').forEach(toggle => {
  toggle.addEventListener('change', async e => {
    const id = e.target.dataset.id;
    const newValue = e.target.checked ? '1' : '0';
    await updateSetting(id, newValue);
  });
});

// Upload logo
document.getElementById('logoUpload')?.addEventListener('change', async e => {
  const file = e.target.files[0];
  if (!file) return;

  const formData = new FormData();
  formData.append('logo', file);
  formData.append('id', '<?= $settings['logo']['id'] ?>');

  const res = await fetch('change_settings.php', { method: 'POST', body: formData });
  const data = await res.json();
  showMessage(data.message, data.success);
  if (data.success) document.getElementById('logoPreview').src = URL.createObjectURL(file);
});

async function updateSetting(id, newValue) {
  const res = await fetch(`change_settings.php?id=${id}&new_value=${encodeURIComponent(newValue)}`);
  const data = await res.json();
  showMessage(data.message, data.success);
}

function showMessage(msg, success) {
  const box = document.getElementById('msgBox');
  box.textContent = msg;
  box.className = `mt-6 text-center text-sm ${success ? 'text-green-600' : 'text-red-600'}`;
}
</script>














      </div>

      <!-- Account Tab -->
      <div class="tab-content hidden" id="tab-account">
        <h2 class="text-xl font-semibold mb-6">Account Settings</h2>

        <div class="space-y-4">
          <div class="border border-gray-300 dark:border-gray-700 dark:bg-gray-800 rounded-lg">
            <button
              class="w-full flex items-center justify-between p-4 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 transition-colors"
              onclick="toggleSection('account-options')"
            >
              <h3 class="font-semibold">Account Options</h3>
              <svg id="icon-account-options" class="w-5 h-5 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>

            <div id="section-account-options" class="p-4 space-y-4 hidden">
              <div class="flex items-center justify-between py-3 border-b border-gray-200">
                <div class="flex-1">
                  <h4 class="font-medium">Email Notifications</h4>
                  <p class="text-sm text-gray-500">Last updated: Jan 12, 2024 2:20 PM</p>
                </div>
                <div class="flex items-center space-x-4">
                  <div class="flex items-center">
                    <div class="w-3 h-3 rounded-full bg-green-500"></div>
                    <span class="ml-2 text-sm">Enabled</span>
                  </div>
                  <button class="text-blue-600 hover:text-blue-800 text-sm font-medium">Edit</button>
                </div>
              </div>

              <div class="flex items-center justify-between py-3 border-b border-gray-200">
                <div class="flex-1">
                  <h4 class="font-medium">Two-Factor Authentication</h4>
                  <p class="text-sm text-gray-500">Last updated: Jan 8, 2024 11:15 AM</p>
                </div>
                <div class="flex items-center space-x-4">
                  <div class="flex items-center">
                    <div class="w-3 h-3 rounded-full bg-red-500"></div>
                    <span class="ml-2 text-sm">Disabled</span>
                  </div>
                  <button class="text-blue-600 hover:text-blue-800 text-sm font-medium">Edit</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Notifications Tab -->
      <div class="tab-content hidden" id="tab-notifications">
        <h2 class="text-xl font-semibold mb-6">Notifications Settings</h2>

        <div class="space-y-4">
          <div class="border border-gray-300 dark:border-gray-700 dark:bg-gray-800 rounded-lg">
            <button
              class="w-full flex items-center justify-between p-4 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 transition-colors"
              onclick="toggleSection('notifications-options')"
            >
              <h3 class="font-semibold">Notification Options</h3>
              <svg id="icon-notifications-options" class="w-5 h-5 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>

            <div id="section-notifications-options" class="p-4 space-y-4 hidden">
              <div class="flex items-center justify-between py-3 border-b border-gray-200">
                <div class="flex-1">
                  <h4 class="font-medium">Push Notifications</h4>
                  <p class="text-sm text-gray-500">Last updated: Jan 13, 2024 8:30 AM</p>
                </div>
                <div class="flex items-center space-x-4">
                  <div class="flex items-center">
                    <div class="w-3 h-3 rounded-full bg-green-500"></div>
                    <span class="ml-2 text-sm">Enabled</span>
                  </div>
                  <button class="text-blue-600 hover:text-blue-800 text-sm font-medium">Edit</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Privacy Tab -->
      <div class="tab-content hidden" id="tab-privacy">
        <h2 class="text-xl font-semibold mb-6">Privacy Settings</h2>
        <p class="text-gray-600 dark:text-gray-300">Data Collection: <span class="font-medium">Limited</span></p>
        <p class="text-gray-600 dark:text-gray-300">Analytics Tracking: <span class="font-medium">Enabled</span></p>
      </div>

      <!-- Appearance Tab -->
      <div class="tab-content hidden" id="tab-appearance">
        <h2 class="text-xl font-semibold mb-6">Appearance Settings</h2>
        <p class="text-gray-600 dark:text-gray-300">Theme: <span class="font-medium">Light</span></p>
        <p class="text-gray-600 dark:text-gray-300">Font Size: <span class="font-medium">Medium</span></p>
      </div>
    </div>
  </div>

  <!-- jQuery logic -->
  <script>
    // expose a global toggleSection so inline onclick attributes work
    window.toggleSection = function(id) {
      const $section = $('#section-' + id);
      const $icon = $('#icon-' + id);
      $section.toggleClass('hidden');
      $icon.toggleClass('rotate-180');
    };

    // run when DOM is ready
    $(function() {
      // Ensure initial state - show general tab
      $('.tab-content').addClass('hidden');
      $('#tab-general').removeClass('hidden');

      // Tabs click handler (jQuery)
      $('.tab-btn').on('click', function() {
        const target = $(this).data('tab');

        // style active tab
        $('.tab-btn').removeClass('bg-red-600 text-white').addClass('bg-gray-200 text-gray-600');
        $(this).removeClass('bg-gray-200 text-gray-600').addClass('bg-red-600 text-white');

        // show target content, hide others
        $('.tab-content').addClass('hidden');
        $('#tab-' + target).removeClass('hidden');

        // optional: hide any open accordion sections inside newly shown tab
        $('#tab-' + target).find('[id^="section-"]').addClass('hidden');
        $('#tab-' + target).find('[id^="icon-"]').removeClass('rotate-180');
      });

      // (Optional) Allow Enter/Space on focused tab buttons for accessibility
      $('.tab-btn').on('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          $(this).trigger('click');
        }
      });
    });
  </script>
</div>

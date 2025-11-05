    <!-- BEGIN: Expanded 26-card Masonry Dashboard Section -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
<style>
  /* Pinterest-style masonry columns */
  .masonry {
    column-count: 4;
    column-gap: 1rem;
  }
  @media (max-width: 1280px) { .masonry { column-count: 3; } }
  @media (max-width: 1024px) { .masonry { column-count: 2; } }
  @media (max-width: 640px)  { .masonry { column-count: 1; } }
  .masonry-item {
    break-inside: avoid;
    margin-bottom: 1rem;
  }
  /* Card maximize styles helper */
  .card-maximized {
    position: fixed !important;
    inset: 2rem !important;
    z-index: 9999 !important;
    width: auto !important;
    height: auto !important;
    margin: 0 !important;
    overflow: auto !important;
    border-radius: 0.5rem !important;
  }
  .card{
    backdrop-filter: blur(10px);
  }
  *{
    accent-color: red;
  }
</style>

<section class="p-6 rounded-xl bg-[url(../app/pages/s/397fced5-e831-4cbd-b734-5bae10d5549b.jpeg)]" style="background-attachment: fixed;" >
  <h1 class="text-3xl font-bold my-12 text-white">Welcome to <?= $site_name ?></h1>
  <div id="dashboard" class="masonry">

    <!-- 1. Searches -->
    <div class="masonry-item">
      <div class="card bg-white/75 rounded-2xl shadow-md overflow-hidden transition hover:shadow-lg" data-url-content="/data/searches">
        <div class="flex items-center justify-between px-4 py-3 bg-gray-50 border-b border-gray-200">
          <h2 class="font-semibold text-lg text-gray-700"><i class="fa-solid fa-magnifying-glass me-1 text-red-500"></i> Searches</h2>
          <div class="flex items-center space-x-2 text-gray-500">
            <button class="collapse-btn" title="Collapse"><i class="fa-solid fa-angle-down"></i></button>
            <button class="reload-btn" title="Reload"><i class="fa-solid fa-rotate-right"></i></button>
            <button class="max-btn" title="Maximize"><i class="fa-solid fa-up-right-and-down-left-from-center"></i></button>
          </div>
        </div>
        <div class="card-content p-4">
          <input type="text" placeholder="Search users, reports, content..." class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200">
          <div class="mt-3 text-sm text-gray-500">Quick filters: <button class="text-pink-600 underline">Users</button> • <button class="text-pink-600 underline">Reports</button> • <button class="text-pink-600 underline">Content</button></div>
        </div>
      </div>
    </div>

    <!-- 2. Settings -->
    <div class="masonry-item">
      <div class="card bg-white/75 rounded-2xl shadow-md overflow-hidden transition hover:shadow-lg" data-url-content="/data/settings">
        <div class="flex items-center justify-between px-4 py-3 bg-gray-50 border-b border-gray-200">
          <h2 class="font-semibold text-lg text-gray-700"><i class="fa-solid fa-gear me-1 text-red-500"></i> Settings</h2>
          <div class="flex items-center space-x-2 text-gray-500">
            <button class="collapse-btn" title="Collapse"><i class="fa-solid fa-angle-down"></i></button>
            <button class="reload-btn" title="Reload"><i class="fa-solid fa-rotate-right"></i></button>
            <button class="max-btn" title="Maximize"><i class="fa-solid fa-up-right-and-down-left-from-center"></i></button>
          </div>
        </div>
        <div class="card-content p-4">
          <div class="grid grid-cols-1 gap-2">
            <div class="flex justify-between"><span>Site name</span><span class="text-gray-600">My Awesome Site</span></div>
            <div class="flex justify-between"><span>Default role</span><span class="text-gray-600">User</span></div>
            <div class="flex justify-between"><span>Session timeout</span><span class="text-gray-600">30 min</span></div>
            <div class="flex justify-between"><span>Email from</span><span class="text-gray-600">noreply@example.com</span></div>
            <a href="#" class="mt-3 inline-block text-pink-600">Open full settings page</a>
          </div>
        </div>
      </div>
    </div>

    <!-- 3. Helpful Links -->
    <div class="masonry-item">
      <div class="card bg-white/75 rounded-2xl shadow-md overflow-hidden transition hover:shadow-lg" data-url-content="/data/links">
        <div class="flex items-center justify-between px-4 py-3 bg-gray-50 border-b border-gray-200">
          <h2 class="font-semibold text-lg text-gray-700"><i class="fa-solid fa-link me-1 text-red-500"></i> Helpful Links</h2>
          <div class="flex items-center space-x-2 text-gray-500">
            <button class="collapse-btn"><i class="fa-solid fa-angle-down"></i></button>
            <button class="reload-btn"><i class="fa-solid fa-rotate-right"></i></button>
            <button class="max-btn"><i class="fa-solid fa-up-right-and-down-left-from-center"></i></button>
          </div>
        </div>
        <div class="card-content p-4">
          <ul class="list-disc ml-5 space-y-1">
            <li><a href="#" class="text-pink-600">Documentation</a></li>
            <li><a href="#" class="text-pink-600">API Reference</a></li>
            <li><a href="#" class="text-pink-600">Developer Forum</a></li>
            <li><a href="#" class="text-pink-600">Support Center</a></li>
          </ul>
        </div>
      </div>
    </div>

    <!-- 4. New Users (summary) -->
    <div class="masonry-item">
      <div class="card bg-white/75 rounded-2xl shadow-md overflow-hidden transition hover:shadow-lg" data-url-content="/data/new-users-summary">
        <div class="flex items-center justify-between px-4 py-3 bg-gray-50 border-b border-gray-200">
          <h2 class="font-semibold text-lg text-gray-700"><i class="fa-solid fa-users me-1 text-red-500"></i> New Users (Summary)</h2>
          <div class="flex items-center space-x-2 text-gray-500">
            <button class="collapse-btn"><i class="fa-solid fa-angle-down"></i></button>
            <button class="reload-btn"><i class="fa-solid fa-rotate-right"></i></button>
            <button class="max-btn"><i class="fa-solid fa-up-right-and-down-left-from-center"></i></button>
          </div>
        </div>
        <div class="card-content p-4">
          <p class="text-sm text-gray-600">10 users registered in the last 24 hours. Top sources: organic, referral.</p>
          <div class="mt-3 flex gap-2">
            <div class="bg-gray-50 rounded p-3 text-sm"><b>10</b><div class="text-xs text-gray-500">New registrations</div></div>
            <div class="bg-gray-50 rounded p-3 text-sm"><b>2</b><div class="text-xs text-gray-500">Invited</div></div>
            <div class="bg-gray-50 rounded p-3 text-sm"><b>8</b><div class="text-xs text-gray-500">Self sign-ups</div></div>
          </div>
        </div>
      </div>
    </div>

    <!-- 5. 10 New Registered Data (table) -->
    <div class="masonry-item">
      <div class="card bg-white/75 rounded-2xl shadow-md overflow-hidden transition hover:shadow-lg" data-url-content="/data/new-registered-table">
        <div class="flex items-center justify-between px-4 py-3 bg-gray-50 border-b border-gray-200">
          <h2 class="font-semibold text-lg text-gray-700"><i class="fa-solid fa-table-list me-1 text-red-500"></i> 10 New Registered Users (Table)</h2>
          <div class="flex items-center space-x-2 text-gray-500">
            <button class="collapse-btn"><i class="fa-solid fa-angle-down"></i></button>
            <button class="reload-btn"><i class="fa-solid fa-rotate-right"></i></button>
            <button class="max-btn"><i class="fa-solid fa-up-right-and-down-left-from-center"></i></button>
          </div>
        </div>
        <div class="card-content p-4 overflow-x-auto">
          <table class="min-w-full text-sm">
            <thead class="bg-gray-50 border-b font-medium">
              <tr><th class="p-2">ID</th><th class="p-2">Name</th><th class="p-2">Email</th><th class="p-2">View</th></tr>
            </thead>
            <tbody>
              <tr class="border-b"><td class="p-2">101</td><td class="p-2">Ana Perez</td><td class="p-2">ana@example.com</td><td class="p-2"><a href="#" class="text-pink-600">View</a></td></tr>
              <tr class="border-b"><td class="p-2">102</td><td class="p-2">Brian Kim</td><td class="p-2">brian@example.com</td><td class="p-2"><a href="#" class="text-pink-600">View</a></td></tr>
              <tr class="border-b"><td class="p-2">103</td><td class="p-2">Chloe Zhang</td><td class="p-2">chloe@example.com</td><td class="p-2"><a href="#" class="text-pink-600">View</a></td></tr>
              <tr class="border-b"><td class="p-2">104</td><td class="p-2">David Roe</td><td class="p-2">david@example.com</td><td class="p-2"><a href="#" class="text-pink-600">View</a></td></tr>
              <tr class="border-b"><td class="p-2">105</td><td class="p-2">Eve Moss</td><td class="p-2">eve@example.com</td><td class="p-2"><a href="#" class="text-pink-600">View</a></td></tr>
              <tr class="border-b"><td class="p-2">106</td><td class="p-2">Femi Ade</td><td class="p-2">femi@example.com</td><td class="p-2"><a href="#" class="text-pink-600">View</a></td></tr>
              <tr class="border-b"><td class="p-2">107</td><td class="p-2">Gina Lu</td><td class="p-2">gina@example.com</td><td class="p-2"><a href="#" class="text-pink-600">View</a></td></tr>
              <tr class="border-b"><td class="p-2">108</td><td class="p-2">Hector P</td><td class="p-2">hector@example.com</td><td class="p-2"><a href="#" class="text-pink-600">View</a></td></tr>
              <tr class="border-b"><td class="p-2">109</td><td class="p-2">Ivy Park</td><td class="p-2">ivy@example.com</td><td class="p-2"><a href="#" class="text-pink-600">View</a></td></tr>
              <tr><td class="p-2">110</td><td class="p-2">Joel M</td><td class="p-2">joel@example.com</td><td class="p-2"><a href="#" class="text-pink-600">View</a></td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- 6. Add New Data (list of tables) -->
    <div class="masonry-item">
      <div class="card bg-white/75 rounded-2xl shadow-md overflow-hidden transition hover:shadow-lg" data-url-content="/data/add-new">
        <div class="flex items-center justify-between px-4 py-3 bg-gray-50 border-b border-gray-200">
          <h2 class="font-semibold text-lg text-gray-700"><i class="fa-solid fa-circle-plus me-1 text-red-500"></i> Add New Data</h2>
          <div class="flex items-center space-x-2 text-gray-500">
            <button class="collapse-btn"><i class="fa-solid fa-angle-down"></i></button>
            <button class="reload-btn"><i class="fa-solid fa-rotate-right"></i></button>
            <button class="max-btn"><i class="fa-solid fa-up-right-and-down-left-from-center"></i></button>
          </div>
        </div>
        <div class="card-content p-4">
          <p class="text-sm text-gray-600">Pick a table to add new rows:</p>
          <ul class="mt-2 list-disc ml-5">
            <li>Users</li>
            <li>Products</li>
            <li>Orders</li>
            <li>Feedback</li>
            <li>Newsletters</li>
          </ul>
          <button class="mt-3 bg-gray-700 text-white px-4 py-2 rounded-lg">Create New Row</button>
        </div>
      </div>
    </div>

    <!-- 7. Change Table Icons -->
    <div class="masonry-item">
      <div class="card bg-white/75 rounded-2xl shadow-md overflow-hidden transition hover:shadow-lg" data-url-content="/data/change-icons">
        <div class="flex items-center justify-between px-4 py-3 bg-gray-50 border-b border-gray-200">
          <h2 class="font-semibold text-lg text-gray-700"><i class="fa-solid fa-icons me-1 text-red-500"></i> Change Table Icons</h2>
          <div class="flex items-center space-x-2 text-gray-500">
            <button class="collapse-btn"><i class="fa-solid fa-angle-down"></i></button>
            <button class="reload-btn"><i class="fa-solid fa-rotate-right"></i></button>
            <button class="max-btn"><i class="fa-solid fa-up-right-and-down-left-from-center"></i></button>
          </div>
        </div>
        <div class="card-content p-4">
          <div class="grid grid-cols-2 gap-3">
            <div class="flex items-center gap-2"><i class="fa-solid fa-users"></i> Users</div>
            <div class="flex items-center gap-2"><i class="fa-solid fa-box"></i> Products</div>
            <div class="flex items-center gap-2"><i class="fa-solid fa-shopping-cart"></i> Orders</div>
            <div class="flex items-center gap-2"><i class="fa-solid fa-comment-dots"></i> Feedback</div>
          </div>
          <div class="mt-3 text-sm text-gray-500">Click an item to change its icon (placeholder).</div>
        </div>
      </div>
    </div>

    <!-- 8. Active Users (chart placeholder) -->
    <div class="masonry-item">
      <div class="card bg-white/75 rounded-2xl shadow-md overflow-hidden transition hover:shadow-lg" data-url-content="/data/active-users">
        <div class="flex items-center justify-between px-4 py-3 bg-gray-50 border-b border-gray-200">
          <h2 class="font-semibold text-lg text-gray-700"><i class="fa-solid fa-chart-line me-1 text-red-500"></i> Active Users</h2>
          <div class="flex items-center space-x-2 text-gray-500">
            <button class="collapse-btn"><i class="fa-solid fa-angle-down"></i></button>
            <button class="reload-btn"><i class="fa-solid fa-rotate-right"></i></button>
            <button class="max-btn"><i class="fa-solid fa-up-right-and-down-left-from-center"></i></button>
          </div>
        </div>
        <div class="card-content p-4">
          <div class="border border-dashed rounded-lg py-8 text-center text-gray-400">[Active Users Chart Placeholder]</div>
          <div class="mt-3 text-xs text-gray-500">Showing: last 30 days</div>
        </div>
      </div>
    </div>

    <!-- 9. Visitor Stats (hour/day/week/month/year) -->
    <div class="masonry-item">
      <div class="card bg-white/75 rounded-2xl shadow-md overflow-hidden transition hover:shadow-lg" data-url-content="/data/visitors">
        <div class="flex items-center justify-between px-4 py-3 bg-gray-50 border-b border-gray-200">
          <h2 class="font-semibold text-lg text-gray-700"><i class="fa-solid fa-compass me-1 text-red-500"></i> Visitors</h2>
          <div class="flex items-center space-x-2 text-gray-500">
            <button class="collapse-btn"><i class="fa-solid fa-angle-down"></i></button>
            <button class="reload-btn"><i class="fa-solid fa-rotate-right"></i></button>
            <button class="max-btn"><i class="fa-solid fa-up-right-and-down-left-from-center"></i></button>
          </div>
        </div>
        <div class="card-content p-4">
          <div class="flex gap-2 flex-wrap">
            <button class="px-3 py-1 bg-gray-100 rounded">Hour</button>
            <button class="px-3 py-1 bg-gray-100 rounded">Day</button>
            <button class="px-3 py-1 bg-gray-100 rounded">Week</button>
            <button class="px-3 py-1 bg-gray-100 rounded">Month</button>
            <button class="px-3 py-1 bg-gray-100 rounded">Year</button>
          </div>
          <div class="mt-3 border border-dashed rounded-lg py-8 text-center text-gray-400">[Visitors Chart Placeholder]</div>
        </div>
      </div>
    </div>

    <!-- 10. Live Time -->
    <div class="masonry-item">
      <div class="card bg-white/75 rounded-2xl shadow-md overflow-hidden transition hover:shadow-lg" data-url-content="/data/time">
        <div class="flex items-center justify-between px-4 py-3 bg-gray-50 border-b border-gray-200">
          <h2 class="font-semibold text-lg text-gray-700"><i class="fa-solid fa-clock me-1 text-red-500"></i> Live Time</h2>
          <div class="flex items-center space-x-2 text-gray-500">
            <button class="collapse-btn"><i class="fa-solid fa-angle-down"></i></button>
            <button class="reload-btn"><i class="fa-solid fa-rotate-right"></i></button>
            <button class="max-btn"><i class="fa-solid fa-up-right-and-down-left-from-center"></i></button>
          </div>
        </div>
        <div class="card-content p-6 text-center text-2xl font-semibold" id="live-time">Loading...</div>
      </div>
    </div>

    <!-- 11. Location (get country) -->
    <div class="masonry-item">
      <div class="card bg-white/75 rounded-2xl shadow-md overflow-hidden transition hover:shadow-lg" data-url-content="/data/location">
        <div class="flex items-center justify-between px-4 py-3 bg-gray-50 border-b border-gray-200">
          <h2 class="font-semibold text-lg text-gray-700"><i class="fa-solid fa-globe me-1 text-red-500"></i> Location</h2>
          <div class="flex items-center space-x-2 text-gray-500">
            <button class="collapse-btn"><i class="fa-solid fa-angle-down"></i></button>
            <button class="reload-btn"><i class="fa-solid fa-rotate-right"></i></button>
            <button class="max-btn"><i class="fa-solid fa-up-right-and-down-left-from-center"></i></button>
          </div>
        </div>
        <div class="card-content p-4">
          <div id="detected-country" class="text-gray-700">Detecting country...</div> 
        </div>
      </div>
    </div>

    <!-- 12. Open Tools -->
    <div class="masonry-item">
      <div class="card bg-white/75 rounded-2xl shadow-md overflow-hidden transition hover:shadow-lg" data-url-content="/data/tools">
        <div class="flex items-center justify-between px-4 py-3 bg-gray-50 border-b border-gray-200">
          <h2 class="font-semibold text-lg text-gray-700"><i class="fa-solid fa-screwdriver-wrench me-1 text-red-500"></i> Open Tools</h2>
          <div class="flex items-center space-x-2 text-gray-500">
            <button class="collapse-btn"><i class="fa-solid fa-angle-down"></i></button>
            <button class="reload-btn"><i class="fa-solid fa-rotate-right"></i></button>
            <button class="max-btn"><i class="fa-solid fa-up-right-and-down-left-from-center"></i></button>
          </div>
        </div>
        <div class="card-content p-4">
          <div class="grid grid-cols-2 gap-2">
            <button class="py-2 px-3 border rounded">DB Explorer</button>
            <button class="py-2 px-3 border rounded">Log Viewer</button>
            <button class="py-2 px-3 border rounded">Cache Manager</button>
            <button class="py-2 px-3 border rounded">Task Runner</button>
          </div>
        </div>
      </div>
    </div>

    <!-- 13. 5 Latest Newsletters (chart placeholder) -->
    <div class="masonry-item">
      <div class="card bg-white/75 rounded-2xl shadow-md overflow-hidden transition hover:shadow-lg" data-url-content="/data/newsletters">
        <div class="flex items-center justify-between px-4 py-3 bg-gray-50 border-b border-gray-200">
          <h2 class="font-semibold text-lg text-gray-700"><i class="fa-solid fa-newspaper me-1 text-red-500"></i> Latest 5 Newsletters</h2>
          <div class="flex items-center space-x-2 text-gray-500">
            <button class="collapse-btn"><i class="fa-solid fa-angle-down"></i></button>
            <button class="reload-btn"><i class="fa-solid fa-rotate-right"></i></button>
            <button class="max-btn"><i class="fa-solid fa-up-right-and-down-left-from-center"></i></button>
          </div>
        </div>
        <div class="card-content p-4">
          <div class="space-y-2">
            <div class="font-medium">Newsletter — July 2025</div>
            <div class="font-medium">Product Update — June 2025</div>
            <div class="font-medium">Security Notice — May 2025</div>
            <div class="font-medium">June Recap — April 2025</div>
            <div class="font-medium">Spring News — March 2025</div>
          </div>
          <div class="mt-3 border border-dashed rounded-lg py-6 text-center text-gray-400">[Newsletter Chart Placeholder]</div>
        </div>
      </div>
    </div>

    <!-- 14. Compose Message -->
    <div class="masonry-item">
      <div class="card bg-white/75 rounded-2xl shadow-md overflow-hidden transition hover:shadow-lg" data-url-content="/data/compose">
        <div class="flex items-center justify-between px-4 py-3 bg-gray-50 border-b border-gray-200">
          <h2 class="font-semibold text-lg text-gray-700"><i class="fa-solid fa-envelope me-1 text-red-500"></i> Compose Message</h2>
          <div class="flex items-center space-x-2 text-gray-500">
            <button class="collapse-btn"><i class="fa-solid fa-angle-down"></i></button>
            <button class="reload-btn"><i class="fa-solid fa-rotate-right"></i></button>
            <button class="max-btn"><i class="fa-solid fa-up-right-and-down-left-from-center"></i></button>
          </div>
        </div>
        <div class="card-content p-4 space-y-2">
          <input type="text" placeholder="To:" class="w-full border rounded-lg px-3 py-2">
          <input type="text" placeholder="Subject:" class="w-full border rounded-lg px-3 py-2">
          <textarea rows="4" placeholder="Write message..." class="w-full border rounded-lg px-3 py-2"></textarea>
          <div class="flex gap-2">
            <button class="bg-gray-700 text-white px-4 py-2 rounded-lg">Send</button>
            <button class="px-4 py-2 border rounded-lg">Save Draft</button>
          </div>
        </div>
      </div>
    </div>

    <!-- 15. Create Tasks -->
    <div class="masonry-item">
      <div class="card bg-white/75 rounded-2xl shadow-md overflow-hidden transition hover:shadow-lg" data-url-content="/data/tasks">
        <div class="flex items-center justify-between px-4 py-3 bg-gray-50 border-b border-gray-200">
          <h2 class="font-semibold text-lg text-gray-700"><i class="fa-solid fa-list-check me-1 text-red-500"></i> Create Tasks</h2>
          <div class="flex items-center space-x-2 text-gray-500">
            <button class="collapse-btn"><i class="fa-solid fa-angle-down"></i></button>
            <button class="reload-btn"><i class="fa-solid fa-rotate-right"></i></button>
            <button class="max-btn"><i class="fa-solid fa-up-right-and-down-left-from-center"></i></button>
          </div>
        </div>
        <div class="card-content p-4">
          <input type="text" placeholder="Task title" class="w-full border rounded-lg px-3 py-2">
          <textarea rows="2" placeholder="Details (optional)" class="w-full border rounded-lg px-3 py-2 mt-2"></textarea>
          <div class="mt-2 flex gap-2">
            <button class="bg-gray-700 text-white px-4 py-2 rounded-lg">Add Task</button>
            <button class="px-4 py-2 border rounded-lg">View Tasks</button>
          </div>
        </div>
      </div>
    </div>

    <!-- 16. Add Content -->
    <div class="masonry-item">
      <div class="card bg-white/75 rounded-2xl shadow-md overflow-hidden transition hover:shadow-lg" data-url-content="/data/add-content">
        <div class="flex items-center justify-between px-4 py-3 bg-gray-50 border-b border-gray-200">
          <h2 class="font-semibold text-lg text-gray-700"><i class="fa-solid fa-pen-to-square me-1 text-red-500"></i> Add Content</h2>
          <div class="flex items-center space-x-2 text-gray-500">
            <button class="collapse-btn"><i class="fa-solid fa-angle-down"></i></button>
            <button class="reload-btn"><i class="fa-solid fa-rotate-right"></i></button>
            <button class="max-btn"><i class="fa-solid fa-up-right-and-down-left-from-center"></i></button>
          </div>
        </div>
        <div class="card-content p-4">
          <input type="text" placeholder="Title" class="w-full border rounded px-3 py-2">
          <textarea rows="4" placeholder="Body..." class="w-full border rounded px-3 py-2 mt-2"></textarea>
          <div class="mt-2 flex gap-2"><button class="bg-gray-700 text-white px-4 py-2 rounded">Publish</button><button class="px-4 py-2 border rounded">Save</button></div>
        </div>
      </div>
    </div>

    <!-- 17. View Content -->
    <div class="masonry-item">
      <div class="card bg-white/75 rounded-2xl shadow-md overflow-hidden transition hover:shadow-lg" data-url-content="/data/view-content">
        <div class="flex items-center justify-between px-4 py-3 bg-gray-50 border-b border-gray-200">
          <h2 class="font-semibold text-lg text-gray-700"><i class="fa-solid fa-book-open me-1 text-red-500"></i> View Content</h2>
          <div class="flex items-center space-x-2 text-gray-500">
            <button class="collapse-btn"><i class="fa-solid fa-angle-down"></i></button>
            <button class="reload-btn"><i class="fa-solid fa-rotate-right"></i></button>
            <button class="max-btn"><i class="fa-solid fa-up-right-and-down-left-from-center"></i></button>
          </div>
        </div>
        <div class="card-content p-4">
          <div class="space-y-2">
            <div class="font-medium">How to get started</div>
            <div class="text-sm text-gray-600">Latest blog post summary and quick links to full content.</div>
            <a href="#" class="text-pink-600">Open content manager</a>
          </div>
        </div>
      </div>
    </div>

    <!-- 18. Reports (list options) -->
    <div class="masonry-item">
      <div class="card bg-white/75 rounded-2xl shadow-md overflow-hidden transition hover:shadow-lg" data-url-content="/data/reports">
        <div class="flex items-center justify-between px-4 py-3 bg-gray-50 border-b border-gray-200">
          <h2 class="font-semibold text-lg text-gray-700"><i class="fa-solid fa-file-lines me-1 text-red-500"></i> Reports</h2>
          <div class="flex items-center space-x-2 text-gray-500">
            <button class="collapse-btn"><i class="fa-solid fa-angle-down"></i></button>
            <button class="reload-btn"><i class="fa-solid fa-rotate-right"></i></button>
            <button class="max-btn"><i class="fa-solid fa-up-right-and-down-left-from-center"></i></button>
          </div>
        </div>
        <div class="card-content p-4">
          <div class="text-sm text-gray-600">Generate reports by:</div>
          <ul class="mt-2 list-disc ml-5">
            <li>Table names (select one)</li>
            <li>Day / Week / Month / Year / Years / All</li>
            <li>Export CSV / PDF</li>
          </ul>
          <div class="mt-3"><button class="bg-gray-700 text-white px-4 py-2 rounded">Open Reports Builder</button></div>
        </div>
      </div>
    </div>

    <!-- 19. Counts (tables | number of rows + small chart) -->
    <div class="masonry-item">
      <div class="card bg-white/75 rounded-2xl shadow-md overflow-hidden transition hover:shadow-lg" data-url-content="/data/counts">
        <div class="flex items-center justify-between px-4 py-3 bg-gray-50 border-b border-gray-200">
          <h2 class="font-semibold text-lg text-gray-700"><i class="fa-solid fa-hashtag me-1 text-red-500"></i> Counts & Metrics</h2>
          <div class="flex items-center space-x-2 text-gray-500">
            <button class="collapse-btn"><i class="fa-solid fa-angle-down"></i></button>
            <button class="reload-btn"><i class="fa-solid fa-rotate-right"></i></button>
            <button class="max-btn"><i class="fa-solid fa-up-right-and-down-left-from-center"></i></button>
          </div>
        </div>
        <div class="card-content p-4">
          <div class="grid grid-cols-2 gap-3">
            <div class="bg-gray-50 p-3 rounded"><div class="text-sm">Users</div><div class="text-xl font-bold">12,345</div></div>
            <div class="bg-gray-50 p-3 rounded"><div class="text-sm">Orders</div><div class="text-xl font-bold">9,876</div></div>
            <div class="bg-gray-50 p-3 rounded"><div class="text-sm">Products</div><div class="text-xl font-bold">1,234</div></div>
            <div class="bg-gray-50 p-3 rounded"><div class="text-sm">Feedback</div><div class="text-xl font-bold">432</div></div>
          </div>
          <div class="mt-3 border border-dashed rounded-lg py-6 text-center text-gray-400">[Counts Chart Placeholder]</div>
        </div>
      </div>
    </div>

    <!-- 20. Dark Mode Switcher -->
<!--     <div class="masonry-item">
      <div class="card bg-white/75 rounded-2xl shadow-md overflow-hidden transition hover:shadow-lg" data-url-content="/data/darkmode">
        <div class="flex items-center justify-between px-4 py-3 bg-gray-50 border-b border-gray-200">
          <h2 class="font-semibold text-lg text-gray-700"><i class="fa-solid fa-moon me-1 text-red-500"></i> Dark Mode</h2>
          <div class="flex items-center space-x-2 text-gray-500">
            <button class="collapse-btn"><i class="fa-solid fa-angle-down"></i></button>
            <button class="reload-btn"><i class="fa-solid fa-rotate-right"></i></button>
            <button class="max-btn"><i class="fa-solid fa-up-right-and-down-left-from-center"></i></button>
          </div>
        </div>
        <div class="card-content p-4">
          <label class="inline-flex items-center cursor-pointer">
            <input type="checkbox" id="dark-toggle" class="sr-only peer">
            <div class="w-11 h-6 bg-gray-300 peer-focus:outline-none rounded-full peer peer-checked:bg-gray-700 relative">
              <span class="absolute left-1 top-1 bg-white/75 w-4 h-4 rounded-full transition-all peer-checked:translate-x-5"></span>
            </div>
            <span class="ml-3 text-gray-700">Enable Dark Mode</span>
          </label>
          <div class="mt-2 text-sm text-gray-500">Toggles a simple page-level dark class.</div>
        </div>
      </div>
    </div> -->

    <!-- 21. New Feedback -->
    <div class="masonry-item">
      <div class="card bg-white/75 rounded-2xl shadow-md overflow-hidden transition hover:shadow-lg" data-url-content="/data/feedback">
        <div class="flex items-center justify-between px-4 py-3 bg-gray-50 border-b border-gray-200">
          <h2 class="font-semibold text-lg text-gray-700"><i class="fa-solid fa-comment-dots me-1 text-red-500"></i> New Feedback</h2>
          <div class="flex items-center space-x-2 text-gray-500">
            <button class="collapse-btn"><i class="fa-solid fa-angle-down"></i></button>
            <button class="reload-btn"><i class="fa-solid fa-rotate-right"></i></button>
            <button class="max-btn"><i class="fa-solid fa-up-right-and-down-left-from-center"></i></button>
          </div>
        </div>
        <div class="card-content p-4">
          <div class="space-y-3">
            <div class="p-3 bg-gray-50 rounded"><b>Olivia</b> — "Great product!"</div>
            <div class="p-3 bg-gray-50 rounded"><b>Mark</b> — "Found a bug in checkout."</div>
            <div class="p-3 bg-gray-50 rounded"><b>Sofia</b> — "Love the new UI."</div>
          </div>
          <div class="mt-3"><a href="#" class="text-pink-600">Open feedback manager</a></div>
        </div>
      </div>
    </div>

    <!-- 22. Open Help Page -->
    <div class="masonry-item">
      <div class="card bg-white/75 rounded-2xl shadow-md overflow-hidden transition hover:shadow-lg" data-url-content="/data/help">
        <div class="flex items-center justify-between px-4 py-3 bg-gray-50 border-b border-gray-200">
          <h2 class="font-semibold text-lg text-gray-700"><i class="fa-solid fa-circle-question me-1 text-red-500"></i> Help</h2>
          <div class="flex items-center space-x-2 text-gray-500">
            <button class="collapse-btn"><i class="fa-solid fa-angle-down"></i></button>
            <button class="reload-btn"><i class="fa-solid fa-rotate-right"></i></button>
            <button class="max-btn"><i class="fa-solid fa-up-right-and-down-left-from-center"></i></button>
          </div>
        </div>
        <div class="card-content p-4">
          <p class="text-sm text-gray-600">Find documentation, FAQs, and support contacts here.</p>
          <a href="#" class="text-pink-600 mt-2 inline-block">Open Help Page</a>
        </div>
      </div>
    </div>

    <!-- 23. User Account -->
    <div class="masonry-item">
      <div class="card bg-white/75 rounded-2xl shadow-md overflow-hidden transition hover:shadow-lg" data-url-content="/data/account">
        <div class="flex items-center justify-between px-4 py-3 bg-gray-50 border-b border-gray-200">
          <h2 class="font-semibold text-lg text-gray-700"><i class="fa-solid fa-user me-1 text-red-500"></i> User Account</h2>
          <div class="flex items-center space-x-2 text-gray-500">
            <button class="collapse-btn"><i class="fa-solid fa-angle-down"></i></button>
            <button class="reload-btn"><i class="fa-solid fa-rotate-right"></i></button>
            <button class="max-btn"><i class="fa-solid fa-up-right-and-down-left-from-center"></i></button>
          </div>
        </div>
        <div class="card-content p-4">
          <p>Username: <b>admin</b></p>
          <p>Email: <b>admin@example.com</b></p>
          <div class="mt-3 flex gap-2">
            <a href="#" class="px-3 py-2 bg-red-500 text-white rounded">Profile</a>
            <a href="#" class="px-3 py-2 border rounded">Settings</a>
          </div>
        </div>
      </div>
    </div>

    <!-- 24. Change Your Passwords -->
    <div class="masonry-item">
      <div class="card bg-white/75 rounded-2xl shadow-md overflow-hidden transition hover:shadow-lg" data-url-content="/data/change-password">
        <div class="flex items-center justify-between px-4 py-3 bg-gray-50 border-b border-gray-200">
          <h2 class="font-semibold text-lg text-gray-700"><i class="fa-solid fa-lock me-1 text-red-500"></i> Change Password</h2>
          <div class="flex items-center space-x-2 text-gray-500">
            <button class="collapse-btn"><i class="fa-solid fa-angle-down"></i></button>
            <button class="reload-btn"><i class="fa-solid fa-rotate-right"></i></button>
            <button class="max-btn"><i class="fa-solid fa-up-right-and-down-left-from-center"></i></button>
          </div>
        </div>
        <div class="card-content p-4">
          <input type="password" placeholder="Current password" class="w-full border rounded px-3 py-2">
          <input type="password" placeholder="New password" class="w-full border rounded px-3 py-2 mt-2">
          <input type="password" placeholder="Confirm new password" class="w-full border rounded px-3 py-2 mt-2">
          <div class="mt-2"><button class="bg-gray-700 text-white px-4 py-2 rounded">Change Password</button></div>
        </div>
      </div>
    </div>

    <!-- 25. Logout -->
    <div class="masonry-item">
      <div class="card bg-white/75 rounded-2xl shadow-md overflow-hidden transition hover:shadow-lg" data-url-content="/action/logout">
        <div class="flex items-center justify-between px-4 py-3 bg-gray-50 border-b border-gray-200">
          <h2 class="font-semibold text-lg text-gray-700"><i class="fa-solid fa-right-from-bracket me-1 text-red-500"></i> Logout</h2>
          <div class="flex items-center space-x-2 text-gray-500">
            <button class="collapse-btn"><i class="fa-solid fa-angle-down"></i></button>
            <button class="reload-btn"><i class="fa-solid fa-rotate-right"></i></button>
            <button class="max-btn"><i class="fa-solid fa-up-right-and-down-left-from-center"></i></button>
          </div>
        </div>
        <div class="card-content p-4">
          <p class="text-sm text-gray-600">Click the button below to sign out of the admin dashboard.</p>
          <div class="mt-3"><button id="logout-btn" class="bg-gray-700 text-white px-4 py-2 rounded">Logout</button></div>
        </div>
      </div>
    </div>

    <!-- 26. Control System Users (roles & table access) -->
    <div class="masonry-item">
      <div class="card bg-white/75 rounded-2xl shadow-md overflow-hidden transition hover:shadow-lg" data-url-content="/data/control-users">
        <div class="flex items-center justify-between px-4 py-3 bg-gray-50 border-b border-gray-200">
          <h2 class="font-semibold text-lg text-gray-700"><i class="fa-solid fa-shield-halved me-1 text-red-500"></i> Control System Users</h2>
          <div class="flex items-center space-x-2 text-gray-500">
            <button class="collapse-btn"><i class="fa-solid fa-angle-down"></i></button>
            <button class="reload-btn"><i class="fa-solid fa-rotate-right"></i></button>
            <button class="max-btn"><i class="fa-solid fa-up-right-and-down-left-from-center"></i></button>
          </div>
        </div>

        <div class="card-content p-4">
          <div class="mb-3">
            <label class="block text-sm font-medium">Create Role</label>
            <div class="flex gap-2 mt-2">
              <input type="text" placeholder="Role name" class="border rounded px-3 py-2 flex-1">
              <button class="bg-gray-700 text-white px-4 py-2 rounded">Create</button>
            </div>
          </div>

          <div class="mb-2 text-sm font-medium">Manage Role Permissions</div>
          <div class="space-y-2 text-sm">
            <div class="border rounded p-2">
              <div class="flex items-center justify-between"><div><b>Admin</b></div><div class="text-xs text-gray-500">Full access</div></div>
              <div class="mt-2 grid grid-cols-2 gap-2">
                <label class="flex items-center gap-2"><input type="checkbox" checked> Users</label>
                <label class="flex items-center gap-2"><input type="checkbox" checked> Orders</label>
                <label class="flex items-center gap-2"><input type="checkbox" checked> Products</label>
                <label class="flex items-center gap-2"><input type="checkbox" checked> Reports</label>
              </div>
            </div>

            <div class="border rounded p-2">
              <div class="flex items-center justify-between"><div><b>Editor</b></div><div class="text-xs text-gray-500">Content only</div></div>
              <div class="mt-2 grid grid-cols-2 gap-2">
                <label class="flex items-center gap-2"><input type="checkbox" checked> Content</label>
                <label class="flex items-center gap-2"><input type="checkbox"> Users</label>
                <label class="flex items-center gap-2"><input type="checkbox"> Reports</label>
                <label class="flex items-center gap-2"><input type="checkbox"> Settings</label>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

  </div> <!-- end dashboard -->

  <!-- FontAwesome (remove if already included globally) -->
  <script src="https://kit.fontawesome.com/a2e0b1e11b.js" crossorigin="anonymous"></script>

  <!-- Interactions -->
  <script>
    // Collapse/Expand
    $(document).on('click', '.collapse-btn', function () {
      const content = $(this).closest('.card').find('.card-content');
      content.slideToggle(180);
      $(this).find('i').toggleClass('fa-angle-down fa-angle-up');
    });

    // Reload (simulate) - uses data-url-content attribute
    $(document).on('click', '.reload-btn', function () {
      const card = $(this).closest('.card');
      const url = card.attr('data-url-content') || '[no-url]';
      const content = card.find('.card-content');
      const prev = content.html();
      content.html('<div class="text-center py-6 text-gray-400">🔄 Loading...</div>');
      setTimeout(function () {
        content.html('<div class="text-sm text-gray-600 pb-2">Reloaded (simulated) from <b>' + url + '</b></div>' + prev);
      }, 800);
    });

    // Maximize / restore
    $(document).on('click', '.max-btn', function () {
      const card = $(this).closest('.card');
      const isMax = card.hasClass('card-maximized');
      if (!isMax) {
        card.addClass('card-maximized');
        $('body').addClass('overflow-hidden');
      } else {
        card.removeClass('card-maximized');
        $('body').removeClass('overflow-hidden');
      }
    });

    // Drag & Drop Sorting
    new Sortable(document.getElementById('dashboard'), {
      animation: 200,
      ghostClass: 'opacity-50',
      // allow dragging from anywhere on the card
      handle: '.card',
    });

    // Live Time updater (YYYY-MM-DD HH:MM:SS)
    function updateTime() {
      const now = new Date();
      const y = now.getFullYear();
      const m = String(now.getMonth() + 1).padStart(2, '0');
      const d = String(now.getDate()).padStart(2, '0');
      const hh = String(now.getHours()).padStart(2, '0');
      const mm = String(now.getMinutes()).padStart(2, '0');
      const ss = String(now.getSeconds()).padStart(2, '0');
      const formatted = y + '-' + m + '-' + d + ' ' + hh + ':' + mm + ':' + ss;
      $('#live-time').text(formatted);
    }
    setInterval(updateTime, 1000);
    updateTime();

    // Dark Mode toggle (simple page-level toggle)
    // $('#dark-toggle').on('change', function () {
    //   const enabled = $(this).is(':checked');
    //   if (enabled) {
    //     $('html').addClass('dark');
    //     $('body').addClass('bg-gray-900 text-gray-100');
    //   } else {
    //     $('html').removeClass('dark');
    //     $('body').removeClass('bg-gray-900 text-gray-100');
    //   }
    // });

    // Logout button (simulated)
    $('#logout-btn').on('click', function () {
      alert('Simulated logout. Implement server-side action to actually log out.');
    });

    // Attempt to detect country via a simple geo-IP endpoint (best-effort; will fail without network)
    (function detectCountry() {
      const el = document.getElementById('detected-country');
      // Best-effort: try using a public endpoint; if blocked or not allowed, fallback.
      fetch('https://ipapi.co/json/')
        .then(res => res.json())
        .then(data => {
          if (data && data.country_name) {
            el.textContent = 'Detected country: ' + data.country_name + ' (' + (data.ip || 'IP unknown') + ')';
          } else {
            el.textContent = 'Detected country: Unknown';
          }
        }).catch(function () {
          // fallback: basic Intl API (not reliably country)
          try {
            const locale = Intl.DateTimeFormat().resolvedOptions().locale || 'en';
            el.textContent = 'Locale: ' + locale + ' (external geo lookup unavailable)';
          } catch (e) {
            el.textContent = 'Country detection unavailable';
          }
        });
    })();

    // Small accessibility: allow Enter to trigger "Add Task" or "Create" in example fields (simulated)
    $(document).on('keypress', 'input', function (e) {
      if (e.which === 13) {
        e.preventDefault();
        $(this).closest('.card').find('button').first().trigger('click');
      }
    });

  </script>

</section>
<!-- END:  Masonry Dashboard Section -->
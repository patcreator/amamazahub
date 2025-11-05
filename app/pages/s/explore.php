  <title>Welcome / Tools & Analytics</title>

  <!-- Note: Tailwind CSS is expected to be provided globally by the app -->
  <!-- If needed for standalone preview uncomment the following CDN (not recommended for production) -->
  <!-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"> -->

  <!-- Optional: include an icon font or use inline SVGs below. We'll use inline SVG icons -->
  <style>
    /* Small helper for modal/offcanvas transitions */
    .fade-in { animation: fadeIn .12s ease forwards; }
    @keyframes fadeIn { from { opacity: 0 } to { opacity: 1 } }

    .slide-in-right { transform: translateX(100%); transition: transform .22s ease; }
    .slide-in-right.open { transform: translateX(0); }

    /* make table container not exceed viewport when inside modal */
    .modal-scroll { max-height: 70vh; overflow: auto; }
    /* simple card hover effect */
    .card-hover:hover { transform: translateY(-6px); box-shadow: 0 10px 30px rgba(0,0,0,0.09); }
  </style>
<div class="bg-white dark:bg-gray-800 dark:text-gray-200 dark:border-gray-700 p-8 rounded-2xl text-slate-800 mx-8">

  <div class="max-w-7xl mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
      <div>
        <h1 class="text-2xl font-semibold">Welcome</h1>
        <div class="text-sm text-slate-500">Quick access to tools and analytics</div>
      </div>

      <div class="text-right">
        <div id="bigTimeDisplay" class="text-lg font-semibold">--:--:--</div>
        <div id="tzName" class="text-sm text-slate-500"></div>
      </div>
    </div>

    <div class="mb-4">
      <input id="toolFilter" class="w-full px-3 py-2 rounded border border-gray-200 bg-white dark:bg-gray-800 dark:text-gray-200 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Filter tools (type to filter cards)" />
    </div>

    <div id="toolsContainer" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
      <!-- Card template: inline SVG icons and text -->
      <!-- Row 1 -->
      <div class="card-tool card-hover bg-white dark:bg-gray-800 dark:text-gray-200 dark:border-gray-700 p-4 rounded-lg border border-gray-100 cursor-pointer" data-url="calculator" data-tool="calculator" data-open="modal" title="Calculator">
        <div class="flex items-center gap-3">
          <!-- calculator icon -->
          <div class="p-2 bg-indigo-50 rounded">
            <svg class="w-6 h-6 text-indigo-600" viewBox="0 0 20 20" fill="currentColor"><path d="M6 2a1 1 0 00-1 1v14a1 1 0 001 1h8a1 1 0 001-1V3a1 1 0 00-1-1H6zM7 5h6v2H7V5zm0 4h2v2H7V9zm3 0h3v2H10V9zM7 12h2v2H7v-2zm3 0h3v2H10v-2z"/></svg>
          </div>
          <div>
            <div class="font-medium">Calculator</div>
            <div class="text-xs text-slate-500">Quick calculations</div>
          </div>
        </div>
      </div>

      <div class="card-tool card-hover bg-white dark:bg-gray-800 dark:text-gray-200 dark:border-gray-700 p-4 rounded-lg border border-gray-100 cursor-pointer" data-url="clock" data-tool="clock" data-open="modal" title="Clock">
        <div class="flex items-center gap-3">
          <div class="p-2 bg-green-50 rounded">
            <svg class="w-6 h-6 text-green-600" viewBox="0 0 24 24" fill="currentColor"><path d="M12 1a11 11 0 1011 11A11.013 11.013 0 0012 1zm1 12.414V7h-2v6.586l5.293 5.293 1.414-1.414z"/></svg>
          </div>
          <div>
            <div class="font-medium">Clock</div>
            <div class="text-xs text-slate-500">World clocks & alarms</div>
          </div>
        </div>
      </div>

      <div class="card-tool card-hover bg-white dark:bg-gray-800 dark:text-gray-200 dark:border-gray-700 p-4 rounded-lg border border-gray-100 cursor-pointer" data-url="contacts" data-tool="contacts" data-open="modal" title="Contacts">
        <div class="flex items-center gap-3">
          <div class="p-2 bg-yellow-50 rounded">
            <svg class="w-6 h-6 text-yellow-600" viewBox="0 0 24 24" fill="currentColor"><path d="M12 12a5 5 0 10-5-5 5 5 0 005 5zm6 9a1 1 0 01-1-1v-1a4 4 0 00-4-4H7a4 4 0 00-4 4v1a1 1 0 01-1 1h16z"/></svg>
          </div>
          <div>
            <div class="font-medium">Contacts</div>
            <div class="text-xs text-slate-500">Manage contacts</div>
          </div>
        </div>
      </div>

      <div class="card-tool card-hover bg-white dark:bg-gray-800 dark:text-gray-200 dark:border-gray-700 p-4 rounded-lg border border-gray-100 cursor-pointer" data-url="tasks" data-tool="tasks" data-open="modal" title="Tasks">
        <div class="flex items-center gap-3">
          <div class="p-2 bg-red-50 rounded">
            <svg class="w-6 h-6 text-red-600" viewBox="0 0 24 24" fill="currentColor"><path d="M9 11l3 3L22 4l-1.4-1.4L12 11.2 10.4 9.6 9 11zM3 6h6V4H3v2zm0 4h10v-2H3v2zm0 4h10v-2H3v2zm0 4h10v-2H3v2z"/></svg>
          </div>
          <div>
            <div class="font-medium">Tasks</div>
            <div class="text-xs text-slate-500">To-do & task lists</div>
          </div>
        </div>
      </div>

      <!-- Row 2 -->
      <div class="card-tool card-hover bg-white dark:bg-gray-800 dark:text-gray-200 dark:border-gray-700 p-4 rounded-lg border border-gray-100 cursor-pointer" data-url="notepad" data-tool="notepad" data-open="modal" title="Notepad">
        <div class="flex items-center gap-3">
          <div class="p-2 bg-sky-50 rounded">
            <svg class="w-6 h-6 text-sky-600" viewBox="0 0 24 24" fill="currentColor"><path d="M7 2h7l5 5v13a1 1 0 01-1 1H7a1 1 0 01-1-1V2zm7 2v4h4"/></svg>
          </div>
          <div>
            <div class="font-medium">Notepad</div>
            <div class="text-xs text-slate-500">Quick notes</div>
          </div>
        </div>
      </div>

      <div class="card-tool card-hover bg-white dark:bg-gray-800 dark:text-gray-200 dark:border-gray-700 p-4 rounded-lg border border-gray-100 cursor-pointer" data-url="filemanager" data-tool="filemanager" data-open="modal" title="File Manager">
        <div class="flex items-center gap-3">
          <div class="p-2 bg-gray-50 rounded">
            <svg class="w-6 h-6 text-gray-600" viewBox="0 0 24 24" fill="currentColor"><path d="M3 7v11a2 2 0 002 2h14V7H3zm2-4h5l2 2h6v2H5V3z"/></svg>
          </div>
          <div>
            <div class="font-medium">File Manager</div>
            <div class="text-xs text-slate-500">Browse files</div>
          </div>
        </div>
      </div>

      <div class="card-tool card-hover bg-white dark:bg-gray-800 dark:text-gray-200 dark:border-gray-700 p-4 rounded-lg border border-gray-100 cursor-pointer" data-url="player" data-tool="player" data-open="modal" title="Player">
        <div class="flex items-center gap-3">
          <div class="p-2 bg-indigo-50 rounded">
            <svg class="w-6 h-6 text-indigo-600" viewBox="0 0 24 24" fill="currentColor"><path d="M4 3v18l16-9L4 3z"/></svg>
          </div>
          <div>
            <div class="font-medium">Player</div>
            <div class="text-xs text-slate-500">Audio / Video player</div>
          </div>
        </div>
      </div>

      <div class="card-tool card-hover bg-white dark:bg-gray-800 dark:text-gray-200 dark:border-gray-700 p-4 rounded-lg border border-gray-100 cursor-pointer" data-url="youtubechannel" data-tool="youtubechannel" data-open="modal" title="YouTube Channel">
        <div class="flex items-center gap-3">
          <div class="p-2 bg-red-50 rounded">
            <svg class="w-6 h-6 text-red-600" viewBox="0 0 24 24" fill="currentColor"><path d="M10 15l5.19-3L10 9v6zM21 8s-.2-1.4-.82-2a3.2 3.2 0 00-2.22-.82C15.5 5 12 5 12 5s-3.5 0-5.96.18a3.2 3.2 0 00-2.22.82C2.2 6.6 2 8 2 8s-.2 1.61-.2 3.21v1.58C1.8 15.39 2 17 2 17s.2 1.4.82 2a3.2 3.2 0 002.22.82C8.5 20 12 20 12 20s3.5 0 5.96-.18a3.2 3.2 0 002.22-.82c.62-.6.82-2 .82-2s.2-1.61.2-3.21v-1.58C21.2 9.61 21 8 21 8z"/></svg>
          </div>
          <div>
            <div class="font-medium">YouTube Channel</div>
            <div class="text-xs text-slate-500">Channel analytics</div>
          </div>
        </div>
      </div>

      <!-- Row 3 -->
      <div class="card-tool card-hover bg-white dark:bg-gray-800 dark:text-gray-200 dark:border-gray-700 p-4 rounded-lg border border-gray-100 cursor-pointer" data-url="newsletter" data-tool="newsletter" data-open="modal" title="Newsletter">
        <div class="flex items-center gap-3">
          <div class="p-2 bg-green-50 rounded">
            <svg class="w-6 h-6 text-green-600" viewBox="0 0 24 24" fill="currentColor"><path d="M2 6v12a2 2 0 002 2h16V6H2zm2-4h12l4 4H4V2z"/></svg>
          </div>
          <div>
            <div class="font-medium">Newsletter</div>
            <div class="text-xs text-slate-500">Subscribers & sends</div>
          </div>
        </div>
      </div>

     <!--  <div class="card-tool card-hover bg-white dark:bg-gray-800 dark:text-gray-200 dark:border-gray-700 p-4 rounded-lg border border-gray-100 cursor-pointer" data-url="settings" data-tool="settings" data-open="offcanvas" title="Settings">
        <div class="flex items-center gap-3">
          <div class="p-2 bg-gray-50 rounded">
            <svg class="w-6 h-6 text-gray-600" viewBox="0 0 24 24" fill="currentColor"><path d="M12 8a4 4 0 104 4 4 4 0 00-4-4zm8.94 4a7.91 7.91 0 01-.14 1l2.07 1.6-2 3.46-2.49-1a8 8 0 01-1.5.86L16 21h-4l-.88-2.08a8 8 0 01-1.5-.86l-2.49 1-2-3.46 2.07-1.6a7.91 7.91 0 01-.14-1 7.91 7.91 0 01.14-1L2.79 8.4l2-3.47 2.49 1A8 8 0 0110.88 4L11.76 2h4.48l.88 2.08a8 8 0 011.5.86l2.49-1 2 3.47L20.06 11z"/></svg>
          </div>
          <div>
            <div class="font-medium">Settings</div>
            <div class="text-xs text-slate-500">App preferences</div>
          </div>
        </div>
      </div> -->

      <div class="card-tool card-hover bg-white dark:bg-gray-800 dark:text-gray-200 dark:border-gray-700 p-4 rounded-lg border border-gray-100 cursor-pointer" data-url="soundrecorder" data-tool="soundrecorder" data-open="modal" title="Sound Recorder">
        <div class="flex items-center gap-3">
          <div class="p-2 bg-yellow-50 rounded">
            <svg class="w-6 h-6 text-yellow-600" viewBox="0 0 24 24" fill="currentColor"><path d="M12 3a3 3 0 00-3 3v6a3 3 0 006 0V6a3 3 0 00-3-3zM5 11a1 1 0 000 2 6 6 0 0012 0 1 1 0 100-2 8 8 0 01-12 0zM11 21h2v-2h-2v2z"/></svg>
          </div>
          <div>
            <div class="font-medium">Sound Recorder</div>
            <div class="text-xs text-slate-500">Record audio</div>
          </div>
        </div>
      </div>

      <div class="card-tool card-hover bg-white dark:bg-gray-800 dark:text-gray-200 dark:border-gray-700 p-4 rounded-lg border border-gray-100 cursor-pointer" data-url="camera" data-tool="camera" data-open="modal" title="Camera">
        <div class="flex items-center gap-3">
          <div class="p-2 bg-red-50 rounded">
            <svg class="w-6 h-6 text-red-600" viewBox="0 0 24 24" fill="currentColor"><path d="M4 7h3l2-2h6l2 2h3v12a2 2 0 01-2 2H6a2 2 0 01-2-2V7zM12 9a4 4 0 100 8 4 4 0 000-8z"/></svg>
          </div>
          <div>
            <div class="font-medium">Camera</div>
            <div class="text-xs text-slate-500">Take snapshots</div>
          </div>
        </div>
      </div>

      <!-- Row 4 - analytics/statistics -->
      <!-- <div class="card-tool card-hover bg-white dark:bg-gray-800 dark:text-gray-200 dark:border-gray-700 p-4 rounded-lg border border-gray-100 cursor-pointer" data-url="pageviews" data-tool="stats&type=pageviews" data-open="modal" title="Page Views">
        <div class="flex items-center gap-3">
          <div class="p-2 bg-indigo-50 rounded">
            <svg class="w-6 h-6 text-indigo-600" viewBox="0 0 24 24" fill="currentColor"><path d="M3 13h3v8H3v-8zm5-6h3v14H8V7zm5 4h3v10h-3V11zm5-6h3v16h-3V5z"/></svg>
          </div>
          <div>
            <div class="font-medium">Page Views</div>
            <div class="text-xs text-slate-500">Visits & trends</div>
          </div>
        </div>
      </div> -->

      <!-- <div class="card-tool card-hover bg-white dark:bg-gray-800 dark:text-gray-200 dark:border-gray-700 p-4 rounded-lg border border-gray-100 cursor-pointer" data-url="contents" data-tool="stats&type=contents" data-open="modal" title="Contents">
        <div class="flex items-center gap-3">
          <div class="p-2 bg-sky-50 rounded">
            <svg class="w-6 h-6 text-sky-600" viewBox="0 0 24 24" fill="currentColor"><path d="M3 5v14a2 2 0 002 2h14V5H3zm2 2h14v2H5V7z"/></svg>
          </div>
          <div>
            <div class="font-medium">Contents</div>
            <div class="text-xs text-slate-500">Pages & posts</div>
          </div>
        </div>
      </div> -->

      <!-- <div class="card-tool card-hover bg-white dark:bg-gray-800 dark:text-gray-200 dark:border-gray-700 p-4 rounded-lg border border-gray-100 cursor-pointer" data-url="traffic" data-tool="stats&type=traffic" data-open="modal" title="Traffic">
        <div class="flex items-center gap-3">
          <div class="p-2 bg-green-50 rounded">
            <svg class="w-6 h-6 text-green-600" viewBox="0 0 24 24" fill="currentColor"><path d="M3 3h18v2H3V3zm2 6h14v2H5V9zm-2 6h18v2H3v-2z"/></svg>
          </div>
          <div>
            <div class="font-medium">Traffic</div>
            <div class="text-xs text-slate-500">Visitor sources</div>
          </div>
        </div>
      </div> -->

      <!-- <div class="card-tool card-hover bg-white dark:bg-gray-800 dark:text-gray-200 dark:border-gray-700 p-4 rounded-lg border border-gray-100 cursor-pointer" data-url="change_password" data-tool="change_password" data-open="offcanvas" title="Change Password">
        <div class="flex items-center gap-3">
          <div class="p-2 bg-gray-50 rounded">
            <svg class="w-6 h-6 text-gray-600" viewBox="0 0 24 24" fill="currentColor"><path d="M12 1a5 5 0 00-5 5v3H6a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2v-8a2 2 0 00-2-2h-1V6a5 5 0 00-5-5zM9 9V6a3 3 0 116 0v3H9z"/></svg>
          </div>
          <div>
            <div class="font-medium">Change Password</div>
            <div class="text-xs text-slate-500">Update your password</div>
          </div>
        </div>
      </div> -->

      <!-- Row 5 - extras -->
      <div class="card-tool card-hover bg-white dark:bg-gray-800 dark:text-gray-200 dark:border-gray-700 p-4 rounded-lg border border-gray-100 cursor-pointer" data-url="bigtime" data-tool="bigtime" data-open="modal" title="Big Time">
        <div class="flex items-center gap-3">
          <div class="p-2 bg-red-50 rounded">
            <svg class="w-6 h-6 text-red-600" viewBox="0 0 24 24" fill="currentColor"><path d="M12 1a11 11 0 1011 11A11.013 11.013 0 0012 1zm1 11.414V7h-2v6.586l5.293 5.293 1.414-1.414z"/></svg>
          </div>
          <div>
            <div class="font-medium">Big Time</div>
            <div class="text-xs text-slate-500">Full clock view</div>
          </div>
        </div>
      </div>

      <div class="card-tool card-hover bg-white dark:bg-gray-800 dark:text-gray-200 dark:border-gray-700 p-4 rounded-lg border border-gray-100 cursor-pointer" data-url="location" data-tool="location" data-open="modal" title="Location">
        <div class="flex items-center gap-3">
          <div class="p-2 bg-indigo-50 rounded">
            <svg class="w-6 h-6 text-indigo-600" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a7 7 0 00-7 7c0 5 7 13 7 13s7-8 7-13a7 7 0 00-7-7zm0 9.5A2.5 2.5 0 1112 6.5a2.5 2.5 0 010 5z"/></svg>
          </div>
          <div>
            <div class="font-medium">Location</div>
            <div class="text-xs text-slate-500">Find your location</div>
          </div>
        </div>
      </div>

      <div class="card-tool card-hover bg-white dark:bg-gray-800 dark:text-gray-200 dark:border-gray-700 p-4 rounded-lg border border-gray-100 cursor-pointer" data-url="alarm" data-tool="alarm" data-open="modal" title="Alarm">
        <div class="flex items-center gap-3">
          <div class="p-2 bg-yellow-50 rounded">
            <svg class="w-6 h-6 text-yellow-600" viewBox="0 0 24 24" fill="currentColor"><path d="M7 2l2 2 1-1-2-2-1 1zM15 2l1-1 2 2-1 1zM12 4a7 7 0 00-7 7v3l-2 2v1h18v-1l-2-2v-3a7 7 0 00-7-7z"/></svg>
          </div>
          <div>
            <div class="font-medium">Alarm</div>
            <div class="text-xs text-slate-500">Set alarms & timers</div>
          </div>
        </div>
      </div>

      <div class="card-tool card-hover bg-white dark:bg-gray-800 dark:text-gray-200 dark:border-gray-700 p-4 rounded-lg border border-gray-100 cursor-pointer" data-url="tables" data-tool="tables" data-open="modal" title="Tables">
        <div class="flex items-center gap-3">
          <div class="p-2 bg-gray-50 rounded">
            <svg class="w-6 h-6 text-gray-600" viewBox="0 0 24 24" fill="currentColor"><path d="M3 3h18v18H3z"/></svg>
          </div>
          <div>
            <div class="font-medium">Tables</div>
            <div class="text-xs text-slate-500">Tabular data</div>
          </div>
        </div>
      </div>

    </div>

    <!-- <div class="mt-4 text-sm text-slate-500">Tip: Click any card to open the corresponding tool. Server endpoints are called like <code>tools/?tool=calculator</code>.</div> -->
  </div>

  <!-- Modal (centered) -->
  <div id="toolModal" class="fixed inset-0 z-50 hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/40" id="modalBackdrop"></div>
    <div class="relative bg-white dark:bg-gray-800 dark:text-gray-200 dark:border-gray-700 rounded-lg w-[95%] md:w-3/4 lg:w-2/3 shadow-lg fade-in overflow-hidden">
      <div class="flex items-center justify-between p-4 border-b">
        <h3 id="modalTitle" class="text-lg font-medium">Tool</h3>
        <button id="modalClose" class="text-slate-600 hover:text-slate-900 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-700 px-4 py-2 rounded-2xl">&times;</button>
      </div>
      <div class="p-4 modal-scroll" id="modalBody">
        <!-- loader -->
        <div id="modalLoader" class="flex items-center justify-center py-8" style="display:none;">
          <svg class="animate-spin h-6 w-6 text-indigo-600" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" class="opacity-20"/><path d="M4 12a8 8 0 018-8" stroke="currentColor" stroke-width="4" stroke-linecap="round"/></svg>
        </div>
        <div id="modalContent"></div>
      </div>
      <div class="p-3 border-t flex items-center justify-between">
        <small id="modalInfo" class="text-slate-500"></small>
        <div>
          <button id="modalCloseBtn" class="px-3 py-1 rounded bg-gray-100 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-800 text-sm">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Offcanvas (right) -->
  <div id="toolOffcanvasBackdrop" class="fixed inset-0 bg-black/40 z-40 hidden"></div>
  <aside id="toolOffcanvas" class="fixed right-0 top-0 h-full w-[92%] sm:w-96 bg-white dark:bg-gray-800 dark:text-gray-200 dark:border-gray-700 z-50 shadow-lg slide-in-right">
    <div class="flex items-center justify-between p-4 border-b">
      <h3 id="offcanvasTitle" class="text-lg font-medium">Tool</h3>
      <button id="offcanvasClose" class="text-slate-600 hover:text-slate-900">&times;</button>
    </div>
    <div class="p-4 overflow-auto h-[calc(100%-72px)]" id="offcanvasBody">
      <div id="offcanvasLoader" class="flex items-center justify-center py-8" style="display:none;">
        <svg class="animate-spin h-6 w-6 text-indigo-600" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" class="opacity-20"/><path d="M4 12a8 8 0 018-8" stroke="currentColor" stroke-width="4" stroke-linecap="round"/></svg>
      </div>
      <div id="offcanvasContent"></div>
    </div>
  </aside>


  <script>
    // Utilities
    function buildToolUrl(toolAttr) {
      // handle shorthand like 'stats&type=pageviews'
      if (!toolAttr) return '/PDT-NEW/projects/pdo/app/pages/tools/';
      if (toolAttr.indexOf('stats&type=') === 0) {
        var t = toolAttr.split('stats&type=')[1];
        return '/PDT-NEW/projects/pdo/app/pages/tools/?tool=stats&type=' + encodeURIComponent(t);
      }
      // if contains '&' or '=' treat as raw (server can interpret)
      if (toolAttr.indexOf('&') !== -1 || toolAttr.indexOf('=') !== -1) {
        // If it already begins with 'tool=' allow it
        if (toolAttr.indexOf('tool=') === 0) {
          return '/PDT-NEW/projects/pdo/app/pages/tools/?' + toolAttr;
        }
        // fallback: send as tool param (encoded)
        return '/PDT-NEW/projects/pdo/app/pages/tools/?tool=' + encodeURIComponent(toolAttr);
      }
      return '/PDT-NEW/projects/pdo/app/pages/tools/?tool=' + encodeURIComponent(toolAttr);
    }

    function showModal(title, html, info) {
      $('#modalTitle').text(title || 'Tool');
      $('#modalInfo').text(info || '');
      $('#modalContent').html(html || '');
      $('#modalLoader').hide();
      $('#modalContent').show();
      $('#toolModal').removeClass('hidden').addClass('flex');
    }
    function hideModal() {
      $('#toolModal').addClass('hidden').removeClass('flex');
      // stop any camera/recorder cleanup if needed by triggering custom event
      $(document).trigger('modal.hidden');
      $('#modalContent').html('');
    }

    function showOffcanvas(title, html, info) {
      $('#offcanvasTitle').text(title || 'Tool');
      $('#offcanvasContent').html(html || '');
      $('#offcanvasLoader').hide();
      $('#offcanvasContent').show();
      $('#toolOffcanvasBackdrop').removeClass('hidden').addClass('block');
      $('#toolOffcanvas').addClass('open');
      $('#toolOffcanvas').removeClass('slide-in-right');
      $('#toolOffcanvas').addClass('slide-in-right open');
    }
    function hideOffcanvas() {
      $('#toolOffcanvasBackdrop').removeClass('block').addClass('hidden');
      $('#toolOffcanvas').removeClass('open');
      $('#toolOffcanvas').removeClass('slide-in-right open');
      $('#toolOffcanvas').addClass('slide-in-right');
      $('#offcanvasContent').html('');
      $(document).trigger('offcanvas.hidden');
    }

    function jsonToTable(json) {
      if (!json || !Array.isArray(json) || json.length === 0) {
        return '<div class="text-center text-slate-500 py-6">No rows returned.</div>';
      }
      var keys = Object.keys(json[0]);
      var html = '<div class="overflow-auto"><table class="min-w-full text-sm divide-y divide-slate-100">';
      html += '<thead class="bg-slate-50"><tr>';
      keys.forEach(function(k){ html += '<th class="px-3 py-2 text-left font-medium text-slate-600">' + $('<div>').text(k).html() + '</th>'; });
      html += '</tr></thead><tbody class="divide-y divide-slate-100">';
      json.forEach(function(row){
        html += '<tr class="odd:bg-white dark:bg-gray-800 dark:text-gray-200 dark:border-gray-700 even:bg-slate-50">';
        keys.forEach(function(k){
          var cell = row[k] == null ? '' : row[k];
          html += '<td class="px-3 py-2 align-top">' + $('<div>').text(String(cell)).html() + '</td>';
        });
        html += '</tr>';
      });
      html += '</tbody></table></div>';
      return html;
    }

    // Document ready
    $(function(){
      // time
      function updateTime() {
        var d = new Date();
        $('#bigTimeDisplay').text(d.toLocaleTimeString());
        $('#tzName').text(Intl.DateTimeFormat().resolvedOptions().timeZone || '');
      }
      updateTime();
      setInterval(updateTime, 500);

      // filter
      $('#toolFilter').on('input', function(){
        var q = $(this).val().toLowerCase().trim();
        $('#toolsContainer .card-tool').each(function(){
          var txt = $(this).text().toLowerCase();
          $(this).toggle(txt.indexOf(q) !== -1);
        });
      });

      // modal/offcanvas close handlers
      $('#modalClose, #modalCloseBtn, #modalBackdrop').on('click', hideModal);
      $('#toolOffcanvasBackdrop, #offcanvasClose, #toolOffcanvasBackdrop').on('click', hideOffcanvas);
      $('#offcanvasClose').on('click', hideOffcanvas);

      // main handler for cards
      $('#toolsContainer').on('click', '.card-tool', function(){
        var $el = $(this);
        var tool = $el.data('tool');
        var openType = $el.data('open') || 'modal';
        var title = $el.attr('title') || $el.find('.font-medium').text();

        // client-side handled tools
        if (tool === 'location') {
          $('#modalLoader').show(); $('#modalContent').hide();
          if (!navigator.geolocation) {
            showModal(title, '<div class="text-center text-slate-500 py-6">Geolocation not supported.</div>');
            return;
          }
          navigator.geolocation.getCurrentPosition(function(pos){
            var lat = pos.coords.latitude.toFixed(6);
            var lon = pos.coords.longitude.toFixed(6);
            var html = '<p class="mb-3"><strong>Latitude:</strong> ' + lat + '<br><strong>Longitude:</strong> ' + lon + '</p>';
            html += '<p><a href="https://www.google.com/maps/search/?api=1&query=' + lat + ',' + lon + '" target="_blank" class="inline-block px-3 py-2 rounded bg-indigo-600 text-white text-sm">Open in Google Maps</a></p>';
            showModal(title, html);
          }, function(err){
            showModal(title, '<div class="text-center text-slate-500 py-6">Location unavailable: ' + (err.message || 'permission denied') + '</div>');
          }, { enableHighAccuracy:true, timeout:10000, maximumAge:60000 });
          return;
        }

        if (tool === 'bigtime') {
          var d = new Date();
          var html = '<div class="text-center py-6"><h1 class="text-4xl font-bold">' + d.toLocaleTimeString() + '</h1><p class="text-sm text-slate-500 mt-2">' + d.toLocaleString() + '</p></div>';
          showModal(title, html);
          return;
        }

        if (tool === 'camera') {
          var html = '<div class="mb-3"><video id="camVideo" autoplay playsinline class="w-full bg-black rounded" style="max-height:60vh;"></video></div>';
          html += '<div class="flex gap-2"><button id="takePhoto" class="px-3 py-1 bg-indigo-600 text-white rounded text-sm">Capture Photo</button><a id="downloadPhoto" class="px-3 py-1 border rounded text-sm hidden" download="snapshot.png">Download</a></div>';
          html += '<canvas id="camCanvas" style="display:none;"></canvas>';
          showModal(title, html);
          // when modal shown, initialize camera
          $(document).one('modal.hidden.cameraCleanup', function(){ /* cleanup if user closed before init */ });
          setTimeout(function(){
            var video = document.getElementById('camVideo');
            var canvas = document.getElementById('camCanvas');
            var streamRef = null;
            navigator.mediaDevices && navigator.mediaDevices.getUserMedia({ video:true })
              .then(function(stream){
                streamRef = stream;
                video.srcObject = stream;
                $('#takePhoto').off('click').on('click', function(){
                  canvas.width = video.videoWidth;
                  canvas.height = video.videoHeight;
                  var ctx = canvas.getContext('2d');
                  ctx.drawImage(video, 0, 0);
                  canvas.toBlob(function(blob){
                    var url = URL.createObjectURL(blob);
                    $('#downloadPhoto').attr('href', url).removeClass('hidden');
                  }, 'image/png');
                });
                // cleanup when modal closed
                $(document).one('modal.hidden', function(){
                  if (streamRef) streamRef.getTracks().forEach(t=>t.stop());
                });
              })
              .catch(function(err){
                $('#modalContent').html('<div class="text-center text-slate-500 py-6">Could not access camera: ' + (err.message || err) + '</div>');
              });
          }, 220);
          return;
        }

        if (tool === 'soundrecorder') {
          var html = '<div class="mb-3 text-sm text-slate-600">Use your microphone to record audio (browser support required).</div>';
          html += '<div class="flex gap-2 mb-3"><button id="startRec" class="px-3 py-1 bg-green-600 text-white rounded text-sm">Start</button><button id="stopRec" class="px-3 py-1 bg-red-600 text-white rounded text-sm" disabled>Stop</button><a id="downloadAudio" class="px-3 py-1 border rounded text-sm hidden" download="recording.webm">Download</a></div>';
          html += '<div id="recStatus" class="text-sm text-slate-500"></div>';
          showModal(title, html);
          setTimeout(function(){
            var mediaRecorder, chunks = [], streamRef=null;
            $('#startRec').off('click').on('click', function(){
              navigator.mediaDevices && navigator.mediaDevices.getUserMedia({ audio:true })
              .then(function(stream){
                streamRef = stream;
                mediaRecorder = new MediaRecorder(stream);
                mediaRecorder.ondataavailable = function(e){ if (e.data && e.data.size) chunks.push(e.data); };
                mediaRecorder.onstop = function(){
                  var blob = new Blob(chunks, { type:'audio/webm' });
                  var url = URL.createObjectURL(blob);
                  $('#downloadAudio').attr('href', url).removeClass('hidden');
                  $('#recStatus').text('Recording stopped. You can download the file.');
                  if (streamRef) streamRef.getTracks().forEach(t=>t.stop());
                };
                mediaRecorder.start();
                $('#startRec').prop('disabled', true);
                $('#stopRec').prop('disabled', false);
                $('#recStatus').text('Recording...');
              })
              .catch(function(err){
                $('#recStatus').text('Could not access microphone: ' + (err.message || err));
              });
            });
            $('#stopRec').off('click').on('click', function(){
              try { mediaRecorder && mediaRecorder.state !== 'inactive' && mediaRecorder.stop(); } catch(e){}
              $('#startRec').prop('disabled', false);
              $('#stopRec').prop('disabled', true);
            });
            $(document).one('modal.hidden', function(){
              if (streamRef) streamRef.getTracks().forEach(t=>t.stop());
            });
          }, 220);
          return;
        }

        // default: AJAX fetch from server
        var url = buildToolUrl(tool);
        if (openType === 'offcanvas') {
          $('#offcanvasLoader').show(); $('#offcanvasContent').hide();
          showOffcanvas(title, '');
          $.ajax({
            url: url,
            method: 'GET',
            dataType: 'text',
            success: function(resp) {
              try {
                var json = JSON.parse(resp);
                if (Array.isArray(json)) {
                  $('#offcanvasContent').html(jsonToTable(json));
                } else {
                  $('#offcanvasContent').html('<pre class="text-sm">' + $('<div>').text(JSON.stringify(json, null, 2)).html() + '</pre>');
                }
              } catch(e) {
                $('#offcanvasContent').html(resp || '<div class="text-center text-slate-500 py-6">No data returned.</div>');
              }
            },
            error: function(xhr) {
              $('#offcanvasContent').html('<div class="text-center text-slate-500 py-6">Error fetching data: ' + (xhr.status ? xhr.status + ' ' + xhr.statusText : 'Network error') + '</div>');
            },
            complete: function(){ $('#offcanvasLoader').hide(); $('#offcanvasContent').show(); }
          });
        } else {
          $('#modalLoader').show(); $('#modalContent').hide(); $('#modalContent').html('');
          showModal(title, '');
          $.ajax({
            url: url,
            method: 'GET',
            dataType: 'text',
            success: function(resp) {
              try {
                var json = JSON.parse(resp);
                if (Array.isArray(json)) {
                  showModal(title, jsonToTable(json), 'Rows: ' + json.length);
                } else {
                  showModal(title, '<pre class="text-sm">' + $('<div>').text(JSON.stringify(json, null, 2)).html() + '</pre>');
                }
              } catch(e) {
                showModal(title, resp || '<div class="text-center text-slate-500 py-6">No data returned.</div>');
              }
            },
            error: function(xhr) {
              showModal(title, '<div class="text-center text-slate-500 py-6">Error fetching data: ' + (xhr.status ? xhr.status + ' ' + xhr.statusText : 'Network error') + '</div>');
            },
            complete: function(){ $('#modalLoader').hide(); $('#modalContent').show(); }
          });
        }
      });

      // Handle hiding modal / offcanvas via Escape key
      $(document).on('keydown', function(e){
        if (e.key === "Escape") {
          hideModal();
          hideOffcanvas();
        }
      });

      // custom triggers for cleanup
      $(document).on('modal.hidden', function(){ /* listeners cleanup if needed */ });
      $(document).on('offcanvas.hidden', function(){ /* listeners cleanup if needed */ });

      // close modal when backdrop clicked
      $('#modalBackdrop').on('click', hideModal);

      // offcanvas backdrop click already wired
    });

  </script>
</div>
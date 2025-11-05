
<div class="mx-6 min-h-screen flex">
  <!-- Sidebar -->
  <aside class="w-64 bg-white dark:bg-slate-800 rounded-3xl shadow-md p-6">
    <h2 class="text-2xl font-bold mb-4">Help Topics</h2>
    <ul id="topic-list" class="space-y-2 mb-4"></ul>
    <button id="addTopicBtn" class="w-full px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">Add Topic</button>
  </aside>

  <!-- Content -->
  <main class="flex-1 p-8">
    <div id="content-area" class="bg-white dark:bg-slate-800 p-6 rounded-lg shadow-md">
      <h1 class="text-3xl font-bold mb-4">Welcome to the Help Page</h1>
      <p>Select a topic from the sidebar to see detailed instructions.</p>
    </div>
  </main>

  <!-- Modal -->
  <div id="topicModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 mx-auto mt-20 p-6 rounded-lg w-1/2 relative">
      <h2 class="text-xl font-bold mb-4" id="modalTitle">Add Topic</h2>
      <input type="hidden" id="topicId">
      <input type="text" id="topicTitle" placeholder="Title" class="w-full border dark:bg-gray-800 dark:border-gray-700 p-2 mb-2 rounded">
      <textarea id="topicContent" placeholder="Content" class="w-full border dark:bg-gray-800 dark:border-gray-700 p-2 mb-2 rounded h-40"></textarea>
      <div class="flex justify-end gap-2">
        <button id="saveTopic" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Save</button>
        <button id="closeModal" class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500">Cancel</button>
      </div>
    </div>
  </div>

<script>
function loadTopics() {
  $.get('/PDT-NEW/projects/pdo/app/system/api/help_data.php', {action:'list'}, function(data) {
    const list = $('#topic-list').empty();
    data.forEach(t => {
      list.append(`
        <li class="flex justify-between items-center">
          <button class="text-left text-blue-600 hover:underline flex-1 topic-btn" data-id="${t.id}" data-title="${t.title}" data-content="${t.content}" data-updated="${t.updated_at}">${t.title}</button>
          <div class="flex gap-1">
            <button class="edit-btn px-2 py-1 bg-yellow-400 text-white rounded" data-id="${t.id}" data-title="${t.title}" data-content="${t.content}">Edit</button>
            <button class="delete-btn px-2 py-1 bg-red-500 text-white rounded" data-id="${t.id}">Delete</button>
          </div>
        </li>
      `);
    });

    // Topic click
    $('.topic-btn').on('click', function() {
      const title = $(this).data('title');
      const content = $(this).data('content');
      const updated = $(this).data('updated');
      $('#content-area').html(`
        <h2 class="text-2xl font-bold mb-3">${title}</h2>
        <p>${content}</p>
        <p class="text-sm text-gray-500 mt-2">Last updated: ${updated}</p>
      `);
    });

    // Edit click
    $('.edit-btn').on('click', function() {
      $('#topicModal').fadeIn();
      $('#modalTitle').text('Edit Topic');
      $('#topicId').val($(this).data('id'));
      $('#topicTitle').val($(this).data('title'));
      $('#topicContent').val($(this).data('content'));
    });

    // Delete click
    $('.delete-btn').on('click', function() {
      if(confirm('Are you sure you want to delete this topic?')) {
        $.post('/PDT-NEW/projects/pdo/app/system/api/help_data.php?action=delete', {action:'delete', id: $(this).data('id')}, function() {
          loadTopics();
        });
      }
    });
  });
}

$('#addTopicBtn').on('click', function() {
  $('#topicModal').fadeIn();
  $('#modalTitle').text('Add Topic');
  $('#topicId').val('');
  $('#topicTitle').val('');
  $('#topicContent').val('');
});

$('#closeModal').on('click', function() {
  $('#topicModal').fadeOut();
});

$('#saveTopic').on('click', function() {
  const id = $('#topicId').val();
  const title = $('#topicTitle').val();
  const content = $('#topicContent').val();
  const action = id ? 'update' : 'add';
  $.post('/PDT-NEW/projects/pdo/app/system/api/help_data.php?action='+action, {action, id, title, content}, function(response) {
    if (response.success) {
      showMessage('Operation done', 'success');
    }else{
      showMessage('Operation not done', 'error');
    }
    $('#topicModal').fadeOut();

    loadTopics();
  }).fail(function(xhr){
    alert(JSON.stringify(xhr));
  });
});

// Initial load
loadTopics();
</script>
</div>

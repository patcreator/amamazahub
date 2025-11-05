<?php include_once '../../system/cogs/db.php'; ?>
<div class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 p-6 transition-colors duration-300">

<div class="max-w-6xl mx-auto bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
  <div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-bold">Newsletter Subscribers</h1>
  </div>

  <!-- Add/Edit Form Overlay -->
  <div id="overlayForm" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg w-96">
      <h2 id="formTitle" class="text-xl font-semibold mb-4">Add Subscriber</h2>
      <form id="subscriberForm">
        <input type="hidden" id="subscriberId" name="id">
        <input type="email" id="email" name="email" placeholder="Email" required class="border w-full p-2 mb-3 rounded dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">
        <select id="status" name="status" class="border w-full p-2 mb-3 rounded dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">
          <option value="unseen">Unseen</option>
          <option value="seen">Seen</option>
          <option value="unsubscribed">Unsubscribed</option>
        </select>
        <div class="flex justify-end space-x-2">
          <button type="button" id="closeForm" class="bg-gray-400 text-white px-3 py-2 rounded">Back</button>
          <button type="submit" class="bg-green-500 text-white px-3 py-2 rounded">Save</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Send Email Form -->
  <div class="mt-6">
    <h2 class="text-xl font-semibold mb-2">Send Newsletter</h2>
    <form id="sendEmailForm">
      <select multiple id="emailSelect" name="emails[]" class="border w-full p-2 rounded mb-2 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">
        <?php
        $stmt = $pdo->query("SELECT email FROM subscribers ORDER BY id DESC");
        while ($row = $stmt->fetch()) {
          echo "<option value='{$row['email']}'>{$row['email']}</option>";
        }
        ?>
      </select>
      <input type="text" name="subject" placeholder="Subject" required class="border w-full p-2 mb-2 rounded dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">
      <textarea name="message" placeholder="Plain Text Message" class="border w-full p-2 mb-2 rounded dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100"></textarea>
      <textarea name="htmlMessage" placeholder="HTML Message (optional)" class="border w-full p-2 mb-2 rounded dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100"></textarea>
      <input type="text" name="cta" placeholder="Call To Action Link (optional)" class="border w-full p-2 mb-2 rounded dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">
      <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Send Email</button>
    </form>
  </div>

  <!-- Subscriber Cards -->
  <div id="subscriberCards" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mt-6">
    <?php
      $stmt = $pdo->query("SELECT * FROM subscribers ORDER BY id DESC");
      while ($row = $stmt->fetch()):
    ?>
    <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow">
      <p class="font-semibold text-lg"><?= htmlspecialchars($row['email']); ?></p>
      <p class="text-sm text-gray-600 dark:text-gray-300"><?= htmlspecialchars($row['status']); ?></p>
      <div class="mt-3 flex justify-between">
        <button class="editBtn bg-yellow-500 text-white px-3 py-1 rounded"
          data-id="<?= $row['id']; ?>"
          data-email="<?= $row['email']; ?>"
          data-status="<?= $row['status']; ?>">Edit</button>
        <button class="deleteBtn bg-red-500 text-white px-3 py-1 rounded"
          data-id="<?= $row['id']; ?>">Delete</button>
      </div>
    </div>
    <?php endwhile; ?>
  </div>
</div>

<script>
$('#toggleDarkMode').click(()=> $('html').toggleClass('dark'));

$('#showAddForm').click(()=> {
  $('#formTitle').text('Add Subscriber');
  $('#subscriberId').val('');
  $('#email').val('');
  $('#status').val('unseen');
  $('#overlayForm').removeClass('hidden');
});

$('#closeForm').click(()=> $('#overlayForm').addClass('hidden'));

$('#subscriberForm').submit(function(e){
  e.preventDefault();
  $.post($('#subscriberId').val() ? '/PDT-NEW/projects/pdo/app/system/api/newsletter/update.php' : '/PDT-NEW/projects/pdo/app/system/api/newsletter/add.php', $(this).serialize(), (res)=> {
      showMessage('email updated!');

  });
});

$('.editBtn').click(function(){
  $('#formTitle').text('Edit Subscriber');
  $('#subscriberId').val($(this).data('id'));
  $('#email').val($(this).data('email'));
  $('#status').val($(this).data('status'));
  $('#overlayForm').removeClass('hidden');
});

$('.deleteBtn').click(function(){
  if(confirm('Delete this subscriber?')){
    $.post('/PDT-NEW/projects/pdo/app/system/api/newsletter/delete.php', {id: $(this).data('id')}, (res)=>{
      showMessage('Data has been deleted','success');
      $(this).parent().parent().remove();
    });
  }
});

$('#sendEmailForm').submit(function(e){
  e.preventDefault();
  $.post('/PDT-NEW/projects/pdo/app/system/api/newsletter/send_email.php', $(this).serialize(), function(res){
    showMessage(res,'success');
    // alert(res);
    $('#sendEmailForm')[0].reset();
  });
});
</script>

</div>
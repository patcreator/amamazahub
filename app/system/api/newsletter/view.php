    
    <?php
      include '../../cogs/db.php';
      function loadCards($pdo){
      $stmt = $pdo->query("SELECT * FROM subscribers ORDER BY id DESC");
      $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <?php } ?>
    <?php loadCards($pdo) ?>
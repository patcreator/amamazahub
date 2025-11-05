<?php
$id = $_GET['id'] ?? null;
if (!$id) { die('Missing id'); }
include_once '../../../system/cogs/functions.php';$row = fetchData("SELECT * FROM `todos` WHERE `id` = ?", [$id])[0] ?? null;
if (!$row) { die('Record not found'); }
?>
<div class="max-w-3xl mx-auto mt-8 bg-white p-6 rounded-lg shadow-md"><form id="edittodosForm" method="POST" action="/update/todos?id=<?= $id ?>" class="space-y-6">
            <div>
                <label class='block text-sm font-medium text-gray-700 mb-1' for='id'>id</label>
                <input type='number' id='id' name='id' required 
                    value='<?= htmlspecialchars($row["id"] ?? "") ?>'
                    maxlength='11' placeholder="Enter id" 
                    
                    class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
            </div>
        
            <div>
                <label class='block text-sm font-medium text-gray-700 mb-1' for='task'>task</label>
                <input type='text' id='task' name='task' required 
                    value='<?= htmlspecialchars($row["task"] ?? "") ?>'
                    maxlength='255' placeholder="Enter task" 
                    
                    class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
            </div>
        
            <div>
                <label class='block text-sm font-medium text-gray-700 mb-1' for='completed'>completed</label>
                <input type='number' id='completed' name='completed'  
                    value='<?= htmlspecialchars($row["completed"] ?? "") ?>'
                    maxlength='1' placeholder="Enter completed" 
                    
                    class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
            </div>
        
            <div>
                <label class='block text-sm font-medium text-gray-700 mb-1' for='created_at'>created_at</label>
                <input type='datetime-local' id='created_at' name='created_at' required 
                    value='<?= htmlspecialchars($row["created_at"] ?? "") ?>'
                     placeholder="Enter created_at" 
                    
                    class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
            </div>
        
            <div>
                <label class='block text-sm font-medium text-gray-700 mb-1' for='updated_at'>updated_at</label>
                <input type='datetime-local' id='updated_at' name='updated_at' required 
                    value='<?= htmlspecialchars($row["updated_at"] ?? "") ?>'
                     placeholder="Enter updated_at" 
                    
                    class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
            </div>
        <?php $selectedVal = $row['status']; ?>

        <div>
            <label class='block text-sm font-medium text-gray-700 mb-1' for='status'>status</label>
            <select id='status' name='status' 
                class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400'>
                <option value='' disabled>Select one</option>
                <?php foreach (array (
  0 => 'ACTIVE',
  1 => 'NOT-ACTIVE',
) as $val): ?>
<option value='<?= $val ?>' <?= ($selectedVal == $val) ? 'selected' : '' ?>><?= $val ?></option>
<?php endforeach; ?>

            </select>
        </div>
    
        <div>
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
                Update Todos
            </button>
        </div>
    </form></div>
<?php
$id = $_GET['id'] ?? null;
if (!$id) { die('Missing id'); }
include_once '../../../system/cogs/functions.php';$row = fetchData("SELECT * FROM `pdt_districtcoordinator` WHERE `id` = ?", [$id])[0] ?? null;
if (!$row) { die('Record not found'); }
?>
<div class="max-w-3xl mx-auto mt-8 bg-white p-6 rounded-lg shadow-md"><form id="editpdt_districtcoordinatorForm" method="POST" action="/update/pdt_districtcoordinator?id=<?= $id ?>" class="space-y-6">
            <div>
                <label class='block text-sm font-medium text-gray-700 mb-1' for='fullName'>fullName</label>
                <input type='text' id='fullName' name='fullName' required 
                    value='<?= htmlspecialchars($row["fullName"] ?? "") ?>'
                    maxlength='100' placeholder="Enter fullName" 
                    
                    class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
            </div>
        
            <div>
                <label class='block text-sm font-medium text-gray-700 mb-1' for='email'>email</label>
                <input type='text' id='email' name='email' required 
                    value='<?= htmlspecialchars($row["email"] ?? "") ?>'
                    maxlength='100' placeholder="Enter email" 
                    
                    class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
            </div>
        
            <div>
                <label class='block text-sm font-medium text-gray-700 mb-1' for='phone'>phone</label>
                <input type='text' id='phone' name='phone' required 
                    value='<?= htmlspecialchars($row["phone"] ?? "") ?>'
                    maxlength='15' placeholder="Enter phone" 
                    
                    class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
            </div>
        
            <div>
                <label class='block text-sm font-medium text-gray-700 mb-1' for='password'>password</label>
                <input type='text' id='password' name='password' required 
                    value='<?= htmlspecialchars($row["password"] ?? "") ?>'
                     placeholder="Enter password" 
                    
                    class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
            </div>
        
            <div>
                <label class='block text-sm font-medium text-gray-700 mb-1' for='createdDate'>createdDate</label>
                <input type='datetime-local' id='createdDate' name='createdDate' required 
                    value='<?= htmlspecialchars($row["createdDate"] ?? "") ?>'
                     placeholder="Enter createdDate" 
                    
                    class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
            </div>
        <?php $selectedVal = $row['status']; ?>

        <div>
            <label class='block text-sm font-medium text-gray-700 mb-1' for='status'>status</label>
            <select id='status' name='status' required
                class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400'>
                <option value='' disabled>Select one</option>
                <?php foreach (array (
  0 => 'HIDE',
  1 => 'SHOW',
  2 => 'DELETED',
) as $val): ?>
<option value='<?= $val ?>' <?= ($selectedVal == $val) ? 'selected' : '' ?>><?= $val ?></option>
<?php endforeach; ?>

            </select>
        </div>
    
            <div>
                <label class='block text-sm font-medium text-gray-700 mb-1' for='Level'>Level</label>
                <input type='text' id='Level' name='Level' required 
                    value='<?= htmlspecialchars($row["Level"] ?? "") ?>'
                    maxlength='70' placeholder="Enter Level" 
                    
                    class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
            </div>
        
            <div>
                <label class='block text-sm font-medium text-gray-700 mb-1' for='Location'>Location</label>
                <input type='text' id='Location' name='Location' required 
                    value='<?= htmlspecialchars($row["Location"] ?? "") ?>'
                     placeholder="Enter Location" 
                    
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
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
                Update Pdt_districtcoordinator
            </button>
        </div>
    </form></div>
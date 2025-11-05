<?php
$id = $_GET['id'] ?? null;
if (!$id) { die('Missing id'); }
include_once '../../../system/cogs/functions.php';$row = fetchData("SELECT * FROM `user_profile` WHERE `id` = ?", [$id])[0] ?? null;
if (!$row) { die('Record not found'); }
?>
<div class="max-w-3xl mx-auto mt-8 bg-white p-6 rounded-lg shadow-md"><form id="edituser_profileForm" method="POST" action="/update/user_profile?id=<?= $id ?>" class="space-y-6">
            <div>
                <label class='block text-sm font-medium text-gray-700 mb-1' for='id'>id</label>
                <input type='number' id='id' name='id' required 
                    value='<?= htmlspecialchars($row["id"] ?? "") ?>'
                    maxlength='20' placeholder="Enter id" 
                    
                    class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
            </div>
        
            <div>
                <label class='block text-sm font-medium text-gray-700 mb-1' for='user_id'>user_id</label>
                <input type='number' id='user_id' name='user_id' required 
                    value='<?= htmlspecialchars($row["user_id"] ?? "") ?>'
                    maxlength='20' placeholder="Enter user_id" 
                    
                    class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
            </div>
        
            <div>
                <label class='block text-sm font-medium text-gray-700 mb-1' for='first_name'>first_name</label>
                <input type='text' id='first_name' name='first_name' required 
                    value='<?= htmlspecialchars($row["first_name"] ?? "") ?>'
                    maxlength='100' placeholder="Enter first_name" 
                    
                    class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
            </div>
        
            <div>
                <label class='block text-sm font-medium text-gray-700 mb-1' for='last_name'>last_name</label>
                <input type='text' id='last_name' name='last_name' required 
                    value='<?= htmlspecialchars($row["last_name"] ?? "") ?>'
                    maxlength='100' placeholder="Enter last_name" 
                    
                    class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
            </div>
        
            <div>
                <label class='block text-sm font-medium text-gray-700 mb-1' for='username'>username</label>
                <input type='text' id='username' name='username' required 
                    value='<?= htmlspecialchars($row["username"] ?? "") ?>'
                    maxlength='50' placeholder="Enter username" 
                    
                    class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
            </div>
        
            <div>
                <label class='block text-sm font-medium text-gray-700 mb-1' for='email'>email</label>
                <input type='text' id='email' name='email' required 
                    value='<?= htmlspecialchars($row["email"] ?? "") ?>'
                    maxlength='150' placeholder="Enter email" 
                    
                    class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
            </div>
        
            <div>
                <label class='block text-sm font-medium text-gray-700 mb-1' for='phone'>phone</label>
                <input type='text' id='phone' name='phone'  
                    value='<?= htmlspecialchars($row["phone"] ?? "") ?>'
                    maxlength='20' placeholder="Enter phone" 
                    
                    class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
            </div>
        
            <div>
                <label class='block text-sm font-medium text-gray-700 mb-1' for='avatar_url'>avatar_url</label>
                <input type='text' id='avatar_url' name='avatar_url'  
                    value='<?= htmlspecialchars($row["avatar_url"] ?? "") ?>'
                    maxlength='500' placeholder="Enter avatar_url" 
                    
                    class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
            </div>
        
            <div>
                <label class='block text-sm font-medium text-gray-700 mb-1' for='bio'>bio</label>
                <input type='text' id='bio' name='bio'  
                    value='<?= htmlspecialchars($row["bio"] ?? "") ?>'
                     placeholder="Enter bio" 
                    
                    class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
            </div>
        <?php $selectedVal = $row['gender']; ?>

        <div>
            <label class='block text-sm font-medium text-gray-700 mb-1' for='gender'>gender</label>
            <select id='gender' name='gender' 
                class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400'>
                <option value='' disabled>Select one</option>
                <?php foreach (array (
  0 => 'MALE',
  1 => 'FEMALE',
  2 => 'OTHER',
) as $val): ?>
<option value='<?= $val ?>' <?= ($selectedVal == $val) ? 'selected' : '' ?>><?= $val ?></option>
<?php endforeach; ?>

            </select>
        </div>
    
            <div>
                <label class='block text-sm font-medium text-gray-700 mb-1' for='date_of_birth'>date_of_birth</label>
                <input type='date' id='date_of_birth' name='date_of_birth'  
                    value='<?= htmlspecialchars($row["date_of_birth"] ?? "") ?>'
                     placeholder="Enter date_of_birth" 
                    
                    class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
            </div>
        
            <div>
                <label class='block text-sm font-medium text-gray-700 mb-1' for='country'>country</label>
                <input type='text' id='country' name='country'  
                    value='<?= htmlspecialchars($row["country"] ?? "") ?>'
                    maxlength='100' placeholder="Enter country" 
                    
                    class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
            </div>
        
            <div>
                <label class='block text-sm font-medium text-gray-700 mb-1' for='city'>city</label>
                <input type='text' id='city' name='city'  
                    value='<?= htmlspecialchars($row["city"] ?? "") ?>'
                    maxlength='100' placeholder="Enter city" 
                    
                    class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
            </div>
        
            <div>
                <label class='block text-sm font-medium text-gray-700 mb-1' for='state'>state</label>
                <input type='text' id='state' name='state'  
                    value='<?= htmlspecialchars($row["state"] ?? "") ?>'
                    maxlength='100' placeholder="Enter state" 
                    
                    class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
            </div>
        
            <div>
                <label class='block text-sm font-medium text-gray-700 mb-1' for='zip_code'>zip_code</label>
                <input type='text' id='zip_code' name='zip_code'  
                    value='<?= htmlspecialchars($row["zip_code"] ?? "") ?>'
                    maxlength='20' placeholder="Enter zip_code" 
                    
                    class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
            </div>
        
            <div>
                <label class='block text-sm font-medium text-gray-700 mb-1' for='social_links'>social_links</label>
                <input type='text' id='social_links' name='social_links'  
                    value='<?= htmlspecialchars($row["social_links"] ?? "") ?>'
                     placeholder="Enter social_links" 
                    
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
                Update User_profile
            </button>
        </div>
    </form></div>
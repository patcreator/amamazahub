<?php
$id = $_GET['id'] ?? null;
if (!$id) { die('Missing id'); }
include_once '../../../system/cogs/functions.php';$row = fetchData("SELECT * FROM `jobs` WHERE `id` = ?", [$id])[0] ?? null;
if (!$row) { die('Record not found'); }
?>
<div class="max-w-3xl mx-auto mt-8 bg-white p-6 rounded-lg shadow-md"><form id="editjobsForm" method="POST" action="/update/jobs?id=<?= $id ?>" class="space-y-6">
            <div>
                <label class='block text-sm font-medium text-gray-700 mb-1' for='id'>id</label>
                <input type='number' id='id' name='id' required 
                    value='<?= htmlspecialchars($row["id"] ?? "") ?>'
                    maxlength='11' placeholder="Enter id" 
                    
                    class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
            </div>
        
            <div>
                <label class='block text-sm font-medium text-gray-700 mb-1' for='job_media'>job_media</label>
                <input type='text' id='job_media' name='job_media' required 
                    value='<?= htmlspecialchars($row["job_media"] ?? "") ?>'
                     placeholder="Enter job_media" 
                    
                    class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
            </div>
        
            <div>
                <label class='block text-sm font-medium text-gray-700 mb-1' for='job_title'>job_title</label>
                <input type='text' id='job_title' name='job_title' required 
                    value='<?= htmlspecialchars($row["job_title"] ?? "") ?>'
                     placeholder="Enter job_title" 
                    
                    class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
            </div>
        
            <div>
                <label class='block text-sm font-medium text-gray-700 mb-1' for='slug'>slug</label>
                <input type='text' id='slug' name='slug' required 
                    value='<?= htmlspecialchars($row["slug"] ?? "") ?>'
                    maxlength='255' placeholder="Enter slug" 
                    
                    class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
            </div>
        
            <div>
                <label class='block text-sm font-medium text-gray-700 mb-1' for='job_description'>job_description</label>
                <input type='text' id='job_description' name='job_description' required 
                    value='<?= htmlspecialchars($row["job_description"] ?? "") ?>'
                     placeholder="Enter job_description" 
                    
                    class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
            </div>
        
            <div>
                <label class='block text-sm font-medium text-gray-700 mb-1' for='job_deadline'>job_deadline</label>
                <input type='datetime-local' id='job_deadline' name='job_deadline' required 
                    value='<?= htmlspecialchars($row["job_deadline"] ?? "") ?>'
                     placeholder="Enter job_deadline" 
                    
                    class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
            </div>
        
            <div>
                <label class='block text-sm font-medium text-gray-700 mb-1' for='company'>company</label>
                <input type='number' id='company' name='company' required 
                    value='<?= htmlspecialchars($row["company"] ?? "") ?>'
                    maxlength='11' placeholder="Enter company" 
                    
                    class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
            </div>
        
            <div>
                <label class='block text-sm font-medium text-gray-700 mb-1' for='job_category'>job_category</label>
                <input type='number' id='job_category' name='job_category' required 
                    value='<?= htmlspecialchars($row["job_category"] ?? "") ?>'
                    maxlength='11' placeholder="Enter job_category" 
                    
                    class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
            </div>
        <?php $selectedVal = $row['job_media_type']; ?>

        <div>
            <label class='block text-sm font-medium text-gray-700 mb-1' for='job_media_type'>job_media_type</label>
            <select id='job_media_type' name='job_media_type' required
                class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400'>
                <option value='' disabled>Select one</option>
                <?php foreach (array (
  0 => 'IMAGE',
  1 => 'VIDEO',
  2 => 'GALLERY',
) as $val): ?>
<option value='<?= $val ?>' <?= ($selectedVal == $val) ? 'selected' : '' ?>><?= $val ?></option>
<?php endforeach; ?>

            </select>
        </div>
    
            <div>
                <label class='block text-sm font-medium text-gray-700 mb-1' for='title'>title</label>
                <input type='text' id='title' name='title' required 
                    value='<?= htmlspecialchars($row["title"] ?? "") ?>'
                    maxlength='255' placeholder="Enter title" 
                    
                    class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
            </div>
        
            <div>
                <label class='block text-sm font-medium text-gray-700 mb-1' for='description'>description</label>
                <input type='text' id='description' name='description'  
                    value='<?= htmlspecialchars($row["description"] ?? "") ?>'
                     placeholder="Enter description" 
                    
                    class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
            </div>
        
            <div>
                <label class='block text-sm font-medium text-gray-700 mb-1' for='requirements'>requirements</label>
                <input type='text' id='requirements' name='requirements'  
                    value='<?= htmlspecialchars($row["requirements"] ?? "") ?>'
                     placeholder="Enter requirements" 
                    
                    class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
            </div>
        
            <div>
                <label class='block text-sm font-medium text-gray-700 mb-1' for='salary_min'>salary_min</label>
                <input type='number' id='salary_min' name='salary_min'  
                    value='<?= htmlspecialchars($row["salary_min"] ?? "") ?>'
                     placeholder="Enter salary_min" 
                    step='0.01'
                    class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
            </div>
        
            <div>
                <label class='block text-sm font-medium text-gray-700 mb-1' for='salary_max'>salary_max</label>
                <input type='number' id='salary_max' name='salary_max'  
                    value='<?= htmlspecialchars($row["salary_max"] ?? "") ?>'
                     placeholder="Enter salary_max" 
                    step='0.01'
                    class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
            </div>
        
            <div>
                <label class='block text-sm font-medium text-gray-700 mb-1' for='location'>location</label>
                <input type='text' id='location' name='location'  
                    value='<?= htmlspecialchars($row["location"] ?? "") ?>'
                    maxlength='255' placeholder="Enter location" 
                    
                    class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
            </div>
        <?php $selectedVal = $row['employment_type']; ?>

        <div>
            <label class='block text-sm font-medium text-gray-700 mb-1' for='employment_type'>employment_type</label>
            <select id='employment_type' name='employment_type' 
                class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400'>
                <option value='' disabled>Select one</option>
                <?php foreach (array (
  0 => 'FULL-TIME',
  1 => 'PART-TIME',
  2 => 'CONTRACT',
  3 => 'INTERNSHIP',
) as $val): ?>
<option value='<?= $val ?>' <?= ($selectedVal == $val) ? 'selected' : '' ?>><?= $val ?></option>
<?php endforeach; ?>

            </select>
        </div>
    <?php $selectedVal = $row['experience_level']; ?>

        <div>
            <label class='block text-sm font-medium text-gray-700 mb-1' for='experience_level'>experience_level</label>
            <select id='experience_level' name='experience_level' 
                class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400'>
                <option value='' disabled>Select one</option>
                <?php foreach (array (
  0 => 'ENTRY',
  1 => 'MID',
  2 => 'SENIOR',
  3 => 'EXECUTIVE',
) as $val): ?>
<option value='<?= $val ?>' <?= ($selectedVal == $val) ? 'selected' : '' ?>><?= $val ?></option>
<?php endforeach; ?>

            </select>
        </div>
    <?php $selectedVal = $row['remote_option']; ?>

        <div>
            <label class='block text-sm font-medium text-gray-700 mb-1' for='remote_option'>remote_option</label>
            <select id='remote_option' name='remote_option' 
                class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400'>
                <option value='' disabled>Select one</option>
                <?php foreach (array (
  0 => 'ONSITE',
  1 => 'REMOTE',
  2 => 'HYBRID',
) as $val): ?>
<option value='<?= $val ?>' <?= ($selectedVal == $val) ? 'selected' : '' ?>><?= $val ?></option>
<?php endforeach; ?>

            </select>
        </div>
    
            <div>
                <label class='block text-sm font-medium text-gray-700 mb-1' for='visa_sponsorship'>visa_sponsorship</label>
                <input type='number' id='visa_sponsorship' name='visa_sponsorship'  
                    value='<?= htmlspecialchars($row["visa_sponsorship"] ?? "") ?>'
                    maxlength='1' placeholder="Enter visa_sponsorship" 
                    
                    class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
            </div>
        
            <div>
                <label class='block text-sm font-medium text-gray-700 mb-1' for='relocation_assistance'>relocation_assistance</label>
                <input type='number' id='relocation_assistance' name='relocation_assistance'  
                    value='<?= htmlspecialchars($row["relocation_assistance"] ?? "") ?>'
                    maxlength='1' placeholder="Enter relocation_assistance" 
                    
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
  1 => 'CLOSED',
  2 => 'DRAFT',
) as $val): ?>
<option value='<?= $val ?>' <?= ($selectedVal == $val) ? 'selected' : '' ?>><?= $val ?></option>
<?php endforeach; ?>

            </select>
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
        
            <div>
                <label class='block text-sm font-medium text-gray-700 mb-1' for='company_id'>company_id</label>
                <input type='number' id='company_id' name='company_id'  
                    value='<?= htmlspecialchars($row["company_id"] ?? "") ?>'
                    maxlength='11' placeholder="Enter company_id" 
                    
                    class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
            </div>
        
        <div>
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
                Update Jobs
            </button>
        </div>
    </form></div>
<div class="max-w-3xl mx-auto mt-8 bg-white p-6 rounded-lg shadow-md"><form id="addjobsForm" method="POST" action="/create/jobs" class="space-y-6">
                <div>
                    <label class='block text-sm font-medium text-gray-700 mb-1' for='id'>id</label>
                    <input type='number' id='id' name='id' required  
                        maxlength='11'
                        
                        placeholder="Enter id" class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
                </div>
            
                <div>
                    <label class='block text-sm font-medium text-gray-700 mb-1' for='job_media'>job_media</label>
                    <input type='text' id='job_media' name='job_media' required  
                        
                        
                        placeholder="Enter job_media" class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
                </div>
            
                <div>
                    <label class='block text-sm font-medium text-gray-700 mb-1' for='job_title'>job_title</label>
                    <input type='text' id='job_title' name='job_title' required  
                        
                        
                        placeholder="Enter job_title" class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
                </div>
            
                <div>
                    <label class='block text-sm font-medium text-gray-700 mb-1' for='slug'>slug</label>
                    <input type='text' id='slug' name='slug' required  
                        maxlength='255'
                        
                        placeholder="Enter slug" class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
                </div>
            
                <div>
                    <label class='block text-sm font-medium text-gray-700 mb-1' for='job_description'>job_description</label>
                    <input type='text' id='job_description' name='job_description' required  
                        
                        
                        placeholder="Enter job_description" class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
                </div>
            
                <div>
                    <label class='block text-sm font-medium text-gray-700 mb-1' for='company'>company</label>
                    <input type='number' id='company' name='company' required  
                        maxlength='11'
                        
                        placeholder="Enter company" class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
                </div>
            
                <div>
                    <label class='block text-sm font-medium text-gray-700 mb-1' for='job_category'>job_category</label>
                    <input type='number' id='job_category' name='job_category' required  
                        maxlength='11'
                        
                        placeholder="Enter job_category" class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
                </div>
            
            <div>
                <label class='block text-sm font-medium text-gray-700 mb-1' for='job_media_type'>job_media_type</label>
                <select id='job_media_type' name='job_media_type' required
                    class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400'>
                    <option value='' disabled selected>Select one</option><option value='IMAGE' >IMAGE</option><option value='VIDEO' >VIDEO</option><option value='GALLERY' >GALLERY</option>
                </select>
            </div>
        
                <div>
                    <label class='block text-sm font-medium text-gray-700 mb-1' for='title'>title</label>
                    <input type='text' id='title' name='title' required  
                        maxlength='255'
                        
                        placeholder="Enter title" class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
                </div>
            
                <div>
                    <label class='block text-sm font-medium text-gray-700 mb-1' for='description'>description</label>
                    <input type='text' id='description' name='description'   
                        
                        
                        placeholder="Enter description" class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
                </div>
            
                <div>
                    <label class='block text-sm font-medium text-gray-700 mb-1' for='requirements'>requirements</label>
                    <input type='text' id='requirements' name='requirements'   
                        
                        
                        placeholder="Enter requirements" class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
                </div>
            
                <div>
                    <label class='block text-sm font-medium text-gray-700 mb-1' for='salary_min'>salary_min</label>
                    <input type='number' id='salary_min' name='salary_min'   
                        
                        step='0.01'
                        placeholder="Enter salary_min" class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
                </div>
            
                <div>
                    <label class='block text-sm font-medium text-gray-700 mb-1' for='salary_max'>salary_max</label>
                    <input type='number' id='salary_max' name='salary_max'   
                        
                        step='0.01'
                        placeholder="Enter salary_max" class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
                </div>
            
                <div>
                    <label class='block text-sm font-medium text-gray-700 mb-1' for='location'>location</label>
                    <input type='text' id='location' name='location'   
                        maxlength='255'
                        
                        placeholder="Enter location" class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
                </div>
            
            <div>
                <label class='block text-sm font-medium text-gray-700 mb-1' for='employment_type'>employment_type</label>
                <select id='employment_type' name='employment_type' 
                    class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400'>
                    <option value='' disabled selected>Select one</option><option value='FULL-TIME' >FULL-TIME</option><option value='PART-TIME' >PART-TIME</option><option value='CONTRACT' >CONTRACT</option><option value='INTERNSHIP' >INTERNSHIP</option>
                </select>
            </div>
        
            <div>
                <label class='block text-sm font-medium text-gray-700 mb-1' for='experience_level'>experience_level</label>
                <select id='experience_level' name='experience_level' 
                    class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400'>
                    <option value='' disabled selected>Select one</option><option value='ENTRY' >ENTRY</option><option value='MID' >MID</option><option value='SENIOR' >SENIOR</option><option value='EXECUTIVE' >EXECUTIVE</option>
                </select>
            </div>
        
            <div>
                <label class='block text-sm font-medium text-gray-700 mb-1' for='remote_option'>remote_option</label>
                <select id='remote_option' name='remote_option' 
                    class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400'>
                    <option value='' disabled selected>Select one</option><option value='ONSITE' >ONSITE</option><option value='REMOTE' >REMOTE</option><option value='HYBRID' >HYBRID</option>
                </select>
            </div>
        
                <div>
                    <label class='block text-sm font-medium text-gray-700 mb-1' for='visa_sponsorship'>visa_sponsorship</label>
                    <input type='number' id='visa_sponsorship' name='visa_sponsorship'   
                        maxlength='1'
                        
                        placeholder="Enter visa_sponsorship" class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
                </div>
            
                <div>
                    <label class='block text-sm font-medium text-gray-700 mb-1' for='relocation_assistance'>relocation_assistance</label>
                    <input type='number' id='relocation_assistance' name='relocation_assistance'   
                        maxlength='1'
                        
                        placeholder="Enter relocation_assistance" class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
                </div>
            
            <div>
                <label class='block text-sm font-medium text-gray-700 mb-1' for='status'>status</label>
                <select id='status' name='status' 
                    class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400'>
                    <option value='' disabled selected>Select one</option><option value='ACTIVE' >ACTIVE</option><option value='CLOSED' >CLOSED</option><option value='DRAFT' >DRAFT</option>
                </select>
            </div>
        
                <div>
                    <label class='block text-sm font-medium text-gray-700 mb-1' for='company_id'>company_id</label>
                    <input type='number' id='company_id' name='company_id'   
                        maxlength='11'
                        
                        placeholder="Enter company_id" class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
                </div>
            
            <div>
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
                    Add Jobs
                </button>
            </div>
        </form></div>
<div class="max-w-3xl mx-auto mt-8 bg-white p-6 rounded-lg shadow-md"><form id="adduser_activityForm" method="POST" action="/create/user_activity" class="space-y-6">
                <div>
                    <label class='block text-sm font-medium text-gray-700 mb-1' for='id'>id</label>
                    <input type='number' id='id' name='id' required value='295593' 
                        maxlength='11'
                        
                        placeholder="Enter id" class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
                </div>
            
        <div>
            <label class='block text-sm font-medium text-gray-700 mb-1' for='user_id'>user_id</label>
            <select id='user_id' name='user_id' required
                class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400'>
                <option value='' disabled selected>Select one</option>
                <option value='4009'>patrick</option><option value='4010'>admin</option><option value='4011'>admin1</option>
            </select>
        </div>
    
                <div>
                    <label class='block text-sm font-medium text-gray-700 mb-1' for='activity_type'>activity_type</label>
                    <input type='text' id='activity_type' name='activity_type' required  
                        maxlength='100'
                        
                        placeholder="Enter activity_type" class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
                </div>
            
                <div>
                    <label class='block text-sm font-medium text-gray-700 mb-1' for='description'>description</label>
                    <input type='text' id='description' name='description' required  
                        
                        
                        placeholder="Enter description" class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
                </div>
            
                <div>
                    <label class='block text-sm font-medium text-gray-700 mb-1' for='ip_address'>ip_address</label>
                    <input type='text' id='ip_address' name='ip_address'   
                        maxlength='50'
                        
                        placeholder="Enter ip_address" class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
                </div>
            
            <div>
                <label class='block text-sm font-medium text-gray-700 mb-1' for='status'>status</label>
                <select id='status' name='status' 
                    class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400'>
                    <option value='' disabled selected>Select one</option><option value='ACTIVE' >ACTIVE</option><option value='NOT-ACTIVE' >NOT-ACTIVE</option>
                </select>
            </div>
        
            <div>
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
                    Add User_activity
                </button>
            </div>
        </form></div>
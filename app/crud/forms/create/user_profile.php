<div class="max-w-3xl mx-auto mt-8 bg-white p-6 rounded-lg shadow-md"><form id="adduser_profileForm" method="POST" action="/create/user_profile" class="space-y-6">
                <div>
                    <label class='block text-sm font-medium text-gray-700 mb-1' for='id'>id</label>
                    <input type='number' id='id' name='id' required value='639048' 
                        maxlength='20'
                        
                        placeholder="Enter id" class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
                </div>
            
                <div>
                    <label class='block text-sm font-medium text-gray-700 mb-1' for='user_id'>user_id</label>
                    <input type='number' id='user_id' name='user_id' required  
                        maxlength='20'
                        
                        placeholder="Enter user_id" class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
                </div>
            
                <div>
                    <label class='block text-sm font-medium text-gray-700 mb-1' for='first_name'>first_name</label>
                    <input type='text' id='first_name' name='first_name' required  
                        maxlength='100'
                        
                        placeholder="Enter first_name" class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
                </div>
            
                <div>
                    <label class='block text-sm font-medium text-gray-700 mb-1' for='last_name'>last_name</label>
                    <input type='text' id='last_name' name='last_name' required  
                        maxlength='100'
                        
                        placeholder="Enter last_name" class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
                </div>
            
                <div>
                    <label class='block text-sm font-medium text-gray-700 mb-1' for='username'>username</label>
                    <input type='text' id='username' name='username' required  
                        maxlength='50'
                        
                        placeholder="Enter username" class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
                </div>
            
                <div>
                    <label class='block text-sm font-medium text-gray-700 mb-1' for='email'>email</label>
                    <input type='text' id='email' name='email' required  
                        maxlength='150'
                        
                        placeholder="Enter email" class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
                </div>
            
                <div>
                    <label class='block text-sm font-medium text-gray-700 mb-1' for='phone'>phone</label>
                    <input type='text' id='phone' name='phone'   
                        maxlength='20'
                        
                        placeholder="Enter phone" class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
                </div>
            
                <div>
                    <label class='block text-sm font-medium text-gray-700 mb-1' for='avatar_url'>avatar_url</label>
                    <input type='text' id='avatar_url' name='avatar_url'   
                        maxlength='500'
                        
                        placeholder="Enter avatar_url" class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
                </div>
            
                <div>
                    <label class='block text-sm font-medium text-gray-700 mb-1' for='bio'>bio</label>
                    <input type='text' id='bio' name='bio'   
                        
                        
                        placeholder="Enter bio" class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
                </div>
            
            <div>
                <label class='block text-sm font-medium text-gray-700 mb-1' for='gender'>gender</label>
                <select id='gender' name='gender' 
                    class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400'>
                    <option value='' disabled selected>Select one</option><option value='MALE' >MALE</option><option value='FEMALE' >FEMALE</option><option value='OTHER' >OTHER</option>
                </select>
            </div>
        
                <div>
                    <label class='block text-sm font-medium text-gray-700 mb-1' for='date_of_birth'>date_of_birth</label>
                    <input type='date' id='date_of_birth' name='date_of_birth'   
                        
                        
                        placeholder="Enter date_of_birth" class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
                </div>
            
                <div>
                    <label class='block text-sm font-medium text-gray-700 mb-1' for='country'>country</label>
                    <input type='text' id='country' name='country'   
                        maxlength='100'
                        
                        placeholder="Enter country" class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
                </div>
            
                <div>
                    <label class='block text-sm font-medium text-gray-700 mb-1' for='city'>city</label>
                    <input type='text' id='city' name='city'   
                        maxlength='100'
                        
                        placeholder="Enter city" class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
                </div>
            
                <div>
                    <label class='block text-sm font-medium text-gray-700 mb-1' for='state'>state</label>
                    <input type='text' id='state' name='state'   
                        maxlength='100'
                        
                        placeholder="Enter state" class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
                </div>
            
                <div>
                    <label class='block text-sm font-medium text-gray-700 mb-1' for='zip_code'>zip_code</label>
                    <input type='text' id='zip_code' name='zip_code'   
                        maxlength='20'
                        
                        placeholder="Enter zip_code" class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
                </div>
            
                <div>
                    <label class='block text-sm font-medium text-gray-700 mb-1' for='social_links'>social_links</label>
                    <input type='text' id='social_links' name='social_links'   
                        
                        
                        placeholder="Enter social_links" class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
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
                    Add User_profile
                </button>
            </div>
        </form></div>
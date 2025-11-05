<div class="max-w-3xl mx-auto mt-8 bg-white p-6 rounded-lg shadow-md"><form id="addnotificationsForm" method="POST" action="/create/notifications" class="space-y-6">
                <div>
                    <label class='block text-sm font-medium text-gray-700 mb-1' for='id'>id</label>
                    <input type='number' id='id' name='id' required value='153478' 
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
                    <label class='block text-sm font-medium text-gray-700 mb-1' for='sender_id'>sender_id</label>
                    <input type='number' id='sender_id' name='sender_id'   
                        maxlength='20'
                        
                        placeholder="Enter sender_id" class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
                </div>
            
                <div>
                    <label class='block text-sm font-medium text-gray-700 mb-1' for='title'>title</label>
                    <input type='text' id='title' name='title' required  
                        maxlength='255'
                        
                        placeholder="Enter title" class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
                </div>
            
                <div>
                    <label class='block text-sm font-medium text-gray-700 mb-1' for='message'>message</label>
                    <input type='text' id='message' name='message' required  
                        
                        
                        placeholder="Enter message" class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
                </div>
            
                <div>
                    <label class='block text-sm font-medium text-gray-700 mb-1' for='type'>type</label>
                    <input type='text' id='type' name='type' required  
                        maxlength='50'
                        
                        placeholder="Enter type" class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
                </div>
            
                <div>
                    <label class='block text-sm font-medium text-gray-700 mb-1' for='link'>link</label>
                    <input type='text' id='link' name='link'   
                        maxlength='500'
                        
                        placeholder="Enter link" class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
                </div>
            
                <div>
                    <label class='block text-sm font-medium text-gray-700 mb-1' for='is_read'>is_read</label>
                    <input type='number' id='is_read' name='is_read'   
                        maxlength='1'
                        
                        placeholder="Enter is_read" class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
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
                    Add Notifications
                </button>
            </div>
        </form></div>
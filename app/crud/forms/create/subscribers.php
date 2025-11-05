<div class="max-w-3xl mx-auto mt-8 bg-white p-6 rounded-lg shadow-md"><form id="addsubscribersForm" method="POST" action="/create/subscribers" class="space-y-6">
                <div>
                    <label class='block text-sm font-medium text-gray-700 mb-1' for='id'>id</label>
                    <input type='number' id='id' name='id' required value='351362' 
                        maxlength='11'
                        
                        placeholder="Enter id" class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
                </div>
            
                <div>
                    <label class='block text-sm font-medium text-gray-700 mb-1' for='email'>email</label>
                    <input type='text' id='email' name='email' required  
                        maxlength='255'
                        
                        placeholder="Enter email" class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
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
                    Add Subscribers
                </button>
            </div>
        </form></div>
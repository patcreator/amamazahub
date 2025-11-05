<div class="max-w-3xl mx-auto mt-8 bg-white p-6 rounded-lg shadow-md"><form id="addpdt_provincecoordinatorForm" method="POST" action="/create/pdt_provincecoordinator" class="space-y-6">
                <div>
                    <label class='block text-sm font-medium text-gray-700 mb-1' for='fullName'>fullName</label>
                    <input type='text' id='fullName' name='fullName' required  
                        maxlength='100'
                        
                        placeholder="Enter fullName" class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
                </div>
            
                <div>
                    <label class='block text-sm font-medium text-gray-700 mb-1' for='email'>email</label>
                    <input type='text' id='email' name='email' required  
                        maxlength='100'
                        
                        placeholder="Enter email" class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
                </div>
            
                <div>
                    <label class='block text-sm font-medium text-gray-700 mb-1' for='phone'>phone</label>
                    <input type='text' id='phone' name='phone' required  
                        maxlength='15'
                        
                        placeholder="Enter phone" class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
                </div>
            
                <div>
                    <label class='block text-sm font-medium text-gray-700 mb-1' for='password'>password</label>
                    <input type='text' id='password' name='password' required  
                        
                        
                        placeholder="Enter password" class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
                </div>
            
            <div>
                <label class='block text-sm font-medium text-gray-700 mb-1' for='status'>status</label>
                <select id='status' name='status' required
                    class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400'>
                    <option value='' disabled selected>Select one</option><option value='HIDE' >HIDE</option><option value='SHOW' >SHOW</option><option value='DELETED' >DELETED</option>
                </select>
            </div>
        
                <div>
                    <label class='block text-sm font-medium text-gray-700 mb-1' for='Level'>Level</label>
                    <input type='text' id='Level' name='Level' required  
                        maxlength='70'
                        
                        placeholder="Enter Level" class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
                </div>
            
                <div>
                    <label class='block text-sm font-medium text-gray-700 mb-1' for='Location'>Location</label>
                    <input type='text' id='Location' name='Location' required  
                        
                        
                        placeholder="Enter Location" class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-400' />
                </div>
            
            <div>
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
                    Add Pdt_provincecoordinator
                </button>
            </div>
        </form></div>
<h5 class="text-2xl px-5 request-title"></h5>
<div id="output" class="overflow-x-auto p-5 dark:bg-gray-900 dark:border-gray-600 bg-white border mx-5 rounded-2xl my-5">
    <span class="text-gray-300">Output</span>
</div>
<section class="p-5 rounded border dark:border-gray-600 mx-5 bg-white dark:bg-gray-900 rounded-2xl">
   <div class="w-full px-5 py-3 mb-4 border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-800 dark:border-gray-600">
       <div class="px-4 py-2 bg-white rounded-t-lg dark:bg-gray-800">
           <label for="input" class="sr-only">Your input</label>
           <textarea id="input" rows="4" class="w-full px-0 text-sm text-gray-900 bg-white border-0 dark:bg-gray-800 focus:ring-0 dark:text-white focus:outline-none dark:placeholder-gray-400" placeholder="Write a input..." required autofocus></textarea>
       </div>
       <div class="flex items-center justify-between px-3 py-2 border-t dark:border-gray-600 border-gray-200">
        <button class="py-2.5 end-0 px-3 text-xs bg-red-200 hover:bg-red-400 dark:bg-red-500 dark:text-white dark:hover:bg-red-800 me-4 rounded-lg" onclick="$('#output').html('');$('#input').html('')">Clear output</button>
           <button class="inline-flex send items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-900 hover:bg-blue-800">
               Run
           </button>
           </div>
       </div>
   </div>
</section>

<p class="ms-auto text-xs text-gray-500 dark:text-gray-400 text-center my-5">Make sure you didn't share you authentication credential to anyone else this page can be used as the hacking portal <a href="#" class="text-blue-600 dark:text-blue-500 hover:underline">Community Guidelines</a>.</p>
<script>
        $(".send").on("click", function(){
            $.post("<?= $path ?>app/api/cmd-runner.php",{
                input: $("#input").val()
            },function (response) {
                $(".request-title").html(`<strong> Input:${$("#input").val()}</strong> `);
                $("#output").html(response.message||'no message');
            }).fail(function (xhr,error,code){
                alert(JSON.stringify(xhr));
                showMessage('500| server error');
            });
        });
        // Handle Ctrl + Enter (or Cmd + Enter)
        $(document).on("keydown", function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === "Enter") {
                $(".send").trigger("click");
            }
        });
    </script>
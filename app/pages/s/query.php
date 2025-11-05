  <style>
    /* small tweaks */
    .truncate-ellipsis { white-space: nowrap; text-overflow: ellipsis; overflow: hidden; }
    /* caret focus for the pseudo-dropdown */
    .focus-ring:focus { outline: 2px solid transparent; box-shadow: 0 0 0 4px rgba(99,102,241,0.12); }
  </style>
<section class="dark:bg-slate-900 dark:text-slate-100 min-h-screen p-6 transition-colors duration-200">

<!-- Container card -->
<div class="max-w-6xl mx-auto">
  <div class="rounded-2xl shadow-2xl overflow-hidden dark:bg-slate-800 dark:bg-slate-900 ring-1 ring-black/10">
    <!-- Header -->
    <div class="flex items-center justify-between px-6 py-4 border-b dark:border-slate-700 dark:border-slate-200">
      <div class="flex  gap-4 flex-col">
        <h2 class="text-lg font-semibold">Query Runner</h2>
        <div class="flex gap-2 overflow-x-auto w-[82vw] scrollbar p-3">
          <?php
            $data = x_retrivedata("SHOW TABLES", false);

            $tbs = [];
            foreach ($data as $array) {
              $tb = $array[0] ?? '';
              $tbs[] = $tb;
              $rnd = "x_".uniqid();
              // Button (table chip) + hidden select (replaced by tailwind styled select below)
              echo "<div class='group relative'>
                      <button onclick='$(\".btn-0s\").removeClass(\"bg-slate-600\");$(this).addClass(\"bg-slate-600\");' type='button' data-rnd='{$rnd}' class='table-chip inline-block px-3 py-1 dark:bg-slate-700 bg-slate-200/70 hover:bg-slate-300 dark:hover:bg-slate-600 text-sm rounded text-gray-900 dark:text-white truncate-ellipsis btn-0s' title='$tb: click for more'>$tb</button>
                    </div>";
            }
          ?>
        </div>
              <!-- Below: quick query presets hidden selects per table (placed here to keep DOM) -->
      <div class="col-span-12">
        <div id="table-presets" class="space-y-2">
          <?php
            // Produce the preset selects similar to your earlier code (hidden by default, shown when table chip clicked)
            $data = x_retrivedata("SHOW TABLES", false);
            foreach ($data as $array) {
              $tb =$array[0]??'';
              $rnd = "x_".uniqid();
              $query2 = x_retrivedata("DESC `$tb`", false);
              $insert = $insert1 = $update = $select = '';
              $pk = '';
              foreach ($query2 as $column) {
                $col = $column['Field'] ?? $column[0];
                $insert .= "`$col`, ";
                $insert1 .= "'value', ";
                $update .= "`$col` = 'value', ";
                $select .= "`$col`, ";
                if (isset($column['Key']) && $column['Key']=='PRI') {
                  $pk = $column['Field'];
                }
              }
              $insert = rtrim($insert,', ');
              $insert1 = rtrim($insert1,', ');
              $update = rtrim($update,', ');
              $select = rtrim($select,', ');
              $pk = $pk ?? '';
              $where = $pk ? "`$pk` = 'value' " : "1=1";
              // Hidden preset container
              echo "<div class='tb-ql-data hidden p-2 dark:bg-slate-800 border dark:border-slate-700 dark:border-slate-200 rounded' data-rnd='$rnd'>
                      <select class='w-full p-2 text-xs dark:bg-slate-700 bg-slate-200/40 rounded select-presets'>
                        <option selected disabled>Queries...</option>
                        <option>SELECT * FROM $tb</option>
                        <option>SELECT $select FROM $tb</option>
                        <option>SELECT * FROM $tb WHERE $where</option>
                        <option>SELECT * FROM $tb WHERE $where order by RAND()</option>
                        <option>SELECT * FROM $tb WHERE $where group by $pk</option>
                        <option>UPDATE $tb SET $update WHERE $where</option>
                        <option>UPDATE $tb SET $where</option>
                        <option>DELETE FROM $tb WHERE $where</option>
                        <option>DELETE FROM $tb</option>
                        <option>TRUNCATE $tb</option>
                        <option>INSERT INTO $tb($insert)VALUES($insert1)</option>
                        <option>INSERT INTO $tb VALUES($insert1)</option>
                        <option>INSERT INTO $tb VALUES SELECT * FROM $tb</option>
                      </select>
                    </div>";
            }
          ?>
        </div>
      </div>
      </div>
    </div>

    <!-- Body -->
    <div class="p-6 grid grid-cols-12 gap-6">
      <!-- Left column: SQL textarea & controls (col-span 8) -->
      <div class="col-span-12 lg:col-span-8">
        <textarea id="sql-field" rows="6" placeholder="Enter your sql here"
          class="w-full resize-y rounded-md dark:bg-slate-800 border-b-2 border-sky-600 focus:border-sky-500 focus:ring-0 text-sm p-4 placeholder:text-slate-400"
          onclick='$(".tb-ql-data").slideUp("fast");' autofocus></textarea>

        <div class="mt-4 flex items-start gap-4">
          <!-- Queries "dropdown" style (custom) -->
          <div class="relative">
            <button id="queries-btn" class="px-3 py-2 bg-sky-600 hover:bg-sky-500 text-white rounded-md text-sm">Queries</button>
            <div id="queries-menu" class="hidden absolute z-30 mt-2 w-64 dark:bg-slate-800 border dark:border-slate-700 dark:border-slate-200 rounded-md shadow-lg p-3">
              <div class="flex flex-wrap gap-2">
                <?php
                $tokens = ['SELECT','DELETE','UPDATE','INSERT','*','FROM','SET','WHERE','AND','OR','NOT','=','<','>','!','LIKE'];
                foreach ($tokens as $tok) {
                  echo "<button type='button' class='token-btn px-2 py-1 dark:bg-slate-700 bg-slate-200 hover:bg-slate-300 dark:hover:bg-slate-600 text-xs rounded' data-val='$tok'>$tok</button>";
                }
                ?>
              </div>
              <div class="mt-3 text-xs space-y-2">
                <button class="snippet-btn block w-full text-left px-3 py-1 rounded dark:bg-slate-700 bg-slate-200 hover:bg-slate-300 dark:hover:bg-slate-600 text-xs" data-val="UPDATE `table` SET `col`='value',`col`='value' where `col` = 'value';">UPDATE `table` ...</button>
                <button class="snippet-btn block w-full text-left px-3 py-1 rounded dark:bg-slate-700 bg-slate-200 hover:bg-slate-300 dark:hover:bg-slate-600 text-xs" data-val="INSERT INTO `table`(`col1`,`col2`) VALUES('val1','val2');">INSERT INTO `table` ...</button>
                <button class="snippet-btn block w-full text-left px-3 py-1 rounded dark:bg-slate-700 bg-slate-200 hover:bg-slate-300 dark:hover:bg-slate-600 text-xs" data-val="SELECT * FROM `table` where `col` = 'value';">SELECT * FROM `table` ...</button>
                <button class="snippet-btn block w-full text-left px-3 py-1 rounded dark:bg-slate-700 bg-slate-200 hover:bg-slate-300 dark:hover:bg-slate-600 text-xs" data-val="DELETE FROM `table` where `col` = 'value';">DELETE FROM `table` ...</button>
              </div>
            </div>
          </div>

          <!-- Execute / Clear -->
          <div class="ml-auto flex gap-2">
            <button id="execute-sql" class="px-4 py-2 bg-gradient-to-br from-emerald-500 to-emerald-400 hover:from-emerald-400 hover:to-emerald-300 rounded-md text-white">Ignate</button>
            <button id="clear-all" class="px-4 py-2 bg-red-600 hover:bg-red-500 text-white rounded-md">Clear</button>
          </div>
        </div>
      </div>

      <!-- Right column: Tables & columns (col-span 4) -->
      <div class="col-span-12 lg:col-span-4">
        <div class="text-xs text-red-400 flex items-center gap-2 mb-2"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 9v2" /></svg><span>* Double click to add Table</span></div>

        <div class="rounded-lg border dark:border-slate-700 dark:border-slate-200 dark:bg-slate-800 overflow-hidden">
          <div class="px-3 py-2 bg-slate-900/50 text-sm">Tables</div>
          <div class="p-3 max-h-56 overflow-auto space-y-2">
          <?php
            // Re-generate with columns
            $data = x_retrivedata("SHOW TABLES", false);
            foreach ($data as $array) {
              $tb = $array[0] ?? '';
              echo "<div class='flex items-center justify-between gap-3'>
                      <span class='table-name text-sm px-2 py-1 rounded dark:bg-slate-700 bg-slate-200 hover:bg-slate-300 dark:hover:bg-slate-600 cursor-pointer truncate-ellipsis' title='Double-click to insert' data-name='{$tb}'>$tb</span>
                      <select class='col-select text-xs dark:bg-slate-700 bg-slate-200/40 rounded px-2 py-1 form-select' data-tb='$tb'>
                        <option selected disabled>Columns...</option>";
              $query2 = x_retrivedata("DESC `$tb`", false);
              foreach ($query2 as $column) {
                // column can be associative or numeric, handle both
                $col = is_array($column) ? ($column['Field'] ?? $column[0]) : $column;
                echo "<option value='$col'>$col</option>";
              }
              echo "</select></div>";
            }
          ?>
          </div>
        </div>
      </div>

      <!-- Result box -->
      <div class="col-span-12">
        <div id="result-box" class="rounded-lg dark:bg-slate-800 border dark:border-slate-700 dark:border-slate-200 p-4 min-h-[80px] text-sm overflow-x-auto w-full">
          <!-- AJAX results will be injected here (use response.meta as in previous logic) -->
        </div>
      </div>
    </div>
  </div>
</div>

<!-- jQuery (kept) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  (function () {

    // Queries dropdown toggle
    const queriesBtn = document.getElementById('queries-btn');
    const queriesMenu = document.getElementById('queries-menu');
    queriesBtn.addEventListener('click', () => queriesMenu.classList.toggle('hidden'));
    document.addEventListener('click', (e) => {
      if (!queriesBtn.contains(e.target) && !queriesMenu.contains(e.target)) {
        queriesMenu.classList.add('hidden');
      }
    });

    // Insert token/snippet into textarea
    const sqlField = document.getElementById('sql-field');
    $(document).on('click', '.token-btn', function () {
      const val = $(this).data('val') || $(this).text();
      sqlField.value += ' ' + val;
      sqlField.focus();
    });
    $(document).on('click', '.snippet-btn', function () {
      const val = $(this).data('val') || $(this).text();
      sqlField.value += (sqlField.value ? ' ' : '') + val;
      sqlField.focus();
    });

    // Clear button
    document.getElementById('clear-all').addEventListener('click', () => sqlField.value = '');

    // Execute (Ignate) - uses jQuery ajax to your existing endpoint
    document.getElementById('execute-sql').addEventListener('click', () => {
      let field = sqlField.value.trim();
      if (!field) {
        my_message("Enter something", 'danger', 3);
        return;
      }
      $.ajax({
        type: "POST",
        url: '<?= $path ?? "" ?>app/system/api/query-runner.php',
        data: { sql: field },
        dataType: 'json',
        success: function (response) {
        	$('#result-box').html('');
        	var messages = '';
        	var contentx = '';
        	response.forEach((r)=>{
		        if (r.meta) {
		            // render the returned HTML into the result box
		            contentx+=r.meta;
		          } else {
		          	var typ = r.type == 'danger'?'bg-red-500':'bg-green-500';
		          	messages += `<div  class="px-4 py-2 rounded-md text-sm my-3 ${typ}">${r.message}</div>`;
		          }
        	});
          $('#result-box').html(contentx);
          $('body').append(`<div id="mgs0" class="fixed right-6 top-6 z-50 px-4 py-2 rounded-md text-sm my-3" >${messages}</div>`);
	      // alert("JSON.stringify(response)");
        },
        error: function (err, err_type, err_message) {
        	// alert(JSON.stringify(err));
            my_message(`${err_type} and ${err_message}`, 5);
        }
      });
    });
    $(document).ready(function () {
    	    setTimeout( function () {$('#msg0').html('');},3000);

    });
    // Table chip click -> show associated presets (we generated a tb-ql-data per table)
    $(document).on('click', '.table-chip', function () {
      const rnd = $(this).data('rnd');
      // hide all, then show the specific one (or toggle)
      $('.tb-ql-data').slideUp('fast');
      $(`.tb-ql-data[data-rnd]`).filter(function () {
        // this filter is needed because we didn't set data-rnd on button per table mapping in PHP above
        // find the one where select-presets contains table name
        return $(this).text().includes($(this).closest('div').text());
      });
      // simpler approach: show the next (we rely on PHP to produce matching order)
      // Instead: toggle nearest .tb-ql-data (based on index)
      // We'll try to find the nth tb-ql-data matching button index:
      const idx = $('.table-chip').index(this);
      const item = $('.tb-ql-data').eq(idx);
      if (item.is(':visible')) item.slideUp('fast'); else item.slideDown('fast');
    });

    // When a preset select is chosen, replace entire SQL
    $(document).on('change', '.select-presets', function () {
      const v = $(this).val();
      $('#sql-field').val(v);
    });

    // Right column: clicking table name double-click inserts
    $(document).on('dblclick', '.table-name', function () {
      const name = $(this).data('name') || $(this).text();
      sqlField.value += (sqlField.value ? ' ' : '') + name;
      sqlField.focus();
    });

    // Column select: when a column is chosen, append to sql field
    $(document).on('change', '.col-select', function () {
      const val = $(this).val();
      sqlField.value += ' ' + val + ' ';
      sqlField.focus();
      // reset select to default
      $(this).prop('selectedIndex', 0);
    });

    // tbs-and-reset equivalent: When the hidden .tb-ql-data select changes we already set entire SQL
    // Also allow double-click on column inside any list (if you want)
    $(document).on('dblclick', 'option', function (e) {
      // prevent weird behavior; only handle when option is inside .tbs
      const parent = $(this).closest('.tbs');
      if (parent.length) {
        $('#sql-field').val($(this).val());
      }
    });

    // Utility: my_message fallback (you had this in original; provide minimal if not defined)
    window.my_message = window.my_message || function (msg, type, t) {
      // minimal toast using console and an ephemeral alert
      console[type === 'danger' ? 'error' : 'log'](msg);
      const el = $('<div class="fixed msg-item right-6 top-6 z-50 px-4 py-2 rounded-md text-sm"></div>');
      el.addClass(type === 'danger' ? 'bg-red-600 text-gray-900 text-white' : 'dark:bg-slate-700 bg-slate-200 text-gray-900 dark:text-white');
      el.text(msg);
      $('body').append(el);
      setTimeout(() => el.fadeOut(400, () => el.remove()), (t || 3) * 1000);
    };
    
    // Safety: clicking outside close queries menu
    document.addEventListener('keydown', (e) => {
      if (e.key === "Escape") {
        queriesMenu.classList.add('hidden');
        $('.tb-ql-data').slideUp('fast');
      }
    });

  

// Hide or remove messages when clicking anywhere, pressing ESC, or clicking message itself
document.addEventListener('click', (e) => {
  // remove only message divs, not the container
  if (!$(e.target).closest('#mgs0').length) {
    $('#mgs0').find('div').remove();
  }
});

// pressing Escape also clears messages
document.addEventListener('keydown', (e) => {
  if (e.key === "Escape") {
    $('#mgs0').find('div').remove();
  }
});

// clicking the message itself clears it
$(document).on('click', '#mgs0 div', function () {
  $(this).remove();
});



  })();
</script>
</section>

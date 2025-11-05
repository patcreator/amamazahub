    //  $(document).ready(function() {

    //   // TAB HANDLING
    //   function activateTab(tabName, updateHash) {
    //     if (!tabName) tabName = 'tables';
    //     tabName = String(tabName).toLowerCase();

    //     // find matching tab button, fallback to tables if not found
    //     var $targetBtn = $('.tabBtn[data-tab="' + tabName + '"]');
    //     if ($targetBtn.length === 0) {
    //       tabName = 'tables';
    //       $targetBtn = $('.tabBtn[data-tab="' + tabName + '"]');
    //     }

    //     // button active styling
    //     $('.tabBtn').removeClass('bg-blue-500 text-white');
    //     $targetBtn.addClass('bg-blue-500 text-white');

    //     // show/hide content panes
    //     $('[id^="tab-"]').addClass('hidden');
    //     $('#tab-' + tabName).removeClass('hidden');

    //     // initialize table lazily when showing tables
    //     if (tabName === 'tables') {
    //       // small timeout to ensure visible before DataTables measures widths
    //       setTimeout(initUsersTable, 50);
    //     }

    //     // update location.hash if requested (clicks set it)
    //     if (updateHash) {
    //       // set hash without adding duplicate entries when same
    //       if (location.hash.replace('#', '') !== tabName) {
    //         location.hash = tabName;
    //       }
    //     }
    //   }

    //   // click handler for tabs
    //   $('.tabBtn').on('click', function(e) {
    //     e.preventDefault();
    //     var tab = $(this).data('tab');
    //     activateTab(tab, true); // update hash
    //   });

    //   // respond to back/forward or manual hash changes
    //   $(window).on('hashchange', function() {
    //     var h = location.hash ? location.hash.replace('#', '') : '';
    //     activateTab(h, false);
    //   });

    //   // on page load, activate based on hash (or default to tables)
    //   var initialHash = location.hash ? location.hash.replace('#', '') : 'tables';
    //   activateTab(initialHash, false);

    //   // Bulk action apply (simple client-side demo; hook to server as needed)
    //   $('#applyBulkAction').on('click', function() {
    //     var action = $('#bulkActions').val();
    //     var ids = $('.rowCheckbox:checked').map(function() { return $(this).data('id'); }).get();
    //     if (!action) {
    //       alert('Please select a bulk action.');
    //       return;
    //     }
    //     if (ids.length === 0) {
    //       alert('Please select at least one row.');
    //       return;
    //     }
    //     // TODO: perform the chosen action via AJAX (edit/copy/delete/export)
    //     alert('Bulk action: ' + action + '\nIDs: ' + ids.join(', '));
    //   });

    //   // Add User modal toggle
    //   $('#addUserBtn').on('click', function(){ $('#addUserModal').removeClass('hidden'); });
    //   $('#closeAddUserModal').on('click', function(){ $('#addUserModal').addClass('hidden'); });
    //   $('#addUserForm').on('submit', function(e){
    //     e.preventDefault();
    //     // TODO: submit form via AJAX, then refresh table or insert row
    //     alert('Add user: ' + $(this).find('input[name="username"]').val());
    //     $('#addUserModal').addClass('hidden');
    //   });

    //   // select all checkbox
    //   $('#selectAll').on('change', function() {
    //     $('.rowCheckbox').prop('checked', $(this).prop('checked'));
    //   });
    // });
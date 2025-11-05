
<div>


    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white dark:bg-gray-800 dark:text-gray-300 rounded-lg shadow-md overflow-hidden">
            <!-- Search and Filters -->
<div class="p-6 flex items-center  space-x-2  mb-4 border-b">
    <i class="fa fa-history text-red-600 text-xl"></i>
    <h2 class="text-xl font-semibold text-red-500 dark:text-gray-100">Dashboard Action Log</h2>
</div>

            <!-- History Table -->
              <div class="overflow-x-auto px-6 pb-5">
                <table id="historyTable" class="min-w-full divide-y divide-gray-200 ">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium dark:bg-gray-700 dark:text-gray-200 text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium dark:bg-gray-700 dark:text-gray-200 text-gray-500 uppercase tracking-wider">User  ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium dark:bg-gray-700 dark:text-gray-200 text-gray-500 uppercase tracking-wider">Action</th>
                            <th class="px-6 py-3 text-left text-xs font-medium dark:bg-gray-700 dark:text-gray-200 text-gray-500 uppercase tracking-wider">Entity Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium dark:bg-gray-700 dark:text-gray-200 text-gray-500 uppercase tracking-wider">Entity ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium dark:bg-gray-700 dark:text-gray-200 text-gray-500 uppercase tracking-wider">Old Value</th>
                            <th class="px-6 py-3 text-left text-xs font-medium dark:bg-gray-700 dark:text-gray-200 text-gray-500 uppercase tracking-wider">New Value</th>
                            <th class="px-6 py-3 text-left text-xs font-medium dark:bg-gray-700 dark:text-gray-200 text-gray-500 uppercase tracking-wider">IP Address</th>
                            <th class="px-6 py-3 text-left text-xs font-medium dark:bg-gray-700 dark:text-gray-200 text-gray-500 uppercase tracking-wider">User  Agent</th>
                            <th class="px-6 py-3 text-left text-xs font-medium dark:bg-gray-700 dark:text-gray-200 text-gray-500 uppercase tracking-wider">Created At</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 dark:text-gray-300 divide-y divide-gray-200">
                        <!-- DataTables will populate rows dynamically -->
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>
<script>
$(document).ready(function() {
    $('#historyTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "/PDT-NEW/projects/pdo/app/system/api/history_data.php",
        order: [[9, "desc"]],
        lengthMenu: [[5,10,25,50],[5,10,25,50]],
        dom: '<"table-controls"<"length-select"l><"dt-buttons"B>f>tip',
        buttons: [
    {
        extend: 'copyHtml5',
        text: '<i class="fa fa-copy"></i> Copy'
    },
    {
        extend: 'csvHtml5',
        text: '<i class="mdi mdi-file-delimited"></i> CSV'
    },
    {
        extend: 'excelHtml5',
        text: '<i class="uil uil-file-excel-alt"></i> Excel'
    },
    {
        extend: 'pdfHtml5',
        text: '<i class="dripicons-document"></i> PDF'
    },
    {
        extend: 'print',
        text: '<i class="fa fa-print"></i> Print'
    }
]
,
        columnDefs: [
            { orderable: false, targets: [5,6,8] },
            {
                targets: 2,
                render: function(data,type,row){
                    let colors = {'Create':'blue','Update':'green','Delete':'red'};
                    let color = colors[data] || 'gray';
                    return `<span class="action-badge ${color}">${data}</span>`;
                }
            }
        ],
        scrollX: true
    });
});

// Map each column header text to an icon (choose Font Awesome, MDI, Uil, or Dripicons)
const headerIcons = {
    "ID": '<i class="fa fa-hashtag"></i>',
    "User ID": '<i class="fa fa-user"></i>',
    "Action": '<i class="fa fa-cogs"></i>',
    "Entity Type": '<i class="fa fa-layer-group"></i>',
    "Entity ID": '<i class="fa fa-key"></i>',
    "Old Value": '<i class="fa fa-arrow-left"></i>',
    "New Value": '<i class="fa fa-arrow-right"></i>',
    "IP Address": '<i class="fa fa-network-wired"></i>',
    "User Agent": '<i class="fa fa-desktop"></i>',
    "Created At": '<i class="fa fa-calendar-alt"></i>'
};

// Loop through all <th> elements and prepend the corresponding icon
$('#historyTable thead th').each(function() {
    const colText = $(this).text().trim();
    if(headerIcons[colText]) {
        $(this).html(headerIcons[colText] + ' ' + colText);
    }
});


</script>
<style>
    #historyTable th,td {
    white-space: nowrap;  /* Prevents text from wrapping */
    overflow: hidden;     /* Optional: hide overflow if too long */
    text-overflow: ellipsis; /* Optional: show "..." for overflow */
}

    /* Container for length select + buttons */
.table-controls {
    display: flex !important;
    flex-wrap: wrap !important;
    justify-content: space-between !important;
    align-items: center !important;
    margin-bottom: 1rem !important;
    gap: 0.5rem !important;
}

/* Length select styling */
.table-controls .length-select select {
    padding: 0.3rem 0.5rem !important;
    border-radius: 0.35rem !important;
    border: 1px solid #d1d5db !important; /* gray-300 */
    background-color: #fff !important;
    min-width: 70px !important;
}

/* Buttons styling */
.dt-buttons button {
    padding: 0.35rem 0.75rem !important;
    border-radius: 0.35rem !important;
    border: none !important;
    color: #fff !important;
    font-weight: 500 !important;
    cursor: pointer !important;
    margin-right: 0.3rem !important;
    margin-bottom: 0.3rem !important;
    transition: background-color 0.2s !important;
}

/* Individual button colors */
.dt-buttons .buttons-copy { background-color: #3b82f6 !important; }
.dt-buttons .buttons-copy:hover { background-color: #2563eb !important; }

.dt-buttons .buttons-csv { background-color: #10b981 !important; }
.dt-buttons .buttons-csv:hover { background-color: #059669 !important; }

.dt-buttons .buttons-excel { background-color: #14b8a6 !important; }
.dt-buttons .buttons-excel:hover { background-color: #0f766e !important; }

.dt-buttons .buttons-pdf { background-color: #ef4444 !important; }
.dt-buttons .buttons-pdf:hover { background-color: #b91c1c !important; }

.dt-buttons .buttons-print { background-color: #6b7280 !important; }
.dt-buttons .buttons-print:hover { background-color: #4b5563 !important; }

/* Action badges */
.action-badge {
    display: inline-block !important;
    padding: 0.15rem 0.5rem !important;
    font-size: 0.75rem !important;
    font-weight: 600 !important;
    border-radius: 0.35rem !important;
    color: #fff !important;
}

.action-badge.blue { background-color: #3b82f6 !important; }
.action-badge.green { background-color: #10b981 !important; }
.action-badge.red { background-color: #ef4444 !important; }
.action-badge.gray { background-color: #6b7280 !important; }

/* Optional: Table horizontal scroll padding */
.dataTables_wrapper .dataTables_scroll {
    overflow-x: auto !important;
}
/* Style the DataTables search input */
.dataTables_filter input {
    padding: 0.4rem 0.6rem;           /* Spacing */
    border-radius: 0.35rem;           /* Rounded corners */
    border: 1px solid #d1d5db;        /* Gray border */
    background-color: #f9fafb;         /* Light background */
    font-size: 0.875rem;               /* Tailwind text-sm */
    color: #111827;                    /* Dark text */
    outline: none;                     /* Remove default outline */
    transition: border-color 0.2s, box-shadow 0.2s;
}

.dataTables_filter input:focus {
    border-color: #fb8236 !important;             /* Tailwind blue-500 */
    box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2) !important;
    background-color: #fff !important;
}



/* Pagination buttons */
.dataTables_wrapper .dataTables_paginate .paginate_button {
    padding: 0.35rem 0.75rem !important;
    border-radius: 0.375rem !important; /* rounded-md */
    border: none !important;
    margin: 0 0.2rem !important;
    font-weight: 500 !important;
    cursor: pointer !important;
    background-color: #ef4444 !important; /* Tailwind red-500 */
    color: #fff !important;
    transition: background-color 0.2s, color 0.2s !important;
}

/* Hover */
.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    background-color: #dc2626 !important; /* Tailwind red-600 */
    color: #fff !important;
}

/* Active page */
.dataTables_wrapper .dataTables_paginate .paginate_button.current {
    background-color: #dc2626 !important; /* Tailwind red-600 */
    color: #fff !important;
}

/* Disabled button */
.dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
    background-color: #fff !important; /* Tailwind gray-400 */
    color: #9ca3af !important;
    cursor: not-allowed !important;
}



/* Dark table background */
body.dark #historyTable {
    background-color: #1f2937 !important; /* gray-800 */
    color: #f9fafb !important;            /* text-white */
}

/* Dark headers */
body.dark #historyTable thead {
    background-color: #374151 !important; /* gray-700 */
    color: #f9fafb !important;
}

/* Dark row hover */
body.dark #historyTable tbody tr:hover {
    background-color: #4b5563 !important; /* gray-600 */
}

/* Buttons for dark mode */
body.dark .dt-buttons button,
body.dark .dataTables_wrapper .dataTables_paginate .paginate_button {
    background-color: #2563eb !important;
    color: #f9fafb !important;
}

body.dark .dt-buttons button:hover,
body.dark .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    background-color: #3b82f6 !important;
    color: #fff !important;
}

/* Search input dark mode */
body.dark .dataTables_filter input {
    background-color: #374151 !important;
    color: #f9fafb !important;
    border: 1px solid #4b5563 !important;
}

body.dark .dataTables_filter input:focus {
    border-color: #3b82f6 !important;
    box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
}


</style>
(function ($) {
    "use strict";
    var tableBootstrap4Style = {
        initialize: function () {
            this.bootstrap4Styling();
            this.bootstrap4Modal();
            this.print();
        },
        bootstrap4Styling: function () {
            $('.bootstrap4-styling').DataTable();
        },
        bootstrap4Modal: function () {
            $('.bootstrap4-modal').DataTable({
                responsive: {
                    details: {
                        display: $.fn.dataTable.Responsive.display.modal({
                            header: function (row) {
                                var data = row.data();
                                return 'Details for ' + data[0] + ' ' + data[1];
                            }
                        }),
                        renderer: $.fn.dataTable.Responsive.renderer.tableAll({
                            tableClass: 'table'
                        })
                    }
                }
            });
        },
    
   
  
        print: function () {
            var table = $('#example').DataTable({
                lengthChange: false,
                 paging:false,
                 dom: "<'row'<'col-sm-4'B><'col-sm-4'l><'col-sm-4'f>>tp", 
                buttons: [
                    {
                        extend: 'copy',
                        text: '<i class="far fa-copy"></i>',
                        titleAttr: 'Copy',
                        className: 'btn-success'
                    },
                    {
                        extend: 'csv',
                        text: '<i class="fas fa-file-csv"></i>',
                        titleAttr: 'CSV',
                        className: 'btn-success'
                    },
                    {
                        extend: 'excel',
                         text: '<i class="far fa-file-excel"></i>',
                        titleAttr: 'Excel',
                        className: 'btn-success'
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="far fa-file-pdf"></i>',
                        titleAttr: 'PDF',
                        className: 'btn-success'
                    },
                    {
                        extend: 'print',
                          text: '<i class="fa fa-print" aria-hidden="true"></i>',
                        titleAttr: 'Print',
                        className: 'btn-success'
                    }
                    
                ]

            });

            table.buttons().container()
                    .appendTo('#example_wrapper .col-md-6:eq(0)');
        }
        

    };
    // Initialize
    $(document).ready(function () {
        "use strict"; 
        tableBootstrap4Style.initialize();
    });

}(jQuery));
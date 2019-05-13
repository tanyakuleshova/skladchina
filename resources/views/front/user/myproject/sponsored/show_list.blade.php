{{-- на входе проект $project --}}
@extends('layouts.app')
@section('content')
<div class="wrapper">
    <div class="container">
        <div class="list-update"> 
            <div class="row">
                <div class="ibox-title">
                    <h2 class="caption">Список спонсоров проекта "{{ $project->name}}"</h2>
                </div>

                <div class="ibox-content">
                    @if($project->orders)
                    <table class="table table-striped" id="js_block_orders_project">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Пользователь</th>
                                <th>Email</th>
                                <th>Сумма</th>
                                <th>Подарок?</th>
                                <th>Дата создания</th>
                                <th>Дата обновления</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th colspan="3" style="text-align:right">Сумма:</th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                    @else
                    <h3>У Вас нет сопнсоров проекта</h3>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>  
@endsection
@section('script')
    <script src="{{asset('administrator/js/plugins/dataTables/datatables.min.js')}}"></script>
    <script>
        /* Formatting function for row details - modify as you need */
        function format ( d ) {
            // `d` is the original data object for the row
            

            return d.child;
//            return '<table cellpadding="3" cellspacing="0" border="0" style="padding-left:50px;">'+
//                '<tr>'+
//                    '<td>Full name:</td>'+
//                    '<td></td>'+
//                '</tr>'+
//                '<tr>'+
//                    '<td>Extension number:</td>'+
//                    '<td>5</td>'+
//                '</tr>'+
//                '<tr>'+
//                    '<td>Extra info:</td>'+
//                    '<td>And any further details here (images etc)...</td>'+
//                '</tr>'+
//            '</table>';
        }  
        
    $(document).ready(function() {
        var table = $('#js_block_orders_project').DataTable( {
            "ajax": {
                "url": "{{ route('getAjaxOrders',$project->id)}}",
                "type": "POST"
                },
            "columns": [
                {
                    "className":      'details-control',
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ''
                },
                { "data": "name" },
                { "data": "email" },
                { "data": "summa" },
                { "data": "gift" },
                { "data": "created" },
                { "data": "updated" }
            ],
            "order": [[1, 'asc']],
            "footerCallback": function ( row, data, start, end, display ) {
                        var api = this.api(), data;

                        // Remove the formatting to get integer data for summation
//                        var intVal = function ( i ) {
//                            return typeof i === 'string' ?
//                                i.replace(/[\$,]/g, '')*1 :
//                                typeof i === 'number' ?
//                                    i : 0;
//                        };

                        // Total over all pages
//                        total = api
//                            .column( 3 )
//                            .data()
//                            .reduce( function (a, b) {
//                                return intVal(a) + intVal(b);
//                            }, 0 );

                        // Total over this page
                        pageTotal = api
                            .column( 3, { page: 'current'} )
                            .data()
                            .reduce( function (a, b) {
                                return a + b;
                            }, 0 );

                        // Update footer
                        $( api.column( 3 ).footer() ).html(
                            pageTotal+ 'грн.'
                        );
                    }
        } );

        // Add event listener for opening and closing details
        $('#js_block_orders_project tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row( tr );

            if ( row.child.isShown() ) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            }
            else {
                // Open this row
                row.child( format(row.data()) ).show();
                tr.addClass('shown');
            }
        } );
    } );

        function checkSendGift(e) {
            if (confirm('Вы уверены ?')) {
                var v = $(e).val();
                if (v === undefined || v == '') { return;}
                v = parseInt(v);
                var uurl = "{{route('sendGiftToUser',[$project->id])}}/" + v
                $.ajax({
                    type: "POST",
                    url: uurl,
                    dataType: 'json',
                    success: function (msg) {
                        console.log('msg => ',msg);
                        if (msg.error !== undefined) {
                            swal('',msg.error, "error");
                        }
                        if (msg.success !== undefined) {
                            $(e).parent('td').html(msg.success);
                        }
                    }
                });
               
            } 
        }
    </script>
@endsection

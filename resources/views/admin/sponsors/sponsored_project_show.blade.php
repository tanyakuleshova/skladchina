@extends('admin.layouts.admin-app')
@section('admin_content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Список спонсоров, проекта  "{{ $project->name }}"</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table id="sponsored-table" class="table table-bordered">
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
                            </table>
                        </div>
                        <a href="{{ route('sponsored_statistics.index') }}" class="btn btn-info">Назад, к списку спонсированных проектов.</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('admin_script')
    <script src="{{asset('administrator/js/plugins/dataTables/datatables.min.js')}}"></script>
    <script>
    $(document).ready(function() {
        var table = $('#sponsored-table').DataTable( {
            "ajax": {
                "url": "{{ route('sponsored_statistics.edit',$project->id)}}",
                "type": "GET"
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
        } );

        // Add event listener for opening and closing details
        $('#sponsored-table').on('click', 'td.details-control', function () {
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
    </script>
@endsection
@extends('layouts.app')

@section('content')
<div class="container">




    <!-- number of user card -->
    <div class="row" >
        <div class="col-sm-3">
            <div class="card">
                <div class="card-header">{{ __('No. of Personel') }}</div>

                <div class="card-body">
                    <h1>{{$Personel - 1}} <span style="font-size:20px;">Users</span> </h1>
                </div>
            </div>
        </div>
   

    <!-- total card -->
    <div class="col-sm-3">
            <div class="card">
                <div class="card-header">{{ __('Total Asset') }}</div>

                <div class="card-body">
                  
                    <h1>{{$Asset}} <span style="font-size:20px;">Item</span> </h1>
                 
                </div>
            </div>
        </div>


    <!-- Available card -->
        <div class="col-sm-3">
            <div class="card">
                <div class="card-header">{{ __('Available') }}</div>

                <div class="card-body">
                  
                    <h1>{{$Available}} <span style="font-size:20px;">Item</span> </h1>
                 
                </div>
            </div>
        </div>

    <!-- Used card -->
        <div class="col-sm-3">
            <div class="card">
                <div class="card-header">{{ __('Used') }}</div>

                <div class="card-body">
                  
                    <h1>{{$Deployed}} <span style="font-size:20px;">Item</span> </h1>
                 

                </div>
            </div>
        </div>
    </div>

<!-- table of data -->

            <div  class="hovertext-history" >
                    <h1 >
                        Items 
                    </h1>
                        <div >
                                <button >  
                                    download
                                </button>
                        </div>
                    
                     <br>
                     <div class="filtration" style="float:right;">
                    
                            Department:
                                <select class="dept" name="dept" id="dept">
                                        @foreach($depts as $d)
                                            <option value="{{$d->dept_name}}">{{$d->dept_name}}</option>
                                        @endforeach
                                </select>
                            Brand:
                            <input class="brand" type="text" id="brand" name="brand" hidden>

                            Type:
                            <select class="Type" name="Type" id="Type">
                                <option value=""></option>
                                <option value="Cellphone">Cellphone</option>
                                <option value="Desktop">Desktop</option>
                                <option value="Laptop">Laptop</option>
                            </select>

                            Availability:
                            <select class="Availability" name="Availability" id="Availability">
                                <option value=""></option>
                                <option value="Deployed">Deployed</option>
                                <option value="Available">Available</option>
                                <option value="Not Available">Not Available</option>
                            </select>

                            <button onclick="reload_table()" class="filterbutton">Filter</button>   
                    </div>
                    <br>
                    <br>
                    <hr >
                <table class="table" id="datatable" data-order='[[ 0, "asc" ]]'>
             
                    <tbody id="history-body">
                       
                    </tbody>
            
            </table>
          
            <!-- list previous of users modal -->
                                <div class="modal fade"  id="myModal"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-xl" >
                                                <div class="modal-content" >
                                                    <div class="modal-header">
                                                        <h3 class="modal-title" id="myModalLabel">List of Previous User</h3>
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" >
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                            
                                                    <div class="modal-body" >
                                                        <table class="table">
                                                            <thead>
                                                                <th>Name</th>
                                                                <th>Date Issued</th>
                                                            </thead>
                                                            <tbody  id="tr" >
                                                             
                                                            </tbody>
                                                            
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer" >
                                                        <button class="btn btn-outline-primary">Assign new user</button>
                                                    </div>
                                            </div>
                                        </div>

</div>
@endsection
 <!-- bootstrap -->
    
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


    <!-- data table -->


    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/fixedheader/3.2.3/js/dataTables.fixedHeader.min.js"></script>

   
    <script>
        $(function() {
            var width = $(window).width();
            var drawer_count = 1;
            var data = [];
           

            $('#datatable').DataTable({
                 

                "oLanguage": {
                    "sProcessing": '<span>Please wait ...</span>'
                },
                "pagingType": "simple_numbers",
                "paging": true,
                "lengthMenu": [
                    [10, 25, 50],
                    [10, 25, 50]
                ],
                "processing": true,
                "serverSide": true,
                "ordering": false,
                "ajax": {
                        "type": "GET",
                        "url": "{{ url('data') }}",
                        "data": function(result) {
                            result.brand = document.getElementById('brand').value;
                            result.Type = document.getElementById('Type').value;
                            result.Availability = document.getElementById('Availability').value;
                            result.dept = document.getElementById('dept').value;
                            
                        },
                        "dataFilter": function(data) {
                            drawer_count++;
                            var json = jQuery.parseJSON(data);
                            json.draw = json.draw;
                            json.recordsTotal = json.total;
                            json.recordsFiltered = json.total;
                            json.data = json.data;

                           
                            $('#list_table_processing').css('display', 'none');
                            return JSON.stringify(json); // return JSON string
                        }
                    },
                    scrollX: true,
                    order: [[ 3, 'desc' ], [ 0, 'asc' ]],
                    "columns": [
                        { "title": '#',                 "data": "#",                "width": "2%",       "name": "asset_code",           "bSortable": true,      "visible": true, "searchable": true },
                        { "title": 'Current User',         "data": "name",             "width": "10%",      "name": "name",                 "bSortable": true,      "visible": true, "searchable": true },
                        { "title": 'Department',        "data": "dept_name",        "width": "10%",      "name": "dept_name",            "bSortable": true,      "visible": true, "searchable": true  },
                        { "title": 'Item',              "data": "description",      "width": "10%",      "name": "description",          "bSortable": true,      "visible": true, "searchable": true ,
                            "mRender": function(data, type, full) {
                                return  '<a href="#"  onclick="showItem(' + full.item_id  + ', ' + full.personel_id + ')" data-toggle="modal" data-target="#myModal"> <p style="color:black;">' + data + '</p> </a>';
                            }
                        },
                        { "title": 'Asset Code',        "data": "asset_code",       "width": "10%",      "name": "asset_code",           "bSortable": true,      "visible": true, "searchable": true },
                        { "title": 'Serial no.',        "data": "serial_num",       "width": "10%",      "name": "serial_num",           "bSortable": true,      "visible": true, "searchable": true },
                        { "title": 'Mac address',       "data": "mac_address",      "width": "10%",      "name": "mac_address",          "bSortable": true,      "visible": true, "searchable": true },
                        { "title": 'Brand',             "data": "brand",            "width": "10%",      "name": "brand",                "bSortable": true,      "visible": true, "searchable": true },
                        { "title": 'Type',              "data": "asset_type",       "width": "10%",      "name": "asset_type",           "bSortable": true,      "visible": true, "searchable": true },
                        { "title": 'Availability',      "data": "availability",      "width": "10%",     "name": "availability",         "bSortable": true,      "visible": true, "searchable": true },
                        { "title": 'Date Last Issued',       "data": "updated_at",       "width": "10%",      "name": "updated_at",              "bSortable": true,      "visible": true, "searchable": true },
                    ],
            });


            
            $('#history-body').html()
        });


        function reload_table() {
          
            $('#datatable').DataTable().ajax.reload();
        }

        function showItem(item_id,personel_id) {
            console.log(item_id);
            // console.log(personel_id);

            const personels = {!! json_encode($personels) !!};
            const his_tokens = {!! json_encode($his_tokens) !!};
            var tr_data = '';
            his_tokens.forEach((token) => {
                
                if(token['item_id'] == item_id)
                {
                    console.log(token['name']);
                    tr_data += '<tr><td>' + token['name'] + '</td>' +
                               '<td>' + token['created_at'] + '</td></tr>' ;
                }

                $('#tr').html(tr_data);
           });
        }
    </script>
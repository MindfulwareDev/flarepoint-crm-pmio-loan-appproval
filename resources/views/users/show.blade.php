@extends('layouts.master')
    @section('content')
    @include('partials.userheader')
<div class="col-sm-8">
  <el-tabs active-name="tasks" style="width:100%">
    <el-tab-pane label="Loans" name="tasks">
        <table class="table table-hover" id="tasks-table">
        <h3>{{ __('Loans assigned') }}</h3>
            <thead>
                    <th>{{ __('Title') }}</th>
                    <th>{{ __('Client') }}</th>
                    <th>{{ __('Created at') }}</th>
                    <th>{{ __('Deadline') }}</th>
                    <th>{{ __('Amount') }}</th>
                    <th>
                        <select name="status" id="status-task">
                        <option value="" disabled selected>{{ __('Status') }}</option>
                            <option value="open">Open</option>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                            <option value="closed">Closed</option>
                            <option value="error">Api request error</option>
                            <option value="all">All</option>
                        </select>
                    </th>
                </tr>
            </thead>
        </table>
    </el-tab-pane>
    {{--<el-tab-pane label="Leads" name="leads">
      <table class="table table-hover">
        <table class="table table-hover" id="leads-table">
                <h3>{{ __('Leads assigned') }}</h3>
                <thead>
                <tr>
                    <th>{{ __('Title') }}</th>
                    <th>{{ __('Client') }}</th>
                    <th>{{ __('Created at') }}</th>
                    <th>{{ __('Deadline') }}</th>
                    <th>
                        <select name="status" id="status-lead">
                        <option value="" disabled selected>{{ __('Status') }}</option>
                            <option value="open">Open</option>
                            <option value="closed">Closed</option>
                            <option value="all">All</option>
                        </select>
                    </th>
                </tr>
                </thead>
            </table>
    </el-tab-pane>--}}
    <el-tab-pane label="Clients" name="clients">
         <table class="table table-hover" id="clients-table">
                <h3>{{ __('Clients assigned') }}</h3>
                <thead>
                <tr>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Company') }}</th>
                    <th>{{ __('Primary number') }}</th>
                </tr>
                </thead>
            </table>
    </el-tab-pane>
  </el-tabs>
  </div>
  <div class="col-sm-4">
  <h4>{{ __('Loans') }}</h4>
<doughnut :statistics="{{$task_statistics}}"></doughnut>
{{--<h4>{{ __('Leads') }}</h4>
<doughnut :statistics="{{$lead_statistics}}"></doughnut>--}}
  </div>

   @stop 
@push('scripts')
        <script>
        $('#pagination a').on('click', function (e) {
            e.preventDefault();
            var url = $('#search').attr('action') + '?page=' + page;
            $.post(url, $('#search').serialize(), function (data) {
                $('#posts').html(data);
            });
        });

            $(function () {
              var table = $('#tasks-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{!! route('users.taskdata', ['id' => $user->id]) !!}',
                    columns: [

                        {data: 'titlelink', name: 'title'},
                        {data: 'client_id', name: 'Client', orderable: false, searchable: false},
                        {data: 'created_at', name: 'created_at'},
                        {data: 'deadline', name: 'deadline'},
                        {data: 'amount', name: 'amount'},
                        {data: 'status', name: 'status', orderable: false},
                    ]
                });

                $('#status-task').change(function() {
                selected = $("#status-task option:selected").val();
                    if(selected == 'open') {
                        table.columns(5).search(1).draw();
                    } else if(selected == 'closed') {
                        table.columns(5).search(2).draw();
                    } else if(selected == 'approved') {
                        table.columns(5).search(3).draw();
                    } else if(selected == 'rejected') {
                        table.columns(5).search(4).draw();
                    } else if(selected == 'error') {
                        table.columns(5).search(5).draw();
                    }
                    else {
                         table.columns(4).search( '' ).draw();
                    }
              });  

          });
            $(function () {
                $('#clients-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{!! route('users.clientdata', ['id' => $user->id]) !!}',
                    columns: [

                        {data: 'clientlink', name: 'name'},
                        {data: 'company_name', name: 'company_name'},
                        {data: 'primary_number', name: 'primary_number'},

                    ]
                });
            });

            $(function () {
              var table = $('#leads-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{!! route('users.leaddata', ['id' => $user->id]) !!}',
                    columns: [

                        {data: 'titlelink', name: 'title'},
                        {data: 'client_id', name: 'Client', orderable: false, searchable: false},
                        {data: 'created_at', name: 'created_at'},
                        {data: 'contact_date', name: 'contact_date'},
                        {data: 'status', name: 'status', orderable: false},
                    ]
                });

              $('#status-lead').change(function() {
                selected = $("#status-lead option:selected").val();
                    if(selected == 'open') {
                        table.columns(4).search(1).draw();
                    } else if(selected == 'closed') {
                        table.columns(4).search(2).draw();
                    } else {
                         table.columns(4).search( '' ).draw();
                    }
              });  
          });
        </script>
@endpush



@extends('admin.layouts.app')
@section('title', 'ကားများ | ရွှေရုပ်လေး ကားလိုင်း')
@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">ကားများ</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">ပင်မစာမျက်နှာ</a></li>
                        <li class="breadcrumb-item active">ကားများ</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">ကားများ</h3>
                    <div class="card-toolbar float-end">
                        <a href="{{route('admin.cars.create')}}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i>ကားအချက်အလက်များသွင်းမည်</a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="carTable">
                        <thead>
                            <tr>
                                <th>စဉ်</th>
                                <th>ကားနံပါတ်</th>
                                <th>ထွက်မည့်နေ့စွဲ</th>
                                <th>ခရီးစဉ်</th>
                                <th>ကားမောင်းသူအမည်</th>
                                <th>ကားမောင်းသူဖုန်းနံပါတ်</th>
                                <th>အကူကားမောင်းသူအမည်</th>
                                <th>အကူကားမောင်းသူဖုန်းနံပါတ်</th>
                                <th>စပယ်ယာအမည်</th>
                                <th>စပယ်ယာဖုန်းနံပါတ်</th>
                                <th>အဖွဲ့ဝင်အမည်</th>
                                <th>အဖွဲ့ဝင်ဖုန်းနံပါတ်</th>
                                <th>လုပ်ဆောင်ချက်</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('#carTable').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                scrollX: true,
                scrollCollapse: true,
                paging: true,
                fixedHeader: true,
                columnDefs: [{
                    targets: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
                    width: '150px',
                }],
                ajax: {
                    url: "{{ route('cars.getList') }}",
                    type: 'GET',
                    dataType: 'json',
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'number',
                        name: 'number'
                    },
                    {
                        data: 'departure_date',
                        name: 'departure_date'
                    },
                    {
                        data: 'route',
                        name: 'route'
                    },
                    {
                        data: 'driver_name',
                        name: 'driver_name'
                    },
                    {
                        data: 'driver_phone_number',
                        name: 'driver_phone_number'
                    },
                    {
                        data: 'assistant_driver_name',
                        name: 'assistant_driver_name'
                    },
                    {
                        data: 'assistant_driver_phone',
                        name: 'assistant_driver_phone'
                    },
                    {
                        data: 'spare_name',
                        name: 'spare_name'
                    },
                    {
                        data: 'spare_phone',
                        name: 'spare_phone'
                    },
                    {
                        data: 'crew_name',
                        name: 'crew_name'
                    },
                    {
                        data: 'crew_phone',
                        name: 'crew_phone'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>

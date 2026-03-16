@extends('admin.layouts.app')
@section('title', 'မြို့များ | ရွှေရုပ်လေး ကားလိုင်း')
@section('content')
<div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">မြို့များ</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">ပင်မစာမျက်နှာ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">မြို့များ</li>
                </ol>
            </div>
        </div>
        <!--end::Row-->
    </div>
    <!--end::Container-->
</div>
<div class="app-content">
    <div class="container-fluid p-2">
        <!--begin::Row-->
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">မြို့များ</h3>
                    <div class="card-toolbar float-end">
                        <div class="d-flex align-items-center">
                            <a href="{{ route('admin.cities.create') }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-plus"></i>
                                မြို့စာရင်းသွင်းမည်
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="citiesTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>မြို့အမည်(EN)</th>
                                    <th>မြို့အမည်(MY)</th>
                                    <th>အကြောင်းရာ</th>
                                    <th>လုပ်ဆောင်ချက်</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <!--end::Row-->
        </div>
    </div>
    <!-- /.container-fluid -->
</div>
    @endsection
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('#citiesTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,
                ajax: {
                    url: "{{ route('cities.getCities') }}",
                    type: 'GET',
                    dataType: 'json'
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name_en',
                        name: 'name_en'
                    },
                    {
                        data: 'name_my',
                        name: 'name_my'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        });
    </script>
    @endpush
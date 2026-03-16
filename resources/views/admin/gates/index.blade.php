@extends('admin.layouts.app')
@section('title', 'ဂိတ်များ | ရွှေရုပ်လေး ကားလိုင်း')
@section('content')
<div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">ဂိတ်များ</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">ပင်မစာမျက်နှာ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">ဂိတ်များ</li>
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
                    <h3 class="card-title">ဂိတ်များ</h3>
                    <div class="card-toolbar float-end">
                        <a href="{{ route('admin.gates.create') }}" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> ဂိတ်စာရင်းသွင်းမည်</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label" for="cityFilter">မြို့များ</label>
                                <select id="cityFilter" class="form-select form-select-sm select2">
                                    <option value="">အားလုံး</option>
                                    @foreach($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name_my }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">

                        </div>
                        <div class="col-md-4"></div>
                    </div>
                    <table class="table table-striped table-bordered" id="gateTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ဂိတ်အမည်(EN)</th>
                                <th>ဂိတ်အမည်(MY)</th>
                                <th>မြို့အမည်</th>
                                <th>အကြောင်းရာ</th>
                                <th>ပင်မဂိတ်</th>
                                <th>ဂိတ်ချိန်း</th>
                                <th>လုပ်ဆောင်မှု</th>
                            </tr>
                        </thead>
                    </table>
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
        $(function() {
            $('#gateTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,
                ajax: {
                    url: "{{ route('gates.getGates') }}",
                    type: 'GET',
                    dataType: 'json',
                    data: function(d) {
                        d.city_id = $('#cityFilter').val();
                    }
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
                        data: 'city_name',
                        name: 'city.name_my'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'is_main',
                        name: 'is_main',
                        render: function(data, type, row) {
                            return data ? 'ဟုတ်တယ်' : 'မဟုတ်ဘူး';
                        }
                    },
                    {
                        data: 'is_transit',
                        name: 'is_transit',
                        render: function(data, type, row) {
                            return data ? 'ဟုတ်တယ်' : 'မဟုတ်ဘူး';
                        }

                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
            });
            $('#cityFilter').on('change', function() {
                $('#gateTable').DataTable().ajax.reload();
            });
        });
    })
</script>
@endpush
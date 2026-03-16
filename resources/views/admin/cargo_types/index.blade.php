@extends('admin.layouts.app')
@section('title', 'ကုန်အမျိုးအစားများ | ရွှေရုပ်လေး ကားလိုင်း')
@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">ကုန်အမျိုးအစားများ</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">ပင်မစာမျက်နှာ</a> </li>
                        <li class="breadcrumb-item active">ကုန်အမျိုးအစားများ</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid p-2">
            <div class="row">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">ကုန်အမျိုးအစားများ</h3>
                        <div class="card-toolbar float-end">
                            <div class="d-flex align-items-center">
                                <button class="btn btn-sm btn-primary"
                                    onclick="window.location.href='{{ route('admin.cargo_types.create') }}'">
                                    <i class="fas fa-plus"></i>
                                    ကုန်အမျိုးအစားသွင်းမည်
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="cargo-types-table" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>စဉ်</th>
                                    <th>အမည်</th>
                                    <th>အကြောင်းအရာ</th>
                                    <th>အခြေနေ</th>
                                    <th>အလုပ်ဆောင်မှု</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('#cargo-types-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,
                ajax: {
                    url: "{{ route('cargo_types.getCargoTypes') }}",
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
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ]
            });
        });
    </script>
@endpush

@extends('admin.layouts.app')
@section('title', 'အသုံးပြုသူများ | ရွှေရုပ်လေး ကားလိုင်း')
@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">အသုံးပြုသူများ</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">ပင်မစာမျက်နှာ</a></li>
                    <li class="breadcrumb-item active">အသုံးပြုသူများ</li>
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
                    <h3 class="card-title">အသုံးပြုသူများ</h3>
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary float-end">အသုံးပြုသူအသစ်ထည့်မည်</a>
                </div>
                <div class="card-body">
                    <table id="users-table" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>စဉ်</th>
                                <th>အမည်</th>
                                <th>အီးမေးလ်</th>
                                <th>တာဝန်ယူမှု</th>
                                <th>လုပ်ဆောင်ချက်</th>
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
        $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            autoWidth: false,
            ajax: {
                url: "{{ route('users.getList') }}",
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
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'roles',
                    name: 'roles'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        })
    });
</script>
@endpush
@extends('admin.layouts.app')
@section('title', 'ကုန်သည်များ | ရွှေရုပ်လေး ကားလိုင်း')
@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">ကုန်သည်များ</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">ပင်မစာမျက်နှာ</a></li>
                    <li class="breadcrumb-item active">ကုန်သည်များ</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="app-content">
    <div class="container-fluid p-2">
        <!--begin::Row-->
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">ကုန်သည်များ</h3>
                    <div class="card-toolbar float-end">
                        <a href="{{route('admin.merchants.create')}}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i>စာရင်းသွင်းမည်</a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-bordered" id="merchantTable">
                        <thead>
                            <tr>
                                <th>စဉ်</th>
                                <th>ကုန်သည်အမည်</th>
                                <th>ဖုန်းနံပါတ်</th>
                                <th>မှတ်ပုံတင်အမှတ်</th>
                                <th>လိပ်စာ</th>
                                <th>လုပ်ဆောင်ချက်</th>
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
@if(session('success'))
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        successMessageAlert(@json(session('success')));
    });
</script>
@endpush
@endif
@if(session('error'))
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        errorMessageAlert(@json(session('error')));
    });
</script>
@endpush
@endif
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#merchantTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('admin.merchants.getMerchants') }}",
                type: 'GET',
            },
            columns: [
                {
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
                    data: 'phone',
                    name: 'phone'
                },
                {
                    data: 'nrc',
                    name: 'nrc'
                },
                {
                    data: 'address',
                    name: 'address'
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
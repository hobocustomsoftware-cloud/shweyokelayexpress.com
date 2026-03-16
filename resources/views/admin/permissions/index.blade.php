@extends('admin.layouts.app')
@section('title', 'ခွင့်ပြုချက်များစီမံခြင်း | ရွှေရုပ်လေး ကားလိုင်း')
@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">ခွင့်ပြုချက်များစီမံခြင်း</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.permissions.index') }}">ခွင့်ပြုချက်များစီမံခြင်း</a></li>
                    <li class="breadcrumb-item active">ခွင့်ပြုချက်များစီမံခြင်း</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="app-content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">ခွင့်ပြုချက်များစီမံခြင်း</h3>
            <div class="card-toolbar float-end">
                <a href="{{route('admin.permissions.create')}}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i>ခွင့်ပြုချက်အသစ်သွင်းမည်</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered" id="permissionTable">
                <thead>
                    <tr>
                        <th>စဉ်</th>
                        <th>ခွင့်ပြုချက်အမည်</th>
                        <th>အကြောင်းအရာ</th>
                        <th>အခြေအနေ</th>
                        <th>ရက်စွဲ</th>
                        <th>လုပ်ဆောင်ချက်</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#permissionTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.permissions.getList') }}",
                type: 'GET',
                dataType: 'json',
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'name', name: 'name' },
                { data: 'description', name: 'description' },
                { data: 'status', name: 'status' },
                { data: 'date', name: 'date' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ],
        });
    });
</script>
@endpush

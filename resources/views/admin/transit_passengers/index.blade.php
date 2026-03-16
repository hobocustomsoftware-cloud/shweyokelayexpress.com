@extends('admin.layouts.app')
@section('title', 'လမ်းတင်လူစာရင်းများ | ရွှေရုပ်လေး ကားလိုင်း')
@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">လမ်းတင်လူစာရင်းများ</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">ပင်မစာမျက်နှာ</a></li>
                    <li class="breadcrumb-item active">လမ်းတင်လူစာရင်းများ</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="app-content">
    <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">လမ်းတင်လူစာရင်းများ</h3>
                    <div class="card-toolbar float-end">
                        <a href="{{route('admin.transit_passengers.create')}}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i>လမ်းတင်လူစာရင်းသွင်းမည်</a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-bordered" id="transitPassengerTable">
                        <thead>
                            <tr>
                                <th>စဉ်</th>
                                <th>အမည်</th>
                                <th>ဖုန်းနံပါတ်</th>
                                <th>မှတ်ပုံတင်အမှတ်</th>
                                <th>လိပ်စာ</th>
                                <th>ကားနံပါတ်</th>
                                <th>ခုံနံပါတ်</th>
                                <th>ကျသင့်ငွေ</th>
                                <th>ဘောက်ချာ နံပါတ်</th>
                                <th>ရှင်းပြီး</th>
                                <th>အခြေအနေ</th>
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
        $('#transitPassengerTable').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            scrollX: true,
            scrollCollapse: true,
            ajax: {
                url: "{{ route('admin.transit_passengers.getList') }}",
                type: 'GET',
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
                    data: 'car_number',
                    name: 'car_number'
                },
                {
                    data: 'seat_number',
                    name: 'seat_number'
                },
                {
                    data: 'price',
                    name: 'price'
                },
                {
                    data: 'voucher_number',
                    name: 'voucher_number'
                },
                {
                    data: 'is_paid',
                    name: 'is_paid'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action'
                },
            ],
        });
    });
</script>
@endpush
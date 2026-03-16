@extends('admin.layouts.app')
@section('title', 'ကားပေါ်တင်ရန် ကုန်ပစ္စည်းများ | ရွှေရုပ်လေး ကားလိုင်း')
@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">ကားပေါ်တင်ရန် ကုန်ပစ္စည်းများ</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">ပင်မစာမျက်နှာ</a></li>
                    <li class="breadcrumb-item active">ကားပေါ်တင်ရန် ကုန်ပစ္စည်းများ</li>
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
                    <h3 class="card-title">ကားပေါ်တင်ရန် ကုန်ပစ္စည်းများ</h3>
                </div>
                <!-- Start cardbody -->
                <div class="card-body">
                    <!-- date range filter -->
                    <div class="row mt-3">
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label class="form-label" for="assignStatusFilter">ကားပေါ်တင်ပြီး မပြီး</label>
                                <select class="form-select select2" id="assignStatusFilter">
                                    <option value="">အားလုံး</option>
                                    <option value="assigned">ပြီးပါပြီ</option>
                                    <option value="pending">မပြီးသေးပါ</option>
                                    <option value="cancelled">ပယ်ဖျတ်ပါပြီ</option>
                                </select>
                            </div>
                        </div>
                        <!-- start status filter -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label" for="statusFilter">ကုန်ပစ္စည်းအခြေအနေများ</label>
                                <select class="form-select select2" id="statusFilter">
                                    <option value="">အားလုံး</option>
                                    <option value="registered">စာရင်းသွင်းပြီး</option>
                                    <option value="delivered">ပို့ပြီး</option>
                                    <option value="taken">ရွေးပြီး</option>
                                </select>
                            </div>
                        </div>
                        <!-- end status filter -->
                        <!-- start date range filter -->
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label class="form-label" for="dateRangeFilter">ရက်စွဲအလိုက်ရှာမယ်</label>
                                <input type="text" class="form-control" id="dateRangeFilter" name="daterange" />
                            </div>
                        </div>
                        <!-- end date range filter -->
                        <!-- start merchant filter -->
                        <div class="col-md-3">
                            <label for="s_name" class="form-label">ပို့သူ</label>
                            <select class="form-select select2" id="s_name">
                                <option value="">အားလုံး</option>
                                @foreach ($params['merchants'] as $param)
                                <option value="{{ $param->id }}">{{ $param->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- end merchant filter -->
                    </div>
                    <div class="row">
                        <!-- start clear button -->
                        <div class="col-md-3 mb-3">
                            <button class="btn btn-sm btn-warning"
                                id="clearFilterBtn"><i class="fa-solid fa-rotate"></i> ပြန်စမယ်</button>
                        </div>
                        <!-- end clear button -->
                    </div>
                    <table class="table table-striped table-bordered" id="putinCargoTable">
                        <thead>
                            <tr>
                                <th>စဉ်</th>
                                <th>ကုန်နံပါတ်</th>
                                <th>ကုန်ပစ္စည်းအမျိုးအစား</th>
                                <th>မှ</th>
                                <th>သို့</th>
                                <th>ပို့သူ</th>
                                <th>လက်ခံသူ</th>
                                <th>စာရင်းသွင်းရက်</th>
                                <th>ကုန်ပစ္စည်းအခြေအနေ</th>
                                <th>ကားပေါ်တင်ပြီး မပြီး</th>
                                <th>ကားနံပါတ်</th>
                                <th>လုပ်ဆောင်ချက်</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <!-- End cardbody -->
            </div>
        </div>
        <!--end::Row-->
    </div>
</div>
@endsection
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        /*****  Date range filter script start ******/
        let today = moment().format('YYYY-MM-DD');
        $('input[name="daterange"]').daterangepicker({
            opens: 'right',
            startDate: today,
            endDate: today,
            locale: {
                format: 'YYYY-MM-DD',
                cancelLabel: 'Clear',
                applyLabel: 'Apply',
            },
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                    'month').endOf('month')]
            }
        });

        // Set initial input value
        $('input[name="daterange"]').val(
            moment().startOf('month').format('YYYY-MM-DD') + ' - ' + moment().endOf('month').format('YYYY-MM-DD')
        );

        // Update the input when dates are selected
        $('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(
                picker.startDate.format('YYYY-MM-DD') + ' - ' +
                picker.endDate.format('YYYY-MM-DD')
            );
        });
        // Clear the input when cleared
        $('input[name="daterange"]').on('cancel.daterangepicker', function() {
            $(this).val('');
        });
        /*****  Date range filter script end ******/

        // Filter auto datatable reload
        $('#statusFilter, #dateRangeFilter, #s_name, #assignStatusFilter').on('change', function() {
            $('#putinCargoTable').DataTable().ajax.reload();
        });

        // Clear filter button click event
        $('#clearFilterBtn').on('click', function() {
            // Reset all filter inputs
            $('#statusFilter, #dateRangeFilter, #s_name, #assignStatusFilter').val('');
            // Reset date range picker
            $('input[name="daterange"]').val('');
            // Reload DataTable with cleared filters
            $('#putinCargoTable').DataTable().ajax.reload();
        });
        // Datatable Script
        let data_table = $('#putinCargoTable').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            scrollX: true,
            scrollCollapse: true,
            ajax: {
                url: "{{ route('admin.putin_cargos.getList') }}",
                type: 'GET',
                dataType: 'json',
                data: function(d) {
                    d.status = $('#statusFilter').val();
                    d.daterange = $('#dateRangeFilter').val();
                    d.s_name = $('#s_name').val();
                    d.assignStatus = $('#assignStatusFilter').val();
                },
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'cargo_no',
                    name: 'cargo_no'
                },
                {
                    data: 'cargo_type',
                    name: 'cargo_type'
                },
                {
                    data: 'from',
                    name: 'from'
                },
                {
                    data: 'to',
                    name: 'to'
                },
                {
                    data: 's_name',
                    name: 's_name'
                },
                {
                    data: 'r_name',
                    name: 'r_name'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'cargo_status',
                    name: 'cargo_status'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'car_number',
                    name: 'car_number'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
        });
    });
</script>
@endpush
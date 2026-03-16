@extends('admin.layouts.app')
@section('title', 'အစီရင်ခံစာများ | ရွှေရုပ်လေး ကားလိုင်း')
@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">အစီရင်ခံစာများ</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">ပင်မစာမျက်နှာ</a></li>
                    <li class="breadcrumb-item active">အစီရင်ခံစာများ</li>
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
                    <h3 class="card-title">လမ်းတင်လူစာရင်း အစီရင်ခံစာများ</h3>
                </div>
                <div class="card-body">
                    <!-- Filter Start -->
                    <div class="row mt-3">
                        <!-- begin::date range filter -->
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label class="form-label" for="dateRangeFilter">ရက်စွဲအလိုက်ရှာမယ်</label>
                                <input type="text" class="form-control" id="dateRangeFilter" name="daterange" />
                            </div>
                        </div>
                        <!-- end::date range filter -->
                        <!-- begin::car filter -->
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label class="form-label" for="carNumberFilter">ကားနံပါတ်</label>
                                <select name="carNumber" class="form-select select2" id="carNumberFilter">
                                    <option value="">အားလုံး</option>
                                    @foreach ($params['cars'] as $car)
                                    <option value="{{ $car->number }}">{{ $car->number }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- end::car filter -->
                    </div>
                    <!-- Filter end -->
                    <table class="table table-striped table-bordered" id="passengerSummaryReportTable">
                        <thead>
                            <tr>
                                <th>စဉ်</th>
                                <th>အမည်</th>
                                <th>ဖုန်းနံပါတ်</th>
                                <th>လိပ်စာ</th>
                                <th>မှတ်ပုံတင်နံပါတ်</th>
                                <th>ကားနံပါတ်</th>
                                <th>ခုံနံပါတ်</th>
                                <th>အကြွေး</th>
                                <th>ဘောင်ချာနံပါတ်</th>
                                <th>ကျသင့်ငွေ</th>
                                <th>ရက်စွဲ</th>
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

        $('#passengerSummaryReportTable').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            scrollX: true,
            scrollCollapse: true,
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'excel',
                    text: '<i class="fas fa-file-excel"></i> Export Excel',
                    className: 'btn btn-success my-2',
                    title: 'Transit Passenger Summary Report',
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                    },
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fas fa-file-pdf"></i> Export PDF',
                    className: 'btn btn-danger my-2',
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                    },
                    customize: function(doc) {
                        doc.defaultStyle = {
                            font: 'NotoSansMyanmar'
                        };
                    }
                }
            ],
            ajax: {
                url: "{{ route('admin.reports.passengers.getList') }}",
                type: 'GET',
                dataType: 'json',
                data: function(d) {
                    d.daterange = $('input[name="daterange"]').val();
                    d.carNumber = $('#carNumberFilter').val();
                },
            },
            columns: [{
                    data: 'id',
                    name: 'id'
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
                    data: 'registered_date',
                    name: 'registered_date'
                },  
                {
                    data: 'nrc',
                    name: 'nrc'
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
                    data: 'is_paid',
                    name: 'is_paid'
                },
                {
                    data: 'voucher_number',
                    name: 'voucher_number'
                },
                {
                    data: 'price',
                    name: 'price'
                },
                {
                    data: 'registered_date',
                    name: 'registered_date'
                },
            ],
        });

        $('#dateRangeFilter, #carNumberFilter').on('change', function() {
            $('#passengerSummaryReportTable').DataTable().ajax.reload();
        });
    });
</script>
@endpush
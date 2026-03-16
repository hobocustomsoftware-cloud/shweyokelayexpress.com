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
        <!--begin::Row-->
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">အစီရင်ခံစာများ</h3>
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
                        <!-- begin::is debt filter -->
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label class="form-label" for="isDebtFilter">ကုန်ကြွေး</label>
                                <select name="isDebt" class="form-select" id="isDebtFilter">
                                    <option value="">အားလုံး</option>
                                    <option value="1">ကုန်ကြွေး</option>
                                    <option value="0">ကုန်ကြွေးမဟုတ်ပါ</option>
                                </select>
                            </div>
                        </div>
                        <!-- end::is debt filter -->
                        <!-- begin::car filter -->
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label class="form-label" for="carNumberFilter">ကားနံပါတ်</label>
                                <select name="carNumber" class="form-select select2" id="carNumberFilter">
                                    <option value="">အားလုံး</option>
                                    @foreach ($params['cars'] as $car)
                                    <option value="{{ $car->id }}">{{ $car->number }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- end::car filter -->
                        <!-- begin::Type filter -->
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label class="form-label" for="typeFilter">ကုန်တင်အမျိူးအစား</label>
                                <select name="type" class="form-select" id="typeFilter">
                                    <option value="">အားလုံး</option>
                                    <option value="gate">ဂိတ်တင်ကုန်</option>
                                    <option value="transit">လမ်းတင်ကုန်</option>
                                </select>
                            </div>
                        </div>
                        <!-- end::Type filter -->
                    </div>
                    <!-- Filter end -->
                    <!--begin::Table-->
                    <table class="table table-striped table-bordered" id="cargoSummaryReportTable">
                        <thead>
                            <tr>
                                <th>စဉ်</th>
                                <th>ကုန်နံပါတ်</th>
                                <th>မှ မြို့ နှင့် ဂိတ်</th>
                                <th>သို့ မြို့ နှင့် ဂိတ်</th>
                                <th>ပို့သူ</th>
                                <th>ပို့သူဖုန်းနံပါတ်</th>
                                <th>လက်ခံသူ</th>
                                <th>လက်ခံသူဖုန်းနံပါတ်</th>
                                <th>ကားနံပါတ်</th>
                                <th>စာရင်းသွင်းရက်</th>
                                <th>ကုန်းရွေးရမည့်ရက်</th>
                                <th>ကုန်ပစ္စည်းအရေအတွက်</th>
                                <th>တန်ဆာခ</th>
                                <th>ခေါက်တိုကြေး</th>
                                <th>အရောက်ပို့ကြေး</th>
                                <th>ဘော်ဒါကြေး</th>
                                <th>ကျသင့်ငွေ</th>
                                <th>လုပ်ဆောင်ချက်</th>
                            </tr>
                        </thead>
                    </table>
                    <!--end::Table-->
                </div>
            </div>
        </div>
        <!-- end::Row-->
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

        // Cargo Summary Report Datatable Script
        $('#cargoSummaryReportTable').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            scrollX: true,
            scrollCollapse: true,
            dom: 'lBfrtip',
            buttons: [{
                    extend: 'excel',
                    text: '<i class="fas fa-file-excel"></i> Export Excel',
                    className: 'btn btn-success my-2',
                    title: 'Cargo Summary Report',
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16],
                    },
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fas fa-file-pdf"></i> Export PDF',
                    className: 'btn btn-danger my-2',
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16],
                        format: {
                            body: function(data, row, column, node) {
                                return data == null ? '' : String(data).replace(/\u{10000}/gu, '');
                            }
                        }
                    },
                    customize: function(doc) {
                        doc.pageSize = 'A4';
                        doc.pageOrientation = 'landscape';
                        doc.defaultStyle = {
                            font: 'NotoSansMyanmar',
                            fontSize: 10,
                            alignment: 'right'
                        };
                        doc.styles = {
                            header: {
                                font: 'NotoSansMyanmar',
                                fontSize: 12,
                                bold: true,
                                alignment: 'center'
                            },
                            tableHeader: {
                                font: 'NotoSansMyanmar',
                                fontSize: 10,
                                bold: true,
                                alignment: 'right'
                            },
                            table: {
                                font: 'NotoSansMyanmar',
                                fontSize: 10,
                                alignment: 'right'
                            }
                        };
                        doc.content.unshift({
                            text: 'အစီရင်ခံစာများ',
                            style: 'header',
                            margin: [0, 0, 0, 10]
                        });
                        const tableContent = doc.content.find(item => item.table);
                        if (tableContent && tableContent.table) {
                            tableContent.table.widths = Array(16).fill('*');
                        } else {
                            console.warn('Table not found in doc.content. Check PDF structure.');
                        }
                    }
                }
            ],
            columnDefs: [{
                targets: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16],
                width: '150px',
            }],
            ajax: {
                url: "{{ route('admin.reports.getList') }}",
                type: 'GET',
                dataType: 'json',
                data: function(d) {
                    d.daterange = $('input[name="daterange"]').val();
                    d.isDebt = $('#isDebtFilter').val();
                    d.carNumber = $('#carNumberFilter').val();
                    d.sender_name = $('#senderNameFilter').val();
                    d.receiver_name = $('#receiverNameFilter').val();
                    d.type = $('#typeFilter').val();
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
                    data: 'from',
                    name: 'from',
                },
                {
                    data: 'to',
                    name: 'to',
                },
                {
                    data: 's_name',
                    name: 's_name',
                },
                {
                    data: 's_phone',
                    name: 's_phone',
                },
                {
                    data: 'r_name',
                    name: 'r_name',
                },
                {
                    data: 'r_phone',
                    name: 'r_phone',
                },
                {
                    data: 'car_number',
                    name: 'car_number',
                },
                {
                    data: 'registered_date',
                    name: 'registered_date',
                },
                {
                    data: 'to_pick_date',
                    name: 'to_pick_date',
                },
                {
                    data: 'quantity',
                    name: 'quantity',
                },
                {
                    data: 'service_charge',
                    name: 'service_charge',
                },
                {
                    data: 'short_deli_fee',
                    name: 'short_deli_fee',
                },
                {
                    data: 'final_deli_fee',
                    name: 'final_deli_fee',
                },
                {
                    data: 'border_fee',
                    name: 'border_fee',
                },
                {
                    data: 'total_fee',
                    name: 'total_fee',
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
        });

        $('#dateRangeFilter, #isDebtFilter, #carNumberFilter, #senderNameFilter, #receiverNameFilter, #typeFilter').on('change', function() {
            $('#cargoSummaryReportTable').DataTable().ajax.reload();
        });
    });
</script>
@endpush
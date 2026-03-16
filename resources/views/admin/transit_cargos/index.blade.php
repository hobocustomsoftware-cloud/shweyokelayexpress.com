@extends('admin.layouts.app')
@section('title', 'လမ်းတင်ကုန်ပစ္စည်းများ | ရွှေရုပ်လေး ကားလိုင်း')
@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">လမ်းတင်ကုန်ပစ္စည်းများ</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">ပင်မစာမျက်နှာ</a></li>
                    <li class="breadcrumb-item active">လမ်းတင်ကုန်ပစ္စည်းများ</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">လမ်းတင်ကုန်ပစ္စည်းများ</h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.transit_cargos.create') }}" class="btn bt-sm btn-primary">
                                <i class="fas fa-plus"></i> လမ်းတင်ကုန်ပစ္စည်းသွင်းမည်
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- from city -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label" for="fromCityFilter">မှမြို့</label>
                                    <select name="from_city_id" class="form-select select2" id="fromCityFilter">
                                        <option value="">အားလုံး</option>
                                        @foreach ($cities as $city)
                                        <option value="{{ $city->id }}">{{ $city->name_my }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- to city -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label" for="toCityFilter">သို့မြို့</label>
                                    <select name="to_city_id" class="form-select select2" id="toCityFilter">
                                        <option value="">အားလုံး</option>
                                        @foreach ($cities as $city)
                                        <option value="{{ $city->id }}">{{ $city->name_my }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- cargo type -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label" for="cargoTypeFilter">ကုန်ပစ္စည်းအမျိုးအစားများ</label>
                                    <select name="cargo_type_id" class="form-select select2" id="cargoTypeFilter">
                                        <option value="">အားလုံး</option>
                                        @foreach ($cargoTypes as $cargoType)
                                        <option value="{{ $cargoType->id }}">{{ $cargoType->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- date range filter -->
                        <div class="row mt-3">
                            <!-- status -->
                            <div class="col-md-4">
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
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="dateRangeFilter">ရက်စွဲအလိုက်ရှာမယ်</label>
                                    <input type="text" class="form-control" id="dateRangeFilter" name="daterange" />
                                </div>
                            </div>
                            <!-- Clear filter -->
                            <div class="col-md-4 my-auto">
                                <button class="btn btn-sm btn-secondary"
                                    id="clearFilterBtn">သက်မှတ်ချက်ကိုပျယ်ဖျတ်မည်</button>
                            </div>
                        </div>
                        <table class="table table-bordered" id="transit_cargos_table">
                            <thead>
                                <tr>
                                    <th>စဉ်</th>
                                    <th>ကုန်နံပါတ်</th>
                                    <th>ကုန်ပစ္စည်းအမျိုးအစား</th>
                                    <th>မှ</th>
                                    <th>သို့</th>
                                    <th>ပို့သူ</th>
                                    <th>လက်ခံသူ</th>
                                    <th>ဘောက်ချာ နံပါတ်</th>
                                    <th>တန်ဆာခ</th>
                                    <th>ကားနံပါတ်</th>
                                    <th>စာရင်းသွင်းရက်</th>
                                    <th>ရွေးရမည့်ရက်</th>
                                    <th>ကုန်ပစ္စည်းအခြေအနေ</th>
                                    <th>လုပ်ဆောင်ချက်</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
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
            moment().format('YYYY-MM-DD') + ' - ' + moment().format('YYYY-MM-DD')
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

        $('#transit_cargos_table').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            scrollX: true,
            scrollCollapse: true,
            ajax: {
                url: "{{ route('admin.transit_cargos.getList') }}",
                type: 'GET',
                dataType: 'json',
                data: function(d) {
                    d.from_city_id = $('#fromCityFilter').val();
                    d.to_city_id = $('#toCityFilter').val();
                    d.cargo_type_id = $('#cargoTypeFilter').val();
                    d.status = $('#statusFilter').val();
                    d.daterange = $('#dateRangeFilter').val();
                }
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
                    data: 'voucher_number',
                    name: 'voucher_number'
                },
                {
                    data: 'service_charge',
                    name: 'service_charge'
                },
                {
                    data: 'car',
                    name: 'car'
                },
                {
                    data: 'date',
                    name: 'date'
                },
                {
                    data: 'to_pick_date',
                    name: 'to_pick_date'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
        });

        $('#fromCityFilter, #toCityFilter, #cargoTypeFilter, #statusFilter, #deliveryTypeFilter, #dateRangeFilter')
            .on('change', function() {
                $('#cargoTable').DataTable().ajax.reload();
            });

        // Clear filter button click event
        $('#clearFilterBtn').on('click', function() {
            // Reset all filter inputs
            $('#deliveryTypeFilter, #fromCityFilter, #toCityFilter, #cargoTypeFilter, #statusFilter, #dateRangeFilter')
                .val('');
            // Reset date range picker
            $('input[name="daterange"]').val('');
            // Reload DataTable with cleared filters
            $('#cargoTable').DataTable().ajax.reload();
        });
    });
</script>
@endpush
@extends('admin.layouts.app')
@section('title', 'ကုန်ပစ္စည်းများ | ရွှေရုပ်လေး ကားလိုင်း')
@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">ကုန်ပစ္စည်းများ</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">ပင်မစာမျက်နှာ</a></li>
                        <li class="breadcrumb-item active">ကုန်ပစ္စည်းများ</li>
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
                        <h3 class="card-title">ကုန်ပစ္စည်းများ</h3>
                        <div class="card-toolbar float-end">
                            <div class="d-flex align-items-center">
                                <button class="btn btn-sm btn-primary" onclick="window.location.href='{{ route('admin.cargos.create') }}'">
                                    <i class="fas fa-plus"></i>
                                    ကုန်ပစ္စည်းသွင်းမည်
                                </button>
                            </div>
                        </div>
                    </div>
                     <!--Start cardbody -->
                    <div class="card-body">
                        <div class="row">
                             <!--from city -->
                            <div class="col-md-3">
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
                             <!--to city -->
                            <div class="col-md-3">
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
                             <!--cargo type -->
                            <div class="col-md-3">
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
                             <!--status -->
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
                        </div>
                        <div class="row mt-3">
                             <!--date range filter -->
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="dateRangeFilter">ရက်စွဲအလိုက်ရှာမယ်</label>
                                    <input type="text" class="form-control" id="dateRangeFilter" name="daterange" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="cargo_no">ကုန်နံပါတ်</label>
                                    <input type="text" class="form-control" id="cargo_no" name="cargo_no"/>
                                </div>
                            </div>
                             <!--Clear filter -->
                            <div class="col-md-3 my-auto">
                                <button class="btn btn-sm btn-secondary"
                                    id="clearFilterBtn">သက်မှတ်ချက်ကိုပျယ်ဖျတ်မည်</button>
                            </div>
                        </div>
                        <table class="table table-striped table-bordered" id="cargoTable">
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
                                    <th>လုပ်ဆောင်ချက်</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                     <!--End cardbody -->
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

            $('#cargoTable').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                scrollX: true,
                scrollCollapse: true,
                ajax: {
                    url: "{{ route('cargos.getCargos') }}",
                    type: 'GET',
                    dataType: 'json',
                    data: function(d) {
                        d.from_city_id = $('#fromCityFilter').val();
                        d.to_city_id = $('#toCityFilter').val();
                        d.cargo_type_id = $('#cargoTypeFilter').val();
                        d.status = $('#statusFilter').val();
                        d.daterange = $('#dateRangeFilter').val();
                        d.cargo_no = $('#cargo_no').val();
                    }
                },
                // columns: [
                //     { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                //     { data: 'cargo_no', name: 'cargo_no' },
                //     { data: 'cargo_type', name: 'cargo_type' },
                //     { data: 'from', name: 'from' },
                //     { data: 'to', name: 'to' },
                //     { data: 's_name', name: 's_name' }, // ဤနေရာတွင် Controller က ပို့သော အမည်နှင့် တူရမည်
                //     { data: 'r_name', name: 'r_name' }, // ဤနေရာတွင် Controller က ပို့သော အမည်နှင့် တူရမည်
                //     { data: 'created_at', name: 'created_at' },
                //     { data: 'status', name: 'status' },
                //     { data: 'action', name: 'action' }
                // ]
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
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $('#fromCityFilter, #toCityFilter, #cargoTypeFilter, #statusFilter, #deliveryTypeFilter, #dateRangeFilter, #cargo_no')
                .on('change', function() {
                    $('#cargoTable').DataTable().ajax.reload();
                });

            // Clear filter button click event
            $('#clearFilterBtn').on('click', function() {
                // Reset all filter inputs
                $('#deliveryTypeFilter, #fromCityFilter, #toCityFilter, #cargoTypeFilter, #statusFilter, #dateRangeFilter, #cargo_no')
                    .val('');
                // Reset date range picker
                $('input[name="daterange"]').val('');
                // Reload DataTable with cleared filters
                $('#cargoTable').DataTable().ajax.reload();
            });
        });
        // Delete လုပ်ရန် Function
        function confirmDelete(id) {
    // SweetAlert သုံးထားရင် ပိုကောင်းပါတယ်၊ ဒါပေမဲ့ ရိုးရိုး confirm နဲ့ပဲ အရင်စမ်းပြပါမယ်
         if (confirm('ဒီကုန်ပစ္စည်းကို ဖျက်မှာ သေချာပါသလား?')) {
        
        // Dynamic Form တစ်ခု တည်ဆောက်မယ်
        let form = document.createElement('form');
        
        // Route path ကို သတိထားပါ။ သင့် Route မှာ admin/cargos လို့ သတ်မှတ်ထားရင် ဒီအတိုင်းသွားပါ
        form.action = '/admin/cargos/' + id; 
        form.method = 'POST';
        
        // Laravel ရဲ့ CSRF နဲ့ Method Spoofing (DELETE) အတွက် hidden fields တွေထည့်မယ်
        form.innerHTML = `
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="_method" value="DELETE">
        `;
        
        document.body.appendChild(form);
        form.submit();
    }
}
    </script>
@endpush



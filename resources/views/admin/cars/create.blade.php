@extends('admin.layouts.app')
@section('title', 'ကားအချက်အလက်များသွင်းမည် | ရွှေရုပ်လေး ကားလိုင်း')
@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">ကားအချက်အလက်များသွင်းမည်</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.cars.index') }}">ကားအချက်အလက်များ</a></li>
                    <li class="breadcrumb-item active">ကားအချက်အလက်များသွင်းမည်</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">ကားအချက်အလက်များသွင်းမည်</h3>
                </div>
                <div class="card-body">
                    @livewire('car-registration-form', ['form_type' => 'create', 'id' => null])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {

    function initDatePickers() {
        flatpickr("#departure_time", {
            enableTime: true, noCalendar: true, time_24hr: false,
            dateFormat: "H:i", altInput: true, altFormat: "h:i K",
            defaultDate: "{{ now()->format('H:i') }}"
        });
        flatpickr("#day_off_date", {
            altInput: true, altFormat: "F j, Y",
            dateFormat: "Y-m-d",
            enableTime: false, inline: true, mode: 'multiple',
            minDate: "{{ now()->format('Y-m-d') }}"
        });
    }
    initDatePickers();

    // Livewire.on('reinitDatePickers', () => initDatePickers());
});
</script>

@endpush
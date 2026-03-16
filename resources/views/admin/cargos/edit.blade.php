@extends('admin.layouts.app')
@section('title', 'ကုန်ပစ္စည်းပြင်ဆင်မည် | ရွှေရုပ်လေး ကားလိုင်း')
@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">ကုန်ပစ္စည်းသွင်းမည်</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.cargos.index') }}">ကုန်ပစ္စည်းများ</a></li>
                    <li class="breadcrumb-item active">ကုန်ပစ္စည်းသွင်းမည်</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!--<div class="app-content">-->
<!--    @if ($cargo_id)-->
<!--        @livewire('cargo-form', ['form_type' => 'edit', 'cargo_id' => $cargo_id], key('cargo-form-'.$cargo_id))-->
<!--    @endif-->
<!--</div>-->
@endsection
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const recBtns = document.querySelectorAll('.rec-btn');
        const noticeMessage = document.getElementById('notice_message');

        recBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const desc = this.getAttribute('data-desc');
                const descArr = desc.split('/');
                const formattedDesc = descArr.join(' / ');
                if (noticeMessage.value) {
                    noticeMessage.value += ', ' + formattedDesc;
                } else {
                    noticeMessage.value = formattedDesc;
                }
                noticeMessage.dispatchEvent(new Event('input'));
            });
        });
    });
</script>
@endpush


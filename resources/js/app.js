import jQuery from 'jquery';
import moment from 'moment';
window.moment = moment;

import select2 from "select2";
select2();
window.$ = window.jQuery = jQuery;
import 'daterangepicker';

import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import './bootstrap';
import '@popperjs/core/dist/umd/popper.min.js';
import 'admin-lte/dist/js/adminlte.min.js';
import '@fortawesome/fontawesome-free/js/all.min.js';
import 'datatables.net-bs5';
import 'datatables.net-buttons-bs5';
import 'datatables.net-buttons/js/buttons.html5';
import 'datatables.net-buttons/js/buttons.print';
import 'datatables.net-buttons/js/buttons.colVis';
import pdfmake from 'pdfmake/build/pdfmake';
import JSZip from 'jszip';
window.JSZip = JSZip;
import 'datatables.net-bs5/css/dataTables.bootstrap5.min.css';
import 'datatables.net-responsive/js/dataTables.responsive.min.js';
import 'datatables.net-responsive-dt/js/responsive.dataTables.min.js';
import 'datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css';
import 'select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.min.css';
import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.min.css';
import { confirmDelete, successMessageAlert, errorMessageAlert } from './functions';
window.confirmDelete = confirmDelete;
window.successMessageAlert = successMessageAlert;
window.errorMessageAlert = errorMessageAlert;
window.initSelect2 = initSelect2;
window.flatpickr = flatpickr;

// Remove or comment out this line
// pdfmake.vfs = pdfMake.vfs;

document.addEventListener('DOMContentLoaded', function () {
    initSelect2();
});

document.addEventListener('DOMContentLoaded', function () {
    Livewire.hook('message.processed', (message, component) => {
        initSelect2();
    });
});

function initSelect2() {
    $('.select2').select2({
        placeholder: 'Choose an option',
        allowClear: true,
        width: 'resolve',
        dropdownAutoWidth: true,
        tags: true,
    }).on('change', function (e) {
        let data = $(this).val();
        let el = $(this);
        let model = el.attr('wire:model');
        if (model) {
            Livewire.find(el.closest('[wire\\:id]').attr('wire:id')).set(model, data);
        }
    });
}
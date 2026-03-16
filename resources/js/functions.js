import Swal from 'sweetalert2';
export function confirmDelete(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You can't undo this action!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e3342f',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form' + id).submit();
        }
    });
}

export function successMessageAlert(message) {
    Swal.fire({
        icon: 'success',
        title: 'Success',
        text: message,
        timer: 2000,
        showConfirmButton: false
    });
}

export function errorMessageAlert(message) {
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: message,
        timer: 2000,
        showConfirmButton: false
    });
}

export function initFlatpickr(selector, options) {
    flatpickr(selector, {
        ...options
    });
}
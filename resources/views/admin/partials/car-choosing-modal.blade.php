<!-- Car Choosing Modal -->
<div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-labelledby="{{ $modalId }}Label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $modalId }}Label">ကားရွေးချယ်ရန်</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="carChoiceForm-{{ $putin_cargo->id }}">
                    @csrf
                    <input type="hidden" name="putin_cargo_id" value="{{ $putin_cargo->id }}">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="departure_date_{{ $putin_cargo->id }}" class="form-label">ထွက်ခွာမည့်ရက်</label>
                                <select class="form-select select2" id="departure_date_{{ $putin_cargo->id }}" name="departure_date" required>
                                    <option value="">ရက်ရွေးချယ်ပါ</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="car_number_{{ $putin_cargo->id }}" class="form-label">ကားနံပါတ်</label>
                                <select class="form-select select2" id="car_number_{{ $putin_cargo->id }}" name="car_number" required>
                                    <option value="">ကားရွေးချယ်ပါ</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ပိတ်ရန်</button>
                <button type="button" class="btn btn-primary" onclick="saveCarChoice({{ $putin_cargo->id }})">သိမ်းဆည်းရန်</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modalId = '{{ $modalId }}';
    const putinCargoId = {{ $putin_cargo->id }};
    
    // Load cars data when modal is shown
    document.getElementById(modalId).addEventListener('shown.bs.modal', function() {
        loadCarsData(putinCargoId);
    });
    
    // Handle departure date change
    document.getElementById('departure_date_' + putinCargoId).addEventListener('change', function() {
        const selectedDate = this.value;
        loadCarNumbers(putinCargoId, selectedDate);
    });
    
    // Handle car number change
    document.getElementById('car_number_' + putinCargoId).addEventListener('change', function() {
        const selectedCarNumber = this.value;
        loadCarDetails(putinCargoId, selectedCarNumber);
    });
});

function loadCarsData(putinCargoId) {
    fetch('/admin/cars/get-departure-dates')
        .then(response => response.json())
        .then(data => {
            const departureSelect = document.getElementById('departure_date_' + putinCargoId);
            departureSelect.innerHTML = '<option value="">ရက်ရွေးချယ်ပါ</option>';
            
            data.forEach(date => {
                const option = document.createElement('option');
                option.value = date;
                option.textContent = date;
                departureSelect.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Error loading departure dates:', error);
        });
}

function loadCarNumbers(putinCargoId, selectedDate) {
    if (!selectedDate) return;
    
    fetch(`/admin/cars/get-car-numbers?date=${selectedDate}`)
        .then(response => response.json())
        .then(data => {
            const carNumberSelect = document.getElementById('car_number_' + putinCargoId);
            carNumberSelect.innerHTML = '<option value="">ကားရွေးချယ်ပါ</option>';
            
            data.forEach(carNumber => {
                const option = document.createElement('option');
                option.value = carNumber;
                option.textContent = carNumber;
                carNumberSelect.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Error loading car numbers:', error);
        });
}

function saveCarChoice(putinCargoId) {
    const form = document.getElementById('carChoiceForm-' + putinCargoId);
    const formData = new FormData(form);
    
    fetch('/admin/putin-cargos/assign-car', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('ကားသတ်မှတ်ပြီးပါပြီ');
            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('{{ $modalId }}'));
            modal.hide();
            // Refresh datatable
            if (typeof window.data_table !== 'undefined') {
                window.data_table.ajax.reload();
            }
        } else {
            alert('မအောင်မြင်ပါ။ ပြန်လည်ကြိုးစားပါ။');
        }
    })
    .catch(error => {
        console.error('Error saving car choice:', error);
        alert('မအောင်မြင်ပါ။ ပြန်လည်ကြိုးစားပါ။');
    });
}
</script> 
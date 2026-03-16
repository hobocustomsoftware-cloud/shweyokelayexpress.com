<div class="container-fluid mb-3">
    <form wire:submit.prevent="save" enctype="multipart/form-data">
        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <div class="form-group" wire:ignore>
                    <label class="form-label fw-bold" for="departure_date">
                        <i class="fas fa-calendar-alt me-1"></i>
                        ကားထွက်မည့်ရက်
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="departure_date" id="departure_date" class="form-control" wire:model.lazy="departure_date" placeholder="ရက်ကို ရွေးပါ" autocomplete="off">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="form-label fw-bold" for="car_number">
                        <i class="fas fa-truck me-1"></i>
                        ကားနံပါတ်
                        <span class="text-danger">*</span>
                    </label>
                    <select name="car_number" id="car_number" class="form-select" wire:model="car_id">
                        <option value="">ကားနံပါတ်များ</option>
                        @foreach ($car_numbers as $number=>$id)
                        <option value="{{ $id }}" >{{ $number }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group text-end">
            <button type="button" class="btn btn-sm btn-secondary" wire:click="back">နောက်သို့</button>
            <button type="submit" class="btn btn-sm btn-primary">ထည့်သွင်းမည်</button>
        </div>
    </form>
</div>
<form wire:submit.prevent="{{ $form_type == 'edit' ? 'update' : 'save' }}" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-4">
            <div class="form-group mb-3">
                <label class="form-label" for="number">ကားနံပါတ် <span
                        class="text-danger">*</span></label>
                <input type="text" wire:model="number" class="form-control">
                @error('number')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group mb-3" wire:ignore>
                <label class="form-label" for="from">မှမြို့ <span
                        class="text-danger">*</span></label>
                <select name="from" id="from" wire:model="from" class="form-select select2">
                    <option value=""></option>
                    @foreach ($cities as $city)
                    <option value="{{ $city->name_my }}" {{ $from === $city->name_my ? 'selected' : '' }}>{{ $city->name_my }}</option>
                    @endforeach
                </select>
                @error('from')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group mb-3" wire:ignore>
                <label class="form-label" for="to">သို့မြို့ <span
                        class="text-danger">*</span></label>
                <select name="to" id="to" wire:model="to" class="form-select select2">
                    <option value=""></option>
                    @foreach ($cities as $city)
                    <option value="{{ $city->name_my }}" {{ $to === $city->name_my ? 'selected' : '' }}>{{ $city->name_my }}</option>
                    @endforeach
                </select>
                @error('to')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label class="form-label" for="driver_name">ကားမောင်းသူအမည် <span
                            class="text-danger">*</span></label>
                    <input type="text" wire:model="driver_name" class="form-control">
                    @error('driver_name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label class="form-label" for="assistant_driver_name">အကူကားမောင်းသူအမည် <span
                            class="text-danger">*</span></label>
                    <input type="text" wire:model="assistant_driver_name" class="form-control">
                    @error('assistant_driver_name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label class="form-label" for="spare_name">စပယ်ယာအမည် <span
                            class="text-danger">*</span></label>
                    <input type="text" wire:model="spare_name" class="form-control">
                    @error('spare_name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label class="form-label" for="crew_name">အဖွဲ့ဝင်အမည် <span
                            class="text-danger">*</span></label>
                    <input type="text" wire:model="crew_name" class="form-control">
                    @error('crew_name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label class="form-label" for="driver_phone_number">ကားမောင်းသူဖုန်းနံပါတ် <span
                            class="text-danger">*</span></label>
                    <input type="text" wire:model="driver_phone_number" class="form-control">
                    @error('driver_phone_number')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label class="form-label" for="assistant_driver_phone">အကူကားမောင်းသူဖုန်းနံပါတ်
                        <span class="text-danger">*</span></label>
                    <input type="text" wire:model="assistant_driver_phone" class="form-control">
                    @error('assistant_driver_phone')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label class="form-label" for="spare_phone">စပယ်ယာဖုန်းနံပါတ် <span
                            class="text-danger">*</span></label>
                    <input type="text" wire:model="spare_phone" class="form-control">
                    @error('spare_phone')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label class="form-label" for="crew_phone">အဖွဲ့ဝင်ဖုန်းနံပါတ် <span
                            class="text-danger">*</span></label>
                    <input type="text" wire:model="crew_phone" class="form-control">
                    @error('crew_phone')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group mb-3" wire:ignore>
                    <label class="form-label" for="departure_time">ထွက်မည့်အချိန် <span class="text-danger">*</span></label>
                    <input type="text" name="departure_time" wire:model="departure_time" id="departure_time" class="form-control flatpickr">
                    @error('departure_time')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-3" wire:ignore>
                    <label class="form-label" for="day_off_date">ကားမထွက်မည့်နေ့စွဲ <span class="text-danger">*</span></label>
                    <input type="text" name="day_off_date" wire:model="day_off_date" id="day_off_date" class="form-control flatpickr">
                    @error('day_off_date')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="form-group mb-3 float-end">
            <a href="{{ route('admin.cars.index') }}" class="btn btn-secondary">နောက်သို့</a>
            <button type="submit" class="btn btn-primary">{{ $form_type == 'edit' ? 'ပြုပြင်မည်' : 'ထည့်သွင်းမည်' }}</button>
        </div>
</form>
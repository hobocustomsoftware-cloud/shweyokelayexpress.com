<div class="container-fluid p-2">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $form_type == 'create' ? 'လမ်းတင်ကုန်ပစ္စည်းသွင်းမည်' : 'လမ်းတင်ကုန်ပစ္စည်းပြင်ဆင်မည်' }}</h3>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="{{ $form_type == 'create' ? 'save' : 'update' }}" enctype="multipart/form-data">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group mb-3" >
                            <label class="form-label" for="name">အမည် <span class="text-danger">*</span></label>
                            <input type="text" wire:model="name" class="form-control" id="name" name="name" value="{{ old('name') }}">
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group mb-3" >
                            <label class="form-label" for="phone">ဖုန်းနံပါတ် <span class="text-danger">*</span></label>
                            <input type="text" wire:model="phone" class="form-control" id="phone" name="phone" value="{{ old('phone') }}">
                            @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group mb-3" >
                            <label class="form-label" for="address">လိပ်စာ <span class="text-danger">*</span></label>
                            <textarea wire:model="address" class="form-control" id="address" name="address">{{ old('address') }}</textarea>
                            @error('address') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group mb-3" >
                            <label class="form-label" for="nrc">မှတ်ပုံတင်အမှတ် </label>
                            <input type="text" wire:model="nrc" class="form-control" id="nrc" name="nrc" value="{{ old('nrc') }}">
                            @error('nrc') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3" >
                            <label class="form-label" for="car_id">ကားနံပါတ် <span class="text-danger">*</span></label>
                            <select name="car_id" id="car_id" wire:model="car_id" class="form-select select2">
                                <option value=""></option>
                                @foreach ($cars as $car)
                                <option value="{{ $car->id }}">
                                    {{ old('car_id') == $car->id ? 'selected' : '' }} {{ $car->number }}
                                </option>
                                @endforeach
                            </select>
                            @error('car_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3" >
                            <label class="form-label" for="seat_number">ခုံနံပါတ် <span class="text-danger">*</span></label>
                            <input type="text" wire:model="seat_number" wire:blur="validateSeatNumber" class="form-control" id="seat_number" name="seat_number" value="{{ old('seat_number') }}">
                            @error('seat_number') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group mb-3" >
                            <label class="form-label" for="price">ကျသင့်ငွေ <span class="text-danger">*</span></label>
                            <input type="text" wire:model="price" class="form-control" id="price" name="price" value="{{ old('price') }}">
                            @error('price') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group mb-3" >
                            <label class="form-label" for="voucher_number">ဘောက်ချာ နံပါတ် <span class="text-danger">*</span></label>
                            <input type="text" wire:model="voucher_number" class="form-control" id="voucher_number" name="voucher_number" value="{{ old('voucher_number') }}" readonly>
                            @error('voucher_number') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group mb-3" >
                            <label class="form-label" for="is_paid">ရှင်းပြီး <span class="text-danger">*</span></label>
                            <input type="checkbox" wire:model="is_paid" class="form-check-input" id="is_paid" name="is_paid" value="1" {{ $is_paid ? 'checked' : '' }}>
                            @error('is_paid') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group mb-3" >
                            <label class="form-label" for="status">အခြေအနေ <span class="text-danger">*</span></label>
                            <select name="status" id="status" wire:model="status" class="form-select">
                                <option value="active" selected>အသုံးပြုနေသည်</option>
                                <option value="inactive">အသုံးမပြုတော့ပါ</option>
                            </select>
                            @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group float-end">
                            <button type="button" class="btn btn-sm btn-danger"
                                wire:click="clearForm">ပယ်ဖျက်မည်</button>
                            <button type="button" class="btn btn-sm btn-secondary"
                                wire:click="cancel">နောက်သို့</button>
                            <button type="submit" class="btn btn-sm btn-primary">{{ $form_type == 'create' ? 'ထည့်သွင်းမည်' : 'ပြင်ဆင်မည်' }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
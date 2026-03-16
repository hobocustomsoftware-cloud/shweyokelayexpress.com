<div class="container-fluid p-2">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">လမ်းတင်ကုန်ပစ္စည်းသွင်းမည်</h3>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="save" enctype="multipart/form-data">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <legend class="text-bold mb-3">ပို့သူအချက်အလက်များ</legend>
                        <div class="form-group mb-3" wire:ignore>
                            <label class="form-label" for="s_name">ပို့သူအမည် <span class="text-danger">*</span></label>
                            <select name="s_name" id="s_name" wire:model="s_name" class="form-select select2">
                                <option value="">Select Merchant</option>
                                @foreach ($merchants as $merchant)
                                <option value="{{ $merchant->id }}">
                                    {{ old('s_name') == $merchant->id ? 'selected' : '' }} {{ $merchant->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('s_name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="s_phone">ပို့သူဖုန်းနံပါတ် <span class="text-danger">*</span></label>
                            <input type="text" name="s_phone" wire:model="s_phone" class="form-control" id="s_phone" value="{{ old('s_phone') }}">
                            @error('s_phone') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="s_nrc">ပို့သူမှတ်ပုံတင်အမှတ် </label>
                            <input type="text" wire:model="s_nrc" class="form-control" id="s_nrc" name="s_nrc" value="{{ old('s_nrc') }}">
                            @error('s_nrc') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="s_address">ပို့သူလိပ်စာ <span class="text-danger">*</span></label>
                            <textarea wire:model="s_address" class="form-control" id="s_address" name="s_address">{{ old('s_address') }}</textarea>
                            @error('s_address') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group mb-3" wire:ignore>
                            <label class="form-label" for="from_city">မှ မြို့<span
                                    class="text-danger">*</span></label>
                            <select name="from_city" id="from_city" wire:model="from_city"
                                class="form-select select2">
                                <option value="">Select City</option>
                                @foreach ($cities as $city)
                                <option value="{{ $city->id }}">
                                    {{ old('from_city') === $city->id ? 'selected' : '' }}{{ $city->name_my }}
                                </option>
                                @endforeach
                            </select>
                            @error('from_city')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="from_gate" class="form-label">မှ ဂိတ် <span
                                    class="text-danger">*</span></label>
                            <select name="from_gate" id="from_gate" wire:model="from_gate"
                                class="form-select select2">
                                <option value="">Select Gate</option>
                                @if ($fromGates)
                                @foreach ($fromGates as $gate)
                                <option value="{{ $gate->id }}">
                                    {{ old('from_gate') == $gate->id ? 'selected' : '' }}
                                    {{ $gate->name_my }}
                                </option>
                                @endforeach
                                @endif
                            </select>
                            @error('from_gate')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <legend class="text-bold mb-3">လက်ခံသူအချက်အလက်များ</legend>
                        <div class="form-group mb-3" wire:ignore>
                            <label class="form-label" for="r_name">လက်ခံသူအမည် <span class="text-danger">*</span></label>
                                <select name="r_name" id="r_name" wire:model="r_name" class="form-select select2">
                                <option value="">Select Merchant</option>
                                @foreach ($merchants as $merchant)
                                <option value="{{ $merchant->id }}">
                                    {{ old('r_name') == $merchant->id ? 'selected' : '' }} {{ $merchant->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('r_name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="r_phone">လက်ခံသူဖုန်းနံပါတ် <span class="text-danger">*</span></label>
                            <input type="text" wire:model="r_phone" class="form-control" id="r_phone" name="r_phone" value="{{ old('r_phone') }}">
                            @error('r_phone') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="r_nrc">လက်ခံသူမှတ်ပုံတင်အမှတ် </label>
                            <input type="text" wire:model="r_nrc" class="form-control" id="r_nrc" name="r_nrc" value="{{ old('r_nrc') }}">
                            @error('r_nrc') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="r_address">လက်ခံသူလိပ်စာ <span class="text-danger">*</span></label>
                            <textarea wire:model="r_address" class="form-control" id="r_address" name="r_address">{{ old('r_address') }}</textarea>
                            @error('r_address') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group mb-3" wire:ignore>
                            <label for="to_city_id" class="form-label">လက်ခံမြို့ <span
                                    class="text-danger">*</span></label>
                            <select name="to_city" id="to_city" wire:model="to_city"
                                class="form-select select2">
                                <option value="">Select City</option>
                                @foreach ($cities as $city)
                                <option value="{{ $city->id }}">
                                    {{ old('to_city') == $city->id ? 'selected' : '' }} {{ $city->name_my }}
                                </option>
                                @endforeach
                            </select>
                            @error('to_city')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="to_gate" class="form-label">လက်ခံဂိတ် <span class="text-danger">*</span></label>
                            <select name="to_gate" id="to_gate" wire:model="to_gate"
                                class="form-select select2">
                                <option value="">Select Gate</option>
                                @if ($toGates)
                                @foreach ($toGates as $gate)
                                <option value="{{ $gate->id }}">
                                    {{ old('to_gate') == $gate->id ? 'selected' : '' }}
                                    {{ $gate->name_my }}
                                </option>
                                @endforeach
                                @endif
                            </select>
                            @error('to_gate')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <legend class="text-bold mb-3">ကုန်ပစ္စည်း အချက်အလက်များ</legend>
                        <div class="form-group mb-3">
                            <label class="form-label" for="quantity">အရေအတွက် <span class="text-danger">*</span></label>
                            <input type="number" wire:model="quantity" class="form-control" id="quantity" name="quantity" value="{{ old('quantity') }}">
                            @error('quantity') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="cargotype">အမျိုးအစား <span class="text-danger">*</span></label>
                            <select name="cargotype" id="cargotype" wire:model="cargo_type_id" class="form-select select2">
                                <option value="">Select Cargo Type</option>
                                @foreach ($cargotypes as $cargotype)
                                <option value="{{ $cargotype->id }}">{{ old('cargotype') == $cargotype->id ? 'selected' : '' }} {{ $cargotype->name }}</option>
                                @endforeach
                            </select>
                            @error('cargo_type_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="image">ပုံတင်ရန် <span class="text-danger">*</span></label>
                            <input type="file" wire:model="image" class="form-control" id="image" name="image" accept="image/*">
                            @error('image') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="to_pick_date">ကုန်းရွေးရမည့်ရက် <span class="text-danger">*</span></label>
                            <input type="date" wire:model="to_pick_date" class="form-control flatpickr" id="to_pick_date" name="to_pick_date" value="{{ $to_pick_date }}">
                            @error('to_pick_date') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="voucher_number">ဘောက်ချာ နံပါတ် <span class="text-danger">*</span></label>
                            <input type="text" wire:model="voucher_number" class="form-control text-muted" id="voucher_number" name="voucher_number" value="{{ $voucher_number }}" readonly>
                            @error('voucher_number') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <legend class="text-bold mb-3">ငွေကြေး အချက်အလက်များ</legend>
                        <div class="form-group mb-3">
                            <label class="form-label" for="service_charge">တန်ဆာခ <span class="text-danger">*</span></label>
                            <input type="number" wire:model.lazy="service_charge" class="form-control" id="service_charge" name="service_charge" value="{{ old('service_charge') }}">
                            @error('service_charge') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="is_debt">ကုန်ကြွေး <span class="text-danger">*</span></label>
                            <input type="checkbox" wire:model="is_debt" class="form-check-input" id="is_debt" name="is_debt" value="1">
                            @error('is_debt') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="car_id">ကားပေါ်တင်ရန် <span class="text-danger">*</span></label>
                            <select name="car_id" id="car_id" wire:model="car_id" class="form-select select2">
                                <option value="">Select Car</option>
                                @foreach ($cars as $car)
                                <option value="{{ $car->id }}">
                                    {{ old('car_id') == $car->id ? 'selected' : '' }} {{ $car->number }}
                                </option>
                                @endforeach
                            </select>
                            @error('car_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group float-end">
                            <button type="button" class="btn btn-sm btn-danger" wire:click="clearForm">ပယ်ဖျက်မည်</button>
                            <button type="button" class="btn btn-sm btn-secondary" wire:click="cancel">နောက်သို့</button>
                            <button type="submit" class="btn btn-sm btn-primary">ထည့်သွင်းမည်</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
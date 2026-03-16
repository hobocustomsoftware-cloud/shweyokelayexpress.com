@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="container-fluid p-2">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">ကုန်ပစ္စည်းသွင်းမည်</h3>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="{{($form_type === 'edit') ? 'update' : 'save'}}" enctype="multipart/form-data">
                <input type="hidden" wire:model.defer="cargo_id" value="{{ $cargo_id }}">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <legend class="text-bold mb-3">ပို့သူအချက်အလက်များ</legend>
                        <div class="form-group mb-3" wire:ignore>
                            <label class="form-label" for="s_name">ပို့သူအမည် <span
                                    class="text-danger">*</span></label>
                            <select name="s_name" id="s_name" wire:model="s_name" class="form-select select2">
                                <option value="">Select Sender</option>
                                @if ($form_type === 'edit' && $s_name)
                                <option value="{{ $s_name }}" selected> {{ $s_name }}
                                </option>
                                @endif
                                @foreach ($merchants as $merchant)
                                <option value="{{ $merchant->id }}"> {{ $merchant->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('s_name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="s_phone">ပို့သူဖုန်းနံပါတ် <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="s_phone" wire:model="s_phone" class="form-control"
                                id="s_phone" value="{{ old('s_phone') }}">
                            @error('s_phone')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="s_nrc">ပို့သူမှတ်ပုံတင်အမှတ် <span class="text-danger">*</span></label>
                            <input type="text" wire:model="s_nrc" class="form-control" id="s_nrc" name="s_nrc"
                                value="{{ $s_nrc }}">
                            @error('s_nrc')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="s_address">ပို့သူလိပ်စာ <span
                                    class="text-danger">*</span></label>
                            <textarea wire:model="s_address" class="form-control" id="s_address" name="s_address">{{ old('s_address') }}</textarea>
                            @error('s_address')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3" wire:ignore>
                            <label class="form-label" for="from_city_id">မှ မြို့<span
                                    class="text-danger">*</span></label>
                            <select name="from_city_id" id="from_city_id" wire:model="from_city_id"
                                class="form-select select2">
                                <option value="">Select City</option>
                                @foreach ($cities as $city)
                                <option value="{{ $city->id }}" {{ $from_city_id === $city->id ? 'selected' : '' }}>
                                    {{ $city->name_my }}
                                </option>
                                @endforeach
                            </select>
                            @error('from_city_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="from_gate_id" class="form-label">မှ ဂိတ် <span
                                    class="text-danger">*</span></label>
                            <select name="from_gate_id" id="from_gate_id" wire:model="from_gate_id"
                                class="form-select select2">
                                <option value="">Select Gate</option>
                                @if ($fromGates)
                                @foreach ($fromGates as $gate)
                                <option value="{{ $gate->id }}" {{ $from_gate_id === $gate->id ? 'selected' : '' }}>
                                    {{ $gate->name_my }}
                                </option>
                                @endforeach
                                @endif
                            </select>
                            @error('from_gate_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <legend class="text-bold mb-3">လက်ခံသူအချက်အလက်များ</legend>
                        <div class="form-group mb-3" wire:ignore>
                            <label class="form-label" for="r_name">လက်ခံသူအမည် <span
                                    class="text-danger">*</span></label>
                            <select name="r_name" id="r_name" wire:model="r_name" class="form-select select2">
                                <option value="">Select Receiver</option>
                                @if ($form_type === 'edit' && $r_name)
                                <option value="{{ $r_name }}" {{ $r_name === $merchant->id ? 'selected' : '' }}> {{ $r_name }}
                                </option>
                                @endif
                                @foreach ($merchants as $merchant)
                                <option value="{{ $merchant->id }}">
                                    {{ $merchant->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('r_name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="r_phone">လက်ခံသူဖုန်းနံပါတ် <span
                                    class="text-danger">*</span></label>
                            <input type="text" wire:model="r_phone" class="form-control" id="r_phone"
                                name="r_phone" value="{{ $r_phone }}">
                            @error('r_phone')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="r_nrc">လက်ခံသူမှတ်ပုံတင်အမှတ် <span class="text-danger">*</span></label>
                            <input type="text" wire:model="r_nrc" class="form-control" id="r_nrc"
                                name="r_nrc" value="{{ $r_nrc }}">
                            @error('r_nrc')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="r_address">လက်ခံသူလိပ်စာ <span
                                    class="text-danger">*</span></label>
                            <textarea wire:model="r_address" class="form-control" id="r_address" name="r_address">{{ $r_address }}</textarea>
                            @error('r_address')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3" wire:ignore>
                            <label for="to_city_id" class="form-label">လက်ခံမြို့ <span
                                    class="text-danger">*</span></label>
                            <select name="to_city_id" id="to_city_id" wire:model="to_city_id"
                                class="form-select select2">
                                <option value="">Select City</option>
                                @foreach ($cities as $city)
                                <option value="{{ $city->id }}" {{ $to_city_id === $city->id ? 'selected' : '' }}>
                                    {{ $city->name_my }}
                                </option>
                                @endforeach
                            </select>
                            @error('to_city_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="to_gate_id" class="form-label">လက်ခံဂိတ် <span
                                    class="text-danger">*</span></label>
                            <select name="to_gate_id" id="to_gate_id" wire:model="to_gate_id"
                                class="form-select select2">
                                <option value="">Select Gate</option>
                                @if ($toGates)
                                @foreach ($toGates as $gate)
                                <option value="{{ $gate->id }}" {{ $to_gate_id === $gate->id ? 'selected' : '' }}>
                                    {{ $gate->name_my }}
                                </option>
                                @endforeach
                                @endif
                            </select>
                            @error('to_gate_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label" for="image">ကုန်ပစ္စည်း ပုံတင်ရန် <span class="text-danger">*</span></label>
                            <input type="file" wire:model.live="image" class="form-control" id="image" name="image" accept="{{($form_type === 'edit') ? '' : 'image/*'}}">
                            @if ($image)
                            <img src="{{(is_string($image)) ? public_asset('uploads/' . $image) : $image->temporaryUrl() }}" alt="Cargo Image" class="img-thumbnail my-2">
                            @endif
                            @error('image')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <legend class="text-bold mb-3">ကုန်ပစ္စည်း အချက်အလက်များ</legend>
                                @foreach($items as $index => $item)
                                <div class="card card-body border border-success mb-3 p-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="badge bg-success">ကုန်ပစ္စည်း ({{ $index + 1 }})</span>
                                        @if(count($items) > 1)
                                            <button type="button" class="btn btn-sm btn-danger" wire:click="removeItem({{ $index }})">
                                                <i class="fas fa-trash-alt"></i> ပယ်ဖျက်ရန်
                                            </button>
                                        @endif
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label class="form-label">အရေအတွက် <span class="text-danger">*</span></label>
                                                <input type="number" wire:model="items.{{ $index }}.quantity" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label class="form-label">အမျိုးအစား <span class="text-danger">*</span></label>
                                                <select wire:model="items.{{ $index }}.cargo_type_id" class="form-select select2">
                                                    <option value="">Select Cargo Type</option>
                                                    @foreach ($cargotypes as $cargotype)
                                                        <option value="{{ $cargotype->id }}">{{ $cargotype->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label class="form-label">အမျိုးအစားအသေးစိတ်</label>
                                                <input type="text" wire:model="items.{{ $index }}.detail" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group mb-3">
                                                <label class="form-label">သတိပြုရန်</label>
                                                <input type="text" wire:model="items.{{ $index }}.notice" class="form-control" placeholder="ဥပမာ - ရေမစိုရ">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                        
                                <button type="button" class="btn btn-sm btn-success" wire:click="addItem">
                                    + ကုန်ပစ္စည်း အသစ်ထပ်ထည့်မည်
                                </button>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="to_pick_date">
                                ကုန်ပစ္စည်း ရွေးရမည့်ရက် <span class="text-danger">*</span>
                            </label>
                            <input type="date" wire:model="to_pick_date" class="form-control flatpickr" id="to_pick_date"
                                name="to_pick_date" value="{{ old('to_pick_date') }}">
                            @error('to_pick_date')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="voucher_number">ဘောက်ချာ နံပါတ် <span
                                    class="text-danger">*</span></label>
                            <input type="text" wire:model="voucher_number" class="form-control text-muted"
                                id="voucher_number" name="voucher_number" value="{{ old('voucher_number') }}"
                                readonly>
                            @error('voucher_number')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <legend class="text-bold mb-3">ငွေကြေး အချက်အလက်များ</legend>
                        <div class="form-group mb-3">
                            <label class="form-label" for="service_charge">တန်ဆာခ <span
                                    class="text-danger">*</span></label>
                            <input type="number" wire:model.lazy="service_charge" class="form-control"
                                id="service_charge" name="service_charge" value="{{ old('service_charge') }}">
                            @error('service_charge')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        @if ($is_transit)
                        <div class="form-group mb-3">
                            <label class="form-label" for="transit_fee">တစ်ဆင့်သွားတန်ဆာခ <span
                                    class="text-danger">*</span></label>
                            <input type="number" wire:model.lazy="transit_fee" class="form-control"
                                id="transit_fee" name="transit_fee" value="{{ old('transit_fee') }}">
                            @error('transit_fee')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        @endif
                        <div class="form-group mb-3">
                            <label class="form-label" for="short_deli_fee">ခေါက်တိုကြေး <span
                                    class="text-danger">*</span></label>
                            <input type="number" wire:model.lazy="short_deli_fee" class="form-control"
                                id="short_deli_fee" name="short_deli_fee" value="{{ old('short_deli_fee') }}">
                            @error('short_deli_fee')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="total_fee">ကျသင့်ငွေစုစုပေါင်း <span
                                    class="text-danger">*</span></label>
                            <input type="number" wire:model="total_fee" class="form-control" id="total_fee"
                                name="total_fee" value="{{ old('total_fee') }}" readonly>
                            @error('total_fee')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="border_fee">ဘော်ဒါကြေး <span
                                    class="text-danger">*</span></label>
                            <input type="number" wire:model.lazy="border_fee" class="form-control" id="border_fee"
                                name="border_fee" value="{{ old('border_fee') }}">
                            @error('border_fee')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="total_receive_fee">အသားတင်ရရှိငွေစုစုပေါင်း<span
                                    class="text-danger">*</span></label>
                            <input type="number" wire:model="total_receive_fee" class="form-control"
                                id="total_receive_fee" name="total_receive_fee" value="{{ old('total_receive_fee') }}" readonly>
                            @error('total_receive_fee')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- <div class="form-group mb-3">
                            <label class="form-label" for="is_short_fee_paid">ခေါက်တိုကြေးပေးပြီး <span
                                    class="text-danger">*</span></label>
                            <input type="checkbox" wire:model="is_short_fee_paid" class="form-check-input"
                                id="is_short_fee_paid" name="is_short_fee_paid"
                                value="{{ old('is_short_fee_paid') }}">
                        @error('is_short_fee_paid')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div> --}}
                    <div class="form-group mb-3">
                        <label class="form-label" for="is_debt">ကုန်ကြွေး <span
                                class="text-danger">*</span></label>
                        <input type="checkbox" wire:model="is_debt" class="form-check-input" id="is_debt"
                            name="is_debt" value="1">
                        @error('is_debt')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label" for="is_home">အိမ်အရောက်ပို့ <span
                                class="text-danger">*</span></label>
                        <input type="checkbox" wire:model.live="is_home" class="form-check-input" id="is_home"
                            name="is_home" value="1">
                        @error('is_home')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    @if ($is_home)
                    <div class="form-group mb-3">
                        <label class="form-label" for="final_deli_fee">အိမ်အရောက်ပို့ကြေး <span
                                class="text-danger">*</span></label>
                        <input type="number" wire:model.lazy="final_deli_fee" class="form-control"
                            id="final_deli_fee" name="final_deli_fee" value="{{ old('final_deli_fee') }}">
                        @error('final_deli_fee')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    @endif
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group float-end">
                            <button type="button" class="btn btn-sm btn-danger"
                                wire:click="clearForm">ပယ်ဖျက်မည်</button>
                            <button type="button" class="btn btn-sm btn-secondary"
                                wire:click="cancel">နောက်သို့</button>
                            <button type="submit" class="btn btn-sm btn-primary">{{ $form_type === 'create' ? 'ထည့်သွင်းမည်' : 'ပြုပြင်မည်' }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


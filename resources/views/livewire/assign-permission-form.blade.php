<form wire:submit.prevent="save">
    <div class="row">
        <div class="col-md-4 mb-4">
            <label for="roleSelect" class="form-label">ရာထူးရွေးပါ <span class="text-danger">*</span></label>
            <select class="form-select select2" id="roleSelect" wire:model="selected_role">
                @foreach($roles as $id=>$name)
                <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </select>
            @error('selected_role') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="row row-cols-2 row-cols-md-3">
        @foreach($permissions as $id=>$description)
        <div class="form-group mb-3">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" wire:model="selected_permissions" value="{{ $id }}" id="perm{{ $id }}">
                <label class="form-check-label" for="perm{{ $id }}">{{ $description }}</label>
            </div>
        </div>
        @endforeach
    </div>
    <div class="float-end mb-3">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-secondary">နောက်သို့</a>
        <button type="submit" class="btn btn-sm btn-primary">သိမ်းမည်</button>
    </div>
</form>
<!-- View Button -->
@if ($module != 'passenger_reports' && $module != 'permissions')
<a href="{{ route('admin.' . $module . '.show', $data->id) }}" class="btn btn-sm btn-primary">
    <i class="fa fa-eye"></i>
</a>
@endif
<!-- End View Button -->
<!-- Edit Button -->
@if (Auth::user()->hasRole('Admin') && $module != 'reports' && $module != 'putin_cargos' && $module != 'transit_cargos' && $module != 'passenger_reports')
<a href="{{ route('admin.' . $module . '.edit', $data->id) }}" class="btn btn-sm btn-primary">
    <i class="fa fa-edit"></i>
</a>
@endif
<!-- End Edit Button -->
<!-- Delete Button -->
@if (Auth::user()->hasRole('Admin') && $module != 'reports'&& $module != 'putin_cargos' && $module != 'passenger_reports')
<form id="delete-form{{ $data->id }}" action="{{ route('admin.' . $module . '.destroy', $data->id) }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
<button type="button" onclick="confirmDelete({{ $data->id }})" class="btn btn-sm btn-danger">
    <i class="fa fa-trash"></i>
</button>
@endif
<!-- End Delete Button -->

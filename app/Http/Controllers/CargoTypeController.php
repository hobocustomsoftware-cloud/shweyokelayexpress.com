<?php

namespace App\Http\Controllers;

use App\Models\CargoType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Interfaces\CargoTypeRepositoryInterface;

use App\Http\Controllers\Controller;
use App\Models\Cargo;
use App\Models\City;


class CargoTypeController extends Controller
{
    protected $cargoTypeRepository;
    public function __construct(CargoTypeRepositoryInterface $cargoTypeRepository)
    {
        $this->cargoTypeRepository = $cargoTypeRepository;
    }

    public function index()
    {
        $cargoTypes = $this->cargoTypeRepository->getList();
        return view('admin.cargo_types.index', compact('cargoTypes'));
    }

    public function getCargoTypes(Request $request)
    {
        $cargoTypes = CargoType::where('status', 'active')->get();
        $cities = City::all();

        if ($request->ajax()) {
            $query = Cargo::with([
                'fromCity', 
                'toCity', 
                'sender_merchant', 
                'receiver_merchant', 
                'items.cargoType'
            ]);

            return DataTables::of($query)
                ->addIndexColumn()
                // ပို့သူအမည် (အမည်မရှိရင် ဖုန်းနံပါတ်ပြပါမယ်)
                ->addColumn('s_name', function ($row) {
                    if ($row->sender_merchant && !empty($row->sender_merchant->name)) {
                        return $row->sender_merchant->name;
                    }
                    return !empty($row->s_name_string) ? $row->s_name_string : ($row->s_phone ?: '-');
                })
                // လက်ခံသူအမည်
                ->addColumn('r_name', function ($row) {
                    if ($row->receiver_merchant && !empty($row->receiver_merchant->name)) {
                        return $row->receiver_merchant->name;
                    }
                    return !empty($row->r_name_string) ? $row->r_name_string : ($row->r_phone ?: '-');
                })
                ->addColumn('cargo_no', function($row) { 
                    return $row->cargo_no ?: '-'; 
                })
                ->addColumn('from', function ($row) { 
                    return $row->fromCity ? $row->fromCity->name_my : '-'; 
                })
                ->addColumn('to', function ($row) { 
                    return $row->toCity ? $row->toCity->name_my : '-'; 
                })
                ->addColumn('cargo_type', function ($row) {
                    if ($row->items && $row->items->count() > 0) {
                        return $row->items->map(function($item) {
                            return ($item->cargoType) ? $item->cargoType->name : 'N/A';
                        })->unique()->implode(', ');
                    }
                    return 'N/A';
                })
                ->editColumn('created_at', function($row) { 
                    return $row->created_at ? $row->created_at->format('d/m/Y') : '-'; 
                })
                ->editColumn('status', function ($row) {
                    return '<span class="badge bg-primary">စာရင်းသွင်းပြီး</span>';
                })
                ->addColumn('action', function ($row) {
                    return '<a href="' . route('admin.cargos.show', $row->id) . '" class="btn btn-sm btn-info text-white"><i class="fas fa-eye"></i></a>';
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        return view('admin.cargo_types.index', compact('cargoTypes', 'cities'));
    }
            

    public function create()
    {
        return view('admin.cargo_types.create');
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string|max:255',
        ]);
        try {
            DB::beginTransaction();
            $this->cargoTypeRepository->createCargoType($validate);
            DB::commit();
            return redirect()->route('admin.cargo_types.index')->with('success', 'Cargo type created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.cargo_types.index')->with('error', 'Cargo type creation failed');
        }
    }

    public function edit($id)
    {
        $cargoType = $this->cargoTypeRepository->getCargoTypeById($id);
        return view('admin.cargo_types.edit', compact('cargoType'));
    }

    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string|max:255',
        ]);
        try {
            DB::beginTransaction();
            $this->cargoTypeRepository->updateCargoType($id, $validate);
            DB::commit();
            return redirect()->route('admin.cargo_types.index')->with('success', 'Cargo type updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.cargo_types.index')->with('error', 'Cargo type update failed');
        }
    }

    public function destroy($id)
    {
        $this->cargoTypeRepository->deleteCargoType($id);
        return redirect()->route('admin.cargo_types.index')->with('success', 'Cargo type deleted successfully');
    }
}

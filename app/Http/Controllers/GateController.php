<?php

namespace App\Http\Controllers;

use App\Models\Gate;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Repositories\Interfaces\CityRepositoryInterface;
use App\Repositories\Interfaces\GateRepositoryInterface;

class GateController extends Controller
{
    protected $gateRepository;
    protected $cityRepository;
    public function __construct(GateRepositoryInterface $gateRepository, CityRepositoryInterface $cityRepository)
    {
        $this->gateRepository = $gateRepository;
        $this->cityRepository = $cityRepository;
    }

    public function index()
    {
        $cities = $this->cityRepository->getAllCities();
        return view('admin.gates.index', compact('cities'));
    }

    public function getGates(Request $request)
    {
        if ($request->ajax()) {
            $gates = $this->gateRepository->getList();
            if ($request->has('city_id') && $request->city_id != '') {
                $gates = $gates->where('city_id', $request->city_id);
            }
            return DataTables::of($gates)
                ->addIndexColumn()
                ->addColumn('city_name', function ($gate) {
                    return $gate->city ? $gate->city->name_my : '';
                })
                ->addColumn('action', function ($gate) {
                    return '<a href="' . route('admin.gates.edit', $gate->id) . '" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                    <form id="delete-form-' . $gate->id . '" action="' . route('admin.gates.destroy', $gate->id) . '" method="POST" style="display: none;">
                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                        <input type="hidden" name="_method" value="DELETE">
                    </form>
                    <button onclick="confirmDelete(' . $gate->id . ')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return redirect()->back()->with('error', 'Invalid request');
    }

    public function create()
    {
        $cities = $this->cityRepository->getAllCities();
        return view('admin.gates.create', compact('cities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_my' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
            'description' => 'nullable|string',
            'is_main' => 'nullable|in:0,1',
            'is_transit' => 'nullable|in:0,1',
        ]);

        $this->gateRepository->createGate($request->all());

        return redirect()->route('admin.gates.index')->with('success', 'ဂိတ်ထည့်သွင်းပြီးပြီ');
    }

    public function edit($id)
    {
        $gate = $this->gateRepository->getGateById($id);
        $cities = $this->cityRepository->getAllCities();
        return view('admin.gates.edit', compact('gate', 'cities'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name_my' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
            'description' => 'nullable|string',
            'is_main' => 'nullable|in:0,1',
            'is_transit' => 'nullable|in:0,1',
        ]);

        $this->gateRepository->updateGate($id, $request->all());

        return redirect()->route('admin.gates.index')->with('success', 'ဂိတ်ထည့်သွင်းပြီးပြီ');
    }

    public function destroy($id)
    {
        $this->gateRepository->deleteGate($id);
        return redirect()->route('admin.gates.index')->with('success', 'ဂိတ်ဖျက်ပြီးပြီ');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreCityRequest;
use App\Http\Requests\UpdateCityRequest;
use Illuminate\Validation\ValidationException;
use App\Repositories\Interfaces\CityRepositoryInterface;

class CityController extends Controller
{
    protected $cityRepository;
    public function __construct(CityRepositoryInterface $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    public function index()
    {
        return view('admin.cities.index');
    }

    public function getCities(Request $request)
    {
        if ($request->ajax()) {
            $cities = $this->cityRepository->getList();
            return DataTables::of($cities)
                ->addIndexColumn()
                ->addColumn('action', function ($city) {
                    return '<a href="' . route('admin.cities.edit', $city->id) . '" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                <form id="delete-form' . $city->id . '" action="' . route('admin.cities.destroy', $city->id) . '" method="POST" style="display: none;">
                <input type="hidden" name="_token" value="' . csrf_token() . '">
                <input type="hidden" name="_method" value="DELETE">
                </form>
                <button type="submit" onclick="confirmDelete(' . $city->id . ')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return redirect()->back()->with('error', 'Invalid request');
    }

    public function create()
    {
        return view('admin.cities.create');
    }

    public function store(StoreCityRequest $request)
    {
        try {
            DB::beginTransaction();
            $validated = $request->validated();
            $city = $this->cityRepository->createCity($validated);
            if ($city) {
                DB::commit();
                return redirect()->route('admin.cities.index')->with('success', 'City created successfully');
            }
            return redirect()->back()->with('error', 'City not created');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        $city = $this->cityRepository->getCityById($id);
        if (!$city) {
            return redirect()->back()->with('error', 'City not found');
        }
        return view('admin.cities.show', compact('city'));
    }

    public function edit($id)
    {
        $city = $this->cityRepository->getCityById($id);
        if (!$city) {
            return redirect()->back()->with('error', 'City not found');
        }
        return view('admin.cities.edit', compact('city'));
    }

    public function update(UpdateCityRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $validated = $request->validated();
            $city = $this->cityRepository->updateCity($id, $validated);
            if ($city) {
                DB::commit();
                return redirect()->route('admin.cities.index')->with('success', 'City updated successfully');
            }
            return redirect()->back()->with('error', 'City not updated');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $city = $this->cityRepository->deleteCity($id);
            if ($city) {
                DB::commit();
                return redirect()->route('admin.cities.index')->with('success', 'City deleted successfully');
            }
            return redirect()->back()->with('error', 'City not deleted');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}

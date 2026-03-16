<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Interfaces\MerchantRepositoryInterface;

class MerchantController extends Controller
{
    protected $merchantRepository;
    public function __construct(MerchantRepositoryInterface $merchantRepository)
    {
        $this->merchantRepository = $merchantRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $merchants = $this->merchantRepository->getList();
        if (!isset($merchants)) {
            return redirect()->route('admin.merchants.index')->with('message', 'No merchants.');
        }
        return view('admin.merchants.index', compact('merchants'));
    }

    /**
     * Get a listing of the resource.
     */
    public function getMerchants(Request $request)
    {
        $merchants = $this->merchantRepository->getList();
        if ($request->ajax()) {
            return DataTables::of($merchants)
                ->addIndexColumn()
                ->addColumn('action', function ($merchant) {
                    return '
                <a href="' . route('admin.merchants.edit', $merchant->id) . '" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                <form id="delete-form' . $merchant->id . '" action="' . route('admin.merchants.destroy', $merchant->id) . '" method="POST" style="display: none;">
                <input type="hidden" name="_token" value="' . csrf_token() . '">
                <input type="hidden" name="_method" value="DELETE">
                </form>
                <button type="submit" onclick="confirmDelete(' . $merchant->id . ')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return redirect()->back()->with('error', 'Invalid request');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.merchants.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:50',
            'phone' => 'required|max:11',
            'nrc' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:50',
        ]);

        $merchant = $this->merchantRepository->create($validated);
        if (!isset($merchant)) {
            return redirect()->route('admin.merchants.index')->with('error', 'Create failed.');
        }
        return redirect()->route('admin.merchants.index')->with('success', 'Create successful.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $merchant = $this->merchantRepository->findById($id);
        if (!isset($merchant)) {
            return redirect()->route('admin.merchants.index')->with('message', 'No merchant.');
        }
        return view('admin.merchants.edit', compact('merchant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|max:50',
            'phone' => 'required|max:11',
            'nrc' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:50',
        ]);
        $merchant = $this->merchantRepository->update($id, $validated);
        if (!isset($merchant)) {
            return redirect()->route('admin.merchants.index')->with('error', 'Update failed.');
        }
        return redirect()->route('admin.merchants.index')->with('success', 'Update successful.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $merchant = $this->merchantRepository->delete($id);
        if (!isset($merchant)) {
            return redirect()->route('admin.merchants.index')->with('error', 'Delete failed.');
        }
        return redirect()->route('admin.merchants.index')->with('success', 'Delete successful.');
    }
}

<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\QrCodeService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreCargoRequest;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Interfaces\CityRepositoryInterface;
use App\Repositories\Interfaces\GateRepositoryInterface;
use App\Repositories\Interfaces\CargoRepositoryInterface;
use App\Repositories\Interfaces\CargoTypeRepositoryInterface;

class AdminCargoController extends Controller
{
    protected $cargoRepository;
    protected $cityRepository;
    protected $cargoTypeRepository;
    protected $gateRepository;
    protected $qrcodeService;

    public function __construct(CargoRepositoryInterface $cargoRepository, CityRepositoryInterface $cityRepository, CargoTypeRepositoryInterface $cargoTypeRepository, GateRepositoryInterface $gateRepository, QrCodeService $qrcodeService)
    {
        $this->cargoRepository = $cargoRepository;
        $this->cityRepository = $cityRepository;
        $this->cargoTypeRepository = $cargoTypeRepository;
        $this->gateRepository = $gateRepository;
        $this->qrcodeService = $qrcodeService;
    }

    /**
     * Show cargos index
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $cities = $this->cityRepository->getAllCities();
        $cargoTypes = $this->cargoTypeRepository->getAllCargoTypes();
        $cargos = $this->cargoRepository->getQuery();
        return view('admin.cargos.index', compact('cities', 'cargoTypes'));
    }

    /**
     * Get cargos
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    // public function getCargos(Request $request)
    // {
    //     $cargos = $this->cargoRepository->getQuery();
    //     if ($request->ajax()) {
    //         return DataTables::of($cargos)
    //             ->addIndexColumn()
    //             ->filter(function ($query) use ($request) {
    //                 if ($request->has('delivery_type') && $request->get('delivery_type') != '') {
    //                     $query->where('delivery_type', $request->get('delivery_type'));
    //                 }
    //                 if ($request->has('from_city_id') && $request->get('from_city_id') != '') {
    //                     $query->where('from_city_id', $request->get('from_city_id'));
    //                 }
    //                 if ($request->has('cargo_no') && $request->get('cargo_no') != '') {
    //                     $query->where('cargo_no', 'like', "%{$request->get('cargo_no')}%");
    //                 } // new
    //                 if ($request->has('to_city_id') && $request->get('to_city_id') != '') {
    //                     $query->where('to_city_id', $request->get('to_city_id'));
    //                 }
    //                 if ($request->has('cargo_type_id') && $request->get('cargo_type_id') != '') {
    //                     $query->where('cargo_type_id', $request->get('cargo_type_id'));
    //                 }
    //                 if ($request->has('status') && $request->get('status') != '') {
    //                     $query->where('status', $request->get('status'));
    //                 }
    //                 if ($request->has('daterange') && $request->get('daterange') != '') {
    //                     $daterange = explode(' - ', $request->get('daterange'));
    //                     $start = Carbon::parse($daterange[0])->startOfDay();
    //                     $end = Carbon::parse($daterange[1])->endOfDay();
    //                     $query->whereBetween('created_at', [$start, $end]);
    //                 }
    //                 if ($request->has('cargo_no') && $request->get('cargo_no') != '') {
    //                     $query->where('cargo_no', $request->get('cargo_no'));
    //                 }
    //             })
    //             ->addColumn('action', function ($cargo) {
    //                 $edit = '';
    //                 $delete = '';
    //                 if (Auth::user()->hasRole('Admin')) {
    //                     $edit = '<a href="' . route('admin.cargos.edit', [$cargo->id, 'form_type' => 'edit']) . '" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>';
    //                     $delete = '
    //                     <form id="delete-form' . $cargo->id . '" action="' . route('admin.cargos.destroy', $cargo->id) . '" method="POST" style="display: none;">
    //             <input type="hidden" name="_token" value="' . csrf_token() . '">
    //             <input type="hidden" name="_method" value="DELETE">
    //             </form>
    //             <button type="submit" onclick="confirmDelete(' . $cargo->id . ')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
    //                     ';
    //                 }
    //                 return '
    //                 <div class="d-flex justify-content-center gap-2">
    //                 <a href="' . route('admin.cargos.show', $cargo->id) . '" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a>
    //                 ' . $edit . '
    //                 ' . $delete . '
    //                 </div>
    //                 ';
    //             })
                
    //             ->addColumn('delivery_type', function ($cargo) {
    //                 return $cargo->delivery_type == 'home' ? 'အိမ်အရောက်' : 'ဂိတ်ရောက်';
    //             })
    //             // ->addColumn('cargo_type', function ($cargo) {
    //             //     return $cargo->cargoType->name;
    //             // })
    //             // app/Http/Controllers/Admin/AdminCargoController.php ထဲက getCargos function ထဲမှာ ရှာပြင်ပါ
    //             ->addColumn('cargo_type', function ($cargo) {
    //                 // ကုန်ပစ္စည်းအားလုံးရဲ့ နာမည်တွေကို ကော်မာ (,) ခံပြီး ပြပါမယ်
    //                 return $cargo->items->map(function($item) {
    //                     return $item->cargoType->name ?? 'အထွေထွေ';
    //                 })->join(', ');
    //             })
    //             ->addColumn('from', function ($cargo) {
    //                 return $cargo->fromCity->name_my . ',' . $cargo->fromGate->name_my;
    //             })
    //             ->addColumn('to', function ($cargo) {
    //                 return $cargo->toCity->name_my . ',' . $cargo->toGate->name_my;
    //             })
    //             ->addColumn('s_name', function ($cargo) {
    //                 return $cargo->sender_merchant->name ?? $cargo->s_name_string;
    //             })
    //             ->addColumn('r_name', function ($cargo) {
    //                 return $cargo->receiver_merchant->name ?? $cargo->r_name_string;
    //             })
    //             ->addColumn('status', function ($cargo) {
    //                 return $this->getCargoStatusMM($cargo->status);
    //             })
    //             ->addColumn('created_at', function ($cargo) {
    //                 return Carbon::parse($cargo->created_at)->format('d/m/Y');
    //             })
    //             ->rawColumns(['action'])
    //             ->make(true);
    //     }
    //     return view('admin.cargos.index');
    // }
    public function getCargos(Request $request)
    {
        // Relationship များကိုပါ တစ်ခါတည်း ဆွဲထုတ်ပါ (Eager Loading) 
        // ဒါမှ Table list ပြတဲ့အခါ Speed မြန်ပြီး Error မတက်မှာပါ
        $cargos = $this->cargoRepository->getQuery()->with(['items.cargoType', 'fromCity', 'toCity', 'fromGate', 'toGate', 'sender_merchant', 'receiver_merchant']);
    
        if ($request->ajax()) {
            return DataTables::of($cargos)
                ->addIndexColumn()
                ->filter(function ($query) use ($request) {
                    if ($request->filled('delivery_type')) {
                        $query->where('delivery_type', $request->get('delivery_type'));
                    }
                    if ($request->filled('from_city_id')) {
                        $query->where('from_city_id', $request->get('from_city_id'));
                    }
                    if ($request->filled('to_city_id')) {
                        $query->where('to_city_id', $request->get('to_city_id'));
                    }
                    if ($request->filled('cargo_no')) {
                        $query->where('cargo_no', 'like', "%{$request->get('cargo_no')}%");
                    }
                    if ($request->filled('status')) {
                        $query->where('status', $request->get('status'));
                    }
                    if ($request->filled('daterange')) {
                        $daterange = explode(' - ', $request->get('daterange'));
                        $start = Carbon::parse($daterange[0])->startOfDay();
                        $end = Carbon::parse($daterange[1])->endOfDay();
                        $query->whereBetween('created_at', [$start, $end]);
                    }
                })
                ->addColumn('action', function ($cargo) {
                    $edit = '';
                    $delete = '';
                    if (Auth::user()->hasRole('Admin')) {
                        $edit = '<a href="' . route('admin.cargos.edit', [$cargo->id, 'form_type' => 'edit']) . '" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>';
                        $delete = '<button type="button" onclick="confirmDelete(' . $cargo->id . ')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>';
                    }
                    return '<div class="d-flex justify-content-center gap-2">
                                <a href="' . route('admin.cargos.show', $cargo->id) . '" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a>
                                ' . $edit . $delete . '
                            </div>';
                })
                ->addColumn('delivery_type', function ($cargo) {
                    return $cargo->delivery_type == 'home' ? 'အိမ်အရောက်' : 'ဂိတ်ရောက်';
                })
                ->addColumn('cargo_type', function ($cargo) {
                    // ကုန်ပစ္စည်းအားလုံးကို ကော်မာခံပြီးပြပါမည်
                    return $cargo->items->map(function($item) {
                        return $item->cargoType->name ?? 'အထွေထွေ';
                    })->join(', ') ?: 'အထွေထွေ';
                })
                ->addColumn('from', function ($cargo) {
                    // Null Check ထည့်ထားပါတယ် (City သို့မဟုတ် Gate မရှိရင် error မတက်အောင်ပါ)
                    $city = $cargo->fromCity->name_my ?? '-';
                    $gate = $cargo->fromGate->name_my ?? '-';
                    return $city . ' / ' . $gate;
                })
                ->addColumn('to', function ($cargo) {
                    $city = $cargo->toCity->name_my ?? '-';
                    $gate = $cargo->toGate->name_my ?? '-';
                    return $city . ' / ' . $gate;
                })
                ->addColumn('s_name', function ($row) {
                if ($row->sender_merchant && !empty($row->sender_merchant->name)) {
                    return $row->sender_merchant->name;
                }
                return !empty($row->s_name_string) ? $row->s_name_string : ($row->s_phone ?: '-');
                })
                // လက်ခံသူ အမည်
                ->addColumn('r_name', function ($row) {
                    if ($row->receiver_merchant && !empty($row->receiver_merchant->name)) {
                        return $row->receiver_merchant->name;
                    }
                    return !empty($row->r_name_string) ? $row->r_name_string : ($row->r_phone ?: '-');
                })
                // ->addColumn('s_name', function ($cargo) {
                //     // Merchant အမည် သို့မဟုတ် String အမည် တစ်ခုခုပေါ်အောင်လုပ်ထားပါတယ်
                //     return $cargo->sender_merchant->name ?? $cargo->s_name_string ?? '-';
                // })
                // ->addColumn('r_name', function ($cargo) {
                //     return $cargo->receiver_merchant->name ?? $cargo->r_name_string ?? '-';
                // })
                ->addColumn('status', function ($cargo) {
                    return $this->getCargoStatusMM($cargo->status);
                })
                ->addColumn('created_at', function ($cargo) {
                    return $cargo->created_at ? $cargo->created_at->format('d/m/Y') : '-';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.cargos.index');
    }

    /**
     * Create cargo
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function create(Request $request)
    {
        return view('admin.cargos.create', ['form_type' => 'create']);
    }

    public function store()
    {
        // 
    }

    /**
     * Edit cargo
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Contracts\View\View
     */
    // public function edit(Request $request, $id)
    // {
    //     if (!$id && !$request->get('form_type')) {
    //         return redirect()->route('admin.cargos.index');
    //     }
    //     return view('admin.cargos.edit', ['form_type' => 'edit', 'cargo_id' => $id]);
    // }
    // public function edit(Request $request, $id)
    // {
    //     // ID မပါလျှင် index သို့ ပြန်ပို့မည်
    //     if (!$id) {
    //         return redirect()->route('admin.cargos.index');
    //     }
    
    //     // Repository မှတစ်ဆင့် ဒေတာဆွဲထုတ်ရန်
    //     $cargo = $this->cargoRepository->getCargoById($id);
    
    //     if (!$cargo) {
    //         return redirect()->route('admin.cargos.index')->with('error', 'Cargo not found');
    //     }
    
    //     // လိုအပ်သော ဒေတာများကို ဆွဲထုတ်ရန် (ဥပမာ- မြို့များ၊ ဂိတ်များ)
    //     $cities = \App\Models\City::all();
    //     $gates = \App\Models\Gate::all();
    //     $cargo_types = \App\Models\CargoType::all();
    
    //     return view('admin.cargos.edit', [
    //         'form_type' => 'edit', 
    //         'cargo' => $cargo, // ဒေတာအဟောင်းများကို ပြရန်
    //         'cities' => $cities,
    //         'gates' => $gates,
    //         'cargo_types' => $cargo_types
    //     ]);
    // }
    /**
     * Edit cargo
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Request $request, $id)
    {
        // 1. ID မပါရင် Index ကို ပြန်ပို့မယ်
        if (!$id) {
            return redirect()->route('admin.cargos.index');
        }

        // 2. Repository ကနေ Cargo ဒေတာကို ရှာမယ်
        $cargo = $this->cargoRepository->getCargoById($id);

        // 3. Cargo မရှိရင် Error message နဲ့ Index ကို ပြန်ပို့မယ်
        if (!$cargo) {
            return redirect()->route('admin.cargos.index')->with('error', 'Cargo not found');
        }

        // 4. လိုအပ်တဲ့ Data တွေအကုန်လုံးကို View ဆီ ပို့ပေးမယ်
        // သတိပြုရန်- 'cargo_id' variable အမည်ကို Blade ထဲမှာ သုံးထားတဲ့အတွက် အတိအကျ ပို့ပေးရပါမယ်
        return view('admin.cargos.edit', [
            'form_type'   => 'edit',
            'cargo_id'    => $id,
            'cargo'       => $cargo,
            'cities'      => \App\Models\City::all(),
            'gates'       => \App\Models\Gate::all(),
            'cargo_types' => \App\Models\CargoType::all()
        ]);
    }
    
    // public function destroy($id)
    // {
    //     $cargo = $this->cargoRepository->getCargoById($id);
    //     if (!$cargo) {
    //         return redirect()->route('admin.cargos.index')->with('error', 'Cargo not found');
    //     }
    
    //     // Soft Delete သို့မဟုတ် ပုံမှန် Delete လုပ်ဆောင်ချက်
    //     $this->cargoRepository->deleteCargo($cargo); 
        
    //     return redirect()->route('admin.cargos.index')->with('success', 'Cargo deleted successfully');
    // }
    public function destroy($id)
    {
        // ၁။ ဒေတာ ရှိမရှိ စစ်မယ်
        $cargo = $this->cargoRepository->getCargoById($id);
        
        if (!$cargo) {
            return redirect()->route('admin.cargos.index')->with('error', 'ကုန်ပစ္စည်း ရှာမတွေ့ပါ။');
        }
    
        try {
            // ၂။ ဖျက်မယ်
            $this->cargoRepository->deleteCargo($cargo);
            
            // ၃။ အောင်မြင်ကြောင်း Message နဲ့အတူ Index ကို ပြန်ပို့မယ်
            return redirect()->route('admin.cargos.index')->with('success', 'ကုန်ပစ္စည်းကို အောင်မြင်စွာ ဖျက်သိမ်းပြီးပါပြီ။');
        } catch (\Exception $e) {
            // Error တစ်ခုခု တက်ရင် ပြမယ်
            return redirect()->route('admin.cargos.index')->with('error', 'ဖျက်၍မရပါ- ' . $e->getMessage());
        }
    }

    /**
     * Show cargo details
     * @param int $id
     * @return \Illuminate\Contracts\View\View
     */
    // public function show($id)
    // {
    //     $user = Auth::user();
    //     $cargo = $this->cargoRepository->getCargoById($id);
    //     if (!$cargo) {
    //         return redirect()->route('admin.cargos.index');
    //     }
    //     $cargo_image = null;
    //     if ($cargo->media) {
    //         $cargo_image = $cargo->media->path;
    //         $cargo_image = str_replace('\\', '/', $cargo_image);
    //         $cargo_image = 'uploads/' . $cargo_image;
    //     }
    //     $entry_date = Carbon::parse($cargo->created_at)->format('d/m/Y');
    //     $to_take_date = Carbon::parse($cargo->to_pick_date)->format('d/m/Y');
    //     $delivery_type = $cargo->delivery_type == 'home' ? 'အိမ်အရောက်' : 'ဂိတ်ရောက်';
    //     $service_charge = number_format($cargo->service_charge, 2);
    //     $transit_fee = number_format($cargo->transit_fee, 2);
    //     $short_deli_fee = number_format($cargo->short_deli_fee, 2);
    //     $final_deli_fee = number_format($cargo->final_deli_fee, 2);
    //     $total_fee = number_format($cargo->total_fee, 2);
    //     $border_fee = number_format($cargo->border_fee, 2);
    //     $cargo_status = $this->getCargoStatusMM($cargo->status);
    //     if ($cargo->qrcode_image) {
    //         $qrcode_image = $cargo->qrcode_image;
    //     } else {
    //         $qrcode_image = null;
    //     }
    //     return view('admin.cargos.show', compact('cargo', 'user', 'entry_date', 'to_take_date', 'delivery_type', 'service_charge', 'transit_fee', 'short_deli_fee', 'final_deli_fee', 'border_fee', 'total_fee', 'cargo_status', 'qrcode_image', 'cargo_image'));
    // }
    // public function show($id)
    // {
    //     $user = Auth::user();
        
    //     // items နှင့် cargoType relationship များကိုပါ တစ်ခါတည်း ဆွဲထုတ်ပါ (Eager Loading)
    //     // ဒါမှသာ 500 error မတက်ဘဲ ကုန်ပစ္စည်းအားလုံးကို loop ပတ်ပြနိုင်မှာပါ
    //     $cargo = \App\Models\Cargo::with(['items.cargoType', 'fromCity', 'toCity', 'fromGate', 'toGate'])->find($id);
    
    //     if (!$cargo) {
    //         return redirect()->route('admin.cargos.index');
    //     }
    
    //     $cargo_image = null;
    //     if ($cargo->media) {
    //         $cargo_image = $cargo->media->path;
    //         $cargo_image = str_replace('\\', '/', $cargo_image);
    //         $cargo_image = 'uploads/' . $cargo_image;
    //     }
    
    //     // ရက်စွဲ format များ
    //     $entry_date = $cargo->created_at ? Carbon::parse($cargo->created_at)->format('d/m/Y') : '-';
    //     $to_take_date = $cargo->to_pick_date ? Carbon::parse($cargo->to_pick_date)->format('d/m/Y') : '-';
        
    //     // ပို့ဆောင်မှုအမျိုးအစား
    //     $delivery_type = $cargo->delivery_type == 'home' ? 'အိမ်အရောက်' : 'ဂိတ်ရောက်';
    
    //     // ငွေကြေး format များ
    //     $service_charge = number_format($cargo->service_charge, 2);
    //     $transit_fee    = number_format($cargo->transit_fee, 2);
    //     $short_deli_fee = number_format($cargo->short_deli_fee, 2);
    //     $final_deli_fee = number_format($cargo->final_deli_fee, 2);
    //     $total_fee      = number_format($cargo->total_fee, 2);
    //     $border_fee     = number_format($cargo->border_fee, 2);
    
    //     // ပစ္စည်းအခြေအနေ (မြန်မာစာ)
    //     $cargo_status = $this->getCargoStatusMM($cargo->status);
    
    //     // QR Code
    //     $qrcode_image = $cargo->qrcode_image ?: null;
    
    //     // ပို့သူ/လက်ခံသူ အမည်များ (Merchant မရှိရင် string ကို ယူသုံးရန်)
    //     $s_name = $cargo->sender_merchant->name ?? $cargo->s_name_string ?? '-';
    //     $r_name = $cargo->receiver_merchant->name ?? $cargo->r_name_string ?? '-';
    
    //     return view('admin.cargos.show', compact(
    //         'cargo', 
    //         'user', 
    //         'entry_date', 
    //         'to_take_date', 
    //         'delivery_type', 
    //         'service_charge', 
    //         'transit_fee', 
    //         'short_deli_fee', 
    //         'final_deli_fee', 
    //         'border_fee', 
    //         'total_fee', 
    //         'cargo_status', 
    //         'qrcode_image', 
    //         'cargo_image',
    //         's_name',
    //         'r_name'
    //     ));
    // }
    public function show($id)
    {
        $user = Auth::user();
        
        // Cargo Type နှင့် အခြားလိုအပ်သော Relationship များကို တစ်ခါတည်း ဆွဲထုတ်ရန် (Eager Loading)
        $cargo = \App\Models\Cargo::with([
            'cargoType', 
            'items.cargoType', 
            'fromCity', 
            'toCity', 
            'fromGate', 
            'toGate',
            'sender_merchant',
            'receiver_merchant',
            'media'
        ])->find($id);
    
        if (!$cargo) {
            return redirect()->route('admin.cargos.index');
        }
    
        // ပစ္စည်းပုံ လမ်းကြောင်း စစ်ဆေးခြင်း
        $cargo_image = null;
        if ($cargo->media) {
            $cargo_image = $cargo->media->path;
            $cargo_image = str_replace('\\', '/', $cargo_image);
            $cargo_image = 'uploads/' . $cargo_image;
        }
    
        // ရက်စွဲ Format များ
        $entry_date = $cargo->created_at ? \Carbon\Carbon::parse($cargo->created_at)->format('d/m/Y') : '-';
        $to_take_date = $cargo->to_pick_date ? \Carbon\Carbon::parse($cargo->to_pick_date)->format('d/m/Y') : '-';
        
        // ပို့ဆောင်မှုအမျိုးအစား (မြန်မာစာ)
        $delivery_type = $cargo->delivery_type == 'home' ? 'အိမ်အရောက်' : 'ဂိတ်ရောက်';
    
        // ငွေကြေး Format များ
        $service_charge = number_format($cargo->service_charge, 2);
        $transit_fee    = number_format($cargo->transit_fee, 2);
        $short_deli_fee = number_format($cargo->short_deli_fee, 2);
        $final_deli_fee = number_format($cargo->final_deli_fee, 2);
        $total_fee      = number_format($cargo->total_fee, 2);
        $border_fee     = number_format($cargo->border_fee, 2);
    
        // ပစ္စည်းအခြေအနေ (မြန်မာစာ)
        $cargo_status = $this->getCargoStatusMM($cargo->status);
    
        // QR Code
        $qrcode_image = $cargo->qrcode_image ?: null;
    
        // ပို့သူ/လက်ခံသူ အမည်များ (Merchant မရှိလျှင် string ကို ယူသုံးရန်)
        $s_name = $cargo->sender_merchant->name ?? $cargo->s_name_string ?? '-';
        $r_name = $cargo->receiver_merchant->name ?? $cargo->r_name_string ?? '-';
    
        return view('admin.cargos.show', compact(
            'cargo', 
            'user', 
            'entry_date', 
            'to_take_date', 
            'delivery_type', 
            'service_charge', 
            'transit_fee', 
            'short_deli_fee', 
            'final_deli_fee', 
            'border_fee', 
            'total_fee', 
            'cargo_status', 
            'qrcode_image', 
            'cargo_image',
            's_name',
            'r_name'
        ));
    }

    /**
     * Get cargo status with Myanmar language
     */
    protected function getCargoStatusMM($type)
    {
        switch ($type) {
            case 'registered':
                return 'စာရင်းသွင်းပြီး';
                break;
            case 'delivered':
                return 'ပို့ပြီး';
                break;
            case 'taken':
                return 'ရွေးပြီး';
                break;
            case 'lost':
                return 'ပျောက်ဆုံး';
                break;
            case 'deleted':
                return 'ပယ်ဖျက်ပြီး';
                break;
            default:
                return '';
                break;
        }
    }

    /**
     * Delete cargo
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    // public function destroy($id)
    // {
    //     $cargo = $this->cargoRepository->getCargoById($id);
    //     if (!$cargo) {
    //         return redirect()->route('admin.cargos.index')->with('error', 'Cargo not found');
    //     }
    //     $cargo->delete();
    //     return redirect()->route('admin.cargos.index')->with('success', 'Cargo deleted successfully');
    // }

    /**
     * Print voucher
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function printVoucher($id)
    {
        $user = Auth::user();
        $cargo = $this->cargoRepository->getCargoById($id);
        if (!$cargo) {
            return redirect()->route('admin.cargos.index');
        }
        $cargo_image = null;
        if ($cargo->media) {
            $cargo_image = $cargo->media->path;
            $cargo_image = str_replace('\\', '/', $cargo_image);
            $cargo_image = 'uploads/' . $cargo_image;
        }
        $entry_date = Carbon::parse($cargo->created_at)->format('d/m/Y');
        $to_take_date = Carbon::parse($cargo->to_pick_date)->format('d/m/Y');
        $delivery_type = $cargo->delivery_type == 'home' ? 'အိမ်အရောက်' : 'ဂိတ်ရောက်';
        $service_charge = number_format($cargo->service_charge, 2);
        $short_deli_fee = number_format($cargo->short_deli_fee, 2);
        $final_deli_fee = number_format($cargo->final_deli_fee, 2);
        $total_fee = number_format($cargo->total_fee, 2);
        $border_fee = number_format($cargo->border_fee, 2);
        $cargo_status = $this->getCargoStatusMM($cargo->status);
        $qrcode_image = $cargo->qrcode_image;
        return view('admin.cargos.voucher-print', compact('cargo', 'qrcode_image', 'user', 'cargo_image', 'entry_date', 'to_take_date', 'delivery_type', 'service_charge', 'short_deli_fee', 'final_deli_fee', 'border_fee', 'total_fee', 'cargo_status'));
    }
}

<?php

namespace App\Http\Controllers;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\TransitPassengerRepositoryInterface;
use Yajra\DataTables\DataTableAbstract;
use Carbon\Carbon;

class TransitPassengerController extends BaseController
{
    public function __construct(TransitPassengerRepositoryInterface $repository){
        parent::__construct($repository, 'admin.transit_passengers', 'transit_passengers');
    }

    public function index($params = []){
        return parent::index($params);
    }

    public function getList(Request $request){
        return parent::getList($request);
    }

    protected function applyFilter(Request $request, $query){
        if ($request->has('daterange') && $request->get('daterange') != '') {
            $daterange = explode(' - ', $request->get('daterange'));
            $start = Carbon::parse($daterange[0])->startOfDay();
            $end = Carbon::parse($daterange[1])->endOfDay();
        
            $query = $query->whereHas('cargo', function ($query) use ($start, $end) {
                $query->whereBetween('created_at', [$start, $end]);
            });
        }
        return $query;
    }

    protected function prepareDataTable(DataTableAbstract $datatable){
        $datatable->addColumn('car_number', function ($transit_passenger) {
            return $transit_passenger->car ? $transit_passenger->car->number : '';
        });
        $datatable->addColumn('seat_number', function ($transit_passenger) {
            return $transit_passenger->seat_number;
        });
        $datatable->addColumn('price', function ($transit_passenger) {
            return $transit_passenger->price;
        });
        $datatable->addColumn('date', function ($transit_passenger) {
            return Carbon::parse($transit_passenger->created_at)->format('d/m/Y');
        });
        $datatable->addColumn('status', function ($transit_passenger) {
            return $transit_passenger->status ? ($transit_passenger->status == 'active' ? 'အသုံးပြုဆဲ' : 'အသုံးမပြုတော့ပါ') : 'အသုံးမပြုတော့ပါ';
        });
        return $datatable;
    }

    /**
     * Show the form for creating a new resource.
     * 
     * @return view
     * @Date 2025-08-20
     * @Author HeinHtetAung
     */
    public function create(){
        return view('admin.transit_passengers.create');
    }

    public function store(Request $request){
        // 
    }

    public function edit($id){
        return view('admin.transit_passengers.edit', [
            'form_type' => 'edit',
            'id' => $id,
        ]);
    }

    public function update(Request $request, $id){
        $this->repository->update($id, $request->all());
        return redirect()->route('admin.transit_passengers.index');
    }

    public function destroy($id){
        $this->repository->delete($id);
        return redirect()->route('admin.transit_passengers.index');
    }

    public function show($id){
        $transit_passenger = $this->repository->getById($id);
        return view('admin.transit_passengers.show', [
            'transit_passenger' => $transit_passenger,
        ]);
    }
}

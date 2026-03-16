<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\PassengerSummaryReportRepositoryInterface;
use App\Models\Car;
use App\Models\Merchant;
use Carbon\Carbon;
use Yajra\DataTables\DataTableAbstract;

class PassengerReportController extends BaseController
{
    protected $passengerSummaryRepository;
    /**
     * Constructor
     * @Date 2025-07-12
     * @param PassengerSummaryReportRepositoryInterface $passengerSummaryReportRepository
     */
    public function __construct(PassengerSummaryReportRepositoryInterface $passengerSummaryReportRepository)
    {
        parent::__construct($passengerSummaryReportRepository, 'admin.reports.passengers', 'passenger_reports');
    }

    public function index($params = [])
    {
        $params = [
            'cars' => Car::all(),
            'merchants' => Merchant::all(),
        ];
        return parent::index($params);
    }

    public function getList(Request $request)
    {
        return parent::getList($request);
    }

    protected function prepareDataTable(DataTableAbstract $datatable)
    {
        return $datatable
            ->addColumn('name', function($report) {
                return $report->name;
            })
            ->addColumn('phone', function($report) {
                return $report->phone;
            })
            ->addColumn('address', function($report) {
                return $report->address;
            })
            ->addColumn('nrc', function($report) {
                return $report->nrc;
            })
            ->addColumn('car_number', function($report) {
                return $report->car_number;
            })
            ->addColumn('seat_number', function($report) {
                return $report->seat_number;
            })
            ->addColumn('is_paid', function($report) {
                return $report->is_paid ? 'ဟုတ်တယ်' : 'မဟုတ်ပါ';
            })
            ->addColumn('price', function($report) {
                return $report->price;
            })
            ->addColumn('voucher_number', function($report) {
                return $report->voucher_number;
            })
            ->addColumn('registered_date', function($report) {
                return Carbon::parse($report->created_at)->format('d/m/Y');
            });
    }

    protected function applyFilter(Request $request, $query)
    {
        if ($request->has('daterange') && $request->get('daterange') != '') {
            $daterange = explode(' - ', $request->get('daterange'));
            $start = Carbon::parse($daterange[0])->startOfDay();
            $end = Carbon::parse($daterange[1])->endOfDay();
        
            $query = $query->whereBetween('tp.created_at', [$start, $end]);
        }
        if ($request->has('carNumber') && $request->get('carNumber') != '') {
            $query = $query->where('car.number', $request->get('carNumber'));
        }
        return $query;
    }
}

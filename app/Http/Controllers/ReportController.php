<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Merchant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTableAbstract;
use App\Repositories\Interfaces\CargoSummaryReportRepositoryInterface;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\Browsershot\Browsershot;

class ReportController extends BaseController
{
    /**
     * Constructor
     * @Date 2025-07-12
     * @param CargoSummaryReportRepositoryInterface $cargoSummaryReportRepository
     */
    public function __construct(CargoSummaryReportRepositoryInterface $cargoSummaryReportRepository)
    {
        parent::__construct($cargoSummaryReportRepository, 'admin.reports', 'reports');
    }

    /**
     * Display a listing of the resource.
     * @Date 2025-07-12
     * @return \Illuminate\Http\Response
     */
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
        return parent::getList($request, $this->repository, $this->viewPath, $this->module);
    }

    protected function prepareDataTable(DataTableAbstract $datatable)
    {
        return $datatable
            ->addColumn('from', function ($report) {
                return $report->from_city . ' - ' . $report->from_gate;
            })
            ->addColumn('to', function ($report) {
                return $report->to_city . ' - ' . $report->to_gate;
            })
            ->addColumn('s_name', function ($report) {
                return $report->sender_name;
            })
            ->addColumn('s_phone', function ($report) {
                return $report->sender_phone;
            })
            ->addColumn('r_name', function ($report) {
                return $report->receiver_name;
            })
            ->addColumn('r_phone', function ($report) {
                return $report->receiver_phone;
            })
            ->addColumn('car_number', function ($report) {
                return $report->car_number;
            })
            ->addColumn('registered_date', function ($report) {
                return Carbon::parse($report->registered_date)->format('d/m/Y');
            })
            ->addColumn('to_pick_date', function ($report) {
                return Carbon::parse($report->to_pick_date)->format('d/m/Y');
            });
    }

    protected function applyFilter(Request $request, $query)
    {
        if ($request->has('daterange') && $request->get('daterange') != '') {
            $daterange = explode(' - ', $request->get('daterange'));
            $start = Carbon::parse($daterange[0])->startOfDay();
            $end = Carbon::parse($daterange[1])->endOfDay();

            $query = $query->whereBetween('registered_date', [$start, $end]);
        }
        if ($request->has('isDebt') && $request->get('isDebt') != '') {
            $query = $query->where('is_debt', $request->get('isDebt'));
        }
        if ($request->has('carNumber') && $request->get('carNumber') != '') {
            $query = $query->where('car_number', $request->get('carNumber'));
        }
        if ($request->has('sender_name') && $request->get('sender_name') != '') {
            $query = $query->where('sender_name', 'like', '%' . $request->get('sender_name') . '%');
        }
        if ($request->has('receiver_name') && $request->get('receiver_name') != '') {
            $query = $query->where('receiver_name', 'like', '%' . $request->get('receiver_name') . '%');
        }
        if ($request->has('type') && $request->get('type') != '') {
            $query = $query->where('type', $request->get('type'));
        }
        return $query;
    }

    public function exportPdf()
    {
        try {
            $query = $this->repository->getList();
            $cars = Car::all();
            $merchants = Merchant::all();
            $reports = $query->get();
            
            // Format the data for the view
            $data = [
                'reports' => $reports,
                'cars' => $cars,
                'merchants' => $merchants,
                'title' => 'Cargo Summary Report',
                'date' => now()->format('d/m/Y H:i:s')
            ];

            // Generate HTML content
            $html = view('admin.reports.pdf', $data)->render();

            // Configure and generate PDF
            $pdfPath = public_path('reports/report_' . now()->format('Ymd_His') . '.pdf');
            
            // Ensure directory exists
            if (!file_exists(dirname($pdfPath))) {
                mkdir(dirname($pdfPath), 0777, true);
            }

            // Generate PDF using Browsershot
            Browsershot::html($html)
                ->save($pdfPath);

            // Return the file download response
            // return response()->download($pdfPath)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to generate PDF: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $report = $this->repository->getById($id);
        return view('admin.reports.show', compact('report'));
    }
}

<?php

namespace App\Repositories;

use App\Repositories\Interfaces\PassengerSummaryReportRepositoryInterface;
use Illuminate\Support\Facades\DB;

class PassengerSummaryReportRepository implements PassengerSummaryReportRepositoryInterface
{
    public function getList()
    {
        $passengerReportQuery = DB::table('transit_passengers as tp')
            ->select(
                'tp.id',
                'tp.name',
                'tp.phone',
                'tp.address',
                'tp.nrc',
                'car.number as car_number',
                'tp.seat_number',
                'tp.price',
                'tp.voucher_number',
                'tp.is_paid',
                'tp.status',
                'tp.created_at',
                'tp.updated_at'
            )->leftJoin('cars as car', 'car.id', '=', 'tp.car_id');
        return $passengerReportQuery;
    }
}

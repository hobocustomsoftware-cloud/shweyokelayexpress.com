<?php

namespace App\Repositories;

use App\Repositories\Interfaces\CargoSummaryReportRepositoryInterface;

use Illuminate\Support\Facades\DB;

class CargoSummaryReportRepository implements CargoSummaryReportRepositoryInterface
{
    public function getList(array $relations = [])
    {
        $gateCargos = DB::table('cargos as c')
            ->select(
                'c.id',
                'c.cargo_no',
                'from_city.name_my as from_city',
                'from_gate.name_my as from_gate',
                'to_city.name_my as to_city',
                'to_gate.name_my as to_gate',
                DB::raw('COALESCE(sender.name, c.s_name_string) as sender_name'),
                DB::raw('COALESCE(sender.phone, c.s_phone) as sender_phone'),
                DB::raw('COALESCE(receiver.name, c.r_name_string) as receiver_name'),
                DB::raw('COALESCE(receiver.phone, c.r_phone) as receiver_phone'),
                'c.created_at as registered_date',
                'c.to_pick_date',
                'c.quantity',
                'c.service_charge',
                'c.short_deli_fee',
                'c.final_deli_fee',
                'c.border_fee',
                'c.total_fee',
                'c.status',
                'c.is_debt',
                'car.number as car_number',
                'car_cargo.car_id',
                DB::raw('"gate" as type')
            )
            ->leftJoin('cities as from_city', 'from_city.id', '=', 'c.from_city_id')
            ->leftJoin('cities as to_city', 'to_city.id', '=', 'c.to_city_id')
            ->leftJoin('gates as from_gate', 'from_gate.id', '=', 'c.from_gate_id')
            ->leftJoin('gates as to_gate', 'to_gate.id', '=', 'c.to_gate_id')
            ->leftJoin('merchants as sender', 'sender.id', '=', 'c.s_merchant_id')
            ->leftJoin('merchants as receiver', 'receiver.id', '=', 'c.r_merchant_id')
            ->leftJoin('car_cargos as car_cargo', 'car_cargo.cargo_id', '=', 'c.id')
            ->leftJoin('cars as car', 'car.id', '=', 'car_cargo.car_id')
            ->where('c.status', '!=', 'deleted');

        $transitCargos = DB::table('transit_cargos as tc')
            ->select(
                'tc.id',
                'tc.cargo_no',
                'from_city.name_my as from_city',
                'from_gate.name_my as from_gate',
                'to_city.name_my as to_city',
                'to_gate.name_my as to_gate',
                DB::raw('COALESCE(sender.name, tc.s_name_string) as sender_name'),
                DB::raw('COALESCE(sender.phone, tc.s_phone) as sender_phone'),
                DB::raw('COALESCE(receiver.name, tc.r_name_string) as receiver_name'),
                DB::raw('COALESCE(receiver.phone, tc.r_phone) as receiver_phone'),
                'tc.created_at as registered_date',
                'tc.to_pick_date',
                'tc.quantity',
                'tc.service_charge',
                DB::raw('NULL as short_deli_fee'),
                DB::raw('NULL as final_deli_fee'),
                DB::raw('NULL as border_fee'),
                DB::raw('NULL as total_fee'),
                'tc.status',
                'tc.is_debt',
                'car.number as car_number',
                'car_cargo.car_id',
                DB::raw('"transit" as type')
            )
            ->leftJoin('cities as from_city', 'from_city.id', '=', 'tc.from_city')
            ->leftJoin('cities as to_city', 'to_city.id', '=', 'tc.to_city')
            ->leftJoin('gates as from_gate', 'from_gate.id', '=', 'tc.from_gate')
            ->leftJoin('gates as to_gate', 'to_gate.id', '=', 'tc.to_gate')
            ->leftJoin('merchants as sender', 'sender.id', '=', 'tc.s_merchant_id')
            ->leftJoin('merchants as receiver', 'receiver.id', '=', 'tc.r_merchant_id')
            ->leftJoin('car_cargos as car_cargo', 'car_cargo.cargo_id', '=', 'tc.id')
            ->leftJoin('cars as car', 'car.id', '=', 'car_cargo.car_id')
            ->where('tc.status', '!=', 'deleted');

        $union = $gateCargos->union($transitCargos);
        $resultQuery = DB::query()
            ->fromSub($union, 'union');
        return $resultQuery;
    }
}

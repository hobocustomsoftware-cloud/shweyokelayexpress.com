<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        // 
    }
    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (Auth::user()->hasRole('Accountant')) {
            return redirect()->route('admin.reports.index');
        }
        if (Auth::user()->hasRole('Spare')) {
            return redirect()->route('admin.transit_cargos.index');
        }
        return redirect()->route('admin.cargos.index');
    }
}

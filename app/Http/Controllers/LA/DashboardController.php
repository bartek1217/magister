<?php
/**
 * Controller genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Http\Controllers\LA;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use DB;

/**
 * Class DashboardController
 * @package App\Http\Controllers
 */
class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        $count_magisters = DB::table('magisters')->whereNull('deleted_at')->count();
        $count_licencjats = DB::table('licencjats')->whereNull('deleted_at')->count();
        $count_reservation_magisters = DB::table('magisters')->whereNotNull('student')->whereNull('deleted_at')->count();
        $count_reservation_licencjats = DB::table('licencjats')->whereNotNull('student')->whereNull('deleted_at')->count();              $magisters = DB::table('magisters')
            ->select('employees.name AS name', DB::raw('count(*) as count'), DB::raw('count(student) as reservation_count'))
            ->leftJoin('employees', 'magisters.promotor', '=', 'employees.id')
            ->groupBy('magisters.promotor')
            ->get();
        $licencjats = DB::table('licencjats')
             ->select('employees.name AS name', DB::raw('count(*) as count'), DB::raw('count(student) as reservation_count'))
             ->leftJoin('employees', 'licencjats.promotor', '=', 'employees.id')
             ->groupBy('licencjats.promotor')
             ->get();

        return view('la.dashboard', [
            'count_magisters' => $count_magisters,
            'count_licencjats' => $count_licencjats,
            'count_reservation_magisters' => $count_reservation_magisters,
            'count_reservation_licencjats' => $count_reservation_licencjats,
            'magisters' => $magisters,
            'licencjats' => $licencjats
        ]);
    }
}
<?php

namespace App\Http\Controllers\LA;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use DB;
use Validator;
use Datatables;
use Collective\Html\FormFacade as Form;
use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\ModuleFields;
use Zizaco\Entrust\EntrustFacade as Entrust;

use App\Models\Licencjat;

class LicencjatsController extends Controller
{
	public $show_action = true;
	public $view_col = 'subject';
	public $listing_cols = ['id', 'promotor', 'subject', 'status'];
	
	public function __construct() {
		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Licencjats', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Licencjats', $this->listing_cols);
		}
	}
	
	/**
	 * Display a listing of the Licencjats.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$module = Module::get('Licencjats');
		
		if(Module::hasAccess($module->id)) {
			return View('la.licencjats.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module
			]);
		} else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
	}

	/**
	 * Show the form for creating a new licencjat.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created licencjat in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Module::hasAccess("Licencjats", "create")) {
		
			$rules = Module::validateRules("Licencjats", $request);
			if(Entrust::hasRole('PRACOWNIK')) $request->request->add(['promotor' => Auth::user()->context_id]);
			$request->request->add(['created_user' => Auth::user()->context_id]);
			$request->request->add(['updated_user' => Auth::user()->context_id]);
			$request->request->add(['status' => 'Wolne']);
			$request->request->add(['stan' => '0']);			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			
			$insert_id = Module::insert("Licencjats", $request);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.licencjats.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified licencjat.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Module::hasAccess("Licencjats", "view")) {
			
			$licencjat = Licencjat::find($id);
			if(isset($licencjat->id)) {
				$module = Module::get('Licencjats');
				$module->row = $licencjat;

				$students = DB::table('employees')
					->select('employees.id as id', 'employees.name as name')
					->leftJoin('role_user as role', 'employees.id', '=', 'role.user_id')
					->where('role.role_id', '=', '4')
					->whereNotIn('employees.id',function($query) {

						$query->select('student')->from('licencjats')->whereNotNull('student');
					 
					 })->get();
				$recenzents = DB::table('employees')
					 ->select('employees.id as id', 'employees.name as name')
					 ->leftJoin('role_user as role', 'employees.id', '=', 'role.user_id')
					 ->where('role.role_id', '=', '3')->get();	

				return view('la.licencjats.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding",
					'students' => $students,
					'recenzents' => $recenzents
				])->with('licencjat', $licencjat);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("licencjat"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified licencjat.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Module::hasAccess("Licencjats", "edit")) {			
			$licencjat = Licencjat::find($id);
			if(isset($licencjat->id)) {	
				$module = Module::get('Licencjats');
				
				$module->row = $licencjat;
				
				return view('la.licencjats.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('licencjat', $licencjat);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("licencjat"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Update the specified licencjat in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Module::hasAccess("Licencjats", "edit")) {
			
			$rules = Module::validateRules("Licencjats", $request, true);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			
			$insert_id = Module::updateRow("Licencjats", $request, $id);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.licencjats.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified licencjat from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("Licencjats", "delete")) {
			Licencjat::find($id)->delete();
			
			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.licencjats.index');
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}
	
	/**
	 * Datatable Ajax fetch
	 *
	 * @return
	 */
	public function dtajax()
	{
		$values = DB::table('licencjats')->select($this->listing_cols)->whereNull('deleted_at');
		$out = Datatables::of($values)->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('Licencjats');
		
		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) { 
				$col = $this->listing_cols[$j];
				if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
				}
				if($col == $this->view_col) {
					$data->data[$i][$j] = '<a href="'.url(config('laraadmin.adminRoute') . '/licencjats/'.$data->data[$i][0]).'">'.$data->data[$i][$j].'</a>';
				}
				// else if($col == "author") {
				//    $data->data[$i][$j];
				// }
			}
			
			if($this->show_action) {
				$output = '';
				if(Module::hasAccess("Licencjats", "view")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/licencjats/'.$data->data[$i][0].'').'" class="btn btn-info btn-xs" style="display:inline;padding:2px 10px 3px 10px; margin-right:2px;"><i class="fa fa-info"></i></a>';
				}

				if(Module::hasAccess("Licencjats", "edit") && (Entrust::hasRole('ADMINISTRATOR') || DB::table('licencjats')->where('promotor', Auth::user()->id)->where('id', $data->data[$i][0])->count() == 1)) 
				{
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/licencjats/'.$data->data[$i][0].'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
				}
				
				if(Module::hasAccess("Licencjats", "delete") && (Entrust::hasRole('ADMINISTRATOR') || DB::table('licencjats')->where('promotor', Auth::user()->id)->where('id', $data->data[$i][0])->count() == 1)) 
				{
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.licencjats.destroy', $data->data[$i][0]], 'method' => 'delete', 'style'=>'display:inline']);
					$output .= ' <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-times"></i></button>';
					$output .= Form::close();
				}
				$data->data[$i][] = (string)$output;
			}
		}
		$out->setData($data);
		return $out;
	}
}

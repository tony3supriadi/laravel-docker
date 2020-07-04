<?php

namespace App\Http\Controllers\Operational;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Employee;
use App\Models\EmployeeSalary;

use Auth;
use PDF;

class SallaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:sallary-list|sallary-create|sallary-edit|sallary-delete', ['only' => ['index','store']]);
         $this->middleware('permission:sallary-create', ['only' => ['create','store']]);
         $this->middleware('permission:sallary-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:sallary-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = isset($_GET['m']) 
            ? $_GET['y'].'-'.$_GET['m'].'%' 
            : date('Y-m').'%';

        $data = array(
            'title' => 'Gaji Karyawan',
            'actived' => 'op-sallary',
            'salaries' => EmployeeSalary::select('employee_salaries.*', 'employees.name')
                                ->join('employees', 'employee_id', '=', 'employees.id')
                                ->where('employee_salaries.created_at', 'LIKE', $filter)
                                ->orderBy('name', 'ASC')
                                ->get(),
            'total' => EmployeeSalary::where('created_at', 'LIKE', $filter)->sum('salary_total')
        );
        return view('modules.operational.sallary.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employees = [];

        if (!Auth::user()->branch_id) {
            $employees = Employee::orderBy('name', 'ASC')->get();
        } else {
            $employees = Employee::orderBy('name', 'ASC')
                            ->where('branch_id', '=', Auth::user()->branch_id)
                            ->get();
        }

        $data = array(
            'title' => 'Gaji Karyawan',
            'actived' => 'op-sallary',
            'employees' => $employees
        );
        return view('modules.operational.sallary.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $filter = isset($_GET['m']) ? $_GET['y'].'-'.$_GET['m'].'%' : date('Y-m').'%';
        $check = EmployeeSalary::where('employee_id', '=', $request->employee_id)
                        ->where('created_at', 'LIKE', $filter)
                        ->first();

        if ($check) {
            $check->fill($request->all());
            $check->salary_total = $request->salary + $request->salary_extra;
            $check->save();
        } else {
            $data = $request->all();
            $data['salary_total'] = $request->salary + $request->salary_extra;
            $data['status'] = 'Dibayarkan';

            EmployeeSalary::create($data);
        }
        return redirect('gaji-karyawan')->with('success', true);
    }

    public function print(Request $request)
    {
        $filter = isset($_GET['m']) 
            ? $_GET['y'].'-'.$_GET['m'].'%' 
            : date('Y-m').'%';

        $results = EmployeeSalary::select('employee_salaries.*', 'employees.name')
                        ->join('employees', 'employee_id', '=', 'employees.id')
                        ->where('employee_salaries.created_at', 'LIKE', $filter)
                        ->orderBy('name', 'ASC')
                        ->get();
        
        return view('modules.operational.sallary.print', compact('results'));
        // $pdf = PDF::loadView('modules.operational.sallary.print', compact('results'))
        //             ->setPaper('a4', 'landscape');
        
        // return $pdf->stream();
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\Imports\EmployeeImport;
use App\Imports\GovernmentAgencyImport;
use App\GovernmentAgency;
use PDF;

use DB;

class ResultController extends Controller
{
    public function index(){
      return view('results.results');
    }

    public function get_results(Request $request){
      $page= isset($_POST['page']) ? intval($_POST['page']):1;
       $rows= isset($_POST['rows']) ? intval($_POST['rows']):10;
       $government_agency_id = $request->government_agency_id;
       $search = $request->search;

       $offset = ($page-1)*$rows;
       $sql="select count(*) from employees";

       $host=config('database.connections.mysql.host');
       $username=config('database.connections.mysql.username');
       $password=config('database.connections.mysql.password');
       $db_name=config('database.connections.mysql.database');
       $connection=mysqli_connect("$host","$username","$password") or die("cannot connect server");
       $database=mysqli_select_db($connection,"$db_name") or die("cannot select db");
       $rs=mysqli_query($connection,$sql);
       $row=mysqli_fetch_row($rs);
       $result["total"]= $row[0];
       if ($government_agency_id != '') {
         $employees = DB::table('employees')
                          ->join('government_agencies','employees.government_agency_id','=','government_agencies.id')
                          ->join('employee_question_answers','employees.id','=','employee_question_answers.employee_id')
                          ->join('answers','answers.id','=','employee_question_answers.answer_id')
                          ->join('questions','questions.id','=','employee_question_answers.question_id')
                          ->join('perfomance_indicators','perfomance_indicators.id','=','questions.perfomance_indicator_id')
                          ->select('employees.*','government_agencies.government_agency','answers.*','perfomance_indicators.*',DB::raw('SUM(answer_value) total'), DB::raw('SUM(CASE WHEN perfomance_indicators.performance_indicator = "Productividad" THEN answer_value ELSE 0 END) as productividad'),DB::raw('SUM(CASE WHEN perfomance_indicators.performance_indicator = "Planificación" THEN answer_value ELSE 0 END) planificacion'),DB::raw('SUM(CASE WHEN perfomance_indicators.performance_indicator = "Liderazgo" THEN answer_value ELSE 0 END) liderazgo'))->where('employees.government_agency_id',$government_agency_id)->groupBy('employees.employee_name')->skip($offset)->take($rows)->get();
       }elseif ($search != '') {

         $employees = DB::table('employees')
                          ->join('government_agencies','employees.government_agency_id','=','government_agencies.id')
                          ->join('employee_question_answers','employees.id','=','employee_question_answers.employee_id')
                          ->join('answers','answers.id','=','employee_question_answers.answer_id')
                          ->join('questions','questions.id','=','employee_question_answers.question_id')
                          ->join('perfomance_indicators','perfomance_indicators.id','=','questions.perfomance_indicator_id')
                          ->select('employees.*','government_agencies.government_agency','answers.*','perfomance_indicators.*',DB::raw('SUM(answer_value) total'), DB::raw('SUM(CASE WHEN perfomance_indicators.performance_indicator = "Productividad" THEN answer_value ELSE 0 END) as productividad'),DB::raw('SUM(CASE WHEN perfomance_indicators.performance_indicator = "Planificación" THEN answer_value ELSE 0 END) planificacion'),DB::raw('SUM(CASE WHEN perfomance_indicators.performance_indicator = "Liderazgo" THEN answer_value ELSE 0 END) liderazgo'))->where('employees.token','LIKE','%'.$search.'%')
                          ->orWhere('employees.employee_name','LIKE','%'.$search.'%')
                          ->orWhere('employees.parent_token','LIKE','%'.$search.'%')
                          ->groupBy('employees.employee_name')->skip($offset)->take($rows)->get();
       }else {
         $employees = DB::table('employees')
         ->join('government_agencies','employees.government_agency_id','=','government_agencies.id')
         ->join('employee_question_answers','employees.id','=','employee_question_answers.employee_id')
         ->join('answers','answers.id','=','employee_question_answers.answer_id')
         ->join('questions','questions.id','=','employee_question_answers.question_id')
         ->join('perfomance_indicators','perfomance_indicators.id','=','questions.perfomance_indicator_id')
         ->select('employees.*','government_agencies.government_agency','answers.*','perfomance_indicators.*',DB::raw('SUM(answer_value) total'), DB::raw('SUM(CASE WHEN perfomance_indicators.performance_indicator = "Productividad" THEN answer_value ELSE 0 END) as productividad'),DB::raw('SUM(CASE WHEN perfomance_indicators.performance_indicator = "Planificación" THEN answer_value ELSE 0 END) planificacion'),DB::raw('SUM(CASE WHEN perfomance_indicators.performance_indicator = "Liderazgo" THEN answer_value ELSE 0 END) liderazgo'))->groupBy('employees.employee_name')->skip($offset)->take($rows)->get();
       }
       //$employees=Employee::with(['government_agency'])->orderBy('id','asc')->skip($offset)->take($rows)->get();
       $items=array();
       foreach($employees as $employee){
         array_push($items, $employee);
       }
       $result["rows"]=$items;
       // $row=$profiles->toArray($profiles);
       echo json_encode($result);
     }
     public function import(Request $request){
       return view('imports.import');
     }
     public function import_data(Request $request){
       $path1 = $request->file('file_upload')->store('temp');
       $path=storage_path('app').'/'.$path1;
       $data = \Excel::import(new EmployeeImport,$path);
       //Excel::import(new PropiertyImport,request()->file('file'));
       return back();
     }
     public function import_data_gob(Request $request){
       $path1 = $request->file('file_upload')->store('temp');
       $path=storage_path('app').'/'.$path1;
       $data = \Excel::import(new GovernmentAgencyImport,$path);
       //Excel::import(new PropiertyImport,request()->file('file'));
       return back();
     }

     public function get_departments(Request $request){
       $departments = GovernmentAgency::orderBy('government_agency')->get();
       echo json_encode($departments);
     }

     public function result_downlad(){
       $departments = GovernmentAgency::orderBy('id')->get();
       return view('results.download', compact('departments'));
     }

     public function download_results(Request $request){
       if ($request) {
         $government_agency_id = $request->government_agency_id;
         $government_agency = GovernmentAgency::where('id', $government_agency_id)->first();
         $employees = DB::table('employees')
                          ->join('government_agencies','employees.government_agency_id','=','government_agencies.id')
                          ->join('employee_question_answers','employees.id','=','employee_question_answers.employee_id')
                          ->join('answers','answers.id','=','employee_question_answers.answer_id')
                          ->join('questions','questions.id','=','employee_question_answers.question_id')
                          ->join('perfomance_indicators','perfomance_indicators.id','=','questions.perfomance_indicator_id')
                          ->select('employees.*','government_agencies.government_agency','answers.*','perfomance_indicators.*',DB::raw('SUM(answer_value) total'), DB::raw('SUM(CASE WHEN perfomance_indicators.performance_indicator = "Productividad" THEN answer_value ELSE 0 END) as productividad'),DB::raw('SUM(CASE WHEN perfomance_indicators.performance_indicator = "Planificación" THEN answer_value ELSE 0 END) planificacion'),DB::raw('SUM(CASE WHEN perfomance_indicators.performance_indicator = "Liderazgo" THEN answer_value ELSE 0 END) liderazgo'))->where('employees.government_agency_id',$government_agency_id)->groupBy('employees.employee_name')->get();

                $pdf = PDF::loadView('results.downloadPDF', compact('employees','government_agency'));
                return $pdf->download('Resultados.pdf');
       }
     }
}

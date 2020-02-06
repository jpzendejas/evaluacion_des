<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Employee;
use App\GovernmentAgency;


class EmployeeController extends Controller
{
    public function index(Request $request){
      return view('cats.employees');
    }

    public function get_employees(Request $request){
      $page= isset($_POST['page']) ? intval($_POST['page']):1;
       $rows= isset($_POST['rows']) ? intval($_POST['rows']):10;
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

       // $questions=Question::orderBy('id','asc')->skip($offset)->take($rows)->get();
       $employees = DB::table('employees')
                    ->join('government_agencies','employees.government_agency_id','=','government_agencies.id')
                    ->select('employees.*','government_agencies.government_agency')->orderBy('id','asc')->skip($offset)->take($rows)->get();
      $items=array();
       foreach($employees as $employee){
         array_push($items, $employee);
       }
       $result["rows"]=$items;
       // $row=$profiles->toArray($profiles);
       echo json_encode($result);
    }

    public function save_employees(Request $request){
      $rules = [
        'token'=>'required',
        'employee_name'=>'required',
        'parent_token'=>'required',
        'government_agency_id'
      ];
      $this->validate($request, $rules);

      $employee = new Employee();
      $employee->token = $request->token;
      $employee->employee_name = $request->employee_name;
      $employee->parent_token = $request->parent_token;
      $employee->government_agency_id = $request->government_agency_id;
      $employee->save();
      echo json_encode(array('success'=>true));
    }

    public function get_departments(){
      $departments = GovernmentAgency::orderBy('id')->get();
      echo json_encode($departments);
    }
    public function get_parent_tokens(){
      $parent_tokens = Employee::orderBy('id')->get();
      echo json_encode($parent_tokens);
    }

    public function update_employees(Request $request, $id){
      $requestData = $request->all();
      $employee = Employee::findOrfail($id);
      $employee->update($requestData);
      echo json_encode(array('success'=>true));
    }

    public function destroy_employees(Request $request){
      $id = $request->id;
      $employee = Employee::findOrFail($id);
      $employee->delete();
      echo json_encode(array('success'=>true));
      }
}

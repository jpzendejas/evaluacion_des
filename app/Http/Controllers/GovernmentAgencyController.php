<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GovernmentAgency;

class GovernmentAgencyController extends Controller
{
  public function index(Request $request){
    return view('cats.governmentagencies');
  }

  public function get_governmentagencies(Request $request){
  $page= isset($_POST['page']) ? intval($_POST['page']):1;
   $rows= isset($_POST['rows']) ? intval($_POST['rows']):10;
   $offset = ($page-1)*$rows;
   $sql="select count(*) from government_agencies";

   $host=config('database.connections.mysql.host');
   $username=config('database.connections.mysql.username');
   $password=config('database.connections.mysql.password');
   $db_name=config('database.connections.mysql.database');
   $connection=mysqli_connect("$host","$username","$password") or die("cannot connect server");
   $database=mysqli_select_db($connection,"$db_name") or die("cannot select db");
   $rs=mysqli_query($connection,$sql);
   $row=mysqli_fetch_row($rs);
   $result["total"]= $row[0];

   $government_agencies=GovernmentAgency::orderBy('id','asc')->skip($offset)->take($rows)->get();
   $items=array();
   foreach($government_agencies as $government_agency){
     array_push($items, $government_agency);
   }
   $result["rows"]=$items;
   // $row=$profiles->toArray($profiles);
   echo json_encode($result);
  }

  public function save_governmentagencies(Request $request){
    $rules = [
      'government_agency'=>'required'
    ];
    $this->validate($request, $rules);

    $government_agency = new GovernmentAgency();
    $government_agency->government_agency = $request->government_agency;
    $government_agency->save();
    echo json_encode(array('success'=>true));
    }

    public function update_governmentagencies(Request $request, $id){
      $requestData = $request->all();
      $government_agency = GovernmentAgency::findOrfail($id);
      $government_agency->update($requestData);
      echo json_encode(array('success'=>true));
    }
}

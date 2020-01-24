<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UseType;

class UseTypesController extends Controller
{
    public function index(Request $request){
      return view('cats.use_types');
    }

    public function get_use_types(Request $request){
      $page= isset($_POST['page']) ? intval($_POST['page']):1;
       $rows= isset($_POST['rows']) ? intval($_POST['rows']):10;
       $offset = ($page-1)*$rows;
       $sql="select count(*) from use_types";

       $host=config('database.connections.mysql.host');
       $username=config('database.connections.mysql.username');
       $password=config('database.connections.mysql.password');
       $db_name=config('database.connections.mysql.database');
       $connection=mysqli_connect("$host","$username","$password") or die("cannot connect server");
       $database=mysqli_select_db($connection,"$db_name") or die("cannot select db");
       $rs=mysqli_query($connection,$sql);
       $row=mysqli_fetch_row($rs);
       $result["total"]= $row[0];

       $use_types=UseType::orderBy('id','asc')->skip($offset)->take($rows)->get();
       $items=array();
       foreach($use_types as $use_type){
         array_push($items, $use_type);
       }
       $result["rows"]=$items;
       // $row=$profiles->toArray($profiles);
       echo json_encode($result);
    }

    public function save_use_types(Request $request){
      $rules = ['use_type'=>'required'];
      $this->validate($request, $rules);
      $us_type = new UseType();
      $us_type->use_type = $request->use_type;
      $us_type->save();
      echo json_encode(array('success'=>true));
    }

    public function update_use_types(Request $request, $id){
      $requestData = $request->all();
      $us_type = UseType::findOrfail($id);
      $us_type->update($requestData);
      echo json_encode(array('success'=>true));
    }
}

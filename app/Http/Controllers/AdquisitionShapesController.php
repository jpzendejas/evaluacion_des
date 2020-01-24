<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AdquisitionShape;

class AdquisitionShapesController extends Controller
{
    public function index(){
      return view('cats.adquisition_shapes');
    }
    public function get_adquisition_shapes(Request $request){
      $page= isset($_POST['page']) ? intval($_POST['page']):1;
       $rows= isset($_POST['rows']) ? intval($_POST['rows']):10;
       $offset = ($page-1)*$rows;
       $sql="select count(*) from adquisition_shapes";

       $host=config('database.connections.mysql.host');
       $username=config('database.connections.mysql.username');
       $password=config('database.connections.mysql.password');
       $db_name=config('database.connections.mysql.database');
       $connection=mysqli_connect("$host","$username","$password") or die("cannot connect server");
       $database=mysqli_select_db($connection,"$db_name") or die("cannot select db");
       $rs=mysqli_query($connection,$sql);
       $row=mysqli_fetch_row($rs);
       $result["total"]= $row[0];

       $adquisition_shapes=AdquisitionShape::orderBy('id','asc')->skip($offset)->take($rows)->get();
       $items=array();
       foreach($adquisition_shapes as $adquisition_shape){
         array_push($items, $adquisition_shape);
       }
       $result["rows"]=$items;
       // $row=$profiles->toArray($profiles);
       echo json_encode($result);
    }

    public function save_adquisition_shapes(Request $request){
      $rules = [
        'adquisition_shape'=>'required'
      ];
      $this->validate($request, $rules);
      $adquisition_sh = new AdquisitionShape();
      $adquisition_sh->adquisition_shape = $request->adquisition_shape;
      $adquisition_sh->save();
      echo json_encode(array('success'=>true));
    }

    public function update_adquisition_shapes(Request $request, $id){
      $requestData=$request->all();
       $adquisition_sh=AdquisitionShape::findOrfail($id);
       $adquisition_sh->update($requestData);
       echo json_encode(array('success'=>true));
    }
}

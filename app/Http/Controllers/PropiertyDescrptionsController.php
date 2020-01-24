<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PropiertyDescription;

class PropiertyDescrptionsController extends Controller
{
    public function index(Request $request){
      return view('cats.propiertydescriptions');
    }

    public function get_propierty_descriptions(Request $request){
      $page= isset($_POST['page']) ? intval($_POST['page']):1;
       $rows= isset($_POST['rows']) ? intval($_POST['rows']):10;
       $offset = ($page-1)*$rows;
       $sql="select count(*) from propierty_descriptions";

       $host=config('database.connections.mysql.host');
       $username=config('database.connections.mysql.username');
       $password=config('database.connections.mysql.password');
       $db_name=config('database.connections.mysql.database');
       $connection=mysqli_connect("$host","$username","$password") or die("cannot connect server");
       $database=mysqli_select_db($connection,"$db_name") or die("cannot select db");
       $rs=mysqli_query($connection,$sql);
       $row=mysqli_fetch_row($rs);
       $result["total"]= $row[0];

       $propierty_descriptions=PropiertyDescription::orderBy('id','asc')->skip($offset)->take($rows)->get();
       $items=array();
       foreach($propierty_descriptions as $propierty_description){
         array_push($items, $propierty_description);
       }
       $result["rows"]=$items;
       // $row=$profiles->toArray($profiles);
       echo json_encode($result);
    }

    public function save_propierty_descriptions(Request $request){
      $rules = [
        'propierty_description'=>'required'
      ];
      $pro_description = new PropiertyDescription();
      $pro_description->propierty_description =$request->propierty_description;
      $pro_description->save();
      echo json_encode(array('success'=>true));
    }

    public function update_propierty_descriptions(Request  $request, $id){
      $requestData=$request->all();
       $pro_description=PropiertyDescription::findOrfail($id);
       $pro_description->update($requestData);
       echo json_encode(array('success'=>true));
    }
}

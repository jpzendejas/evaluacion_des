<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Owner;

class OwnersController extends Controller
{
    public function index(Request $request){
      return view('cats.owners');
    }

    public function get_owners(Request $request){
      $page= isset($_POST['page']) ? intval($_POST['page']):1;
       $rows= isset($_POST['rows']) ? intval($_POST['rows']):10;
       $offset = ($page-1)*$rows;
       $sql="select count(*) from owners";

       $host=config('database.connections.mysql.host');
       $username=config('database.connections.mysql.username');
       $password=config('database.connections.mysql.password');
       $db_name=config('database.connections.mysql.database');
       $connection=mysqli_connect("$host","$username","$password") or die("cannot connect server");
       $database=mysqli_select_db($connection,"$db_name") or die("cannot select db");
       $rs=mysqli_query($connection,$sql);
       $row=mysqli_fetch_row($rs);
       $result["total"]= $row[0];

       $owners=Owner::orderBy('id','asc')->skip($offset)->take($rows)->get();
       $items=array();
       foreach($owners as $owner){
         array_push($items, $owner);
       }
       $result["rows"]=$items;
       // $row=$profiles->toArray($profiles);
       echo json_encode($result);
    }

    public function save_owners(Request $request){
      $rules = ['owner_name'=>'required'
      ];
      $this->validate($request, $rules);
      $owner = new Owner();
      $owner->owner_name = $request->owner_name;
      $owner->save();
      echo json_encode(array('success'=>true));
    }
    public function update_owners(Request $request, $id){
      $requestData = $request->all();
      $owner = Owner::findOrfail($id);
      $owner->update($requestData);
      echo json_encode(array('success'=>true));
    }
}

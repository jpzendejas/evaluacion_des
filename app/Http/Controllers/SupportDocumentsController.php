<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SupportDocument;

class SupportDocumentsController extends Controller
{
    public function index(Request $request){
      return view('cats.supportdocuments');
    }

    public function get_support_documents(Request $request){
      $page= isset($_POST['page']) ? intval($_POST['page']):1;
       $rows= isset($_POST['rows']) ? intval($_POST['rows']):10;
       $offset = ($page-1)*$rows;
       $sql="select count(*) from support_documents";

       $host=config('database.connections.mysql.host');
       $username=config('database.connections.mysql.username');
       $password=config('database.connections.mysql.password');
       $db_name=config('database.connections.mysql.database');
       $connection=mysqli_connect("$host","$username","$password") or die("cannot connect server");
       $database=mysqli_select_db($connection,"$db_name") or die("cannot select db");
       $rs=mysqli_query($connection,$sql);
       $row=mysqli_fetch_row($rs);
       $result["total"]= $row[0];

       $support_documents=SupportDocument::orderBy('id','asc')->skip($offset)->take($rows)->get();
       $items=array();
       foreach($support_documents as $support_document){
         array_push($items, $support_document);
       }
       $result["rows"]=$items;
       // $row=$profiles->toArray($profiles);
       echo json_encode($result);
    }
    public function save_support_documents(Request $request){
      $rules = [
        'support_document'=>'required'
      ];
      $this->validate($request, $rules);
      $su_document = new SupportDocument();
      $su_document->support_document = $request->support_document;
      $su_document->save();
      echo json_encode(array('success'=>true));
    }

    public function update_support_documents(Request $request, $id){
      $requestData = $request->all();
      $su_document = SupportDocument::findOrfail($id);
      $su_document->update($requestData);
      echo json_encode(array('success'=>true));
    }


}

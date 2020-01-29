<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\Http\Controllers\Controller;
use App\Answer;

class AnswerController extends Controller
{
    public function index(){
      return view('cats.anwers');
    }

    public function get_answers(Request $request){
      $page= isset($_POST['page']) ? intval($_POST['page']):1;
     $rows= isset($_POST['rows']) ? intval($_POST['rows']):10;
     $offset = ($page-1)*$rows;
     $sql="select count(*) from answers";

     $host=config('database.connections.mysql.host');
     $username=config('database.connections.mysql.username');
     $password=config('database.connections.mysql.password');
     $db_name=config('database.connections.mysql.database');
     $connection=mysqli_connect("$host","$username","$password") or die("cannot connect server");
     $database=mysqli_select_db($connection,"$db_name") or die("cannot select db");
     $rs=mysqli_query($connection,$sql);
     $row=mysqli_fetch_row($rs);
     $result["total"]= $row[0];

     $answers=Answer::orderBy('id','asc')->skip($offset)->take($rows)->get();
     $items=array();
     foreach($answers as $answer){
       array_push($items, $answer);
     }
     $result["rows"]=$items;
     // $row=$profiles->toArray($profiles);
     echo json_encode($result);
    }

    public function save_answers(Request $request){
        $rules = [
          'answer'=>'required',
          'answer_value'=>'required'
        ];
        $this->validate($request, $rules);
        $answer = new Answer();
        $answer->answer = $request->answer;
        $answer->answer_value = $request->answer_value;
        $answer->save();
        echo json_encode(array('success'=>true));
    }

    public function update_answers(Request $request, $id){
      $requestData = $request->all();
      $answer = Answer::findOrfail($id);
      $answer->update($requestData);
      echo json_encode(array('success'=>true));
    }
}

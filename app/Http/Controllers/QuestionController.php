<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;

class QuestionController extends Controller
{
    public function index(){
      return view('cats.questions');
    }

    public function get_questions(Request $request){
    $page= isset($_POST['page']) ? intval($_POST['page']):1;
     $rows= isset($_POST['rows']) ? intval($_POST['rows']):10;
     $offset = ($page-1)*$rows;
     $sql="select count(*) from questions";

     $host=config('database.connections.mysql.host');
     $username=config('database.connections.mysql.username');
     $password=config('database.connections.mysql.password');
     $db_name=config('database.connections.mysql.database');
     $connection=mysqli_connect("$host","$username","$password") or die("cannot connect server");
     $database=mysqli_select_db($connection,"$db_name") or die("cannot select db");
     $rs=mysqli_query($connection,$sql);
     $row=mysqli_fetch_row($rs);
     $result["total"]= $row[0];

     $questions=Question::orderBy('id','asc')->skip($offset)->take($rows)->get();
     $items=array();
     foreach($questions as $question){
       array_push($items, $question);
     }
     $result["rows"]=$items;
     // $row=$profiles->toArray($profiles);
     echo json_encode($result);
    }

    public function save_questions(Request $request){
        $rules = [
          'question'=>'required'
        ];
        $this->validate($request, $rules);
        $question = new Question();
        $question->question = $request->question;
        $question->save();
        echo json_encode(array('success'=>true));
    }

    public function update_questions(Request $request, $id){
      $requestData = $request->all();
      $question = Question::findOrfail($id);
      $question->update($requestData);
      echo json_encode(array('success'=>true));
    }
}

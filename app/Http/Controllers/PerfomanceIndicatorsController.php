<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GovernmentAgency;
use App\Employee;
use App\Question;
use App\QuestionAnswer;
use App\EmployeeQuestionAnswer;

class PerfomanceIndicatorsController extends Controller
{
    public function index(Request $request){
      $government_agencies = GovernmentAgency::orderBy('id')->get();
      return view('perfomance_indicators.login', compact('government_agencies',$government_agencies));
    }

    public function employees_evaluations(Request $request){
      $rules = [
        'government_agency_id'=>'required',
        'token'=>'required|min:4|max:4'
      ];
      $this->validate($request, $rules);
      $parent_tokent = $request->token;
      $government_agency_id = $request->government_agency_id;
      $evaluate_employees = Employee::orderBy('id')->where([['parent_token', $parent_tokent],['government_agency_id',$government_agency_id]])->get();
      return view('perfomance_indicators.employee_list', compact('evaluate_employees', $evaluate_employees));


    }
    public function get_question(Request $request){
      $questions = Question::orderBy('id')->get();
      return $questions;
    }

    public function evaluaciones(Request $request, $token){
      $questions = Question::with('answers.answer')->orderBy('id')->get();
      $employee = Employee::where('token', $token)->first();
      return view('perfomance_indicators.evaluation',compact('questions',$questions,'employee', $employee));
    }

    public function save_results(Request $request){
      $rules = [
        'employee_token'=>'required|min:4|max:4'
      ];
      $employee = Employee::where('token', $request->employee_token)->first();
      $question_ids = Question::orderBy('id')->pluck('id')->toArray();
      foreach ($question_ids as $key => $question_id) {
        $result = new EmployeeQuestionAnswer();
        $result->employee_id = $employee->id;
        $result->question_id = $question_id;
        $result->answer_id = $request->$question_id;
        $result->save();
      }
      return redirect('/evaluacion_desempeño');
    }
}

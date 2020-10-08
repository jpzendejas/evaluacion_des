<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GovernmentAgency;
use App\Employee;
use App\Mail\NuevaEvaluacion;
use App\Question;
use App\QuestionAnswer;
use App\EmployeeQuestionAnswer;
use Mail;

class PerfomanceIndicatorsController extends Controller
{
    public function index(Request $request){
      $government_agencies = GovernmentAgency::orderBy('id')->get();
      return view('perfomance_indicators.login', compact('government_agencies',$government_agencies));
    }

    public function employees_evaluations(Request $request){
      $rules = [
        'government_agency_id'=>'required',
        'token'=>'required|min:2|max:4'
      ];
      $this->validate($request, $rules);
      $parent_tokent = $request->token;
      $government_agency_id = $request->government_agency_id;
      $evaluated_employees = EmployeeQuestionAnswer::groupBy('employee_id')->pluck('employee_id')->toArray();
      // $evaluate_employees = Employee::orderBy('id')->where([['parent_token', $parent_tokent],['government_agency_id',$government_agency_id]])->get();
      $evaluate_employees = Employee::whereNotIn('id',$evaluated_employees)->where('parent_token','=',$parent_tokent)->get();

      $notification = array(
        'message' =>'Sin empleados para evaluar',
        'alert-type' => 'error'
      );
      if ($evaluate_employees->count() > 0) {
        return view('perfomance_indicators.employee_list', compact('evaluate_employees', $evaluate_employees));
      }else {
        return back()->with($notification);
      }



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
        'employee_token'=>'required|min:3|max:4'
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
      $notification = array(
        'message' =>'Evaluación creada correctamente',
        'alert-type' => 'success'
      );
      //here go email director
      // $user_email=Employee::where([['government_agency_id', $employee->government_agency_id],['email','<>','null']])->first();
      // if ($user_email->count() > 0) {
      //   Mail::to($user_email->email)->send(new NuevaEvaluacion($employee));
      // }
      return redirect('/evaluacion_desempeño')->with($notification);

    }
}

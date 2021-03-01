<?php

namespace App\Http\Controllers\org;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use DB;
use App\User;
use Illuminate\Http\Request;
use App\RegForm;
use App\RegFormInput;
use App\EventRegFormMapping;
use App\EventRegistration;
use App\EventRegAnswer;

class RegistrationFormController extends Controller
{
    public function __construct() {
        $this->middleware('verified');
    }
    
    public function index()
    {
        $user = Auth::user();

        $regForms = "select rf.*, group_concat(e.title SEPARATOR ', ') as eventTitle from reg_forms rf left join event_reg_form_mappings erfm on rf.id = erfm.reg_form_id left join events e on erfm.event_id = e.id GROUP BY rf.id";

        $regFormResults = DB::select(DB::raw($regForms));

        return view('org/regForms', compact('regFormResults'));
    }

    public function create()
    {
        $user = Auth::user();

        //$regForm = RegForm::all();
        $regFormInput =RegFormInput::all();
        return view('org/createRegistrationForm', compact('regFormInput'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //RegForm Entry
        $regForm = new RegForm;
        $regForm->title = $request->RegTitle;
        $regForm->save();

        //RegFormInput Entry
        $questionInputArray = $request->question_inputs;
        for ($i = 0; $i < count($questionInputArray); $i++) {
            $regFormInput = new RegFormInput;
            $regFormInput->reg_form_id = $regForm->id;
            $regFormInput->question = $questionInputArray[$i]['question_value'];

            if($questionInputArray[$i]['IsRequired'] == "true"){
                $regFormInput->is_inputRequired = 1;
            } else {
                $regFormInput->is_inputRequired = 0;
            }

            $regFormInput->answer_type = $questionInputArray[$i]['answer_type'];
            if($questionInputArray[$i]['answer_type'] != "1"){
                $regFormInput->answer_values = $questionInputArray[$i]['answerValues'];
            } else {
                $regFormInput->answer_values = "";
            }
            $regFormInput->save();
        }

   //      //RegForm Entry
   //      $regForm = new RegForm;
   //      $regForm->title = $request->RegTitle;
   //      $regForm->save();

   //      //RegFormInput Entry
   //      $regFormInput = new RegFormInput;
   //      $regFormInput->reg_form_id = $regForm->id;
   //      $regFormInput->answer_type = $request->regFormsSelect;

   //      if($request->regFormsSelect != 1){
   //      	$removeLastCommas = rtrim($request->hiddenAnswerValues, ',');
   //  		$hiddenAnswerValues = ltrim($removeLastCommas, ',');
   //  		$strSplit = preg_replace("/,+/", ",", $hiddenAnswerValues);
   //  		$strSplit1 = preg_split("/\,/", $strSplit);
			// $answerValues = implode("@~@", $strSplit1);
			// $regFormInput->answer_values = $answerValues;
   //      } else {
   //      	$regFormInput->answer_values = "";
   //      }

   //      $regFormInput->question = $request->question;
   //      if (isset($request->IsRequired)) {
   //          $regFormInput->is_inputRequired = 1;
   //      } else {
   //          $regFormInput->is_inputRequired = 0;
   //      }

   //      $regFormInput->save();

   //      return redirect('org/regForms');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($regFormid)
    {
        $user = Auth::user();
        $regForm = RegForm::findOrFail($regFormid);
        $regFormInput =RegFormInput::where("reg_form_id", $regForm->id)->orderBy('id', 'ASC')->get();

        return view('org/createRegistrationForm', compact('regForm', 'regFormInput'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $regFormid)
    {
        //RegForm Entry
        $regForm = RegForm::findOrFail($regFormid);
        $regForm->title = $request->RegTitle;
        $regForm->save();

        //RegFormInput Entry
        $questionInputArray = $request->question_inputs;
        $regFormInput =RegFormInput::where("reg_form_id", $regForm->id)->delete();
        for ($i = 0; $i < count($questionInputArray); $i++) {
            $regFormInput = new RegFormInput;
            $regFormInput->reg_form_id = $regForm->id;
            $regFormInput->question = $questionInputArray[$i]['question_value'];

            if($questionInputArray[$i]['IsRequired'] == "true"){
                $regFormInput->is_inputRequired = 1;
            } else {
                $regFormInput->is_inputRequired = 0;
            }

            $regFormInput->answer_type = $questionInputArray[$i]['answer_type'];
            if($questionInputArray[$i]['answer_type'] != "1"){
                $regFormInput->answer_values = $questionInputArray[$i]['answerValues'];
            } else {
                $regFormInput->answer_values = "";
            }
            $regFormInput->save();
        }


   //      //RegForm Entry
   //      $regForm = RegForm::findOrFail($regFormid);
   //      $regForm->title = $request->RegTitle;
   //      $regForm->save();

   //      //RegFormInput Entry
   //      $regFormInput =RegFormInput::where("reg_form_id", $regForm->id)->first();
   //      $regFormInput->reg_form_id = $regForm->id;
   //      $regFormInput->answer_type = $request->regFormsSelect;
   //      $regFormInput->question = $request->question;
   //      if (isset($request->IsRequired)) {
   //          $regFormInput->is_inputRequired = 1;
   //      } else {
   //          $regFormInput->is_inputRequired = 0;
   //      }
        
   //      if($request->regFormsSelect != 1){
   //  		$removeLastCommas = rtrim($request->hiddenAnswerValues, ',');
   //  		$hiddenAnswerValues = ltrim($removeLastCommas, ',');
   //  		$strSplit = preg_replace("/,+/", ",", $hiddenAnswerValues);
   //  		$strSplit1 = preg_split("/\,/", $strSplit);
			// $answerValues = implode("@~@", $strSplit1);
			// $regFormInput->answer_values = $answerValues;
   //      } else {
   //      	$regFormInput->answer_values = "";
   //      }

   //      $regFormInput->save();

   //      return redirect('org/regForms');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
    	//return $request->regFormDeleteId;
        EventRegFormMapping::where("reg_form_id", $request->regFormDeleteId)->delete();
        RegFormInput::where("reg_form_id", $request->regFormDeleteId)->delete();
        RegForm::find($request->regFormDeleteId)->delete();
    }

    public function deleteThisQue(Request $request)
    {
        RegFormInput::find($request->queFormDeleteId)->delete();
    }
}

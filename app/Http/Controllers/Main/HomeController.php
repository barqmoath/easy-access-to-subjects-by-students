<?php

namespace App\Http\Controllers\Main;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use App\Subject;
use Session;

class HomeController extends Controller
{
  /*
   * @ name    : index
   * @ param   : none
   * @ return  : view(home) with more data
   * @ work    : Get For Current User Subjects by Current department_id and stage_id
   */
  public function index()
  {
    if(!empty(Auth::user()->department_id) && !empty(Auth::user()->stage_id))
    {
      $subjects = Subject::where([['department_id','=',intval(Auth::user()->department_id)],['stage_id','=',intval(Auth::user()->stage_id)]])->orderBy('subject_name')->get();       
      //$subjects = DB::table('subjects')->where([['department_id','=',intval(Auth::user()->department_id)],['stage_id','=',intval(Auth::user()->stage_id)]])->orderBy('subject_name')->get();
      return view('main.home',compact('subjects',$subjects));
    }
    else
    {
      return view('main.home');
    }

  }// Index Function End  ---------


}

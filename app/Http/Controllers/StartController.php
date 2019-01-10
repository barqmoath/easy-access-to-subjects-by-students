<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use DB;
use Session;

class StartController extends Controller
{
  /*
   * @ name    : start
   * @ param   : none
   * @ return  : view(start) or  view(home)
   * @ work    : Check If Find User Login or Not And Display Home or Start
   */
  public function start()
  {
    if(Auth::check())
      return view('main.home');
    else
      return view('start');
  }// start Function End ---------

}

<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Year;
use DB;

class YearsController extends Controller
{
  public function index()
  {
    $years = DB::table('years')->orderBy('the_year')->get();
    return view('dashboard.years.years')->with('years',$years);
  }

  public function delete($year)
  {
    DB::table('years')->where('the_year',$year)->delete();
    return redirect(route('years'))->with('msg','Year Delete Successfuly');
  }

  public function new_year(Request $request)
  {
    $this->validate($request,[
      'the_year' => 'required|integer|min:4|Unique:years',
    ]);
    DB::table('years')->insert(['the_year' => $request->input('the_year')]);
    return redirect(route('years'))->with('msg','Year Added Successfuly');
  }
}

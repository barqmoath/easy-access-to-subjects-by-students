<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Stage;

class StagesController extends Controller
{
  public function index()
  {
    $stages = DB::table('stages')->orderBy('stage_name')->get();
    $departments = DB::table('departments')->orderBy('department_name')->get();
    return view('dashboard.stages.stages')->with('data',['departments' => $departments, 'stages' => $stages]);
  }

  public function new_stage(Request $request)
  {
    $this->validate($request,[
      'name' => 'required|string|max:255',
    ]);
    if($request->input('department') != 0)
    {
      $stage = new Stage();
      $stage->department_id = $request->input('department');
      $stage->stage_name = $request->input('name');
      $stage->save();
    }
    else
    {
      return redirect(route('stages'))->with('fmsg','Add Faild');
    }
    return redirect(route('stages'))->with('msg','New Stage Was Added Successfully');
  }

  public function delete($id)
  {
    if(is_numeric($id))
    {
      DB::table('stages')->where('id',$id)->delete();
      return redirect(route('stages'))->with('msg','Stage Delete Success');
    }
    return redirect(route('stages'))->with('fmsg','Stage Delete Faild');
  }

  public function edit_show($id)
  {
    if(is_numeric($id))
    {
      $stage = DB::table('stages')->where('id',$id)->get()->first();
      return view('dashboard.stages.edit')->with('stage',$stage);
    }
    return redirect(route('stages'))->with('fmsg','Faild Message');
  }

  public function edit(Request $request)
  {
    $this->validate($request,[
      'name' => 'required|string|max:255',
      'id'   =>'required|integer',
    ]);
    DB::table('stages')->where('id',$request->input('id'))->update(['stage_name' => $request->input('name')]);
    return redirect(route('stages'))->with('msg','Stage Edit Success');
  }
}

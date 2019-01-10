<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Department;

class DepartmentsController extends Controller
{
  public function index()
  {
    $departments = DB::table('departments')->orderBy('department_name')->get();
    return view('dashboard.departments.departments')->with('departments',$departments);
  }

  public function new_department(Request $request)
  {
    $this->validate($request,[
      'department_name' => 'required|string|max:255|Unique:departments',
    ]);

    $department = new Department();
    $department->slug = strtolower(str_replace([' ','&','+','.','"','?','#','@','<','>','{','}','[',']','÷','*','%','$','(',')','_',',','،','='],'-',$request->input('department_name')));
    $department->department_name = $request->input('department_name');
    $department->save();
    return redirect(route('departments'))->with('msg','New Department Was Added Successfully');
  }

  public function delete($slug)
  {
      DB::table('departments')->where('slug',$slug)->delete();
      return redirect(route('departments'))->with('msg','Department Delete Success');
  }

  public function edit_show($slug)
  {
    if(DB::table('departments')->where('slug',$slug)->count() > 0)
    {
      $departments = DB::table('departments')->where('slug',$slug)->first();
      return view('dashboard.departments.edit')->with('departments',$departments);
    }
    else
    {
      return redirect(route('departments'))->with('fmsg','Department Not Found');
    }
  }

  public function edit_save(Request $request)
  {
    $this->validate($request,[
      'name' => 'required|string|max:255',
    ]);
    $slug = strtolower(str_replace([' ','&','+','.','"','?','#','@','<','>','{','}','[',']','÷','*','%','$','(',')','_',',','،','='],'-',$request->input('name')));
    $id   = $request->input('id');
    $name = $request->input('name');
    DB::table('departments')->where('id',$id)->update(['slug' => $slug,'department_name' => $name]);
    return redirect(route('departments'))->with('msg','Department Edit Success');
  }
}

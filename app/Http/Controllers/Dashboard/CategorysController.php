<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Category;

class CategorysController extends Controller
{
  public function index()
  {
    $categorys = DB::table('categories')->orderBy('category_name')->get();
    return view('dashboard.categorys.categorys')->with('categorys',$categorys);
  }

  public function new_category(Request $request)
  {
    $this->validate($request,[
      'category_name' => 'required|string|max:255|Unique:categories',
    ]);
    $category = new Category();
    $category->slug = strtolower(str_replace([' ','&','+','.','"','?','#','@','<','>','{','}','[',']','÷','*','%','$','(',')','_',',','،','='],'-',$request->input('category_name')));
    $category->category_name = $request->input('category_name');
    $category->save();
    return redirect(route('categorys'))->with('msg','New Category Was Added Successfully');
  }

  public function delete($slug)
  {
    DB::table('categories')->where('slug',$slug)->delete();
    return redirect(route('categorys'))->with('msg','Category Delete Success');
  }

  public function edit_show($slug)
  {
    $category = DB::table('categories')->where('slug',$slug)->get()->first();
    return view('dashboard.categorys.edit')->with('category',$category);
  }

  public function edit_save(Request $request)
  {
    $this->validate($request,[
      'id'   => 'required|integer',
      'category_name' => 'required|string|max:255',
    ]);
    $id  = $request->input('id');
    $slug = strtolower(str_replace([' ','&','+','.','"','?','#','@','<','>','{','}','[',']','÷','*','%','$','(',')','_',',','،','='],'-',$request->input('category_name')));
    $name = $request->input('category_name');
    DB::table('categories')->where('id',$id)->update(['slug' => $slug,'category_name' => $name]);
    return redirect(route('categorys'))->with('msg','Category Edit Success');
  }

}

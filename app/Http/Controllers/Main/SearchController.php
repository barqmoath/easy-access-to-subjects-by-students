<?php

namespace App\Http\Controllers\Main;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;

class SearchController extends Controller
{

  public function __construct()
  {
    // Chek User Complete The Profile Setting Department and Stage or Not
    $this->middleware('checkDS');
  }// Contstruct End --------


  public function index()
  {
    return view('main.search.search');
  }

  public function search(Request $request)
  {
    $searchText = $request->input('txt');
    $results = DB::table('items')->join('users','items.user_id','=','users.id')->join('departments','items.department_id','=','departments.id')->join('stages','items.stage_id','=','stages.id')->join('subjects','items.subject_id','=','subjects.id')->join('categories','items.category_id','=','categories.id')
                                 ->select(['items.id as itemid','items.item_year as itemyear','items.title as itemtitle','items.discription as itemdiscription','items.file as itemfile','items.created_at as itemuploaddate','users.id as userid','users.name as username','users.photo as userphoto','users.facebook_link as userfacebook','departments.department_name as departmentname','stages.stage_name as stagename','subjects.subject_name as subjectname','categories.category_name as categoryname'])
                                 ->where([['items.department_id','=',Auth::user()->department_id],['items.stage_id','=',Auth::user()->stage_id]  ])
                                 ->where('items.title','like','%'.$searchText.'%')
                                 ->orwhere('items.discription','like','%'.$searchText.'%')
                                 ->orwhere('items.item_year','like','%'.$searchText.'%')
                                 ->orwhere('users.name','like','%'.$searchText.'%')
                                 ->orwhere('subjects.subject_name','like','%'.$searchText.'%')
                                 ->orwhere('categories.category_name','like','%'.$searchText.'%')
                                 ->orderBy('items.created_at','desc')
                                 ->paginate(12);
    return view('main.search.search')->with('results',$results);
  }
}

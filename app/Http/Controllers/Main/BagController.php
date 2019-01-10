<?php

namespace App\Http\Controllers\Main;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Bag;
use DB;
use Auth;

class BagController extends Controller
{

  public function __construct()
  {
    // Chek User Complete The Profile Setting Department and Stage or Not
    $this->middleware('checkDS');
  }// Contstruct End --------


  /*
   * @ name    : index
   * @ param   : none
   * @ return  : view(bag) with the items and more data
   * @ work    : Get Data From Current User Bag By (GET Request) isset or not
   */
  public function index()
  {
    $years = DB::table('years')->orderBy('the_year')->get();
    $categories = DB::table('categories')->orderBy('category_name')->get();
    $subjects = DB::table('subjects')->where([['department_id','=',Auth::user()->department_id],['stage_id','=',Auth::user()->stage_id]])->orderBy('subject_name')->get();
    $items = [];

    // Current Study Year Data
    if(!isset($_GET['year']) && !isset($_GET['cat']) && !isset($_GET['sub']))
    {
      $items = DB::table('bags')->join('items','bags.item_id','=','items.id')
                                ->join('subjects','items.subject_id','=','subjects.id')
                                ->join('departments','items.department_id','=','departments.id')
                                ->join('stages','items.stage_id','=','stages.id')
                                ->join('categories','items.category_id','=','categories.id')
                                ->select(['items.id as itemid','items.title as itemtitle','items.discription as itemdiscription','items.item_year as itemyear','subjects.subject_name as subjectname','subjects.cover as subjectcover','departments.department_name as departmentname','stages.stage_name as stagename','categories.category_name as categoryname','bags.created_at as addeddate'])
                                ->where([['bags.user_id','=',Auth::user()->id],['items.item_year','=',date("Y")]])
                                ->orderBy('bags.created_at','desc')
                                ->get();
      return view('auth.profile.bag')->with(['years' => $years, 'categories' => $categories, 'items' => $items, 'subjects' => $subjects]);
    }
    // Data By Year
    elseif(!isset($_GET['sub'])  && isset($_GET['year']) && !isset($_GET['cat']) && DB::table('years')->where('the_year',intval($_GET['year']))->count() > 0 )
    {
      $items = DB::table('bags')->join('items','bags.item_id','=','items.id')
                                ->join('subjects','items.subject_id','=','subjects.id')
                                ->join('departments','items.department_id','=','departments.id')
                                ->join('stages','items.stage_id','=','stages.id')
                                ->join('categories','items.category_id','=','categories.id')
                                ->select(['items.id as itemid','items.title as itemtitle','items.discription as itemdiscription','items.item_year as itemyear','subjects.subject_name as subjectname','subjects.cover as subjectcover','departments.department_name as departmentname','stages.stage_name as stagename','categories.category_name as categoryname','bags.created_at as addeddate'])
                                ->where([['bags.user_id','=',Auth::user()->id],['items.item_year','=',intval($_GET['year'])]])
                                ->orderBy('bags.created_at','desc')
                                ->get();
      return view('auth.profile.bag')->with(['years' => $years, 'categories' => $categories, 'items' => $items, 'subjects' => $subjects]);
    }
    // Data By Category
    elseif(!isset($_GET['sub'])  && !isset($_GET['year']) && isset($_GET['cat']) && DB::table('categories')->where('slug',$_GET['cat'])->count() > 0)
    {
      $cat_id = DB::table('categories')->where('slug',$_GET['cat'])->select('id')->get()->first();
      $items = DB::table('bags')->join('items','bags.item_id','=','items.id')
                                ->join('subjects','items.subject_id','=','subjects.id')
                                ->join('departments','items.department_id','=','departments.id')
                                ->join('stages','items.stage_id','=','stages.id')
                                ->join('categories','items.category_id','=','categories.id')
                                ->select(['items.id as itemid','items.title as itemtitle','items.discription as itemdiscription','items.item_year as itemyear','subjects.subject_name as subjectname','subjects.cover as subjectcover','departments.department_name as departmentname','stages.stage_name as stagename','categories.category_name as categoryname','bags.created_at as addeddate'])
                                ->where([['bags.user_id','=',Auth::user()->id],['items.category_id','=',$cat_id->id]])
                                ->orderBy('bags.created_at','desc')
                                ->get();
      return view('auth.profile.bag')->with(['years' => $years, 'categories' => $categories, 'items' => $items, 'subjects' => $subjects]);
    }
    // Data By Subject
    elseif(isset($_GET['sub']) && DB::table('subjects')->where([['department_id','=',Auth::user()->department_id],['stage_id','=',Auth::user()->stage_id],['slug','=',$_GET['sub']]]) && !isset($_GET['year']) && !isset($_GET['cat']))
    {
      $sub_id = DB::table('subjects')->where('slug','=',$_GET['sub'])->select('id')->get()->first();
      $items = DB::table('bags')->join('items','bags.item_id','=','items.id')
                                ->join('subjects','items.subject_id','=','subjects.id')
                                ->join('departments','items.department_id','=','departments.id')
                                ->join('stages','items.stage_id','=','stages.id')
                                ->join('categories','items.category_id','=','categories.id')
                                ->select(['items.id as itemid','items.title as itemtitle','items.discription as itemdiscription','items.item_year as itemyear','subjects.subject_name as subjectname','subjects.cover as subjectcover','departments.department_name as departmentname','stages.stage_name as stagename','categories.category_name as categoryname','bags.created_at as addeddate'])
                                ->where([['bags.user_id','=',Auth::user()->id],['items.subject_id','=',$sub_id->id]])
                                ->orderBy('bags.created_at','desc')
                                ->get();
      return view('auth.profile.bag')->with(['years' => $years, 'categories' => $categories, 'items' => $items, 'subjects' => $subjects]);
    }
    else
    {
      return redirect(route('bag.index'));
    }
  }// Index Function End ------------


  /*
   * @ name   : empty_bag
   * @ param  : none
   * @ return : Back
   * @ work   : delete All Items From The Current User Bag
   */
  public function empty_bag()
  {
    DB::table('bags')->where('user_id',intval(Auth::user()->id))->delete();
    return back()->with('msg','Your Bag is Empty Now !');
  }// Empty Bag Function End


  /*
   * @ name   : item_delete
   * @ param  : [ $id -> ineteger type -> is item id]
   * @ return : Back
   * @ work   : delete One item From Current User Bag By ID Value
   */
  public function item_delete($id)
  {
    if(is_numeric($id) && DB::table('items')->where('id',$id)->count() > 0)
    {
      DB::table('bags')->where([['user_id','=',intval(Auth::user()->id)],['item_id','=',intval($id)]])->delete();
      return back()->with('msg','Items Removed From Your Bag !');
    }
    else
    {
      return redirect(route('bag.index'));
    }
  }// item_delete Function End -------

}

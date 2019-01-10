<?php
namespace App\Http\Controllers\Main;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Department;
use App\Stage;
use App\Subject;
use App\Item;
use App\Category;
use App\Year;
use App\Setting;
use DB;
use Auth;

class LibraryController extends Controller
{
  public function __construct()
  {
    // Chek User Complete The Profile Setting Department and Stage or Not
    $this->middleware('checkDS');
  }// Contstruct End --------

  public function index()
  {
    $departments      = Department::orderBy('department_name')->get();
    $stages           = Stage::orderBy('stage_name')->get();
    $subjects         = Subject::where([['department_id','=',Auth::user()->department_id],['stage_id','=',Auth::user()->stage_id]])->orderBy('subject_name')->get();
    return view('main.library.library')->with([
      'departments'  => $departments,
      'stages'       => $stages,
      'subjects'     => $subjects
    ]);
  }// index Function End -----

  public function lib($department_slug,$stage_id)
  {
    if(DB::table('departments')->where('slug',$department_slug)->count() > 0 && is_numeric($stage_id) && DB::table('stages')->where('id',$stage_id)->count() > 0)
    {
      $department  = DB::table('departments')->where('slug',$department_slug)->first();
      $depID       = $department->id;
      $stage       = DB::table('stages')->where([['id',$stage_id],['department_id','=',$depID]])->first();
      $stgID       = $stage->id;
      $subjects    = Subject::orderBy('subject_name')->where([['department_id','=',$depID],['stage_id','=',$stgID]])->get();

      //
      $departments      = Department::orderBy('department_name')->get();
      $stages           = Stage::orderBy('stage_name')->get();
      // Return Data
      return view('main.library.library')->with([
        'departments'     => $departments,
        'stages'          => $stages,
        'custom_subjects' => $subjects,
        'department_name' => $department->department_name,
        'stage_name'      => $stage->stage_name
      ]);
    }
    else
    {
      return redirect(route('home'));
    }
  }// lib Function End ---------

  public function sub($subject_slug,$depID,$stgID)
  {
    if(DB::table('subjects')->where('slug',$subject_slug)->count('id') > 0 && DB::table('departments')->where('id',$depID)->count('id') > 0 && DB::table('stages')->where('id',$stgID)->count('id') >0)
    {
      $categories = Category::all();
      $years      = Year::all();
      $subjects   = Subject::where([['department_id','=',$depID],['stage_id','=',$stgID]])->orderBy('subject_name')->get();

      // Find Current Subject
      $subject = DB::table('subjects')->join('departments','department_id','=','departments.id')->join('stages','stage_id','=','stages.id')
                                ->select([
                                  'subjects.id as subjectid',
                                  'subjects.slug as subjectslug',
                                  'subjects.department_id as departmentid',
                                  'subjects.stage_id as stageid',
                                  'subjects.subject_name as subjectname',
                                  'departments.department_name as departmentname',
                                  'stages.stage_name as stagename'
                                ])
                                ->where([
                                  ['subjects.slug','=',$subject_slug],
                                  ['subjects.department_id','=',$depID],
                                  ['subjects.stage_id','=',$stgID]
                                ])
                                ->first();
      $subjectID = $subject->subjectid;

      // Count Items in This Subject
      $subject_items_counter = DB::table('items')->where('subject_id',$subjectID)->count('id');

      // Data By Category Only
      if(isset($_GET['cat']) && DB::table('categories')->where('slug',$_GET['cat'])->count() > 0 && !isset($_GET['year']))
      {
        $category = DB::table('categories')->where('slug',$_GET['cat'])->select(['id','category_name'])->get()->first();
        $catID    = $category->id;
        $items = DB::table('items')->join('users','items.user_id','=','users.id')->join('departments','items.department_id','=','departments.id')->join('stages','items.stage_id','=','stages.id')->join('subjects','items.subject_id','=','subjects.id')->join('categories','items.category_id','=','categories.id')
                                   ->select(['items.id as itemid','items.item_year as itemyear','items.title as itemtitle','items.discription as itemdiscription','items.file as itemfile','items.created_at as itemuploaddate','users.id as userid','users.name as username','users.photo as userphoto','users.facebook_link as userfacebook','departments.department_name as departmentname','stages.stage_name as stagename','subjects.subject_name as subjectname','categories.category_name as categoryname'])
                                   ->where([['items.subject_id','=',intval($subjectID)],['items.category_id','=',intval($catID)],['items.item_year','=',Setting::where('name','current-year')->pluck('value')->all()]])
                                   ->orderBy('items.created_at','desc')
                                   ->paginate(15);
        $text = $category->category_name .' - ' . 'This Year';
      }
      // Data By Year Only
      elseif(isset($_GET['year']) && DB::table('years')->where('the_year',$_GET['year'])->count() > 0 && !isset($_GET['cat']))
      {
        $items = DB::table('items')->join('users','items.user_id','=','users.id')->join('departments','items.department_id','=','departments.id')->join('stages','items.stage_id','=','stages.id')->join('subjects','items.subject_id','=','subjects.id')->join('categories','items.category_id','=','categories.id')
                                   ->select(['items.id as itemid','items.item_year as itemyear','items.title as itemtitle','items.discription as itemdiscription','items.file as itemfile','items.created_at as itemuploaddate','users.id as userid','users.name as username','users.photo as userphoto','users.facebook_link as userfacebook','departments.department_name as departmentname','stages.stage_name as stagename','subjects.subject_name as subjectname','categories.category_name as categoryname'])
                                   ->where([['items.subject_id','=',intval($subjectID)],['items.item_year','=',intval($_GET['year'])]])
                                   ->orderBy('items.created_at','desc')
                                   ->paginate(15);
        $text = 'All Categories' .' - ' . $_GET['year'];
      }
      // Data By Category and Year
      elseif(isset($_GET['cat']) && DB::table('categories')->where('slug',$_GET['cat'])->count() > 0 && isset($_GET['year']) && DB::table('years')->where('the_year',$_GET['year'])->count() > 0)
      {
        $category = DB::table('categories')->where('slug',$_GET['cat'])->select(['id','category_name'])->get()->first();
        $catID    = $category->id;
        $items = DB::table('items')->join('users','items.user_id','=','users.id')->join('departments','items.department_id','=','departments.id')->join('stages','items.stage_id','=','stages.id')->join('subjects','items.subject_id','=','subjects.id')->join('categories','items.category_id','=','categories.id')
                                   ->select(['items.id as itemid','items.item_year as itemyear','items.title as itemtitle','items.discription as itemdiscription','items.file as itemfile','items.created_at as itemuploaddate','users.id as userid','users.name as username','users.photo as userphoto','users.facebook_link as userfacebook','departments.department_name as departmentname','stages.stage_name as stagename','subjects.subject_name as subjectname','categories.category_name as categoryname'])
                                   ->where([['items.subject_id','=',intval($subjectID)],['items.category_id','=',intval($catID)],['items.item_year','=',intval($_GET['year'])]])
                                   ->orderBy('items.created_at','desc')
                                   ->paginate(15);
        $text = $category->category_name .' - ' . $_GET['year'];
      }
      // Data Using Search
      elseif(isset($_GET['searchQuery']))
      {
        $items = DB::table('items')->join('users','items.user_id','=','users.id')->join('departments','items.department_id','=','departments.id')->join('stages','items.stage_id','=','stages.id')->join('subjects','items.subject_id','=','subjects.id')->join('categories','items.category_id','=','categories.id')
                                   ->select(['items.id as itemid','items.item_year as itemyear','items.title as itemtitle','items.discription as itemdiscription','items.file as itemfile','items.created_at as itemuploaddate','users.id as userid','users.name as username','users.photo as userphoto','users.facebook_link as userfacebook','departments.department_name as departmentname','stages.stage_name as stagename','subjects.subject_name as subjectname','categories.category_name as categoryname'])
                                   ->where([['items.subject_id','=',intVal($subjectID)],['items.department_id','=',intVal($depID)],['items.stage_id','=',intVal($stgID)]])
                                   ->where('items.title','like','%'.$_GET['searchQuery'].'%')
                                   ->orwhere('items.discription','like','%'.$_GET['searchQuery'].'%')
                                   ->orderBy('items.created_at','desc')
                                   ->paginate(20);
        $text = count($items) . ' ' . 'Search Results';
      }
      // Data By This Year
      else
      {
        $items = DB::table('items')->join('users','items.user_id','=','users.id')->join('departments','items.department_id','=','departments.id')->join('stages','items.stage_id','=','stages.id')->join('subjects','items.subject_id','=','subjects.id')->join('categories','items.category_id','=','categories.id')
                                   ->select(['items.id as itemid','items.item_year as itemyear','items.title as itemtitle','items.discription as itemdiscription','items.file as itemfile','items.created_at as itemuploaddate','users.id as userid','users.name as username','users.photo as userphoto','users.facebook_link as userfacebook','departments.department_name as departmentname','stages.stage_name as stagename','subjects.subject_name as subjectname','categories.category_name as categoryname'])
                                   ->where([['items.subject_id','=',intval($subjectID)],['items.item_year','=',Setting::where('name','current-year')->pluck('value')->all()]])
                                   ->orderBy('items.created_at','desc')
                                   ->paginate(15);
        $text = 'All Categories' .' - ' . 'This Year';
      }

      return view('main.library.subject-browse')->with([
        'categories'      => $categories,
        'years'           => $years,
        'subjects'        => $subjects,
        'itemscounter'    => $subject_items_counter,
        'items'           => $items,
        'subject'         => $subject,
        'text'            => $text
      ]);
    }
    else
    {
      return redirect(route('home'));
    }
  }// sub Function End ----------

}

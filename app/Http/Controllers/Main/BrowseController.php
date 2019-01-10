<?php
namespace App\Http\Controllers\Main;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Subject;
use App\Category;
use App\Year;
use App\Like;
use App\Setting;
use DB;
use Auth;


class BrowseController extends Controller
{

  public function __construct()
  {
    // Chek User Complete The Profile Setting Department and Stage or Not
    $this->middleware('checkDS');
  }// Contstruct End --------

  /**
   * @ Index Function
   * @ Dispaly Items in Selected Subject By Year or Category
   */
  public function index($slug)
  {
    if(DB::table('subjects')->where('slug',$slug)->count() > 0)
    {
      $categories          = Category::all();
      $years               = Year::all();
      $subjects            = Subject::where([['department_id','=',Auth::user()->department_id],['stage_id','=',Auth::user()->stage_id]])->orderBy('subject_name')->get();
      $subject             = DB::table('subjects')->where('slug',$slug)->select(['id','slug','subject_name','cover'])->get()->first();
      $subjectID           = $subject->id;
      $subject_items_counter = DB::table('items')->where('subject_id',$subjectID)->count();

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
                                   ->where('items.subject_id',intVal($subjectID))
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
      return view('main.browse.index')->with(['categories' => $categories, 'years' => $years,'subject' => $subject ,'items' => $items,'text' => $text, 'subject_item_counter' => $subject_items_counter, 'subjects' => $subjects]);
    }
    else
    {
      return redirect(route('home'));
    }
  }// Index Function End ---------


  /**
   *  @ Function to Display One Item With Info
   */
  public function item_view($id)
  {
    if(is_numeric($id) && DB::table('items')->where('id',intval($id))->count() > 0)
    {
      $item = DB::table('items')->join('users','items.user_id','=','users.id')->join('departments','items.department_id','=','departments.id')->join('stages','items.stage_id','=','stages.id')->join('subjects','items.subject_id','=','subjects.id')->join('categories','items.category_id','=','categories.id')
                                ->select(['items.id as itemid','items.item_year as itemyear','items.title as itemtitle','items.discription as itemdiscription','items.file as itemfile','items.created_at as itemuploaddate','users.id as userid','users.name as username','items.department_id as departmentid','departments.department_name as departmentname','items.stage_id as stageid','stages.stage_name as stagename','subjects.subject_name as subjectname','categories.category_name as categoryname'])
                                ->where('items.id',intval($id))
                                ->get()->first();
      $comments = DB::table('comments')->join('users','comments.user_id','=','users.id')->select(['comments.id as commentid','comments.the_comment as comment','comments.created_at as commentdatetime','users.id as userid','users.name as username','users.photo as userphoto', 'users.facebook_link as userfacebook'])
                                       ->where('comments.item_id',$item->itemid)
                                       ->orderBy('comments.created_at','desc')->get();
      $likes   = DB::table('likes')->where('item_id',$item->itemid)->select(['item_id','user_id'])->get();
      $bags    = DB::table('bags')->where('item_id',$item->itemid)->select(['item_id','user_id'])->get();
      $lovers  = DB::table('likes')->join('users','likes.user_id','=','users.id')
                                   ->select(['users.id as userid','users.name as username', 'users.photo as userphoto'])
                                   ->where('likes.item_id',$item->itemid)
                                   ->orderBy('likes.created_at','desc')->get();
      return view('main.browse.item')->with(['item' => $item, 'comments' => $comments, 'likes' => $likes, 'bags' => $bags, 'lovers' => $lovers]);
    }
    else
    {
      return redirect(route('home'));
    }
  }// Item_view Function End --------


  /**
   *  @ Function to Display One Subject Info
   */
  public function sub_view($subject_slug)
  {
    if(DB::table('subjects')->where('slug',$subject_slug)->count() > 0)
    {
      $subject = DB::table('subjects')->join('departments','department_id','=','departments.id')->join('stages','stage_id','=','stages.id')
                                ->select(['subjects.id as subjectid','subjects.department_id as sdeptid','subjects.stage_id as sstgid','subjects.slug as subjectslug','subjects.subject_name as subjectname','subjects.teacher_name as subjectteacher','subjects.discription as subjectdiscription','subjects.cover as subjectcover','departments.id as departmentid','departments.slug as departmentslug','departments.department_name as departmentname','stages.id as stageid','stages.stage_name as stagename'])
                                ->where('subjects.slug',$subject_slug)
                                ->get()->first();
      return view('main.browse.subject-view')->with(['subject' => $subject]);
    }
    else
    {
      return redirect(route('home'));
    }
  }//sub_view Funciton End -----------


  public function browse_all()
  {
    $items = DB::table('items')->join('users','items.user_id','=','users.id')->join('departments','items.department_id','=','departments.id')->join('stages','items.stage_id','=','stages.id')->join('subjects','items.subject_id','=','subjects.id')->join('categories','items.category_id','=','categories.id')
                               ->select(['items.id as itemid','items.item_year as itemyear','items.title as itemtitle','items.discription as itemdiscription','items.file as itemfile','items.created_at as itemuploaddate','users.id as userid','users.name as username','users.photo as userphoto','users.facebook_link as userfacebook','departments.department_name as departmentname','stages.stage_name as stagename','subjects.subject_name as subjectname','categories.category_name as categoryname'])
                               ->where([
                                        ['items.department_id','=',intval(Auth::user()->department_id)],
                                        ['items.stage_id','=',intval(Auth::user()->stage_id)],
                                        ['items.item_year','=',Setting::where('name','current-year')->pluck('value')->all()]
                                       ])
                               ->orderBy('items.created_at','desc')
                               ->paginate(10);
    return view('main.browse.all')->with('items',$items);
  }// browse_all Function End ------

  

}

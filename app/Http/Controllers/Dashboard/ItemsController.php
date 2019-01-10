<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\File;
use App\Http\Controllers\Controller;
use App\Item;
use DB;
use Auth;

class ItemsController extends Controller
{
  public function index($showState)
  {
    if($showState === 'all')
    {
      if(isset($_GET['sub']) && DB::table('subjects')->where('slug',$_GET['sub'])->count() > 0)
      {
        $subjects = DB::table('subjects')->where('slug',$_GET['sub'])->select('id','slug','department_id','stage_id','subject_name')->get()->first();
        $items = DB::table('items')->join('users','items.user_id','=','users.id')
                                   ->join('departments','items.department_id','=','departments.id')
                                   ->join('stages','items.stage_id','=','stages.id')
                                   ->join('subjects','items.subject_id','=','subjects.id')
                                   ->join('categories','items.category_id','=','categories.id')
                                   ->select([
                                     'items.id as itemid',
                                     'items.item_year as itemyear',
                                     'items.title as itemtitle',
                                     'items.discription as itemdiscription',
                                     'items.file as itemfile',
                                     'items.created_at as itemuploaddate',

                                     'users.id as userid',
                                     'users.name as username',

                                     'departments.department_name as departmentname',

                                     'stages.stage_name as stagename',

                                     'subjects.subject_name as subjectname',

                                     'categories.category_name as categoryname'
                                   ])
                                   ->where('items.subject_id',intval($subjects->id))
                                   ->orderBy('items.created_at','desc')
                                   ->paginate(10);
        return view('dashboard.items.viewItemsList')->with(['items' => $items, 'subject' => $subjects]);
      }
      else
      {
        return redirect(route('subjects.start'));
      }

    }
    elseif($showState === 'category')
    {

      if(isset($_GET['sub']) && isset($_GET['cat']) && DB::table('subjects')->where('slug',$_GET['sub'])->count() > 0 && DB::table('categories')->where('slug',$_GET['cat'])->count() > 0)
      {
        $subjects = DB::table('subjects')->where('slug',$_GET['sub'])->select('id','slug','department_id','stage_id','subject_name')->get()->first();
        $categories =  DB::table('categories')->where('slug',$_GET['cat'])->select('id')->get()->first();
        $items = DB::table('items')->join('users','items.user_id','=','users.id')
                                   ->join('departments','items.department_id','=','departments.id')
                                   ->join('stages','items.stage_id','=','stages.id')
                                   ->join('subjects','items.subject_id','=','subjects.id')
                                   ->join('categories','items.category_id','=','categories.id')
                                   ->select([
                                     'items.id as itemid',
                                     'items.item_year as itemyear',
                                     'items.title as itemtitle',
                                     'items.discription as itemdiscription',
                                     'items.file as itemfile',
                                     'items.created_at as itemuploaddate',

                                     'users.id as userid',
                                     'users.name as username',

                                     'departments.department_name as departmentname',

                                     'stages.stage_name as stagename',

                                     'subjects.subject_name as subjectname',

                                     'categories.category_name as categoryname'
                                   ])
                                   ->where([['items.subject_id','=',intval($subjects->id)],['items.category_id','=',intval($categories->id)]])
                                   ->orderBy('items.created_at','desc')
                                   ->paginate(10);
        return view('dashboard.items.viewItemsList')->with(['items' => $items, 'subject' => $subjects]);
      }
      else
      {
        return redirect(route('subjects.start'));
      }

    }
    elseif($showState === 'year')
    {
      if(isset($_GET['sub']) && isset($_GET['yr']) && DB::table('subjects')->where('slug',$_GET['sub'])->count() > 0 && DB::table('years')->where('the_year',$_GET['yr'])->count() > 0)
      {
        $subjects = DB::table('subjects')->where('slug',$_GET['sub'])->select('id','slug','department_id','stage_id','subject_name')->get()->first();
        $items = DB::table('items')->join('users','items.user_id','=','users.id')
                                   ->join('departments','items.department_id','=','departments.id')
                                   ->join('stages','items.stage_id','=','stages.id')
                                   ->join('subjects','items.subject_id','=','subjects.id')
                                   ->join('categories','items.category_id','=','categories.id')
                                   ->select([
                                     'items.id as itemid',
                                     'items.item_year as itemyear',
                                     'items.title as itemtitle',
                                     'items.discription as itemdiscription',
                                     'items.file as itemfile',
                                     'items.created_at as itemuploaddate',

                                     'users.id as userid',
                                     'users.name as username',

                                     'departments.department_name as departmentname',

                                     'stages.stage_name as stagename',

                                     'subjects.subject_name as subjectname',

                                     'categories.category_name as categoryname'
                                   ])
                                   ->where([['items.subject_id','=',intval($subjects->id)],['items.item_year','=',$_GET['yr']]])
                                   ->orderBy('items.created_at','desc')
                                   ->paginate(10);
        return view('dashboard.items.viewItemsList')->with(['items' => $items, 'subject' => $subjects]);
      }
      else
      {
        return redirect(route('subjects.start'));
      }
    }
    elseif($showState === 'category-and-year')
    {
      if(isset($_GET['sub']) && isset($_GET['cat']) && isset($_GET['yr']) && DB::table('subjects')->where('slug',$_GET['sub'])->count() > 0 && DB::table('categories')->where('slug',$_GET['cat'])->count() > 0 && DB::table('years')->where('the_year',$_GET['yr'])->count() > 0)
      {
        $subjects = DB::table('subjects')->where('slug',$_GET['sub'])->select('id','slug','department_id','stage_id','subject_name')->get()->first();
        $categories =  DB::table('categories')->where('slug',$_GET['cat'])->select('id')->get()->first();
        $items = DB::table('items')->join('users','items.user_id','=','users.id')
                                   ->join('departments','items.department_id','=','departments.id')
                                   ->join('stages','items.stage_id','=','stages.id')
                                   ->join('subjects','items.subject_id','=','subjects.id')
                                   ->join('categories','items.category_id','=','categories.id')
                                   ->select([
                                     'items.id as itemid',
                                     'items.item_year as itemyear',
                                     'items.title as itemtitle',
                                     'items.discription as itemdiscription',
                                     'items.file as itemfile',
                                     'items.created_at as itemuploaddate',

                                     'users.id as userid',
                                     'users.name as username',

                                     'departments.department_name as departmentname',

                                     'stages.stage_name as stagename',

                                     'subjects.subject_name as subjectname',

                                     'categories.category_name as categoryname'
                                   ])
                                   ->where([['items.subject_id','=',intval($subjects->id)],['items.category_id','=',intval($categories->id)],['items.item_year','=',$_GET['yr']]])
                                   ->orderBy('items.created_at','desc')
                                   ->paginate(10);
        return view('dashboard.items.viewItemsList')->with(['items' => $items, 'subject' => $subjects]);
      }
      else
      {
        return redirect(route('subjects.start'));
      }

    }
    else
    {
      return redirect(route('subjects.start'));
    }
  } // ----------------------------------------------------------------------------------------------------------

  /*
   * This Function to View Upload or Edit Form by $view Parameter
   */
  public function upload_edit_forms_view($view)
  {
    if($view === 'upload' && isset($_GET['dept']) && is_numeric($_GET['dept']) && DB::table('departments')->where('id',$_GET['dept'])->count() > 0 && isset($_GET['stg']) && is_numeric($_GET['stg']) && DB::table('stages')->where('id',$_GET['stg'])->count() > 0 && isset($_GET['sub']) && is_numeric($_GET['sub']) && DB::table('subjects')->where('id',$_GET['sub'])->count() > 0)
    {
      $subject = DB::table('subjects')->where('id',$_GET['sub'])->select(['id','slug','subject_name'])->get()->first();
      $department = DB::table('departments')->where('id',$_GET['dept'])->select(['id','department_name'])->get()->first();
      $stage = DB::table('stages')->where('id',$_GET['stg'])->select(['id','stage_name'])->get()->first();
      $categories = DB::table('categories')->orderBy('category_name')->get();
      $years = DB::table('years')->orderBy('the_year')->get();
      return view('dashboard.items.upload')->with(['subject' => $subject, 'department' => $department, 'stage' => $stage, 'categories' => $categories, 'years' => $years]);
    }
    elseif($view === 'edit' && isset($_GET['item']) && is_numeric($_GET['item']) && DB::table('items')->where('id',$_GET['item'])->count() > 0)
    {
      if(isset($_GET['uid']) && is_numeric($_GET['uid']) && DB::table('users')->where('id',intval($_GET['uid']))->count() > 0 && intval($_GET['uid']) === Auth::user()->id)
      {
        $item_data = DB::table('items')->where('id',$_GET['item'])->get()->first();
        $subject = DB::table('subjects')->where('id',$item_data->subject_id)->select(['id','slug','subject_name'])->get()->first();
        $department = DB::table('departments')->where('id',$item_data->department_id)->select(['id','department_name'])->get()->first();
        $stage = DB::table('stages')->where('id',$item_data->stage_id)->select(['id','stage_name'])->get()->first();
        return view('dashboard.items.edit')->with(['item_data' => $item_data, 'subject' => $subject, 'department' => $department, 'stage' => $stage]);
      }
      else
      {
        abort(403,'FORBIDDEN');
      }
    }
    else
    {
      abort(404,'NOT FOUND');
    }
  } // --------------------------------------------------------------------------------------------------------------

  /*
   * Function Upload ITEM by POST Request
   */
  public function upload(Request $request)
  {
    $file = '';
    $this->validate($request,[
      'department_id'   => 'required|integer',
      'stage_id'        => 'required|integer',
      'subject_id'      => 'required|integer',
      'category_id'     => 'required|integer',
      'year'            => 'required|integer',
      'title'           => 'required|string|max:255',
      'discription'     => 'required|string',
      'file'            => 'mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,txt,zip,rar'
    ]);

    if($request->hasFile('file'))
    {
      if($request->file('file')->isValid())
      {
        try
        {
          echo "<h1 style='font-size:2rem;font-weight:100;text-align:center;margin:50px;'>Uploading Please Wait ... </h1>";
          $file_store_path = './data/items/files/';
          $file = str_replace([' ','&','+','.','"','?','#','@','<','>','{','}','[',']','÷','*','%','$','(',')','_',',','،'],'_',$request->input('title')) . '_' . rand(111111111,999999999) . '.'.$request->file('file')->getClientOriginalExtension();
          $request->file('file')->move($file_store_path,$file);
        }
        catch(Illuminate\Filesystem\FileNotFoundException $e)
        {

        }
      }
    }

    $item = new Item();
    $item->user_id       = intval(Auth::user()->id);
    $item->stage_id      = intval($request->input('stage_id'));
    $item->department_id = intval($request->input('department_id'));
    $item->subject_id    = intval($request->input('subject_id'));
    $item->category_id   = intval($request->input('category_id'));
    $item->item_year     = intval($request->input('year'));
    $item->title         = $request->input('title');
    $item->discription   = $request->input('discription');
    $item->file          = $file;
    $item->save();
    // Redirect to Subject
    return back()->with('msg','Uploading Successfully');
  } // ----------------------------------------------------------------------------------------------------------------------------

  /*
   * Function To Edit Item
   */
  public function edit(Request $request)
  {
    $file = '';
    $this->validate($request,[
      'id'           => 'required|integer',
      'title'        => 'required|string|max:255',
      'discription'  => 'required|string',
      'file'         => 'mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,txt,zip,rar',
      'oldfile'      => 'required'
    ]);

    if($request->hasFile('file'))
    {
      if($request->file('file')->isValid())
      {
        echo "<h1 style='font-size:2rem;font-weight:100;text-align:center;margin:50px;'>Please Wait ... </h1>";
        $file = strtolower(str_replace([' ','&','+','.','"','?','#','@','<','>','{','}','[',']','÷','*','%','$','(',')','_',',','،'],'_',$request->input('title'))). '_' . rand(111111111,999999999) . '.'.$request->file('file')->getClientOriginalExtension();
        $request->file('file')->move('./data/items/files/',$file);
        if(!empty($request->input('oldfile')))
        {
          if(file_exists('./data/items/files/'. $request->input('oldfile')))
            unlink('./data/items/files/'.$request->input('oldfile'));
        }
      }

    }

    $nfile = '';
    if($file === '')
    {
      $nfile = $request->input('oldfile');
    }
    else
    {
      $nfile = $file;
    }

    DB::table('items')->where('id',intval($request->input('id')))
                      ->update([
                        'title'       => $request->input('title'),
                        'discription' => $request->input('discription'),
                        'file'        => $nfile
                      ]);


    return back()->with('msg','Item Edit Success');

  }// ------------------------------------------------------------------------------------------------------------------------------

  public function delete($id)
  {
    if(is_numeric($id) && DB::table('items')->where('id',$id)->count() > 0 && isset($_GET['fl']))
    {
      if(!empty($_GET['fl']))
      {
        if(file_exists('./data/items/files/'.$_GET['fl']))
          unlink('./data/items/files/'.$_GET['fl']);
      }
      DB::table('items')->where('id',$id)->delete();
      return back()->with('msg','Item Delete Success');
    }
    else
    {
      abort(404,'NOT FOUND');
    }
  }
}

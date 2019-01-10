<?php
namespace App\Http\Controllers\Main;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use App\Http\Controllers\Controller;
use App\Item;
use DB;
use Auth;

class UploadController extends Controller
{

  public function __construct()
  {
    // Chek User Complete The Profile Setting Department and Stage or Not
    $this->middleware('checkDS');
  }// Contstruct End --------


  /**
   * @ name    : index
   * @ param   : none
   * @ return  : view(o-upload || u-upload) With Data
   * @ work    : This Function Display The Upload Form
   */
  public function index()
  {
    if(Auth::user()->role != 'Uploader')
    {
      $departments = DB::table('departments')->orderBy('department_name')->get();
      $stages      = DB::table('stages')->orderBy('stage_name')->get();
      $subjects    = DB::table('subjects')->orderBy('subject_name')->get();
      $categories  = DB::table('categories')->orderBy('category_name')->get();
      $years       = DB::table('years')->orderBy('the_year')->get();
      return view('main.upload.o-upload')->with(['departments' => $departments, 'stages' => $stages, 'subjects' => $subjects, 'categories' => $categories, 'years' => $years]);
    }
    else
    {
      $subjects   = DB::table('subjects')->where([['department_id','=',Auth::user()->department_id],['stage_id','=',Auth::user()->stage_id]])->orderBy('subject_name')->get();
      $categories = DB::table('categories')->orderBy('category_name')->get();
      $years      = DB::table('years')->orderBy('the_year')->get();
      $department = DB::table('departments')->select('department_name')->where('id',Auth::user()->department_id)->get()->first();
      $stage      = DB::table('stages')->select('stage_name')->where('id',Auth::user()->stage_id)->get()->first();
      return view('main.upload.u-upload')->with(['subjects' => $subjects, 'categories' => $categories, 'years' => $years, 'department' => $department, 'stage' => $stage]);
    }
  }// Function Index End ---------


  /**
   * @ name    : upload_in_my_stage
   * @ param   : none
   * @ return  : view(u-upload) With Data
   * @ work    : This Function Display The Current Stage Upload Form
   */
  public function upload_in_my_stage()
  {
    $subjects   = DB::table('subjects')->where([['department_id','=',Auth::user()->department_id],['stage_id','=',Auth::user()->stage_id]])->orderBy('subject_name')->get();
    $categories = DB::table('categories')->orderBy('category_name')->get();
    $years      = DB::table('years')->orderBy('the_year')->get();
    $department = DB::table('departments')->select('department_name')->where('id',Auth::user()->department_id)->get()->first();
    $stage      = DB::table('stages')->select('stage_name')->where('id',Auth::user()->stage_id)->get()->first();
    return view('main.upload.u-upload')->with(['subjects' => $subjects, 'categories' => $categories, 'years' => $years, 'department' => $department, 'stage' => $stage]);
  }// Function Upload In My Stage End -------


  /**
   * @ name    : upload
   * @ param   : [ $request -> Request Type ] From Form
   * @ return  : Back
   * @ work    : This Function Save The Item Info Into Database and Upload File to Storage System
   */
  public function o_upload(Request $request)
  {
    // O-UPLOAD
    $this->validate($request,[
      'file'          => 'mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,txt,zip,rar',
      'department_id' => 'required|integer',
      'stage_id'      => 'required|integer',
      'subject_id'    => 'required|integer',
      'category_id'   => 'required|integer',
      'the_year'      => 'required|integer',
      'title'         => 'required|string|max:255',
      'discription'   => 'required|string'
    ]);

    $file = '';
    // Check Has File
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
    $item->item_year     = intval($request->input('the_year'));
    $item->title         = $request->input('title');
    $item->discription   = $request->input('discription');
    $item->file          = $file;
    $item->save();
    return back()->with('msg','Item Uploading Successfully !');
  }// O_Upload Function End ----------


  /**
   * @ name    : u_upload
   * @ param   : [ $request -> Request Type ] From Form
   * @ return  : Back
   * @ work    : This Function Save The Item Info Into Database and Upload File to Storage System
   */
  public function u_upload(Request $request)
  {
    // U-UPLOAD
    $this->validate($request,[
      'file'          => 'mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,txt,zip,rar',
      'subject_id'    => 'required|integer',
      'category_id'   => 'required|integer',
      'the_year'      => 'required|integer',
      'title'         => 'required|string|max:255',
      'discription'   => 'required|string'
    ]);

    $file = '';
    // Check Has File
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
    $item->stage_id      = intval(Auth::user()->stage_id);
    $item->department_id = intval(Auth::user()->department_id);
    $item->subject_id    = intval($request->input('subject_id'));
    $item->category_id   = intval($request->input('category_id'));
    $item->item_year     = intval($request->input('the_year'));
    $item->title         = $request->input('title');
    $item->discription   = $request->input('discription');
    $item->file          = $file;
    $item->save();
    return back()->with('msg','Item Uploading Successfully !');
  }// U_Upload Function End ----------


  /**
   * @ name    : item_delete
   * @ param   : [ $id -> integer Type ] From Form
   * @ return  : Back
   * @ work    : This Function Delete one Item From Database and Delete One File - By ID
   */
  public function item_delete($id)
  {
    if(Auth::user()->role === 'Owner')
    {
      if(is_numeric($id) && DB::table('items')->where('id',intval($id))->count('id') > 0 && isset($_GET['file']))
      {
        DB::table('items')->where('id',intval($id))->delete();
        if(!empty($_GET['file']))
        {
          if(file_exists('./data/items/files/' . $_GET['file']))
            unlink('./data/items/files/' . $_GET['file']);
        }
        return back()->with('msg','Item Delete Successfully !');
      }
      else
      {
        return redirect(route('home'));
      }
    }
    else
    {
      if(is_numeric($id) && DB::table('items')->where([['id','=',$id],['user_id','=',Auth::user()->id]])->count('id') > 0 && isset($_GET['file']))
      {
        DB::table('items')->where([['id','=',$id],['user_id','=',Auth::user()->id]])->delete();
        if(!empty($_GET['file']))
        {
          if(file_exists('./data/items/files/' . $_GET['file']))
            unlink('./data/items/files/' . $_GET['file']);
        }
        return back()->with('msg','Item Delete Successfully !');
      }
      else
      {
        return redirect(route('home'));
      }
    }
  }// Item Delete Function End -----------

  /**
   * @ name    : item_edit_show
   * @ param   : [ $id -> integer Type ] From Form
   * @ return  : view(Item edit) With Data
   * @ work    : This Function to Display The Item Edit Form
   */
  public function item_edit_show($id)
  {
    if(is_numeric($id) && DB::table('items')->where([['id','=',$id],['user_id','=',Auth::user()->id]])->count() > 0 )
    {
      $item       = Item::find($id);
      return view('main.upload.item-edit')->with(['item' => $item]);
    }
    else
    {
      return redirect(route('home'));
    }
  }// Edit Item Function End -------


  /**
   * @ name    : item_edit_execute
   * @ param   : [ $request -> Request Type ] From Form
   * @ return  : to Back
   * @ work    : This Function to Update One Item Info
   */
  public function item_edit_execute(Request $request)
  {
    $this->validate($request,[
      'id'           => 'required|integer',
      'file'         => 'mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,txt,zip,rar',
      'title'        => 'required|string|max:255',
      'discription'  => 'required|string',
      'oldfile'      => 'required',
      'returnto'     => 'required'
    ]);;

    if(DB::table('items')->where([['id','=',$request->input('id')],['user_id','=',Auth::user()->id]])->count() > 0)
    {

      // File
      $file = '';
      $file_store_path = './data/items/files/';
      if($request->hasFile('file'))
      {
        if($request->file('file')->isValid())
        {
          try
          {
            echo "<h1 style='font-size:2rem;font-weight:100;text-align:center;margin:50px;'>Updating Please Wait ... </h1>";
            $file = str_replace([' ','&','+','.','"','?','#','@','<','>','{','}','[',']','÷','*','%','$','(',')','_',',','،'],'_',$request->input('title')). '_' . rand(111111111,999999999) . '.'.$request->file('file')->getClientOriginalExtension();
            $request->file('file')->move($file_store_path,$file);
            if(!empty($request->input('oldfile')))
            {
              if(file_exists($file_store_path. $request->input('oldfile')))
                unlink($file_store_path . $request->input('oldfile'));
            }
          }
          catch(Illuminate\Filesystem\FileNotFoundException $e)
          {

          }
        }
      }

      $nfile = '';
      if($file === '')
        $nfile = $request->input('oldfile');
      else
        $nfile = $file;

      DB::table('items')->where([['id','=',$request->input('id')],['user_id','=',Auth::user()->id]])
                        ->update([
                          'title'         => $request->input('title'),
                          'discription'   => $request->input('discription'),
                          'file'          => $nfile
                        ]);
      //$return_subject = DB::table('subjects')->where('id',$request->input('returnto'))->select('slug')->get()->first();
      return back()->with('msg','Item Edit Successfully !');
    }
    else
    {
      return redirect(route('home'));
    }

  }// Edit Execute Function End ----------


}

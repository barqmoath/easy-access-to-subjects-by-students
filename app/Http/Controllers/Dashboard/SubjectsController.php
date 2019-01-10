<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\File;
use DB;
use App\Subject;

class SubjectsController extends Controller
{
  /*
   * Function to Start Browsing Subjects
   */
  public function start()
  {
    $departments = DB::table('departments')->orderBy('department_name')->get();
    $stages = DB::table('stages')->orderby('stage_name')->get();
    return view('dashboard.subjects.start')->with(['departments' => $departments, 'stages' => $stages]);
  } // --------------------------------------------------------------------------------------------------------------------------

  /*
   * Function to Get The Subjects by Department and Stage
   */
  public function brows($dept,$stg)
  {
    if(strlen($dept) > 0 && DB::table('departments')->where('slug',$dept)->count() > 0 && is_numeric($stg) && DB::table('stages')->where('id',$stg)->count() > 0)
    {
      $dept_name = DB::table('departments')->where('slug',$dept)->get()->first();
      $stg_name  = DB::table('stages')->where('id',$stg)->get()->first();
      $deptid    = DB::table('departments')->where('slug',$dept)->select('id')->get()->first();
      $subjects  = DB::table('subjects')
                      ->where([['department_id','=',intval($deptid->id)],['stage_id','=',intval($stg)]])
                      ->orderBy('subject_name')->get();
      return view('dashboard.subjects.brows')->with(['subjects' => $subjects, 'dept_name' => $dept_name, 'stg_name' => $stg_name]);
    }
    else
    {
      return redirect(route('subjects.start'));
    }
  }//-------------------------------------------------------------------------------------------------------------------------------


  /*
   * Function to View One Subject By Slug
   */
  public function view_subject($slug)
  {
    if(DB::table('subjects')->where('slug',$slug)->count() > 0)
    {
      $subject = DB::table('subjects')
                     ->join('departments','department_id','=','departments.id')
                     ->join('stages','stage_id','=','stages.id')
                     ->select([
                       'subjects.id as subjectid',
                       'subjects.department_id as sdeptid',
                       'subjects.stage_id as sstgid',
                       'subjects.slug as subjectslug',
                       'subjects.subject_name as subjectname',
                       'subjects.teacher_name as subjectteacher',
                       'subjects.discription as subjectdiscription',
                       'subjects.cover as subjectcover',
                       'departments.id as departmentid',
                       'departments.slug as departmentslug',
                       'departments.department_name as departmentname',
                       'stages.id as stageid',
                       'stages.stage_name as stagename'
                     ])
                     ->where('subjects.slug',$slug)
                     ->get()->first();
      $categories = DB::table('categories')->orderBy('category_name')->get();
      $years = DB::table('years')->orderBy('the_year')->get();

      $items_counter = DB::table('items')->where('subject_id',$subject->subjectid)->count();

      return view('dashboard.subjects.view')->with(['subject' => $subject, 'categories' => $categories, 'items_counter' => $items_counter, 'years' => $years]);
    }
    else
    {
      return redirect(route('subjects.start'));
    }
  } // --------------------------------------------------------------------------------------------------------------------------


  /*
   * Function to Show The Add new Subject Form
   */
  public function add_view()
  {
    $departments = DB::table('departments')->orderBy('department_name')->get();
    $stages = DB::table('stages')->orderby('stage_name')->get();
    return view('dashboard.subjects.add')->with(['departments' => $departments, 'stages' => $stages]);
  } // --------------------------------------------------------------------------------------------------------------------------


  /*
   * Function to Show The Edit Subject Form
   */
  public function edit_view($slug)
  {
    if(DB::table('subjects')->where('slug',$slug)->count() > 0)
    {
      $subject = DB::table('subjects')
                     ->join('departments','department_id','=','departments.id')
                     ->join('stages','stage_id','=','stages.id')
                     ->select([
                       'subjects.id as subjectid',
                       'subjects.department_id as sdeptid',
                       'subjects.stage_id as sstgid',
                       'subjects.slug as subjectslug',
                       'subjects.subject_name as subjectname',
                       'subjects.teacher_name as subjectteacher',
                       'subjects.discription as subjectdiscription',
                       'subjects.cover as subjectcover',
                       'departments.id as departmentid',
                       'departments.slug as departmentslug',
                       'departments.department_name as departmentname',
                       'stages.id as stageid',
                       'stages.stage_name as stagename'
                     ])
                     ->where('subjects.slug',$slug)
                     ->get()->first();
        return view('dashboard.subjects.edit')->with(['subject' => $subject]);
    }
    else
    {
      return redirect(route('subjects.start'));
    }

  } // --------------------------------------------------------------------------------------------------------------------------

  /*
   *  Function to execute The Add Subject
   */
  public function add(Request $request)
  {
    $cover = '';
    $this->validate($request,[
      'subject_name'   => 'required|string|max:255',
      'department_id'  => 'required|integer',
      'stage_id'       => 'required|integer',
      'teacher_name'   => 'required|string|max:255',
      'discription'    => 'required|string',
      'cover'          => 'required|image|mimes:jpg,png,jpeg'
    ]);

    if($request->hasFile('cover'))
    {
      if($request->file('cover')->isValid())
      {
        try
        {
          $cover = rand(11111,99999) . time().'.'.$request->file('cover')->getClientOriginalExtension();
          $request->file('cover')->move('./data/subjects/covers/',$cover);
        }
        catch(Illuminate\Filesystem\FileNotFoundException $e)
        {

        }
      }
    }

    $subject = new Subject();
    $subject->id = rand(11111,99999);
    $subject->subject_name  = $request->input('subject_name');
    $subject->slug          = strtolower(str_replace([' ','&','+','.','"','?','#','@','<','>','{','}','[',']','÷','*','%','$','(',')','_',',','،','='],'-',$request->input('subject_name')));
    $subject->department_id = $request->input('department_id');
    $subject->stage_id      = $request->input('stage_id');
    $subject->teacher_name  = $request->input('teacher_name');
    $subject->discription   = $request->input('discription');
    $subject->cover         = $cover;
    $subject->save();

    $return_dept_slug = DB::table('departments')->where('id',$request->input('department_id'))->select('slug')->first();
    return redirect(route('subjects.brows',['dept' => $return_dept_slug->slug, 'stg' => $request->input('stage_id')]))->with('msg','New Subject Was Added Successfully');
  } // --------------------------------------------------------------------------------------------------------------------------

  /*
   * Function to execute The Edit Subject
   */
  public function edit(Request $request)
  {
    $cover = '';
    $this->validate($request,[
      'id'             => 'required|integer',
      'subject_name'   => 'required|string|max:255',
      'teacher_name'   => 'required|string|max:255',
      'discription'    => 'required|string',
      'cover'          => 'image|mimes:jpg,png,jpeg',
      'oldcover'       => 'required|string',
    ]);

    if($request->hasFile('cover'))
    {
      if($request->file('cover')->isValid())
      {
        try
        {
          $cover = rand(11111,99999) . time().'.'.$request->file('cover')->getClientOriginalExtension();
          $request->file('cover')->move('./data/subjects/covers/',$cover);

          if(file_exists('./data/subjects/covers/'.$request->input('oldcover')))
          {
            unlink('./data/subjects/covers/'.$request->input('oldcover'));
          }

        }
        catch(Illuminate\Filesystem\FileNotFoundException $e)
        {

        }
      }
    }
    $ncover = '';
    if($cover === '')
    {
      $ncover = $request->input('oldcover');
    }
    else
    {
      $ncover = $cover;
    }

    DB::table('subjects')->where('id',$request->input('id'))
                         ->update([
                           'slug'           => strtolower(str_replace([' ','&','+','.','"','?','#','@','<','>','{','}','[',']','÷','*','%','$','(',')','_',',','،','='],'-',$request->input('subject_name'))),
                           'subject_name'   => $request->input('subject_name'),
                           'teacher_name'   => $request->input('teacher_name'),
                           'discription'    => $request->input('discription'),
                           'cover'          => $ncover,
                         ]);
    $return_slug = DB::table('subjects')->where('id',$request->input('id'))->select('slug')->first();
    return redirect(route('subjects.view_subject',['slug' => $return_slug->slug]))->with('msg','Subject Edit Success');
  } // --------------------------------------------------------------------------------------------------------------------------

  /*
   * Function to Delete One Subject by Slug
   */
  public function delete($slug)
  {
    $the_subject = DB::table('subjects')->where('slug',$slug)->get()->first();
    if(file_exists('./data/subjects/covers/'.$the_subject->cover))
    {
      unlink('./data/subjects/covers/'.$the_subject->cover);
    }
    DB::table('subjects')->where('id',$the_subject->id)->delete();
    return redirect(route('subjects.start'))->with('msg','Subject Delete Success');
  } // --------------------------------------------------------------------------------------------------------------------------

}

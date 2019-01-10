<?php

namespace App\Http\Controllers\Main;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use DB;

class ProfileController extends Controller
{

  //public function __construct()
  //{
    // Chek User Complete The Profile Setting Department and Stage or Not
    //$this->middleware('checkDS');
  //}// Contstruct End --------


  /*
   * @ name    : my_profile
   * @ param   : none
   * @ return  : view(profile) with Current User Data and more data
   * @ work    : Display User Profile and More
   */
  public function my_profile()
  {
    $user = User::find(intval(Auth::user()->id));
    $departments = DB::table('departments')->orderBy('department_name')->get();
    $stages = DB::table('stages')->orderBy('stage_name')->get();
    $ds = [];
    if(!empty($user->department_id) && !empty($user->stage_id))
    {
      $d = DB::table('departments')->where('id',$user->department_id)->get()->first();
      $s = DB::table('stages')->where('id',$user->stage_id)->get()->first();
      $ds = ['department_id' =>$d->id ,'department_name' => $d->department_name, 'stage_id' => $s->id, 'stage_name' => $s->stage_name];
    }
    return view('auth.profile.profile')->with(['departments' => $departments, 'stages' => $stages, 'user' => $user, 'ds' => $ds]);
  }// --------

  /*
   * @ name   : edit_profile
   * @ param  : [ $request -> Request Type ] From Form
   * @ return : Back
   * @ work   : Save Profile Changes on Database For Current User
   */
  public function edit_profile(Request $request)
  {
    $photo = '';
    $this->validate($request,[
      'photo'          => 'image|mimes:jpg,jpeg,png|max:5000',
      'name'           => 'required|string|max:255',
      'email'          => 'required|string|email|max:255',
      'oldemail'       => 'required|string|max:255',
      'oldphoto'       => 'required|string|max:255',
      'olddept'        => 'required',
      'oldstg'         => 'required'
    ]);

    if($request->input('oldemail') != $request->input('email'))
    {
      $this->validate($request,[
        'email' => 'required|string|email|max:255|unique:users'
      ]);
    }

    if($request->hasFile('photo'))
    {
      if($request->file('photo')->isValid())
      {
        try
        {
          $photo = rand(111111111,999999999) . time().'.'.$request->file('photo')->getClientOriginalExtension();
          $request->file('photo')->move('./data/users/photos/',$photo);
          if(file_exists('./data/users/photos/'.$request->input('oldphoto')) && $request->input('oldphoto') != 'default-user-photo.png')
            unlink('./data/users/photos/'.$request->input('oldphoto'));
        }
        catch(Illuminate\Filesystem\FileNotFoundException $e)
        {

        }
      }
    }

    $nphoto = '';
    if($photo === '')
      $nphoto = $request->input('oldphoto');
    else
      $nphoto = $photo;

    $ndept  = null;
    $nstg   = null;

    if($request->input('department_id') === 'empty' && $request->input('stage_id') === 'empty')
    {
      if($request->input('olddept') != 'none' && $request->input('oldstg') != 'none')
      {
        $ndept = intval($request->input('olddept'));
        $nstg  = intval($request->input('oldstg'));
      }
    }
    else
    {
      $ndept = intval($request->input('department_id'));
      $nstg  = intval($request->input('stage_id'));
    }


    DB::table('users')->where('id',intval(Auth::user()->id))
                      ->update([
                        'name'            => $request->input('name'),
                        'email'           => $request->input('email'),
                        'facebook_link'   => $request->input('facebook_link'),
                        'photo'           => $nphoto,
                        'department_id'   => $ndept,
                        'stage_id'        => $nstg
                      ]);

    return back()->with('msg','Profile Updated Successfully');

  }// edit_profile Function End -----------------------

  /*
   * @ name   : edit_password
   * @ param  : [ $request -> Request Type ] From Form
   * @ return : Back
   * @ work   : Update The Password For Current User
   */
  public function edit_password(Request $request)
  {
    $this->validate($request,[
      'old_password'          => 'required|string|min:6',
      'password'              => 'required|confirmed|string|min:6',
      'password_confirmation' => 'sometimes|required_with:password'
    ]);

    $user           = User::find(Auth::user()->id);
    $hashedPassword = $user->password;
    Hash::make($request->input('old_password'));
    if(Hash::check($request->input('old_password'), $hashedPassword))
    {
      DB::table('users')->where('id',intval(Auth::user()->id))
                        ->update([
                          'password' => bcrypt($request->input('password'))
                        ]);
      Auth::logout();
      return redirect(route('login'));
    }
    else
    {
      return back()->with('fmsg','The old password is wrong !');
    }
  }// edit_password Function End --------

  /*
   * @ name   : delete
   * @ param  : none
   * @ return : To Home Page After Logout
   * @ work   : Delete The Current User Account and Logout
   */
  public function delete()
  {
    return view('auth.profile.delete-confirm');
  }

  public function delete_exe(Request $request)
  {
    $this->validate($request,[
      'password' => 'required|string|min:6'
    ]);

    $user           = User::find(Auth::user()->id);
    $hashedPassword = $user->password;
    Hash::make($request->input('password'));
    if(Hash::check($request->input('password'), $hashedPassword))
    {
      DB::table('users')->where('id',intval(Auth::user()->id))->delete();
      Auth::logout();
      return redirect(route('start'));
    }
    else
    {
      return back()->with('fmsg','Delete Faild Check Password !');
    }
  }
  //delete Function End --------




  /*
   * @ name   : my_items
   * @ param  : none
   * @ return : my-items View With Data
   * @ work   : Get All Items For This User
   */
  public function my_items()
  {
    $my_items_counter = DB::table('items')->where('user_id',intval(Auth::user()->id))->count('user_id');
    $items = DB::table('items')->join('users','items.user_id','=','users.id')->join('departments','items.department_id','=','departments.id')->join('stages','items.stage_id','=','stages.id')->join('subjects','items.subject_id','=','subjects.id')->join('categories','items.category_id','=','categories.id')
                               ->select(['items.id as itemid','items.item_year as itemyear','items.title as itemtitle','items.discription as itemdiscription','items.file as itemfile','items.created_at as itemuploaddate','users.id as userid','users.name as username','users.photo as userphoto','users.facebook_link as userfacebook','departments.department_name as departmentname','stages.stage_name as stagename','subjects.subject_name as subjectname','categories.category_name as categoryname'])
                               ->where('user_id',intval(Auth::user()->id))
                               ->orderBy('items.created_at','desc')
                               ->paginate(12);
    return view('auth.profile.my-items')->with(['items' => $items, 'itemscounter' => $my_items_counter]);                          ;
  }// My Items Function End --------------


  public function edit_type_and_class(Request $request)
  {

  }

}

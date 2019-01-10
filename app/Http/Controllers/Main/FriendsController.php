<?php
namespace App\Http\Controllers\Main;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use DB;
use Auth;

class FriendsController extends Controller
{

  public function __construct()
  {
    // Chek User Complete The Profile Setting Department and Stage or Not
    $this->middleware('checkDS');
  }// Contstruct End --------

  public function index()
  {
    // Get The User Data
    $my_info = DB::table('users')->join('departments','users.department_id','=','departments.id')
                                 ->join('stages','users.stage_id','=','stages.id')
                                 ->select([
                                            'users.id as userid','users.email as email','users.role as userrole','users.name as username','users.photo as userphoto','users.facebook_link as userfacebook','users.created_at as joinat',
                                            'departments.id as departmentid','departments.department_name as departmentname',
                                            'stages.id as stageid','stages.stage_name as stagename'
                                          ])
                                 ->where('users.id',intval(Auth::user()->id))
                                 ->first();

    // Get User Friends Data
    $friends = DB::table('users')->join('departments','users.department_id','=','departments.id')
                                 ->join('stages','users.stage_id','=','stages.id')
                                 ->select([
                                            'users.id as userid','users.email as email','users.role as userrole','users.name as username','users.photo as userphoto','users.facebook_link as userfacebook','users.created_at as joinat',
                                            'departments.id as departmentid','departments.department_name as departmentname',
                                            'stages.id as stageid','stages.stage_name as stagename'
                                          ])
                                 ->where([
                                            ['users.id','<>',Auth::user()->id],
                                            ['users.stage_id','<>',''],
                                            ['users.department_id','<>',''],
                                            ['users.stage_id','=',Auth::user()->stage_id],
                                            ['users.department_id','=',Auth::user()->department_id]
                                         ])
                                 ->orderBy('users.name')
                                 ->get();
    return view('main.friends.friends')->with(['my_info' => $my_info, 'friends' => $friends]);
  }// index Function End --------
}

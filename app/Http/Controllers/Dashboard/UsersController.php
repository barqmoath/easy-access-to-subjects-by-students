<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use App\User;

class UsersController extends Controller
{

  //Function to Control Display Users
  public function index($showState)
  {
    $mg_id = Auth::user()->id;
    $users_data = array();
    if($showState === 'all-users')
    {
      $users_data = DB::table('users')->where([['role','=','User'],['id','<>',$mg_id]])->orderBy('created_at','desc')->paginate(15);
    }
    elseif ($showState === 'active-users')
    {
      $users_data = DB::table('users')->where([['role','=','User'],['state','=',1],['id','<>',$mg_id]])->orderBy('created_at','desc')->paginate(15);
    }
    elseif($showState === 'blocked-users')
    {
      $users_data = DB::table('users')->where([['role','=','User'],['state','=',0],['id','<>',$mg_id]])->orderBy('created_at','desc')->paginate(15);
    }
    elseif($showState === 'search' && isset($_GET['txt']))
    {
      $q = $_GET['txt'];
      $users_data = DB::table('users')->where('role','User')->where('name','like','%'.$q.'%')->orwhere('email','like','%'.$q.'%')->orderBy('name')->paginate(15);
    }
    else
    {
      $users_data = DB::table('users')->where([['role','=','User'],['id','<>',$mg_id]])->orderBy('created_at','desc')->paginate(15);
    }
    return view('dashboard.users.users',compact('users_data',$users_data));
  }



  //Function to Get All Managers - Owners and Admins only
  public function managers()
  {
    $mg_id = Auth::user()->id;
    $managers_data = DB::table('users')->where([['role','<>','User'],['state','=',1],['id','<>',$mg_id]])->orderBy('created_at')->get();
    return view('dashboard.users.managers',compact('managers_data',$managers_data));
  }



   //Function to Delete One user by ID
   public function delete($uid)
   {
     $id = 0;
     if(is_numeric($uid)){ $id = intVal($uid);}
     if($id != 0)
     {
        DB::table('users')->where([['id','=',$id],['role','<>','Owner'],['role','<>','Administrator']])->delete();
        return redirect(route('users.index',['showState' => 'all-users']))->with('msg','User Delete Successfully');
     }
     return redirect(route('users.index',['showState' => 'all-users']))->with('fmsg','User Delete Faild');
   }

   //Function to Block One User by ID
   public function block($uid)
   {
     $id = 0;
     if(is_numeric($uid)){ $id = intVal($uid);}
     if($id != 0)
     {
       $finduser = DB::table('users')->where('id',$id)->count();
       if($finduser > 0)
       {
         DB::table('users')->where([['id','=',$id],['role','<>','Owner'],['role','<>','Administrator'],['state','=',1]])
                           ->update(['state' => 0]);
         return redirect(route('users.index',['showState' => 'all-users']))->with('msg','User Blocked Success');
       }
       else
       {
         return redirect(route('users.index',['showState' => 'all-users']))->with('fmsg','User Blocked Faild');
       }
     }
     return redirect(route('users.index',['showState' => 'all-users']))->with('fmsg','User Blocked Faild');
   }

   //Function to Block All Users
   public function block_all()
   {
     DB::table('users')->where([['role','<>','Owner'],['role','<>','Administrator'],['state','=',1]])
                       ->update(['state' => 0]);
     return redirect(route('users.index',['showState' => 'all-users']))->with('msg','All User is Blocked Now');
   }

   //Function to Active One User by ID
   public function active($uid)
   {
     $id = 0;
     if(is_numeric($uid)){ $id = intVal($uid);}
     if($id != 0)
     {
       $finduser = DB::table('users')->where('id',$id)->count();
       if($finduser > 0)
       {
         DB::table('users')->where([['id','=',$id],['role','<>','Owner'],['role','<>','Administrator'],['state','=',0]])
                           ->update(['state' => 1]);
         return redirect(route('users.index',['showState' => 'all-users']))->with('msg','User Active Successfully');
       }
       else
       {
         return redirect(route('users.index',['showState' => 'all-users']))->with('fmsg','User Active Faild');
       }
     }
     return redirect(route('users.index',['showState' => 'all-users']))->with('fmsg','User Active Faild');
   }

   //Function to Active All Users
   public function active_all()
   {
     DB::table('users')->where([['role','<>','Owner'],['role','<>','Administrator'],['state','=',0]])
                       ->update(['state' => 1]);
     return redirect(route('users.index',['showState' => 'all-users']))->with('msg','All Users is Active Now');
   }

   //Function to Make new Owner
   public function make_owner($id)
   {
     $S = 'default';
     if(isset($_GET['S'])){$S = $_GET['S'];}
     if(is_numeric($id))
     {
       $finduser = DB::table('users')->where('id',$id)->count();
       if($finduser > 0)
       {
         DB::table('users')->where([['id','=',$id],['role','<>','Owner'],['state','=',1]])
                           ->update(['role' => 'Owner']);
         if($S === 'default')
           return redirect(route('users.index',['showState' => 'all-users']))->with('msg','User Role Has Been Changed Successfuly');
         else
           return redirect(route('managers'))->with('msg','User Role Has Been Changed Successfuly');
       }
       else
       {
         if($S === 'default')
           return redirect(route('users.index',['showState' => 'all-users']))->with('fmsg','Faild');
         else
           return redirect(route('managers'))->with('fmsg','Faild');
       }
     }
     if($S === 'default')
       return redirect(route('users.index',['showState' => 'all-users']))->with('fmsg','Faild');
     else
       return redirect(route('managers'))->with('fmsg','Faild');
   }//end Function

   //Function to Make new Administrator
   public function make_administrator($id)
   {
     $S = 'default';
     if(isset($_GET['S'])){$S = $_GET['S'];}
     if(is_numeric($id))
     {
       $finduser = DB::table('users')->where('id',$id)->count();
       if($finduser > 0)
       {
         DB::table('users')->where([['id','=',$id],['role','<>','Administrator'],['state','=',1]])
                           ->update(['role' => 'Administrator']);
         if($S === 'default')
           return redirect(route('users.index',['showState' => 'all-users']))->with('msg','User Role Has Been Changed Successfuly');
         else
           return redirect(route('managers'))->with('msg','User Role Has Been Changed Successfuly');
       }
       else
       {
         if($S === 'default')
           return redirect(route('users.index',['showState' => 'all-users']))->with('fmsg','Faild');
         else
           return redirect(route('managers'))->with('fmsg','Faild');
       }
     }

     if($S === 'default')
       return redirect(route('users.index',['showState' => 'all-users']))->with('fmsg','Faild');
     else
       return redirect(route('managers'))->with('fmsg','Faild');

   }

   // Function to Make Uploader
   public function make_uploader($id)
   {
     $S = 'default';
     if(isset($_GET['S'])){$S = $_GET['S'];}
     if(is_numeric($id))
     {
       $finduser = DB::table('users')->where('id',$id)->count();
       if($finduser > 0)
       {
         DB::table('users')->where([['id','=',$id],['role','<>','Uploader'],['state','=',1]])
                           ->update(['role' => 'Uploader']);
         if($S === 'default')
           return redirect(route('users.index',['showState' => 'all-users']))->with('msg','User Role Has Been Changed Successfuly');
         else
           return redirect(route('managers'))->with('msg','User Role Has Been Changed Successfuly');
       }
       else
       {
         if($S === 'default')
           return redirect(route('users.index',['showState' => 'all-users']))->with('fmsg','Faild');
         else
           return redirect(route('managers'))->with('fmsg','Faild');
       }
     }

     if($S === 'default')
       return redirect(route('users.index',['showState' => 'all-users']))->with('fmsg','Faild');
     else
       return redirect(route('managers'))->with('fmsg','Faild');
   }
   //Function to Make User
   public function make_user($id)
   {
     $S = 'default';
     if(isset($_GET['S'])){$S = $_GET['S'];}
     if(is_numeric($id))
     {
       $finduser = DB::table('users')->where('id',$id)->count();
       if($finduser > 0)
       {
         DB::table('users')->where([['id','=',$id],['role','<>','User'],['state','=',1]])
                           ->update(['role' => 'User']);
         if($S === 'default')
           return redirect(route('users.index',['showState' => 'all-users']))->with('msg','User Role Has Been Changed Successfuly');
         else
           return redirect(route('managers'))->with('msg','User Role Has Been Changed Successfuly');
       }
       else
       {
         if($S === 'default')
           return redirect(route('users.index',['showState' => 'all-users']))->with('fmsg','Faild');
         else
           return redirect(route('managers'))->with('fmsg','Faild');
       }
     }
     if($S === 'default')
       return redirect(route('users.index',['showState' => 'all-users']))->with('fmsg','Faild');
     else
       return redirect(route('managers'))->with('fmsg','Faild');
   } // end Function


}

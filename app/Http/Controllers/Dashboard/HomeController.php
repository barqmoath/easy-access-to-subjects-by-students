<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use App\User;

class HomeController extends Controller
{
  public function index()
  {
    $users_count    = DB::table('users')->count();
    $items_count    = DB::table('items')->count();
    $subjects_count = DB::table('subjects')->count();
    $comments_count = DB::table('comments')->count();
    $orders_count   = DB::table('orders')->count();

    $user_id = Auth::user()->id;
    $items_count_user = DB::table('items')->where('user_id',$user_id)->count();

    return view('dashboard.home')->with('data',['users_counter' => $users_count, 'items_counter' => $items_count, 'subjects_counter' => $subjects_count, 'comments_counter' => $comments_count, 'items_user_counter' => $items_count_user, 'orders_count' => $orders_count]);
  }

}

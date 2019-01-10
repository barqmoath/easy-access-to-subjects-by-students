<?php

namespace App\Http\Controllers\Dashboard;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;

class OrdersController extends Controller
{
  public function index()
  {
    $orders = DB::table('orders')->join('users','users.id','=','orders.user_id')
                                 ->select([
                                   'orders.id as orderid','orders.order_content as ordercontent','orders.created_at as orderdatetime',
                                   'users.id as userid','users.name as username','users.facebook_link as userfacebook','users.photo as userphoto'
                                 ])
                                 ->orderBy('orders.created_at','desc')->paginate(15);
    return view('dashboard.orders.orders')->with('orders',$orders);
  }

  public function delete($id)
  {
    if(DB::table('orders')->where('id',$id)->count() > 0)
    {
      DB::table('orders')->where('id',$id)->delete();
      return back()->with('msg','Order Delete Success');
    }
    else
    {
      return redirect(route('dashboard_home'));
    }
  }
}

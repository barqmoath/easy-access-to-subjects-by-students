<?php

namespace App\Http\Controllers\Main;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;

class OrderController extends Controller
{
  public function order_view()
  {
    return view('main.order.order');
  }// Order View Function End -----------

  public function order_send(Request $request)
  {
    $this->validate($request,[
      'order_content' => 'required|string'
    ]);
    DB::table('orders')->insert([
                                  'user_id'       => Auth::user()->id,
                                  'order_content' => $request->input('order_content')
                               ]);
    return back()->with('msg','Order Sent');
  }
}

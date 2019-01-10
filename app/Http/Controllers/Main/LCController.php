<?php

namespace App\Http\Controllers\Main;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Like;
use App\Bag;
use App\Comment;
use DB;
use Auth;

class LCController extends Controller
{
  /**
   * Function Using to Ajax in lb.js File
   * This Function to Update Love State For Current User
   */
  public function love(Request $request)
  {
    $itemid = $request->item_id;
    $userid = Auth::user()->id;
    $is_loved = false;
    $love = DB::table('likes')->where([['item_id','=',$itemid],['user_id','=',$userid]])->get()->first();

    if(!$love)
    {
      $newlove = new Like();
      $newlove->user_id = $userid;
      $newlove->item_id = $itemid;
      $newlove->save();
      $is_loved = true;
    }
    else
    {
      DB::table('likes')->where([['item_id','=',$itemid],['user_id','=',$userid]])->delete();
    }
    $response = [
      'is_loved' => $is_loved
    ];
    return response()->json($response, 200);
  }// Love Funciton End ----------

  /**
   * Function Using to Ajax in lb.js File
   * This Function to Update Bag State For Current User
   */
  public function bag(Request $request)
  {
    $itemid = $request->item_id;
    $userid = Auth::user()->id;
    $is_in_bag = false;
    $bag = DB::table('bags')->where([['item_id','=',$itemid],['user_id','=',$userid]])->get()->first();

    if(!$bag)
    {
      $newlove = new Bag();
      $newlove->user_id = $userid;
      $newlove->item_id = $itemid;
      $newlove->save();
      $is_in_bag = true;
    }
    else
    {
      DB::table('bags')->where([['item_id','=',$itemid],['user_id','=',$userid]])->delete();
    }
    $response = [
      'is_in_bag' => $is_in_bag
    ];
    return response()->json($response, 200);
  }// Bag Funciton End ----------

  public function add_comment(Request $request)
  {
    $this->validate($request,[
      'item_id'     => 'required|integer',
      'the_comment' => 'required|string'
    ]);
    if(DB::table('items')->where('id',intval($request->input('item_id')))->count() > 0)
    {
      $comment = new Comment();
      $comment->user_id     = Auth::user()->id;
      $comment->item_id     = intval($request->input('item_id'));
      $comment->the_comment = $request->input('the_comment');
      $comment->save();
      return back();
    }
    else
    {
      return redirect(route('home'));
    }
  }// Add Comment Function End ----------

  public function delete_comment($cid)
  {
    if(DB::table('comments')->where('id',intval($cid))->count() > 0 && isset($_GET['ui']))
    {
      Hash::make(Auth::user()->id);
      if(Auth::user()->role === 'Owner' || Auth::user()->role === 'Administrator' || Hash::check(Auth::user()->id,$_GET['ui']))
      {
        DB::table('comments')->where('id',$cid)->delete();
        return back();
      }
    }
    else
    {
      return back();
    }
  }// Delete Comment End ------------
}

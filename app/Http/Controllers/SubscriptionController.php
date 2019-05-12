<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    //
    public function cancel(Request $request){
      $request->user()->subscription('main')->cancel();
      return response()->json(200);
    }

    public funtion updateCard(Request $request){
      $request->user()->updateCard($request->token);
      return response()->json(200);
    }
}

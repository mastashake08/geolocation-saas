<?php

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return response()->json(new UserResource($request->user()));
});

Route::middleware('auth:api')->resource('/location','LocationController');

Route::middleware('auth:api')->post('/cancel','SubscriptionController@cancel');
Route::middleware('auth:api')->post('/update-card','SubscriptionController@updateCard');

Route::post('/login',function(Request $request){
  $http = new \GuzzleHttp\Client;

  $response = $http->post(env('APP_URL').'/oauth/token', [
    'form_params' => [
        'grant_type' => 'password',
        'client_id' => env('PASSPORT_CLIENT_ID'),
        'client_secret' => env('PASSPORT_CLIENT_SECRET'),
        'username' => $request->username,
        'password' => $request->password,
        'scope' => '',
    ],
]);

return json_decode((string) $response->getBody(), true);
});

Route::post('/register', function(Request $request){
  
  $user = \App\User::create([
     'name' => $request->name,
     'email' => $request->email,
     'password' => Hash::make($request->password),
 ])->newSubscription('main', $request->subscription_plan)->create($request->token);
 $http = new \GuzzleHttp\Client;

 $response = $http->post(env('APP_URL').'/oauth/token', [
   'form_params' => [
       'grant_type' => 'password',
       'client_id' => env('PASSPORT_CLIENT_ID'),
       'client_secret' => env('PASSPORT_CLIENT_SECRET'),
       'username' => $request->username,
       'password' => $request->password,
       'scope' => '',
   ],
]);

return json_decode((string) $response->getBody(), true);
});

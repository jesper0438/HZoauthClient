<?php

use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('rederict',function(){
	$query = http_build_query([
        'client_id' => '11',
        'redirect_uri' => 'http://client.app/callback',
        'response_type' => 'code',
        'scope' => '',
    ]);

    return redirect('http://vue.app/oauth/authorize?'.$query);
})->name('get.token');

Route::get('/callback', function (Request $request) {

    $http = new GuzzleHttp\Client;

    $response = $http->post('http://vue.app/oauth/token', [
        'form_params' => [
            'grant_type' => 'authorization_code',
            'client_id' => '11',
            'client_secret' => 'zS8lf92vrEJ4cLRgO3ou7jR7MoO5qh1k82D9oExA',
            'redirect_uri' => 'http://client.app/callback',
            'code' => $request->code,
        ],
    ]);

    return json_decode((string) $response->getBody(), true);
});

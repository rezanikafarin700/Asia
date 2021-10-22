<?php
use App\Http\Controllers\MailController;

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
    return view('upload');
});
Route::post('avatar',function (){

    $files = request()->file('avatar');
    foreach ($files as $file){
        $path = $file->store('Avatar');
//        $name = explode('/', $path)[1];
//        dd($path);

    }
    return back();
});


Route::get('/mail',[
    'as' => 'mail',
   'uses' => 'EmailController@mail'
]);

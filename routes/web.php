<?php

use App\http\Controllers\HomeController;
use App\Http\Controllers\PostCommentController;
use App\http\Controllers\PostsController;
use App\http\Controllers\PostTagController;
use App\Http\Controllers\UserCommentController;
use App\Http\Controllers\UserController;
//use App\http\Controllers\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

// Route::get('/', function () {
//     return view('home.index',[]);
// })-> name('home.index');

// Route::get('/contact', function(){
//     return view('home.contact');
// })->name('home.contact'); 

Route::get('/',[HomeController::class,'home'])
 -> name('home');
//  ->middleware('auth');
Route::get('/contact',[HomeController::class,'contact']) -> name('contact');
Route::resource('posts',PostsController::class);
Route::get('/posts/tag/{tag}',[PostTagController::class,'index']) -> name('posts.tags.index');

Route::resource('posts.comments',PostCommentController::class)->only(['store']);
Route::resource('users.comments',UserCommentController::class)->only(['store']);
Route::resource('users',UserController::class)->only(['show','edit','update']);

Route::get('/secret',[HomeController::class,'secret'])
    ->name('secret')
    ->middleware('can:home.secret');

// $posts = [
//     1 => [
//         'title' => 'Intro to Laravel',
//         'content' => 'This is a short intro to Laravel',
//         'is_new' => true,
//         'is_set' => true
//     ],
//     2 => [
//         'title' => 'Intro to PHP',
//         'content' => 'This is a short intro to PHP',
//         'is_new' => false
//     ],
//     3 => [
//         'title' => 'Intro to Golang',
//         'content' => 'This is a short intro to Golang',
//         'is_new' => false
//     ]
// ];

    //->only(['index','show','create','store','edit','update']);

// Route::get('/posts', function() use($posts) {
//     return view('posts.index', ['posts' => $posts]);
// });

// Route::get('/posts/{id}',function($id) use($posts){
//     abort_if(!isset($posts[$id]),404);
//     return view('posts.show',['post' => $posts[$id]]);
// })->name('posts.show');

Route::get('recent-posts/{days_ago?}', function($daysAgo = 20 ){
    return 'Posts from ' . $daysAgo . ' days ago';
}) -> name('posts.recent.index');


// Route::prefix('/fun')->name('fun.')->group(function() use($posts){
//     Route::get('/responses',function() use($posts){
//         return response($posts,201)
//         ->header('Content-Type','application/json')
//         ->cookie('MY_COOKIE','Hadar Margalit',3600);
//     })->name('responses');
    
//     Route::get('/redirect', function(){
//         return redirect('/contact');
//     })->name('redirect');
    
//     Route::get('/back', function(){
//         return back();
//     })->name('back');
    
//     Route::get('/named-route', function(){
//         return redirect()->route('posts.show',['id' => 1]);
//     })->name('named-route');
    
//     Route::get('/away', function(){
//         return redirect()->away('https://google.com');
//     })->name('away');
    
//     Route::get('/json', function() use($posts){
//         return response()->json($posts);
//     })->name('json');
    
//     Route::get('/download', function() use($posts){
//         return response()->download(public_path('/flower.jpg'),'pictureFlower.jpg');
//     })->name('download');
// });

Auth::routes();



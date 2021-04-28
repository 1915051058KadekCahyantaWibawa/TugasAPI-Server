<?php

use Illuminate\Support\Facades\Route;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

// Read/Retrieve
Route::get('/', function(){
    $blog = Blog::all();
    return response()->json($blog);
});

// Create
Route::post('/', function(Request $request){
    $validator = Validator::make($request->all(), [
        'judul' => 'required',
        'isi' => 'required',
    ]);

    if($validator->fails()){
        return  response()->json([
            'status' => 'error',
            'message' => $validator->getMessageBag()->toArray(),
        ], 422);
    }

    $blog = Blog::create($request->only('judul', 'isi'));

    return response()->json([
        'status' => 'OK',
        'data' => $blog
    ], 200);
});

Route::patch('/{id}', function(Request $request){
    $validator = Validator::make($request->all(), [
        'judul' => 'required',
        'isi' => 'required',
    ]);

    if($validator->fails()){
        return  response()->json([
            'status' => 'error',
            'message' => $validator->getMessageBag()->toArray(),
        ], 422);
    }

    $blog = Blog::where('id', $request->id)->update($request->only('isi','judul'));

    return response()->json([
        'status' => 'OK',
        'data' => $blog
    ], 200);
});

Route::delete('/{id}', function(Request $request){
    $blog = Blog::where('id', $request->id)->delete();
    return response()->json([
        'status' => 'OK',
        'data' => $blog
    ], 200);
});


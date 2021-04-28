<?php

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

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

// Read
Route::get('/', function(){
    return response()->json([
        'status' => 'OK',
        'data' => Blog::all()
    ], 200);
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

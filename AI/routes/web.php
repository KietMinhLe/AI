<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::post('/upload', function (Request $request) {
    if (!$request->hasFile('image')) {
        return response()->json(['error' => 'Không có ảnh!'], 400);
    }

    $image = $request->file('image');
    $response = Http::attach('image', file_get_contents($image->path()), $image->getClientOriginalName())
        ->post('http://127.0.0.1:5000/detect');

    return $response->json();
})->name('upload');
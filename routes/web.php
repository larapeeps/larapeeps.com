<?php

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Finder\SplFileInfo;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('homepage', [
        'lists' => collect(File::allFiles(base_path('content/lists')))->mapWithKeys(function (SplFileInfo $file) {
            return [$file->getFilenameWithoutExtension() => json_decode($file->getContents())];
        }),
    ]);
});

Route::get('/{list}', function ($list) {
    $path = base_path('content/lists/' . $list . '.json');

    abort_unless(File::exists($path), 404);

    return view('list', [
        'list' => $list = json_decode(File::get($path)),
        'people' => $list->people,
    ]);  
})->name('list');

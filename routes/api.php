<?php

declare(strict_types=1);

use App\Http\Controllers\Peeps\AvatarController;
use App\Http\Controllers\Peeps\ShowController;
use Illuminate\Support\Facades\Route;

Route::middleware(['cache.headers:public;max_age=2628000;etag'])->group(static function (): void {
    Route::get('peeps/{slug}', ShowController::class)->name('peep:show');
    Route::get('peeps/{slug}/avatar', AvatarController::class)->name('peep:avatar');
});

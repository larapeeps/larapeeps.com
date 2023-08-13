<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orbit\Concerns\Orbital;
use Illuminate\Database\Schema\Blueprint;

class Group extends Model
{
    use HasFactory;
    use Orbital;

    protected $guarded = [];

    protected $casts = [
        'people' => 'array',
    ];

    public static function schema(Blueprint $table)
    {
        $table->string('name');
        $table->string('slug');
        $table->string('description');
        $table->json('people');
    }

    public function getKeyName()
    {
        return 'slug';
    }
    
    public function getIncrementing()
    {
        return false;
    }
}

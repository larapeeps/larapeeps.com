<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orbit\Concerns\Orbital;
use Illuminate\Database\Schema\Blueprint;

class Person extends Model
{
    use HasFactory;
    use Orbital;

    protected $guarded = [];

    public static function schema(Blueprint $table)
    {
        $table->string('name');
        $table->string('slug');
        $table->string('bio');
        $table->string('avatar_url');
        $table->string('x_handle');
        $table->string('github_handle')->nullable();
    }

    public function getKeyName()
    {
        return 'slug';
    }
    
    public function getIncrementing()
    {
        return false;
    }

    public function usesTimestamps()
    {
        return false;
    }
}

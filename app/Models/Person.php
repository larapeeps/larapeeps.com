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
    protected $keyType = 'string';

    public static function schema(Blueprint $table)
    {
        $table->string('name');
        $table->string('slug');
        $table->string('bio');
        $table->string('x_handle')->nullable();
        $table->string('x_avatar_url')->nullable();
        $table->string('github_handle')->nullable();
        $table->string('website_url')->nullable();
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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orbit\Concerns\Orbital;
use Illuminate\Database\Schema\Blueprint;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

class Group extends Model
{
    use HasFactory;
    use Orbital;
    use HasJsonRelationships;

    protected $guarded = [];
    protected $keyType = 'string';

    protected $casts = [
        'members' => 'json',
    ];

    public static function schema(Blueprint $table)
    {
        $table->string('name');
        $table->string('slug');
        $table->string('description')->nullable();
        $table->json('members');
    }

    public function people()
    {
        return $this->belongsToJson(Person::class, 'members');
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

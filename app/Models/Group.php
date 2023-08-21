<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Orbit\Concerns\Orbital;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;
use Staudenmeir\EloquentJsonRelations\Relations\BelongsToJson;

/**
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property \Illuminate\Support\Collection $members
 */
final class Group extends Model
{
    use HasFactory;
    use HasJsonRelationships;
    use Orbital;

    protected $keyType = 'string';

    protected $casts = [
        'members' => AsCollection::class,
    ];

    public static function schema(Blueprint $table): void
    {
        $table->string('name');
        $table->string('slug');
        $table->string('description')->nullable();
        $table->json('members');
    }

    public function people(): BelongsToJson
    {
        return $this->belongsToJson(
            related: Person::class,
            foreignKey: 'members',
        );
    }

    public function addMember(Person $person): self
    {
        if ($this->members->doesntContain($person->slug)) {
            $this->members->push($person->slug);
        }

        return $this;
    }

    public function getKeyName(): string
    {
        return 'slug';
    }

    public function getIncrementing(): false
    {
        return false;
    }

    public function usesTimestamps(): false
    {
        return false;
    }
}

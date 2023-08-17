<?php

declare(strict_types=1);

namespace App\Models;

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
 * @property array $members
 */
final class Group extends Model
{
    use HasFactory;
    use HasJsonRelationships;
    use Orbital;

    protected $keyType = 'string';

    protected $casts = [
        'members' => 'json',
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
        $members = collect($this->members);

        if ($members->doesntContain($person->slug)) {
            $members->push($person->slug);
        }

        $this->members = $members->all();

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

<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Orbit\Concerns\Orbital;

/**
 * @property string $name
 * @property string $slug
 * @property string $x_handle
 * @property string $x_avatar_url
 * @property string $github_handle
 * @property string $website_url
 */
final class Person extends Model
{
    use HasFactory;
    use Orbital;

    protected $keyType = 'string';

    public static function schema(Blueprint $table): void
    {
        $table->string('name');
        $table->string('slug');
        $table->string('x_handle')->nullable();
        $table->string('x_avatar_url')->nullable();
        $table->string('github_handle')->nullable();
        $table->string('website_url')->nullable();
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

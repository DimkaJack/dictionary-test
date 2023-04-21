<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TranslationExample
 *
 * @property string $id
 * @property string $description
 * @property string $translation_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Translation $translation
 * @method static \Database\Factories\TranslationExampleFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|TranslationExample newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TranslationExample newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TranslationExample query()
 * @method static \Illuminate\Database\Eloquent\Builder|TranslationExample whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TranslationExample whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TranslationExample whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TranslationExample whereTranslationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TranslationExample whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TranslationExample extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'description',
        'translation_id',
    ];

    public function translation()
    {
        return $this->belongsTo(Translation::class);
    }
}

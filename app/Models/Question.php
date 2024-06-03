<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 *
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $category_id
 * @property string $question
 * @property int $expected
 * @property string|null $advice
 * @property-read Category $category
 * @property-read Collection<int, Response> $responses
 * @property-read int|null $responses_count
 * @method static Builder|Question newModelQuery()
 * @method static Builder|Question newQuery()
 * @method static Builder|Question query()
 * @method static Builder|Question whereAdvice($value)
 * @method static Builder|Question whereCategoryId($value)
 * @method static Builder|Question whereCreatedAt($value)
 * @method static Builder|Question whereExpected($value)
 * @method static Builder|Question whereId($value)
 * @method static Builder|Question whereQuestion($value)
 * @method static Builder|Question whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Question extends Model
{
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function responses(): HasMany
    {
        return $this->hasMany(Response::class);
    }

    public function next(): Question|null
    {
        return Question::where('id', '>', $this->id)->orderBy("id", "ASC")->first();
    }

    public function scopeRelatedCount(Builder $builder, Project $project) {



    }
}

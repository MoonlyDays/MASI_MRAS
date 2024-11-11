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
 *
 * @method static Builder<static>|Question newModelQuery()
 * @method static Builder<static>|Question newQuery()
 * @method static Builder<static>|Question query()
 * @method static Builder<static>|Question whereAdvice($value)
 * @method static Builder<static>|Question whereCategoryId($value)
 * @method static Builder<static>|Question whereCreatedAt($value)
 * @method static Builder<static>|Question whereExpected($value)
 * @method static Builder<static>|Question whereId($value)
 * @method static Builder<static>|Question whereQuestion($value)
 * @method static Builder<static>|Question whereUpdatedAt($value)
 *
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

    public function next(): ?Question
    {
        return Question::where('id', '>', $this->id)->orderBy('id', 'ASC')->first();
    }
}

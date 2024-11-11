<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $project_id
 * @property int $question_id
 * @property int $answer
 * @property string|null $reason
 * @property-read Question|null $question
 *
 * @method static Builder<static>|Response newModelQuery()
 * @method static Builder<static>|Response newQuery()
 * @method static Builder<static>|Response query()
 * @method static Builder<static>|Response whereAnswer($value)
 * @method static Builder<static>|Response whereCreatedAt($value)
 * @method static Builder<static>|Response whereId($value)
 * @method static Builder<static>|Response whereProjectId($value)
 * @method static Builder<static>|Response whereQuestionId($value)
 * @method static Builder<static>|Response whereReason($value)
 * @method static Builder<static>|Response whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
class Response extends Model
{
    const YES = 1;

    const NO = 2;

    const UNRELATED = 3;

    protected $fillable = [
        'answer',
        'reason',
    ];

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    public function score(): int
    {
        if ($this->answer == self::UNRELATED) {
            // No difference.
            return 0;
        }

        $expected = $this->question->expected ? self::YES : self::NO;

        return $this->answer == $expected ? 1 : -1;
    }
}

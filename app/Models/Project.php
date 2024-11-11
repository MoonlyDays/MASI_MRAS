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
 * @property int $user_id
 * @property string $title
 * @property-read Collection<int, Report> $reports
 * @property-read int|null $reports_count
 * @property-read Collection<int, Response> $responses
 * @property-read int|null $responses_count
 * @property-read User $user
 *
 * @method static Builder<static>|Project newModelQuery()
 * @method static Builder<static>|Project newQuery()
 * @method static Builder<static>|Project query()
 * @method static Builder<static>|Project whereCreatedAt($value)
 * @method static Builder<static>|Project whereId($value)
 * @method static Builder<static>|Project whereTitle($value)
 * @method static Builder<static>|Project whereUpdatedAt($value)
 * @method static Builder<static>|Project whereUserId($value)
 *
 * @mixin Eloquent
 */
class Project extends Model
{
    protected $fillable = [
        'title',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany<Response>
     */
    public function responses(): HasMany
    {
        return $this->hasMany(Response::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    public function isCompleted(): bool
    {
        return Question::count() <= $this->responses()->count();
    }

    public function setAnswerFor(Question $question, int $answer, ?string $reason = null): void
    {
        /** @var Response $response */
        $response = $this->responses()
            ->where('question_id', $question->id)
            ->firstOrNew();

        $response->question_id = $question->id;
        $response->fill([
            'answer' => $answer,
            'reason' => $reason,
        ]);

        $response->save();
    }
}

<?php

namespace App\Models;

use App\Mail\ReportMail;
use Arr;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Mail;

/**
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $project_id
 * @property string $email
 * @property array $data
 * @property-read mixed $percent
 * @property-read Project $project
 *
 * @method static Builder<static>|Report newModelQuery()
 * @method static Builder<static>|Report newQuery()
 * @method static Builder<static>|Report query()
 * @method static Builder<static>|Report whereCreatedAt($value)
 * @method static Builder<static>|Report whereData($value)
 * @method static Builder<static>|Report whereEmail($value)
 * @method static Builder<static>|Report whereId($value)
 * @method static Builder<static>|Report whereProjectId($value)
 * @method static Builder<static>|Report whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
class Report extends Model
{
    protected $fillable = [
        'data',
        'email',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    protected static function boot(): void
    {
        parent::boot();

        self::created(function (Report $report) {
            Mail::to($report->email)->send(
                new ReportMail($report)
            );
        });
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function percent(): Attribute
    {
        return Attribute::make(
            get: fn () => once(fn () => $this->statsFor(null)['secure_percent'])
        );
    }

    /**
     * @return Collection<Category>
     */
    public function categories(): Collection
    {
        return once(function () {
            return $this->questions()->pluck('category')->unique()->values();
        });
    }

    /**
     * @return Collection<Question>
     */
    public function questions(): Collection
    {
        return once(function () {
            $ids = collect($this->data)->keys();

            return Question::findMany($ids)->load('category');
        });
    }

    public function answerFor(Question $question): array|false
    {
        return Arr::get($this->data, $question->id, false);
    }

    public function statsFor(?Category $category): array
    {
        /** @var Collection<Question> $questions */
        $questions = $this->questions();
        if (isset($category)) {
            $questions = $questions->where('category_id', $category->id);
        }

        $relatedCount = 0;
        $secureCount = 0;
        $advices = [];
        $listings = [];

        foreach ($questions as $question) {
            $answer = $this->answerFor($question);
            if ($answer === false) {
                continue;
            }

            $answerType = $answer[0];
            $listing = [
                'question' => $question->question,
                'answer' => $answerType,
            ];

            if ($answerType == Response::UNRELATED) {
                $listing['color'] = 'text-yellow-500';
                $listing['reason'] = $answer[1];
                $listings[] = $listing;

                continue;
            }

            $relatedCount++;
            $expected = $question->expected ? Response::YES : Response::NO;
            if ($expected == $answerType) {
                $listing['color'] = 'text-green-500';
                $secureCount++;
            } else {
                $listing['color'] = 'text-red-500';
                $advices[] = $question->advice;
            }

            $listings[] = $listing;
        }

        return [
            'related_count' => $relatedCount,
            'insecure_count' => $relatedCount - $secureCount,
            'secure_count' => $secureCount,
            'secure_percent' => $relatedCount > 0 ? floor($secureCount / $relatedCount * 100) : 0,
            'advices' => $advices,
            'listings' => $listings,
        ];
    }
}

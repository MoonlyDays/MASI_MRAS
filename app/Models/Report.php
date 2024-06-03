<?php

namespace App\Models;

use Arr;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 *
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $project_id
 * @property-read Project $project
 * @property array $data
 * @property string $email
 * @method static Builder|Report newModelQuery()
 * @method static Builder|Report newQuery()
 * @method static Builder|Report query()
 * @method static Builder|Report whereCreatedAt($value)
 * @method static Builder|Report whereData($value)
 * @method static Builder|Report whereId($value)
 * @method static Builder|Report whereProjectId($value)
 * @method static Builder|Report whereUpdatedAt($value)
 * @method static Builder|Report whereEmail($value)
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

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
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

            return Question::findMany($ids)->load("category");
        });
    }

    public function answerFor(Question $question): int|false
    {
        return Arr::get($this->data, $question->id, false);
    }

    public function statsFor(Category|null $category): array
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

            $listing = [
                'question' => $question->question,
                'answer' => $answer,
            ];

            if ($answer == Response::UNRELATED) {
                $listing['color'] = 'text-yellow-500';
                $listings[] = $listing;
                continue;
            }

            $relatedCount++;
            $expected = $question->expected ? Response::YES : Response::NO;
            if ($expected == $answer) {
                $listing['color'] = 'text-green-500';
                $secureCount++;
            } else {
                $listing['color'] = 'text-red-500';
                $advices[] = $question->advice;
            }

            $listings[] = $listing;
        }

        return [
            "related_count" => $relatedCount,
            "insecure_count" => $relatedCount - $secureCount,
            "secure_count" => $secureCount,
            "secure_percent" => $relatedCount > 0 ? floor($secureCount / $relatedCount * 100) : 0,
            "advices" => $advices,
            'listings' => $listings,
        ];
    }
}

<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 *
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $project_id
 * @property int $question_id
 * @property int $answer
 * @method static Builder|Response newModelQuery()
 * @method static Builder|Response newQuery()
 * @method static Builder|Response query()
 * @method static Builder|Response whereAnswer($value)
 * @method static Builder|Response whereCreatedAt($value)
 * @method static Builder|Response whereId($value)
 * @method static Builder|Response whereProjectId($value)
 * @method static Builder|Response whereQuestionId($value)
 * @method static Builder|Response whereUpdatedAt($value)
 * @method static Builder|Response project(Project $project)
 * @method static Builder|Response question(Question $question)
 * @mixin Eloquent
 */
class Response extends Model
{
    protected $fillable = [
        'answer',
    ];

    protected function scopeQuestion(Builder $query, Question $question)
    {
        return $query->where("question_id", $question->id);
    }

    protected function scopeProject(Builder $query, Project $project)
    {
        return $query->where("project_id", $project->id);
    }
}

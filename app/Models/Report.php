<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

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
        'email'
    ];

    protected $casts = [
        'data' => 'array'
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}

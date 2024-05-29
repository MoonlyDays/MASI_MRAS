<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\Report;
use App\Models\User;
use Gate;

class ReportPolicy
{
    public function show(User $user, Report $report): bool
    {
        return $this->index($user, $report->project);
    }

    public function index(User $user, Project $project): bool
    {
        return Gate::check('show', $project);
    }

    public function create(User $user, Project $project): bool
    {
        return $this->index($user, $project) && $project->isCompleted();
    }
}

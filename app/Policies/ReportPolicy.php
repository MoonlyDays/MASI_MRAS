<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Gate;

class ReportPolicy
{
    public function index(User $user, Project $project): bool
    {
        return Gate::check('show', $project);
    }

    public function create(User $user, Project $project): bool
    {
        return $this->index($user, $project) && $project->isCompleted();
    }
}

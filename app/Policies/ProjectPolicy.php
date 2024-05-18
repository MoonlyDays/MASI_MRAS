<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    public function show(User $user, Project $project): bool
    {
        return $project->user_id == $user->id;
    }

    public function update(User $user, Project $project): bool
    {
        return $this->show($user, $project);
    }

    public function create(User $user): bool
    {
        return true;
    }
}

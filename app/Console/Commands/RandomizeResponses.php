<?php

namespace App\Console\Commands;

use App\Models\Project;
use App\Models\Question;
use Illuminate\Console\Command;

class RandomizeResponses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:randomize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Randomizes responses to questions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $questions = Question::all();
        $projects = Project::all();
        $display = ['', 'Yes', 'No', 'Unrelated'];

        foreach ($projects as $project) {
            $this->info("********************************************************");
            $this->info("Project: ".$project->title);
            $this->info("********************************************************");
            foreach ($questions as $question) {
                $answer = rand(1, 3);

                $this->warn(sprintf("Answer: %10s : %s", $display[$answer], $question->question));
                $project->setAnswerFor($question, $answer);
            }
        }
    }
}

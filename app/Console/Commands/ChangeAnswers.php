<?php

namespace App\Console\Commands;

use App\Models\Project;
use App\Models\Question;
use App\Models\Response;
use Illuminate\Console\Command;

class ChangeAnswers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:answer {answer?} {--chance=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Randomizes responses to questions';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $questions = Question::all();
        $projects = Project::all();
        $display = collect([
            Response::YES => 'Yes',
            Response::NO => 'No',
            Response::UNRELATED => 'Unrelated',
        ]);

        $forceAnswer = $this->argument('answer');
        if (isset($forceAnswer)) {
            if (! $display->has($forceAnswer)) {
                $this->error('Invalid answer type');

                return;
            }
        }

        $chance = $this->option('chance') ?? 0;
        $this->info('Random chance of correct answer: '.$chance.'%');

        foreach ($projects as $project) {
            $this->info('********************************************************');
            $this->info('Project: '.$project->title);
            $this->info('********************************************************');
            foreach ($questions as $question) {
                if (isset($forceAnswer)) {
                    $answer = $forceAnswer;
                } else {
                    if (rand(0, 100) < $chance) {
                        $answer = $question->expected ? Response::YES : Response::NO;
                    } else {
                        $answer = rand(1, 3);
                    }
                }

                $this->warn(sprintf('Answer: %10s : %s', $display[$answer], $question->question));
                $project->setAnswerFor($question, $answer);
            }
        }
    }
}

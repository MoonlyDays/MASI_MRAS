<?php

use App\Models\Category;
use App\Models\Question;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $files = File::files('resources/survey');
        foreach ($files as $file) {
            $content = $file->getContents();
            $content = json_decode($content, true);

            $title = Arr::get($content, 'title');
            if (empty($title)) {
                continue;
            }

            $category = new Category;
            $category->title = $title;
            $category->save();

            $questions = Arr::get($content, 'questions');
            foreach ($questions as $question) {
                /** @var Question $q */
                $q = $category->questions()->make();
                $q->expected = Arr::get($question, 'expected') == true;
                $q->question = Arr::get($question, 'question');
                $q->advice = Arr::get($question, 'advice');
                $q->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Question::truncate();
        Category::truncate();
    }
};

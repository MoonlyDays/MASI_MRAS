<?php

use App\Models\Project;
use App\Models\Question;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('responses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignIdFor(Project::class);
            $table->foreignIdFor(Question::class);
            $table->unsignedInteger('answer');
            $table->string('reason')->nullable();

            $table->unique(['project_id', 'question_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('responses');
    }
};

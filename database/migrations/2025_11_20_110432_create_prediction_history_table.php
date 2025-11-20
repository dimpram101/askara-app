<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   /**
    * Run the migrations.
    */
   public function up(): void {
      Schema::create('prediction_history', function (Blueprint $table) {
         $table->id();
         $table->string('nik');
         $table->unsignedBigInteger('user_id')->nullable();
         $table->float('confidence_score');
         $table->string('predicted_class');
         $table->string('processing_time');
         $table->text('summary')->nullable();
         $table->text('clinical_explanation')->nullable();
         $table->text('radiological_findings')->nullable();
         $table->text('recommended_actions')->nullable();
         $table->text('important_notes')->nullable();
         $table->text('follow_up_suggestions')->nullable();
         $table->json('all_probabilities')->nullable();
         $table->json('model_metadata')->nullable();
         $table->dateTime('predicted_at')->nullable();

         $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
         $table->timestamps();
      });
   }

   /**
    * Reverse the migrations.
    */
   public function down(): void {
      Schema::dropIfExists('prediction_history');
   }
};

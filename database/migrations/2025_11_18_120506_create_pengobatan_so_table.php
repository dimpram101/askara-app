<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   /**
    * Run the migrations.
    */
   public function up(): void {
      Schema::create('pengobatan_so', function (Blueprint $table) {
         $table->id();
         $table->string('province');
         $table->unsignedInteger('population');
         $table->unsignedInteger('case');
         $table->unsignedInteger('cured');
         $table->unsignedInteger('complete_curement');
         $table->unsignedInteger('deaths');
         $table->unsignedInteger('failed');
         $table->unsignedInteger('loss_to_follow_up');
         $table->unsignedInteger('not_evaluated');
         $table->decimal('success_rate');
         $table->decimal('mortality_rate');
         $table->decimal('incident_rate');
         $table->decimal('tbc_findings');
         $table->unsignedTinyInteger('hotspot_quadran');
         $table->unsignedTinyInteger('hotspot_average_quadran');
         $table->float('latitude');
         $table->float('longitude');
         $table->timestamps();
      });
   }

   /**
    * Reverse the migrations.
    */
   public function down(): void {
      Schema::dropIfExists('pengobatan_so');
   }
};

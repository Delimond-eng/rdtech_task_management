<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_report_taches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tache_id')->nullable()->constrained('taches')->nullOnDelete();
            $table->foreignId('report_id')->nullable()->constrained('activity_reports')->nullOnDelete();
            $table->string("commentaire")->nullable();
            $table->enum("status",["pending", "completed"])->default("pending");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activity_report_taches');
    }
};

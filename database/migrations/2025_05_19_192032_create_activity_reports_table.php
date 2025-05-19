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
        Schema::create('activity_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agent_id')->nullable()->constrained('agents')->nullOnDelete();
            $table->foreignId('activity_id')->nullable()->constrained('activity_reports')->nullOnDelete();
            $table->foreignId('site_id')->nullable()->constrained("sites")->nullOnDelete();
            $table->date("date")->useCurrent();
            $table->text("commentaire")->nullable();
            $table->string("latlng")->nullable();
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
        Schema::dropIfExists('activity_reports');
    }
};

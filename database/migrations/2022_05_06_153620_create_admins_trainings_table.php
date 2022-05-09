<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTrainingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins_trainings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('admin_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->boolean('present')->default(false);
            // If had a certificate for that training
            $table->boolean('granted')->default(false);
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
        Schema::dropIfExists('admins_trainings');
    }
}

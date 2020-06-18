<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('exam_id');
            $table->string('title',191);
            $table->integer('time');
            $table->string('info',191)->nullable();
            $table->string('reference_img', 191)->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });

        Schema::table('sections', function (Blueprint $table) {
            $table->foreign('exam_id')
                ->onDelete('cascade')
                ->references('id')
                ->on('exams');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subjects');
    }
}

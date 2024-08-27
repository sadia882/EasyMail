<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailesTable extends Migration
{
    public function up()
    {
        Schema::create('emailes', function (Blueprint $table) {
            $table->id();
            $table->string('to');
            $table->string('subject');
            $table->text('body');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('emailes');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveColumnsFromContactsTable extends Migration
{
    public function up()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn(['nom', 'prenom', 'email']);
        });
    }

    public function down()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->string('nom');
            $table->string('prenom');
            $table->string('email')->unique();
        });
    }
}

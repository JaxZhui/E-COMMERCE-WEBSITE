<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('contacts', function (Blueprint $table) {
            if (!Schema::hasColumn('contacts', 'name')) {
                $table->string('name');
            }
            if (!Schema::hasColumn('contacts', 'email')) {
                $table->string('email');
            }
            if (!Schema::hasColumn('contacts', 'message')) {
                $table->text('message');
            }
        });
    }

    public function down()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn(['name', 'email', 'message']);
        });
    }
};

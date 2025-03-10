<?php

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
        Schema::table('admins', function (Blueprint $table) {
            $table->integer('otp')->after('email');
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->integer('otp')->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropIfExists('otp');
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->dropIfExists('otp');
        });
    }
};

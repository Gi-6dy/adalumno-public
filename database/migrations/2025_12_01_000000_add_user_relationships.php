<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'rol')) {
                $table->enum('rol', ['Alumno'])->nullable()->after('email');
            }
        });

        Schema::table('alumnos', function (Blueprint $table) {
            if (! Schema::hasColumn('alumnos', 'user_id')) {
                $table->foreignId('user_id')
                    ->nullable()
                    ->unique()
                    ->constrained()
                    ->cascadeOnDelete()
                    ->after('id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('alumnos', function (Blueprint $table) {
            if (Schema::hasColumn('alumnos', 'user_id')) {
                $table->dropConstrainedForeignId('user_id');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'rol')) {
                $table->dropColumn('rol');
            }
        });
    }
};

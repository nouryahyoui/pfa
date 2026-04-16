<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('annonces', function (Blueprint $table) {
            $table->integer('vues')->default(0)->after('photo_url');
        });
    }

    public function down(): void {
        Schema::table('annonces', function (Blueprint $table) {
            $table->dropColumn('vues');
        });
    }
};
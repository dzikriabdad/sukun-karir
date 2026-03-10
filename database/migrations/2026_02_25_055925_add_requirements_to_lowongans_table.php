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
    Schema::table('lowongans', function (Blueprint $table) {
        // Kita letakkan kolom requirements setelah kolom description agar rapi
        $table->text('requirements')->nullable()->after('description');
    });
}

public function down(): void
{
    Schema::table('lowongans', function (Blueprint $table) {
        $table->dropColumn('requirements');
    });
}
};

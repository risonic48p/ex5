<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): bool
    {
        Schema::create('short_links', function (Blueprint $table) {
            $table->id();
            $table->string('url', 500);
            $table->string('hash', 32)->unique();
            $table->integer('user_id')->index();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            return true;
        });

        return false;
    }

    /**
     * Reverse the migrations.
     */
    public function down(): bool
    {
        Schema::dropIfExists('short_links');
        return true;
    }
};

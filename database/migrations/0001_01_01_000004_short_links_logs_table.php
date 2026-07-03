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
        Schema::create('short_links_logs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('link_id', false, true)->index();
            $table->bigInteger('creator_id', false, true)->index();
            $table->string('user_ip', 255);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->foreign('link_id')
                ->references('id')
                ->on('short_links')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('creator_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            return true;
        });

        return false;
    }

    /**
     * Reverse the migrations.
     */
    public function down(): bool
    {
        Schema::dropIfExists('short_links_logs');
        return true;
    }
};

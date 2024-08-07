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
        //
        Schema::rename('timesheets', 'old_timesheets');
        Schema::create('timesheets', function(Blueprint $tabe){
            $tabe->id();
            $tabe->foreignId('calendar_id');
            $tabe->foreignId('user_id');
            $tabe->enum('type',['work','pause'])->default('work');
            $tabe->timestamp('day_in')->nullable();
            $tabe->timestamp('day_out')->nullable();
            $tabe->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

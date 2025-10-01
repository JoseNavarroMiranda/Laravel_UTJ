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
       Schema::create('assets', function (Blueprint $table) {
           $table->id();
           $table->string('title', 300);
           $table->string('image', 300);
           $table->string('video_path', 100);
           $table->timestamps();
       });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('a_s_s_e_t_s');
    }
};

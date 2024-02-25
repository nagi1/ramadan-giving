<?php

use App\Models\Campaign;
use App\Models\User;
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
        Schema::create('giving_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Campaign::class);
            $table->string('name')->unique()->nullable();
            $table->string('phone')->unique()->nullable();
            $table->string('identifier')->unique()->nullable();
            $table->foreignIdFor(User::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('giving_entries');
    }
};

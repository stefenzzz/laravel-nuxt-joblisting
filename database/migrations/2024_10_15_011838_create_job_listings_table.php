<?php

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
        Schema::create('job_listings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('description');
            $table->string('email')->unique();
            $table->string('company_name');
            $table->string('status')->default('active');
            $table->unsignedInteger('number_impression')->nullable();
            $table->unsignedInteger('number_applies')->nullable();
            $table->unsignedInteger('number_views')->nullable();
            $table->foreignIdFor(User::class,'created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_listings');
    }
};

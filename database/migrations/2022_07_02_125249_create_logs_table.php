<?php

use App\Models\Customer;
use App\Models\Project;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->json('raw_body')->nullable();
            $table->json('server')->nullable();
            $table->json('request')->nullable();
            $table->json('headers')->nullable();
            $table->json('session')->nullable();
            $table->json('additional_data')->nullable();
            $table->foreignIdFor(Project::class)->constrained()->restrictOnDelete()->restrictOnUpdate();
            $table->foreignIdFor(Customer::class)->constrained()->restrictOnDelete()->restrictOnUpdate();
            $table->foreignId('logable_id');
            $table->string('logable_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('logs', function (Blueprint $table) {
            $table->dropForeignIdFor(Project::class);
            $table->dropForeignIdFor(Customer::class);
        });
        Schema::dropIfExists('logs');
    }
};

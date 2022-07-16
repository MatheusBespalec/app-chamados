<?php

use App\Models\Customer;
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
            $table->string('http_method', 20)->nullable();
            $table->json('raw_body')->nullable();
            $table->json('var_server')->nullable();
            $table->json('var_get')->nullable();
            $table->json('var_post')->nullable();
            $table->json('var_request')->nullable();
            $table->json('var_files')->nullable();
            $table->json('var_session')->nullable();
            $table->json('var_cookie')->nullable();
            $table->json('var_headers')->nullable();
            $table->json('var_env')->nullable();
            $table->json('data')->nullable();
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
            $table->dropForeignIdFor(Customer::class);
        });
        Schema::dropIfExists('logs');
    }
};

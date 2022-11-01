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
        Schema::create('bancos_digitais', function (Blueprint $table) {
            $table->id();
            $table->string('webhook')->nullable();
            $table->string('env_lambda')->nullable();
            $table->foreignIdFor(Project::class)->nullable()->constrained()->restrictOnDelete()->restrictOnUpdate();
            $table->foreignIdFor(Customer::class)->nullable()->constrained()->restrictOnDelete()->restrictOnUpdate();
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
        Schema::dropIfExists('bancos_digitais');
    }
};

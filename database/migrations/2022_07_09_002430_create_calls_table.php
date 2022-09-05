<?php

use App\Models\CallCategory;
use App\Models\Customer;
use App\Models\Project;
use App\Models\User;
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
        Schema::create('calls', function (Blueprint $table) {
            $table->id();
            $table->string('webhook');
            $table->string('title');
            $table->string('from');
            $table->uuid();
            $table->string('category');
            $table->text('description')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->foreignIdFor(User::class)->nullable()->constrained()->restrictOnDelete()->restrictOnUpdate();
            $table->foreignIdFor(Customer::class)->constrained()->restrictOnDelete()->restrictOnUpdate();
            $table->foreignIdFor(Project::class)->constrained()->restrictOnDelete()->restrictOnUpdate();
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
        Schema::table('calls', function (Blueprint $table) {
            $table->dropForeignIdFor(Customer::class);
            $table->dropForeignIdFor(Project::class);
            $table->dropForeignIdFor(User::class);
        });
        Schema::dropIfExists('calls');
    }
};

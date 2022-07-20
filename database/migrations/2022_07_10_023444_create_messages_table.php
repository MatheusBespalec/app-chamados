<?php

use App\Models\Call;
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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string('from')->nullable();
            $table->string('text')->nullable();
            $table->string('file_path')->nullable();
            $table->boolean('external')->default(false);
            $table->foreignId('messageable_id');
            $table->string('messageable_type');
            $table->foreignIdFor(User::class)->nullable()->constrained()->restrictOnDelete()->restrictOnUpdate();
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
        Schema::table('messages', function (Blueprint $table) {
            $table->dropForeignIdFor(User::class);
        });
        Schema::dropIfExists('messages');
    }
};

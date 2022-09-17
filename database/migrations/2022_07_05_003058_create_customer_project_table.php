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
        Schema::create('customer_project', function (Blueprint $table) {
            $table->uuid();
            $table->foreignIdFor(Customer::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(Project::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->boolean('status')->default(false);
            $table->primary(['customer_id', 'project_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_project', function (Blueprint $table) {
            $table->dropForeignIdFor(Project::class);
            $table->dropForeignIdFor(Customer::class);
        });
        Schema::dropIfExists('customer_project');
    }
};

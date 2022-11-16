<?php

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
        Schema::create('financial_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->enum('type', ['credit_card', 'checking', 'investiment', 'other'])->default('checking');
            $table->decimal('opening_balance', 10, 2)->default(0);
            $table->decimal('current_balance', 10, 2)->default(0);
            $table->string('currency')->default('BRL');
            $table->foreignId('user_id')->constrained();
            $table->boolean('default')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('financial_accounts');
    }
};

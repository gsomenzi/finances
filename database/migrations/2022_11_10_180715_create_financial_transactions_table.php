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
        Schema::create('financial_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->decimal('value', 10, 2);
            $table->date('date');
            $table->enum('type', ['receipt', 'expense', 'transfer']);
            $table->decimal('previous_balance', 10, 2)->nullable();
            $table->boolean('paid')->default(0);
            $table->date('paid_at')->nullable();
            $table->foreignId('category_id')->constrained('categories');
            $table->foreignId('financial_account_id')->constrained();
            $table->foreignId('destination_id')->nullable()->constrained('financial_accounts');
            $table->foreignId('financial_transaction_id')->nullable()->constrained();
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
        Schema::dropIfExists('financial_transactions');
    }
};

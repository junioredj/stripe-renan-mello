<?php

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
        Schema::create('vendas', function (Blueprint $table) {
            $table->id();
            $table->string('id_transaction');
            $table->timestamp('created');
            $table->string('object');
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->decimal('amount');
            $table->text('description')->nullable();
            $table->text('descricao_licenca')->nullable();
            $table->timestamp('last_auth_mt5')->nullable();
            $table->text('produto_id')->nullable();
            $table->timestamp('start')->nullable();
            $table->timestamp('end')->nullable();
            $table->string('interval')->nullable();
            $table->boolean('paid')->default(false);
            $table->string('subscription')->default(false);
            $table->string('account_mt5')->nullable();
            $table->string('status')->nullable();
            $table->double('saldo')->nullable();
            $table->timestamp('update_account')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendas');
    }
};

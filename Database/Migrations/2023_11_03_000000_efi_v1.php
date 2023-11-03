<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EfiV1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('efi_transactions', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->unsignedInteger('company_id');
            $table->unsignedInteger('document_id')->unique();
            $table->unsignedInteger('location_id');
            $table->string('txid', 32);
            $table->timestamps();
            $table->softDeletes();

            $table->index('company_id');
            $table->foreign('document_id')->references('id')->on('documents');
        });

        Schema::create('efi_logs', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->unsignedInteger('company_id');
            $table->unsignedInteger('document_id')->nullable();
            $table->enum('action', [
                'create',
                'update',
                'cancel',
                'webhook',
                'show',
                'enable',
                'disable'
            ]);
            $table->boolean('error');
            $table->text('message')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('company_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('efi_transactions');
        Schema::dropIfExists('efi_logs');
    }
}

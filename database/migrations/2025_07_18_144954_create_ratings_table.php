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
        Schema::create('ratings', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('document_id');
    $table->unsignedBigInteger('user_id')->nullable();
    $table->string('ip_address')->nullable();
    $table->tinyInteger('rating'); // 1–5
    $table->timestamps();

    $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ratings');
    }
};

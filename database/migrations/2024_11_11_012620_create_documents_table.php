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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
    $table->string('file_name');
    $table->unsignedBigInteger('folder_id');
    $table->string('folder_category');
    $table->string('file_path');
    $table->unsignedBigInteger('user_id');
    $table->timestamps();

// Foreign key constraints
    $table->foreign('folder_id')->references('id')->on('folders')->onDelete('cascade');
    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
};

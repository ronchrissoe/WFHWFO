<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_user', function (Blueprint $table) {
            $table->id();
            $table->string('user_id', 50)->nullable();
            $table->string('password', 50)->nullable();
            $table->string('full_name', 255)->nullable();
            $table->string('department', 255)->nullable();
            $table->string('title', 255)->nullable();
            $table->string('mail', 255)->nullable();
            $table->string('company', 255)->nullable();
            $table->string('manager_name', 255)->nullable();
            $table->boolean('aktif')->nullable();
            $table->string('created_by', 50)->nullable();
            $table->string('updated_by', 50)->nullable();
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
        Schema::dropIfExists('m_user');
    }
}

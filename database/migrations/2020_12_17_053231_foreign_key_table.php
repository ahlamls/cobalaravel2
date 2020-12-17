<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ForeignKeyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comment', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('post_id');

            $table->foreign('user_id')->references('id')->on('user')
            ->onUpdate('NO ACTION')
            ->onDelete('SET NULL');
            $table->foreign('post_id')->references('id')->on('image')
            ->onUpdate('NO ACTION')
            ->onDelete('SET NULL');
        });
        
        Schema::table('image', function (Blueprint $table) {
            $table->index('user_id');
            $table->foreign('user_id')->references('id')->on('user')
            ->onUpdate('NO ACTION')
            ->onDelete('SET NULL');
        });

        Schema::table('vote', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('post_id');
            $table->foreign('user_id')->references('id')->on('user')
            ->onUpdate('NO ACTION')
            ->onDelete('SET NULL');
            $table->foreign('post_id')->references('id')->on('image')
            ->onUpdate('NO ACTION')
            ->onDelete('SET NULL');
        });
        //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

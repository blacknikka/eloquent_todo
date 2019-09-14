<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTreePathsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tree_paths', function (Blueprint $table) {
            $table->unsignedInteger('ancestor')->comment('ancestor of this item');
            $table->unsignedInteger('descendant')->comment('descendant of this item');
            $table->timestamps();

            $table->unique(['ancestor', 'descendant']);

            // fkey
            $table->foreign('ancestor')->references('id')->on('comments');
            $table->foreign('descendant')->references('id')->on('comments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tree_paths');
    }
}

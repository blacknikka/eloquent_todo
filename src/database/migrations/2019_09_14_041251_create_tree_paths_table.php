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
            $table->unsignedInteger('ancestor_id')->comment('ancestor of this item');
            $table->unsignedInteger('descendant_id')->comment('descendant of this item');
            $table->timestamps();

            $table->unique(['ancestor_id', 'descendant_id']);

            // fkey
            $table->foreign('ancestor_id')->references('id')->on('comments');
            $table->foreign('descendant_id')->references('id')->on('comments');
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

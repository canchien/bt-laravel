<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("post_id")->unsigned();
            $table->bigInteger("author")->unsigned();
            $table->bigInteger("comment_parent");
            $table->longText("comment_content");
            $table->boolean("comment_status");
            $table->timestamps();
            $table->foreign("post_id")->references("id")->on("posts");
            $table->foreign("author")->references("id")->on("users");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}

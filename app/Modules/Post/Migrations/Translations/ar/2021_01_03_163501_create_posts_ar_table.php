<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsArTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts_ar', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('post_author');
            $table->longText('post_content')->nullable();
            $table->string('post_title');
            $table->string('post_excerpt')->nullable();
            $table->string('post_status');
            $table->string('post_name')->comment('is slug of post');
            $table->string('post_type');
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
        Schema::dropIfExists('posts');
    }
}

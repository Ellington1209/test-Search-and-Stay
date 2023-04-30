<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookStoresTable extends Migration
{
    public function up()
    {
        Schema::create('book_stores', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false);
            $table->string('isbn', 13)->nullable(false);
            $table->decimal('value', 8, 2)->nullable(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('book_stores');
    }
}

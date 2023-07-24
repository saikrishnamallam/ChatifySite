<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePdfFilesTable extends Migration
{
    public function up()
    {
        Schema::create('pdf_files', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('path');
            $table->text('text_content')->nullable(); // Add the 'text_content' column
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pdf_files');
    }
}

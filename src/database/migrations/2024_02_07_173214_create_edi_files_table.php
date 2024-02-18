<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEdiFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('edi_files', function (Blueprint $table) {
            $table->id();
            $table->integer('edf_cancelled')->default(0);
            $table->integer('edf_test_file')->default(0);
            $table->integer('edf_state')->default(0);
            $table-> integer('edf_cancelled')->default(0);
            $table->dateTime('edf_filedate')->nullable();
                        
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('edi_files');
    }
}

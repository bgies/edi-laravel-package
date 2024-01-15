<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEdiIncomingFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('edi_incoming_files');
        
        Schema::create('edi_incoming_files', function (Blueprint $table) {
            $table->id();
//            $table->bigIncrements('id')->primary();
            $table->unsignedBigInteger('ein_edi_type_id', false)->nullable();
            $table->unsignedBigInteger('ein_response_number')->nullable();
            $table->integer('edi_state')->default(0);
            $table->string('ein_file_name', 255);
            $table->dateTime('ein_datetime')->nullable();
            $table->tinyInteger('ein_read_attempts')->default(0);
            $table->tinyInteger('ein_read_successful')->default(0);
            $table->dateTime('ein_read_datetime')->nullable();
            
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
        Schema::dropIfExists('edi_incoming_files');
    }
}

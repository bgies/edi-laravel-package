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
            $table->bigInteger('edf_edi_type_id');
            $table->integer('edf_cancelled')->default(1);
            $table->integer('edf_test_file')->default(0);
            $table->integer('edf_state')->default(0);
            $table->dateTime('edf_filedate')->nullable();

            $table->timestamp('edf_datetime')->useCurrent();
            $table->integer('edf_transaction_control_number')->nullable();
            $table->string('edf_filename')->nullable();
            $table->string('interchange_sender_id')->nullable();
            $table->string('interchange_receiver_id')->nullable();
            $table->string('application_receiver_code')->nullable();
            $table->string('application_sender_code')->nullable();
            $table->integer('edf_state')->default(0);
            $table->dateTime('edf_transmission_date')->nullable();
            $table->tinyInteger('edi_acknowledged')->nullable();
            $table->integer('edf_records_parsed')->nullable();
            $table->integer('edf_records_transmitted')->nullable();
            $table->boolean('edf_test_file')->nullable()->default(0);
            $table->string('edf_original_filename')->nullable();
            
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

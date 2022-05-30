<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEdiTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('edi_types', function (Blueprint $table) {
            $table->id();
            $table->string('edt_name', 30)->unique('edi_type_name_unique');
            $table->tinyInteger('edt_is_incoming', false, true)->default(1);
            $table->string('edt_edi_standard', 10)->default('X12');
            $table->string('edt_transaction_set_name', 30);
            $table->tinyInteger('edt_enabled')->default(0);
            $table->unsignedBigInteger('edt_control_number')->default(0);
            $table->boolean('edt_manual_create')->default(1);
            $table->boolean('edt_in_use')->default(0);
            $table->integer('edt_user_id')->default(-1);
            $table->dateTime('edt_next_run_datetime')->nullable();
            $table->integer('edt_next_run_increment_seconds')->nullable();
//            $table->integer('edt_before_processObjectType')->default(10);
            $table->text('edt_before_process_object')->nullable();
            $table->string('edt_file_directory');
            $table->text('edt_edi_object')->nullable();
            $table->string('edt_ip_address', 30)->nullable();
//            $table->string('edtUserName', 30)->nullable();
//            $table->string('edtPassword', 30)->nullable();
//            $table->integer('edt_after_process_objectSendProcessingType')->default(1);
            $table->text('edt_after_process_object')->nullable();
            $table->boolean('edt_alert_if_not_acknowledged')->default(1);
            $table->string('edt_alert_object')->nullable();
//            $table->string('edtAlertSMS')->default('');
//            $table->string('edtPGPKeyID', 20)->nullable();
            $table->text('edt_file_drop')->nullable();
//            $table->integer('edt_traEtrID')->nullable();
            $table->text('edt_transmission_object')->nullable();
//            $table->integer('edtCstID')->nullable();
            $table->dateTime('modified')->nullable();
            $table->string('interchange_sender_id', 15);
            $table->string('interchange_receiver_id', 15);
            $table->string('application_sender_code', 15);
            $table->string('application_receiver_code', 15);

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
        Schema::dropIfExists('edi_types');
    }
}

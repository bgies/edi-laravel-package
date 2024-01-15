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
/*      
 *    Switched to using edi_incoming_files and edi_outgoing_files
 *    
        if (!Schema::hasTable('edi_files')) {
           
           Schema::create('edi_files', function (Blueprint $table) {
              $table->id();
              $table->integer('main_id', false, true)->default(1);
              $table->string('file_name', 255)->unique('edi_type_name_unique');
              $table->string('sender_id', 15);
              $table->string('sender_code_qualifier', 3);
              $table->string('receiver_id', 15);
              $table->string('receiver_code_qualifier', 3);
              $table->string('message_reference_number', 14)->nullable();
              $table->string('document_identifier`,
              $table->string('version_identifier`,
              $table->string('revision_identifier`,
              $table->string('message_function_code`, 
              $table->string('`test_indicator`
              
              ->nullable(
              
              $table->tinyInteger('edt_is_incoming', false, true)->default(1);
              $table->string('edt_edi_standard', 10)->default('X12');

              INSERT INTO edi_file(`main_id`, `file_name`, `sender_id`,`sender_code_qualifier`,`receiver_id`,`receiver_code_qualifier`,
                 `message_reference_number`, `document_identifier`, `version_identifier`, `revision_identifier`, `message_function_code`, `test_indicator`)

                 VALUES(NOW(), main_id, file_name, sender_id, sender_code_qualifier, receiver_id, receiver_code_qualifier,
                    message_reference_number, document_identifier, version_identifier, revision_identifier, message_function_code, test_indicator);
                 
              

              $table->timestamps();
                
                
                
                
                IN main_id INT,
                IN file_name VARCHAR(255),
                IN sender_id VARCHAR(15),
                IN sender_code_qualifier VARCHAR(3),
                IN receiver_id VARCHAR(15),
                IN receiver_code_qualifier VARCHAR(3),
                IN message_reference_number VARCHAR(14),
                IN document_identifier VARCHAR(35),
                IN version_identifier VARCHAR(9),
                IN revision_identifier VARCHAR(6),
                IN message_function_code VARCHAR(3),
                IN test_indicator INT
                )
                BEGIN
                DECLARE ediFileId INT;
                
                   
                
                
                
            });
        }
*/        
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

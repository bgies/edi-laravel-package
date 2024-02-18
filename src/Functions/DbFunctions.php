<?php

namespace Bgies\EdiLaravel\Functions;


use Illuminate\Database\Eloquent\Model;
use Bgies\EdiLaravel\lib\x12\options\EDISendOptions;
use Bgies\EdiLaravel\Models\EdiOutgoingFiles;
use Bgies\EdiLaravel\Models\Edifiledetails;

//use lib\x12\SharedTypes;


class DbFunctions //extends BaseController
{
   
   //public static function insertEDIFilesRecord(Model $model, EDISendOptions &$EDIObj ) : edifiles
   public static function insertEDIFilesRecord(Model $model, &$EDIObj ) : EdiOutgoingFiles
   {
      $ediFile = new EdiOutgoingFiles();
//      $ediFile->id = $model->id;
      $ediFile->edf_edi_type_id = $EDIObj->ediId;
      $ediFile->edf_transaction_control_number = $EDIObj->interchangeControlVersionNumber;
      $ediFile->edf_cancelled = 1;
      $ediFile->edf_test_file = $EDIObj->isTestFile;
      $ediFile->edf_state = 1;
      $ediFile->edf_filedate = now();
      
      $ediFile->save();
      
      return $ediFile;
/*      
      `id` int(10) NOT NULL AUTO_INCREMENT,
      `edf_edt_id` int(10) NOT NULL,
      `edf_payment_agency` int(10) DEFAULT NULL,
      `edf_transaction_control_number` int(10) DEFAULT NULL,
      `edf_records_tablename` varchar(255) DEFAULT NULL,
      `edf_filename` varchar(255) DEFAULT NULL,
      `edf_sender_id` int(10) DEFAULT NULL,
      `edf_receiver_id` int(10) DEFAULT NULL,
      `edf_state` int(10) NOT NULL,
      `edf_filedate` datetime DEFAULT NULL,
      `edf_transmission_date` datetime DEFAULT NULL,
      `edf_cancelled` int(10) NOT NULL DEFAULT '0',
      `edf_acknowledged` tinyint(4) DEFAULT NULL,
      `edf_records_parsed` int(10) unsigned DEFAULT NULL,
      `edf_records_transmitted` int(10) DEFAULT NULL,
      `edf_test_file` tinyint(4) DEFAULT '0',
      `edf_cst_id` int(10) unsigned DEFAULT NULL,
      `edf_stf_id` int(10) unsigned DEFAULT NULL,
      `created_at` timestamp NULL DEFAULT NULL COMMENT 'Managed by Laravel',
      `updated_at` timestamp NULL DEFAULT NULL COMMENT 'Managed by Laravel',
      `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'Managed by Laravel',
*/      
      
   }
   
   
   public static function updateEDIFilesRecord(string $ShortFileName, int $EDIID, Model $filesModel, 
          Model $typesModel, EDISendOptions &$EDIObj ) : edifiles
   {

      $filesModel->edf_edt_id = $typesModel->id;
      $filesModel->edf_transaction_control_number = $EDIObj->interchangeControlVersionNumber;
      $filesModel->edf_records_tablename = $EDIObj->ediTableName;
      $filesModel->interchange_sender_id = $EDIObj->interchangeSenderID;
      $filesModel->interchange_receiver_id = $EDIObj->interchangeReceiverID;
      $filesModel->applicatione_sender_code = $EDIObj->applicationSenderCode;
      $filesModel->application_receiver_code = $EDIObj->applicationReceiverCode;
      
      $filesModel->edf_state = 3;
      $filesModel->edf_filename = $ShortFileName;
      $filesModel->edf_cancelled = 0;
      //$filesModel->edf_records_parsed = 
      
      $filesModel->save();  
      return $filesModel;
   }
      
   
   public static function insertFileDetailRecords(array $data, Model $typesModel,
         Model $filesModel, EDISendOptions &$EDIObj, $UniqueControlNumber)
   {
      for ($i = 0; $i < count($data) - 1; $i++) {
         $curData = (array) $data[$i];
         $fileDetailModel = new Edifiledetails();
         $fileDetailModel->efd_edf_id = $filesModel->id;
         $fileDetailModel->efd_record_id = $curData['id'];
         $fileDetailModel->efd_edi_transaction_control_number = $UniqueControlNumber;
//         $fileDetailModel->efd_espState` ,
//         $fileDetailModel->efd_unique_control_number = $curData[''];
         $fileDetailModel->efd_cancelled = 0;
         $fileDetailModel->efd_total = $curData['InvoiceAmount'];
         
         $fileDetailModel->save();
      
      }
      
   }
   
   public static function incrementControlNumber(Model &$ediTypeModel) {
      $ediTypeModel->edt_control_number = $ediTypeModel->edt_control_number + 1;
      $ediTypeModel->save();      
   }
   
}
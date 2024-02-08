<?php

namespace Bgies\EdiLaravel\Lib\X12\TransactionSets\Send;

//use Illuminate\Routing\Controller as BaseController;
//use Bgies\Phpedi\lib

use Bgies\EdiLaravel\Lib\X12\TransactionSets\BaseObjects\BaseEdiSend;
use Bgies\EdiLaravel\Lib\X12\SharedTypes;
use Illuminate\Support\Facades\Storage;
use function Opis\Closure\serialize;
use function Opis\Closure\unserialize;
use Bgies\EdiLaravel\Models\Editypes as ediType;
use Bgies\EdiLaravel\Lib\X12\Options\Send\Send210Options as Send210Options;
use Bgies\EdiLaravel\DataHandling\StoredProcedure;
use Bgies\EdiLaravel\FileHandling\FileDrop;

use Bgies\EdiLaravel\Functions\DateTimeFunctions;
use Bgies\EdiLaravel\Functions\DbFunctions;
use Bgies\EdiLaravel\Functions\SegmentFunctions;
use Bgies\EdiLaravel\Functions\FileFunctions;
use Bgies\EdiLaravel\Lib\X12\Options\Segments\B3Options;
use Bgies\EdiLaravel\Lib\X12\Options\Segments\Seg210Loop0100;
use Bgies\EdiLaravel\Lib\X12\Options\Send\EDISendOptions;
use Bgies\EdiLaravel\Lib\X12\Options\TestOptions\TestFile210;
use Bgies\EdiLaravel\Lib\X12\Delimiters;
use Carbon\Exceptions\Exception;
use Bgies\EdiLaravel\Functions\WriteFileToDisk;
use App\Exceptions\EdiException;
use Bgies\EdiLaravel\Functions\SegmentFunctionsAtoM;
use Bgies\EdiLaravel\Functions\StringFunctions;
use Bgies\EdiLaravel\Lib\X12\Options\Segments\Loop0400Options;
use Bgies\EdiLaravel\Functions\CurrencyFunctions;


class X12Send210 extends BaseEdiSend
{
   private $ediTypeId = null;
   private $ediType = null;
   public $ediOptions = null;
   private $ediBeforeProcessObject = null;
   private $data = null;
   private $ediAfterProcessObject = null;
   
   private $ediFile = array();
   
  
   private $errorCount = 0;
   
   
   /**
    * Create a new instance.
    *
    * @return void
    */
   public function __construct(int $edi_type_id)
   {
      //parent::__construct();
      \Log::info('Bgies\EdiLaravel\X12\X12Send210 construct $edi_type_id: ' . $edi_type_id);
      
      $this->ediType = Editype::find($edi_type_id); //   findOrFail($edi_type_id);

      if (!$this->ediType) {
         \Log::error('X12Send210 edi_type ' . $edi_type_id . ' NOT FOUND');
         return 0;
         throw new Bgies\EdiLaravel\Exceptions\NoSuchEdiTypeException('X12Send210 edi_type ' . $edi_type_id . ' NOT FOUND');
         
         exit;
      }
      
      // make sure it's a 210, otherwise ABORT
      if ($this->ediType->edt_transaction_set_name != '210') {
         \Log::error('X12Send210 edi_type ' . $edi_type_id . ' is not a 210');
         return 0;
         throw new Bgies\EdiLaravel\Exceptions\NoSuchEdiTypeException('X12Send210 edi_type ' . $edi_type_id . ' NOT FOUND');
         
         exit;
         

      }
      
      
      // NOTE - The actual object is at ediOptions and the string representation is edt_edi_object
      $this->ediOptions = unserialize($this->ediType->edt_edi_object);
      $this->ediBeforeProcessObject = unserialize($this->ediType->edt_before_process_object);
      $this->ediAfterProcessObject = unserialize($this->ediType->edt_after_process_object);
      $this->ediFileDrop = unserialize($this->ediType->edt_file_drop);
      
       
       
      \Log::info('');
      \Log::info('class X12Send210 edi_type serialize: ' . serialize($this->ediType));
      
      return 1;
   }
   
   
   public function execute() : string
   {
      \Log::info('Bgies\EdiLaravel\X12 X12Send210 execute START');      
      
      try {
         $dataResult = $this->getData();
      } catch (EdiException $e) {
         \Log::error('Bgies\EdiLaravel\X12 X12Send210 execute EXCEPTION in getData: ' . $e->message);
      } catch (Exception $e) {
         \Log::error('Bgies\EdiLaravel\X12 X12Send210 execute EXCEPTION in getData: ' . $e->getMessage());
      }
      
      
      try {
         $retVal = $this->composeFile($dataResult, 'orders');
         if (!$retVal) {
            \Log::error('Bgies\EdiLaravel\X12 X12Send210 execute composeFile Failed aborting...');
            return false;
         }
      } catch (EdiException $e) {
         \Log::error('Bgies\EdiLaravel\X12 X12Send210 execute EXCEPTION in composeFile: ' . $e->message);
         return print_r($this->ediOptions->ediMemo, true);
      }           
      
      
      try {
         $this->dealWithFile($this->ShortFileName, $this->ediOptions);
      } catch (EdiException $e) {
         \Log::error('Bgies\EdiLaravel\X12 X12Send210 execute EXCEPTION in getData: ' . $e->message);
      }     
      
           
      
      \Log::info('Bgies\EdiLaravel\Lib\X12 X12Send210 execute END');
      return print_r($this->ediOptions->ediMemo, true);
   }
   
   
   protected function getData() {
      \Log::info('Bgies\EdiLaravel\Lib\X12 X12Send210 getData() START');

      try {
         $dataResults = $this->ediBeforeProcessObject->execute();
         $this->data = $dataResults;
         
      } catch (Exception $e) {
         \Log::error('Bgies\EdiLaravel\Lib\X12 X12Send210 getData EXCEPTION: ' . $e->getMessage());
      }   
         
      return $dataResults;
      
      \Log::info('Bgies\EdiLaravel\Lib\X12 X12Send210 getData() dataResults: ' . print_r($dataResults, true));
   }
   
   /**
    * checkForRequiredFields simply checks every row to make sure it has all the required info
    * for the EDI file
    * 
    * @return boolean
    */
   protected function checkForRequiredFields() {
     // if ! field is valid then log it, and return false
     $retVal = true;
      if (!$this->ediType['edt_name']) {
         \Log::error('Name is blank.... aborting');
         $retVal = false;
      }
      
      return $retVal;
   }
   
   protected function composeFile($dataResults, string $tableName) {
      \Log::info('Bgies\EdiLaravel\X12 X12Send210 composeFile() START');
      
      // make sure the ediFile variable is clear. 
      $this->ediFile = null;
      unset($this->ediFile); 
      $this->ediFile = array();
      // also clear the errors
      $this->ediErrors = null;
      unset($this->ediErrors);
      $this->ediErrors = array();
      
      if (!$this->checkForRequiredFields()) {
         \Log::info('Bgies\EdiLaravel\X12 X12Send210 composeFile() FAILED Check for Required Fields');
         return false;         
      }
       
      
      try {
          $ediFile = DbFunctions::insertEDIFilesRecord($this->ediType, $this->ediOptions);
          $this->EDIID = $ediFile->id;
          $ediFile->edf_records_parsed = count($this->data);
          $ediFile->edf_records_tablename = $tableName;
          $this->ediFile = $ediFile;
                    
          $DirectoryDateString = \Bgies\Phpedi\Functions\DateTimeFunctions::GetDateStr(now(),true);
          $TopDirectory = FileFunctions::getTopDirectory();
          
          // Note shortFileName is the dir/file name string entered into the database. 
          $ShortFileName = FileFunctions::getShortFileName($this->ediType->edt_name, $this->EDIID);
          $this->ShortFileName = $ShortFileName;
          $this->ediOptions->ediTableName = $this->ediType->table;
          
         if ($this->WriteTheFile()) {
            
            WriteFileToDisk::WriteEDIFile($this->ediOptions->ediMemo,
                 $ShortFileName, $this->ediOptions);
           
            $ediFile = DbFunctions::updateEDIFilesRecord($ShortFileName, $this->EDIID, $ediFile, $this->ediType, $this->ediOptions );
            $retVal = DbFunctions::insertFileDetailRecords($this->data, $this->ediType,
                  $ediFile, $this->ediOptions, $this->EDIID);
            
            return true;
            
         }
         
         $retVal = DbFunctions::insertFileDetailRecords($this->ediType, $this->ediOptions);         
         
      } catch (EdiException $e) {
         //return false; 
         throw new \App\Exceptions\EdiException($e->message);
      } catch (Exception $e) {
         \Log::error('There was an error. e.Message=' + e.Message + ' Aborting.....');
         throw Exception ($e);
         return false;
      }
      
      
      return true;
   }
   
   
   private function WriteTheFile() : bool
   {  
      $TempStr = '';
      $GroupCount = 0;
      $TotalOfInvoices = 0.00;

      try{
         $this->ediOptions->edi2DigitYearDate = DateTimeFunctions::GetDateStr(now(), false);
         $this->ediOptions->edi4DigitYearDate = DateTimeFunctions::GetDateStr(now(), true);
         $this->ediOptions->ediTime = DateTimeFunctions::GetTimeStr(now());
      
         $TempStr = SegmentFunctions::GetISASegment($this->ediOptions, false, true);
         array_push($this->ediOptions->ediMemo, $TempStr);
         //$EDI.EDIMemo.Add($TempStr);
      
         if (!$this->addInvoices($GroupCount, $TotalOfInvoices)) {
            return false;
         }

         $TempStr = SegmentFunctions::GetIEASegment($GroupCount, $this->ediOptions);
         array_push($this->ediOptions->ediMemo, $TempStr);
      
         return true;
      
      
      } catch (EdiException $exception) {
         \Log::error('X12Send210 WriteTheFile() EdiException There was an error. e.Message=' . $exception->message . ' Aborting.....');
         throw new \App\Exceptions\EdiException($exception->message);
      } catch (Exception $e) {
         \Log::error('X12Send210 WriteTheFile() Exception There was an error. e.Message=' . $exception.getMessage() . ' Aborting.....');
         return false;
      }
         
      return true; 
   }
   
   
  
   private function addInvoices(int &$groupCount, float &$InvoiceTotal) {
            
      $UniqueNumberStr = '';
      $TempStr = '';
      $TempString = '';
      $TempErrorStr = '';
      //I, J, LastCarrierID,
      $LineCount = 0;
      $LXLoopCount = 0;
      $InvoiceCount = 0;
      $TotalInvoiceCount = 0;
      $TotalOfAllInvoices = 0.00;
      $UniqueNumberStr = '';
      
      
      $InvoiceTotal = 0.00;

      $TempStr = SegmentFunctions::GetGSSegment($this->ediOptions, $this->ediOptions->use4DigitYear);
      array_push($this->ediOptions->ediMemo, $TempStr);

      $groupCount = 1;
      $LastCarrierID = $this->ediType['CarrierId'];

     
      foreach ($this->data as $rowVals) {
         Try {
            //Need to strip special EDI characters from all string fields
            //$row->edit;
            Try {
               $classVars = get_object_vars($rowVals);
               
               foreach ($classVars as $name => $value) {
                  
                     $TempString = $value;
                     str_replace($this->ediOptions->delimiters->ComponentElementSeparator, '', $TempString);
                     str_replace($this->ediOptions->delimiters->ElementDelimiter, '', $TempString);
                     str_replace($this->ediOptions->delimiters->SegmentTerminator, '', $TempString);
                     str_replace($this->ediOptions->delimiters->ReleaseCharacter, '', $TempString);
                     str_replace($this->ediOptions->delimiters->DecimalPoint, '', $TempString);
                     $rowVals->$name = $TempString;
                  
               }
            } catch (EdiException $e) {
               // To ensure an exception does not stop file creation
               
            }
         } catch (EdiException $e) {
            
            
         }
      
         $row = get_object_vars($rowVals);
         
         
         if ($this->ediOptions->UseSeparateGSSegmentForEachCarrier) {
            if ($LastCarrierID != $row['CarrierId']) {
               // first insert the closing GE Line
               $TempStr = SegmentFunctions::GetGESegment($InvoiceCount);
               array_push($this->ediOptions->ediMemo, $TempStr);

               // now insert the new GS line.
               $this->InterchangeSenderID = $row['CarrierCustomerCode'];
      
               if ($this->ediOptions->Use4DigitDate) {
                  $TempStr = SegmentFunctions::GetGSLine($EDIObj, true);
               } else {
                  $TempStr = SegmentFunctions::GetGSLine($EDIObj, false);
               }
               array_push($this->ediOptions->ediMemo, $TempStr);
         
               // now update the totals etc.
               $LastCarrierID = $row['CarID'];
               $InvoiceCount = 0;
               $GroupCount++;
            }
         }
      
         $LineCount = 0;
         $InvoiceCount++;
         $TotalInvoiceCount++;

         $TotalCharges = 0.00;
        
         $TempStr = SegmentFunctions::GetSTSegment('210', $this->ediOptions, $TotalInvoiceCount, $UniqueNumberStr);
         $row['UniqueNumberStr'] = $UniqueNumberStr;
         array_push($this->ediOptions->ediMemo, $TempStr);
         $LineCount++;
      
         $TempStr = SegmentFunctionsAtoM::GetB3Line($this->ediOptions, $row);
         array_push($this->ediOptions->ediMemo, $TempStr);
         $LineCount++;
      
         if ($row['CurrencyCode'] != 'USD') {
            $TempStr = SegmentFunctionsAtoM::GetC3Line($this->ediOptions, $row);
            array_push($this->ediOptions->ediMemo, $TempStr);
            $LineCount++;
         }
         
         $this->AddN9Segments($LineCount, $this->ediOptions, $row);
      
      
         $TempStr = SegmentFunctionsAtoM::GetG62Segment($this->ediOptions, $row);
         array_push($this->ediOptions->ediMemo, $TempStr);
         $LineCount++;
      
         // this has not been implemented as it is optional
         if ($this->ediOptions->UseR3Segment) {
            $TempStr = SegmentFunctionsAtoM::GetR3Segment;
            array_push($this->ediOptions->ediMemo, $TempStr);
            $LineCount++;
         }

         // this has not been implemented as it is optional
         if ($this->ediOptions->UseH3Segment) {
            $TempStr = $this->WriteH3Segments($EDIObj, $LineCount);
            array_push($this->ediOptions->ediMemo, $TempStr);
            $LineCount++;         
         }
      
         // this has not been implemented as it is optional
         if ($this->ediOptions->UseK1Segment) {
            $TempStr = $this->EDI210.EDI210K1Lines.WriteK1Lines(self, EDI, EDI210, LineCount);
            array_push($this->ediOptions->ediMemo, $TempStr);
            $LineCount++;         
         }

         $this->WriteLoop0100($row, $this->ediOptions, $LineCount);
      
                              
         $TempStr = SegmentFunctionsAtoM::GetN7Segment($this->ediOptions, $row);
         array_push($this->ediOptions->ediMemo, $TempStr);
         $LineCount++;
                              
         $LXLoopCount = 0;
         if ($this->ediOptions->MakeGSTFirstLXLoop) {
            if ($row['GST'] != Null) {
               $LXLoopCount = 1;
               $TempStr .= 'LX' . $this->ediOptions->delimiters->Delimiter . '1';
               array_push($this->ediOptions->ediMemo, $TempStr);
               $LineCount++;
                              
               $TempStr .= SegmentFunctionsAtoM::GetL1Segment($TotalCharges, $LxLoopCount);
               array_push($this->ediOptions->ediMemo, $TempStr);
               $LineCount++;
            }
         }
                              

         if ($this->ediOptions->useDetailQuery && (trim($this->ediOptions->detailSQL) <> '')) {
            $sqlParts = explode (':', $this->ediOptions->detailSQL);
            
            $detailQuery = new StoredProcedure();
            
            $detailQuery->storedProcedureName = trim($sqlParts[0]) . ' ';
            if (count($sqlParts) > 1) {
               $detailQuery->storedProcedureName .= '("';
            }
            for ($i = 1; $i < count($sqlParts); $i++) {
               if ($i >= 2) {
                  $detailQuery->storedProcedureName .= ', ';
               }
               $detailQuery->storedProcedureName .= $row[$sqlParts[$i]] ;
            }
            if (count($sqlParts) > 1) {
               $detailQuery->storedProcedureName .= '")';
            }
            
            $detailResults = $detailQuery->execute();

            if (($this->ediOptions->ErrorOnZeroInvoiceAmount) && (count($detailResults) < 1)) {
               throw new \App\Exceptions\EdiException('No Invoice Items were returned for Invoice ' . $row['InvoiceId']);
            }
                                       
            $this->AddAuditIDLxLoop($row, $detailResults, $LineCount, $LXLoopCount, 
               $TotalCharges, $this->ediOptions);


            $TempStr = SegmentFunctionsAtoM::GetL3Segment( (array) $row, $TotalCharges, $this->ediOptions);
            array_push($this->ediOptions->ediMemo, $TempStr);
            $LineCount++;
                                       
            $TempStr = SegmentFunctions::GetSESegment($LineCount, $this->ediOptions->delimiters, $UniqueNumberStr);
            array_push($this->ediOptions->ediMemo, $TempStr);
                                       
            $TotalOfAllInvoices = $TotalOfAllInvoices + $TotalCharges;
         }
         
         
         
      }
                                             
      $TempStr = SegmentFunctions::GetGESegment($InvoiceCount, $this->ediOptions);
      array_push($this->ediOptions->ediMemo, $TempStr);
       
      
      
      
      return true;                                  
         
   }
   

   public function WriteLoop0100($row, Send210Options $EDIObj, int &$LineCount) 
   {
      if ($EDIObj->Loop0100Options->LoopCount > $EDIObj->Loop0100Options->MaxCount) {
         throw new EdiException('The Maximum number of Loop 0100 entries is ' . $EDIObj->Loop0100Options->MaxCount);
      }
   
      $retVal = '';      
      for ($i = 1; $i <= $EDIObj->Loop0100Options->LoopCount; $i++) {
         $FieldNamePrefix = 'Loop0100_' . ($i) . '_';
         $LoopFieldName = $FieldNamePrefix . 'EntityIdentifier';
         if (array_key_exists($LoopFieldName, $row)) {
            $this->AddSingleLoop0100($row, $EDIObj, $FieldNamePrefix, $LineCount);
         } else {
            throw new EdiException('Writing Loop 0100 - No SQL field found for loop count ' . ($i + 1) . '  Loop field Name = ' . $LoopFieldName);
         }
      }

   }
    
   
   private function AddSingleLoop0100($row, Send210Options $EDIObj, $FieldNamePrefix, int &$LineCount)
   {
      $LocTypeFieldName = $FieldNamePrefix . 'EntityIdentifier';
   
      if ($row[$LocTypeFieldName] == '') {
         EDI210.ErrorList.Add('The EntityIdentifier for location (' . DataSet.FieldByName(FieldNamePrefix + 'Name').AsString + ') shipment # ' + DataSet.FieldByName('ShpID').AsString + ' is blank.');
         throw new EdiException('The EntityIdentifier for location (' .  $row[$FieldNamePrefix] . 'Name' . ') shipment # ' . $row['InvoiceId'] . ' is blank.');
      }
   
      $LcpCode = '';
      if (trim($row[$FieldNamePrefix . 'LocationCode']) == '') {
         // if either the test or production ErrorOnBlankLocationCode is true then
         // report this.
         if ($EDIObj->ErrorOnBlankLocationCode || $EDIObj->testFileOptions->ErrorOnBlankLocationCode) {
            array_push($EDIObj->errorList, 'The Code for location (' . $row[$FieldNamePrefix . 'Name'] . ') shipment # ' . $row['INvoiceId'] + ' is blank (Field ' . $LocTypeFieldName . ').');
         }
   
         // Abort if it should be aborted.
         if (((! $EDIObj->isTestFile) && $EDIObj->ErrorOnBlankLocationCode) ||
            ($EDIObj->TestFile && $EDIObj->testFileOptions->ErrorOnBlankLocationCode)) {
               throw new EdiException('The Code for location (' + $row[$FieldNamePrefix . 'Name'] . ') shipment # ' . $row['InvoiceId'] . ' is blank (Field ' . $LocTypeFieldName + ').');
            }
             // it's blank so set it to the default location code if there is one
         if ($EDIObj->DefaultLocationCode != '') {
            $LcpCode =  EDI210.DefaultLocationCode;
         }
      } else {
         $LcpCode =  trim($row[$FieldNamePrefix . 'LocationCode']);
      }
      
      // START N1
      if ($EDIObj->Loop0100Options->UseN1) {
         $TempStr = 'N1' . $EDIObj->delimiters->ElementDelimiter . $row[$FieldNamePrefix . 'EntityIdentifier'] . $EDIObj->delimiters->ElementDelimiter; // N101
      
         if ((int) $EDIObj->ediVersionReleaseCode >= 4010) {
            $TempStr .= substr($row[$FieldNamePrefix . 'Name'], 0, 60) . $EDIObj->delimiters->ElementDelimiter; // N102
         } else {
            $TempStr .= substr($row[$FieldNamePrefix . 'Name'], 0, 35) . $EDIObj->delimiters->ElementDelimiter; // N102
         }
         
         // if the customer needs this to be specific for each location then we can
         // pass it in in the dataset, otherwise use the property as the default
         // Note that if the SQL brings in the value it must be correct as it will be
         // used even if it is blank.
         $TempFieldName = $FieldNamePrefix . 'IdCodeQualifier';
         if (array_key_exists($TempFieldName, $row)) {
            $TempStr .= $row[$TempFieldName] . $EDIObj->delimiters->ElementDelimiter;   // N103
            
         } else {
            $TempStr .= $EDIObj->identificationCodeQualifier . $EDIObj->delimiters->ElementDelimiter;  // N103
         }
            
         if ((strlen($LcpCode) < 2) &&  (((! $EDIObj->isTestFile) && $EDIObj->ErrorOnBlankLocationCode)
            || ($EDIObj->isTestFile && $EDIObj->testFileOptions->ErrorOnBlankLocationCode))) {
               array_push($EDIObj->errorList, 'The Code for ' . $row[FieldNamePrefix . 'Name'] . ' is less than 2 characters and therefore invalid for invoice ' .  $row['InvoiceId'] . '. Aborting.....');
               throw new EdiException('The Code for ' . $row[FieldNamePrefix . 'Name'] . ' is less than 2 characters and therefore invalid for shipment ' . $row['InvoiceId'] . '. Aborting.....');
         }
               
         $TempStr .= substr($LcpCode, 0, 17) ;  // N104
               
            //{ TODO 1 -oBrad Gies -cWhen bored : There are two more elements for the 4010 version that are not currently used by our customers. }
         array_push($this->ediOptions->ediMemo, $TempStr);
         $LineCount++;
      }
               
      // START N3
      if ($EDIObj->Loop0100Options->UseN3) {
         if ($row[$FieldNamePrefix . 'LocAddress1'] == '') {

           // if either the test or production ErrorOnBlankLocationCode is true then
           // report this.
            if ($EDIObj->ErrorOnBlankLocationAddress || $EDIObj->testFileOptions->ErrorOnBlankLocationAddress) {
               array_push($EDIObj->errorList, 'The Address1 field for location (' . $row[$FieldNamePrefix . 'Name'] . ') Invoice # ' . $row['InvoiceId'] . ' is blank (Field ' . $LocTypeFieldName + ').');
            }
               
            // Abort if it should be aborted.
            if (((! $EDIObj.isTestFile) && $EDIObj->testFileOptions->ErrorOnBlankLocationAddress) ||
               ($EDIObj.isTestFile && $EDIObj->testFileOptions->ErrorOnBlankLocationAddress)) {
               throw new EdiException('The Address1 field for location (' . $row[FieldNamePrefix . 'Name'] . ') shipment # ' . $row['InvoiceId'] . ' is blank (Field ' . $LocTypeFieldName + ').');
            }
         }
                              
         // This will remove all characters after a forward or backward slash.
         $LocAddress1 = $row[$FieldNamePrefix . 'LocAddress1'];
         if ($EDIObj->Loop0100Options->TruncateAddressAtSlash) {
            if (strpos($LocAddress1, '/') > 0) {
               $LocAddress1 = substr($LocAddress1, 0, strpos('/', $LocAddress1) - 1);
            }
// NOTE if the is needed the code commented out needs to be implemented. but the 
//      backward slash is a PHP control character. 
//               if (strpPos($LocAddress1, '\') > 0) {
//                     $LocAddress1 = substr($LocAddress1, 0, strpos($LocAddress1, '\') - 1);
//               }
            $LocAddress1 = trim($LocAddress1);
         }
                     
                     
        if ((int) $EDIObj->ediVersionReleaseCode >= 4010) {
           $TempStr = 'N3' . $EDIObj->delimiters->ElementDelimiter . substr($LocAddress1, 0, 55);
        } else {
           $TempStr = 'N3' + $EDIObj->delimiters->ElementDelimiter . substr($row[$FieldNamePrefix . 'LocAddress1'], 0, 35);
        }
        // Don't send anything if it's blank so the line won't end with a delimiter.
        // Versions >= 4010  allow 55 characters. Other versions only 35 characters.
        if (array_key_exists($FieldNamePrefix . 'LocAddress2', $row )) {
           if ((int) $EDIObj->ediVersionReleaseCode >= 4010) {
              $TempStr .= $EDIObj->delimiters->ElementDelimiter . substr($row[$FieldNamePrefix . 'LocAddress2'], 0, 55);
           } else {
              $TempStr .= $EDIObj->delimiters->ElementDelimiter . substr($row[$FieldNamePrefix . 'LocAddress2'], 0, 35);
           }
        }
         
        array_push($this->ediOptions->ediMemo, $TempStr);
        $LineCount++;
      }
                        
      // START N4
      if ($EDIObj->Loop0100Options->UseN4) {
         if (strlen($row[$FieldNamePrefix . 'LocCity']) < 2) {
            throw new EdiException('The ' . $row[$FieldNamePrefix . 'Name'] . ' city for ' . $row[$FieldNamePrefix . 'Name'] . ' shipment # ' . $row['InvoiceId'] . ' is invalid. It must be at least 2 characters');
         }
                        
         if ( (int) $EDIObj->ediVersionReleaseCode >= 4010) {
            $TempStr = 'N4' . $EDIObj->delimiters->ElementDelimiter . substr($row[$FieldNamePrefix . 'LocCity'], 0, 30) . $EDIObj->delimiters->ElementDelimiter;  // N4 01
         } else {
            $TempStr = 'N4' . $EDIObj->delimiters->ElementDelimiter . substr($row[$FieldNamePrefix . 'LocCity'], 0, 19) . $EDIObj->delimiters->ElementDelimiter; // N4 01
         }
                           
         if (strlen($row[$FieldNamePrefix . 'LocState']) < 2) {
            throw new EdiException('The ' . $row[$FieldNamePrefix . 'Name'] . ' State for ' . $row[$FieldNamePrefix] . 'Name' . ' shipment # ' . $row['InvoiceId'] . ' is invalid. It must be at least 2 characters') ;
         }
                           
         $TempStr .= substr($row[$FieldNamePrefix . 'LocState'], 0, 2) . $EDIObj->delimiters->ElementDelimiter; // N4 02
                           
         // if the country is Canada and we are allowing Canadian postal codes then just
         // use whatever is in the field.
         if ( strtoupper(trim($row[$FieldNamePrefix . 'LocCountry'])) == 'CA') {
            $TempZip = $row[$FieldNamePrefix + 'LocZip'];
            if ($EDIObj->RemoveSpaceFromCanadianPostalCode) {
               $TempZip = StringFunctions::RemoveSpaceFromCanadianPostal($TempZip);
            }
            if ($EDIObj->Loop0100Options->AllowCanadianPostalCodesForZip) {
               $TempStr .= $TempZip . $EDIObj->delimiters->ElementDelimiter;  // N4 03
            } else {
               // else use the cleaned up version of the zip code.
               $TempStr .= StringFunctions::CleanUpZipCode($TempZip) . $EDIObj->delimiters->ElementDelimiter;  // N4 03
            }
         } else {
           // else use the cleaned up version of the zip code,
           // unless it's Mexico and we're allowing Alpha's
            if (strtoupper(trim($row[$FieldNamePrefix . 'LocCountry'])) == 'MX' 
                && (!$EDIObj->Loop0100Options->CleanMexicanZipCode)) {
               $TempStr .= $row[$FieldNamePrefix . 'LocZip'] . $EDIObj->delimiters->ElementDelimiter;  // N4 03
            } else {
               $TempStr .= StringFunctions::CleanUpZipCode($row[$FieldNamePrefix . 'LocZip']) . $EDIObj->delimiters->ElementDelimiter;  // N4 03
            }
                                       
            if (strlen($row[$FieldNamePrefix . 'LocCountry']) < 2) {
               throw new EdiException('The ' . $row[$FieldNamePrefix . 'Name'] . ' Country for ' . $row[$FieldNamePrefix . 'Name'] . ' shipment # ' . $row['InvoiceId'] . ' is invalid. It must be at least 2 characters') ;
            }
                                       
            if ((int)$EDIObj->ediVersionReleaseCode >= 4010) {
               $TempStr .= substr($row[$FieldNamePrefix . 'LocCountry'], 0, 3);        // N4 04
            } else {
               $TempStr .= substr($row[$FieldNamePrefix . 'LocCountry'], 0, 2);                  // N4 04
            }
                                          
            if ((array_key_exists($FieldNamePrefix . 'LocationQualifier', $row))
               && (array_key_exists($FieldNamePrefix . 'RegionCode', $row))) {

                $TempStr .= $EDIObj->delimiters->ElementDelimiter +
                          substr($row[$FieldNamePrefix . 'LocationQualifier'], 0, 2) .
                          $EDIObj->delimiters->ElementDelimiter .
                          substr($row[$FieldNamePrefix . 'RegionCode'], 0, 30);
                      // N4 04
            }
         }
                                             
            array_push($this->ediOptions->ediMemo, $TempStr);
            $LineCount++;

      }
   }
                                             
   
   
   private function AddN9Segments(int &$LineCount, EDISendOptions $EDIObj, $row)
   {
      // In Delphi I had an elaborate structure to customize the N9 segments on the file, 
      // but for PHP We will just loop through the possible codes in the options object, 
      // and add those we have data for. 
      $N9String = $EDIObj->N9Segments;
      if (trim($N9String) == '') {
         throw new EdiException('N9 Segments are mandatory to send Bill of Lading and other codes');
      }
            
      $N9Array =  explode('|', $N9String);
      foreach ($N9Array AS $N9CodeStr) {
         $N9CodePieces = explode(':', $N9CodeStr);
         $N9Code = $N9CodePieces[0];
         $N9FieldName = $N9CodePieces[1];
         if (count($N9CodePieces) > 2) {
            $N9DateFieldName = $N9CodePieces[2];
         } else {
            $N9DateFieldName = '';
         }
         
         $TempStr = 'N9' . $EDIObj->delimiters->ElementDelimiter;
         $TempStr .= $N9Code . $EDIObj->delimiters->ElementDelimiter;  // N9 01
         
         $TempStr2 = StringFunctions::CleanString($row[$N9FieldName], true);
         $row[$N9FieldName] = $TempStr2;
         
         if ($EDIObj->Loop0060ConvertValueToUpperCase) {
            $TempStr .= strtoupper(substr($row[$N9FieldName], 0, 30)) . $EDIObj->delimiters->ElementDelimiter;   // N9 02
         } else {
            $TempStr .= substr($row[$N9FieldName], 0, 30) . $EDIObj->delimiters->ElementDelimiter;   // N9 02
         }
            
         if ($EDIObj->Loop0060UseFieldNameAsDescription) {
            $TempStr .= $N9FieldName . $EDIObj->delimiters->ElementDelimiter;
         } else {
            $TempStr .= $EDIObj->delimiters->ElementDelimiter;  // N9 03
         }
           
         if (array_key_exists($N9DateFieldName, $row)) {
            if (trim($row[$N9DateFieldName]) <> '') {
               $TempStr .= DateTimeFunctions::GetDateStr($row[$N9DateFieldName], true) . $EDIObj->delimiters->ElementDelimiter + $EDIObj->delimiters->ElementDelimiter; // N9 04
            }
         }
         
         array_push($this->ediOptions->ediMemo, $TempStr);
         $LineCount++;
         
      }
      
   }
      
      
   private function AddAuditIDLxLoop(array $MsterDataSet, array $Details, int &$LineCount, int $LXLoopCount,
        float &$TotalCharges, Send210Options $EDIObj)
   {
      for ($i = 0; $i < count($Details); $i++) {
         $detailRow = (array) $Details[$i];
         $LXLoopCount++;
         $TempStr = 'LX' . $EDIObj->delimiters->ElementDelimiter . $LXLoopCount;
         array_push($this->ediOptions->ediMemo, $TempStr);
         $LineCount++;
         
         
         if ($detailRow['ItemType'] == 400) {
            $TempStr = 'L5' . $EDIObj->delimiters->ElementDelimiter .
                  $LXLoopCount . $EDIObj->delimiters->ElementDelimiter;
            // if we have the field then put this in, otherwise leave it blank.
            if (array_key_exists('LadingDescription', $detailRow)) {
               $TempStr .= $detailRow['LadingDescription'];
            }
            $TempStr .= $EDIObj->delimiters->ElementDelimiter . '2' . $EDIObj->delimiters->ElementDelimiter . 'Z';
            array_push($this->ediOptions->ediMemo, $TempStr);
            $LineCount++;
      
            // Dry run exclusion taken out for Freightliner.
            $TempStr = SegmentFunctionsAtoM::GetL0Segment(  $detailRow, $LXLoopCount, $EDIObj);
            if ($TempStr != '') {
               array_push($this->ediOptions->ediMemo, $TempStr);
               $LineCount++;
            }
         }
         
         
         $TempFloatStr = CurrencyFunctions::ConvertMoneyToCents($detailRow['ItemTotal']);
         $TempFloatStr = CurrencyFunctions::RemoveCommas($TempFloatStr);
         
         //$TotalCharges = $TotalCharges + round($detailRow['ItemTotal'], 2);
      
         $TempStr = 'L1' . $EDIObj->delimiters->ElementDelimiter . $LXLoopCount . $EDIObj->delimiters->ElementDelimiter .  // L1 01
               $TempFloatStr . $EDIObj->delimiters->ElementDelimiter . 'FR' . $EDIObj->delimiters->ElementDelimiter . // L1 02-03
               $TempFloatStr . $EDIObj->delimiters->ElementDelimiter;  // L1 04
         
         $TempStr .= $EDIObj->delimiters->ElementDelimiter . $EDIObj->delimiters->ElementDelimiter . $EDIObj->delimiters->ElementDelimiter; // L1 05-07

         if (strlen($detailRow['ItemType']) > 0) {
            switch ($detailRow['ItemType']) { // L1 08
               case 0 : $TempStr .= 'PAE'; break; // premiumfreight
               case 1 : $TempStr .= 'PAV'; break;  // Pickup on Sat.Sun and/or holiday plus next day delivery
               case 2 : $TempStr .= 'HOL'; break; // Sun or Holiday pickup or delivery
               case 3 : $TempStr .= 'SAS'; break;  // Shipment Holdover on weekends
               case 4 : $TempStr .= 'DTL'; break;  // Detention loading
               case 5 : $TempStr .= 'DTU'; break;  // Detention unloading
               case 6 : $TempStr .= 'IHT'; break;  // Interstate/ highway toll
               case 7 : $TempStr .= 'RCC'; break;  // Reconsigment charge
               case 8 : $TempStr .= 'RCL'; break;  // Redelivery
               case 9 : $TempStr .= 'CNS'; break;  // Consolidation
               case 10 : $TempStr .= 'SOC'; break;  // Stop off charge
               case 11 : $TempStr .= 'SEC'; break;  // Special equipment charge
               case 12 : $TempStr .= 'FUE';  break; // fuel charge
               case 13 : $TempStr .= 'VOR'; break;  // Vehicle ordered not used (dry run)
               case 14 : $TempStr .=  'MIL'; break;  // Special mileage movements
               case 15 : $TempStr .= 'FUE'; break;  // fuel charge
               case 16 : $TempStr .= 'MIL'; break;  // special mileage movements
               case 400 : $TempStr .= ''; break;  // Freight
               case 401 : $TempStr .= 'GST'; break;  // GST
               case 402 : $TempStr .= 'SUC'; break;  // SCIP Fee
               default : {
                  $TempStr .= 'MSC';  // other accessorial charge
                  array_push($EDIObj->ErrorList, 'Unknown ItemType for L1 Line ');
               }

            } //case
         }
      
         $TempStr .= $EDIObj->delimiters->ElementDelimiter; // finish L1 08
         $TempStr .= $EDIObj->delimiters->ElementDelimiter . 
               $EDIObj->delimiters->ElementDelimiter . $EDIObj->delimiters->ElementDelimiter; // L1 09-11
      
         switch ($detailRow['Item']) {  // L1 12
            case 0 : $TempStr .= 'Cost'; break;      // Acc  0
            case 1 : $TempStr .= 'Sat-Sun'; break;          // Acc  1
            case 2 : $TempStr .= 'Holiday'; break;          // Acc  2
            case 3 : $TempStr .= 'Hold Delivry'; break;     // Acc  3
            case 4 : $TempStr .= 'Det @ Orig'; break;       // Acc  4
            case 5 : $TempStr .= 'Det @ Dest'; break;       // Acc  5
            case 6 : $TempStr .= 'Tolls-Permts'; break;     // Acc  6
            case 7 : $TempStr .= 'Re-Con/Div'; break;       // Acc  7
            case 8 : $TempStr .= 'Re-Delivry'; break;       // Acc  8
            case 9 : $TempStr .= 'Consolidated'; break;     // Acc  9
            case 10 : $TempStr .= 'Stop-Off'; break;         // Acc 10
            case 11 : $TempStr .= 'Special Eqp'; break;      // Acc 11
            case 12 : $TempStr .= 'Fuel Charges'; break;     // Acc 12
            case 13 : $TempStr .= 'Dry Run'; break;          // Acc 13
            case 14 : $TempStr .= 'Sp/By'; break;            // Acc 14
            case 15 : $TempStr .= 'Other'; break;            // Acc 15
            case 16 : $TempStr .= 'Sp/By Adj'; break;        // Acc 16
            case 400 : $TempStr .= 'Freight'; break;  // Freight
            default : {
               $TempStr .= 'Other';
            }
         }

         array_push($this->ediOptions->ediMemo, $TempStr);
         $LineCount++;
         
         if ($detailRow['ItemType'] == 'Freight') {
            if ($EDIObj->Loop0400Options->UseL7InLXLoop && ( array_key_exists('Miles', $detailRow))) {
               $TempStr = 'L7' . $EDIObj->delimiters->ElementDelimiter . $LXLoopCount .  $EDIObj->delimiters->ElementDelimiter . $EDIObj->delimiters->ElementDelimiter . $EDIObj->delimiters->ElementDelimiter;  // L7 01-03
               $TempStr .= $EDIObj->delimiters->ElementDelimiter . $EDIObj->delimiters->ElementDelimiter;
            
               $TempStr .= $EDIObj->delimiters->ElementDelimiter . $EDIObj->delimiters->ElementDelimiter .  // L7 04-07
                     $EDIObj->delimiters->ElementDelimiter . $EDIObj->delimiters->ElementDelimiter . $EDIObj->delimiters->ElementDelimiter . $EDIObj->delimiters->ElementDelimiter . $EDIObj->delimiters->ElementDelimiter;   // L7 08-12
               $TempStr .= (int)$detailRow['Miles'] . $EDIObj->delimiters->ElementDelimiter . 'M';     // L7 13-14
               array_push($this->ediOptions->ediMemo, $TempStr);
               $LineCount++;
            }
         }
      }
   
   }
   
   
   
   // Compose File generates the file and saves it to the semi permanent directory it will stay in
   //  
   // this procedure is to get a copy of the file where it needs to be (an FTP directory, either 
   // here or at the client
   protected function dealWithFile(string $FileShortName, EDISendOptions $EDIObj) {
      \Log::info('Bgies\Phpedi\X12 X12Send210 dealWithFile() START');
      
       DbFunctions::incrementControlNumber($this->ediType);
      
      
      try {
         $this->ediAfterProcessObject->execute();
         
      } catch (EdiException $e) {
            
      } 
      
      
      
      
   }
   
    
   
   
}
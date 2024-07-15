<?php

namespace Bgies\EdiLaravel\Lib\X12\TransactionSets\Read;

use Bgies\EdiLaravel\FileHandling\FileDrop;
use Bgies\EdiLaravel\Lib\PropertyType;
use Bgies\EdiLaravel\Lib\ReturnValues;
use Bgies\EdiLaravel\Lib\X12\SegmentFunctions;
use Bgies\EdiLaravel\Lib\X12\TransactionSets\BaseObjects\BaseEdiReceive;
use Bgies\EdiLaravel\Lib\X12\Options\Read\EDIReadOptions;
use Bgies\EdiLaravel\Models\EdiFile;
use Bgies\EdiLaravel\Models\EdiType;
use Bgies\EdiLaravel\Functions\LoggingFunctions;
use Bgies\EdiLaravel\Functions\EdiFileFunctions;
use Bgies\EdiLaravel\Lib\X12\SharedTypes;

class X12Read210 extends BaseEdiReceive
{
   public $transactionSetName = '210';
   protected ?EdiFile $ediFile = null;
   
   /*
    * From BaseEdiReceive
    *    protected $dataset = array();
    *    protected $ediTypeId = null;
    *    protected ?EdiType $ediType = null;
    *    protected $ediOptions = null;
    *    protected $edtBeforeProcessObject = null;
    *    protected $fileString = '';
    *    protected $fileArray = array();
    *    protected $edtAfterProcessObject = null;
    *    protected $errorCount = 0;
    */
   
   
   /**
    * Create a new instance.
    *
    * @return void
    */
   public function __construct(EdiType $ediType, EdiFile $ediFile)
   {
      parent::__construct($ediType, $ediFile);
      LoggingFunctions::logThis('info', 4, 'Bgies\EdiLaravel\Lib\X12\TransactionSets\Read\X12Read210 construct', 'edi_type_id: ' . $ediType->id);
     
      if (!$this->ediType) {
         LoggingFunctions::logThis('error',7, 'Bgies\EdiLaravel\Lib\X12\TransactionSets\Read\X12Read210 construct', 'edi_type (' . $edi_type_id . ') NOT FOUND');
         return 0;
      }

      LoggingFunctions::logThis('info',3, 'Bgies\EdiLaravel\Lib\X12\TransactionSets\Read\X12Read210 construct', 'edi_type: ' . print_r($this->ediType->getAttributes(), true));

      $this->ediOptions = unserialize($this->ediType->edt_edi_object);
      $this->edtBeforeProcessObject = unserialize($this->ediType->edt_before_process_object);
      $this->edtAfterProcessObject = unserialize($this->ediType->edt_after_process_object);
      
      //$this->setupDataSets();
      
      
      \Log::info('');
      \Log::info('class X12Read210 edi_type serialize: ' . serialize($this->ediType));
      
      return 1;
   }
   
   protected function getDetailDataset() : array
   {
      $record = array(
         'TransactionSetIdentifier' => ''

      );
      return $record;
   }
   
   protected function fillMasterDataSet() 
   {
     // $this->dataset
      
      
   }
   
   protected function setupDataSets()
   {
      $this->dataset = $this->getMasterDataset();
      // if you need to add fields to the master dataset, do it here
      //$this->dataset['mynewfield'] = '';
      
      $this->dataset['ediTypeId'] = $this->ediTypeId;
      $this->dataset['InterchangeSenderID'] = $this->ediOptions->interchangeSenderID;
      $this->dataset['InterchangeReceiverID'] = $this->ediOptions->interchangeReceiverID;
      $this->dataset['ApplicationSenderCode'] = $this->ediOptions->applicationSenderCode;
      $this->dataset['ApplicationReceiverCode'] = $this->ediOptions->applicationReceiverCode;
      
      $this->dataset['NumberOfTransactionSetsIncluded'] = 0;
      $this->dataset['NumberOfReceivedTransactionSets'] = 0;
      $this->dataset['NumberOfAcceptedTransactionSets'] = 0;

      //$this->dataset['DetailDataSet'] = $this->getDetailDataset();
      
   }
   
//      $this->ediFile = new EdiFile();
      
      /*
       * We shouldn't need this anymore, as we can now edit the edi_types table
       */
      /*
      $ediTesting = ENV('EDI_TESTING', false);
      if ($ediTesting) {
         // create a default edt_before_process_object_properties if there isn't one
         // for now at least. Shouldn't need this in production
         // UNCOMMENT THE LINE BELOW TO CLEAR THE BEFORE PROCESS OBJECT AND RECREATE IT WITH UPDATED PROPERTIES
         //$this->ediType->edt_before_process_object_properties = '';
         if ($this->ediType->edt_before_process_object_properties == '') {
            LoggingFunctions::logThis('info',6, 'Bgies\EdiLaravel\Lib\X12\TransactionSets\Read\X12Read210 construct', 'edt_before_process_object_properties IS BLANK');
            
            switch($this->ediType->edt_before_process_object) {
               case 1: {    break; }
               
               
               case 8: {
                  $this->edtBeforeProcessObject = new FileDrop();
                  $this->edtBeforeProcessObject->fileDirectory = 'incoming';
                  break;
               }
               case 9: {
                  
                  break;
               }
               case 10: {
                  $this->edtBeforeProcessObject = new FileFromDirectory();
                  $this->edtBeforeProcessObject->directoryName = env('EDI_TOP_DIRECTORY') . '/' . 'W210Replies';
                  
                  break;
               }
               case 11: {
                  $this->edtBeforeProcessObject = new StoredProcedure();
                  $this->edtBeforeProcessObject->directoryName = env('EDI_TOP_DIRECTORY') . '/' . 'W210Replies';
                  $this->edtBeforeProcessObject->storedProcedureName = 'proc_get_210_replies';
                  
               }
               default: {
                  
               }
            }
            $this->ediType->edt_before_process_object = serialize($this->edtBeforeProcessObject);
            $this->ediType->save();
            
         } else {
            $this->edt_before_process_object = serialize($this->ediType->edt_before_process_object);
         }
         
         if ($this->ediType->edt_edi_object == '') {
            \Log::info('class X12Read997 edt_edi_object IS BLANK');
            
            $this->ediOptions = new Read210Options();
            
            $this->ediType->edt_edi_object = serialize($this->ediOptions);
            $this->ediType->save();
         } else {
            $this->ediOptions = unserialize($this->ediType->edt_edi_object);
         }
         
         if ($this->ediType->edt_after_process_object == '') {
            \Log::info('class X12Read210 edt_after_process_object IS BLANK');
            
            $tempProperties = new FileDrop();
            $this->ediType->edt_after_process_object = serialize($tempProperties);
            $this->ediType->save();
         }
         
         
      }  // END if ($ediTesting) 
      */
      
   
   
   
   public function getFile()
   {
     
      
      
   }
   
   public function execute() : ReturnValues
   {
      LoggingFunctions::logThis('info', 4, 'Bgies\EdiLaravel\Lib\X12\TransactionSets\ReadX12Send210 execute', 'Start');
      $this->retValues = new ReturnValues();     
      
      /*
       *  if we already have a file to read, we can skip this 
       *  so we can manually read files 
       */
      if (count($this->fileArray) < 6) {
         if ($this->edtBeforeProcessObject) {
            $retFiles = $this->edtBeforeProcessObject->execute();
         } else {
            $retFiles = $this->getFile($this->ediOptions);
         }
         if (!$retFiles || count($retFiles) == 0) {
            LoggingFunctions::logThis('info', 4, 'Bgies\EdiLaravel\Lib\X12\TransactionSets\ReadX12Send210 execute', 'No Files to Process');
            $this->retValues->addToErrorList('No Files to Process');
            return $this->retValues;
         //throw new EdiFatalException('No File found');
         }
      } else {
         $retFiles[0] = $this->fileArray;
      }
      
      $sharedTypes = new SharedTypes();
      foreach ($retFiles as $curFile) {
         try {
            $filePath = env('EDI_TOP_DIRECTORY') . "/" . $this->ediFile['edf_filename'];

            $fileArray = EdiFileFunctions::ReadX12FileIntoStrings($filePath,
               $this->ediOptions, false, $sharedTypes);
            $this->fileArray = $fileArray;
            $this->curFile = $curFile;
            
            $LineCount = 0;
            
            try {
               $this->checkSenderReceiver($this->fileArray, $this->ediOptions);
            } catch (EdiFatalException $e) {
               \Log::error('Bgies\EdiLaravel\X12 X12Read997 execute checkSenderReceiver aborting... File: ' . $filePath);
               throw($e);
            }
            
         } catch (EdiException $e) {
            \Log::error('Bgies\EdiLaravel\X12 X12Read997 execute EXCEPTION in getData: ' . $e->message);
         } catch (Exception $e) {
            \Log::error('Bgies\EdiLaravel\X12 X12Read997 execute EXCEPTION in getData: ' . $e->message());
         }
         
         try {
            $retVal = EdiFileFunctions::checkFileIntegrity($this->fileArray, $this->ediOptions);
         } catch (EdiFatalException $e) {
            \Log::error('Bgies\EdiLaravel\X12 X12Read997 execute checkSenderReceiver aborting... File: ' . $filePath);
            throw($e);
         }
         
         
         try {
            // we've already read the ISA, GS and ST segments in the
            // ReadX12FileIntoStrings
            $FileLineCount = 2;
            
            $retVal = $this->readFile($this->curFile, $this->fileArray, $this->ediOptions, $FileLineCount, $sharedTypes);
            if (!$retVal) {
               \Log::error('Bgies\EdiLaravel\X12 X12Read997 execute readFile Failed aborting...');
               return false;
            }
         } catch (EdiException $e) {
            \Log::error('Bgies\EdiLaravel\X12 X12Read997 execute EXCEPTION in composeFile: ' . $e->message);
            $this->retValues->addToErrorList('Bgies\EdiLaravel\X12 X12Read997 execute EXCEPTION in composeFile: ' . $e->message);
            return $this->retValues;
         }
         
         try {
            $retVal = $this->dealWithData();
            if (!$retVal) {
               \Log::error('Bgies\EdiLaravel\X12 X12Read997 execute problem in dealWithData');
               $this->retValues->addToErrorList('Bgies\EdiLaravel\X12 X12Read997 execute problem in dealWithData: ' . $e->message);
               return $this->retValues;
            }
            
         } catch (EdiException $e) {
            \Log::error('Bgies\EdiLaravel\X12 X12Read997 execute EXCEPTION in dealWithData: ' . $e->message);
            $this->retValues->addToErrorList('Bgies\EdiLaravel\X12 X12Read997 execute EXCEPTION in dealWithData: ' . $e->message);
            return $this->retValues;
         }
         
      };
      
      \Log::info('Bgies\EdiLaravel\X12 X12Read997 execute END');
//      return print_r($this->dataset, $retVal);    
      
      return $this->retValues;
   }
   
   
   
   protected function readFile($curFile, array $fileArray, EDIReadOptions $EDIObj, int $FileLineCount, SharedTypes $sharedTypes )
   {
      $this->setupDataSets();
      $this->dataset['DataInterchangeControlNumber'] = $EDIObj->GSControlNumber;
      
      $LineCountFile = 1;
      $ediVersion = $EDIObj->ediVersionReleaseCode;
      $SegmentGroupCount = 0;
      $TransactionSetsIncluded = 0;
      
      try {
         do {
            $FileLineCount++;
            $LineCountFile++;
            $segmentType = SegmentFunctions::GetSegmentType($fileArray[$FileLineCount - 1], $EDIObj->delimiters, $sharedTypes);
            $segmentArray = explode($EDIObj->delimiters->ElementDelimiter, $fileArray[$FileLineCount - 1]);
            
            switch ($segmentType) {
               case 'Invalid' : {
                  throw new EdiException('An invalid segment type was encountered in an ST loop. Aborting....');
                  break;
               }
               case 'ISA' : {
                  throw new EdiException('An ISA segment was encountered inside an ST loop. Aborting....');
                  break;
               }
               case 'GS' : {
                  throw new EdiException('A GS segment was encountered inside an ST loop. Aborting....');
                  break;
               }
               case 'ST'  : {
                  try {
                     $SegmentGroupCount = 0;
                     $TransactionSetsIncluded++;
                     $this->dataset['NumberOfTransactionSetsIncluded'] = $TransactionSetsIncluded;
                     
                     $retVals = $this->checkSTSEIntegrity($this->fileArray, $FileLineCount - 1);
                     if (!$retVals->getResult()) {
                        throw new EdiFatalException('ST-SE group is not correct at ' . $FileLineCount . ' ReturnValues result is false');
                     }
                     $detailDataSet = $this->getDetailDataset();
                     SegmentFunctions::ReadSTSegment($segmentArray, $detailDataSet, $EDIObj, $FileLineCount, $sharedTypes);
                     
                  } catch (Exception $e) {
                     throw new EdiFatalException('ST-SE group is not correct at ' . $FileLineCount . ' Exception: ' . $e->getMessage());
                  } 
                  $SegmentGroupCount = 1;
                  
                  $detailDataSet['TransactionSetIdentifier'] = $segmentArray[1];
                  $detailDataSet['TransactionSetControlNumber'] = $segmentArray[2];
            //      $detailDataSet['TransactionSetControlNumber'] = $EDIObj->dataInterchangeControlNumber;
                  $this->dataset['DetailDataSet'][] = $detailDataSet;
                  
                  
                  do {
                     $FileLineCount++;
                     $LineCountFile++;
                     $SegmentGroupCount++;
                     
                     $segmentType = SegmentFunctions::GetSegmentType($fileArray[$FileLineCount - 1], $EDIObj->delimiters, $sharedTypes);
                     $segmentArray = explode($EDIObj->delimiters->ElementDelimiter, $fileArray[$FileLineCount - 1]);
                     
                     switch ($segmentType) {
                        case 'B3' : {
                           try {   
                              $detailCount = count( $this->dataset['DetailDataSet']);
                              \Bgies\EdiLaravel\Lib\X12\SegmentFunctions\Read\SegmentB3::SegmentRead($segmentArray, $EDIObj, $detailDataSet, $ediVersion);
                              $this->dataset['DetailDataSet'][$detailCount - 1] = $detailDataSet;
                           } catch (Exception $e) {
                              LoggingFunctions::logThis('info', 8, 'Bgies\EdiLaravel\Lib\X12\TransactionSets\X12Read210 readFile', 'Exception in B3 segment count : ' . $FileLineCount . ' - ' . $e->getMessage());
                              throw new EdiException('Exception in B3 segment  count : ' . $FileLineCount . ' - ' . $e->getMessage());
                           }
                           break;
                        }
                        // N1 is the start of a location information loop, so deal
                        // with 1 entire inside this case statement. 
                        case 'N1' : {
                           try {
                              $detailCount = count( $this->dataset['DetailDataSet']);
                              
                              if (!array_key_exists('LocationInfo', $detailDataSet)) {
                                 $detailDataSet['LocationInfo'] = []; 
                              }
                              // add a locationInfo dataset. 
                              $detailDataSet['LocationInfo'][] = [];
                              
                              $locationCount = count( $detailDataSet['LocationInfo']);
                              $locationDataSet = $detailDataSet['LocationInfo'][$locationCount - 1];
                              \Bgies\EdiLaravel\Lib\X12\SegmentFunctions\Read\SegmentN1::SegmentRead($segmentArray, $EDIObj, $locationDataSet, $ediVersion);
                              
                              // CHeck the next line to see if's N3 (it should be)
                              if ('N3' == SegmentFunctions::GetSegmentType($fileArray[$FileLineCount], $EDIObj->delimiters, $sharedTypes)) {
                                 $FileLineCount++;
                                 $LineCountFile++;
                                 $SegmentGroupCount++;
                                 
                                 $segmentArray = explode($EDIObj->delimiters->ElementDelimiter, $fileArray[$FileLineCount - 1]);
                                 
                                 \Bgies\EdiLaravel\Lib\X12\SegmentFunctions\Read\SegmentN3::SegmentRead($segmentArray, $EDIObj, $locationDataSet, $ediVersion);
                                 
                                 if ('N4' == SegmentFunctions::GetSegmentType($fileArray[$FileLineCount], $EDIObj->delimiters, $sharedTypes)) {
                                    $FileLineCount++;
                                    $LineCountFile++;
                                    $SegmentGroupCount++;
                                    
                                    $segmentArray = explode($EDIObj->delimiters->ElementDelimiter, $fileArray[$FileLineCount - 1]);
                                    
                                    \Bgies\EdiLaravel\Lib\X12\SegmentFunctions\Read\SegmentN4::SegmentRead($segmentArray, $EDIObj, $locationDataSet, $ediVersion);
                                 }
                              }  
                              
                              $detailDataSet['LocationInfo'][$locationCount - 1] = $locationDataSet; 
                              $this->dataset['DetailDataSet'][$detailCount - 1] = $detailDataSet;
                              
                           } catch (Exception $e) {
                              LoggingFunctions::logThis('info', 8, 'Bgies\EdiLaravel\Lib\X12\TransactionSets\X12Read210 readFile', 'Exception in N1 segment count : ' . $FileLineCount . ' - ' . $e->getMessage());
                              throw new EdiException('A 997 ST segment was not terminated with an SE segment');
                           }
                           
                           break;
                        }
                     
                        case 'N9' : {
                           try {
                              $detailCount = count( $this->dataset['DetailDataSet']);
                              \Bgies\EdiLaravel\Lib\X12\SegmentFunctions\Read\SegmentN9::SegmentRead($segmentArray, $EDIObj, $detailDataSet, $ediVersion);
                              $this->dataset['DetailDataSet'][$detailCount - 1] = $detailDataSet;
                           } catch (Exception $e) {
                              LoggingFunctions::logThis('info', 8, 'Bgies\EdiLaravel\Lib\X12\TransactionSets\X12Read210 readFile', 'Exception in N9 segment count : ' . $FileLineCount . ' - ' . $e->getMessage());
                              throw new EdiException('Exception in N9 segment at Segment File Pos: ' . $FileLineCount);
                           }
                           
                           break;
                        }
                        case 'G62' : {
                           try {
                              $detailCount = count( $this->dataset['DetailDataSet']);
                              \Bgies\EdiLaravel\Lib\X12\SegmentFunctions\Read\SegmentG62::SegmentRead($segmentArray, $EDIObj, $detailDataSet, $ediVersion);
                              $this->dataset['DetailDataSet'][$detailCount - 1] = $detailDataSet;
                           } catch (Exception $e) {
                              LoggingFunctions::logThis('info', 8, 'Bgies\EdiLaravel\Lib\X12\TransactionSets\X12Read210 readFile', 'Exception in g62 segment. Count : ' . $FileLineCount . ' - ' . $e->getMessage());
                              throw new EdiException('Exception in G62 segment at Segment File Pos: ' . $FileLineCount);
                           }
                        
                           break;
                        }
                        // LX segment is the start of an LX loop, so deal with the entire 
                        // loop inside this case statement. 
                        case 'LX' : {
                           try {
                              $detailCount = count( $this->dataset['DetailDataSet']);
                              
                              if (!array_key_exists('Charges', $detailDataSet)) {
                                 $detailDataSet['Charges'] = [];
                              }
                              // add a Charges dataset.
                              $detailDataSet['Charges'][] = [];
                              
                              $chargesCount = count( $detailDataSet['Charges']);
                              $chargesDataSet = $detailDataSet['Charges'][$chargesCount - 1];
                              \Bgies\EdiLaravel\Lib\X12\SegmentFunctions\Read\SegmentLX::SegmentRead($segmentArray, $EDIObj, $chargesDataSet, $ediVersion);
                           } catch (Exception $e) {
                              LoggingFunctions::logThis('info', 8, 'Bgies\EdiLaravel\Lib\X12\TransactionSets\X12Read210 readFile', 'Exception in LX segment. Count : ' . $FileLineCount . ' - ' . $e->getMessage());
                              throw new EdiException('Exception in LX segment at Segment File Pos: ' . $FileLineCount);
                           }
                           
                           $detailDataSet['Charges'][$chargesCount - 1] = $chargesDataSet;
                           $this->dataset['DetailDataSet'][$detailCount - 1] = $detailDataSet;
                           break;
                        }
                        case 'L1' : {
                           try {
                              $chargesCount = count( $detailDataSet['Charges']);
                              $chargesDataSet = $detailDataSet['Charges'][$chargesCount - 1];
                              \Bgies\EdiLaravel\Lib\X12\SegmentFunctions\Read\SegmentL1::SegmentRead($segmentArray, $EDIObj, $chargesDataSet, $ediVersion);
                           } catch (Exception $e) {
                              LoggingFunctions::logThis('info', 8, 'Bgies\EdiLaravel\Lib\X12\TransactionSets\X12Read210 readFile', 'Exception in L1 segment. Count : ' . $FileLineCount . ' - ' . $e->getMessage());
                              throw new EdiException('Exception in L1 segment at Segment File Pos: ' . $FileLineCount);
                           }
                           $detailDataSet['Charges'][$chargesCount - 1] = $chargesDataSet;
                           $this->dataset['DetailDataSet'][$detailCount - 1] = $detailDataSet;
                           break;
                        }
                        
                        case 'L3' : {
                           try {
                              $chargesCount = count( $detailDataSet['Charges']);
                              $chargesDataSet = $detailDataSet['Charges'][$chargesCount - 1];
                              \Bgies\EdiLaravel\Lib\X12\SegmentFunctions\Read\SegmentL3::SegmentRead($segmentArray, $EDIObj, $chargesDataSet, $ediVersion);
                           } catch (Exception $e) {
                              LoggingFunctions::logThis('info', 8, 'Bgies\EdiLaravel\Lib\X12\TransactionSets\X12Read210 readFile', 'Exception in L3 segment. Count : ' . $FileLineCount . ' - ' . $e->getMessage());
                              throw new EdiException('Exception in L3 segment at Segment File Pos: ' . $FileLineCount);
                           }
                           $detailDataSet['Charges'][$chargesCount - 1] = $chargesDataSet;
                           $this->dataset['DetailDataSet'][$detailCount - 1] = $detailDataSet;
                           break;
                        }
                        case 'N7' : {
                           
                           break;
                        }
                        
                        
                        
                        default : {
                        
                           break;
                        }
                     }
                     
                  } while ($segmentType != 'SE' && ($FileLineCount <= count($fileArray)));
                  
                  if ($segmentType != 'SE') {
                     throw new EdiException('An ST segment was not terminated with an SE segment');
                  }

                  SegmentFunctions::ReadSESegment($segmentArray, $EDIObj, $LineCountFile, $SegmentGroupCount);
                  
                  break;
               }
               case 'IEA' : {
                  throw new EdiException('An IEA segment was encountered inside an ST Segment. Line: ' . $FileLineCount . ' Aborting....');
                  break;
               }
               case 'SE'  : {
                  SegmentFunctions::ReadSESegment($segmentArray, $EDIObj, $LineCountFile, $SegmentGroupCount);
                  break;
               }
               
               case 'CN' : {
                  
                  break;
               }
               case 'G62' : {
                  
                  break;
               }
               
               case 'AK1' : {
                  \Bgies\EdiLaravel\Functions\ReadFileFunctions::ReadAK1Line($segmentArray[$FileLineCount - 1], $EDIObj->delimiters, $masterDataset );
                  break;
               }
               case 'AK2' : {
                  $masterDataset['InterchangeSenderID'] = $EDIObj->interchangeSenderID;
                  $masterDataset['InterchangeReceiverID'] = $EDIObj->interchangeReceiverID;
                  $detailDataset = $this->getDetailDataset();
                  
                  $masterDataset['DetailDataSet'][count($masterDataset['DetailDataSet'])] = $detailDataset;
                  
                  ReadFileFunctions::ReadAK2Line($segmentArray[$FileLineCount - 1],
                     $EDIObj->delimiters, $detailDataset);
                  break;
               }
               case 'AK3' : {
                  ReadFileFunctions::ReadAK3Line($segmentArray[$FileLineCount - 1],
                     $EDIObj->delimiters, $detailDataset);
                  break;
               }
               case 'AK4' : {
                  ReadFileFunctions::ReadAK4Line($segmentArray[$FileLineCount - 1],
                     $EDIObj->delimiters, $detailDataset);
                  break;
               }
               case 'AK5' : {
                  ReadFileFunctions::ReadAK5Line($segmentArray[$FileLineCount - 1],
                     $EDIObj->delimiters, $detailDataset);
                  break;
               }
               case 'AK9'  : {
                  ReadFileFunctions::ReadAK9Line($segmentArray[$FileLineCount - 1],
                     $EDIObj->delimiters, $masterDataset);
                  break;
               }
               
               default : {
                  
                  break;
               }
            }
            
            
         } while ($segmentType != 'SE' && ($FileLineCount <= count($fileArray)));
         //         until (lineType = ltSE) or (FileLineCount >= segmentArray.Count);
         
         
         
      } catch (Exception $e) {
         throw($e);
      }
      

      
      return true;
   }
   
   // if Files can be updated, then update them, also need to put in
   protected function dealWithData()
   {
      
      $fullDataSet = $this->dataset;

      foreach ($fullDataSet['DetailDataSet'] as $curDetail ) {
         
         
         
      }
      
      
      
      
      
      
      return true;
   }
   
   
   
   
}
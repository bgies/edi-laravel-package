<?php

namespace Bgies\EdiLaravel\Functions;


use Bgies\EdiLaravel\Lib\X12\SharedTypes;
use Bgies\EdiLaravel\Lib\X12\Options\BaseEdiOptions;
use phpDocumentor\Reflection\Types\Boolean;
use Bgies\EdiLaravel\Lib\X12\SegmentFunctions;
use Carbon\Carbon;

//use lib\x12\SharedTypes;


class EdiFileFunctions //extends BaseController
{
   
   public static function getClientFileName(string $fileFormat, string $SCAC, Carbon $carbonDate) {
      //scac_yyyymmdd_hhnnss.filetype
      $fileName = $fileFormat;
      
      if (strpos($fileFormat, 'scac')) {
         $fileName = str_replace('scac', $SCAC, $fileName);
      }
      if (strpos($fileFormat, 'yyyy')) {
         $year = $carbonDate->year;
         $fileName = str_replace('yyyy', (string) $year, $fileName);
      }
      if (strpos($fileFormat, 'mm')) {
         $month = (string) $carbonDate->month;
         if (strlen($month) == 1) {
            $month = '0' . $month;
         }
         $fileName = str_replace('mm', (string) $month, $fileName);
      }
      if (strpos($fileFormat, 'dd')) {
         $day = (string) $carbonDate->day;
         if (strlen($day) == 1) {
            $day = '0' . $day;
         }
         $fileName = str_replace('dd', (string) $day, $fileName);
      }
      if (strpos($fileFormat, 'hh')) {
         $hour = (string) $carbonDate->hour;
         if (strlen($hour) == 1) {
            $hour = '0' . $hour;
         }
         $fileName = str_replace('hh', (string) $hour, $fileName);
      }
      if (strpos($fileFormat, 'nn')) {
         $minute = (string) $carbonDate->minute;
         if (strlen($minute) == 1) {
            $minute = '0' . $minute;
         }
         $fileName = str_replace('nn', (string) $minute, $fileName);
      }
      if (strpos($fileFormat, 'ss')) {
         $second = (string) $carbonDate->second;
         if (strlen($second) == 1) {
            $second = '0' . $second;
         }
         $fileName = str_replace('ss', (string) $second, $fileName);
      }
      return $fileName;
      
      
      
      
      
   }
   
   public static function getTopDirectory() {
      $topPath = \Storage::disk('edi')->path('');
      $midPath = ENV('EDI_TOP_DIRECTORY', '');
      
      return $topPath . $midPath;
   }
   
   
   public static function getDirectoryDateString() {
      return  substr(\Bgies\EdiLavavel\Functions\DateTimeFunctions::GetDateStr(now(),true), 0, 6);
   }
   
   // NOTE - The short file name is what's stored in the edi_files Table
   public static function getShortFileName($ediTypeName, $EDIID) {
      $DirectoryDateString = FileFunctions::getDirectoryDateString();
      $ShortFileName = $ediTypeName . '/' . $DirectoryDateString . '/' . $EDIID . '.txt';
      return $ShortFileName;
   }
  
   
   public static function getFileName(int $EDIID, string $ediTypeName)
   {
      $TopDirectory = FileFunctions::getTopDirectory();
      
      $FTPFileName = $TopDirectory . '/' . FileFunctions::getShortFileName($ediTypeName, $EDIID) ;

      return $FTPFileName;
   }
   
   //==============================================================================
   public static function GetUniqueControlNumberStr(BaseEdiOptions $EDI, int $Counter) : string
   {
      $NumberStr = '';
      $NumberStr2 = '';
      
      $NumberStr = (string) $EDI->dataInterchangeControlNumber;
      // if the Number is more than UseXDigitsFromControlNumber digits, then only
      // use the last UseXDigitsFromControlNumber digits.
      if (strlen($NumberStr) > $EDI->useXDigitsFromControlNumber) {
         $NumberStr = substr($NumberStr, strlen($NumberStr) - $EDI->useXDigitsFromControlNumber);
      }
      // now make sure it is at least 6 characters
      // took this out for Syncada.... need to make it a property.
      if ($EDI->leftPadControlNumber) {
         $NumberStr = str_pad($NumberStr, $EDI->useXDigitsFromControlNumber, '0', STR_PAD_LEFT);
      }
      
      $NumberStr2 = '';
      if ($EDI->useXDigitsFromControlNumber < 9) {
      
         $NumberStr2 = (string) $Counter;
         $padBy = 9 - $EDI->useXDigitsFromControlNumber;
      
      
         $NumberStr2 = str_pad($NumberStr2, $padBy, '0', STR_PAD_LEFT);
      }
      
/*      
      if (strlen($NumberStr2) < (9 - $EDI->useXDigitsFromControlNumber)) {
         $NumberStr2 = str_pad($NumberStr2, (9 - $EDI->useXDigitsFromControlNumber), '0', STR_PAD_LEFT);
      } else {
         if (strlen($NumberStr2) == (9 - $EDI->useXDigitsFromControlNumber)) {
            $NumberStr2 = substr($NumberStr2, 1, $EDI->useXDigitsFromControlNumber);
         } else { 
            $startPos = strlen($NumberStr2) - 8 + $EDI->useXDigitsFromControlNumber;
            $NumberStr2 = substr($NumberStr2, strlen($NumberStr2) - 8 + $EDI->useXDigitsFromControlNumber, strlen($NumberStr2));
         }
      }
*/   
      // NumberStr is the first part and NumberStr2 is the second part of
      // the TransactionSetControlNumber
      return $NumberStr . $NumberStr2;
   }
   
   
   
   
   
/*   
   //=============================================================================
   function UpdateEDIRecordAfterFileCreate(ADOProcUpdateEDIRecord : TADOStoredProc; EDIID: integer;
   inFileName, edgId, ediSender, ediReceiver : string) : boolean;
   
   begin
   Result := false;
   ADOProcUpdateEDIRecord.Close;
   ADOProcUpdateEDIRecord.Parameters.ParamByName('@edi_id').Value := EDIID;
   ADOProcUpdateEDIRecord.Parameters.ParamByName('@edi_file_name').Value := inFileName;
   ADOProcUpdateEDIRecord.Parameters.ParamByName('@edi_edg_id').Value := edgId;
   ADOProcUpdateEDIRecord.Parameters.ParamByName('@edi_sender_id').Value := ediSender;
   ADOProcUpdateEDIRecord.Parameters.ParamByName('@edi_receiver_id').Value := ediReceiver;
   
   ADOProcUpdateEDIRecord.Open;
   ADOProcUpdateEDIRecord.Close;
   Result := true;
   
   end;
   
   
   //==============================================================================
   function CreateEDIRecord(ADOProcEDIRecord : TADOStoredProc;
   PaymentAgency, Customer, ediState, ControlNumber, RecordsParsed, edtID : integer;
   FileName : string;
   FileTypeId, TestFile, StaffId : integer) : integer;
   begin
   
   ADOProcEDIRecord.Close;
   
   ADOProcEDIRecord.Parameters.ParamByName('@payment_agency').Value := PaymentAgency;
   ADOProcEDIRecord.Parameters.ParamByName('@edi_state').Value := ediState;
   ADOProcEDIRecord.Parameters.ParamByName('@edi_file_name').Value := FileName;
   ADOProcEDIRecord.Parameters.ParamByName('@edi_control_number').Value := ControlNumber;
   ADOProcEDIRecord.Parameters.ParamByName('@edi_records_parsed').Value := RecordsParsed;
   if ADOProcEDIRecord.Parameters.FindParam('@edt_id') <> nil then
   ADOProcEDIRecord.Parameters.ParamByName('@edt_id').Value := FileTypeId;
   
   ADOProcEDIRecord.Parameters.ParamByName('@stf_id').Value := StaffID;
   ADOProcEDIRecord.Parameters.ParamByName('@test_file').Value := TestFile;
   ADOProcEDIRecord.Parameters.ParamByName('@cst_id').Value := TestFile;
   
   ADOProcEDIRecord.Open;
   Result := ADOProcEDIRecord.FieldByName('edi_file_id').AsInteger;
   ADOProcEDIRecord.Close;
   
   end;
*/  
   
   public static function getFileContentsFromShortName($diskName, $shortName) {
      //$TopDirectory = FileFunctions::getTopDirectory();
      
      //$fileName = $TopDirectory . '/' . $shortName;
      $midPath = ENV('EDI_TOP_DIRECTORY', '');
      
      $fileContents = \Storage::disk($diskName)->get($midPath . '/' . $shortName);
      
      

$filePath2 = \Storage::disk($diskName)->path($midPath . '/' . $shortName);
      return $fileContents;
   }
   
   
   public static function ReadX12FileIntoStrings(string $FileName, $EDIObj, $InProgram, SharedTypes $sharedTypes) : array
  {
     $fileArray = array();
     
     if (!\Storage::disk('edi')->exists( $FileName)) {
        throw new \App\Exceptions\EdiFatalException('ReadEDIFileIntoStrings File: ' . $FileName . ' does not exist');
     }
     
     $f = \Storage::disk('edi')->get($FileName);
     
     //$f = file_get_contents ($FileName, false, null);
     if (!$f) {
        throw new \App\Exceptions\EdiException('ReadEDIFileIntoStrings Unable to read file with file_get_contents File: ' . $FileName);
     }
     // This is supposed to be an ANSII X12 file, so the first 3 characters HAVE TO BE ISA
     if (substr($f, 0, 3) != 'ISA') {
        throw new \App\Exceptions\EdiException('ReadEDIFileIntoStrings File is invalid (must start with ISA): ' . $FileName);
     }     
     
     /*
      * $isaSegment = substr($f, 0, 106);
      * the ISA Segment has to compensate for companies that broke the spec
      * and made the date 8 characters instead of the specified 6 characters 
      */
     $isaSegment = substr($f, 0, 108);
     $LineCount = 0;
     SegmentFunctions::ReadISASegment($isaSegment, $LineCount, $EDIObj, $sharedTypes);
     $LineCount++;
//     $f = substr($f, 107);
         
     
     try {
        $fileArray = explode($EDIObj->delimiters->SegmentTerminator, $f);
        $fileCount = count($fileArray);
        // Remove last segment if it's empty
        if ($fileArray[count($fileArray) - 1] == '') {
           array_pop($fileArray);
        }

/*        
        SegmentFunctions::ReadGSSegment($fileArray[1], $EDIObj, $LineCount, $sharedTypes);
        $LineCount++;
        
        SegmentFunctions::ReadSTSegment($fileArray[2], $EDIObj, $LineCount, $sharedTypes);
        $LineCount++;
*/        
        
        $ReadCount = 0;
        $EightyCharFile = false;
        
        
/*        
        While ( strlen($f) > 0) {
           $posSegmentTerminator = strpos($f, $EDIObj->delimiters->SegmentTerminator);
           if ($posSegmentTerminator > 0) {
              $fileArray[] = substr($f, 0, $posSegmentTerminator);
              $f = substr($f, $posSegmentTerminator + 1);
              // also read the GS Segment so we can check the Application Sender and Reciever later. 
              if (count($fileArray) == 2) {
                 SegmentFunctions::ReadGSSegment($fileArray[1], $EDIObj, $InProgram, $LineCount, $sharedTypes);
                 $LineCount++;
              }
              if (count($fileArray) == 3) {
                 SegmentFunctions::ReadSTSegment($fileArray[2], $EDIObj, $InProgram, $LineCount, $sharedTypes);
                 $LineCount++;
              }
              
           } else {
              $f = '';
           }
           $ReadCount++;
        }
*/        
/*           
//            Readln(f, s);
           $SLength = strlenLength($s);
        
           if (($ReadCount == 1) and ($SLength == 80)) {
               $EightyCharFile = true;
           }
        
           if (ord($s[Length($s)]) <> 28) {
              if (($EightyCharFile) and ($SLength == 80)) {
                 $s = substr($s, 0, 80);
              } else {
                 //$s .= chr($1C);
                 $s .= chr(28);
              }
   
              $Str .= $s;
           }
        }
*/           
        
     } finally {
       //CloseFile(f);
     }
     
     return $fileArray;

   }
/*           
     // break into lines
     $StartPos = 1;
     $LineCount = 0;
     For I := 1 to Length(Str) do
              begin
              if Str[I] = chr(28) then
              begin
              TempStr := copy(Str, StartPos, I-StartPos);
              if Length(TempStr) > 0 then
              begin
              Memo.Add(TempStr);
              LineCount := LineCount + 1;
              end;
              StartPos := I + 1;
              end;
              end;
              Memo.Add(copy(Str, StartPos, Length(Str)));
              
              if LineCount = 1 then
              begin
              // first clear the memo to remove the one line we have
              LineCount := 0;
              Memo.Clear;
              // break into lines using ^ as the line break
              StartPos := 1;
              For I := 1 to Length(Str) do
                 begin
                 if Str[I] = chr(94) then
                 begin
                 TempStr := copy(Str, StartPos, I-StartPos);
                 if Length(TempStr) > 0 then
                 begin
                 Memo.Add(TempStr);
                 LineCount := LineCount + 1;
                 end;
                 StartPos := I + 1;
                 end;
                 end;
                 Memo.Add(copy(Str, StartPos, Length(Str)));
                 LineCount := LineCount + 1;
                 end;
                 
                 if LineCount = 1 then
                 begin
                 Memo.Clear;
                 // break into lines using ! as the line break
                 StartPos := 1;
                 For I := 1 to Length(Str) do
                    begin
                    if Str[I] = chr(33) then
                    begin
                    TempStr := copy(Str, StartPos, I-StartPos);
                    if Length(TempStr) > 0 then
                    begin
                    Memo.Add(TempStr);
                    LineCount := LineCount + 1;
                    end;
                    StartPos := I + 1;
                    end;
                    end;
                    Memo.Add(copy(Str, StartPos, Length(Str)));
                    end;
                    
                    if LineCount = 1 then
                    begin
                    Memo.Clear;
                    // break into lines using | as the line break
                    StartPos := 1;
                    For I := 1 to Length(Str) do
                       begin
                       if Str[I] = chr(166) then
                       begin
                       TempStr := copy(Str, StartPos, I-StartPos);
                       if Length(TempStr) > 0 then
                       begin
                       Memo.Add(TempStr);
                       LineCount := LineCount + 1;
                       end;
                       StartPos := I + 1;
                       end;
                       end;
                       Memo.Add(copy(Str, StartPos, Length(Str)));
                       end;
                       
                       
                       if LineCount = 1 then
                       begin
                       Memo.Clear;
                       // Try to find the Segment terminator and
                       // break into lines using that
                       SegmentTerminator := Str[106];
                       // only use these characters to try right now, and make sure they are
                       // not the delimiter.
                       if ((SegmentTerminator in ['~', '*', '\']) and (Pos(SegmentTerminator, Str) > 105)) then
           begin
             StartPos := 1;
                          
             For I := 1 to Length(Str) do
               begin
                 if Str[I] = SegmentTerminator then
                   begin
                     TempStr := copy(Str, StartPos, I-StartPos);
                     if Length(TempStr) > 1 then
                       begin
                         Memo.Add(TempStr);
                         LineCount := LineCount + 1;
                       end;
                     StartPos := I + 1;
                   end;
               end;
             if ((Length(Str) - StartPos) > 1) then
               Memo.Add(copy(Str, StartPos, Length(Str)));
           end;
       end;
                          
     if LineCount = 0 then
       begin
         Memo.Clear;
          // Try to find the Segment terminator and
          // break into lines using that
         SegmentTerminator := Str[106];
         // only use these characters to try right now, and make sure they are
         // not the delimiter.
         if ((SegmentTerminator in ['~', '*']) and (Pos(SegmentTerminator, Str) > 105)) then
           begin
             StartPos := 1;
                          
             For I := 1 to Length(Str) do
               begin
                 if Str[I] = SegmentTerminator then
                   begin
                     TempStr := copy(Str, StartPos, I-StartPos);
                     if Length(TempStr) > 0 then
                       begin
                         Memo.Add(trim(TempStr));
                         LineCount := LineCount + 1;
                       end;
                     StartPos := I + 1;
                   end;
               end;
             Memo.Add(copy(Str, StartPos, Length(Str)));
           end;
       end;
                          
     if LineCount <= 1 then
       begin
         Memo.Clear;
         Memo.LoadFromFile( FileName );
//         LineCount := Memo.Count;
       end;
                          
    Result := true;
   } catch (Exception $e)  {
      throw new EdiException('Exception in ReadEDIFileIntoStrings e->message: ' . $e->getMessage);
   }
     
*/     
     

   

/*
//==============================================================================
procedure RemoveAllSegmentTerminators(var Str : String; SegmentTerminator : char);
begin
  Str := StrRemoveChars(Str, [SegmentTerminator]);
end;


//==============================================================================
Function RemoveSegmentTerminator(Str : string; SegmentTerminator : char) : string;
begin
  if ord(SegmentTerminator) > 1 then
    if Str[Length(Str)] = SegmentTerminator then
      Result := copy(Str, 1, Length(Str) - 1)
    else
      Result := Str;
end;
   
   
   
   
*/   
   
   
   
   
   
   
   
   
}
   
   
<?php

namespace Bgies\EdiLaravel\Functions;


use Bgies\EdiLaravel\lib\x12\options\EDISendOptions;
use Bgies\EdiLaravel\Exceptions\EdiFatalException;
use Illuminate\Support\Facades\Storage;

//use lib\x12\SharedTypes;


class WriteFileToDisk
{
   
   protected static function DeleteExtraCharacters(string &$inStr, string $inChar)
   {
      $StrLength = strlen($InStr);
      if ($StrLength < 1) {
         return;
      }
   
      $CopyToPos = $StrLength;
      do {
         $Found = false;
         if ($inStr[$CopyToPos] == $inChar) {
            $CopyToPos--;
            $Found = true;
         }

      } while ($Found && ($CopyToPos > 0));
   
      $inStr = substr($inStr, 0, $CopyToPos);   
   }
   
   
   
   //WriteEDIFile(EDI.EDIMemo, FileName, ord(EDI.ComponentElementSeparator), EDI.TrimExtraDelimiters, EDI.WriteOneLine, EDI.Delimiter);
   //public static function WriteEDIFile(array $fileArray, string $shortFileName, EDISendOptions $ediOptions)
   public static function WriteEDIFile(array $fileArray, string $shortFileName, $ediOptions)
   {
      $topDirectory = FileFunctions::getTopDirectory();
      $fileNameOnDisk = ENV('EDI_TOP_DIRECTORY') . "/" . $shortFileName;
      if (Storage::disk('edi')->exists($fileNameOnDisk) ) {
         \Log::error('WriteFileToDisk WriteEDIFile File already exists on disk. Aborting.....');
         throw new EdiFatalException('WriteFileToDisk WriteEDIFile File already exists on disk. Aborting.....');
      }
      
      // Make sure the directory exists
      // NOTE - the below is using strRpos, not strpos
      $dirString = substr($fileNameOnDisk, 0, strrpos($fileNameOnDisk, '/') );
      $retVal = Storage::disk('edi')->makeDirectory($dirString);
      
      Storage::disk('edi')->put($fileNameOnDisk, '');
      
      $FullStr = '';
      for ($i = 0; $i < count($ediOptions->ediMemo); $i++) {
         $TempStr = $ediOptions->ediMemo[$i];
         
         if ($ediOptions->trimExtraDelimiters) {
            $this->DeleteExtraCharacters($TempStr, $ediOptions->delimiters);
         }
         
         $TempStr .= $ediOptions->delimiters->SegmentTerminator;
         $ediOptions->ediMemo[$i] = (string) $TempStr;
         
         // if we want to write it as one line then just add to the string and it will be written
         // after the loop, else write the line.
         if ($ediOptions->writeOneLine) {
            $FullStr .= $TempStr;
         } else {
            Storage::disk('edi')->append($fileNameOnDisk, $TempStr);
         }
      }
                      
      if ($ediOptions->writeOneLine) {
         Storage::disk('edi')->put($fileNameOnDisk, $FullStr);
      }

      return true;
   }
   
   
               
      
/*      
      
      TheFilePath := ExtractFilePath(FileName);
      
      if not DirectoryExists(TheFilePath) then
      if not ForceDirectories(TheFilePath) then
      if not CreateDir(TheFilePath) then
      sleep(0);
      
      AssignFile(f, FileName);
      try
      Rewrite(f);
      For I := 0 to List.Count - 1 do
         begin
         TempStr := List[I];
         if DeleteExtraChars then
         DeleteExtraCharacters(TempStr, Delimiter);
         if SegmentEnd <> 0 then
         begin
         TempStr := TempStr + AnsiString(chr(SegmentEnd));
         List[I] := String(TempStr);
         end;
         // if we want to write it as one line then just add to the string and it will be written
         // after the loop, else write the line.
         if WriteOneLine then
         FullStr := FullStr + TempStr
         else
            begin
            Writeln(f, TempStr);
            end;
            
            if I mod 500 = 0 then
            Application.ProcessMessages;
            end;
            if WriteOneLine then
            Write(f, FullStr);
            Result := true;
            
            finally
            CloseFile(f);
            end;
            
            end;
 */           
      
   
   
   
   
}
   


   
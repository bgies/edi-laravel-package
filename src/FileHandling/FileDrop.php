<?php

namespace Bgies\EdiLaravel\FileHandling;

use Bgies\EdiLaravel\Lib\PropertyType;
use Bgies\EdiLaravel\Functions\LoggingFunctions;


/*
 * File Drop is designed to make a copy of an EDI file, and 
 * deposit it in a specific folder. Generally, the location
 * will be a folder designated for an FTP (FTPS, SFTP, or AS2)
 * server which will send all files in that folder to the 
 * appropriate trading partner. 
 * 
 * NOTE - disk (oldDisk, moveFilesToDisk) refers to Laravel's 
 * disk system in the config/filesystems file. 
 * 
 * if you need the copy 
 */

class FileDrop 
{
   public bool $enabled = true;
   public bool $deleteFileAfterMove = false;
   public bool $changeFileName = false;
   public string $moveFilesToDisk = 'edi';
   public string $changeFileNameMask = '';
   
   
   /**
    * Create a new instance.
    *
    * @return void
    */
   public function __construct()
   {
      LoggingFunctions::logThis('info', 3, 'Bgies\EdiLaravel\FileHandling\FileDrop construct', 'Start');
   }
   
   public function execute(string $originalDisk, string $shortFileName, $EdiObj) {
      LoggingFunctions::logThis('info', 4, 'Bgies\EdiLaravel\FileHandling\FileDrop execute', 'Start');
      
      if ($EdiObj->isTestFile && !$EdiObj->testFileOptions->sendTestFile ) {
         return;         
      }
      
      if (! $originalDisk) {
         throw new \Exception("FileDrop originalDisk is Blank");
         return false;
      }
      if (! $shortFileName) {
         throw new \Exception("FileDrop shortFileName is Blank");
         return false;
      }
      
      $retVal = Storage::disk('edi')->makeDirectory($this->shortFileNameOnDisk);
          
      
   }
   
   public function getPropertyTypes() {
      //$propTypes = parent::getPropertyTypes();
      $propTypes['enabled'] = new PropertyType(
         'bool', 0, 1, false, true, null, true, true
         );
      $propTypes['deleteFileAfterMove'] = new PropertyType(
         'bool', 0, 1, false, true, null, true, true
         );
      $propTypes['changeFileName'] = new PropertyType(
         'bool', 0, 1, false, true, null, true, true
         );
      $propTypes['moveFilesToDisk'] = new PropertyType(
         'string', 0, 255, true, false, null, true, true, 'The Laravel Disk File to use (config/filesystems.php'
         );
      $propTypes['changeFileNameMask'] = new PropertyType(
         'string', 0, 255, true, false, null, true, true, 'The File Name to Use'
         );
      
      return $propTypes;
   }
   
   
   
}

/*

unit FileDrop;

interface

uses
Windows, Messages, SysUtils, Classes, Controls;

type

TSetEDITransmissionDateTime = procedure(FileName, EDIType : string;
UpdateOpsDatabase : boolean);


TFileDrop = class(TComponent)
private
{ Private declarations }
FMoveFileList : TStringList;
FDeleteFilesAfterMove : boolean;
FOriginalFileDirectory : string;
FMoveFilesToDirectory : string;

FUpdateOpsDatabase : boolean;
protected
{ Protected declarations }
public
{ Public declarations }
FSetEDITransmissionDateTime : TSetEDITransmissionDateTime;
constructor Create(AOwner: TComponent); override;
destructor Destroy; override;
function MoveFiles : boolean;

published
{ Published declarations }
property MoveFileList : TStringList read FMoveFileList Write FMoveFileList;
property DeleteFilesAfterMove : boolean read FDeleteFilesAfterMove Write FDeleteFilesAfterMove;
property OriginalFileDirectory : String read FOriginalFileDirectory Write FOriginalFileDirectory;
property MoveFilesToDirectory : String read FMoveFilesToDirectory Write FMoveFilesToDirectory;

end;

procedure Register;

implementation



procedure Register;
begin
RegisterComponents('NLM', [TFileDrop]);
end;

{ TFileDrop }
constructor TFileDrop.Create(AOwner: TComponent);
begin
inherited;
FMoveFileList := TStringList.Create;
end;

destructor TFileDrop.Destroy;
begin
FMoveFileList.Clear;
FMoveFileList.Free;
inherited;
end;

//==============================================================================
Function TFileDrop.MoveFiles : boolean;
var
I : integer;
begin
if Not (DirectoryExists(FMoveFilesToDirectory)) then
begin
Result := false;
Exception.Create('The Move Files to Directory does not exist');
end;

For I := 0 to FMoveFileList.Count - 1 do
   begin
   if Length(FMoveFileList[I]) > 0 then
   begin
   if CopyFile(pChar(FMoveFileList[I]), pChar(FMoveFilesToDirectory + '\' + ExtractFileName(FMoveFileList[I])), true) then
            begin
              Result := true;
            end
          else
            begin
              Result := false;
              Exception.Create('Unable to copy file ' + FMoveFileList[I] + ' to ' + FMoveFilesToDirectory + ' directory');
            end;
      
          if FDeleteFilesAfterMove then
            DeleteFile(FMoveFileList[I]);
        end
      else
        begin
          Exception.Create('FileName is blank at position ' + IntToStr(I));
        end;
      
      
    end;
      
end;
      
initialization
  Classes.RegisterClass(TFileDrop);
      
      
end.

*/





<?php

namespace Bgies\EdiLaravel\FileHandling;

use Bgies\EdiLaravel\Lib\PropertyType;


class FileDrop 
{
   public $filePath = '';
   public $fileName = '';
   
   /**
    * Create a new instance.
    *
    * @return void
    */
   public function __construct()
   {
      \Log::info('class FileDrop construct');
      
      //parent::__construct();
      
      \Log::info('class Phpedi construct after parent');
      
   }
   
   public function execute() {
      
      
      
      
      
   }
   
   public function getPropertyTypes() {
      //$propTypes = parent::getPropertyTypes();
      
      $propTypes['filePath'] = new PropertyType(
         'string', 0, 255, true, false, null, true, true, 'File Path to put files in'
         );
      $propTypes['fileName'] = new PropertyType(
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





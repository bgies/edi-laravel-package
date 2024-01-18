<?php

namespace Bgies\Phpedi\lib\x12;


class SharedTypes
{
   public $TransmissionTypes = array('None', 'FileDrop', 'FTP', 'FTPS', 'SFTP', 'AS2', 'HTTP', 'HTTPS');
   
   public $SegmentTypes = array('Invalid', 'ISA', 'GS', 'ST', 'BGN', 'N1', 'N3', 'N4',
      'GE', 'IEA', 'OTI', 'REF', 'DTM', 'AMT', 'TED', 'SE', 'NTE', 'AK1', 'AK2',
      'AK3', 'AK4', 'AK5', 'AK9', 'BPS', 'CUR', 'N2', 'PER', 'LS', 'LE', 'RMT', 'B10',
      'LX', 'MS3', 'L11', 'AT7', 'AT8', 'MS1', 'MS2', 'G61', 'G62', 'K1', 'Man', 'Q7',
      'AT5', 'CD3', 'SPO', 'SDQ', 'BPR', 'TRN', 'ENT', 'RMR', 'IT1', 'BX', 'N9',
      'HL', 'L0', 'NM1', 'ADX', 'H3', 'BSS', 'LIN', 'CTT', 'UIT', 'S5', 'N7', 'M7');
   
   public $EDIFileTypes = array('Unknown', 'Invalid', '204', '210', '213',
      '214', '270', '271', '276', '820',
      '824', '835', '837', '858', '862',
      '864', '997', '999');
   
   public $EDIStandard = array('Unknown', 'X12', 'EDIFACT', 'Custom');
   
   public $EDIFileDirection = array('Unknown', 'Incoming', 'Outgoing');
   
   public $Usage = array('Unknown', 'Mandatory', 'NotUsed', 'Optional', 'Relational', 'Paired',
      'Conditional', 'ListConditional', 'Exclusion');
   
   public $ElementDataType = array('Unknown', 'AlphaNumeric', 'Date', 'DateTime',
      'Decimal', 'Id', 'Numeric', 'String', 'Time');
   
   public $Versions = array('3020', '3040', '4010', '4060', '5010', '6010');
   
   
/*
   public $TransmissionType = (ttNone, ttChrysler214, ttChrysler210, ttChryslerResponse,
         ttCorPayResponse, ttVectorCustomFile, ttVisteon210, ttChrysler214DXCSubmit,
         ttFordPCSF, ttVisteon210ChangingDirectory, ttVisteon210Response, ttJCIShowShipment);

  TSegmentType = (ltInvalid, ltISA, ltGS, ltST, ltBGN, ltN1, ltN3, ltN4, ltGE, ltIEA,
      ltOTI, ltREF, ltDTM, ltAMT, ltTED, ltSE, ltNTE, ltAK1, ltAK2, ltAK3, ltAK4,
      ltAK5, ltAK9, ltBPS, ltCUR, ltN2, ltPER, ltLS, ltLE, ltRMT, ltB10, ltLX,
      ltMS3, ltL11, ltAT7, ltAT8, ltMS1, ltMS2, ltG61, ltG62, ltK1, ltMan, ltQ7,
      ltAT5, ltCD3, ltSPO, ltSDQ, ltBPR, ltTRN, ltENT, ltRMR, ltIT1, ltBX, ltN9,
      ltHL, ltL0, ltNM1, ltADX, ltH3, ltBSS, ltLIN, ltCTT, ltUIT, ltS5, ltN7, ltM7);

  TEDIFileType = (ftUnknown = -1, ftInvalid = 0, ft204 = 204, ft210 = 210, ft213 = 213,
                  ft214 = 214, ft270 = 270, ft271 = 271, ft276 = 276, ft820 = 820,
                  ft824 = 824, ft835 = 835, ft837 = 837, ft858 = 858, ft862 = 862,
                  ft864 = 864, ft997 = 997, ft999 = 999);

  TEDIStandard = (estUnknown = 0, estX12 = 1, estEDIFACT = 2, estCustom = 10);
  TEDIFileDirection = (efdUnknown = 0, efdIncoming = 1, efdOutgoing = 2);

  TUsage = (usgUnknown = 0, usgMandatory, usgNotUsed, usgOptional,usgRelational, usgPaired,
         usgConditional, usgListConditional, usgExclusion);

  TElementDataType = (edtUnknown = 0, edtAlphaNumeric = 1, edtDate = 2, edtDateTime = 3,
      edtDecimal = 4, edtId = 5, edtNumeric = 6, edtString = 7, edtTime = 8);


  TVersions = (veTDCC28 = 180, ve200 = 200, ve204 = 204, ve3020 = 3020,
       ve3040 = 3040, ve4010 = 4010, ve4060 = 4060, ve5010 = 5010);

  Str2 = string[2];

   // Do not change the order of TShipmentStatus. It corresponds to the order in the EDIChryslerNotificationTypes Table.
  TShipmentStatus = (ssUnknown, ssDepartOrigin, ssETA, ssDestinationArrival, ssOriginArrival,
                     ssDryRun, ssGPS, ssFAST, ssFreightArrived, ssAircraftDeparted,
                     ssAircraftArrived, ssFreightOut);

  TEnterIncomingFile = procedure (FileName, CustomerTrackingNumber : string);
  TErrorLogProc = procedure (InProcedure, theProgram, ErrorStr : string; WriteToDatabase : boolean);
  TWriteToFile = procedure (Str : string; ErrorLevel : integer);
  TGetIncomingFileName = function : string;
  TProcedureListProc = procedure (inItem : string);
  TProcessMessagesProc = procedure;
  TSetEDITransmissionDateTime = procedure(FileName, EDIType : string;
                                          UpdateOpsDatabase : boolean);


  TUpdateIncomingFileInDatabase = procedure (EDIID : integer; CustomerTrackingNumber : string);

const FileVersions : array[1..10] of integer = (200, 204, 300, 304, 400, 401, 3020, 3040, 4010, 5010);
      IntegerCharacters = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

      ElementDataTypes : array [0..8] of string = ('edtUnknown', 'edtAlphaNumeric',
         'edtDate', 'edtDateTime', 'edtDecimal', 'edtId', 'edtNumeric', 'edtString',
         'edtTime');

      OneSecond      : real = 0.00001157407407407407407407;
      OneMinute      : real = 0.00069444444444444444444444444444444;
      TenMinutes     : real = 0.0069444444444444444444444444444444;
      FifteenMinutes : real = 0.01041666666666666666666666666;
      TwentyMinutes  : real = 0.013888888888888888888888888888;
      OneHour        : real = 0.041666666666666666666666666666667;
      ThreeHours     : real = 0.125;

      TenMinutesInMilliseconds : int64 = 600000;

      EDIFileServer = 'G:\EDIMagic\EDIFiles\';


//      EdiReadServiceLogFileDirectory = 'E:\EDIFiles\EDIReadService\';

      FTPRequestString : array [0..42] of string =
                    ('ftpNone',         'ftpOpenAsync',     'ftpUserAsync',
                     'ftpPassAsync',     'ftpCwdAsync',      'ftpConnectAsync',
                     'ftpReceiveAsync',  'ftpDirAsync',      'ftpLsAsync',
                     'ftpPortAsync',     'ftpGetAsync',      'ftpDirectoryAsync',
                     'ftpListAsync',     'ftpSystemAsync',   'ftpSystAsync',
                     'ftpQuitAsync',     'ftpAbortXferAsync',
                     'ftpSizeAsync',     'ftpPutAsync',      'ftpAppendAsync',
                     'ftpFileSizeAsync', 'ftpRqAbort',       'ftpMkdAsync',
                     'ftpRmdAsync',      'ftpRenameAsync',   'ftpDeleAsync',
                     'ftpRenAsync',      'ftpRenToAsync',    'ftpRenFromAsync',
                     'ftpDeleteAsync',   'ftpMkdirAsync',    'ftpRmdirAsync',
                     'ftpPwdAsync',      'ftpQuoteAsync',    'ftpCDupAsync',
                     'ftpDoQuoteAsync',  'ftpTransmitAsync', 'ftpTypeSetAsync',
                     'ftpRestAsync',     'ftpRestGetAsync',  'ftpRestartGetAsync',
                     'ftpRestPutAsync',  'ftpRestartPutAsync');

      FTPStateString : array [0..9] of string =
                    ('ftpNotConnected',   'ftpReady',         'ftpInternalReady',
                     'ftpDnsLookup',      'ftpConnected',     'ftpAbort',
                     'ftpInternalAbort',  'ftpWaitingBanner', 'ftpWaitingResponse',
                     'ftpPasvReady');


 cFileNotExist = '%0s : File Does Not Exist';
 cInvalidFileType = 'Invalid File Type';
 DefaultBufSize = 4096;

 */
   
}
 
 
 
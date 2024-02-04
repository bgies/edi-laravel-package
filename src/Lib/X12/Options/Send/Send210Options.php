<?php

namespace Bgies\EdiLaravel\Lib\X12\Options\Send;


use Bgies\EdiLaravel\Lib\X12\Options\Send\EDISendOptions;
use Bgies\EdiLaravel\Lib\X12\Options\Segments\B3Options;
use Bgies\EdiLaravel\Lib\X12\Options\Segments\Seg210Loop0100;
use Bgies\EdiLaravel\Lib\X12\Options\TestOptions\TestFile210;
use Bgies\EdiLaravel\Lib\X12\Options\Segments\Loop0400Options;


class Send210Options extends EDISendOptions
{
   public $DefaultLocationCode = '';
   
   public $UseSeparateGSSegmentForEachCarrier = false;
      
   public $ErrorOnZeroInvoiceAmount = true;
   public $ErrorOnBlankLocationCode = false; 
   public $ErrorOnBlankLocationAddress = true;
   
   public $ConvertInvoiceNumberToUpperCase = false;
   
   public $B3Options = null;
   public $Loop0100Options = null;
  
   public $N9Segments = 'BM:BillOfLading:BOLDate|CN:InvoiceNumber:InvoiceDate'; // NOTE  
   public $Loop0060ConvertValueToUpperCase = false;
   public $Loop0060UseFieldNameAsDescription = false;
   public $Loop0400Options = null;
   
   public $MakeGSTFirstLXLoop = false;
   
   public $RemoveSpaceFromCanadianPostalCode = false;
   
   public $TestFileOptions = null; 
   
   public $UseR3Segment = false;
   public $UseH3Segment = false;
   public $UseK1Segment = false;
   
   
   
   /**
    * Create a new instance.
    *
    * @return void
    */
   public function __construct()
   {
      parent::__construct();
      
      $this->B3Options = new B3Options();
      $this->Loop0100Options = new Seg210Loop0100();
      $this->TestFileOptions = new TestFile210();
      $this->Loop0400Options = new Loop0400Options();
      
   }
   
   
   public function getPropertyTypes() {
      $propTypes = parent::getPropertyTypes();
      
      $propTypes['DefaultLocationCode'] = new PropertyType(
         'string', 0, 30, false, true, null, true, true
         );
      $propTypes['UseSeparateGSSegmentForEachCarrier'] = new PropertyType(
         'bool', 0, 1, false, true, null, true, true
         );
      
      
      return $propTypes;
   }
   
   
/* 
   TEDI210Object = class(TPersistent)
   private
   FDefaultLocationCode : string;
   FEDI210B3Segment : TEDI210B3Segment;
   FEDI210H3Segment : TEDI210H3Segment;
   FEDI210K1Lines : TEDI210K1Lines;
   FEDI210Loop0060 : TEDI210Loop0060;
   FEDI210Loop0100 : TEDI210Loop0100;
   FEDI210Loop0400 : TEDI210Loop0400;
   FEDI210PreProcess : TEDI210PreProcessObject;
   FEDI210TestFile : TEDI210TestFile;
   FErrorOnBlankLocationCode : boolean;
   FErrorOnBlankLocationAddress : boolean;
   FErrorOnBlankInvoiceDate : boolean;
   FErrorOnNegativeInvoiceAmount : boolean;
   FErrorOnZeroInvoiceAmount : boolean;
   FRemoveSpaceFromCanadianPostalCode : boolean;
   FLxLoopSQL : TStringList;
   FMakeGSTFirstLXLoop : boolean;
   FquLoop : TQuery;
   FUseL7InLXLoop : boolean;
   FUseLxLoop0400 : boolean;
   FUseInvoiceItemLxLoop : boolean;
   FUseLoop0100 : boolean;  // NOTE FUseLoop0100 is temporary Remove when Chrysler and Visteon
   //    FSQLLxLoop : String;     // are compatible with the 210Loop0100 object.
   FUseH3Segment : boolean;
   FUseK1Segment : boolean;
   FUseLoop0300 : boolean;
   FUseR3Segment : boolean;
   FUseSeparateGSSegmentForEachCarrier : boolean;
   public
   { Public declarations }
   N9Array : TN9Array;
   ErrorList : TStringList;
   constructor Create(AOwner: TComponent);
   destructor Destroy; override;
   published
   { Published declarations }
   property DefaultLocationCode : string read FDefaultLocationCode Write FDefaultLocationCode;
   property EDI210B3Segment : TEDI210B3Segment read FEDI210B3Segment Write FEDI210B3Segment;
   property EDI210H3Segment : TEDI210H3Segment read FEDI210H3Segment Write FEDI210H3Segment;
   property EDI210K1Lines : TEDI210K1Lines read FEDI210K1Lines Write FEDI210K1Lines;
   property EDI210Loop0060 : TEDI210Loop0060 read FEDI210Loop0060 Write FEDI210Loop0060;
   property EDI210Loop0100 : TEDI210Loop0100 read FEDI210Loop0100 Write FEDI210Loop0100;
   property EDI210Loop0400 : TEDI210Loop0400 read FEDI210Loop0400 Write FEDI210Loop0400;
   property EDI210PreProcess : TEDI210PreProcessObject read FEDI210PreProcess Write FEDI210PreProcess;
   property EDI210TestFile : TEDI210TestFile read FEDI210TestFile Write FEDI210TestFile;
   property ErrorOnBlankInvoiceDate : boolean read FErrorOnBlankInvoiceDate write FErrorOnBlankInvoiceDate default false;
   property ErrorOnBlankLocationCode : boolean read FErrorOnBlankLocationCode write FErrorOnBlankLocationCode default false;
   property ErrorOnBlankLocationAddress : boolean read FErrorOnBlankLocationAddress write FErrorOnBlankLocationAddress default false;
   property ErrorOnNegativeInvoiceAmount : boolean read FErrorOnNegativeInvoiceAmount write FErrorOnNegativeInvoiceAmount default true;
   property ErrorOnZeroInvoiceAmount : boolean read FErrorOnZeroInvoiceAmount write FErrorOnZeroInvoiceAmount default true;
   property LxLoopSQL : TStringList read FLxLoopSQL write FLxLoopSQL;
   property MakeGSTFirstLXLoop : boolean read FMakeGSTFirstLXLoop write FMakeGSTFirstLXLoop default true;
   property RemoveSpaceFromCanadianPostalCode : boolean read FRemoveSpaceFromCanadianPostalCode Write FRemoveSpaceFromCanadianPostalCode default false;
   
   property UseL7InLXLoop : boolean read FUseL7InLXLoop Write FUseL7InLXLoop default true;
   property UseLoop0100 : boolean read FUseLoop0100 Write FUseLoop0100 default false;
   property UseH3Segment : boolean read FUseH3Segment Write FUseH3Segment default false;
   property UseK1Segment : boolean read FUseK1Segment Write FUseK1Segment default false;
   
   property UseLoop0300 : boolean read FUseLoop0300 Write FUseLoop0300 default true;
   //property UseLxLoop : boolean read FUseLxLoop0400 Write FUseLxLoop0400 default false;
   property UseLxLoop0400 : boolean read FUseLxLoop0400 Write FUseLxLoop0400 default false;
   property UseInvoiceItemLxLoop : boolean read FUseInvoiceItemLxLoop Write FUseInvoiceItemLxLoop default false;
   property UseR3Segment : boolean read FUseR3Segment Write FUseR3Segment default true;
   property UseSeparateGSSegmentForEachCarrier : boolean read FUseSeparateGSSegmentForEachCarrier Write FUseSeparateGSSegmentForEachCarrier default false;
   //    property SQLLxLoop : String read FSQLLxLoop write FSQLLxLoop;
   end;
*/   
   
   
   
   
}
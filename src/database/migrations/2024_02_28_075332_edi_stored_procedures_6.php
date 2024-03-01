<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EdiStoredProcedures5 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        \DB::unprepared("
            
        DROP PROCEDURE IF EXISTS proc_test_210;
            
        CREATE PROCEDURE proc_test_210()
        BEGIN

	SELECT 
		10 as id, /* edi_orders.id, */
    10 AS InvoiceId,
		date_add(now(), INTERVAL -7 DAY) as InvoiceDate, 
    731.25 as InvoiceAmount,
    64 AS DetailFieldId,
--    12.55 AS FreightCharge,
		'INV-2035' AS InvoiceNumber,		

		12345 AS CarrierId,
	  'Best Carrier' AS CarrierName,
    IFNULL('BOL-123', '') AS BillOfLading,


	  'SCAC' AS SCAC,
	  'SCAC' AS B3SCAC,
		date_add(now(), INTERVAL -9 DAY) AS B3_12Date,
        
    'USD' AS CurrencyCode,
       
    null AS GST,
		'PP' AS PaymentMethod,


		'2018' AS UnitNumber,
/*		
    (SELECT sum(weight) 
			FROM edi_order_details 
      WHERE edi_order_details.load_id = edi_orders.load_id)
*/			
      1240 AS Weight  , 
 
     'G' AS WeightQualifier ,

		 date_add(now(), INTERVAL -9 DAY) AS B3_06Date,

     
     date_add(now(), INTERVAL -8 DAY) AS ArriveTimeDestination,

     NOW() AS BOLDate, 
     date_add(now(), INTERVAL -9 DAY) AS ShippedOnDate,
     date_add(now(), INTERVAL -8 DAY) AS G62Date,
     '35' AS G62DateQualifier,

		 -- BILL TO IS ALWAYS THE SAME SO HARD CODE IT HERE, OR USE Location id 5. 
		 'BT' AS Loop0100_1_EntityIdentifier,
     'AMG' AS Loop0100_1_LocationCode,
		 'AMAZON GLASS' AS Loop0100_1_Name,
     '1019 Grosspoint' AS Loop0100_1_LocAddress1,
		 'Suite 810' AS Loop0100_1_LocAddress2,
     'Indianpolis' AS Loop0100_1_LocCity,
     'IN' AS Loop0100_1_LocState,
		 'US' AS Loop0100_1_LocCountry,
     '46256' AS Loop0100_1_LocZip,

		 'SH' AS	Loop0100_3_EntityIdentifier,
     'AM2' AS Loop0100_3_LocationCode,
	   'AMAZON 2' AS Loop0100_3_Name,
     '1256 Somewhere Lane' AS Loop0100_3_LocAddress1,
		 'Fantasy City' AS Loop0100_3_LocCity,
		 'FL' AS Loop0100_3_LocState,
		 'US' AS Loop0100_3_LocCountry,
		 '34787' AS Loop0100_3_LocZip,

     'CN' AS Loop0100_2_EntityIdentifier,
     'W12' AS Loop0100_2_LocationCode,
		 'Warehouse 12' AS Loop0100_2_Name,
     '4563 Birch Rd' AS Loop0100_2_LocAddress1,
		 'San Antonio' AS Loop0100_2_LocCity,
		 'TX' AS Loop0100_2_LocState,
		 'US' AS Loop0100_2_LocCountry,
		 '48075' AS Loop0100_2_LocZip


/*
		 'SF' AS	Loop0100_4_EntityIdentifier,
     '' AS Loop0100_4_LocationCode,
     'ARDAGH GLASS PEVELY' AS Loop0100_4_Name,
     '1500 St Gobain' AS Loop0100_4_LocAddress1,
		 'Pevely' AS Loop0100_4_LocCity,
		 'MO' AS Loop0100_4_LocState,
		 '63070' AS Loop0100_4_LocZip,

		 'ST' AS	Loop0100_4_EntityIdentifier,
     '' AS Loop0100_4_LocationCode,
		 'Patton Warehouse - Columbus' AS Loop0100_4_Name,
     '650 Manor Park Dr' AS Loop0100_4_LocAddress1,
		 'Columbus' AS Loop0100_4_LocCity,
		 'OH' AS Loop0100_4_LocState,
		 'US' AS Loop0100_4_LocCountry,
		 '43228' AS Loop0100_4_LocZip

	FROM edi_orders
		JOIN edi_order_locations pickup_location ON pickup_location.id = edi_orders.pickup_location_id
		JOIN edi_order_locations dropoff_location ON dropoff_location.id = edi_orders.drop_location_id
	WHERE 
-- edi_orders.id in (181, 190, 193) 

edi_orders.id >= 327
*/
--    AND edi_orders.amount IS NOT NULL 
--    AND edi_orders.amount > 0.01
/*
		AND ( (SELECT COUNT(*)
						FROM edi_order_details 
						WHERE edi_order_details.load_id = edi_orders.load_id) > 0)
*/

  FROM DUAL
	ORDER BY id ASC
--  LIMIT 1
	;

END

         ");
     
        
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::unprepared("
            DROP PROCEDURE IF EXISTS proc_insert_997_replies;

            DROP PROCEDURE IF EXISTS proc_get_856_to_send;
        ");
    }
}




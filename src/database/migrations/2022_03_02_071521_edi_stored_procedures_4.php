<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EdiStoredProcedures4 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        \DB::unprepared("
            
        DROP PROCEDURE IF EXISTS proc_get_856_to_send;
            
        CREATE PROCEDURE proc_get_856_to_send()
        BEGIN
            
            
    SELECT porders.id AS purchase_order_id,
				porders.*,
        sscc AS BSN_ShipmentIdentification,
				sscc AS MarksAndNumbers,
				NOW() AS BSN_DateTime,
				(SELECT SUM(quantity_sent_to_printer)
              FROM advantage_purchase_order_details
              WHERE advantage_purchase_order_details.purchase_order_id = porders.id) AS order_count,
            
				shipped_datetime AS ShipDate,
				'011' AS ShipDateQualifier,
				DATE_ADD(shipped_datetime, INTERVAL 8 DAY) AS DeliverDate,
				'017' AS DeliverDateQualifier,
            
            
				'TL' AS EquipmentDescriptionCode,
        'B' AS WeightQualifier,
         (SELECT (SUM(book_weight * quantity_sent_to_printer))
						FROM advantage_purchase_order_details
              WHERE advantage_purchase_order_details.purchase_order_id = porders.id) AS Weight,
				'KG' AS WeightUnit,
        'G' AS WeightQualifier,
        'KG' AS WeightMeasurementCode,
            
				'SF' AS SFEntityIdentifierCode,
        'Linemark' AS SFName,
				'92' AS SFIdentificationCodeQualifier,
				'SD902' AS SFIdentificationCode,
            
            
            
				'501 Prince Georges Blvd' AS SFAddress1,
				'' AS SFAddress2,
        'Upper Marlboro' AS SFCityName,
        '' AS SFStateCode,
        '20774' AS SFPostalCode,
        'US' AS SFCountryCode,
            
				'ST' AS STEntityIdentifierCode,
        'Amazon.com Services, Inc.' AS STName,
				'92' AS STIdentificationCodeQualifier,
				warehouse_code AS STIdentificationCode,
            
            
      'CTN' AS ShipmentPackagingCode,
			((SELECT (SUM(book_weight * quantity_sent_to_printer))
						FROM advantage_purchase_order_details
              WHERE advantage_purchase_order_details.purchase_order_id = porders.id) DIV 31) + 1 AS LadingQuantity,
      'Book' AS CommodityCode,
            
      'USPS' AS CarrierScac,
      (SELECT tracking FROM advantage_purchase_order_details
				WHERE advantage_purchase_order_details.purchase_order_id = porders.id
          and tracking IS NOT NULL
        LIMIT 1) as ProNumber,
      'IB' AS ProductIDQualifier,
      transaction_control_number AS TransactionControlNumber
            
            
            
		FROM advantage_purchase_orders porders
            
        WHERE reply_status = 3
			AND shipped_datetime IS NOT NULL
            AND DATE_ADD(shipped_datetime, INTERVAL 1 HOUR) < NOW()
            AND ((SELECT SUM(quantity_sent_to_printer)
              FROM advantage_purchase_order_details
              WHERE advantage_purchase_order_details.purchase_order_id = porders.id) > 0)
            
    ORDER BY porders.id DESC;
            
 END;
            
          ");
        
        
        
        
        \DB::unprepared("
        
        DROP PROCEDURE IF EXISTS proc_insert_997_replies;

CREATE PROCEDURE proc_insert_997_replies(
   IN purchase_order_id INT, 
   IN NumberOfTransactionSetsIncluded INT,
   IN NumberOfReceivedTransactionSets INT,
   IN NumberOfAcceptedTransactionSets INT,
   IN Date DATE 
)
BEGIN

   
    SELECT advantage_purchase_order_details.item AS AssignedIdentification, 
    advantage_purchase_order_details.quantity_ordered AS QuantityOrdered,
    'EA' AS UnitMeasurementCode,
    advantage_purchase_order_details.price AS UnitPrice,
		'NT' AS	UnitPriceCode,
		'IB' AS ProductIDQualifier,
    advantage_purchase_order_details.item AS ProductID,
 
		CASE
			WHEN advantage_purchase_order_details.quantity_ordered != advantage_purchase_order_details.quantity_shipped THEN 'IQ'
			ELSE 'IA'
    END	AS LineItemStatusCode,
    advantage_purchase_order_details.quantity_shipped AS Quantity,
		'068' AS ShipDateQualifier,
		DATE_ADD(NOW(), INTERVAL 2 DAY) AS ShipDate,
		'067'	AS DeliverDateQualifier,
    DATE_ADD(NOW(), INTERVAL 10 DAY) AS DeliverDate,

    advantage_purchase_orders.id, advantage_purchase_order_details.*

	FROM advantage_purchase_orders
  JOIN advantage_purchase_order_details ON advantage_purchase_order_details.purchase_order_id = advantage_purchase_orders.id
  WHERE advantage_purchase_orders.id = purchase_order_id;
-- 		AND reply_status = 0
        
END;

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

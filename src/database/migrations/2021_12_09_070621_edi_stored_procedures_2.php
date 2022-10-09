<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EdiStoredProcedures2 extends Migration
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
    WHERE reply_status = 1
       AND ((SELECT SUM(quantity_sent_to_printer) 
              FROM advantage_purchase_order_details 
              WHERE advantage_purchase_order_details.purchase_order_id = porders.id) > 0)

    ORDER BY porders.id DESC;

 END;              
        
          ");
        
        
        
        \DB::unprepared("
        
        DROP PROCEDURE IF EXISTS proc_get_856_details;

CREATE PROCEDURE proc_get_856_details(
	IN PurchaseOrderId INT
)
BEGIN

   
    SELECT porderdetails.*,
			PurchaseOrderId AS purchase_order_id,
			'shipId' AS ShipmentIdentification,
			DATE_ADD(NOW(), INTERVAL 8 DAY) AS DeliverDate,
			'' AS DeliverDateQualifier,
			item AS ProductID,
			'EA' AS UnitMeasurementCode,
		  quantity_sent_to_printer AS NumberofUnitsShipped
      

		FROM advantage_purchase_order_details porderdetails
    WHERE porderdetails.purchase_order_id = PurchaseOrderId
			AND porderdetails.quantity_sent_to_printer > 0;
        
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
            DROP PROCEDURE IF EXISTS proc_get_856_details;

            DROP PROCEDURE IF EXISTS proc_get_856_to_send;
        ");
    }
}

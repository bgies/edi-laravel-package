<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EdiStoredProcedures3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        
        
        
        \DB::unprepared("
        
        DROP PROCEDURE IF EXISTS proc_get_855_details;

CREATE PROCEDURE proc_get_855_details(
	IN purchase_order_id INT 
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
            DROP PROCEDURE IF EXISTS proc_get_856_details;

        ");
    }
}

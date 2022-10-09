<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EdiStoredProcedures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::unprepared("   
          DROP PROCEDURE IF EXISTS proc_create_edi_record;

          CREATE PROCEDURE proc_create_edi_record(
            IN payment_agency INT,
            IN edi_state INT,
            IN edi_file_name VARCHAR(255),
            IN edi_control_number INT,
            IN edi_records_parsed INT,
            IN edt_id INT,
            IN stf_id INT,
            IN test_file INT,
            IN cst_id INT
            )
            BEGIN
            
            DECLARE edi_file_id INT;
            
            INSERT INTO edi_files(`edi_payment_agency`, `edi_state`, `edi_filename`,
                `edi_transaction_control_number`, `edi_records_parsed`, `edi_edt_id`,
                `edi_file_date`, `edi_stf_id`, `edi_test_file`)
                VALUES(payment_agency, edi_state, edi_file_name,
                    edi_control_number, edi_records_parsed, edt_id,
                    NOW(), stf_id, test_file);
                
                
                SELECT LAST_INSERT_ID() as edi_file_id;
            END;  

           ");                
                


        \DB::unprepared("
            DROP PROCEDURE IF EXISTS proc_get_855_replies;

          CREATE PROCEDURE proc_get_855_replies()
          BEGIN

               SELECT advantage_purchase_orders.id AS purchase_order_id, advantage_purchase_orders.*, advantage_purchase_order_details.*
	       	      FROM advantage_purchase_orders 
                  JOIN advantage_purchase_order_details ON advantage_purchase_order_details.purchase_order_id = advantage_purchase_orders.id
                WHERE reply_status = 0

            	 ORDER BY advantage_purchase_orders.id DESC, advantage_purchase_order_details.id ASC
            LIMIT 100;

            END;
        "); 
        
        

        \DB::unprepared("
            DROP PROCEDURE IF EXISTS proc_get_856_to_send;

            CREATE PROCEDURE proc_get_856_to_send()
            BEGIN

        SELECT porders.id AS purchase_order_id,
        porders.*,
        'ShipmentId' AS BSN_ShipmentIdentification,
        NOW() AS BSN_DateTime,
        (SELECT SUM(quantity_sent_to_printer)
            FROM advantage_purchase_order_details
            WHERE advantage_purchase_order_details.purchase_order_id = porders.id) AS order_count,
            
            NOW() AS ShipDate,
            '011' AS ShipDateQualifier,
            DATE_ADD(NOW(), INTERVAL 8 DAY) AS DeliverDate,
            '017' AS DeliverDateQualifier,
            
            
            'TL' AS EquipmentDescriptionCode,
            'B' AS WeightQualifier,
            23.2 AS Weight,
            'KG' AS WeightUnit,
            
            'SF' AS SFEntityIdentifierCode,
            'Cloud Printer' AS SFName,
            '92' AS SFIdentificationCodeQualifier,
            'AmazonVendorCode' AS SFIdentificationCode,
            
            'ST' AS STEntityIdentifierCode,
            'Amazon Warehouse' AS STName,
            '92' AS STIdentificationCodeQualifier,
            'AmazonVendorCode' AS STIdentificationCode,
            
            'Address1' AS SFAddress1,
            '' AS SFAddress2,
            'CityName' AS SFCityName,
            'StateCode' AS SFStateCode,
            'PostalCode' AS SFPostalCode,
            'US' AS SFCountryCode,
            
            'CTN' AS ShipmentPackagingCode,
            1 AS LadingQuantity,
            'CommodityCode' AS CommodityCode,
            
            3.25 AS Weight,
            'LB' AS WeightQualifier,
            'KG' AS WeightUnit,
            
            'PRO Number' as ProNumber,
            'IB' AS ProductIDQualifier
            
            
            
            FROM advantage_purchase_orders porders
            WHERE porders.id = 589
        
            LIMIT 100;
        END
       ");
          
        
        

        \DB::unprepared("
            DROP PROCEDURE IF EXISTS proc_get_855_details; 

          CREATE PROCEDURE proc_get_855_details(
               IN purchase_order_id INT 
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
            DROP PROCEDURE IF EXISTS proc_get_855_details; 

            DROP PROCEDURE IF EXISTS proc_get_856_to_send;

            DROP PROCEDURE IF EXISTS proc_get_855_replies;

            DROP PROCEDURE IF EXISTS proc_create_edi_record;
        ");

    }

}

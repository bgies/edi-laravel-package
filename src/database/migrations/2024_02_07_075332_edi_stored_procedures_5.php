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
            
DROP PROCEDURE IF EXISTS proc_test_210_detail;
delimiter // 
CREATE PROCEDURE proc_test_210_detail(
	IN invoiceId VARCHAR (255)
)
BEGIN 

	SELECT 
    invoiceId, 
		id AS InvoiceDetailId,
    created_at as InvoiceDetailDate, 
    item_total as ItemTotal,

		item_type AS ItemType,
		item AS Item,

		item_quantity AS Quantity,
    item_unit as Unit,
    item_price as Price,
    item_total as ItemTotal,

		 item AS LadingDescription,

-- IF ( edi_order_details.item_type  = 'Freight', edi_order_details.item_quantity, 0) AS Miles,

		FORMAT( edi_order_details.weight, 0) AS Weight,

		edi_order_details.item_quantity AS Pieces,
		'LB' AS L003Qualifier
    
    FROM edi_order_details

		WHERE edi_order_details.load_id = invoiceId;

    

-- 	FROM DUAL;


--    SELECT(CONCAT(v_date_now,'  ', v_birthdate, '   ', v_calculated_age));


END//
DELIMITER ;
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
            DROP PROCEDURE IF EXISTS proc_test_210_detail;

            
        ");
    }
}




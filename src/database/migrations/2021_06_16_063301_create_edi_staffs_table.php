<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEdiStaffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('edi_staffs', function (Blueprint $table) {
            $table->id();
            $table->string('est_display_name', 50);
            $table->string('est_login_name', 50);
            $table->string('est_password', 100);
            $table->boolean('est_is_admin')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('edi_staffs');
    }
}

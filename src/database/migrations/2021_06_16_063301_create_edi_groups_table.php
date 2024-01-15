<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEdiGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists("edi_groups");
        Schema::create('edi_groups', function (Blueprint $table) {
            $table->id();
            $table->string('edg_group_name', 255)->unique('edi_group_name_index');
            $table->string('edg_description', 255)->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('edi_groups');
    }
}

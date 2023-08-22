<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mv_dtl', function (Blueprint $table) {
            $table->id();
            $table->string('ref_no','100');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('old_storage_location_id');
            $table->string('old_item_type', 50); //good, damage, repair. etc
            $table->double('old_inv_qty', 8, 2)->default(0);
            $table->unsignedInteger('old_inv_uom');
            $table->unsignedInteger('new_storage_location_id');
            $table->string('new_item_type', 50); //good, damage, repair. etc
            $table->double('new_inv_qty', 8, 2)->default(0);
            $table->unsignedInteger('new_inv_uom');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mv_dtl');
    }
};

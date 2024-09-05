<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_order', function (Blueprint $table) {
            $table->increments('oid'); // equivalent to INT(11) NOT NULL AUTO_INCREMENT
            $table->string('order_id', 30); // VARCHAR(30) NOT NULL
            $table->integer('cust_id'); // INT(11) NOT NULL
            $table->string('product_count', 20); // VARCHAR(20) NOT NULL
            $table->float('payment_amount', 10, 2); // FLOAT(10,2) NOT NULL
            $table->float('shipping_charge', 10, 2); // FLOAT(10,2) NOT NULL
            $table->float('cgst', 10, 2); // FLOAT(10,2) NOT NULL
            $table->float('sgst', 10, 2); // FLOAT(10,2) NOT NULL
            $table->float('discount', 10, 2); // FLOAT(10,2) NOT NULL
            $table->string('payment_type', 50); // VARCHAR(50) NOT NULL
            $table->string('payment_status', 50); // VARCHAR(50) NOT NULL
            $table->string('order_status', 50); // VARCHAR(50) NOT NULL
            $table->text('remark')->nullable(); // TEXT NULL DEFAULT NULL
            $table->timestamps(); // This adds `created_at` and `updated_at` columns with current timestamps

            // Set primary key
            $table->primary('oid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_order');
    }
}

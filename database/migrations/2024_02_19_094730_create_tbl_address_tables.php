<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_address', function (Blueprint $table) {
            $table->increments('aid'); // equivalent to INT(11) NOT NULL AUTO_INCREMENT
            $table->integer('cust_id'); // INT(11) NOT NULL
            $table->string('address_one', 100); // VARCHAR(100) NOT NULL
            $table->string('address_two', 100); // VARCHAR(100) NOT NULL
            $table->string('address_three', 100); // VARCHAR(100) NOT NULL
            $table->string('city', 50); // VARCHAR(50) NOT NULL
            $table->string('state', 50); // VARCHAR(50) NOT NULL
            $table->string('pincode', 20); // VARCHAR(20) NOT NULL
            $table->tinyInteger('is_primary')->default(0)->comment('0 No,1 Yes'); // TINYINT NOT NULL DEFAULT '0'
            $table->tinyInteger('is_delete')->default(0)->comment('0 No,1 Yes'); // TINYINT NOT NULL DEFAULT '0'
            $table->timestamps(); // This adds `created_at` and `updated_at` columns with current timestamps

            // Set primary key
            $table->primary('aid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_address');
    }
}

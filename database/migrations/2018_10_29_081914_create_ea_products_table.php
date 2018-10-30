<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEaProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ea_products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ea_id');
            $table->string('ea_name');
            $table->integer('user_id');
            $table->string('parameter');
            $table->timestamps();
        });
        DB::table('ea_products')->insert(
            array(
                'ea_id' => 'qpnUtF89_131843151865849616',
                'ea_name' => 'Swarmtrading EA',
                'user_id'=> 2,
                'parameter' => 'TradeSymbol= {"DEFAULT", "DEFAULT", "DEFAULT", "DEFAULT", "DEFAULT", "DEFAULT"};',
            )
        );
        DB::table('ea_products')->insert(
            array(
                'ea_id' => '121212_131843151865849616',
                'ea_name' => '12121Swarmtrading EA',
                'user_id'=> 3,
                'parameter' => '12121TradeSymbol= {"DEFAULT", "DEFAULT", "DEFAULT", "DEFAULT", "DEFAULT", "DEFAULT"};',
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ea_products');
    }
}

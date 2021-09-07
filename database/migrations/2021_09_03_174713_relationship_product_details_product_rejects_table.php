<?php

/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2021-09-03 17:47:13
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RelationshipProductDetailsProductRejectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_rejects', function (Blueprint $table) {
            $table->unsignedBigInteger('product_detail_id')->nullable()->after('id');

            // $table->index('product_detail_id');
            // $table->foreign('product_detail_id')
            //     ->references('id')->on('product_details')
            //    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_rejects', function (Blueprint $table) {
            $table->dropColumn('product_detail_id');
            // $table->dropForeign('product_detail_id');
        });
    }
}

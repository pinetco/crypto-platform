<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTokenCombinationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('token_combinations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('protocol_id');
            $table->foreignId('pair_type_id');
            $table->foreignId('from_token_id');
            $table->foreignId('to_token_id')->nullable();
            $table->double('apy')->default(0);
            $table->double('apr')->default(0);
            $table->double('tvl')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('token_combinations');
    }
}

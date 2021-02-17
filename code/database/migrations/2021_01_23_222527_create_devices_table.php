<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('application_id');
            $table->unsignedBigInteger('user_id');
            $table->string('language', 6);
            $table->string('os', 9);
            $table->string('client_token');
            $table->tinyInteger('subscription_status')->default(\App\Models\Device::PENDING_STATUS); // 0
            $table->dateTime('expire_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'application_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('devices');
    }
}

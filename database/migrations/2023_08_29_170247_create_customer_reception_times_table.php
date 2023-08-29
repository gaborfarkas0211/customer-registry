<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customer_reception_times', function (Blueprint $table) {
            $table->id();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('type');
            $table->integer('day');
            $table->time('start_time');
            $table->time('end_time');
            $table->timestamps();

            $table->unique(['start_date', 'type', 'day', 'start_time', 'end_time'], 'customer_reception_times_datetime_day_type_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_reception_times');
    }
};

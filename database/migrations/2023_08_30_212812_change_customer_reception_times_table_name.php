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
        Schema::rename('customer_reception_times', 'reception_times');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('reception_times', 'customer_reception_times');
    }
};

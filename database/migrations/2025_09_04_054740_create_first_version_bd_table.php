<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Должности
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); 
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // 2. Категории комфорта
        Schema::create('comfort_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->integer('level')->unique();
            $table->timestamps();
        });

        // 3. Связь должностей и категорий
        Schema::create('position_comfort_category', function (Blueprint $table) {
            $table->foreignId('position_id')->constrained()->onDelete('cascade');
            $table->foreignId('comfort_category_id')->constrained()->onDelete('cascade');
            $table->primary(['position_id', 'comfort_category_id']);
        });

        // 4. Страны
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 3)->unique();
            $table->timestamps();
        });

        // 5. Цвета
        Schema::create('colors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('hex_code')->nullable();
            $table->timestamps();
        });

        // 6. Бренды автомобилей
        Schema::create('car_brands', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // 7. Модели автомобилей
        Schema::create('car_models', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained('car_brands');
            $table->string('name');
            $table->timestamps();
        });

        // 8. Сотрудники (ДОЛЖНА БЫТЬ ПОСЛЕ positions)
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('patronymic')->nullable();
            $table->string('phone')->nullable();
            $table->foreignId('position_id')->constrained();
            $table->timestamps();
        });

        // 9. Водители (ДОЛЖНА БЫТЬ ПОСЛЕ employees)
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->unique()->constrained()->onDelete('cascade');
            $table->string('license_number')->unique();
            $table->string('license_category');
            $table->date('license_expiry_date');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 10. Автомобили (ДОЛЖНА БЫТЬ ПОСЛЕ ВСЕХ зависимых таблиц)
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('model_id')->constrained('car_models');
            $table->foreignId('color_id')->constrained();
            $table->foreignId('comfort_category_id')->constrained();
            $table->foreignId('driver_id')->constrained();
            
            // Номерной знак
            $table->string('license_plate')->unique();
            $table->string('vin_code')->unique()->nullable();
            
            $table->integer('year');
            $table->integer('mileage')->default(0);
            $table->boolean('is_active')->default(true);
            $table->text('features')->nullable();
            $table->timestamps();
        });

        // 11. Бронирования (ПОСЛЕДНЯЯ - зависит от всех)
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained(); 
            $table->foreignId('car_id')->constrained();
            $table->datetime('start_time');
            $table->datetime('end_time');
            $table->text('purpose');
            $table->string('destination')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed', 'cancelled'])->default('pending');
            $table->timestamps();
            
            $table->index(['car_id', 'start_time', 'end_time']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Важно удалять в ОБРАТНОМ порядке из-за внешних ключей!
        Schema::dropIfExists('bookings');
        Schema::dropIfExists('cars');
        Schema::dropIfExists('drivers');
        Schema::dropIfExists('employees');
        Schema::dropIfExists('car_models');
        Schema::dropIfExists('car_brands');
        Schema::dropIfExists('colors');
        Schema::dropIfExists('position_comfort_category');
        Schema::dropIfExists('comfort_categories');
        Schema::dropIfExists('positions');
        Schema::dropIfExists('countries');
    }
};
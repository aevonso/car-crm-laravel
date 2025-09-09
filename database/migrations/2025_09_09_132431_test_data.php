<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Добавляем страны
        DB::table('countries')->insert([
            ['name' => 'Россия', 'code' => 'RU'],
            ['name' => 'Германия', 'code' => 'DE'],
            ['name' => 'Япония', 'code' => 'JP'],
            ['name' => 'США', 'code' => 'US'],
        ]);

        // 2. Добавляем бренды автомобилей
        DB::table('car_brands')->insert([
            ['name' => 'Toyota'],
            ['name' => 'BMW'],
            ['name' => 'Mercedes-Benz'],
            ['name' => 'Honda'],
            ['name' => 'Audi'],
        ]);

        // 3. Добавляем модели автомобилей
        DB::table('car_models')->insert([
            ['brand_id' => 1, 'name' => 'Camry'],
            ['brand_id' => 1, 'name' => 'Corolla'],
            ['brand_id' => 1, 'name' => 'RAV4'],
            ['brand_id' => 2, 'name' => 'X5'],
            ['brand_id' => 2, 'name' => '3 Series'],
            ['brand_id' => 3, 'name' => 'E-Class'],
            ['brand_id' => 3, 'name' => 'S-Class'],
            ['brand_id' => 4, 'name' => 'Civic'],
            ['brand_id' => 4, 'name' => 'Accord'],
            ['brand_id' => 5, 'name' => 'A6'],
        ]);

        // 4. Добавляем цвета
        DB::table('colors')->insert([
            ['name' => 'Черный', 'hex_code' => '#000000'],
            ['name' => 'Белый', 'hex_code' => '#FFFFFF'],
            ['name' => 'Серый', 'hex_code' => '#808080'],
            ['name' => 'Красный', 'hex_code' => '#FF0000'],
            ['name' => 'Синий', 'hex_code' => '#0000FF'],
            ['name' => 'Зеленый', 'hex_code' => '#008000'],
        ]);

        // 5. Добавляем категории комфорта
        DB::table('comfort_categories')->insert([
            ['name' => 'Эконом', 'level' => 'C'],
            ['name' => 'Стандарт', 'level' => 'B'],
            ['name' => 'Комфорт', 'level' => 'A'],
            ['name' => 'Бизнес', 'level' => 'A+'],
            ['name' => 'Премиум', 'level' => 'S'],
        ]);

        // 6. Добавляем должности
        DB::table('positions')->insert([
            ['name' => 'Менеджер', 'description' => 'Руководящая должность'],
            ['name' => 'Разработчик', 'description' => 'IT специалист'],
            ['name' => 'Аналитик', 'description' => 'Бизнес-аналитик'],
            ['name' => 'Директор', 'description' => 'Высшее руководство'],
            ['name' => 'Бухгалтер', 'description' => 'Финансовый отдел'],
        ]);

        // 7. Связь должностей с категориями комфорта
        DB::table('position_comfort_category')->insert([
            ['position_id' => 1, 'comfort_category_id' => 3], // Менеджер - Комфорт
            ['position_id' => 2, 'comfort_category_id' => 2], // Разработчик - Стандарт
            ['position_id' => 3, 'comfort_category_id' => 3], // Аналитик - Комфорт
            ['position_id' => 4, 'comfort_category_id' => 4], // Директор - Бизнес
            ['position_id' => 5, 'comfort_category_id' => 2], // Бухгалтер - Стандарт
        ]);

        // 8. Добавляем пользователей
        $users = [
            [
                'name' => 'Иван Иванов',
                'email' => 'ivanov@example.com',
                'password' => Hash::make('password123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Петр Петров',
                'email' => 'petrov@example.com',
                'password' => Hash::make('password123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Мария Сидорова',
                'email' => 'sidorova@example.com',
                'password' => Hash::make('password123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Алексей Козлов',
                'email' => 'kozlov@example.com',
                'password' => Hash::make('password123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Елена Новикова',
                'email' => 'novikova@example.com',
                'password' => Hash::make('password123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('users')->insert($users);

        // 9. Добавляем сотрудников
        DB::table('employees')->insert([
            [
                'user_id' => 1,
                'first_name' => 'Иван',
                'last_name' => 'Иванов',
                'patronymic' => 'Иванович',
                'phone' => '+79161234567',
                'position_id' => 4, // Директор
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'first_name' => 'Петр',
                'last_name' => 'Петров',
                'patronymic' => 'Петрович',
                'phone' => '+79161234568',
                'position_id' => 1, // Менеджер
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3,
                'first_name' => 'Мария',
                'last_name' => 'Сидорова',
                'patronymic' => 'Ивановна',
                'phone' => '+79161234569',
                'position_id' => 2, // Разработчик
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 4,
                'first_name' => 'Алексей',
                'last_name' => 'Козлов',
                'patronymic' => 'Сергеевич',
                'phone' => '+79161234570',
                'position_id' => 3, // Аналитик
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 5,
                'first_name' => 'Елена',
                'last_name' => 'Новикова',
                'patronymic' => 'Александровна',
                'phone' => '+79161234571',
                'position_id' => 5, // Бухгалтер
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // 10. Добавляем водителей
        DB::table('drivers')->insert([
            [
                'employee_id' => 1,
                'license_number' => 'АВ123456',
                'license_category' => 'B, C',
                'license_expiry_date' => '2025-12-31',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'employee_id' => 2,
                'license_number' => 'ВС654321',
                'license_category' => 'B',
                'license_expiry_date' => '2024-10-15',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'employee_id' => 3,
                'license_number' => 'СD789012',
                'license_category' => 'B, D',
                'license_expiry_date' => '2026-05-20',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // 11. Добавляем автомобили
        DB::table('cars')->insert([
            [
                'model_id' => 1, // Toyota Camry
                'color_id' => 1, // Черный
                'comfort_category_id' => 4, // Бизнес
                'driver_id' => 1, // Иван Иванов
                'license_plate' => 'А001АА777',
                'vin_code' => 'JTDBR32E160000001',
                'year' => 2023,
                'mileage' => 15000,
                'is_active' => true,
                'features' => json_encode(['кондиционер', 'подогрев сидений', 'навигация']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'model_id' => 4, // BMW X5
                'color_id' => 2, // Белый
                'comfort_category_id' => 5, // Премиум
                'driver_id' => 2, // Петр Петров
                'license_plate' => 'В002ВВ777',
                'vin_code' => 'WBAFR7C50BC000002',
                'year' => 2022,
                'mileage' => 25000,
                'is_active' => true,
                'features' => json_encode(['кондиционер', 'кожаный салон', 'панорамная крыша']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'model_id' => 6, // Mercedes E-Class
                'color_id' => 3, // Серый
                'comfort_category_id' => 3, // Комфорт
                'driver_id' => 3, // Мария Сидорова
                'license_plate' => 'С003СС777',
                'vin_code' => 'WDD2130421A000003',
                'year' => 2021,
                'mileage' => 35000,
                'is_active' => true,
                'features' => json_encode(['кондиционер', 'круиз-контроль']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // 12. Добавляем бронирования
        DB::table('bookings')->insert([
            [
                'employee_id' => 3, // Мария Сидорова
                'car_id' => 1, // Toyota Camry
                'start_time' => now()->subDays(2),
                'end_time' => now()->addDays(1),
                'purpose' => 'Деловая поездка к клиенту',
                'destination' => 'Москва, ул. Тверская, 15',
                'status' => 'approved',
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(2),
            ],
            [
                'employee_id' => 4, // Алексей Козлов
                'car_id' => 2, // BMW X5
                'start_time' => now()->addDays(1),
                'end_time' => now()->addDays(3),
                'purpose' => 'Участие в конференции',
                'destination' => 'Санкт-Петербург, Экспофорум',
                'status' => 'pending',
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subDays(1),
            ],
            [
                'employee_id' => 5, // Елена Новикова
                'car_id' => 3, // Mercedes E-Class
                'start_time' => now()->subDays(5),
                'end_time' => now()->subDays(3),
                'purpose' => 'Посещение банка',
                'destination' => 'Москва, Центральный банк',
                'status' => 'completed',
                'created_at' => now()->subDays(6),
                'updated_at' => now()->subDays(3),
            ],
        ]);
    }

    public function down(): void
    {
        // Очищаем все таблицы в обратном порядке
        DB::table('bookings')->delete();
        DB::table('cars')->delete();
        DB::table('drivers')->delete();
        DB::table('employees')->delete();
        DB::table('users')->delete();
        DB::table('position_comfort_category')->delete();
        DB::table('positions')->delete();
        DB::table('comfort_categories')->delete();
        DB::table('colors')->delete();
        DB::table('car_models')->delete();
        DB::table('car_brands')->delete();
        DB::table('countries')->delete();
    }
};
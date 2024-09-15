<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        User::query()->create([
                'name' => 'saeed',
                'lastname' => 'sarailoo',
                'level' => 'manager',
                'department' => 'Management',
                'branch' => 'tehran',
                'sector' => 'management',
                'email' => 's.sarailoo@tie-co.com',
                'password' => Hash::make('123456')
            ]);

        User::query()->create([
            'name' => 'Ali',
            'lastname' => 'Hassani SokhtehSaraei',
            'level' => 'manager',
            'department' => 'Management',
            'branch' => 'tehran',
            'sector' => 'management',
            'email' => 'sysadmin@tie-co.com',
            'password' => Hash::make('Aa123456')
        ]);

        User::query()->create([
            'name' => 'Management',
            'lastname' => 'Masaralkhbara',
            'level' => 'manager',
            'department' => 'Management',
            'branch' => 'Baghdad',
            'sector' => 'management',
            'email' => 'manager@masaralkhbara.com',
            'password' => Hash::make('Aa123456')
        ]);

        User::query()->create([
            'name' => 'Financial',
            'lastname' => 'Manager',
            'level' => 'manager',
            'department' => 'financial',
            'branch' => 'Baghdad',
            'sector' => 'management',
            'email' => 'financial@masaralkhbara.com',
            'password' => Hash::make('Aa123456')
        ]);

        User::query()->create([
            'name' => 'technical',
            'lastname' => 'Manager',
            'level' => 'manager',
            'department' => 'technical',
            'branch' => 'Baghdad',
            'sector' => 'management',
            'email' => 'technical@masaralkhbara.com',
            'password' => Hash::make('Aa123456')
        ]);
        User::query()->create([
            'name' => 'Iran',
            'lastname' => 'Branch',
            'level' => 'expert',
            'department' => 'branch',
            'branch' => 'Iran',
            'sector' => 'branch',
            'email' => 'iran-expert@masaralkhbara.com',
            'password' => Hash::make('Aa123456')
        ]);
        User::query()->create([
            'name' => 'Iran',
            'lastname' => 'Branch',
            'level' => 'manager',
            'department' => 'branch',
            'branch' => 'Iran',
            'sector' => 'management',
            'email' => 'iran-manager@masaralkhbara.com',
            'password' => Hash::make('Aa123456')
        ]);
        User::query()->create([
            'name' => 'Safwan',
            'lastname' => 'Lab',
            'level' => 'expert',
            'department' => 'laboratory',
            'branch' => 'Safwan',
            'sector' => 'management',
            'email' => 'safwan@masaralkhbara.com',
            'password' => Hash::make('Aa123456')
        ]);
        User::query()->create([
            'name' => 'COSQC',
            'lastname' => 'USER',
            'level' => 'expert',
            'department' => 'cosqc',
            'branch' => 'cosqc',
            'sector' => 'cosqc',
            'email' => 'cosqc@masaralkhbara.com',
            'password' => Hash::make('Aa123456')
        ]);
        User::query()->create([
            'name' => 'Zurbatiyah',
            'lastname' => 'Border',
            'level' => 'expert',
            'department' => 'border',
            'branch' => 'Zurbatiyah',
            'sector' => 'border',
            'email' => 'zurbatiyah@masaralkhbara.com',
            'password' => Hash::make('Aa123456')
        ]);
        User::query()->create([
            'name' => 'Zurbatiyah',
            'lastname' => 'Customs',
            'level' => 'expert',
            'department' => 'customs',
            'branch' => 'Zurbatiyah',
            'sector' => 'customs',
            'email' => 'customs@masaralkhbara.com',
            'password' => Hash::make('Aa123456')
        ]);
        $this->call([
            LabFeeSeeder::class
        ]);
    }
}

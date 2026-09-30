<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class employeesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    $faker=\Faker\Factory::create();

    for($i=1; $i<=40; $i++){

    Employee::create([
    'first_name'=>$faker->firstName,
    'last_name'=>$faker->lastName,
    'email'=>$faker->unique()->safeEmail(),
    'phoneno'=>$faker->phoneNumber,
    'gender'=>$faker->randomElement([
     'Male',
     'Female'
    ]),
    'hire_date'=>$faker->date,
    'department'=>$faker->randomElement([
      'Accounts',
      'ICT',
      'Operations',
      'Human Resource'
    ]),
    
    'salary'=>$faker->numberBetween(50000, 100000)

    ]);

    }
    }
}

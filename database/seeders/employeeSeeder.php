<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class employeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
    $faker=\Faker\Factory::create();//create a faker object

    for($i=1;$i<=100; $i++){
      Employee::create([
       'first_name'=>$faker->firstName,
       'last_name'=>$faker->lastName,
       'email'=>$faker->unique()->safeEmail(),
       'phoneno'=>$faker->phoneNumber,

       'gender'=>$faker->randomElement([
        'male',
        'female'
       ]),
     'hire_date'=>$faker->date,

     'department'=>$faker->randomElement([
        'Operations',
        'Hr',
        'ICT',
        'Accounts'
       ]),

     'salary'=>$faker->numberBetween(50000, 100000)
      ]);
    }
    }
}

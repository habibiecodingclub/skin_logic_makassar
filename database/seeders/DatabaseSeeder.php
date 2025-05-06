<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Order;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password'=> Hash::make("admin")
        ]);
        Customer::factory()->create([
            'Customer_Name' => "Khumaedi",
            "Phone_Number" => "085231312535",
            "Email" => "meliodas00012@gmail.com",
            "Occupation" => "Mahasiswa",
            "Date_of_Birth" => "2005-03-02"
        ]);
    }
}

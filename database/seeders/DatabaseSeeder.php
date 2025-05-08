<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
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

        // User Seeder

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password'=> Hash::make("admin")
        ]);

        // Customer Seeder
        Customer::factory()->create([
            'Customer_Name' => "Khumaedi",
            "Phone_Number" => "085231312535",
            "Email" => "meliodas00012@gmail.com",
            "Occupation" => "Mahasiswa",
            "Date_of_Birth" => "2005-03-02"
        ]);
        // Product::factory()->create(
        // [
        //    "Product_Name" => "Brightening",
        //    "Product_Category" => "Paket",
        //    "Product_Price" => "123",
        //    "SKU-Number" => "123",
        //    "Description" => "wla"
        // ],

        // Brightening Seeder
    Product::factory()
    ->count(5)
    ->state(new Sequence(
        ['Product_Name' => 'Toner', 'SKU-Number' => '123'],
        ['Product_Name' => 'Facial Wash', 'SKU-Number' => '124'],
        ['Product_Name' => 'Retinol C', 'SKU-Number' => '125'],
        ['Product_Name' => 'Peach Glow', 'SKU-Number' => '126'],
        ['Product_Name' => 'Snow White', 'SKU-Number' => '127'],
    ))
    ->create([
        "Product_Category" => "Brightening",
        "Product_Price" => "123",
        "Description" => "wla"
    ]);


    // Paket Seeder
    Product::factory()->count(2)->state(new Sequence(
        ['Product_Name' => 'Brightening', 'SKU-Number' => '128'],
        ['Product_Name' => 'Acne', 'SKU-Number' => '129'],
    ))->create([
        "Product_Category" => "Paket",
        "Product_Price" => "123",
        "Description" => "wla"
    ]);


    // Lainnya Seeder
    Product::factory()->create([
        "Product_Name" => "DNA Salmon",
        "Product_Category" => "Lainnya",
        "SKU-Number" => "130",
        "Product_Price" => "123",
        "Description" => "wla"
    ]);
    Product::factory()->create([
        "Product_Name" => "Botox",
        "Product_Category" => "Lainnya",
        "SKU-Number" => "131",
        "Product_Price" => "123",
        "Description" => "wla"
    ]);
    Product::factory()->create([
        "Product_Name" => "Masker MPO",
        "Product_Category" => "Lainnya",
        "SKU-Number" => "132",
        "Product_Price" => "123",
        "Description" => "wla"
    ]);
    Product::factory()->create([
        "Product_Name" => "Glutanex",
        "Product_Category" => "Lainnya",
        "SKU-Number" => "133",
        "Product_Price" => "123",
        "Description" => "wla"
    ]);

    Product::factory()->count(2)->state(new Sequence(
        ['Product_Name' => 'Cream C', 'SKU-Number' => '135'],
        ['Product_Name' => 'Cream H', 'SKU-Number' => '134'],
    ))->create([
        "Product_Category" => "Racikan",
        "Product_Price" => "123",
        "Description" => "wla"
    ]);

}


}

<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    //public function run(): void
    public function run()
    {
        //
        DB::table('products')->insert([
            'name'=>"Aretes simpatía",
            'description'=>"Aretes con cara y una sonrisa",
            'price'=>8000
        ]);
        DB::table('products')->insert([
            'name'=>"Anillo gratitud",
            'description'=>"Anillo en plata con incrustaciones de berilio",
            'price'=>15000
        ]);
        DB::table('products')->insert([
            'name'=>"Cadena Aurora boreal",
            'description'=>"Cadena de oro con piedras amatista",
            'price'=>18000
        ]);
    }
}

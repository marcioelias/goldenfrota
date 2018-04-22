<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* $this->call(UsersTableSeeder::class);
        $this->call(UnidadesTableSeeder::class);
        $this->call(TipoPessoasTableSeeder::class); */
        $this->call(UfsTableSeeder::class);
    }
}

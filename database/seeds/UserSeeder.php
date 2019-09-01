<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'numero_identificacao' => NULL,
            'tipo_documento' => NULL,
            'name' => 'Administrador',
            'username' => 1234567,
            'roleDB' => 'admin',
            'role' => 'Administrador',
            'unidade_organica' => 'ESTG',
            'password' => bcrypt('root'),
            'email' => 'admin@mail.pt',
            'blocked' => 0,
            'deleted_at' => NULL,
            'remember_token' => NULL,
        ]);
    }
}

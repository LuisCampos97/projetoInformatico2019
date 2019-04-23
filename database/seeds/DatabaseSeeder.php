<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET foreign_key_checks=0"); //Sera preciso??

        DB::table('proposta_proponente_professor')->delete();
        DB::table('proposta_proponente_assistente')->delete();
        DB::table('proposta_proponente_monitor')->delete();
        DB::table('unidade_curricular')->delete();
        DB::table('proposta_proponente')->delete();
        DB::table('departamento')->delete();
        DB::table('proposta_diretor_uo')->delete();
        DB::table('proposta_ctc')->delete();
        DB::table('proposta_secretariado_direcao')->delete();
        DB::table('proposta_recursos_humanos')->delete();
        DB::table('proposta')->delete();
        DB::table('user')->delete();


        DB::statement('ALTER TABLE user AUTO_INCREMENT = 0');
        DB::statement('ALTER TABLE proposta_proponente_professor AUTO_INCREMENT = 0');
        DB::statement('ALTER TABLE proposta_proponente_assistente AUTO_INCREMENT = 0');
        DB::statement('ALTER TABLE proposta_proponente_monitor AUTO_INCREMENT = 0');
        DB::statement('ALTER TABLE departamento AUTO_INCREMENT = 0');
        DB::statement('ALTER TABLE unidade_curricular AUTO_INCREMENT = 0');
        DB::statement('ALTER TABLE proposta_proponente AUTO_INCREMENT = 0');
        DB::statement('ALTER TABLE proposta_diretor_uo AUTO_INCREMENT = 0');
        DB::statement('ALTER TABLE proposta_ctc AUTO_INCREMENT = 0');
        DB::statement('ALTER TABLE proposta_secretariado_direcao AUTO_INCREMENT = 0');
        DB::statement('ALTER TABLE proposta_recursos_humanos AUTO_INCREMENT = 0');
        DB::statement('ALTER TABLE proposta AUTO_INCREMENT = 0');

        DB::statement("SET foreign_key_checks=1"); //Sera preciso??

        $this->call(UserTableSeeder::class);
        $this->call(DepartmentTableSeeder::class);
        $this->call(UnidadeCurricularSeeder::class);
        
    }
}

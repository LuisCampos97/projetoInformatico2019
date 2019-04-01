<?php

use Illuminate\Database\Seeder;

class DepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->line("");
        $this->command->line("##################################################################################");
        $this->command->line("A criar departamentos...");
        $this->command->line("##################################################################################");

        $this->faker = Faker\Factory::create('pt_PT');

        $this->adicionarDepartamento($this->faker, 'Engenharia Informatica', 'EI');
        $this->adicionarDepartamento($this->faker, 'Matematica', 'MAT');
        
    }

    private function adicionarDepartamento(Faker\Generator $faker, $name, $sigla)
    {
        $departamento = [
            'nome_departamento' => $name,
            'sigla' => $sigla,
            'coordenador_departamento' => $this->getRandomPreponente(),
        ];
        DB::table('departamento')->insertGetId($departamento);
    }

    private function getRandomPreponente()
    {
        static $preponentes;
        $preponentes = $preponentes != null ? $preponentes : DB::table('user')->where('role', 'proponente')
        ->where('deleted_at', null)->where('blocked', 0)->pluck('id');
        return $preponentes->random();
    }

}

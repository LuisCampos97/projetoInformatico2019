<?php

use Illuminate\Database\Seeder;

class UnidadeCurricularSeeder extends Seeder
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
        $this->command->line("A criar unidades curriculares...");
        $this->command->line("##################################################################################");

        $this->faker = Faker\Factory::create('pt_PT');

        $this->addUnidadeCurricular($this->faker, 'Programação 1', $this->getIdDepartamentoInformatica(), 'Diurno', 'Semestral', 5, 75);
        $this->addUnidadeCurricular($this->faker, 'Programação 2', $this->getIdDepartamentoInformatica(), 'Diurno', 'Semestral', 6, 85);
        $this->addUnidadeCurricular($this->faker, 'Analise Matematica', $this->getIdDepartamentoMatematica(), 'Diurno', 'Semestral', 5, 75);

    }

    private function addUnidadeCurricular(Faker\Generator $faker, $nome, $departamento, $regime, $tipo, $horas, $horas_semestrais)
    {
        $unidadeCurricular = [
            'nome' => $nome,
            'departamento_id' => $departamento,
            'regime' => $regime,
            'tipo' => $tipo,
            'horas' => $horas,
            'horas_semestrais' => $horas_semestrais,
        ];

        DB::table('unidade_curricular')->insertGetId($unidadeCurricular);
    }

    private function getIdDepartamentoMatematica()
    {
        static $departamentoMatematica;
        $departamentoMatematica = $departamentoMatematica != null ? $departamentoMatematica : DB::table('departamento')
            ->where('nome_departamento', 'Matematica')->pluck('id')[0];
        return $departamentoMatematica;
    }

    private function getIdDepartamentoInformatica(){
        static $departamentoInformatica;
        $departamentoInformatica = $departamentoInformatica != null ? $departamentoInformatica : DB::table('departamento')
            ->where('nome_departamento', 'Engenharia Informatica')->pluck('id')[0];
        return $departamentoInformatica;
    }

    
}

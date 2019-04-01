<?php

use Illuminate\Database\Seeder;

class PropostaProponenteProfessorSeeder extends Seeder
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
        $this->command->line("A criar proposta proponente professor...");
        $this->command->line("##################################################################################");

        $this->faker = Faker\Factory::create('pt_PT');

        
    }
}

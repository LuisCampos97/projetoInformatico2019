<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    private $typesOfUsers = ['proponente', 'diretor_uo', 'ctc', 'secretariado_direcao', 'recursos_humanos'];
    private $typesOfUsersPrefix = ['p', 'd', 'c', 's', 'r'];
    private $numberOfUsers = [5,1,5,5,5];
    private $numberOfSoftDeletedUsers = [1,0,1,1,1];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->line("");
        $this->command->line("##################################################################################");
        $this->command->line("A criar utilizadores...");
        $this->command->line("##################################################################################");

        $this->faker = Faker\Factory::create('pt_PT');

        $totalUsers = 0;
        $contadorGlobal = 0;
        for ($typeOfUserIdx = 0; $typeOfUserIdx< 4; $typeOfUserIdx++) {
            $totalUsers += $this->numberOfUsers[$typeOfUserIdx];
            $totalUsers += $this->numberOfSoftDeletedUsers[$typeOfUserIdx];
        }

        $faker = Faker\Factory::create('pt_PT');

        for ($typeOfUserIdx = 0; $typeOfUserIdx< 4; $typeOfUserIdx++) {
            for ($i = 0; $i < $this->numberOfUsers[$typeOfUserIdx]; $i++) {
                $contadorGlobal++;
                $user = $this->fakeUser($faker, $typeOfUserIdx, $i);
                DB::table('user')->insert($user);
                $this->command->info("Created User $contadorGlobal/$totalUsers: " . $user['name']);
            }
            for ($j = 0; $j < $this->numberOfSoftDeletedUsers[$typeOfUserIdx]; $j++) {
                $contadorGlobal++;
                $user = $this->fakeUser($faker, $typeOfUserIdx, $j + $i, true);
                DB::table('user')->insert($user);
                $this->command->info("Created User $contadorGlobal/$totalUsers: " . $user['name']);
            }
        }
    }

    private function fakeUser(Faker\Generator $faker, $typeOfUserIdx, $idx, $softDelete = false)
    {
        $createdAt = Carbon\Carbon::now()->subDays(600);
        $gender = $faker->randomElements(['male', 'female'])[0];

        return[
            'name' =>$idx == 0 ? 'First ' . $this->typesOfUsers[$typeOfUserIdx] : $faker->name($gender),
            'numero_identificacao' => $faker->randomNumber($nbDigits = 9),
            'tipo_documento' => $faker->randomElement(['cartao_cidadao', 'passaporte']),
            'username' => $this->typesOfUsersPrefix[$typeOfUserIdx].$idx,
            'password' => bcrypt('123'),
            'role' => $this->typesOfUsers[$typeOfUserIdx],
            'email' => $this->typesOfUsersPrefix[$typeOfUserIdx].$idx.'@mail.pt',
            'blocked' => $softDelete? false : ($idx == 0 ? false : $idx % 9 == 0),
            'remember_token' => str_random(10),
            'created_at' => $createdAt,
            'updated_at' => $faker->dateTimeBetween($createdAt),
            'deleted_at' => $softDelete ? $faker->dateTimeBetween($createdAt) : null
        ];
    }
}

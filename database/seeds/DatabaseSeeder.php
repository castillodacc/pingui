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
        $this->call(ClearTablesSeeder::class);
        $this->call(PermissionsSeeder::class);
        $this->call(UserRootSeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(DeveloperSeeder::class);
        if (env('APP_ENV') == 'production') {return;}
        $organizer = \App\Models\Organizer::create([
            'name' => ucfirst(mb_strtolower("organizador")),
            'paypal_client_id' => "1",
            'paypal_client_secret' => "1",
            't_publishable_key' => "1",
            't_secret_key' => "1",
            'bank' => "1",
            'account' => "1",
            'headline' => "1",
        ]);

        $referee = \App\Models\Referee::create([
            'name' => ucfirst(mb_strtolower("Referee")),
        ]);
    
        $dataTournament = [
            'description' => "testtesttesttesttesttesttesttesttesttest",
            'end' => "10/06/2020",
            'inscription' => true,
            'name' => "testtest",
            'organizer_id' => $organizer->id,
            'start' => "10/06/2020",
            'type_id' => 2,
            'record_id' => \App\User::find(1)->id
        ];

        $dataTournament['slug'] = str_replace(' ', '-', $dataTournament['name']);
        $slug = \App\Models\Tournament::where('slug', '=', $dataTournament['slug'])->count();
        $dataTournament['slug'] .= '-' . $slug;

        $dataTournament['end'] = \Carbon::parse($dataTournament['end'])->format('Y-m-d');
        $dataTournament['start'] = \Carbon::parse($dataTournament['start'])->format('Y-m-d');
        $dataTournament['end'] = str_replace('/', '-', $dataTournament['end']);

        $tournament = \App\Models\Tournament::create($dataTournament);
        $tournament->referees()->attach([$referee->id]);

        $dataInscription = [
            'pay' => 16,
            'method_pay' => 1,
            'age_group' => [0, 1],
            'dance' => [0, 5],
            'price' => [],
            'email' => "email@domain.com",
            'phone' => "12345678900",
            'category_id' => 1,
            'sex_id' => 1,
            'name' => "name",
            'last_name' => "last_name",
            'name_couple' => "name_couple",
            'last_name_couple' => "last_name_couple",
            'birthdate' => "05/05/2020",
            'club' => "club",
            'coach' => "entrenador",
            'country' => "pais",
            'tournament_id' => $tournament->id,
        ];

        $inscription = \App\Models\Inscription::create([
            'febd_num_1' => null,
            'febd_num_2' => null,
            'last_name_1' => $dataInscription['last_name'],
            'last_name_2' => optional($dataInscription)['last_name_couple'],
            'name_1' => $dataInscription['name'],
            'name_2' => optional($dataInscription)['name_couple'],
            'tournament_id' => $dataInscription['tournament_id'],
            'method_pay' => $dataInscription['method_pay'],
            'pay' => $dataInscription['pay'],
        ]);

        \App\Models\InscriptionOnline::create([
            'club' => $dataInscription['club'],
            'phone' => $dataInscription['phone'],
            'email' => $dataInscription['email'],
            'coach' => optional($dataInscription)['coach'],
            'sex_id' => optional($dataInscription)['sex_id'],
            'country' => $dataInscription['country'],
            'birthdate' => $dataInscription['birthdate'],
            'category_id' => $dataInscription['category_id'],
            'inscription_id' => $inscription->id,
            'dance' => implode(',', $dataInscription['dance']),
            'age_group' => implode(',', $dataInscription['age_group']),
        ]);

    }
}

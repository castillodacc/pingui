<?php

use Illuminate\Database\Seeder;

class DeveloperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clubs = [
            [
                "id" => "4",
                "name" => "A Ritmo, Club de Baile Deportivo",
                "population" => "Villanueva de Gallego",
                "province" => "Zaragoza",
            ],
            [
                "id" => "5",
                "name" => "Abdera Dance",
                "population" => "Almer",
                "province" => "Almer",
            ],
            [
                "id" => "6",
                "name" => "Abdera Dance, CBD",
                "population" => "Adra",
                "province" => "Almer",
            ],
            [
                "id" => "7",
                "name" => "Akiria, CBE",
                "population" => "Puig-Reig",
                "province" => "Barcelona",
            ],
            [
                "id" => "8",
                "name" => "Al Compas, Club de Baile Deportivo",
                "population" => "Vigo",
                "province" => "Pontevedra",
            ],
            [
                "id" => "9",
                "name" => "Alaquas, Club de Ball Esportiu",
                "population" => "Alaquas",
                "province" => "Valencia",
            ],
            [
                "id" => "10",
                "name" => "Amics del Ball de Sal",
                "population" => "Deltebre",
                "province" => "Tarragona"
            ],
            [
                "id" => "11",
                "name" => "Amposta Quick Dance, C.B.E.",
                "population" => "Amposta",
                "province" => "Tarragona"
            ],
            [
                "id" => "12",
                "name" => "Ara Dance, CBD",
                "population" => "Cadrete",
                "province" => "Zaragoza"
            ],
            [
                "id" => "13",
                "name" => "Arag",
                "population" => "Zaragoza",
                "province" => "Zaragoza"
            ],
            [
                "id" => "14",
                "name" => "Arte e Movemento, Club Baile Deportivo",
                "population" => "CEE",
                "province" => "A Coru"
            ],
            [
                "id" => "15",
                "name" => "Baile para todos, CBD",
                "population" => "Cuarte de Huerva",
                "province" => "Zaragoza"
            ],
            [
                "id" => "16",
                "name" => "Ballroom Saforball",
                "population" => "Oliva",
                "province" => "Valencia"
            ],
            [
                "id" => "17",
                "name" => "Bat-Club, Club de Ball Esportiu",
                "population" => "Palma de Mallorca",
                "province" => "Illes Balears"
            ],
            [
                "id" => "18",
                "name" => "Bougis Dance, Club de Ball Esportiu",
                "population" => "Almassora",
                "province" => "Castell"
            ],
            [
                "id" => "19",
                "name" => "Carisma Vila-Real, CBE",
                "population" => "Vila-Real",
                "province" => "Castell"
            ],
            [
                "id" => "20",
                "name" => "Centre de Ball Mallorca. C.B.E.",
                "population" => "Palma de Mallorca",
                "province" => "Illes Balears"
            ],
            [
                "id" => "21",
                "name" => "Dance Time, CBE",
                "population" => "Palma",
                "province" => "Illes Balears"
            ],
            [
                "id" => "22",
                "name" => "DanceGold, CBE",
                "population" => "Vilanova i la Geltr",
                "province" => "Barcelona"
            ],
            [
                "id" => "23",
                "name" => "Dancing Days, CBE",
                "population" => "B_terra",
                "province" => "Valencia"
            ],
            [
                "id" => "24",
                "name" => "Dancing Elx, CBE",
                "population" => "Elche",
                "province" => "Alicante"
            ],
            [
                "id" => "25",
                "name" => "Dancing Ontinyent, Club de Ball Esportiu",
                "population" => "Ontinyent",
                "province" => "Valencia"
            ],
            [
                "id" => "26",
                "name" => "Dandi, CBE",
                "population" => "Mollet del Valles",
                "province" => "Barcelona"
            ],
            [
                "id" => "27",
                "name" => "Danzalia Espai de Ball, CBE",
                "population" => "B_tera",
                "province" => "Valencia"
            ],
            [
                "id" => "28",
                "name" => "Didance, CBE",
                "population" => "Lleida",
                "province" => "Lleida"
            ],
            [
                "id" => "29",
                "name" => "Elegance, CBE",
                "population" => "Alicante",
                "province" => "Alicante"
            ],
            [
                "id" => "30",
                "name" => "Emilio Benaguasil, Club de Ball Esportiu",
                "population" => "Benaguacil",
                "province" => "Valencia"
            ],
            [
                "id" => "31",
                "name" => "Enrique Lluch La Ca",
                "population" => "Paterna",
                "province" => "Valencia"
            ],
            [
                "id" => "32",
                "name" => "Fanny Blasco, CBE",
                "population" => "San Vicente del Raspeig",
                "province" => "Valencia"
            ],
            [
                "id" => "33",
                "name" => "Felanitx, Club de Ball Esportiu",
                "population" => "Felanitx",
                "province" => "Illes Balears"
            ],
            [
                "id" => "34",
                "name" => "Fipball, CBE",
                "population" => "Sant Boi de Llobregat",
                "province" => "Barcelona"
            ],
            [
                "id" => "35",
                "name" => "Frak Manresa, CBE",
                "population" => "Manresa",
                "province" => "Barcelona"
            ],
            [
                "id" => "36",
                "name" => "Giros Dance Massanassa, Club Baile Deportivo",
                "population" => "Massanassa",
                "province" => "Valencia"
            ],
            [
                "id" => "37",
                "name" => "Globaldance",
                "population" => "San Sebasti",
                "province" => "Madrid"
            ],
            [
                "id" => "38",
                "name" => "Goldance",
                "population" => "Ferreira Do Valadouro",
                "province" => "Lugo"
            ],
            [
                "id" => "39",
                "name" => "Guadalajara Club Deportivo B",
                "population" => "Guadalajara",
                "province" => "Guadalajara"
            ],
            [
                "id" => "40",
                "name" => "Hermanos Agramunt Manises, CBE",
                "population" => "Manises",
                "province" => "Valencia"
            ],
            [
                "id" => "41",
                "name" => "Ileten Tenerife, Club Deportivo de Baile",
                "population" => "San Cristobal de la Laguna",
                "province" => "Santa Cruz de Tenerife"
            ],
            [
                "id" => "42",
                "name" => "Illescas CBE",
                "population" => "El Viso de San Juan",
                "province" => "Toledo"
            ],
            [
                "id" => "43",
                "name" => "Impetus, CBE",
                "population" => "La Pobla Llarga",
                "province" => "Valencia"
            ],
            [
                "id" => "44",
                "name" => "Impuls, CBE",
                "population" => "Terrassa",
                "province" => "Barcelona"
            ],
            [
                "id" => "45",
                "name" => "Kalinka Marat Yarulin, CBD",
                "population" => "Valencia",
                "province" => "Valencia"
            ],
            [
                "id" => "46",
                "name" => "La Costa, Club de Baile Deportivo",
                "population" => "Torremolinos",
                "province" => "M"
            ],
            [
                "id" => "47",
                "name" => "La Garriga, CBE",
                "population" => "La Garriga",
                "province" => "Barcelona"
            ],
            [
                "id" => "48",
                "name" => "La Gatzara, CBE",
                "population" => "Riudellots",
                "province" => "Girona"
            ],
            [
                "id" => "49",
                "name" => "La Pobla de Vallbona Balla, Club de Ball Esportiu",
                "population" => "Pobla de Vallbona",
                "province" => "Valencia"
            ],
            [
                "id" => "50",
                "name" => "L Eliana, CBE",
                "population" => "Riba-Roja de Turia",
                "province" => "Valencia"
            ],
            [
                "id" => "51",
                "name" => "Mambo Swing, CBD",
                "population" => "Arroyomolinos",
                "province" => "Madrid"
            ],
            [
                "id" => "52",
                "name" => "Manises, Club de Ball Esportiu",
                "population" => "Manises",
                "province" => "Valencia"
            ],
            [
                "id" => "53",
                "name" => "Marina, CBE",
                "population" => "Marratx",
                "province" => "Illes Balears"
            ],
            [
                "id" => "54",
                "name" => "Moviments, GEBE",
                "population" => "Valencia",
                "province" => "Valencia"
            ],
            [
                "id" => "55",
                "name" => "Nar",
                "population" => "Nar",
                "province" => "A Coru"
            ],
            [
                "id" => "56",
                "name" => "Palma Ball, CBE palma-ball-c-b-e",
                "population" => "Palma de Mallorca",
                "province" => "Illes Balears"
            ],
            [
                "id" => "57",
                "name" => "Partenaire, CBE",
                "population" => "Granollers",
                "province" => "Barcelona"
            ],
            [
                "id" => "58",
                "name" => "Pasbàsic",
                "population" => "El Masnou",
                "province" => "Barcelona"
            ],
            [
                "id" => "59",
                "name" => "Piedra Escrita Paterna, CBD",
                "population" => "Paterna",
                "province" => "Valencia"
            ],
            [
                "id" => "60",
                "name" => "Pilar Torcal y Jan Mller, CBD",
                "population" => "Zaragoza",
                "province" => "Zaragoza"
            ],
            [
                "id" => "61",
                "name" => "Platinium, Club Esportiu",
                "population" => "Palma de Mallorca",
                "province" => "Illes Balears"
            ],
            [
                "id" => "62",
                "name" => "Pràctic, CBE",
                "population" => "Barcelona",
                "province" => "Barcelona"
            ],
            [
                "id" => "63",
                "name" => "Quart, CBE",
                "population" => "Quart",
                "province" => "Girona"
            ],
            [
                "id" => "64",
                "name" => "Querobaile, Club de Baile Deportivo",
                "population" => "Vigo",
                "province" => "Pontevedra"
            ],
            [
                "id" => "65",
                "name" => "Ribarroja, Club de Ball Esportiu",
                "population" => "Ribarroja de Turia",
                "province" => "Valencia"
            ],
            [
                "id" => "66",
                "name" => "Salduie, Club de Baile Deportivo",
                "population" => "La Cartuja Baja",
                "province" => "Zaragoza"
            ],
            [
                "id" => "67",
                "name" => "Sant Cugat, CBE",
                "population" => "Sant Cugat del Vall_s",
                "province" => "Barcelona"
            ],
            [
                "id" => "68",
                "name" => "Sant Vicen",
                "population" => "Sant Vicen",
                "province" => "Barcelona"
            ],
            [
                "id" => "69",
                "name" => "Shatki, CBE",
                "population" => "Burjassot",
                "province" => "Valencia"
            ],
            [
                "id" => "70",
                "name" => "Sons Club de Baile",
                "population" => "Santiago de Compostela",
                "province" => "A Coru"
            ],
            [
                "id" => "71",
                "name" => "Standard Latinos, CBE",
                "population" => "Esplugues de Llobregat",
                "province" => "Barcelona"
            ],
            [
                "id" => "72",
                "name" => "Stil, Academia de Ball",
                "population" => "Campos",
                "province" => "Illes Balears"
            ],
            [
                "id" => "73",
                "name" => "Stop and Go, CDB",
                "population" => "Zaragoza",
                "province" => "Zaragoza"
            ],
            [
                "id" => "74",
                "name" => "Studio 16, CD",
                "population" => "Roquetas de Mar",
                "province" => "Almer"
            ],
            [
                "id" => "75",
                "name" => "Stylo s Club de Baile Deportivo",
                "population" => "Mislata",
                "province" => "Valencia"
            ],
            [
                "id" => "76",
                "name" => "Swing Castellon",
                "population" => "Castellon",
                "province" => "Castellon"
            ],
            [
                "id" => "77",
                "name" => "Team Swing",
                "population" => "Manresa",
                "province" => "Barcelona"
            ],
            [
                "id" => "78",
                "name" => "Team Dynamik, CBE",
                "population" => "Esplugues de Llobregat",
                "province" => "Barcelona"
            ],
            [
                "id" => "79",
                "name" => "Twirling - Gimn",
                "population" => "Sant Feliu de Guixols",
                "province" => "Girona"
            ],
            [
                "id" => "80",
                "name" => "Twirling dels Alfacs, Club",
                "population" => "Sant Carles de la R",
                "province" => "Tarragona"
            ],
            [
                "id" => "81",
                "name" => "Twirling Els Magraners, Club",
                "population" => "Lleida",
                "province" => "Lleida"
            ],
            [
                "id" => "82",
                "name" => "Twirling Gornal, Club",
                "population" => "Hospitalet de Llobregat",
                "province" => "Barcelona"
            ],
            [
                "id" => "83",
                "name" => "Twirling Monteagudo Majorettes",
                "population" => "Monteagudo",
                "province" => "Murcia"
            ],
            [
                "id" => "84",
                "name" => "Valencia, CBE",
                "population" => "Valencia",
                "province" => "Valencia"
            ],
            [
                "id" => "85",
                "name" => "Ven y Baila, Club de Baile Deportivo",
                "population" => "Zaragoza",
                "province" => "Zaragoza"
            ],
            [
                "id" => "86",
                "name" => "Victory s Sport Dancing",
                "population" => "Palma de Mallorca",
                "province" => "Illes Balears"
            ],
            [
                "id" => "87",
                "name" => "Wali",
                "population" => "Paiporta",
                "province" => "Valencia"
            ],
            [
                "id" => "88",
                "name" => "Zaragoza Chass_ Club de Baile Deportivo",
                "population" => "Villanueva de Gallego",
                "province" => "Zaragoza"
            ],
            [
                "id" => "89",
                "name" => "Armonía Club de Baile Deportivo, CBD",
                "population" => "Zaragoza",
                "province" => "Zaragoza"
            ],
            [
                "id" => "91",
                "name" => "Horadance, CBE",
            ],
            [
                "id" => "92",
                "name" => "Club Arte y Danza",
            ],
            [
                "id" => "94",
                "name" => "Royal Dance",
                "population" => "Manresa",
                "province" => "Barcelona"
            ],
            [
                "id" => "95",
                "name" => "Endansa  CBE",
                "population" => "Moncada",
                "province" => "Barcelona"
            ],
            [
                "id" => "96",
                "name" => "CBE JESUS",
                "province" => "Tarragona"
            ],
            [
                "id" => "97",
                "name" => "CBE Azahar",
                "province" => "Vila-real"
            ],
            [
                "id" => "98",
                "name" => "PAS A PAS VALENCIA",
                "population" => "Valencia",
                "province" => "Valencia"
            ],
            [
                "id" => "99",
                "name" => "DBARROS DANCE C.B.D.",
                "population" => "Almendralejo",
                "province" => "Badajoz"
            ],
            [
                "id" => "100",
                "name" => "Meridance",
                "population" => "Merida",
                "province" => "Badajoz"
            ],
            [
                "id" => "101",
                "name" => "Dancing Granada",
                "population" => "Granada",
                "province" => "Andalucia"
            ],
            [
                "id" => "102",
                "name" => "La Costa, CBE",
            ],
            [
                "id" => "103",
                "name" => "Freedom Dance, CBE",
                "population" => "Sant Juan despi",
                "province" => "Barcelona"
            ],
            [
                "id" => "104",
                "name" => "Simply Dance CBE",
                "population" => "PALMA DE MALLORCA",
                "province" => "Baleares"
            ],
        ];
        foreach ($clubs as $value) {
            \App\Models\Club::create($value);
        }

        /*for ($i = 2; $i <= 100; $i++) { 
            DB::table('role_user')->insert([
                'user_id' => $i,
                'role_id' => rand(2, 3)
            ]);
        }*/

        $category_opens = [
            "Adulto Lat",
            "Adulto Std",
            "C Combinado Puertorriqueño",
            "Clase A Clase B",
            "Clase C – Comb Cubano",
            "Down",
            "F Caribeños comb - Cubano",
            "F Caribeños comb P. Rico",
            "G Ritmos Caribeños",
            "Girls lat",
            "Girls std",
            "H Ritmos Caribeños",
            "Infantil lat",
            "Infantil std",
            "Junior Lat",
            "Junior Std",
            "Juvenil I 4 B",
            "Juvenil II 6B",
            "Juvenil Lat",
            "Latinos sub 12",
            "Latinos sub 16",
            "Latinos sub 9",
            "Lations sub 9",
            "Open +30 años",
            "Open Infantil Lat",
            "Open Infantil Std",
            "Open Latinos",
            "Open Peques Lat",
            "Open Standard +45",
            "Open TV3 Standard",
            "Peques lat",
            "Peques Std",
            "Senior 4 lat",
            "Senior 4 std",
            "Senior I Lat",
            "Senior I Std",
            "Senior II Lat",
            "Senior II Std",
            "Senior III Lat",
            "Senior III Std",
            "Senior IV Lat",
            "Senior Lat",
            "Senior std",
            "Single Latinos",
            "Single Standard",
            "Standard +50",
            "Standard +60",
            "Top Senior lat",
            "Top Senior Std",
            "Wheelchair",
            "Youth Lat",
            "Youth Std"
        ];
        foreach ($category_opens as $c) {
            \App\Models\Category_open::create(['name' => $c]);
        }

        $category_latinos = [
            "1ª Territorial (D)",
            "2ª Territorial (E)",
            "AI",
            "AN",
            "B",
            "C",
            "F",
            // "No Bailo",
        ];
        $subcategory_latinos = [
            "Adulto I",
            "Adulto II",
            "Junior 1",
            "Junior II",
            "Juvenil 1",
            "Juvenil 2",
            "Senior",
            "Senior II",
            "Senior III",
            "Youth",
        ];
        foreach ($category_latinos as $c) {
            $Category_latino = \App\Models\Category_latino::create(['name' => $c]);
            foreach ($subcategory_latinos as $s) {
                \App\Models\Subcategory_latino::create([
                    'name' => $s,
                    'category_latino_id' => $Category_latino->id
                ]);
            }
        }
        \App\Models\Category_latino::create(['name' => "No Bailo"]);

        $categories_standard = [
            "1ª Territorial (D)" => [
                "Adulto I",
                "Adulto II",
                "Junior 1",
                "Junior II",
                "Juvenil 1",
                "Juvenil 2",
                "Senior",
                "Senior II",
                "Senior III",
                "Youth",
            ],
            "2ª Territorial (E)" => [
                "Adulto I",
                "Adulto II",
                "Junior 1",
                "Junior II",
                "Juvenil 1",
                "Juvenil 2",
                "Senior",
                "Senior II",
                "Senior III",
                "Youth",
            ],
            "AI" => [
                "Adulto I",
                "Senior II",
                "Senior III",
            ],
            "AN" => [
                "Adulto I",
                "Adulto II",
                "Junior I",
                "Junior II",
                "Senior",
                "Senior II",
                "Senior III",
                "Senior IV",
                "Top senior",
                "Youth",
            ],
            "B" => [
                "Adulto I",
                "Adulto II",
                "Junior I",
                "Junior II",
                "Senior",
                "Senior II",
                "Senior III",
                "Senior IV",
                "Top Senior",
                "Youth",
            ],
            "C" => [
                "Adulto I",
                "Adulto II",
                "Junior I",
                "Junior II",
                "Senior",
                "Senior II",
                "Senior III",
                "Youth",
            ],
            "F" => [
                "Adulto I",
                "Adulto II",
                "Junior I",
                "Junior II",
                "Juvenil 1",
                "juvenil 2",
                "Senior",
                "Senior II",
                "Senior III",
                "Youth",
            ],
            "Girls std" => [
                "Girls std"
            ],
            "No Bailo" => [
                "No Bailo"
            ],
        ];
        foreach ($categories_standard as $key => $value) {
            $category_standar = \App\Models\Category_standar::create(['name' => $key]);
            foreach ($value as $sub) {
                \App\Models\Subcategory_standar::create([
                    'name' => $sub,
                    'category_standar_id' => $category_standar->id
                ]);
            }
        }
    }
}

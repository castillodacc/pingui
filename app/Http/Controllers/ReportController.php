<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tournament;

class ReportController extends Controller
{
	public function csvCompetition(Request $request, $id)
	{
		$tournament = Tournament::findOrFail($id);
		$str_lg = '';
		header("Content-type: application/csv; charset=UTF-8");
		header("Content-Disposition:attachment; filename=$tournament->slug.csv");
		header("Pragma: no-cache");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

		if ($tournament->type_id == 1) {
			foreach ($tournament->prices as $p) {
				foreach ($p->inscriptions as $i) {
					$str = '';
					// sutaz -> CATEGORIAS
					if ($p->category_id == 1) {
						$str = 'OPEN ' . $p->subO->name;
					} elseif ($p->category_id == 2) {
						$str = 'LAT ' . $p->subL->name . ' - ' . $p->subL->category_latino->name;
					} else {
						$str = 'STD ';
						$str .= $p->subS->name . ' - ' . $p->subS->category_standar->name;
					}
					$str .= ';';
					// idpar -> ID de la pareja
					$str .= /*$i->user_id . */';';
					// idMuz -> ID del Bailarín
					$str .= $i->febd_num_1 . ';';
					// Menomuz -> nombre de la Bailarín
					$str .= "$i->last_name_1, $i->name_1" . ';';
					// idZena -> ID del Bailarina
					$str .= $i->febd_num_2 . ';';
					// Menozena -> nombre de la Bailarina
					$str .= "$i->last_name_2, $i->name_2" . ';';
					// klub -> Club
					if ($i->user) {
						$str .= optional($i->user->club)->name . ';';
					} else {
						$str .= ';';
					}
					// stat -> Nacionalidad
					$str .= 'España;';
					// dorsal
					$str .= $i->dorsal . ';';
					$str_lg .= $str .= "\n";
				}
			}
			$str_lg .= 'sutaz; idpar; idMuz; Menomuz; idZena;Menozena; klub; stat; Dorsal';
		} elseif ($tournament->type_id == 2) {
			$str_lg .= "sutaz;idpar;idMuz;Menomuz;idZena;Menozena;klub;stat;Dorsal;phone;email;;;;;;;;;;;;;;;\n";
			$age_groups = [
				'JUVENIL 13 years old',
				'Under 16',
				'Under 21',
				'Under 35',
				'Over 35',
			];
			$dances = [
				'English Walts',
				'Tango',
				'Viennese Waltz',
				'Slow Foxtrot',
				'Quickstep',
				'Samba',
				'Cha cha cha',
				'Rumba',
				'Paso doble',
				'Jive',
			];
			foreach ($dances as $key => $value) {
				$test = true;
				foreach ($tournament->inscriptions as $i) {
					if (in_array($key, explode(',', $i->inscriptionOnline->dance))) {
						$test = false; continue;
					}
				}
				if ($test) {continue;}

				foreach ($age_groups as $key_ag => $value_ag) {
					$test2 = true;
					foreach ($tournament->inscriptions as $i) {
						if (in_array($key_ag, explode(',', $i->inscriptionOnline->age_group)) && in_array($key, explode(',', $i->inscriptionOnline->dance))) {
							$test2 = false; continue;
						}
					}
					if ($test2) {continue;}

					foreach ($tournament->inscriptions as $i) {
						if (! in_array($key, explode(',', $i->inscriptionOnline->dance) )) {continue;}
						if (! in_array($key_ag, explode(',', $i->inscriptionOnline->age_group) )) {continue;}
						$str = '';
						// sutaz -> CATEGORIAS
						$str = $value_ag . ' - ' . $value . ';';
						// idpar -> ID de la pareja
						$str .= /*$i->user_id . */';';
						// idMuz -> ID del Bailarín
						$str .= $i->febd_num_1 . ';';
						// Menomuz -> nombre del Bailarín
						$str .= "$i->last_name_1, $i->name_1" . ';';
						// idZena -> ID del Bailarina
						$str .= $i->febd_num_2 . ';';
						// Menozena -> nombre de la Bailarina
						$str .= "$i->last_name_2, $i->name_2" . ';';
						// klub -> Club
						$str .= optional($i->inscriptionOnline)->club . ';';
						// stat -> Nacionalidad
						$str .= optional($i->inscriptionOnline)->country . ';';
						// phone -> Telefono
						$str .= optional($i->inscriptionOnline)->phone . ';';
						// email -> Correo
						$str .= optional($i->inscriptionOnline)->email . ';';
						// Dorsal
						$str .= $i->dorsal . ';';
						$str .= ';;;;;;;;;;;;;;;;;';
						$str_lg .= $str .= "\n";
					}
				}
			}
		}
		$str_lg = utf8_decode($str_lg);
		echo $str_lg . "\n";
		return;
	}

	public function ListInscriptions($id)
	{
		$tournament = Tournament::findOrFail($id);
		if ($tournament == null) return redirect('/');
		$age_groups = [
            'JUVENIL 13 years old',
            'Under 16',
            'Under 21',
            'Under 35',
            'Over 35',
        ];
        $dances = [
        	'English Walts',
        	'Tango',
        	'Viennese Waltz',
        	'Slow Foxtrot',
        	'Quickstep',
        	'Samba',
        	'Cha cha cha',
        	'Rumba',
        	'Paso doble',
        	'Jive',
        ];
		return \PDF::loadView(
			'pdf.inscription-list',
			compact('tournament', 'age_groups', 'dances')
		)->stream("$tournament->name.pdf");
	}
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StepsSeeder extends Seeder
{
    public function run(): void
    {
        $steps = [

            // ===== Challenge 1: Afval Prikker avontuur =====
            [
                'challenge_id' => 1,
                'step_number' => 1,
                'step_description' => 'Verzamel een afvalzak, grijper of handschoenen.',
            ],
            [
                'challenge_id' => 1,
                'step_number' => 2,
                'step_description' => 'Kies een plek waar vaak afval ligt.',
            ],
            [
                'challenge_id' => 1,
                'step_number' => 3,
                'step_description' => 'Ruim zoveel mogelijk zwerfafval op.',
            ],
            [
                'challenge_id' => 1,
                'step_number' => 4,
                'step_description' => 'Gooi de volle zak weg.',
            ],
            [
                'challenge_id' => 1,
                'step_number' => 5,
                'step_description' => 'Maak een foto van je verzamelde afval.',
            ],

            // ===== Challenge 2: Mini-Boompje Planten =====
            [
                'challenge_id' => 2,
                'step_number' => 1,
                'step_description' => 'Kies een plek waar het boompje kan groeien.',
            ],
            [
                'challenge_id' => 2,
                'step_number' => 2,
                'step_description' => 'Koop of ontvang een jong boompje.',
            ],
            [
                'challenge_id' => 2,
                'step_number' => 3,
                'step_description' => 'Graaf een gat dat diep genoeg is.',
            ],
            [
                'challenge_id' => 2,
                'step_number' => 4,
                'step_description' => 'Plaats het boompje rechtop.',
            ],
            [
                'challenge_id' => 2,
                'step_number' => 5,
                'step_description' => 'Vul het gat met aarde.',
            ],
            [
                'challenge_id' => 2,
                'step_number' => 6,
                'step_description' => 'Geef elke week water en maak een foto als bewijs.',
            ],

            // ===== Challenge 3: Red de Bijen – Bloemen Zaaien =====
            [
                'challenge_id' => 3,
                'step_number' => 1,
                'step_description' => 'Zoek een zonnige plek buiten, want bloemen groeien het beste in de zon.',
            ],
            [
                'challenge_id' => 3,
                'step_number' => 2,
                'step_description' => 'Maak de aarde los zodat de wortels straks makkelijk kunnen groeien.',
            ],
            [
                'challenge_id' => 3,
                'step_number' => 3,
                'step_description' => 'Strooi de zaadjes rustig uit, zo krijgen de bloemen genoeg ruimte.',
            ],
            [
                'challenge_id' => 3,
                'step_number' => 4,
                'step_description' => 'Bedek de zaadjes met een dun laagje aarde tegen wind en vogels.',
            ],
            [
                'challenge_id' => 3,
                'step_number' => 5,
                'step_description' => 'Geef water zodat de zaadjes kunnen beginnen met groeien.',
            ],
            [
                'challenge_id' => 3,
                'step_number' => 6,
                'step_description' => 'Geef regelmatig water en kijk elke dag even hoe het gaat.',
            ],
            [
                'challenge_id' => 3,
                'step_number' => 7,
                'step_description' => 'Na een paar weken bloeien de bloemen en komen bijen nectar halen.',
            ],
            [
                'challenge_id' => 3,
                'step_number' => 8,
                'step_description' => 'Door jouw werk help je de natuur en maak je de wereld een beetje groener.',
            ],

            // ===== Challenge 4: Waterwachter – Sloot Inspectie =====
            [
                'challenge_id' => 4,
                'step_number' => 1,
                'step_description' => 'Zoek een waterplek bij jou in de buurt.',
            ],
            [
                'challenge_id' => 4,
                'step_number' => 2,
                'step_description' => 'Observeer of het water helder of troebel is.',
            ],
            [
                'challenge_id' => 4,
                'step_number' => 3,
                'step_description' => 'Kijk welke dieren en planten aanwezig zijn.',
            ],
            [
                'challenge_id' => 4,
                'step_number' => 4,
                'step_description' => 'Noteer wat je hebt ontdekt.',
            ],
            [
                'challenge_id' => 4,
                'step_number' => 5,
                'step_description' => 'Maak foto’s van je bevindingen.',
            ],

            // ===== Challenge 6: Bouw een Insectenhotel =====
            [
                'challenge_id' => 6,
                'step_number' => 1,
                'step_description' => 'Gebruik natuurlijke materialen zoals hout, bamboe, riet, dennenappels of karton.',
            ],
            [
                'challenge_id' => 6,
                'step_number' => 2,
                'step_description' => 'Gebruik een doos, blik of houten kistje als huisje.',
            ],
            [
                'challenge_id' => 6,
                'step_number' => 3,
                'step_description' => 'Stop de materialen in vakjes of lagen zodat meerdere insecten kunnen wonen.',
            ],
            [
                'challenge_id' => 6,
                'step_number' => 4,
                'step_description' => 'Gaatjes in hout en holle stengels zijn perfecte nestelplekken.',
            ],
            [
                'challenge_id' => 6,
                'step_number' => 5,
                'step_description' => 'Plaats het insectenhotel buiten op een droge en zonnige plek.',
            ],
            [
                'challenge_id' => 6,
                'step_number' => 6,
                'step_description' => 'Insecten gebruiken het hotel om te rusten of te overwinteren.',
            ],
            [
                'challenge_id' => 6,
                'step_number' => 7,
                'step_description' => 'Door jouw insectenhotel blijft de bodem gezond.',
            ],
            [
                'challenge_id' => 6,
                'step_number' => 8,
                'step_description' => 'Je hebt insecten geholpen én iets creatiefs gebouwd.',
            ],

            // ===== Challenge 7: Zelfgemaakte Windmolen =====
            [
                'challenge_id' => 7,
                'step_number' => 1,
                'step_description' => 'Verzamel wieken, een stokje, een motortje, draadjes en een batterij.',
            ],
            [
                'challenge_id' => 7,
                'step_number' => 2,
                'step_description' => 'Maak de wieken vast aan het motortje.',
            ],
            [
                'challenge_id' => 7,
                'step_number' => 3,
                'step_description' => 'Plak het motortje op de bovenkant van het stokje.',
            ],
            [
                'challenge_id' => 7,
                'step_number' => 4,
                'step_description' => 'Verbind het motortje met de batterij met draadjes.',
            ],
            [
                'challenge_id' => 7,
                'step_number' => 5,
                'step_description' => 'Zet de molen buiten in de wind.',
            ],
            [
                'challenge_id' => 7,
                'step_number' => 6,
                'step_description' => 'Kijk hoe de wieken draaien!',
            ],
        ];

        foreach ($steps as $step) {
            DB::table('steps')->updateOrInsert(
                [
                    'challenge_id' => $step['challenge_id'],
                    'step_number' => $step['step_number'],
                ],
                $step
            );
        }
    }
}

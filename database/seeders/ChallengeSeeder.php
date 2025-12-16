<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Challenge;

class ChallengeSeeder extends Seeder
{
    public function run(): void
    {
        $challenges = [
            [
                'title' => 'Afval Prikker avontuur',
                'description' => 'In de natuur komt helaas nog steeds veel zwerfafval terecht. Plastic, blikjes en papiertjes kunnen schadelijk zijn voor dieren en vervuilen het landschap. Met deze challenge draag je direct bij aan een schonere, gezondere omgeving. Door bewust afval te verzamelen, word je niet alleen zelf milieubewuster, maar inspireer je ook anderen om duurzamer om te gaan met de natuur. Een kleine actie kan al een zichtbaar verschil maken in jouw buurt.',
                'difficulty_id' => 1,
                'user_id' => 12,
                'badge_id' => 9,
                'published' => true,
                'duration' => '00:15',
                'image_path' => 'challenge_images/afvalprikker.webp',
            ],
            [
                'title' => 'Mini-Boompje Planten',
                'description' => 'Bomen zijn onmisbaar voor een gezond klimaat. Ze zorgen voor schone lucht, bieden schaduw, verminderen CO₂ en geven dieren een plek om te leven. Door een boompje te planten draag je letterlijk een steentje bij aan een groenere toekomst. Deze challenge laat je ervaren hoe eenvoudig én impactvol het kan zijn om meer natuur te creëren. Het boompje groeit mee met de tijd, net als jouw inzet voor het milieu.',
                'difficulty_id' => 2,
                'user_id' => 12,
                'badge_id' => 6,
                'published' => true,
                'duration' => '00:15',
                'image_path' => 'challenge_images/zelf-een-boom-planten-planting-a-tree.jpg',
            ],
            [
                'title' => 'Red de Bijen – Bloemen Zaaien',
                'description' => 'Bijen spelen een cruciale rol in ons ecosysteem: zonder bijen zouden veel planten en gewassen niet kunnen groeien. Helaas hebben bijen het zwaar door verstedelijking en gebrek aan voedsel. Met deze challenge ga jij ze helpen door kleurrijke bloemen te zaaien die nectar en stuifmeel bieden. Binnen een paar weken zie je jouw bloemen tot leven komen en bijdragen aan een gezonde leefomgeving voor insecten.',
                'difficulty_id' => 3,
                'user_id' => 12,
                'badge_id' => 3,
                'published' => true,
                'duration' => '00:05',
                'image_path' => 'challenge_images/zaaien-3-retina.jpg',
            ],
            [
                'title' => 'Waterwachter – Sloot Inspectie',
                'description' => 'Schoon water is belangrijk voor talloze planten en dieren. Veel mensen staan er niet bij stil hoe kwetsbaar de waterkwaliteit is—vervuiling, algengroei en afval kunnen snel gevolgen hebben voor de natuur. Bij deze challenge ga jij onderzoeken hoe gezond het water in jouw omgeving is. Door goed te kijken naar helderheid, geur en leven in het water, leer je meer over ecosystemen en hoe we ze kunnen beschermen.',
                'difficulty_id' => 1,
                'user_id' => 12,
                'badge_id' => 7,
                'published' => true,
                'duration' => '01:00',
                'image_path' => 'challenge_images/maxresdefault.jpg',
            ],
            [
                'title' => 'Wilde Dierenspotter',
                'description' => 'Hoewel je het misschien niet altijd ziet, leven er heel veel dieren in Nederland! Van vogels en egels tot eekhoorns en kikkers. Deze challenge daagt je uit om bewust te kijken naar de natuur om je heen. Door een dier vast te leggen op camera, leer je niet alleen beter kijken, maar ontdek je ook hoe divers je omgeving eigenlijk is. Zo krijg je meer respect en bewondering voor de dieren die hier leven.',
                'difficulty_id' => 3,
                'user_id' => 12,
                'badge_id' => 5,
                'published' => true,
                'duration' => '02:00',
                'image_path' => 'challenge_images/dier6.jpg',
            ],
            [
                'title' => 'Bouw een Insectenhotel',
                'description' => 'Insecten zijn misschien klein, maar ze zijn enorm belangrijk voor de natuur. Ze houden de bodem gezond, bestuiven planten en vormen voedsel voor andere dieren. Steeds minder insecten vinden een goede plek om te leven. Met deze challenge help je ze door een insectenhotel te bouwen. Dit is een veilige plek waar insecten kunnen schuilen, nestelen of overwinteren. Het bouwen ervan is creatief, leerzaam en supernuttig.',
                'difficulty_id' => 1,
                'user_id' => 12,
                'badge_id' => 2,
                'published' => true,
                'duration' => '01:00',
                'image_path' => 'challenge_images/insectenhotel-2023-768x768.jpg',
            ],
            [
                'title' => 'Zelfgemaakte Windmolen',
                'description' => 'Een kleine windmolen gebruikt de kracht van de wind om energie te maken. Wanneer de wieken draaien, wekt het motortje binnenin stroom op. Die stroom kun je gebruiken om bijvoorbeeld een lampje te laten branden. Windmolens zijn goed voor de natuur omdat er geen vieze lucht of rook ontstaat.',
                'difficulty_id' => 3,
                'user_id' => 12,
                'badge_id' => 8,
                'published' => true,
                'duration' => '01:30',
                'image_path' => 'challenge_images/zelfgemaakte-windmolen.png',
            ],
        ];

        foreach ($challenges as $challenge) {
            Challenge::create($challenge);
        }
    }
}

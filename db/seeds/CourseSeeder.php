<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class CourseSeeder extends AbstractSeed
{
    public function getDependencies(): array
    {
        return [
            'UserSeed',
            'TeacherSeed',
            'CdlSeed'
        ];
    }

    public function run(): void
    {
        $data = [
            [
                'teacher' => 3, // Assume this teacher_id exists in your `teachers` table
                'cdl' => 1, // Assume this ID exists in your `cdl` table
                'name' => 'Basi di Dati',
                'description' => 'Basi di Dati',
                'year' => 1,
            ],
            [
                'teacher' => 4, // Another existing teacher_id
                'cdl' => 2, // Another existing cdl ID
                'name' => 'Analisi Matematica',
                'description' => 'A deep dive into complex mathematical theories and applications.',
                'year' => 2,
            ],
            [
                'teacher' => 3, // Assume this teacher_id exists in your `teachers` table
                'cdl' => 1, // Assume this ID exists in your `cdl` table
                'name' => 'Algoritmi e Strutture Dati',
                'description' => 'Algoritmi e Strutture Dati',
                'year' => 1,
            ],
            [
                'teacher' => 4, // Another existing teacher_id
                'cdl' => 2, // Another existing cdl ID
                'name' => 'Matematica del Discreto',
                'description' => 'A deep dive into complex mathematical theories and applications.',
                'year' => 2,
            ],            
            // Add more courses as necessary
        ];

        $this->table('courses')->insert($data)->saveData();
    }
}

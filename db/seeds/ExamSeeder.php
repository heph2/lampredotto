<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class ExamSeeder extends AbstractSeed
{
    public function getDependencies(): array
    {
        return [
            'CourseSeeder'
        ];
    }

    // Change Private Key
    public function run(): void
    {
        $data = [
            [
                'course_id' => 1, // Ensure this ID exists in your `courses` table
                'room' => '101A',
                'name' => 'Esame Basi di Dati',
                'exam_date' => '2023-03-15 09:00:00',
            ],
            [
                'course_id' => 2, // Same course, different exam
                'room' => '101A',
                'name' => 'Esame Analisi Matematica',
                'exam_date' => '2023-06-20 09:00:00',
            ],
            [
                'course_id' => 3, 
                'room' => '102B',
                'name' => 'Esame Analisi Matematica II',
                'exam_date' => '2023-03-16 10:00:00',
            ],
            [
                'course_id' => 4, 
                'room' => '103C',
                'name' => 'Esame Algoritmi e Strutture Dati',
                'exam_date' => '2023-03-17 10:00:00',
            ],            
        ];

        $this->table('exams')->insert($data)->saveData();
    }
}

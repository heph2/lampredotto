<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class EnrollmentSeed extends AbstractSeed
{
    public function getDependencies(): array
    {
        return [
            'UserSeed',
            'StudentSeed',
            'CourseSeeder',
            'ExamSeeder'
        ];
    }

    public function run(): void
    {
        $data = [
            [
                'course_id' => 1, // Assuming this course_id exists in your `exams` table
                'name' => 'Esame Basi di Dati', // Assuming this name exists for the course_id in your `exams` table
                'student' => 1, // Assuming this student_id exists in your `students` table
                'score' => 30, // Assuming this score is valid for the exam
            ],
            [
                'course_id' => 2,
                'name' => 'Esame Analisi Matematica',
                'student' => 2,
            ],
            // Add more records as necessary
        ];

        $this->table('enrollment')->insert($data)->saveData();
    }
}

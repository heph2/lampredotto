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

    public function run(): void
    {
        $data = [
            [
                'course_id' => 1, // Ensure this ID exists in your `courses` table
                'room' => '101A',
                'name' => 'Midterm Exam',
                'exam_date' => '2023-03-15 09:00:00',
            ],
            [
                'course_id' => 1, // Same course, different exam
                'room' => '101A',
                'name' => 'Final Exam',
                'exam_date' => '2023-06-20 09:00:00',
            ],
            [
                'course_id' => 2, // Another course
                'room' => '102B',
                'name' => 'Midterm Exam',
                'exam_date' => '2023-03-16 10:00:00',
            ],
        ];

        $this->table('exams')->insert($data)->saveData();
    }
}

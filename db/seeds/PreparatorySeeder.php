<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class PreparatorySeeder extends AbstractSeed
{
    public function getDependencies(): array
    {
        return [
            'CourseSeeder',
        ];
    }
    public function run(): void
    {
        $data = [
            [
                'preparatory_course' => 1, // ID of the preparatory course in `courses` table
                'course' => 2, // ID of the course requiring the preparatory course
            ],
            [
                'preparatory_course' => 3, // Another preparatory course ID
                'course' => 4, // Another course ID requiring the preparatory course
            ],
            // Add more relationships as necessary
        ];

        $this->table('preparatories')->insert($data)->saveData();
    }
}

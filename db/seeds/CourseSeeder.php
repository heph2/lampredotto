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
                'name' => 'Introduction to Philosophy',
                'description' => 'An overview of major philosophical ideas and thinkers.',
                'year' => 1,
            ],
            [
                'teacher' => 4, // Another existing teacher_id
                'cdl' => 2, // Another existing cdl ID
                'name' => 'Advanced Mathematics',
                'description' => 'A deep dive into complex mathematical theories and applications.',
                'year' => 2,
            ],
            [
                'teacher' => 3, // Assume this teacher_id exists in your `teachers` table
                'cdl' => 1, // Assume this ID exists in your `cdl` table
                'name' => 'Databases',
                'description' => 'An overview of major philosophical ideas and thinkers.',
                'year' => 1,
            ],
            [
                'teacher' => 4, // Another existing teacher_id
                'cdl' => 2, // Another existing cdl ID
                'name' => 'Discrete Mathematics',
                'description' => 'A deep dive into complex mathematical theories and applications.',
                'year' => 2,
            ],            
            // Add more courses as necessary
        ];

        $this->table('courses')->insert($data)->saveData();
    }
}

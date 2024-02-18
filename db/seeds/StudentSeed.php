<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class StudentSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run(): void
    {
        // Ensure there are corresponding entries in 'users' and 'cdl' tables for these IDs
        $data = [
            [
                'student_id' => 1, // ID from 'users'
                'cdl' => 1, // ID from 'cdl'
                'enrollment_date' => '2024-01-01 09:00:00',
                'status' => 'active',
            ],
            [
                'student_id' => 2,
                'cdl' => 2,
                'enrollment_date' => '2024-01-02 10:00:00',
                'status' => 'inactive',
            ],
            // Add more entries as needed
        ];

        $table = $this->table('students');
        $table->insert($data)->saveData(); // Use 'saveData()' for Phinx 0.12.0 and above, otherwise use 'save()'
    }
}

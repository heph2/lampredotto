<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class StudentSeed extends AbstractSeed
{
    public function getDependencies(): array
    {
        return [
            'UserSeed'
        ];
    }

    public function run(): void
    {
        // Assuming 'users' and 'cdl' tables are already seeded and contain data.
        $data = [
            [
                'student_id' => 1, // Ensure this ID exists in the 'users' table
                'cdl' => 1, // Ensure this ID exists in the 'cdl' table
                'enrollment_date' => '2020-09-01 00:00:00',
                'status' => 'active',
            ],
            [
                'student_id' => 2, // Ensure this ID exists in the 'users' table
                'cdl' => 2, // Ensure this ID exists in the 'cdl' table
                'enrollment_date' => '2020-09-02 00:00:00',
                'status' => 'active',
            ],
            // Add more records as needed
        ];

        $table = $this->table('students');
        $table->insert($data)->saveData();
    }
}

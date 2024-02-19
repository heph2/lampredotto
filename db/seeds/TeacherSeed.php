<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class TeacherSeed extends AbstractSeed
{
    public function getDependencies(): array
    {
        return [
            'UserSeed'
        ];
    }

    public function run(): void
    {
        $teacherUserIds = [3, 4]; // Make sure these IDs match actual user IDs in the `users` table.

        $data = [];
        foreach ($teacherUserIds as $userId) {
            $data[] = [
                'teacher_id' => $userId
            ];
        }

        $this->table('teachers')->insert($data)->saveData();
    }
}

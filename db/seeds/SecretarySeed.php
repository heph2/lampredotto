<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class SecretarySeed extends AbstractSeed
{
    public function getDependencies(): array
    {
        return [
            'UserSeed'
        ];
    }

    public function run(): void
    {
        $secretaryUserIds = [5, 6]; // Make sure these IDs match actual user IDs in the `users` table.

        $data = [];
        foreach ($secretaryUserIds as $userId) {
            $data[] = [
                'secretary_id' => $userId
            ];
        }

        $this->table('secretaries')->insert($data)->saveData();
    }
}

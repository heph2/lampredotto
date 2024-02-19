<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class CdlSeed extends AbstractSeed
{
    public function run(): void
    {
        $data = [
            [
                'name'        => 'Computer Science',
                'description' => 'The study of algorithms, data structures, and the principles of software engineering.'
            ],
            [
                'name'        => 'Mathematics',
                'description' => 'The abstract science of number, quantity, and space, either as abstract concepts or as applied to other disciplines such as physics and engineering.'
            ],
        ];

        $table = $this->table('cdl');
        $table->insert($data)->save();
    }
}

<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class CdlSeed extends AbstractSeed
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

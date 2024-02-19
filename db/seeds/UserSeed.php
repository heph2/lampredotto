<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class UserSeed extends AbstractSeed
{
    public function run(): void
    {
        $data = [
            [
                'first_name' => 'Filippo',
                'second_name' => 'Champagne',
                'email' => 'filippo.champagne@example.com',
                'password' => password_hash('password123', PASSWORD_DEFAULT), // Hash the password
            ],
            [
                'first_name' => 'Nevio',
                'second_name' => 'Stirato',
                'email' => 'nevio.stirato@example.com',
                'password' => password_hash('password456', PASSWORD_DEFAULT), // Hash the password
            ],
            [
                'first_name' => 'Alessia',
                'second_name' => 'Bianchi',
                'email' => 'alessia.bianchi@example.com',
                'password' => password_hash('securePass789', PASSWORD_DEFAULT), // Hash the password
            ],
            [
                'first_name' => 'Marco',
                'second_name' => 'Rossi',
                'email' => 'marco.rossi@example.com',
                'password' => password_hash('mySuperPass010', PASSWORD_DEFAULT), // Hash the password
            ],
            [
                'first_name' => 'Giulia',
                'second_name' => 'Verdi',
                'email' => 'giulia.verdi@example.com',
                'password' => password_hash('pass123Giulia', PASSWORD_DEFAULT), // Hash the password
            ],
            [
                'first_name' => 'Luca',
                'second_name' => 'Neri',
                'email' => 'luca.neri@example.com',
                'password' => password_hash('lucaPassword456', PASSWORD_DEFAULT), // Hash the password
            ],
        ];

        $table = $this->table('users');
        $table->insert($data)->saveData();
    }
}

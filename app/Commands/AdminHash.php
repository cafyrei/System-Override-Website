<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class AdminHash extends BaseCommand
{
    protected $group       = 'App';
    protected $name        = 'admin:hash';
    protected $description = 'Generates the bcrypt hash to put in .env as admin.passwordHash.';
    protected $usage       = 'admin:hash [password]';
    protected $arguments   = ['password' => 'Optional. Prompted for if omitted (preferred: an argument lands in shell history).'];

    public function run(array $params)
    {
        $password = $params[0] ?? CLI::prompt('Admin password');

        if (strlen($password) < 12) {
            CLI::error('Use at least 12 characters.');

            return EXIT_ERROR;
        }

        CLI::write("admin.passwordHash = '" . password_hash($password, PASSWORD_DEFAULT) . "'", 'green');
        CLI::write('Paste that line into .env (keep the single quotes; the hash contains "$").');

        return EXIT_SUCCESS;
    }
}

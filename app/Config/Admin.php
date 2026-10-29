<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Administrator credentials. Values are read from .env (never commit them):
 *
 *   admin.username     = 'your-username'
 *   admin.passwordHash = '$2y$12$...'      (generate with: php spark admin:hash)
 *
 * If either value is empty, login is disabled. It fails closed.
 */
class Admin extends BaseConfig
{
    public string $username = '';

    public string $passwordHash = '';

    /** Failed-or-not login attempts allowed per IP per minute. */
    public int $loginAttemptsPerMinute = 5;
}

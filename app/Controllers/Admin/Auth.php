<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Filters\AdminAuth;
use CodeIgniter\HTTP\RedirectResponse;

class Auth extends BaseController
{
    public function loginForm(): string|RedirectResponse
    {
        if (session()->get(AdminAuth::SESSION_KEY) === true) {
            return redirect()->to(site_url('admin'));
        }

        return view('admin/auth/login-admin');
    }

    public function login(): RedirectResponse
    {
        $config   = config('Admin');
        $throttle = service('throttler');
        $back     = redirect()->to(site_url('admin-login'));

        // Counts every attempt (right or wrong) against the client IP.
        if ($throttle->check('admin-login-' . md5($this->request->getIPAddress()), $config->loginAttemptsPerMinute, MINUTE) === false) {
            return $back->with('error', 'Too many attempts. Wait a minute and try again.');
        }

        $identity = trim((string) $this->request->getPost('identity'));
        $password = (string) $this->request->getPost('password');

        if (! $this->credentialsAreValid($config, $identity, $password)) {
            return $back->with('error', 'Access refused. Invalid credentials.')->withInput();
        }

        // New session ID on privilege change: blocks session fixation.
        session()->regenerate();
        session()->set([
            AdminAuth::SESSION_KEY => true,
            'admin_identity'       => $config->username,
        ]);

        return redirect()->to(site_url('admin'));
    }

    public function logout(): RedirectResponse
    {
        session()->destroy();

        return redirect()->to(site_url('admin-login'));
    }

    private function credentialsAreValid(object $config, string $identity, string $password): bool
    {
        // Not configured => nobody gets in.
        if ($config->username === '' || $config->passwordHash === '') {
            return false;
        }

        // Always run both checks so response time doesn't reveal which one failed.
        $userOk = hash_equals($config->username, $identity);
        $passOk = password_verify($password, $config->passwordHash);

        return $userOk && $passOk;
    }
}

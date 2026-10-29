<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Gatekeeper for every admin route. Applied once, to a route group in
 * Config/Routes.php, so individual controllers never check the session
 * themselves (and cannot forget to).
 */
class AdminAuth implements FilterInterface
{
    public const SESSION_KEY = 'is_admin_logged_in';

    public function before(RequestInterface $request, $arguments = null)
    {
        if (session()->get(self::SESSION_KEY) === true) {
            return null;
        }

        // fetch()/XHR callers get a status code they can act on;
        // browsers get sent to the login page.
        $wantsJson = $request->isAJAX()
            || str_contains($request->getHeaderLine('Accept'), 'application/json');

        if ($wantsJson) {
            return service('response')
                ->setStatusCode(401)
                ->setJSON(['success' => false, 'message' => 'Authentication required.']);
        }

        return redirect()->to(site_url('admin-login'));
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Admin pages hold private data; never let a shared cache keep them.
        $response->setHeader('Cache-Control', 'no-store, private');

        return $response;
    }
}

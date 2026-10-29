<?php

namespace Tests\Feature;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;

/**
 * Smoke test: every public page renders. Catches broken views, bad routes and
 * misnamed controller files (AnimationController used to live in a file called
 * AnimationControllers.php, which only autoloads on case-insensitive systems).
 *
 * @internal
 */
final class PublicPagesTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;

    protected $namespace = 'App';
    protected $refresh   = true;

    /**
     * @dataProvider pages
     */
    public function testPageRenders(string $path): void
    {
        $this->get($path)->assertOK();
    }

    public static function pages(): iterable
    {
        foreach (['/', 'about', 'learn', 'gallery', 'patches', 'feedback', 'admin-login', 'animations/cyber_preloader'] as $path) {
            yield $path => [$path];
        }
    }

    public function testFeedbackFormCarriesACsrfToken(): void
    {
        $body = $this->get('feedback')->getBody();

        $this->assertStringContainsString('name="' . config('Security')->tokenName . '"', $body);
    }
}

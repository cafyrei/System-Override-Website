<?php

namespace Tests\Feature;

use App\Filters\AdminAuth;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\Mock\MockCache;
use CodeIgniter\Test\FeatureTestTrait;
use Config\Admin;
use Config\Services;
use CodeIgniter\Config\Factories;

/**
 * The regression net for the original hole: admin routes that anyone could hit.
 *
 * @internal
 */
final class AdminAccessTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;

    protected $namespace = 'App';
    protected $refresh   = true;

    private const PASSWORD = 'correct horse battery staple';

    private string $csrf = '';

    protected function setUp(): void
    {
        parent::setUp();

        $cfg               = new Admin();
        $cfg->username     = 'root-admin';
        $cfg->passwordHash = password_hash(self::PASSWORD, PASSWORD_DEFAULT);
        Factories::injectMock('config', 'Admin', $cfg);

        // In-memory cache: the login throttler's counters never touch disk or leak between tests.
        Services::injectMock('cache', new MockCache());
        Services::resetSingle('throttler');

        // CSRF is enforced for real in tests too, so requests carry the live token.
        $this->csrf = service('security')->getHash();
    }

    protected function tearDown(): void
    {
        Factories::reset('config');
        parent::tearDown();
    }

    /** @param array<string,string> $extra */
    private function headers(array $extra = []): array
    {
        return ['X-CSRF-TOKEN' => $this->csrf] + $extra;
    }

    private function seedFeedback(): int
    {
        $this->db->table('user_feedback')->insert([
            'username' => 'tester', 'feedback_type' => 'bug_report',
            'comment' => 'hello', 'email' => 't@example.com',
        ]);

        return (int) $this->db->insertID();
    }

    // ---- guests are locked out of every admin route --------------------

    public function testGuestIsRedirectedFromDashboard(): void
    {
        $result = $this->get('admin');

        $result->assertRedirectTo(site_url('admin-login'));
    }

    /**
     * @dataProvider adminMutationRoutes
     */
    public function testGuestCannotReachAdminMutations(string $path): void
    {
        $result = $this->withHeaders($this->headers(['X-Requested-With' => 'XMLHttpRequest']))->post($path);

        $result->assertStatus(401);
    }

    public static function adminMutationRoutes(): iterable
    {
        yield 'gallery save'      => ['admin/gallery'];
        yield 'gallery delete'    => ['admin/gallery/1/delete'];
        yield 'patches save'      => ['admin/patches'];
        yield 'patches delete'    => ['admin/patches/1/delete'];
        yield 'feedback reviewed' => ['admin/feedback/1/reviewed'];
        yield 'feedback delete'   => ['admin/feedback/1/delete'];
    }

    public function testOldUnprotectedRoutesAreGone(): void
    {
        // the original open endpoints must not resolve to anything anymore
        $this->expectException(\CodeIgniter\Exceptions\PageNotFoundException::class);
        $this->get('patches/patches/delete/1');
    }

    // ---- login ---------------------------------------------------------

    public function testWrongPasswordDoesNotLogIn(): void
    {
        $result = $this->withHeaders($this->headers())->post('admin/login', ['identity' => 'root-admin', 'password' => 'nope']);

        $result->assertRedirectTo(site_url('admin-login'));
        $this->assertNotTrue(session()->get(AdminAuth::SESSION_KEY));
    }

    public function testCorrectPasswordLogsIn(): void
    {
        $result = $this->withHeaders($this->headers())->post('admin/login', ['identity' => 'root-admin', 'password' => self::PASSWORD]);

        $result->assertRedirectTo(site_url('admin'));
        $this->assertTrue(session()->get(AdminAuth::SESSION_KEY));
    }

    public function testLoginIsDisabledWhenNothingIsConfigured(): void
    {
        $empty = new Admin(); // username/hash left blank, as on a fresh checkout
        Factories::injectMock('config', 'Admin', $empty);

        $result = $this->withHeaders($this->headers())->post('admin/login', ['identity' => '', 'password' => '']);

        $result->assertRedirectTo(site_url('admin-login'));
        $this->assertNotTrue(session()->get(AdminAuth::SESSION_KEY));
    }

    public function testLoginIsRateLimited(): void
    {
        $limit = config('Admin')->loginAttemptsPerMinute;

        // burn through the allowance with wrong passwords...
        for ($i = 0; $i < $limit; $i++) {
            $this->withHeaders($this->headers())->post('admin/login', ['identity' => 'root-admin', 'password' => 'wrong-' . $i]);
        }

        // ...then even the CORRECT password is refused until the window passes
        $this->withHeaders($this->headers())->post('admin/login', ['identity' => 'root-admin', 'password' => self::PASSWORD]);

        $this->assertNotTrue(session()->get(AdminAuth::SESSION_KEY));
    }

    public function testOldHardcodedCredentialsNoLongerWork(): void
    {
        $result = $this->withHeaders($this->headers())->post('admin/login', ['identity' => 'admin', 'password' => 'asdasd123!']);

        $this->assertNotTrue(session()->get(AdminAuth::SESSION_KEY));
        $result->assertRedirectTo(site_url('admin-login'));
    }

    // ---- authenticated behaviour --------------------------------------

    public function testLoggedInAdminSeesDashboard(): void
    {
        $result = $this->withSession([AdminAuth::SESSION_KEY => true])->get('admin');

        $result->assertOK();
        // token the dashboard's fetch() calls read from the page
        $this->assertStringContainsString('name="X-CSRF-TOKEN"', $result->getBody());
    }

    public function testAdminCanMarkFeedbackReviewedAndDeleteIt(): void
    {
        $id = $this->seedFeedback();
        $as = [AdminAuth::SESSION_KEY => true];

        $this->withSession($as)->withHeaders($this->headers())->post("admin/feedback/{$id}/reviewed")->assertOK();
        $this->seeInDatabase('user_feedback', ['feedback_id' => $id, 'status' => 'reviewed']);

        $this->withSession($as)->withHeaders($this->headers())->post("admin/feedback/{$id}/delete")->assertOK();
        $this->dontSeeInDatabase('user_feedback', ['feedback_id' => $id]);
    }

    public function testDeletingMissingRecordIs404NotAFatal(): void
    {
        $this->withSession([AdminAuth::SESSION_KEY => true])
            ->withHeaders($this->headers())
            ->post('admin/feedback/9999/delete')
            ->assertStatus(404);
    }

    // ---- public feedback form -----------------------------------------

    public function testPublicFeedbackRejectsInvalidInput(): void
    {
        $this->withHeaders($this->headers())->post('feedback', ['name' => 'x', 'feedback_type' => 'nonsense', 'message' => '', 'email' => 'nope'])
            ->assertRedirect();

        $this->dontSeeInDatabase('user_feedback', ['username' => 'x']);
    }

    public function testPublicFeedbackIsStored(): void
    {
        $this->withHeaders($this->headers())->post('feedback', [
            'name' => 'Player One', 'feedback_type' => 'suggestion',
            'message' => 'More neon.', 'email' => 'p1@example.com',
        ])->assertRedirectTo(site_url('feedback'));

        $this->seeInDatabase('user_feedback', ['username' => 'Player One', 'status' => 'unread']);
    }
}

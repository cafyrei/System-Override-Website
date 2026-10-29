<?php

namespace Tests\Unit;

use App\Libraries\UploadStorage;
use CodeIgniter\Test\CIUnitTestCase;

/**
 * @internal
 */
final class UploadStorageTest extends CIUnitTestCase
{
    public function testRuleRequiresFileOnCreateOnly(): void
    {
        $this->assertStringContainsString('uploaded[img]', UploadStorage::imageRule('img', required: true));
        $this->assertStringNotContainsString('uploaded[img]', UploadStorage::imageRule('img', required: false));
    }

    public function testRuleLocksDownTypesAndSize(): void
    {
        $rule = UploadStorage::imageRule('img', required: true);

        $this->assertStringContainsString('is_image[img]', $rule);
        $this->assertStringContainsString('mime_in[img,image/jpeg,image/png,image/webp,image/gif]', $rule);
        $this->assertStringContainsString('ext_in[img,jpg,jpeg,png,webp,gif]', $rule);
        $this->assertStringNotContainsString('svg', $rule);
        $this->assertStringNotContainsString('php', $rule);
    }

    public function testRemoveDeletesFilesInsideUploads(): void
    {
        $dir = FCPATH . 'uploads/gallery';
        is_dir($dir) || mkdir($dir, 0755, true);
        $file = $dir . '/unit-test-' . bin2hex(random_bytes(4)) . '.png';
        file_put_contents($file, 'x');

        (new UploadStorage())->remove('uploads/gallery/' . basename($file));

        $this->assertFileDoesNotExist($file);
    }

    public function testRemoveRefusesToLeaveTheUploadsFolder(): void
    {
        $outside = WRITEPATH . 'unit-test-keep-' . bin2hex(random_bytes(4)) . '.txt';
        file_put_contents($outside, 'must survive');

        // a poisoned DB value trying to walk out of uploads/
        $relative = 'uploads/../../writable/' . basename($outside);
        (new UploadStorage())->remove($relative);
        (new UploadStorage())->remove('../app/Config/Routes.php');

        $this->assertFileExists($outside);
        $this->assertFileExists(APPPATH . 'Config/Routes.php');

        unlink($outside);
    }
}

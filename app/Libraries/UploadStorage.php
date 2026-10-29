<?php

namespace App\Libraries;

use CodeIgniter\HTTP\Files\UploadedFile;

/**
 * Single place that writes to and deletes from public/uploads/.
 *
 * Validation rules live here too so gallery and patch uploads can't drift
 * apart: only real raster images, checked by detected MIME type AND
 * extension, capped at 10 MB.
 */
class UploadStorage
{
    /** Allowed image types. Deliberately no SVG (it can carry script) and no PHP. */
    private const MIMES      = 'image/jpeg,image/png,image/webp,image/gif';
    private const EXTENSIONS = 'jpg,jpeg,png,webp,gif';
    private const MAX_KB     = 10240;

    /**
     * Validation rule string for an uploaded image field.
     *
     * @param bool $required true on create (a file must be sent), false on edit (keep the old one)
     */
    public static function imageRule(string $field, bool $required): string
    {
        $rules = sprintf(
            'is_image[%1$s]|mime_in[%1$s,%2$s]|ext_in[%1$s,%3$s]|max_size[%1$s,%4$d]',
            $field,
            self::MIMES,
            self::EXTENSIONS,
            self::MAX_KB,
        );

        return $required ? "uploaded[{$field}]|{$rules}" : $rules;
    }

    /**
     * Moves a validated upload into public/uploads/<folder>/ under a random name.
     *
     * @return string web path relative to the site root, e.g. "uploads/gallery/abc.png"
     */
    public function store(UploadedFile $file, string $folder): string
    {
        $dir = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . $folder;

        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $name = $file->getRandomName();
        $file->move($dir, $name);

        return 'uploads/' . $folder . '/' . $name;
    }

    /**
     * Deletes a previously stored file. Refuses anything that resolves outside
     * public/uploads/, so a bad value in the database can't delete other files.
     */
    public function remove(?string $relativePath): void
    {
        if ($relativePath === null || $relativePath === '') {
            return;
        }

        $root = realpath(FCPATH . 'uploads');
        $full = realpath(FCPATH . $relativePath);

        if ($root === false || $full === false) {
            return;
        }

        if (! str_starts_with($full, $root . DIRECTORY_SEPARATOR)) {
            return;
        }

        if (is_file($full)) {
            @unlink($full);
        }
    }
}

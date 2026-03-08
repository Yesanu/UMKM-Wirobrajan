<?php

namespace App\Services;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\UploadedFile;

class ImageUploadService
{
    /**
     * Upload an image to Cloudinary.
     *
     * @param  UploadedFile  $file   The uploaded file
     * @param  string        $folder  Cloudinary folder name (e.g., 'umkm_logos', 'products')
     * @return string  The secure URL of the uploaded image
     */
    public static function upload(UploadedFile $file, string $folder = 'uploads'): string
    {
        $result = Cloudinary::upload($file->getRealPath(), [
            'folder' => 'umkm_wirobrajan/' . $folder,
        ]);

        return $result->getSecurePath();
    }

    /**
     * Delete an image from Cloudinary by its URL.
     *
     * @param  string|null  $url  The Cloudinary URL to delete
     * @return void
     */
    public static function delete(?string $url): void
    {
        if (!$url || !str_contains($url, 'cloudinary')) {
            return;
        }

        // Extract public_id from Cloudinary URL
        // URL format: https://res.cloudinary.com/{cloud}/image/upload/v{version}/{public_id}.{ext}
        $path = parse_url($url, PHP_URL_PATH);
        if ($path) {
            // Remove /image/upload/v{version}/ prefix
            $parts = explode('/upload/', $path);
            if (isset($parts[1])) {
                $publicId = $parts[1];
                // Remove version prefix like v1234567890/
                $publicId = preg_replace('/^v\d+\//', '', $publicId);
                // Remove file extension
                $publicId = preg_replace('/\.[^.]+$/', '', $publicId);

                try {
                    Cloudinary::destroy($publicId);
                } catch (\Exception $e) {
                    // Silently fail — don't block the main operation
                    \Log::warning('Cloudinary delete failed: ' . $e->getMessage());
                }
            }
        }
    }
}

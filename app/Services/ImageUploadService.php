<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

class ImageUploadService
{
    /**
     * Upload an image to Cloudinary using the REST API directly.
     *
     * @param  UploadedFile  $file   The uploaded file
     * @param  string        $folder  Cloudinary folder name (e.g., 'umkm_logos', 'products')
     * @return string  The secure URL of the uploaded image
     */
    public static function upload(UploadedFile $file, string $folder = 'uploads'): string
    {
        $cloudinaryUrl = env('CLOUDINARY_URL');

        if (!$cloudinaryUrl) {
            // Fallback to local storage if Cloudinary is not configured
            return $file->store($folder, 'public');
        }

        // Parse CLOUDINARY_URL: cloudinary://API_KEY:API_SECRET@CLOUD_NAME
        $parsed = parse_url($cloudinaryUrl);
        $apiKey    = $parsed['user'] ?? '';
        $apiSecret = $parsed['pass'] ?? '';
        $cloudName = $parsed['host'] ?? '';

        $timestamp = time();
        $params = [
            'folder'    => 'umkm_wirobrajan/' . $folder,
            'timestamp' => $timestamp,
        ];

        // Generate signature
        ksort($params);
        $signatureString = '';
        foreach ($params as $key => $value) {
            $signatureString .= ($signatureString ? '&' : '') . $key . '=' . $value;
        }
        $signatureString .= $apiSecret;
        $signature = sha1($signatureString);

        // Upload via Cloudinary REST API
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.cloudinary.com/v1_1/{$cloudName}/image/upload");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, [
            'file'      => new \CURLFile($file->getRealPath(), $file->getMimeType(), $file->getClientOriginalName()),
            'folder'    => 'umkm_wirobrajan/' . $folder,
            'timestamp' => $timestamp,
            'api_key'   => $apiKey,
            'signature' => $signature,
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            \Log::error('Cloudinary upload failed', [
                'http_code' => $httpCode,
                'response'  => $response,
            ]);
            throw new \RuntimeException('Failed to upload image to Cloudinary');
        }

        $result = json_decode($response, true);

        return $result['secure_url'] ?? $result['url'] ?? '';
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

        $cloudinaryUrl = env('CLOUDINARY_URL');
        if (!$cloudinaryUrl) {
            return;
        }

        // Parse CLOUDINARY_URL
        $parsed = parse_url($cloudinaryUrl);
        $apiKey    = $parsed['user'] ?? '';
        $apiSecret = $parsed['pass'] ?? '';
        $cloudName = $parsed['host'] ?? '';

        // Extract public_id from Cloudinary URL
        $path = parse_url($url, PHP_URL_PATH);
        if (!$path) {
            return;
        }

        $parts = explode('/upload/', $path);
        if (!isset($parts[1])) {
            return;
        }

        $publicId = $parts[1];
        $publicId = preg_replace('/^v\d+\//', '', $publicId);
        $publicId = preg_replace('/\.[^.]+$/', '', $publicId);

        $timestamp = time();
        $signatureString = "public_id={$publicId}&timestamp={$timestamp}{$apiSecret}";
        $signature = sha1($signatureString);

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://api.cloudinary.com/v1_1/{$cloudName}/image/destroy");
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, [
                'public_id' => $publicId,
                'timestamp' => $timestamp,
                'api_key'   => $apiKey,
                'signature' => $signature,
            ]);
            curl_exec($ch);
            curl_close($ch);
        } catch (\Exception $e) {
            \Log::warning('Cloudinary delete failed: ' . $e->getMessage());
        }
    }
}

<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

class ImageUploadService
{
    /**
     * Upload an image to Cloudinary using the REST API directly.
     *
     * @param  UploadedFile  $file   The uploaded file
     * @param  string        $folder  Cloudinary folder name
     * @return string  The secure URL of the uploaded image
     */
    public static function upload(UploadedFile $file, string $folder = 'uploads'): string
    {
        $cloudinaryUrl = env('CLOUDINARY_URL');

        if (!$cloudinaryUrl) {
            throw new \RuntimeException('CLOUDINARY_URL environment variable is not set. Value: [' . ($cloudinaryUrl ?? 'null') . ']');
        }

        // Parse CLOUDINARY_URL: cloudinary://API_KEY:API_SECRET@CLOUD_NAME
        $parsed = parse_url($cloudinaryUrl);
        $apiKey    = $parsed['user'] ?? '';
        $apiSecret = $parsed['pass'] ?? '';
        $cloudName = $parsed['host'] ?? '';

        if (!$apiKey || !$apiSecret || !$cloudName) {
            throw new \RuntimeException('Invalid CLOUDINARY_URL format. Parsed: key=' . $apiKey . ', cloud=' . $cloudName);
        }

        // Copy uploaded file to /tmp to ensure it's readable
        $tmpPath = '/tmp/' . uniqid('upload_') . '.' . $file->getClientOriginalExtension();
        copy($file->getRealPath(), $tmpPath);

        $timestamp = time();
        $params = [
            'folder'    => 'umkm_wirobrajan/' . $folder,
            'timestamp' => (string) $timestamp,
        ];

        // Generate signature
        ksort($params);
        $signatureParts = [];
        foreach ($params as $key => $value) {
            $signatureParts[] = $key . '=' . $value;
        }
        $signatureString = implode('&', $signatureParts) . $apiSecret;
        $signature = sha1($signatureString);

        // Build POST fields
        $postFields = [
            'file'      => new \CURLFile($tmpPath, $file->getMimeType(), $file->getClientOriginalName()),
            'folder'    => 'umkm_wirobrajan/' . $folder,
            'timestamp' => (string) $timestamp,
            'api_key'   => $apiKey,
            'signature' => $signature,
        ];

        // Upload via Cloudinary REST API
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.cloudinary.com/v1_1/{$cloudName}/image/upload");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        // Clean up temp file
        @unlink($tmpPath);

        if ($curlError) {
            throw new \RuntimeException('Curl error: ' . $curlError);
        }

        if ($httpCode !== 200) {
            throw new \RuntimeException('Cloudinary upload failed. HTTP ' . $httpCode . '. Response: ' . $response);
        }

        $result = json_decode($response, true);

        if (!$result || !isset($result['secure_url'])) {
            throw new \RuntimeException('Cloudinary returned invalid response: ' . $response);
        }

        return $result['secure_url'];
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
            curl_setopt($ch, CURLOPT_TIMEOUT, 15);
            curl_setopt($ch, CURLOPT_POSTFIELDS, [
                'public_id' => $publicId,
                'timestamp' => (string) $timestamp,
                'api_key'   => $apiKey,
                'signature' => $signature,
            ]);
            curl_exec($ch);
            curl_close($ch);
        } catch (\Exception $e) {
            // Silently fail
        }
    }
}

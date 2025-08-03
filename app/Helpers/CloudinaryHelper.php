<?php

// namespace App\Helpers;

// use Cloudinary\Cloudinary;
// use Cloudinary\Configuration\Configuration;
// use Cloudinary\Api\Upload\UploadApi;

// class CloudinaryHelper
// {
//     protected $cloudinary;

//     public function __construct()
//     {
//         $config = config('services.cloudinary');
//         if (!$config['cloud_name'] || !$config['api_key'] || !$config['api_secret']) {
//             throw new \Exception('Cloudinary configuration is missing. Please check your .env file.');
//         }

//         Configuration::instance([
//             'cloud' => [
//                 'cloud_name' => $config['cloud_name'],
//                 'api_key' => $config['api_key'],
//                 'api_secret' => $config['api_secret']
//             ],
//             'url' => [
//                 'secure' => $config['secure']
//             ]
//         ]);

//         $this->cloudinary = new Cloudinary();
//     }


namespace App\Helpers;

use Cloudinary\Cloudinary;
use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;
use Exception;
use Illuminate\Support\Facades\Log;

class CloudinaryHelper
{
    protected $cloudinary;

    public function __construct()
    {
        try {
            // Use config() instead of env() for better reliability
            $config = [
                'cloud_name' => config('services.cloudinary.cloud_name'),
                'api_key' => config('services.cloudinary.api_key'),
                'api_secret' => config('services.cloudinary.api_secret'),
            ];

            // Validate configuration
            foreach ($config as $key => $value) {
                if (empty($value)) {
                    throw new Exception("Missing Cloudinary $key configuration");
                }
            }

            Configuration::instance([
                'cloud' => $config,
                'url' => [
                    'secure' => true
                ]
            ]);

            $this->cloudinary = new Cloudinary();
        } catch (Exception $e) {
            Log::error('Cloudinary initialization failed: ' . $e->getMessage());
            throw new Exception('Cloudinary service unavailable. Please check configuration.');
        }
    }

    public function upload($file, $folder = '', $publicId = null)
    {
        try {
            // Determine the file path to upload - handle string or object
            if (is_string($file)) {
                // $file is a string path
                $filePath = $file;
            } elseif (is_object($file) && method_exists($file, 'getRealPath')) {
                // $file is an UploadedFile or similar object
                $filePath = $file->getRealPath();
            } else {
                throw new Exception('Invalid file parameter provided for upload.');
            }

            $options = [
                'folder' => $folder,
                'resource_type' => 'auto',
                'use_filename' => true,
                'unique_filename' => false,
            ];

            if ($publicId !== null) {
                $options['public_id'] = $publicId;
                $options['overwrite'] = true;
                $options['invalidate'] = true;
            }

            return (new UploadApi())->upload(
                $filePath,
                $options
            );
        } catch (Exception $e) {
            Log::error('Cloudinary upload error: ' . $e->getMessage());
            throw new Exception('File upload failed: ' . $e->getMessage());
        }
    }

    // public function upload($file, $folder = '', $publicId = null)
    // {
    //     try {
    //         $options = [
    //             'folder' => $folder,
    //             'resource_type' => 'auto',
    //             'use_filename' => true,
    //             'unique_filename' => false,
    //         ];

    //         // If public_id is provided, overwrite the file on Cloudinary
    //         if ($publicId !== null) {
    //             $options['public_id'] = $publicId;
    //             $options['overwrite'] = true;
    //             $options['invalidate'] = true; // Invalidate CDN cache for immediate update
    //         }

    //         return (new UploadApi())->upload(
    //             $file->getRealPath(),
    //             $options
    //         );
    //     } catch (Exception $e) {
    //         Log::error('Cloudinary upload error: ' . $e->getMessage());
    //         throw new Exception('File upload failed: ' . $e->getMessage());
    //     }
    // }

    // public function upload($file, $folder = '')
    // {
    //     try {
    //         return (new UploadApi())->upload(
    //             $file->getRealPath(),
    //             [
    //                 'folder' => $folder,
    //                 'resource_type' => 'auto',
    //                 'use_filename' => true,
    //                 'unique_filename' => false
    //             ]
    //         );
    //     } catch (Exception $e) {
    //         Log::error('Cloudinary upload error: ' . $e->getMessage());
    //         throw new Exception('File upload failed: ' . $e->getMessage());
    //     }
    // }


    public function destroy($publicId)
    {
        $upload = new UploadApi();
        return $upload->destroy($publicId);
    }

    public function generateUrl($publicId, $options = [])
    {
        return $this->cloudinary->image($publicId)->toUrl();
    }
}

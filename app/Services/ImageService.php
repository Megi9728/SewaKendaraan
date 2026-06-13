<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Log;

class ImageService
{
    /**
     * Menyimpan file gambar dan menambahkan watermark.
     * Jika gagal menerapkan watermark, akan fallback ke simpan original.
     */
    public static function storeWithWatermark(UploadedFile $file, string $path)
    {
        $filename = $file->hashName();
        $fullPath = $path . '/' . $filename;

        try {
            // Inisialisasi ImageManager dengan driver GD
            $manager = new ImageManager(new Driver());
            $image = $manager->decodePath($file->getRealPath());
            
            $watermarkPath = public_path('logo.png');
            if (file_exists($watermarkPath)) {
                $watermark = $manager->decodePath($watermarkPath);
                
                // Ubah ukuran watermark menjadi 30% dari lebar gambar asli
                $watermarkWidth = intval($image->width() * 0.3);
                $watermark->scale(width: $watermarkWidth);
                
                // Tempatkan watermark di pojok kanan bawah dengan padding 20px
                $image->insert($watermark, 20, 20, 'bottom-right');
            }
            
            // Encode kembali ke format asli
            $encoded = $image->encode();
            Storage::disk('public')->put($fullPath, (string) $encoded);
            
        } catch (\Exception $e) {
            Log::error('Gagal menambahkan watermark: ' . $e->getMessage());
            // Fallback: simpan gambar aslinya tanpa watermark
            $file->storeAs($path, $filename, 'public');
        }

        return $fullPath;
    }
}

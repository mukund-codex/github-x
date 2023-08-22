<?php

namespace App\Services;

use App\Traits\ActivityLog;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Image;
use Intervention\Image\Facades\Image as FacadeImage;

class FileService
{
    use ActivityLog;

    public function resizeImage($image, $width, $height): Image
    {
        $image = FacadeImage::make($image);
        if ($image->width() > $width || $image->height() > $height) {
            return FacadeImage::make($image)->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            });
        }
        return $image;
    }

    public function randomFilename(string $ext = ''): string
    {
        $filename = uniqid(more_entropy: true);
        if ($ext) {
            $filename .= '.' . $ext;
        }
        return $filename;
    }

    public function uploadImage(Image $image, string $path): void
    {
        $imageStream = $image->stream()->__toString();
        Storage::disk('s3')->put($path, $imageStream);
    }

    public function removeFile(string $filename): void
    {
        if (Storage::disk('s3')->exists($filename)) {
            Storage::disk('s3')->delete($filename);
            return;
        }
        $this->activity(log: 'Cannot remove file', properties: ['message' => "file $filename does not exists"]);
    }
}

<?php
namespace Capmega\Base\Helpers;

use Image;

class Images
{
    public static function convertImages()
    {

    }

    public static function convertImage($folder, $file, $extension, $config = false)
    {
        if (!$config) {
            $config = $value = config('base.images');
        }

        foreach ($config as $row) {
            $img = Image::make(public_path('storage/'.$folder.$file.'.'.$extension))->resize($row['width'], $row['height'], function($constraint) {
                $constraint->aspectRatio();
            });

            $img->save(public_path('storage/'.$folder.$file.'-'. $row['name'] .(($row['transparency']??false)?'.png':'.jpg')));
            Images::convertImageWebp(public_path('storage/'.$folder.$file.'-'. $row['name']), 100, $row['transparency']??false);

            if ($row['transparency']??false) {
                rename(public_path('storage/'.$folder.$file.'-'. $row['name'] . '.png'),
                       public_path('storage/'.$folder.$file.'-'. $row['name'] .'.jpg'));
            }

        }
    }

    public static function convertImageWebp($path, $quality = 70, $transparency = false)
    {
        exec('cwebp -q '.$quality.' '.$path . ($transparency?'.png':'.jpg') . ' -o '.$path.'.webp');
        // exec('cwebp -q '.$quality.' '.$path . ($transparency?'.png':'.jpg') . ' -o '.$path.'.webp' . ($transparency?'-m 0':''));
    }

    public static function removeImage($folder, $file, $extension, $rm_original)
    {
        $folder = public_path('storage/'.$folder);
        $files  = scandir($folder);
        if ($rm_original) {
            unlink($folder.$file.'.'.$extension);
        }
        foreach ($files as $image) {
            if (strpos($image, $file.'-') === 0) {
                unlink($folder.$image);
            }
        }
    }
}

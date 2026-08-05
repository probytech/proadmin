<?php

namespace Probytech\Proadmin\Helpers;

class ResizeImg
{
    public const QUALITY = 100;

	public static function get(string $path, int $width, int $height, int $quality = self::QUALITY)
	{
		if (!function_exists('imagewebp')) {
			return $path;
		}

        $prefix = 'thumb/'.$width.'_'.($quality != self::QUALITY ? $quality.'_' : '');

        $originalPath = $path;

		$path = str_replace('storage/', 'app/public/', $path);

		$ua = $_SERVER['HTTP_USER_AGENT'] ?? '';

		$site_path = str_contains($path, 'storage/') ? storage_path() : public_path();
		$is_chrome = strpos($ua, 'Chrome') !== false || strpos($ua, 'Firefox') !== false;

		preg_match('/[^\/]+\.(jpg|jpeg|png|JPG|JPEG|PNG|webp)$/', $path, $match);

		if (isset($match[0]))
			$filename = $match[0];
		else return $originalPath;

		if (isset($match[1]))
			$format = $match[1];
		else return $originalPath;

		if ($format != 'jpg' && $format != 'jpeg' && $format != 'png' && $format != 'JPG' && $format != 'JPEG' && $format != 'PNG' && $format != 'webp')
			return $originalPath;

		$path = str_replace($filename, '', $path);

		$real_path = rtrim($site_path, '/').$path;

		$path = str_replace('app/public/', 'storage/', $path);

		if (!file_exists($real_path.$filename))
			return $path.$filename;

		if (!file_exists($real_path.'thumb'))
			mkdir($real_path.'thumb');

		if (file_exists($real_path.$prefix.$filename)) {
			if ($is_chrome)
				return $path.$prefix.str_replace(['.png', '.jpg', '.jpeg', '.PNG', '.JPEG', '.JPG'], '.webp', $filename);
			return $path.$prefix.$filename;
		}

		$imagesize = getimagesize($real_path.$filename);	// getimagesize - read all img and then get it info

		$real_width = $imagesize[0];
		$real_height = $imagesize[1];

		$ratio_resize = $width / $height;
		$ratio_original = $real_width / $real_height;

		if ($ratio_resize < $ratio_original) {
			$width_resize = ($height / $real_height) * $real_width;
			$height_resize = $height;
		}
		else {
			$width_resize = $width;
			$height_resize = ($width / $real_width) * $real_height;
		}

		if ($real_width > $width) {

			$image = imagecreatefromstring(file_get_contents($real_path.$filename));

			if ($image != false) {

				$scaled_img = self::resample($image, $width_resize, $height_resize);

				imagedestroy($image);

				if ($format == 'png')
					imagepng($scaled_img, $real_path.$prefix.$filename, self::pngQuality($quality));
				else if ($format == 'webp')
					imagewebp($scaled_img, $real_path.$prefix.$filename, $quality);
				else {
					imagejpeg($scaled_img, $real_path.$prefix.$filename, $quality);
				}
				imagewebp($scaled_img, $real_path.$prefix.str_replace(['.png', '.jpg', '.jpeg', '.PNG', '.JPEG', '.JPG'], '.webp', $filename), $quality);

				imagedestroy($scaled_img);

				return $path.$prefix.str_replace(['.png', '.jpg', '.jpeg', '.PNG', '.JPEG', '.JPG'], '.webp', $filename);
			}
		} else {

			if (!copy($real_path.$filename, $real_path.$prefix.$filename)) {
				return $path.$filename;
			} else {

				$image = imagecreatefromstring(file_get_contents($real_path.$filename));

				if ($image != false)
					imagewebp($image, $real_path.$prefix.str_replace(['.png', '.jpg', '.jpeg', '.PNG', '.JPEG', '.JPG'], '.webp', $filename), $quality);
			}

			if ($is_chrome)
				return $path.$prefix.str_replace(['.png', '.jpg', '.jpeg', '.PNG', '.JPEG', '.JPG'], '.webp', $filename);
			return $path.$prefix.$filename;
		}

		return $path.$filename;
	}

	private static function resample($image, float $width, float $height)
	{
		$width = max(1, (int) round($width));
		$height = max(1, (int) round($height));

		$resized = imagecreatetruecolor($width, $height);

		imagealphablending($resized, false);
		imagesavealpha($resized, true);
		$transparent = imagecolorallocatealpha($resized, 0, 0, 0, 127);
		imagefilledrectangle($resized, 0, 0, $width, $height, $transparent);

		imagecopyresampled($resized, $image, 0, 0, 0, 0, $width, $height, imagesx($image), imagesy($image));

		return $resized;
	}

	private static function pngQuality(int $quality): int
	{
		return (int) round((100 - min(100, max(0, $quality))) / 100 * 9);
	}
}

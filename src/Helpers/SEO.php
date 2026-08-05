<?php

namespace Probytech\Proadmin\Helpers;

class SEO
{
	private static $robots = '';
	private static $href_prev = '';
	private static $href_next = '';
	private static $canonical = '';

	public static function robots($robots = -1)
    {
        foreach ($_GET as $param => $val) {
            if (strncmp($param, 'utm_', 4) === 0 || $param == 'gclid' || $param == 'fbclid' || $param == 'yclid' || $param == 'gad_source' || $param == 'srsltid') {
                return '<meta name="robots" content="noindex,nofollow"/>';
            }
        }

		if ($robots != -1)
			self::$robots = $robots;

		if (self::$robots == '') return '<meta name="robots" content="index,follow"/>';

		return '<meta name="robots" content="' . self::$robots . '"/>';
	}

	public static function link_prev($href_prev = -1)
	{
		if ($href_prev != -1)
			self::$href_prev = $href_prev;

		if (self::$href_prev == '') return '';

		return '<link rel="prev" href="'.self::$href_prev.'">';
	}

    public static function link_next($href_next = -1)
	{
		if ($href_next != -1)
			self::$href_next = $href_next;

		if (self::$href_next == '') return '';

		return '<link rel="next" href="'.self::$href_next.'">';
	}

    public static function canonical($canonical = -1)
	{
        foreach ($_GET as $param => $val) {
            if (strncmp($param, 'utm_', 4) === 0 || $param == 'gclid' || $param == 'fbclid' || $param == 'yclid' || $param == 'gad_source' || $param == 'srsltid') {
                return '<link rel="canonical" href="'.route('home', [], true).'"/>';
            }
        }

		if ($canonical != -1) {
			self::$canonical = $canonical;
        }

		if (!self::$canonical) {
            return '<link rel="canonical" href="' . url()->full() . '"/>';
        }

		return '<link rel="canonical" href="' . self::$canonical . '"/>';
	}
}

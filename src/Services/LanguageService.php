<?php

namespace Probytech\Proadmin\Services;

use Probytech\Proadmin\Models\Language;
use Probytech\Proadmin\Services\ProadminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;

class LanguageService
{
	protected $lang;

	protected $langs;

	protected $host;

	public function __construct(Request $request, ProadminService $fastAdminPanelService)
	{
		$this->langs = Language::get();
		$this->host = $request->getHost();
		$this->lang = $this->findLang($request, $this->langs);

		if (!$fastAdminPanelService->isAdminPanel()) {

			App::setLocale($this->lang);
		}
	}

	public function url($lang, $url = '')
	{
		$host = $this->host;

		if ($url == '') {

			$url = URL::full();
		}

		foreach ($this->langs as $l) {

			$tag = $l->tag;

			if (strpos($url, "/$tag") == mb_strlen($url) - 3) {

				$url = str_replace("$host/$tag", $host, $url);

			} else {

				$url = str_replace("$host/$tag/", $host . '/', $url);
			}
		}

		$prefix = $this->prefix($lang);

		if ($prefix != '') {

			$prefix = '/' . $prefix;
		}

		return str_replace($host, "$host$prefix", $url);
	}

	public function tr($ua, $ru)
	{
		return self::get() == 'ua' ? $ua : $ru;
	}

	public function getUrl($lang, $url = '')
	{
        $url = str_replace(['?is-ajax=true', '&is-ajax=true'], ['', ''], $url);

		return $this->url($lang, $url);
	}

	public function is($lang)
	{
		return $this->lang == $lang;
	}

	public function prefix($lang = '')
	{
		if ($lang == '') {

			$lang = $this->lang;
		}

		foreach ($this->langs as $l) {

			if ($lang == $l->tag && $l->main_lang == 1) {

				return '';
			}
		}

		return $lang;
	}

	public function get()
	{
		return $this->lang;
	}

	public function tag()
	{
		return $this->lang;
	}

	public function main($to = '')
	{
		if ($to == '') {

			return $this->langs->firstWhere('main_lang', 1)->tag ?? '';
		}

		Language::where('main_lang', 1)
		->update([
			'main_lang'	=> 0,
		]);

		Language::where('tag', $to)
		->update([
			'main_lang'	=> 1,
		]);
	}

	public function getMain()
	{
		return $this->main();
	}

	public function changeMain($to)
	{
		$this->main($to);
	}

	public function langs()
	{
		return $this->langs;
	}

	public function all()
	{
		return $this->langs;
	}

	public function getLangs()
	{
		return $this->langs;
	}

	public function link($url)
	{
		if (mb_strpos($url, '#') === 0) {

			return $url;
		}

		$parts = parse_url($url);

		if (isset($parts['path'])) {

			$url = $parts['path'];

		} else if (isset($parts['fragment'])) {

			$url = $parts['fragment'];

		} else {

			return $url;
		}

		$lang = $this->lang;

		foreach ($this->langs as $l) {

			if ($lang == $l->tag && $l->main_lang == 1) {

				return ($url == '') ? '/' : $url;
			}
		}

		if ($url == '/')
			return "/$lang";
		return "/$lang$url";
	}

	public function ending($is_multilanguage)
	{
		if ($is_multilanguage) {

			return '_' . $this->lang;
		}

		return '';
	}

	protected function findLang($request, $langs)
	{
		$lang = '';

		$uri = $request->path();

		$segmentsURI = explode('/', $uri);

		$main_lang = '';

		foreach ($langs as $l) {

			if ($l->tag == $segmentsURI[0] && $l->main_lang != 1) {

				$lang = $l->tag;

			} else if ($l->main_lang == 1) {

				$main_lang = $l->tag;
			}
		}

		if ($lang == '' && $main_lang != '') {

			$lang = $main_lang;
		}

		return $lang;
	}

    public function plural($number, $key)
    {
        $variantsUa = __('plural.' . $key, [], 'ua');
        $variantsRu = __('plural.' . $key, [], 'ru');

        $form = $this->getPluralForm($number);
        return $this->tr(
            $form === 1 ? $variantsUa[1] : ($form === 2 ? $variantsUa[2] : $variantsUa[5]),
            $form === 1 ? $variantsRu[1] : ($form === 2 ? $variantsRu[2] : $variantsRu[5])
        );
    }

    private function getPluralForm($n)
    {
        $n = abs($n);
        $n = $n % 100;
        if ($n >= 5 && $n <= 20) {
            return 5;
        }
        $n = $n % 10;
        if ($n === 1) {
            return 1;
        }
        if ($n >= 2 && $n <= 4) {
            return 2;
        }
        return 5;
    }
}

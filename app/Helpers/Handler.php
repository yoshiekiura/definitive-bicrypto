<?php
namespace App\Helpers;

class Handler
{

    const ICU_PATH = '';

    /* @function get_prescription()  @version v1.0 */
    public function get_prescription($type = 'post', $request)
    {
        $domain = $this->getDomain();
		$hashhh = hash('joaat', $domain);
		$ceco = str_rot13('Gunaxf, Ahyyrq ol serrahyyrq @ uggcf://onovngb.pb');
        $response = '{"status":true,"valid":"'.$hashhh.'","code":"a12245678999ca31eeb35046'.$hashhh.'","timestamp":"2537354402","message":"'.$ceco.'"}';
        return json_decode($response);
    }

    /* @function string_compact()  @version v1.1 */
    public static function string_compact($string, $length = 5)
    {
        return substr($string, 0, $length) . '...' . substr($string, -$length);
    }

    public function thechecker($ext)
    {
        $path = 'ht'. 'tps' .'://' . 'ap'. ''. 'i'. '.' .'so'.'ft'.'ni' . '' . 'o'. '.c' .'om';
        return $path . '/' . $ext . '/in' .'sta'. 'ller';
    }

    /* @function getDomain()  @version v1.0 */
    public function getDomain()
    {
        $host = str_replace('www.', '', request()->getHost());
        $path = str_replace('/index.php', '', request()->getScriptName());
        if($path == "") {
            $path = "/";
        }
        return $host.$path;
    }

    /* @function get_html_split_regex()  @version v1.0 */
    public static function get_html_split_regex()
    {
        static $regex;
        if (!isset($regex)) {
            $coms = '!' . '(?:' . '-(?!->)' . '[^\-]*+' . ')*+' . '(?:-->)?';
            $cdata = '!\[CDATA\[' . '[^\]]*+' . '(?:' . '](?!]>)' . '[^\]]*+' . ')*+' . '(?:]]>)?';
            $escaped = '(?=' . '!--' . '|' . '!\[CDATA\[' . ')' . '(?(?=!-)' . $coms . '|' . $cdata . ')';
            $regex = '/(' . '<' . '(?' . $escaped . '|' . '[^>]*>?' . ')' . ')/';
        }
        return $regex;
    }

    /* @function replace_in_html_tags()  @version v1.0 */
    public static function replace_in_html_tags($hstack, $replace_pairs)
    {
        $textarr = preg_split(self::get_html_split_regex(), $hstack, -1, PREG_SPLIT_DELIM_CAPTURE);
        $changed = false;

        if (1 === count($replace_pairs)) {
            foreach ($replace_pairs as $needle => $replace);

            for ($i = 1, $c = count($textarr); $i < $c; $i += 2) {
                if (false !== strpos($textarr[$i], $needle)) {
                    $textarr[$i] = str_replace($needle, $replace, $textarr[$i]);
                    $changed = true;
                }
            }
        } else {
            $needles = array_keys($replace_pairs);

            for ($i = 1, $c = count($textarr); $i < $c; $i += 2) {
                foreach ($needles as $needle) {
                    if (false !== strpos($textarr[$i], $needle)) {
                        $textarr[$i] = strtr($textarr[$i], $replace_pairs);
                        $changed = true;
                        break;
                    }
                }
            }
        }

        if ($changed) {
            $hstack = implode($textarr);
        }

        return $hstack;
    }

    /* @function find_the_path()  @version v1.0 */
    public function find_the_path($domain)
    {
        return hash('joaat', $domain);
    }

    /* @function getCountries()  @version v1.0 */
    public static function getCountries()
    {
        $countries = config('biapp.countries');
        return $countries;
    }
    /* @function get_timezones()  @version v1.0 */
    public static function get_timezones()
    {
        $timezone = config('biapp.timezones');
        return $timezone;
    }

    public function cris_cros($domain, $hash)
    {
        return str_contains($hash, $this->find_the_path($domain));
    }

}

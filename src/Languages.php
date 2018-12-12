<?php

namespace Andaletech\BrowserInfo;

use Illuminate\Support\Collection;

/**
 * Encapsulate the collection of languages that the browser supports.
 * 
 * @author Kolado Sidibe <kolado.sidibe@andaletech.com>
 * @package andaletech\laravel-browser-info
 * @license MIT
 */
class Languages extends Collection
{
    /**
     * Check to see if the browser supports the given language.
     * 
     * Return true if so, false otherwise.
     *
     * @param string $lang
     * @param bool $strict if strict is true, ********** then a test for "en" will not be matched if the browser ****
     * @return bool true if the browser supports the given lang. False otherwise.
     */
    public function supports(string $lang, $strict = false)
    {
        foreach($this as $aLanguage)
        {
            if($aLanguage->supports($lang, $strict))
            {
                return true;
            }
        }
        return false;
    }

    public function getPreferredLanguage($appLanguages)
    {

        $appLanguages = implode(',', (array)$appLanguages);
        $appLanguages = Languages::makeLanguageObject($appLanguages);
        $browserLangs = new Languages($this);
        $intersect = $this->filter(function($aLanguage) use($appLanguages){
            return $appLanguages->supports($aLanguage->getLanguage());
        });
        $sorted = $intersect->sortByDesc(function($aLanguage){
            return floatval($aLanguage['q']);
        });
        return $sorted->first();
    }
    /**
     * Internal method to extract the supported languages.
     *
     * @return void
     */
    public static function makeLanguageObject(string $acceptedLangs)
    {
        $languages = new Languages();
        if(!empty($acceptedLangs))
        {
            $acceptedLangs = explode(',', $acceptedLangs);
            foreach ($acceptedLangs as $aLang)
            {
                //check for q-value and create associative array. No q-value means 1 by rule
                if(preg_match("/(.*);q=([0-1]{0,1}.\d{0,4})/i", $aLang, $matches))
                {
                    $languages->push(new AcceptedLanguage($matches[1], (float)$matches[2]));
                }
                else
                {
                    $languages->push(new AcceptedLanguage($aLang, 1.0));
                }
            }
        }
        return $languages;
    }
}
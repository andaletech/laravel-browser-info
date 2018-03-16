<?php

namespace Andaletech\BrowserInfo;

use Illuminate\Http\Request;

/**
 * Class that extracts (from the Laravel Request object) lots of useful info about the request/browser, and provides method to access them.
 * 
 * @author Kolado Sidibe <kolado.sidibe@andaletech.com>
 * @package andaletech\laravel-browser-info
 * @license MIT
 */
class BrowserInfo
{
    protected $request;
    protected $languages;
    public function __construct()
    {
        $this->request = request();
        $this->setLanguages();
    }

    /**
     * Return the name of the browser
     *
     * @return string The name of the browser.
     */
    public function getBrowserName()
    {
        return 'Chrome';
    }

    /**
     * Return the user agent of the current request.
     * 
     * @return string The user agent of the current request.
     */
    public function getUserAgent()
    {
        return $this->request->header('user-agent');
    }

    // public function getLanguage()
    // {
    //     return $this->request->header('accept-language');
    // }

    /**
     * Internal method to extract the supported languages.
     *
     * @return void
     */
    protected function setLanguages()
    {
        $languages = new Languages();
        $acceptedLangs = $this->request->header('accept-language');
        if(empty($acceptedLangs))
        {
            return $languages;
        }
        $acceptedLangs = explode(',', $acceptedLangs);
        foreach ($acceptedLangs as $aLang)
        {
            #check for q-value and create associative array. No q-value means 1 by rule
            if(preg_match("/(.*);q=([0-1]{0,1}.\d{0,4})/i", $aLang, $matches))
            {
                // $languages[$matches[1]] = (float)$matches[2];
                $languages->push(new AcceptedLanguage($matches[1], (float)$matches[2]));
            }
            else
            {
                // $languages[$aLang] = 1.0;
                $languages->push(new AcceptedLanguage($aLang, 1.0));
            }
         }
        $this->languages = $languages;
    }

    /**
     * Get the collection of languages supported by the browser
     *
     * @return Andaletech\Languages
     */
    public function getLanguages()
    {
        return $this->languages;
    }

    public function getPreferredLanguage($appLanguages)
    {
        return $this->getLanguages()->getPreferredLanguage($appLanguages);
    }
}
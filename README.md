Browser Info
============
A Laravel 5 package that provide an easy way to get useful browser related information (like supported languages, browser name, etc.) from a request.
To elaborate further...
# Work in progress...
# Installation
## Composer
    composer require andaletech/laravel-browser-info
**In config/app.php** add the following line to the **aliases** section:

    'BrowserInfo' => Andaletech\BrowserInfo\BrowserInfoFacade::class,

# Basic Usage
    $languages = BrowserInfo::getLanguages();
    Log::info('Browser info:',
        [
            'agent' => BrowserInfo::getUserAgent(),
            'languages' => $languages()->toArray(),
            'support_en_not_strict' => $languages->supports('en'),
            'support_en_strict' => $languages->supports('en', true),
            'support_fr_not_strict' => $languages->supports('fr'),
            'support_fr_strict' => $languages->supports('fr-FR', true),
        ]
    );
Will result in:
```json
{
    "agent":"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.186 Safari/537.36",
    "languages":[
        {
            "raw_language":"en-US",
            "language":"en",
            "country":"US",
            "variant":"",
            "q":1
        },
        {
            "raw_language":"en",
            "language":"en",
            "country":"",
            "variant":"",
            "q":0.9
        },
        {
            "raw_language":"fr",
            "language":"fr",
            "country":"",
            "variant":"",
            "q":0.8
        }
    ],
    "support_en_not_strict":true,
    "support_en_strict":true,
    "support_fr_not_strict":true,
    "support_fr_strict":false
} 
```
## Noteworthy Classes
### AcceptedLanguage
Encapsulates a single language that the browser accepts. This class allows you to access:
* **The two char i18n language code (i.e. en, fr, es)**.
* **The two char i18n country code (i.e. US, FR, ES)**
* **The q (the preference weight) of the language.**.

#### Examples
If a browser sends: ```accept-language: "en-US,en;q=0.9,fr;q=0.8"```
<br> Then<br>
``` php
$languages = BrowserInfo::getLanguages();
$aLanguage = $languages->first();
Log::info('$aLanguage\'s language:', ['language' => $aLanguage->getLanguage()]); // en
Log::info('$aLanguage\'s country:', ['country' => $aLanguage->getCountry()]); // US
Log::info('$aLanguage\'s q:', ['language' => $aLanguage->getQ()]); // 1
```


### Languages:
Languages is a collection class that inherits from Laravel's ```Illuminate\Support\Collection```. Therefore, it has all the same methods as the Laravel Collection, plus some additional methods. Those methods are as follows.
#### *supports(string $lang, $strict = false)*
This method takes a i18n language code string (i.e. 'en', 'fr-FR', 'es-ES') as parameter to determine if the browser supports that language. By default, this method returns ```true``` when the browser supports the given language regardless of the country and/or variant segment of the language code. For example, accept-language: ```"en-US,en;q=0.9,fr;q=0.8"```
##### Example
If a browser sends: ```accept-language: "en-US,en;q=0.9,fr;q=0.8"```
<br> Then<br>
``` php
$languages = BrowserInfo::getLanguages();
Log::info('Supports French', ['output' => $languages->supports('fr')]); // true
Log::info('Supports French', ['output' => $languages->supports('fr', true)]); // true
Log::info('Supports French from France strict', ['output' => $languages->supports('fr-FR')]); // false
Log::info('Supports Spanish (any)', ['output' => $languages->supports('es-ES')]); // true 
```



## Available Facades
### BrowserInfo
The **BrowserInfo** facade allows you to easily access informations related to the browser such as the supported languages. The available methods are the following.
#### BrowserInfo::getLanguages()


<?php

namespace AirAroma\Library;

use AirAroma\Repository\TokenRepository;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Log\Writer;




class Translator
{
    protected $tokens;
    public $translated;

    /**
     * Construct the translator
     * @return type
     */
    public function __construct(Writer $log)
    {
        $this->log = $log;
        $this->translations = getConfig('siteTranslations', 'translations');
    }

    /**
     * Translate provided token, and if it is translatable from the frontend.
     * 
     * @param string $token
     * @param  bool $translatable
     */
    public function token($token, $translatable = true)
    {
        $this->token = $token;
        $this->translatable = $translatable;

        return $this->translate();
    }


    /**
     * 
     */
    public function translate()
    {
        if (empty($this->token) || ! isset($this->token)) {
            return $this->showMessage('no_token_specified');
        }

        if (! array_key_exists($this->token, $this->translations)) {
            return $this->showMessage('no_token', $this->token);
        }

        if (! $this->translations[$this->token]['translation']) {

            if ($this->translatable) {
                return $this->showTranslationInlineTools('translate');
            } 
            return $this->showMessage('no_translation', $this->token);
        }

        if (! auth()->guard('admin')->check()) {
            return $this->showTranslation();
        }

        /* Parkash - Turning off Inline Translation Tool. */
        //if ($this->translatable) {
        //    return $this->showTranslationInlineTools('translate');
        //} 
        
        return $this->showTranslation();
    }   

    /**
     * Display message if no translations
     * 
     * @param string $message
     * @param string $token
     */
    private function showMessage($message, $token = null) 
    {
        $this->log->useDailyFiles(storage_path().'/logs/translations/errors.log');
        $this->log->info(json_encode([
            'uri' => request()->server('REQUEST_URI'),
            'message' => $message,
            'token' => $token
            ]));

        if ($token) {
            $token = '['.$token.']';
        }

        return $message.' '.$token;
    }

    /**
     * Show translation  and parse inline tags
     * 
     */
    private function showTranslation() 
    { 
        $translation = $this->translations[$this->token]['translation'];
        return $this->parseInlineTags($translation);
    }

    /**
     * 
     */
    private function showTranslationInlineTools($type) 
    {
        $tokenId = $this->translations[$this->token]['id'];
        $translation = $this->parseInlineTags($this->translations[$this->token]['translation']);

        if (! $translation) {
            $translation = $this->showMessage('no_translation', $this->token);
        }

        return '<i class="inline-tools" data-type="'. $type .'" data-token="'. $this->token .'" data-id="'. $tokenId .'">'.$translation.'</i>';
    }

    /**
     * 
     */
    private function parseInlineTags($translation) 
    {
        return preg_replace_callback('/\[(.*?)\]/', [$this, 'tagEngine'], nl2br($translation));
    }

    /**
     * 
     */
    private function tagEngine($tags) 
    {
        $tags = explode('#', $tags[1]);

        switch ($tags[0]) {
            case 'link':
               return $this->tagEngineLink($tags);
            break;
            case 'date':
               return $this->tagEngineDate($tags);
            break;
            default:
                return $this->showMessage('unknown_tag');
        }
    }

    /**
     * 
     */
    protected function tagEngineDate($tag) 
    {
        $format = (isset($tag[1])) ? $tag[1] : 'd M Y';
        return date($format);
    }

    /**
     * 
     */
    protected function tagEngineLink($tag) 
    {
        $url = $tag[1]; 
        $token = $tag[2]; 

        if (! array_key_exists($token, $this->translations)) {
            return $this->showMessage('no_token', $token);
        }

        $translation = ($this->translations[$token]['translation']) ?: $this->showMessage('no_translation', $token);

        return '<a href="'.$url.'">'.$translation.'</a>';
    }
    

}
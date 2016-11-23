<?php

namespace VizuaaLOG\Recaptcha;

class Recaptcha {
    /**
    *   Cached captcha response
    *
    *   @var Array|null
    */
    protected $response = null;

    /**
    *   Echo the script and reCaptcha element
    *   
    *   @return String
    */
    public function render()
    {
        return '<script src="https://www.google.com/recaptcha/api.js"></script><div class="g-recaptcha" data-sitekey="'.config('recaptcha.sitekey').'"></div>';
    }

    /**
    * Perform a cURL request to check if the captcha is successful
    *
    * @return boolean
    */
    public function check($request)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, config('recaptcha.url'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(
            array(
                'secret' => config('recaptcha.secret'),
                'response' => $request->input('g-recaptcha-response')
            )
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $this->response = json_decode(curl_exec($ch), true);

        curl_close($ch);

        return $this->response['success'];
    }

    /**
    *   Return the errors from the captcha API
    *
    *   @return Array
    */
    public function getErrors()
    {
        return $this->response['error-codes'];
    }
}
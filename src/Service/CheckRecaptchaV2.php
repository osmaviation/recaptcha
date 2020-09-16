<?php

namespace OSMAviation\Recaptcha\Service;

/**
 * Handle sending out and receiving a response to validate the captcha
 */
class CheckRecaptchaV2 implements RecaptchaInterface
{

    /**
     * Call out to reCAPTCHA and process the response
     *
     * @param string $challenge
     * @param string $response
     *
     * @return bool
     */
    public function check($challenge, $response)
    {

        $response = app('recaptcha.driver')
            ->setUrl('https://www.google.com/recaptcha/api/siteverify')
            ->call([
                'secret' => value(app('config')->get('recaptcha.private_key')),
                'remoteip' => app('request')->getClientIp(),
                'response' => $response,
            ]);

        /**
         * Request error
         */
        if($response === false){
            return false;
        }

        return $response['success'];
    }

    public function getTemplate()
    {
        return 'captchav2';
    }

    public function getResponseKey()
    {
        return 'g-recaptcha-response';
    }
}

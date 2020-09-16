<?php

namespace OSMAviation\Recaptcha\Service;
use Illuminate\Support\Facades\Http;

/**
 * Handle sending out and receiving a response to validate the captcha
 */
class CheckRecaptchaV3 implements RecaptchaInterface
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

        /**
         * Fake token
         */
        if(!$response['success']){
            return false;
        }

        /**
         * Ensure the action name is the name we expect
         */
        if (!isset($response['action']) || $response['action'] !== app('config')->get('recaptcha.actions.register')) {
            return false;
        }

        /**
         * Check the score
         */
        return isset($response['score']) && floatval(app('config')->get('recaptcha.threshold')) < floatval($response['score']);
    }

    public function getTemplate()
    {
        return 'captchav3';
    }

    public function getResponseKey()
    {
        return 'g-recaptcha-response';
    }
}

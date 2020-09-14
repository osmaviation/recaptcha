<?php

namespace OSMAviation\Recaptcha\Service;

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
        $parameters = http_build_query([
            'secret'   => value(app('config')->get('recaptcha.private_key')),
            'remoteip' => app('request')->getClientIp(),
            'response' => $response,
        ]);

        $url           = 'https://www.google.com/recaptcha/api/siteverify?' . $parameters;
        $checkResponse = null;

        // prefer curl, but fall back to file_get_contents
        if ('curl' === app('config')->get('recaptcha.driver') && function_exists('curl_version')) {
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_TIMEOUT, app('config')->get('recaptcha.options.curl_timeout', 1));
            if(app('config')->get('recaptcha.options.curl_verify') === false) {
              curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            }

            $checkResponse = curl_exec($curl);

            if(false === $checkResponse) {
              app('log')->error('[Recaptcha] CURL error: '.curl_error($curl));
            }
        } else {
            $checkResponse = file_get_contents($url);
        }

        if (is_null($checkResponse) || empty( $checkResponse )) {
            return false;
        }

        $decodedResponse = json_decode($checkResponse, true);

        /**
         * Fake token
         */
        if(!$decodedResponse['success']){
            return false;
        }

        /**
         * The action name is the name we expect
         */
        if (!isset($decodedResponse['action']) || $decodedResponse['action'] !== app('config')->get('recaptcha.actions.register')) {
            return false;
        }

        /**
         * Check the score
         */
        return isset($decodedResponse['score']) && floatval(app('config')->get('recaptcha.threshold')) < floatval($decodedResponse['score']);
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

<?php

namespace AirAroma\Service;

use AirAroma\Library\API;
use AirAroma\Library\Translator;
use Illuminate\Config\Repository as Config;
use Illuminate\Http\Request;
use Illuminate\Validation\Factory as Validator;

/**
* ContactService - functions to process and send the contact form emails.
*/
class ContactService
{
    public function __construct(Config $config, Request $request, Translator $translator, API $api, Validator $validator)
    {
        $this->config = $config;
        $this->request = $request;
        $this->translate = $translator;
        $this->api = $api;
        $this->validator = $validator;
    }

    /**
    * Validate Contact Form Recaptcha
    *
    * @param null
    * @return boolean, recaptcha result
    */
    public function validateRecaptcha()
    {
        //Recaptcha Check
        $recaptchaResponse = $this->request->get('g-recaptcha-response');
        $recaptchaRemoteIP = $this->request->server('REMOTE_ADDR');     
        $recaptchaSecretKey = getenv('RECAPTCHA_SECRET');

        $recaptchaUrl = 'https://www.google.com/recaptcha/api/siteverify';

        $params = [ 
            'secret' => $recaptchaSecretKey,
            'response' => $recaptchaResponse,
            'remoteip' => $recaptchaRemoteIP
        ];

        $this->api->post($recaptchaUrl, $params);

        $response = json_decode($this->api->response(10240));

        if ($response && isset($response->success)) {
            return $response->success;
        }

        return false;
    }

    /**
    * Validate Contact Form contents
    *
    * @param null
    * @return validator object
    */
    public function validateForm()
    {
        return $this->validator->make(
            $this->request->all(),
            [
                'contact-form-name' => 'required',
                'contact-form-email' => 'required|email',
                'contact-form-email2' => 'required|email|same:contact-form-email',
                'contact-form-phone' => 'required',
                'contact-form-reason' => 'required',
                'contact-form-country' => 'required',
                'contact-form-message' => 'required',
            ],
            [
                'required' => $this->translate->token('text_fieldrequired', false),
                'email' =>  $this->translate->token('text_emailinvalid', false),
                'same' => $this->translate->token('text_fieldnomatch', false)
            ]
        );
    }

    /**
    * Send Contact Form contents to Air Aroma, Send thankyou message to Customer.
    *
    * @param null
    * @return boolean - sucessMessage
    */
    public function sendEmails()
    {
        $countryRepository = app('AirAroma\Repository\CountryRepository');
        $mail = app('Illuminate\Mail\Mailer');
        $log = app('Illuminate\Log\Writer');

        $countryCode = $this->request->get('contact-form-country');
        $country = $countryRepository->getCountryByCode($countryCode);

        $contactReasonToken = $this->request->get('contact-form-reason');
        $contactReason = $this->translate->token($contactReasonToken, false);

        $geolocation = $this->request->session()->get('geolocation');

        if (isset($geolocation['cou_name'])) {
            $detectedCountry = $geolocation['cou_name'];
        } else {
            $detectedCountry = 'Could not determine Country';
        }

        $stateCode = $this->request->get('contact-form-state');
        $stateName = "Not Provided";

        if ($stateCode != null && $stateCode != "") {
            $state = $country->states()->where('sta_code', $stateCode)->first();
            if ($state) {
                $stateName = $state->sta_name;
            }
        }

        $emailRecipients = $countryRepository->getContactFormEmails($country->cou_slug, $contactReasonToken);

        $emailTo = [];

        foreach ($emailRecipients as $email) {
            $emailTo[] = $email->eml_address;
        }

        if (! count($emailTo)) {
            $emailTo[] = $this->config->get('airaroma.admin_email');
        }

        $data = [
                'contactWebsiteName' => getConfig('siteConfig', 'web_main_domain'),
                'contactDate' => date("Y-m-d H:i:s"),
                'contactName' => $this->request->get('contact-form-name'),
                'contactEmailAddress' => $this->request->get('contact-form-email'),
                'contactPhone' => $this->request->get('contact-form-phone'),
                'contactNewsletter' => '',
                'contactSelectedCountry' => $country->cou_name,
                'contactDetectedCountry' => $detectedCountry,
                'contactState' => $stateName,
                'contactReason' => $contactReason,
                'contactMessage' => $this->request->get('contact-form-message'),
                'emailTo' => $emailTo,
                'emailImageServer' => $this->config->get('airaroma.email_image_server'),
            ];

        $log->useDailyFiles(storage_path().'/logs/mail/contactform.log');
        $log->info(json_encode($data));

        $mail->send('emails.contactus.data', ['data' => $data], function ($mail) use ($data) {
            $mail->to($data['emailTo'])
                ->replyTo($data['contactEmailAddress'])
                ->subject($this->translate->token('contactform_subject_internal', false).' - ' . date('Y-m-d H:i:s ( P )'));
        });

        $mail->send('emails.contactus.thankyou', ['data' => $data], function ($mail) use ($data) {
            $mail->to($data['contactEmailAddress'], $data['contactName'])
                ->subject($this->translate->token('contactform_subject_customer', false));
        });
        
        return true;
    }
}

<?php

namespace App;

trait Sendpulse
{
    public function getSendPulseAccessToken()
    {
        $params = [
            'grant_type' => 'client_credentials',
            'client_id' => '7d185a3f144190a156383081b6f382e6',
            'client_secret' => '84f7c8647b34bcc30f4f73763b587696'
        ];

        $ch = curl_init('https://api.sendpulse.com/oauth/access_token');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));

        $response = curl_exec($ch);

        if ($response === false) {
            die(curl_error($ch));
        }

        curl_close($ch);

        $responseData = json_decode($response, true);

        return $responseData['access_token'] ?? null;
    }

    public function getContactIdByPhone($phone, $accessToken)
    {
        $botId = '660697e76d30103aa40f2931';
        $url = 'https://api.sendpulse.com/whatsapp/contacts/getByPhone?phone=' . $phone . '&bot_id=' . $botId;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $accessToken,
            'accept: application/json'
        ]);

        $response = curl_exec($ch);

        if ($response === false) {
            die(curl_error($ch));
        }

        curl_close($ch);

        $responseData = json_decode($response, true);

        return $responseData['data']['id'] ?? null;
    }

    public function isContactExist($phone, $accessToken)
    {
        $botId = '660697e76d30103aa40f2931';
        $url = 'https://api.sendpulse.com/whatsapp/contacts/getByPhone?phone=' . $phone . '&bot_id=' . $botId;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $accessToken,
            'accept: application/json'
        ]);

        $response = curl_exec($ch);

        if ($response === false) {
            die(curl_error($ch));
        }

        curl_close($ch);

        $responseData = json_decode($response, true);

        // Check if 'error_code' exists in the response data
        if (isset($responseData['error_code'])) {
            // Handle the case where the error_code exists
            return false;
        }

        // Handle the case where error_code does not exist (maybe return null or some other value)
        return true;
    }
    
    public function getPhoneByContactId($contactId, $accessToken)
    {
        $botId = '660697e76d30103aa40f2931';
        $url = 'https://api.sendpulse.com/whatsapp/contacts/get?id=' . $contactId;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $accessToken,
            'accept: application/json'
        ]);

        $response = curl_exec($ch);

        if ($response === false) {
            die(curl_error($ch));
        }

        curl_close($ch);
        $responseData = json_decode($response, true);

        // Check if 'error_code' exists in the response data
        if (isset($responseData['error_code'])) {
            // Handle the case where the error_code exists
            return false;
        }

        // Handle the case where error_code does not exist (maybe return null or some other value)
        return $responseData['data']['channel_data']['phone'] ?? null;
    }

    public function sendTemplatebyPhone($patientName, $phone, $filename, $invoiceLink, $accessToken) 
    {
    $botId = '660697e76d30103aa40f2931'; // Replace with your bot ID
    $url = 'https://api.sendpulse.com/whatsapp/contacts/sendTemplateByPhone';

    $data = [
        'bot_id' => $botId,
        'phone' => $phone,
        'template' => [
            'name' => 'invoice_pdf', // Template name
            'language' => [
                'code' => 'en' // Language code
            ],
            'components' => [
                [
                    'type' => 'body',
                    'parameters' => [
                        [
                            'type' => 'text',
                            'text' => $patientName // Replace with the actual text you want to send
                        ]
                    ]
                ],
                [
                    'type' => 'header',
                    'parameters' => [
                        [
                            'type' => 'document',
                            'document' => [
                                'link' => $invoiceLink, // Replace with the actual link to the PDF
                                'filename' => $filename // Replace with the actual filename
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $accessToken,
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $response = curl_exec($ch);

    if ($response === false) {
        curl_close($ch);
        return [
            'success' => false,
            'message' => curl_error($ch)
        ];
    }

    curl_close($ch);

    $responseData = json_decode($response, true);

    // Check if the response indicates success
    if (isset($responseData['success']) && $responseData['success']) {
        return [
            'success' => true,
            'data' => $responseData['data']
        ];
    } else {
        return [
            'success' => false,
            'message' => $responseData['error'] ?? 'An error occurred'
        ];
    }
}

    public function setUserVariable($contactId, $variableName, $variableValue, $accessToken)
    {
        $url = 'https://api.sendpulse.com/whatsapp/contacts/setVariable';

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $accessToken,
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
            'contact_id' => $contactId,
            'variable_name' => $variableName,
            'variable_value' => (string) $variableValue // Convert variable value to string
        ]));

        $response = curl_exec($ch);

        if ($response === false) {
            die(curl_error($ch));
        }

        curl_close($ch);
    }
    
    public function createContact($phone, $name, $accessToken)
    {
    $botId = '660697e76d30103aa40f2931';
    $url = 'https://api.sendpulse.com/whatsapp/contacts';
    
    $data = [
        'phone' => $phone,
        'name' => $name,
        'bot_id' => $botId,
        'tags' => ['string'], // Update this with the actual tags
        'variables' => [
            [
                'name' => $name, // Update this with the actual variable names
                'value' => 'string' // Update this with the actual variable values
            ]
        ]
    ];
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $accessToken,
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    
    $response = curl_exec($ch);
    
    if ($response === false) {
        die(curl_error($ch));
    }
    
    curl_close($ch);
    
    $responseData = json_decode($response, true);
    
    
    // Log::info('API response', ['response' => $responseData]);
    
    return $responseData['id'] ?? null;
}
}

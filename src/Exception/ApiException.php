<?php

namespace Youbs\ChargeIO\Exception;

class ApiException extends ChargeIOException
{
    protected $messages;
    protected $errors;

    public function __construct($message = null, $json = null)
    {
        parent::__construct(null, $json);

        $this->messages = array();
        $this->errors = array();
        $attrs = json_decode($json, true);
        if ($attrs['messages']) {
            foreach ($attrs['messages'] as $message) {
                if ($message['level'] == 'error' && $message['message']) {
                    if (empty($this->errors)) {
                        $this->code = $message['code'];
                    }
                    $this->messages[] = $message;
                    $this->errors[] = $message['message'];
                }
            }
        }

        if (empty($this->errors)) {
            $this->messages[] = array('code' => 'application_error', 'level' => 'error');
            $this->errors[] = 'Unknown ChargeIO Error';
            $this->code = 'application_error';
        }

        $this->message = $this->errors[0];
    }
}

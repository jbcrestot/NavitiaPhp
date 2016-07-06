<?php

namespace CanalTP\NavitiaPhp\Exception;

class NavitiaException extends \Exception
{
    /**
     * NavitiaException constructor.
     */
    public function __construct($message, $code, $previous = null)
    {
        if (empty($message)) {
            $message = 'Navitia API call didn\'t end as expected';
        }

        if (empty($code)) {
            $code = 500;
        }

        parent::__construct($message, $code, $previous);
    }
}
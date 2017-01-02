<?php

namespace CanalTP\NavitiaPhp\Exception;

class NavitiaException extends \Exception
{
    /**
     * NavitiaException constructor.
     *
     * @param string $message
     * @param \Exception $previous
     */
    public function __construct($message = 'Navitia API call didn\'t end as expected', $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }
}

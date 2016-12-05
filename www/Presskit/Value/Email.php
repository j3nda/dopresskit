<?php

namespace Presskit\Value;

class Email
{
    private $email = '';

    public function __construct($email)
    {
        $email = (string) $email;

        if ($email !== '' && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->email = $email;
        }
    }

    public function __toString()
    {
        if ($this->email === '') {
            return '';
        }

        return $this->email;
    }
}

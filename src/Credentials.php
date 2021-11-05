<?php
/*
 * Copyright (c) 2021, Bastian Leicht <mail@bastianleicht.de>
 *
 * PDX-License-Identifier: BSD-2-Clause
 */

namespace SubServices;

use SubServices\Exception\ParameterException;

class Credentials
{
    private $token;
    private $url;

    /**
     * Credentials constructor.
     * @param string $token
     */
    public function __construct(string $token)
    {
        if (!is_string($token)) {
            throw new ParameterException('invalid argument');
        }
        $this->token = $token;
        $this->url = 'https://sub.services/api/v1/';
    }

    public function __toString()
    {
        return sprintf(
            '[Host: %s], [Token: %s].',
            $this->url,
            $this->token
        );
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }
}

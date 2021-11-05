<?php
/*
 * Copyright (c) 2021, Bastian Leicht <mail@bastianleicht.de>
 *
 * PDX-License-Identifier: BSD-2-Clause
 */

namespace SubServices\Instance;

use GuzzleHttp\Exception\GuzzleException;
use SubServices\SubServices;

class Instance
{
    private $subServices;
    private $whitelistHandler;

    public function __construct(SubServices $subServices)
    {
        $this->subServices = $subServices;
    }

    public function whitelist(): Whitelist
    {
        if(!$this->whitelistHandler) $this->whitelistHandler = new Whitelist($this->subServices);
        return $this->whitelistHandler;
    }

    /**
     * Returns a list of all available Instances.
     * @return array|string
     */
    public function list()
    {
        return $this->subServices->get('instance/list');
    }

    /**
     * Returns detailed Information about the Instance.
     * @param int $id           ID of the Instance.
     * @return array|string
     */
    public function show(int $id)
    {
        return $this->subServices->get('instance/'.$id.'/show');
    }

    /**
     * Starts the Instance.
     * @param int $id
     * @return array|string
     */
    public function start(int $id)
    {
        return $this->subServices->post('instance/'.$id.'/start');
    }

    /**
     * Stops the Instance.
     * @param int $id
     * @return array|string
     */
    public function stop(int $id)
    {
        return $this->subServices->post('instance/'.$id.'/stop');
    }

    /**
     * Restarts the Instance.
     * @param int $id
     * @return array|string
     */
    public function restart(int $id)
    {
        return $this->subServices->post('instance/'.$id.'/restart');
    }

    /**
     * Resets the Password of the Instance.
     * @param int $id
     * @return array|string
     */
    public function reset_password(int $id)
    {
        return $this->subServices->post('instance/'.$id.'/reset-password');
    }

    /**
     * Orders a new Instance.
     * @param int $location_id  Location ID
     * @param string $name      Name of the new Instance
     * @return array|string
     */
    public function order(int $location_id, string $name)
    {
        return $this->subServices->post('order/instance', [
            'location_id' => $location_id,
            'name'        => $name
        ]);
    }

}

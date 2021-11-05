<?php
/*
 * Copyright (c) 2021, Bastian Leicht <mail@bastianleicht.de>
 *
 * PDX-License-Identifier: BSD-2-Clause
 */

namespace SubServices\Instance;


use SubServices\SubServices;

class Whitelist
{
    private $subServices;

    public function __construct(SubServices $subServices)
    {
        $this->subServices = $subServices;
    }

    /**
     * Returns the Whitelist of the Instance
     * @param int $id
     * @return array|string
     */
    public function list(int $id)
    {
        return $this->subServices->get('instance/'.$id.'/whitelist');
    }

    /**
     * Adds an IP Address to the Whitelist.
     * @param int $id               ID of the Instance.
     * @param string $ip_address    IP to add to the Whitelist (127.0.0.1).
     * @return array|string
     */
    public function addEntry(int $id, string $ip_address)
    {
        return $this->subServices->post('instance/'.$id.'/whitelist', [
            'ip_address' => $ip_address
        ]);
    }

    /**
     * @param int $id               ID of the Instance.
     * @param int $whitelist        ID of the Whitelist entry.
     * @param string $ip_address    IP Address to delete.
     * @return array|string
     */
    public function deleteEntry(int $id, int $whitelist, string $ip_address)
    {
        return $this->subServices->delete('instance/'.$id.'/whitelist/'.$whitelist, [
            'ip_address' => $ip_address
        ]);
    }


}

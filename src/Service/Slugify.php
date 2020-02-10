<?php


namespace App\Service;

class Slugify
{

    /**
     * @param string $input
     * @return string
     */
    public function generate(?string $input): string
    {
        $charactersForbidden = ["'","/","`","à","é","è",];
        return str_replace(' ', '-', strtolower($input));
    }
}

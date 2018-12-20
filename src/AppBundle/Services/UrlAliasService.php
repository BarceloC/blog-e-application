<?php

namespace AppBundle\Services;

class UrlAliasService
{
    protected $num;

    public function __construct()
    {
        $this->num = 1;
    }

    public function create(string $urlAlias): string
    {
        $urlAlias = str_replace(" ", "-", $urlAlias);
        if($this->num > 1)
            $urlAlias .= $this->num;

        $this->num++;

        return $urlAlias;
    }
}
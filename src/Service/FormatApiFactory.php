<?php
namespace App\Service;

class FormatApiFactory
{
    private array $services = [
        'reddit' => FormatApiReddit::class,
        'twitter' => FormatApiTwitter::class,
        // ON AJOUTE D'AUTRES SERVICES ICI PLUS TARD
    ];

    public function create(string $serviceName): FormatApiDataInterface
    {
        if (!isset($this->services[$serviceName])) {
            throw new \InvalidArgumentException(sprintf('Service "%s" not found.', $serviceName));
        }

        return new $this->services[$serviceName]();
    }
}
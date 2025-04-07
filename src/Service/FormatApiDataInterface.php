<?php 
namespace App\Service;

interface FormatApiDataInterface
{
    public function format(array $data): array;
}
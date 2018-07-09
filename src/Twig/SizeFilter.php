<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class SizeFilter extends AbstractExtension
{
    const DIM=['', 'K', 'M', 'G', 'T'];

    public function getFilters()
    {
        return [
          new TwigFilter('bytes', [$this, 'convertBytes']),
          new TwigFilter('pixeles', [$this, 'convertPixeles'])
        ];
    }

    public function convertBytes(int $number) : string
    {
        for ($i = 0; $number > (pow(1024, $i)); $i++);
        $numero = round($number/(pow(1024, $i-1)), 2);
        $dimension = self::DIM[$i-1];
        return sprintf('%s %sB', $numero, $dimension);
    }

    public function convertPixeles(string $dimension) : string
    {
        preg_match_all('/(\d{1,})×(\d{1,})/', $dimension, $matches, PREG_SET_ORDER, 0);
        $numero = round(((int)$matches[0][0]*(int)$matches[0][1])/1e6, 2);
        return sprintf('%s Mpx', $numero);
    }
}

<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class SizeFilter extends AbstractExtension
{
    const DIM=['', 'kilo', 'mega', 'giga', 'tera'];

    public function getFilters()
    {
        return [
          new TwigFilter('bytes', [$this, 'convert'])
        ];
    }

    public function convert(int $number) : string
    {
        for ($i = 0; $number > (pow(1024, $i)); $i++);
        $numero = round($number/(pow(1024, $i-1)), 2);
        $dimension = self::DIM[$i-1];
        return sprintf('%s %sbytes', $numero, $dimension);
    }
}

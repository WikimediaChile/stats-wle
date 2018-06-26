<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class CommonsFilter extends AbstractExtension
{
    const FORMAT = 'https://upload.wikimedia.org/wikipedia/commons/thumb/%s/%s/%s/1024px-%s';

    public function getFilters()
    {
        return [
          new TwigFilter('commons', [$this, 'convert'])
        ];
    }

    public function convert(string $filename) : string
    {
        $md5 = md5($filename);
        $md5_1 = substr($md5, 0, 1);
        $md5_2 = substr($md5, 0, 2);
        return sprintf(self::FORMAT, $md5_1, $md5_2, $filename, $filename);
    }
}

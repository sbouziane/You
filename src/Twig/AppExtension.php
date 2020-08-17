<?php


namespace App\Twig;


use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('clean', [$this, 'cleanTitle']),
            new TwigFilter('slugify', [$this, 'slugify']),
        ];
    }

    public function cleanTitle($title)
    {
        return $this->clean($title);
    }
    public function slugify($var)
    {
        return str_replace(' ','-', $var);
    }

    function clean($string) {
        $string = str_replace('.',' ', $string);
        $string = preg_replace('/[^\w\s]+/u', '', $string); // Removes special chars.
        $string = preg_replace('!\s+!', ' ', $string);
        $string = str_replace('quot','', $string);
        $string = str_replace('  ',' ', $string);
        return $string;
    }
}
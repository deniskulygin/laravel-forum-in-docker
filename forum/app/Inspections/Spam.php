<?php


namespace App\Inspections;


class Spam
{
    /**
     * @var array
     */
    protected $inspections = [
        InvalidKeywords::class,
        KeyHeldDown::class
    ];

    /**
     * @param string $text
     *
     * @return bool
     */
    public function detect(string $text): bool
    {
        foreach ($this->inspections as $inspection) {
            app($inspection)->detect($text);
        }

        return false;
    }
}

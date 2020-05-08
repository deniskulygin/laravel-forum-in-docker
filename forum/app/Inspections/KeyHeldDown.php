<?php


namespace App\Inspections;


class KeyHeldDown implements InspectionsInterface
{
    /**
     * @param string $text
     *
     * @throws \Exception
     */
    public function detect(string $text): void
    {
        if (preg_match('/(.)\\1{4,}/', $text)) {
            throw new \Exception('Your reply contains spam.');
        }
    }
}

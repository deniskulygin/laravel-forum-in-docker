<?php


namespace App\Inspections;


interface InspectionsInterface
{
    /**
     * @param string $text
     */
    public function detect(string $text): void;
}

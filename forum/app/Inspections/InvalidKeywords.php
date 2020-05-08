<?php


namespace App\Inspections;


class InvalidKeywords implements InspectionsInterface
{
    /**
     * @var array
     */
    protected $keywords = [
        'Yahoo customer support'
    ];

    /**
     * @param string $text
     *
     * @throws \Exception
     */
    public function detect(string $text): void
    {
        foreach ($this->keywords as $keyword) {
            if (stripos($text, $keyword) !== false) {
                throw new \Exception('Your reply contains spam.');
            }
        }
    }
}

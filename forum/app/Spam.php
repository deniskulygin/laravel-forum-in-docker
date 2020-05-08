<?php


namespace App;


class Spam
{
    /**
     * @param string $text
     *
     * @return bool
     * @throws \Exception
     */
    public function detect(string $text)
    {
         $this->detectInvalidKeywords($text);

         return false;
    }

    /**
     * @param string $text
     * @throws \Exception
     */
    public function detectInvalidKeywords(string $text)
    {
        $invalidKeywords = [
            'Yahoo customer support'
        ];

        foreach ($invalidKeywords as $keyword) {
            if (stripos($text, $keyword) !== false) {
                throw new \Exception('Your reply contains spam.');
            }
        }
    }
}

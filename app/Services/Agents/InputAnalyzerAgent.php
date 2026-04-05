<?php

namespace App\Services\Agents;

class InputAnalyzerAgent
{
    private $keywords = [
        'fire' => ['fire', 'flames', 'smoke', 'burning', 'explosion'],
        'accident' => ['accident', 'crash', 'collision', 'hit', 'road', 'car'],
        'health' => ['heart attack', 'bleeding', 'blood', 'unconscious', 'fainting', 'breath', 'pain', 'medical', 'fever', 'choking'],
        'natural_disaster' => ['earthquake', 'flood', 'storm', 'tornado', 'shake'],
    ];

    public function analyze(string $message): array
    {
        $messageParsed = strtolower($message);
        $detectedType = 'unknown';
        $detectedKeywords = [];

        foreach ($this->keywords as $type => $words) {
            foreach ($words as $word) {
                if (str_contains($messageParsed, $word)) {
                    $detectedType = $type;
                    $detectedKeywords[] = $word;
                    break; // Just pick the first detected type for simplicity
                }
            }
        }

        return [
            'type' => $detectedType,
            'keywords' => array_unique($detectedKeywords),
            'original_message' => $message,
        ];
    }
}

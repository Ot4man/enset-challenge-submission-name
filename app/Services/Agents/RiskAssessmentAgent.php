<?php

namespace App\Services\Agents;

class RiskAssessmentAgent
{
    private $riskLevels = [
        'natural_disaster' => 'critical',
        'health' => 'high',
        'fire' => 'high',
        'accident' => 'medium',
        'unknown' => 'low',
    ];

    public function assess(array $analysis): array
    {
        $type = $analysis['type'];
        $keywords = $analysis['keywords'];

        $risk = $this->riskLevels[$type] ?? 'low';

        // Escalate risk based on keyword strength if needed
        if ($type === 'health' && (in_array('heart attack', $keywords) || in_array('unconscious', $keywords))) {
            $risk = 'critical';
        }

        if ($type === 'fire' && in_array('explosion', $keywords)) {
            $risk = 'critical';
        }

        return array_merge($analysis, [
            'risk_level' => $risk,
        ]);
    }
}

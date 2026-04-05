<?php

namespace App\Services\Agents;

class ActionAgent
{
    public function format(array $decision): array
    {
        $actions = $decision['raw_actions'];

        // Clean action texts and add disclaimer if needed
        $cleanActions = array_map(function ($action) {
            return ucfirst(trim($action));
        }, $actions);

        return [
            'emergency_type' => $decision['type'],
            'risk_level' => $decision['risk_level'],
            'actions' => $cleanActions,
            'disclaimer' => 'This AI does not replace emergency services. Please call local emergency numbers (e.g. 911 or 112) immediately.',
        ];
    }
}

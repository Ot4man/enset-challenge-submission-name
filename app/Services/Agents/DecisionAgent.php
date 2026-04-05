<?php

namespace App\Services\Agents;

class DecisionAgent
{
    private $actionsByType = [
        'fire' => ['Evacuate', 'Call firefighters', 'Use fire extinguisher if safe'],
        'accident' => ['Secure boundaries', 'Check for injuries', 'Call ambulance'],
        'health' => ['Call 911', 'Administer first aid', 'Stay with person'],
        'natural_disaster' => ['Find cover', 'Move to higher ground if flood', 'Stay away from windows'],
        'unknown' => ['Assess situation further', 'Stay safe', 'Call local authorities'],
    ];

    public function decide(array $assessment): array
    {
        $type = $assessment['type'];
        $risk = $assessment['risk_level'];

        $actions = $this->actionsByType[$type] ?? $this->actionsByType['unknown'];

        // Modify actions based on risk level
        if ($risk === 'critical') {
            $actions = array_merge(['PRIORITY: EVACUATE IMMEDIATELY'], $actions);
        }

        return array_merge($assessment, [
            'raw_actions' => $actions,
        ]);
    }
}

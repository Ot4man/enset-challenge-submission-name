<?php

namespace App\Services\Agents;

class MedicalAdviceAgent
{
    private $tips = [
        'heart attack' => [
            'Have the person sit down, rest, and try to keep calm.',
            'Loosen any tight clothing.',
            'Ask if the person takes any chest pain medication, such as nitroglycerin, for a known heart condition, and help them take it.',
        ],
        'bleeding' => [
            'Apply direct pressure to the wound with a clean cloth or bandage.',
            'Keep the pressure constant until help arrives.',
            'Elevate the injured limb above the level of the heart if possible.',
        ],
        'choking' => [
            'Give 5 back blows between the shoulder blades with the heel of your hand.',
            'Give 5 abdominal thrusts (Heimlich maneuver).',
            'Alternate between 5 blows and 5 thrusts until the blockage is dislodged.',
        ],
        'unconscious' => [
            'Check for breathing and a pulse.',
            'If not breathing, begin CPR immediately.',
            'Place the person in the recovery position if they are breathing.',
        ],
        'default' => [
            'Monitor the victim closely for changes in condition.',
            'Ensure the airway remains clear.',
            'Avoid giving the person anything to eat or drink.',
        ]
    ];

    public function provideTips(array $actionData): array
    {
        $type = $actionData['emergency_type'];
        $keywords = $actionData['keywords'] ?? [];
        
        $medicalTips = [];

        if ($type === 'health') {
            foreach ($this->tips as $key => $advices) {
                if (in_array($key, $keywords)) {
                    $medicalTips = array_merge($medicalTips, $advices);
                }
            }

            if (empty($medicalTips)) {
                $medicalTips = $this->tips['default'];
            }
        }

        return array_merge($actionData, [
            'medical_advice' => $medicalTips,
        ]);
    }
}

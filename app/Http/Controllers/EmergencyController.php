<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Agents\InputAnalyzerAgent;
use App\Services\Agents\RiskAssessmentAgent;
use App\Services\Agents\DecisionAgent;
use App\Services\Agents\ActionAgent;
use Illuminate\Http\JsonResponse;

class EmergencyController extends Controller
{
    protected $inputAnalyzer;
    protected $riskAssessor;
    protected $decisionMaker;
    protected $actionFormatter;

    public function __construct(
        InputAnalyzerAgent $inputAnalyzer,
        RiskAssessmentAgent $riskAssessor,
        DecisionAgent $decisionMaker,
        ActionAgent $actionFormatter
    ) {
        $this->inputAnalyzer = $inputAnalyzer;
        $this->riskAssessor = $riskAssessor;
        $this->decisionMaker = $decisionMaker;
        $this->actionFormatter = $actionFormatter;
    }

    public function analyze(Request $request): JsonResponse
    {
        $request->validate([
            'message' => 'required|string|max:500',
        ]);

        $message = $request->input('message');

        // Agent sequence
        $analysis = $this->inputAnalyzer->analyze($message);
        $assessment = $this->riskAssessor->assess($analysis);
        $decision = $this->decisionMaker->decide($assessment);
        $result = $this->actionFormatter->format($decision);

        return response()->json($result);
    }
}

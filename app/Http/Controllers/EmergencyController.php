<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Agents\InputAnalyzerAgent;
use App\Services\Agents\RiskAssessmentAgent;
use App\Services\Agents\DecisionAgent;
use App\Services\Agents\ActionAgent;
use App\Services\Agents\VoiceDispatchAgent;
use App\Services\Agents\MedicalAdviceAgent;
use App\Services\Agents\VisionAnalysisAgent;
use App\Models\EmergencyRecord;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class EmergencyController extends Controller
{
    protected $inputAnalyzer;
    protected $riskAssessor;
    protected $decisionMaker;
    protected $actionFormatter;
    protected $voiceDispatcher;
    protected $medicalAdvisor;
    protected $visionAnalyzer;

    public function __construct(
        InputAnalyzerAgent $inputAnalyzer,
        RiskAssessmentAgent $riskAssessor,
        DecisionAgent $decisionMaker,
        ActionAgent $actionFormatter,
        VoiceDispatchAgent $voiceDispatcher,
        MedicalAdviceAgent $medicalAdvisor,
        VisionAnalysisAgent $visionAnalyzer
    ) {
        $this->inputAnalyzer = $inputAnalyzer;
        $this->riskAssessor = $riskAssessor;
        $this->decisionMaker = $decisionMaker;
        $this->actionFormatter = $actionFormatter;
        $this->voiceDispatcher = $voiceDispatcher;
        $this->medicalAdvisor = $medicalAdvisor;
        $this->visionAnalyzer = $visionAnalyzer;
    }

    public function home(): View { return view('home'); }
    public function about(): View { return view('about'); }
    public function contact(): View { return view('contact'); }

    public function history(): View
    {
        $records = EmergencyRecord::latest()->get();
        return view('history', compact('records'));
    }

    public function nearby(): View
    {
        $nearby = [
            ['name' => 'General Hospital Central', 'type' => 'Hospital', 'distance' => '1.2km', 'icon' => '🏥'],
            ['name' => 'Police Prefecture 1', 'type' => 'Police Station', 'distance' => '0.5km', 'icon' => '👮'],
            ['name' => 'Main Fire Station', 'type' => 'Fire Station', 'distance' => '2.1km', 'icon' => '🚒'],
            ['name' => 'Red Cross Ambulance Service', 'type' => 'Ambulance', 'distance' => '3.4km', 'icon' => '🚑'],
        ];
        return view('nearby', compact('nearby'));
    }

    public function dashboard(): View
    {
        $total = EmergencyRecord::count();
        $byType = EmergencyRecord::selectRaw('type, count(*) as count')->groupBy('type')->pluck('count', 'type');
        $byRisk = EmergencyRecord::selectRaw('risk_level, count(*) as count')->groupBy('risk_level')->pluck('count', 'risk_level');
        return view('dashboard', compact('total', 'byType', 'byRisk'));
    }

    public function analyze(Request $request): JsonResponse
    {
        $request->validate([
            'message' => 'nullable|string|max:500',
            'image' => 'nullable|image|max:5120', // Max 5MB
        ]);

        $message = $request->input('message') ?? 'Emergency analyzed from image capture.';
        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('emergencies', 'public');
        }

        // Multi-Agent Sequence
        $analysis = $this->inputAnalyzer->analyze($message);
        
        // Add Vision Intelligence step
        $visionResult = $this->visionAnalyzer->analyzeImage($imagePath);
        $analysis = array_merge($analysis, $visionResult);

        $assessment = $this->riskAssessor->assess($analysis);
        $decision = $this->decisionMaker->decide($assessment);
        $result = $this->actionFormatter->format($decision);
        
        $dispatchData = $this->voiceDispatcher->dispatch($result);
        $finalResponse = $this->medicalAdvisor->provideTips($dispatchData);

        // Store record in database with image
        EmergencyRecord::create([
            'message' => $message,
            'image_path' => $imagePath,
            'type' => $result['emergency_type'],
            'risk_level' => $result['risk_level'],
            'actions' => $result['actions'],
        ]);

        // Include the actual image URL in response for display
        if($imagePath) {
            $finalResponse['uploaded_image_url'] = Storage::url($imagePath);
        }

        return response()->json($finalResponse);
    }
}

@extends('layout')

@section('title', 'About Emergency Response Agent')

@section('extra_css')
<style>
    .about-card { background: var(--card); padding: 3rem; border-radius: 2rem; border: 1px solid var(--border); }
    .feature-list { margin-top: 2rem; list-style: none; }
    .feature-list li { margin-bottom: 1rem; display: flex; align-items: center; gap: 1rem; font-size: 1.1rem; }
    .feature-list li::before { content: '🚀'; }
</style>
@endsection

@section('content')
<div class="about-card">
    <h1 style="font-size: 2.5rem; margin-bottom: 2rem; background: linear-gradient(90deg, #fca5a5, #ef4444); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">About the AI System</h1>
    <p style="font-size: 1.2rem; line-height: 1.8; color: var(--text-dim);">
        The **Emergency Response Agent** is an agentic AI system designed to handle critical situations. Using a multi-agent architectural pattern in Laravel, it divides the decision-making process into specialized units:
    </p>

    <ul class="feature-list">
        <li><strong>Analyze:</strong> Extracting intent and keywords from raw text.</li>
        <li><strong>Assess:</strong> Evaluating risks based on human safety criteria.</li>
        <li><strong>Decide:</strong> Selecting appropriate first-response protocols.</li>
        <li><strong>Format:</strong> Generating clear, standardized instructions.</li>
    </ul>

    <div style="margin-top: 4rem; padding: 2rem; background: rgba(239,68,68,0.05); border: 1px solid rgba(239,68,68,0.2); border-radius: 1rem;">
        <h3 style="color: var(--primary); margin-bottom: 1rem;">⚖️ Legal Disclaimer</h3>
        <p style="font-size: 0.95rem; line-height: 1.6;">
            This application is an AI demonstration prototype. It should **never** be used as a replacement for official emergency dispatch systems (911, 112, etc.). AI models can hallucinate and should only be consulted as a secondary information source while official help is being contacted.
        </p>
    </div>
</div>
@endsection

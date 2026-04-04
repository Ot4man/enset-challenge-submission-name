@extends('layout')

@section('title', 'Emergency Home - Agentic AI')

@section('extra_css')
<style>
    .chat-container {
        background: var(--card);
        padding: 3rem;
        border-radius: 2rem;
        border: 1px solid var(--border);
        box-shadow: 0 10px 40px rgba(0,0,0,0.3);
    }

    textarea {
        width: 100%;
        background: #0f172a;
        border: 2px solid var(--border);
        border-radius: 0.8rem;
        padding: 1.2rem;
        color: white;
        font-size: 1.1rem;
        outline: none;
        transition: 0.3s;
        resize: none;
    }
    textarea:focus { border-color: var(--primary); }

    .result-area { display: none; margin-top: 2rem; animation: slideUp 0.4s ease; }
    
    .dispatch-card {
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid rgba(239, 68, 68, 0.4);
        border-radius: 1rem;
        padding: 1.5rem;
        margin-bottom: 2rem;
        display: none;
        align-items: center;
        gap: 1.5rem;
        animation: pulseBorder 2s infinite;
    }

    @keyframes pulseBorder {
        0% { border-color: rgba(239, 68, 68, 0.4); box-shadow: 0 0 0px rgba(239, 68, 68, 0); }
        50% { border-color: rgba(239, 68, 68, 1); box-shadow: 0 0 15px rgba(239, 68, 68, 0.3); }
        100% { border-color: rgba(239, 68, 68, 0.4); box-shadow: 0 0 0px rgba(239, 68, 68, 0); }
    }

    .pulse {
        width: 15px;
        height: 15px;
        background: #ef4444;
        border-radius: 50%;
        box-shadow: 0 0 0 rgba(239, 68, 68, 0.4);
        animation: pulseDot 2s infinite;
    }

    @keyframes pulseDot {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(239, 68, 68, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
    }
    @keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

    .action-list { list-style: none; margin-top: 1rem; }
    .action-list li { padding: 0.8rem 0; border-bottom: 1px dashed var(--border); display: flex; gap: 10px; }
    .action-list li::before { content: '✓'; color: var(--primary); font-weight: 900; }
</style>
@endsection

@section('content')
<div class="chat-container">
    <h1 style="margin-bottom: 0.5rem;">🚨 New Emergency Analysis</h1>
    <p style="color: var(--text-dim); margin-bottom: 2rem;">Describe the situation. Our agents will categorize and prioritize it instantly.</p>

    <div class="input-group">
        <textarea id="message" rows="4" placeholder="Example: There is a multi-car accident on the highway, passengers are trapped..."></textarea>
    </div>

    <button id="submit-btn" class="btn-primary" style="width: 100%; margin-top: 1.5rem; font-size: 1.1rem;" onclick="analyzeSituation()">
        Analyze & Respond
    </button>

    <div id="dispatch-bar" class="dispatch-card">
        <div class="pulse"></div>
        <div>
            <h4 id="dispatch-title" style="color: #ef4444; margin-bottom: 0.2rem;">AI Dispatching to Local Center...</h4>
            <p id="dispatch-status" style="font-size: 0.85rem; color: var(--text-dim);">Analyzing optimal transmission channel...</p>
        </div>
    </div>

    <div id="result-area" class="result-area">
        <div id="risk-badge" class="badge">Critical</div>
        <div style="background: rgba(0,0,0,0.2); padding: 1.5rem; border-radius: 1rem; margin-top: 1rem; border: 1px solid var(--border);">
            <h3 id="emergency-type" style="margin-bottom: 1rem; color: #f1f5f9;">Detected: Fire</h3>
            <ul id="action-list" class="action-list"></ul>
        </div>
    </div>

    <div style="margin-top: 3rem; font-size: 0.75rem; color: #ef4444; border: 1px dashed rgba(239,68,68,0.3); padding: 1rem; border-radius: 0.8rem; text-align: center;">
        ⚠️ DISCLAIMER: This AI does not replace emergency services. If in danger, call local emergency numbers (911/112) now.
    </div>
</div>
@endsection

@section('extra_js')
<script>
    async function analyzeSituation() {
        const message = document.getElementById('message').value.trim();
        const btn = document.getElementById('submit-btn');
        const res = document.getElementById('result-area');
        
        if(!message) return;

        btn.disabled = true;
        btn.innerText = 'Agents Collaborating...';
        res.style.display = 'none';

        try {
            const response = await fetch("{{ route('analyze') }}", {
                method: "POST",
                headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                body: JSON.stringify({ message })
            });

            const data = await response.json();

            // Handle Dispatch Logic
            const dispatchBar = document.getElementById('dispatch-bar');
            const dispatchStatus = document.getElementById('dispatch-status');
            const dispatchTitle = document.getElementById('dispatch-title');

            if(data.risk_level === 'critical' || data.risk_level === 'high') {
                dispatchBar.style.display = 'flex';
                dispatchTitle.innerText = "Transmitting to 911/112 Dispatchers...";
                dispatchStatus.innerText = "Connecting to VoIP Priority Channel: " + data.dispatch_status.channel;
                
                setTimeout(() => {
                    dispatchStatus.innerText = "CONNECTED: Voice alert transmission in progress. Priority: IMMEDIATE";
                }, 1500);
            } else {
                dispatchBar.style.display = 'none';
            }

            document.getElementById('emergency-type').innerText = "Emergency: " + data.emergency_type.toUpperCase();
            const badge = document.getElementById('risk-badge');
            badge.innerText = data.risk_level + " Risk";
            badge.className = "badge badge-" + data.risk_level;

            const list = document.getElementById('action-list');
            list.innerHTML = "";
            data.actions.forEach(act => {
                const li = document.createElement('li');
                li.innerText = act;
                list.appendChild(li);
            });

            res.style.display = 'block';
        } catch (e) {
            alert("Error in agent communication sequence.");
        } finally {
            btn.disabled = false;
            btn.innerText = 'Analyze & Respond';
        }
    }
</script>
@endsection

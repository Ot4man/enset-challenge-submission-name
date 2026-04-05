@extends('layout')

@section('title', 'SOS Center - Agentic AI')

@section('extra_css')
<style>
    .home-card { transition: 0.5s; padding: 3.5rem; overflow: hidden; position: relative; }
    
    /* Background Elements */
    .home-card::before {
        content: ''; position: absolute; top: -100px; right: -100px; width: 300px; height: 300px; 
        background: radial-gradient(circle, var(--primary), transparent 70%); opacity: 0.1; filter: blur(50px);
    }

    textarea {
        width: 100%; min-height: 140px; background: rgba(15, 23, 42, 0.4); border: 2px solid var(--border);
        border-radius: 1.2rem; padding: 1.5rem; color: #fff; font-size: 1.2rem; outline: none; transition: 0.4s;
        box-shadow: inset 0 2px 10px rgba(0,0,0,0.2);
    }
    textarea:focus { border-color: var(--primary); background: rgba(15, 23, 42, 0.6); }

    .input-actions { display: flex; justify-content: space-between; align-items: center; margin-top: 1.5rem; }

    .mic-btn {
        background: rgba(255,255,255,0.05); color: #fff; border: 1px solid var(--border);
        padding: 0.8rem 1.2rem; border-radius: 999px; cursor: pointer; display: flex; align-items: center; gap: 8px;
        transition: 0.3s; font-size: 0.9rem; font-weight: 600;
    }
    .mic-btn:hover { background: rgba(255,255,255,0.1); border-color: #fff; }
    .mic-btn.listening { background: var(--primary); animation: micPulse 1.5s infinite; border: none; }

    @keyframes micPulse { 0% { opacity: 0.7; } 50% { opacity: 1; } 100% { opacity: 0.7; } }

    /* Progress Steps */
    .agent-steps { display: none; margin-top: 2rem; gap: 10px; flex-wrap: wrap; }
    .step { display: flex; align-items: center; gap: 8px; font-size: 0.8rem; color: var(--text-dim); opacity: 0.4; transition: 0.3s; }
    .step.active { color: #fff; opacity: 1; font-weight: 600; }
    .step i { display: inline-block; width: 10px; height: 10px; border-radius: 50%; background: var(--text-dim); }
    .step.active i { background: var(--primary); box-shadow: 0 0 10px var(--primary); }

    /* Animated scan line for vision feed */
    @keyframes scanAnim { 0% { top: 0; } 100% { top: 100%; } }

    /* Action List Stylings */
    .action-list { list-style: none; margin-top: 1.5rem; }
    .action-list li { margin-bottom: 0.8rem; padding: 1rem; background: rgba(255,255,255,0.03); border-radius: 1rem; border: 1px solid var(--border); display: flex; align-items: center; gap: 1rem; transition: 0.3s; animation: reveal 0.5s forwards; }
    .action-list li:hover { background: rgba(255,255,255,0.06); transform: translateX(10px); }
    .action-list li i { color: var(--primary); font-style: normal; font-weight: 900; }

    @keyframes reveal { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

    /* Quick Alert Buttons */
    .quick-alerts { display: flex; gap: 1rem; flex-wrap: wrap; margin-bottom: 2rem; }
    .quick-btn { background: rgba(255, 255, 255, 0.05); border: 1px solid var(--border); padding: 0.6rem 1.2rem; border-radius: 12px; font-size: 0.85rem; color: #fff; cursor: pointer; transition: 0.2s; }
    .quick-btn:hover { background: var(--primary); border-color: transparent; transform: translateY(-2px); }

    /* Custom Call Dispatch Interface */
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
</style>
@endsection

@section('content')
<div class="glass-card home-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 2.5rem; letter-spacing: -1px; margin-bottom: 0.5rem;">🚨 New Emergency Case</h1>
            <p style="color: var(--text-dim); font-size: 1.1rem;">Agentic AI sequence protocols initialized.</p>
        </div>
        <div id="status-tag" style="background: rgba(34, 197, 94, 0.1); color: var(--low); padding: 0.5rem 1rem; border-radius: 12px; font-size: 0.8rem; font-weight: 700; display: flex; align-items: center; gap: 8px;">
            <div style="width: 8px; height: 8px; background: var(--low); border-radius: 50%; box-shadow: 0 0 10px var(--low);"></div>
            AGENTS ONLINE
        </div>
    </div>

    <div class="quick-alerts">
        <button class="quick-btn" onclick="prefillEmergency('Large kitchen fire spreading...')">🔥 Fire Outbreak</button>
        <button class="quick-btn" onclick="prefillEmergency('Severe bleeding from a car accident...')">🚗 Road Accident</button>
        <button class="quick-btn" onclick="prefillEmergency('Someone collapsed, having trouble breathing...')">🫀 Medical Attack</button>
        <button class="quick-btn" onclick="prefillEmergency('Heavy flooding entering the main house...')">🌊 Natural Disaster</button>
    </div>

    <div class="input-group" style="position: relative;">
        <textarea id="message" placeholder="Describe the crisis details here..."></textarea>
    </div>

    <!-- Image Upload Portal -->
    <div style="margin-top: 1.5rem; display: flex; align-items: center; gap: 1rem;">
        <label for="image-upload" style="flex: 1; background: rgba(255,255,255,0.05); border: 2px dashed var(--border); padding: 1.5rem; border-radius: 1rem; text-align: center; cursor: pointer; transition: 0.3s; color: var(--text-dim);">
            📸 ATTACH PHOTO EVIDENCE
            <input type="file" id="image-upload" style="display: none;" accept="image/*" onchange="previewUpload(this)">
        </label>
        <div id="image-preview-container" style="display: none; width: 80px; height: 80px; border-radius: 12px; overflow: hidden; border: 2px solid var(--primary);">
            <img id="image-preview" src="" style="width: 100%; height: 100%; object-fit: cover;">
        </div>
    </div>

    <div class="input-actions">
        <button id="mic-btn" class="mic-btn" onclick="toggleListening()">
            <span id="mic-label">🎙️ Start Voice Input</span>
        </button>
        <button id="submit-btn" class="btn-primary" style="padding: 1.2rem 3rem; font-size: 1.1rem; border-radius: 999px; box-shadow: 0 10px 30px rgba(244, 63, 94, 0.4);" onclick="analyzeCrisis()">
            Analyze Crisis & Engage ➔
        </button>
    </div>

    <!-- Micro-Agent Progress Bar -->
    <div id="agent-steps" class="agent-steps">
        <div style="width: 100%; text-align: center; margin-bottom: 2rem;">
            <img src="/assets/img/avatar.png" style="width: 100px; height: 100px; border-radius: 50%; border: 3px solid var(--primary); animation: pulse 2s infinite;">
            <p style="margin-top: 1rem; color: #fff; font-size: 1rem; font-weight: 700; letter-spacing: 2px;">AI AGENT COLLABORATING...</p>
        </div>
        <div class="step" id="step-analyzer"><i></i> InputAnalyzerAgent</div>
        <div class="step" id="step-assessor"><i></i> RiskAssessmentAgent</div>
        <div class="step" id="step-decision"><i></i> DecisionAgent</div>
        <div class="step" id="step-dispatch"><i></i> VoiceDispatchAgent</div>
        <div class="step" id="step-action"><i></i> ActionAgent</div>
    </div>

    <div id="dispatch-bar" class="dispatch-card">
        <div class="pulse"></div>
        <div>
            <h4 id="dispatch-title" style="color: #ef4444; margin-bottom: 0.2rem;">AI Dispatching to Local Center...</h4>
            <p id="dispatch-status" style="font-size: 0.85rem; color: var(--text-dim);">Analyzing optimal transmission channel...</p>
        </div>
    </div>

    <!-- Results -->
    <div id="result-area" style="display: none; margin-top: 3rem; animation: reveal 0.8s ease;">
        <div id="risk-badge" class="badge">CRITICAL</div>
        
        <!-- Medical Section -->
        <div id="medical-tips-card" style="display: none; margin-top: 2rem; background: rgba(34, 197, 94, 0.05); border: 1px solid rgba(34, 197, 94, 0.3); border-radius: 1.5rem; padding: 2rem;">
            <h3 style="color: var(--low); font-size: 1.2rem; display: flex; align-items: center; gap: 10px; margin-bottom: 1.2rem;">👨‍⚕️ Medical Response Agent Tips:</h3>
            <ul id="medical-advices" style="list-style: none; color: var(--text-dim); line-height: 1.8;">
            </ul>
        </div>
        
        <!-- Analysis Visualization -->
        <div id="vision-analysis" style="display: none; margin-top: 2rem;">
            <div style="position: relative; border-radius: 1.5rem; overflow: hidden; border: 2px solid var(--border); background: #000; height: 350px;">
                <img id="incident-photo" src="" style="width: 100%; height: 100%; object-fit: cover; opacity: 0.8;">
                <div style="position: absolute; top: 0; left: 0; padding: 1rem; color: #fff; font-size: 0.8rem; font-family: monospace; background: rgba(0,0,0,0.5);">
                    [AI_VISION_FEED_ACTIVE] <br> SCANNING_INCIDENT_SITE... <br> DEPTH_MAP: OK
                </div>
                <!-- Dynamic Scan Line -->
                <div style="position: absolute; width: 100%; height: 2px; background: rgba(244,63,94,0.4); top: 0; animation: scanAnim 3s infinite linear; box-shadow: 0 0 10px var(--primary);"></div>
            </div>
        </div>

        <div style="margin-top: 2rem; background: rgba(255,255,255,0.02); border: 1px solid var(--border); border-radius: 1.5rem; padding: 2rem;">
            <h2 id="emergency-title" style="font-size: 1.8rem; margin-bottom: 0.5rem; color: #fff;">Detected: FIRE</h2>
            <ul id="action-list" class="action-list"></ul>
        </div>
        
        <div style="margin-top: 3rem; font-size: 0.8rem; color: #ef4444; border: 1px dashed rgba(239,68,68,0.3); padding: 1.5rem; border-radius: 1.2rem; text-align: center; background: rgba(239, 68, 68, 0.05);">
            ⚠️ 🚨 **DISCLAIMER:** This AI is a first-response decision support system. If immediate human assistance is needed, call **911** or **112** from an official cellular line.
        </div>
    </div>
</div>
@endsection

@section('extra_js')
<script>
    function prefillEmergency(txt) {
        document.getElementById('message').value = txt;
        document.getElementById('message').focus();
    }

    function previewUpload(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('image-preview').src = e.target.result;
                document.getElementById('image-preview-container').style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Voice Feedback (Web Speech API)
    function toggleListening() {
        const btn = document.getElementById('mic-btn');
        const label = document.getElementById('mic-label');
        const textarea = document.getElementById('message');

        const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
        if (!SpeechRecognition) {
            alert("Your browser does not support voice recognition.");
            return;
        }

        const recognition = new SpeechRecognition();
        recognition.lang = 'en-US';

        if (btn.classList.contains('listening')) {
            recognition.stop();
            btn.classList.remove('listening');
            label.innerText = '🎙️ Start Voice Input';
        } else {
            btn.classList.add('listening');
            label.innerText = '🛑 Stop Listening...';
            recognition.start();

            recognition.onresult = (event) => {
                const transcript = event.results[0][0].transcript;
                textarea.value = transcript;
                btn.classList.remove('listening');
                label.innerText = '🎙️ Voice Input Received';
            };

            recognition.onerror = () => {
                btn.classList.remove('listening');
                label.innerText = '🎙️ Start Voice Input (Error)';
            };
        }
    }

    // Agent Sequence Simulation
    async function analyzeCrisis() {
        const message = document.getElementById('message').value.trim();
        const imageFile = document.getElementById('image-upload').files[0];
        const btn = document.getElementById('submit-btn');
        const results = document.getElementById('result-area');
        const activeSteps = document.getElementById('agent-steps');
        const dispatchBar = document.getElementById('dispatch-bar');

        if (!message && !imageFile) {
            alert("Provide either a description or a photo evidence.");
            return;
        }

        // Reset UI
        btn.disabled = true;
        results.style.display = 'none';
        dispatchBar.style.display = 'none';
        activeSteps.style.display = 'flex';
        
        const steps = ['step-analyzer', 'step-assessor', 'step-decision', 'step-dispatch', 'step-action'];
        steps.forEach(id => document.getElementById(id).classList.remove('active'));

        // Sequential Simulation Logic
        for(let i=0; i<steps.length; i++) {
            document.getElementById(steps[i]).classList.add('active');
            if(i < 3) await new Promise(r => setTimeout(r, 600)); // Simulated agent delay
        }

        // Using FormData for uploads
        const formData = new FormData();
        formData.append('message', message);
        if (imageFile) {
            formData.append('image', imageFile);
        }

        try {
            const response = await fetch("{{ route('analyze') }}", {
                method: "POST",
                headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}", "Accept": "application/json" },
                body: formData
            });

            const data = await response.json();

            // Handle Dispatch Logic
            if(data.risk_level === 'critical' || data.risk_level === 'high') {
                dispatchBar.style.display = 'flex';
                const dispatchStatus = document.getElementById('dispatch-status');
                const dispatchTitle = document.getElementById('dispatch-title');
                dispatchTitle.innerText = "Transmitting to 911/112 Dispatchers...";
                dispatchStatus.innerText = "Connecting to VoIP Priority Channel: " + data.dispatch_status.channel;
                
                setTimeout(() => {
                    dispatchStatus.innerText = "CONNECTED: Voice alert transmission in progress. Priority: IMMEDIATE";
                }, 1500);
            }

            // Handle Medical Tips
            const medCard = document.getElementById('medical-tips-card');
            const medList = document.getElementById('medical-advices');
            if (data.medical_advice && data.medical_advice.length > 0) {
                medCard.style.display = 'block';
                medList.innerHTML = '';
                data.medical_advice.forEach(tip => {
                    const li = document.createElement('li');
                    li.style.marginBottom = '10px';
                    li.innerHTML = `• ${tip}`;
                    medList.appendChild(li);
                });
            } else {
                medCard.style.display = 'none';
            }

            // Results population
            document.getElementById('emergency-title').innerText = "Crisis Type: " + data.emergency_type.toUpperCase().replace('_', ' ');
            const rb = document.getElementById('risk-badge');
            rb.innerText = data.risk_level + " RISK";
            rb.className = "badge badge-" + data.risk_level;

            // Handle Vision Logic
            const vision = document.getElementById('vision-analysis');
            const photo = document.getElementById('incident-photo');
            
            // Show uploaded image if exists, else type image
            photo.src = data.uploaded_image_url || getPlaceholderImage(data.emergency_type);
            vision.style.display = 'block';

            function getPlaceholderImage(type) {
                const typeImages = {
                    fire: 'https://images.unsplash.com/photo-1542353436-312f02c16299?q=80&w=600',
                    accident: 'https://images.unsplash.com/photo-1595085610813-f667ca84d16d?q=80&w=600',
                    health: 'https://images.unsplash.com/photo-1516549655169-df83a0774514?q=80&w=600',
                    natural_disaster: 'https://images.unsplash.com/photo-1511210414434-7389868779b7?q=80&w=600',
                };
                return typeImages[type] || 'https://images.unsplash.com/photo-1518770660439-4636190af475?q=80&w=600';
            }

            const list = document.getElementById('action-list');
            list.innerHTML = "";
            data.actions.forEach((act, index) => {
                const li = document.createElement('li');
                li.style.animationDelay = (index * 0.1) + 's';
                li.innerHTML = `<i>${index+1}</i> ${act}`;
                list.appendChild(li);
            });

            results.style.display = 'block';
        } catch (e) {
            console.error(e);
            alert("Crisis logic pipeline failed.");
        } finally {
            btn.disabled = false;
            activeSteps.style.display = 'none';
        }
    }
</script>
@endsection

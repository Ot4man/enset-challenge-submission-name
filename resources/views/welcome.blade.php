<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emergency Response Agent - Agentic AI System</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #ef4444;
            --bg: #0f172a;
            --card: #1e293b;
            --text: #f8fafc;
            --text-dim: #94a3b8;
            --border: #334155;
            --critical: #dc2626;
            --high: #f97316;
            --medium: #facc15;
            --low: #22c55e;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Outfit', sans-serif;
        }

        body {
            background-color: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .container {
            max-width: 800px;
            width: 100%;
            background: var(--card);
            padding: 2.5rem;
            border-radius: 1.5rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
            border: 1px solid var(--border);
            backdrop-filter: blur(10px);
        }

        h1 {
            font-size: 2.2rem;
            margin-bottom: 0.5rem;
            background: linear-gradient(90deg, #fca5a5, #ef4444);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-align: center;
        }

        p.subtitle {
            color: var(--text-dim);
            text-align: center;
            margin-bottom: 2rem;
        }

        .input-group {
            position: relative;
            margin-bottom: 2rem;
        }

        textarea {
            width: 100%;
            background: rgba(15, 23, 42, 0.5);
            border: 2px solid var(--border);
            border-radius: 1rem;
            padding: 1.2rem;
            color: var(--text);
            font-size: 1.1rem;
            resize: none;
            transition: all 0.3s ease;
            outline: none;
        }

        textarea:focus {
            border-color: var(--primary);
            box-shadow: 0 0 15px rgba(239, 68, 68, 0.2);
        }

        button {
            width: 100%;
            background: linear-gradient(90deg, #ef4444, #b91c1c);
            color: white;
            border: none;
            padding: 1rem;
            border-radius: 0.8rem;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, background 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        button:hover {
            transform: translateY(-2px);
            opacity: 0.9;
        }

        button:active {
            transform: translateY(0);
        }

        button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .result-area {
            margin-top: 2rem;
            display: none;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .badge {
            display: inline-block;
            padding: 0.4rem 1rem;
            border-radius: 9999px;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 1rem;
        }

        .badge-critical { background: var(--critical); color: white; }
        .badge-high { background: var(--high); color: white; }
        .badge-medium { background: var(--medium); color: white; }
        .badge-low { background: var(--low); color: white; }

        .response-card {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 1rem;
            padding: 1.5rem;
            border: 1px solid var(--border);
        }

        .action-list {
            list-style: none;
            margin-top: 1rem;
        }

        .action-list li {
            padding: 0.8rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            align-items: flex-start;
            gap: 0.8rem;
        }

        .action-list li:last-child {
            border-bottom: none;
        }

        .action-list li::before {
            content: '✓';
            color: var(--primary);
            font-weight: bold;
        }

        .disclaimer {
            margin-top: 2.5rem;
            font-size: 0.75rem;
            color: #ef4444;
            text-align: center;
            font-weight: 500;
            opacity: 0.8;
            padding: 1rem;
            border: 1px dashed rgba(239, 68, 68, 0.3);
            border-radius: 0.5rem;
        }

        .loader {
            width: 20px;
            height: 20px;
            border: 3px solid #FFF;
            border-bottom-color: transparent;
            border-radius: 50%;
            display: none;
            box-sizing: border-box;
            animation: rotation 1s linear infinite;
        }

        @keyframes rotation {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Emergency Response Agent</h1>
        <p class="subtitle">Agentic AI System powered by Laravel</p>

        <div class="input-group">
            <textarea id="message" rows="4" placeholder="Describe your emergency here... (e.g., 'There is a fire in my kitchen' or 'Someone is having a heart attack')"></textarea>
        </div>

        <button id="submit-btn" onclick="analyzeEmergency()">
            <span class="loader" id="loader"></span>
            <span id="btn-text">Analyze Situation</span>
        </button>

        <div id="result-area" class="result-area">
            <div id="risk-badge" class="badge">Critical</div>
            <div class="response-card">
                <h3 id="emergency-type" style="font-weight: 600; font-size: 1.2rem; color: #f1f5f9;">Emergency Detected</h3>
                <ul id="action-list" class="action-list">
                    <!-- Actions will be injected here -->
                </ul>
            </div>
        </div>

        <div class="disclaimer">
            ⚠️ DISCLAIMER: This AI does not replace emergency services. Please call local emergency numbers (e.g. 911 or 112) immediately.
        </div>
    </div>

    <script>
        async function analyzeEmergency() {
            const messageInput = document.getElementById('message');
            const submitBtn = document.getElementById('submit-btn');
            const loader = document.getElementById('loader');
            const btnText = document.getElementById('btn-text');
            const resultArea = document.getElementById('result-area');
            const actionList = document.getElementById('action-list');
            const riskBadge = document.getElementById('risk-badge');
            const emergencyType = document.getElementById('emergency-type');

            const message = messageInput.value.trim();
            if (!message) return;

            // UI Loading state
            submitBtn.disabled = true;
            loader.style.display = 'inline-block';
            btnText.innerText = 'Analyzing...';
            resultArea.style.display = 'none';

            try {
                const response = await fetch('/api/analyze', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ message })
                });

                const data = await response.json();

                // Display Results
                emergencyType.innerText = `Type Detected: ${data.emergency_type.toUpperCase().replace('_', ' ')}`;
                
                riskBadge.innerText = data.risk_level + " Risk";
                riskBadge.className = `badge badge-${data.risk_level}`;

                actionList.innerHTML = '';
                data.actions.forEach(action => {
                    const li = document.createElement('li');
                    li.innerText = action;
                    actionList.appendChild(li);
                });

                resultArea.style.display = 'block';

            } catch (error) {
                console.error("Error analyzing emergency:", error);
                alert("Something went wrong. Please try again.");
            } finally {
                submitBtn.disabled = false;
                loader.style.display = 'none';
                btnText.innerText = 'Analyze Situation';
            }
        }
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Emergency Response Agent')</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary: #f43f5e;
            --primary-dark: #e11d48;
            --bg: #020617;
            --card: rgba(30, 41, 59, 0.7);
            --text: #f8fafc;
            --text-dim: #94a3b8;
            --border: rgba(255, 255, 255, 0.1);
            --critical: #dc2626;
            --high: #f97316;
            --medium: #facc15;
            --low: #22c55e;
            --glass: rgba(15, 23, 42, 0.6);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Outfit', sans-serif;
        }

        body {
            background: radial-gradient(circle at top right, #1e1b4b, #020617);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        /* Glassmorphism Navbar */
        nav {
            background: var(--glass);
            backdrop-filter: blur(15px);
            border-bottom: 1px solid var(--border);
            padding: 1rem 8%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            text-decoration: none;
        }

        .logo-circle {
            width: 35px;
            height: 35px;
            background: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            animation: pulse 2s infinite;
        }

        .logo-text {
            font-size: 1.4rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            background: linear-gradient(90deg, #fff, #94a3b8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        nav ul {
            display: flex;
            list-style: none;
            gap: 2.5rem;
            align-items: center;
        }

        nav ul li a {
            text-decoration: none;
            color: var(--text-dim);
            font-weight: 500;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 0.95rem;
            position: relative;
        }

        nav ul li a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary);
            transition: 0.3s;
        }

        nav ul li a:hover::after, nav ul li a.active::after {
            width: 100%;
        }

        nav ul li a:hover, nav ul li a.active {
            color: #fff;
        }

        .container {
            max-width: 1100px;
            width: 100%;
            margin: 4rem auto;
            padding: 0 2rem;
            flex: 1;
        }

        footer {
            text-align: center;
            padding: 3rem;
            color: var(--text-dim);
            font-size: 0.85rem;
            border-top: 1px solid var(--border);
            background: rgba(0,0,0,0.2);
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 0.4rem 1rem;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-critical { background: var(--critical); box-shadow: 0 0 10px rgba(220, 38, 38, 0.4); }
        .badge-high { background: var(--high); }
        .badge-medium { background: var(--medium); color: #000; }
        .badge-low { background: var(--low); }

        .glass-card {
            background: var(--card);
            backdrop-filter: blur(10px);
            border: 1px solid var(--border);
            border-radius: 2rem;
            padding: 2.5rem;
            box-shadow: 0 20px 50px rgba(0,0,0,0.3);
        }

        @keyframes pulse {
            0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(244, 63, 94, 0.7); }
            70% { transform: scale(1.05); box-shadow: 0 0 0 10px rgba(244, 63, 94, 0); }
            100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(244, 63, 94, 0); }
        }

        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: var(--bg); }
        ::-webkit-scrollbar-thumb { background: #334155; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--primary); }

    </style>
    @yield('extra_css')
</head>
<body>
    <nav>
        <a href="{{ route('home') }}" class="logo-container">
            <div class="logo-circle">🆘</div>
            <div class="logo-text">Emergency Agent</div>
        </a>
        <ul>
            @auth
            <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
            <li><a href="{{ route('history') }}" class="{{ request()->routeIs('history') ? 'active' : '' }}">History</a></li>
            <li><a href="{{ route('nearby') }}" class="{{ request()->routeIs('nearby') ? 'active' : '' }}">Help Map</a></li>
            <li><a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Insights</a></li>
            <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">Agent AI</a></li>
            <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">Feedback</a></li>
            <li>
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" style="background: none; border: none; color: var(--primary); font-family: inherit; font-size: 0.95rem; font-weight: 700; cursor: pointer;">LOGOUT</button>
                </form>
            </li>
            @else
            <li><a href="{{ route('login') }}" style="color: #fff; font-weight: 700;">PROCEED TO LOGIN ➔</a></li>
            @endauth
        </ul>
        @auth
        <div style="font-size: 0.8rem; color: var(--text-dim); display: flex; align-items: center; gap: 10px;">
            <div style="width: 8px; height: 8px; background: var(--low); border-radius: 50%;"></div>
            AGENT: <strong>{{ strtoupper(Auth::user()->name) }}</strong>
        </div>
        @endauth
    </nav>

    <div class="container">
        @yield('content')
    </div>

    <footer>
        <p>&copy; {{ date('Y') }} <strong>Emergency Response Agentic System</strong>. All Rights Reserved.</p>
        <p style="margin-top: 0.5rem; font-size: 0.75rem; opacity: 0.6;">System Status: <span style="color: var(--low);">● Operational</span> (v1.2.0)</p>
    </footer>

    @yield('extra_js')
</body>
</html>

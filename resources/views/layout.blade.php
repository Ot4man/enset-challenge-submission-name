<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Emergency Response Agent')</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        }

        /* Navbar Styling */
        nav {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            padding: 1rem 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 800;
            background: linear-gradient(90deg, #fca5a5, #ef4444);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-decoration: none;
        }

        nav ul {
            display: flex;
            list-style: none;
            gap: 2rem;
            align-items: center;
        }

        nav ul li a {
            text-decoration: none;
            color: var(--text-dim);
            font-weight: 500;
            transition: all 0.3s;
            font-size: 0.95rem;
        }

        nav ul li a:hover, nav ul li a.active {
            color: var(--primary);
        }

        .container {
            max-width: 1000px;
            width: 100%;
            margin: 3rem auto;
            padding: 0 1.5rem;
            flex: 1;
        }

        footer {
            text-align: center;
            padding: 2rem;
            color: var(--text-dim);
            font-size: 0.8rem;
            border-top: 1px solid var(--border);
        }

        .badge {
            display: inline-block;
            padding: 0.3rem 0.8rem;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        .badge-critical { background: var(--critical); color: white; }
        .badge-high { background: var(--high); color: white; }
        .badge-medium { background: var(--medium); color: white; }
        .badge-low { background: var(--low); color: white; }

        .btn-primary {
            background: var(--primary);
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }
        .btn-primary:hover { opacity: 0.9; transform: translateY(-1px); }

        @media (max-width: 768px) {
            nav ul { display: none; } /* Mobile nav enhancement simplified */
        }
    </style>
    @yield('extra_css')
</head>
<body>
    <nav>
        <a href="{{ route('home') }}" class="logo">🆘 Emergency Agent</a>
        <ul>
            <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
            <li><a href="{{ route('history') }}" class="{{ request()->routeIs('history') ? 'active' : '' }}">History</a></li>
            <li><a href="{{ route('nearby') }}" class="{{ request()->routeIs('nearby') ? 'active' : '' }}">Nearby Help</a></li>
            <li><a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a></li>
            <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">About</a></li>
            <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a></li>
        </ul>
    </nav>

    <div class="container">
        @yield('content')
    </div>

    <footer>
        <p>&copy; {{ date('Y') }} Emergency Response Agent. Powered by Agentic AI Architecture.</p>
    </footer>

    @yield('extra_js')
</body>
</html>

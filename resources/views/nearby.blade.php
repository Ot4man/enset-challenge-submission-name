@extends('layout')

@section('title', 'Emergency Dispatch Tracker')

@section('extra_css')
<!-- Leaflet.js CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    .tracker-card { background: var(--card); border: 1px solid var(--border); border-radius: 2rem; padding: 2.5rem; }
    #map { height: 500px; width: 100%; border-radius: 1.5rem; margin-top: 2rem; border: 2px solid var(--border); z-index: 1; }
    
    .tracking-stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; margin-top: 2rem; }
    .stat-box { background: rgba(255,255,255,0.05); padding: 1.5rem; border-radius: 1rem; border-left: 4px solid var(--primary); }
    .stat-box h4 { font-size: 0.8rem; color: var(--text-dim); margin-bottom: 0.5rem; }
    .stat-box p { font-size: 1.2rem; font-weight: 800; color: #fff; }

    .pulse-marker { animation: pulseAnim 2s infinite; }
    @keyframes pulseAnim { 0% { opacity: 0.5; transform: scale(1); } 50% { opacity: 1; transform: scale(1.2); } 100% { opacity: 0.5; transform: scale(1); } }
</style>
@endsection

@section('content')
<div class="tracker-card">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1>📡 Live Rescue Tracker</h1>
            <p style="color: var(--text-dim);">Simulating real-time dispatch of nearest help units to your location.</p>
        </div>
        <div class="badge badge-low">GPS ACTIVE</div>
    </div>

    <div id="map"></div>

    <div class="tracking-stats">
        <div class="stat-box">
            <h4>NEAREST AMBULANCE</h4>
            <p id="dist-amb">1.2 km</p>
            <span style="font-size: 0.7rem; color: var(--low);">ETA: 4 MINS</span>
        </div>
        <div class="stat-box" style="border-left-color: var(--high);">
            <h4>FIRE TRUCK #402</h4>
            <p id="dist-fire">2.8 km</p>
            <span style="font-size: 0.7rem; color: var(--high);">EN ROUTE</span>
        </div>
        <div class="stat-box" style="border-left-color: #3b82f6;">
            <h4>PATROL UNIT #09</h4>
            <p id="dist-pol">0.5 km</p>
            <span style="font-size: 0.7rem; color: #3b82f6;">PATROLLING</span>
        </div>
    </div>
</div>
@endsection

@section('extra_js')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    // Initialize Map
    const map = L.map('map').setView([48.8566, 2.3522], 14); // Paris coordinates as example
    
    L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>'
    }).addTo(map);

    // User Location (Static Center)
    const userIcon = L.divIcon({
        className: 'user-marker',
        html: '<div style="background:var(--primary); width:20px; height:20px; border-radius:50%; border:3px solid white; box-shadow:0 0 15px var(--primary);"></div>',
        iconSize: [20, 20]
    });
    L.marker([48.8566, 2.3522], {icon: userIcon}).addTo(map).bindPopup("<b>YOU ARE HERE</b>").openPopup();

    // Emergency Unit Markers
    const units = [
        { name: 'Ambulance R1', pos: [48.8650, 2.3600], icon: '🚑', type: 'amb' },
        { name: 'Fire Engine 4', pos: [48.8480, 2.3400], icon: '🚒', type: 'fire' },
        { name: 'Patrol 09', pos: [48.8500, 2.3700], icon: '🚓', type: 'pol' }
    ];

    const markers = {};

    units.forEach(u => {
        const icon = L.divIcon({
            className: 'pulse-marker',
            html: `<div style="font-size:2rem; cursor:pointer;">${u.icon}</div>`,
            iconSize: [30, 30]
        });
        markers[u.type] = L.marker(u.pos, {icon: icon}).addTo(map).bindPopup(`<b>${u.name}</b><br>Priority Dispatch`);
    });

    // Simulate Movement
    setInterval(() => {
        units.forEach(u => {
            const m = markers[u.type];
            const currentPos = m.getLatLng();
            
            // Move slightly towards user (48.8566, 2.3522)
            const newLat = currentPos.lat + (48.8566 - currentPos.lat) * 0.05;
            const newLng = currentPos.lng + (2.3522 - currentPos.lng) * 0.05;
            
            m.setLatLng([newLat, newLng]);
            
            // Update distance simulation
            const dist = (Math.sqrt(Math.pow(newLat - 48.8566, 2) + Math.pow(newLng - 2.3522, 2)) * 111).toFixed(2);
            document.getElementById(`dist-${u.type}`).innerText = dist + " km";
        });
    }, 2000);

</script>
@endsection

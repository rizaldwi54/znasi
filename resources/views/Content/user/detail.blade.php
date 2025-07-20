@extends('Content.user.dashboard')

@section('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <style>
        #map {
            height: 400px;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-18">
                <div class="card">
                    <div class="card-header">Simple Map</div>
                    <div class="card-body">
                        <div id="map"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-18">
                <div class="card">
                    <div class="card-header">Detail Spot : {{ $spot->name }}</div>
                    <div class="card-body">
                        <p>
                        <h4><strong>Nama Spot :</strong></h4>
                        <h5>{{ $spot->name }}</h5>
                        </p>
                        <p>
                        <h4><strong>Detail :</strong></h4>
                        <h5>{{ $spot->description }}</h5>
                        </p>
                        <p>
                        <h4><strong>Gambar</strong></h4>
                        <img src="img-fluid" width="200" src="{{ $spot->getImageAsset() }}" alt="">
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('javascript')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        // const map = L.map('map').setView([-7.698539949863448, 109.02326311124153], 13);

        // Perbaikan: Gunakan object {} bukan array []
        var osm = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        });

        var Esri_WorldImagery = L.tileLayer(
            'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community'
            });

        var Esri_WorldStreetMap = L.tileLayer(
            'https://server.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer/tile/{z}/{y}/{x}', {
                attribution: 'Tiles &copy; Esri &mdash; Source: Esri, DeLorme, NAVTEQ, USGS, Intermap, iPC, NRCAN, Esri Japan, METI, Esri China (Hong Kong), Esri (Thailand), TomTom, 2012'
            });
        var map = L.map('map', {
            center: [{{ $centerPoint->coordinates }}],
            zoom: 10,
            layers: [osm],
            fullscreenControl: {
                pseudoFullscreen: false
            }
        })

        var circle = L.circle([{{ $centerPoint->coordinates }}], {
            color: 'red',
            fillColor: '#f03',
            fillOpacity: 0.5,
            radius: 1000
        }).addTo(map)

        const baseLayers = {
            'OpenStreetMap': osm,
            'Esri_WorldImagery': Esri_WorldImagery,
            'Esri_WorldStreetMap': Esri_WorldStreetMap
        }

        const layerControl = L.control.layers(baseLayers).addTo(map)
        var curLocation = [{{ $spot->coordinates }}]

        var marker = new L.marker(curLocation, {
            draggable: false
        })
        map.addLayer(marker)
        function onLocationFound(e) {
                

                const locationMarker = L.marker(e.latlng).addTo(map)
                    .bindPopup(`You in here`).openPopup();

                const locationCircle = L.circle(e.latlng, radius).addTo(map);
            }

            function onLocationError(e) {
                alert(e.message);
            }

            map.on('locationfound', onLocationFound);
            map.on('locationerror', onLocationError);

            map.locate({
                setView: true,
                maxZoom: 16
            });
    </script>
@endpush

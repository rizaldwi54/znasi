@extends('Content.user.dashboard')

@section('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet-search@4.0.0/dist/leaflet-search.src.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet.fullscreen@4.0.0/Control.FullScreen.min.css">
@endsection

@section('content')
    <div class="container my-4">
        <div class="row justify-content-center">
            <div class="col-left-6">
                <div class="card">
                    <div class="card-header">Map Spot</div>
                    <div class="card-body">
                        <div id="map" style="height: 400px"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('javascript')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <script src="https://cdn.jsdelivr.net/npm/leaflet-search@4.0.0/dist/leaflet-search.src.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/leaflet.fullscreen@4.0.0/Control.FullScreen.min.js"></script>

    <script>
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
            center: [{{$centerPoint->coordinates}}],
            zoom: 10,
            layers: [osm],
            fullscreenControl: {
                pseudoFullscreen: false
            }
        })

        const baseLayers = {
            'OpenStreetMap': osm,
            'Esri_WorldImagery': Esri_WorldImagery,
            'Esri_WorldStreetMap': Esri_WorldStreetMap
        }

        var datas = [
            @foreach ( $spot as $key => $value)
                {
                    "loc" :[{{ $value->coordinates }}],
                    "title" : '{{!! $value->name !!}}'
                },
            @endforeach
        ]

        var markersLayer = new L.layerGroup()
        map.addLayer(markersLayer)

        var controlSearch = new L.Control.Search({
            position: 'topleft',
            layer: markersLayer,
            zoom: 12,
            markerLocation: false
        })
        
        map.addControl(controlSearch)

        for (i in data) {
            var title = data[i].title,
                loc = data[i].loc,
                marker = new L.marker(new L.latLng(loc), {
                    title: title
                })
            markersLayer.addLayer(marker)

            @foreach ($spot as $item )
                L.marker([{{ $item->coordinates }}]).bindPopup(
                    "<div class='my-2'><img src='{{ $item->getImageAsset() }}' class='img-fluid' width='700px'></div>" +
                    "<div class='my-2'><strong>Nama Spot : </strong> <br>{{ $item->name }}</div>" +
                    "<div><a href='{{ route('detail-spot',$item->slug) }}' class='btn btn-outline btn-info'>Detail Spot</a></div>"
                ).addTo(map)
            @endforeach
        }

        const layerControl = L.control.layers(baseLayers).addTo(map)

        
    </script>
@endpush

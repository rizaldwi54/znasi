@extends('Content.admin.dashboard')

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
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Simple Map</div>
                    <div class="card-body">
                        <div id="map"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Titik Koordinat</div>
                    <div class="card-body">
                        <form action="{{ route('center-point.store') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="">Koordinat</label>
                                    <input type="text" class="form-control @error('coordinate')
                                        is-invalid
                                    @enderror" name="coordinate" id="coordinate">
                                    @error('coordinate')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="">Latitude</label>
                                    <input type="text" class="form-control" name="latitude" id="latitude">
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="">Longitude</label>
                                    <input type="text" class="form-control" name="longitude" id="longitude">
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-sm my-2">Simpan</button>
                            </div>
                        </form>
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
            center: [-7.698539949863448, 109.02326311124153],
            zoom: 13,
            layers: [osm]
        })

        var marker = L.marker([-7.67363, 109.05808], {
            draggable: true
        }).addTo(map);

        var baseMaps = {
            'OpenStreetMap': osm,
            'Esri_WorldImagery': Esri_WorldImagery,
            'Esri_WorldStreetMap': Esri_WorldStreetMap
        }

        L.control.layers(baseMaps).addTo(map)

        // Cara Pertama
        function onMapClick(e){
            var coords = document.querySelector("[name=coordinate]")
            var latitude = document.querySelector("[name=latitude]")
            var longitude = document.querySelector("[name=longitude]")
            var lat = e.latlng.lat
            var lng = e.latlng.lng

            if (!marker) {
                marker = L.marker(e.latlng).addTo(map)
            } else {
                marker.setLatLng(e.latlng)
            }

            coords.value = lat + "," + lng
            latitude.value = lat,
            longitude.value = lng
        }
        map.on('click',onMapClick)
        // Cara Pertama

        // Cara Kedua
        // marker.on('dragend',function(){
        //     var coordinate = marker.getLangLng();
        //     marker.setLatLng(coordinate, {
        //         draggable:true
        //     })
        //     $('#coordinate').vol(coordinate.lat + "," + coordinate.lng).keyup()
        //     $('#latitude').vol(coordinate.lat).keyup()
        //     $('#longitude').vol(coordinate.lng).keyup()
        // })
        // Cara Kedua
        // function onEachFeature(feature, layer) {
        //     let popupContent = `Data GeoJson ${feature.geometry.type}`

        //     if (feature.properties && feature.properties.popupContent) {
        //         popupContent += feature.properties.popupContent
        //     }

        //     layer.bindPopup(popupContent);
        // }

        // const geoJson = L.geoJSON(school, {
        //     style(feature) {
        //         return feature.properties && feature.properties.style
        //     },
        //     onEachFeature,

        // }).addTo(map);

        // const layerControl = L.control.layers(baseLayers).addTo(map);

        // // Cara Pertama
        // function onMapClick(e) {
        //     var coords = document.querySelector(["[name=coordinate]"])
        //     var latitude = document.querySelector(["[name=latitude]"])
        //     var longitude = document.querySelector(["[name=longitude]"])
        //     var lat = e.latlng.lat
        //     var lng = e.latlng.lng

        //     if (!marker) {
        //         marker = L.marker(e.latlng).addTo(map)
        //     } else {
        //         marker.setLatLng(e.latlng)
        //     }
        //     // coords.value = `${lat}, ${lng}`
        //     coords.value = lat + "," + lng
        //     latitude.value = lat,
        //     longitude.value = lng
        // }
        //     map.on('click', onMapClick);
        
    </script>
@endpush

<!--
=========================================================
* Corporate UI - v1.0.0
=========================================================

* Product Page: https://www.creative-tim.com/product/corporate-ui
* Copyright 2022 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="/assets/img/iot/favicon.png">
    <link rel="icon" type="image/png" href="/assets/img/iot/favicon.png">
    <title>
        IAN Monitoring Platform
    </title>
    {{-- <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Noto+Sans:300,400,500,600,700,800|PT+Mono:300,400,500,600,700"
        rel="stylesheet" /> --}}
    <link href="/assets/css/all.css" rel="stylesheet" />
    <link rel="stylesheet" href="/assets/css/iot.css">
    <style>
        #map {
            width: "100%";
            height: 600px;
        }
    </style>
    <link id="pagestyle" href="/assets/css/corporate-ui-dashboard.css?v=1.0.0" rel="stylesheet" />
    <link href="/assets/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="/assets/css/daterangepicker.css" rel="stylesheet" />
    @livewireStyles()
</head>

<body class="g-sidenav-show  bg-gray-100">
    @include('layouts.sidebar')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        @include('layouts.navbar')
        <!-- End Navbar -->
        <div class="container-fluid py-4 px-5">
            @yield('container')
            @include('layouts.footer')
        </div>
    </main>
    <!--   Core JS Files   -->
    <script src="/assets/js/jquery-3.5.1.js"></script>
    <script src="/assets/js/core/popper.min.js"></script>
    <script src="/assets/js/core/bootstrap.min.js"></script>
    {{-- <script src="/assets/js/plugins/perfect-scrollbar.min.js"></script> --}}
    <script src="/assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script src="/assets/js/plugins/chartjs.min.js"></script>
    <script src="/assets/js/plugins/swiper-bundle.min.js" type="text/javascript"></script>
    <script src="/assets/js/all.js"></script>
    <script src="/assets/js/jquery.dataTables.min.js"></script>
    <script src="/assets/js/dist/echarts.js"></script>
    <script src="/assets/js/moment.min.js"></script>
    <script src="/assets/js/daterangepicker.min.js"></script>

    @if (Request::is('devices'))
        <script>
            $(document).ready(function() {
                $('#device_list').DataTable({
                    "processing": false, //Feature control the processing indicator.
                    "serverSide": true, //Feature control DataTables' server-side processing mode.
                    "ajax": {
                        "url": "{{ url('alldevices') }}",
                        "type": "POST",
                        "data": {
                            _token: "{{ csrf_token() }}"
                        }
                    },
                });
            });
        </script>
    @endif
    @if (Request::is('sites'))
        <script>
            $(document).ready(function() {
                $('#site_list').DataTable({
                    "processing": false, //Feature control the processing indicator.
                    "serverSide": true, //Feature control DataTables' server-side processing mode.
                    "ajax": {
                        "url": "{{ url('allsites') }}",
                        "type": "POST",
                        "data": {
                            _token: "{{ csrf_token() }}"
                        }
                    },
                });
            });
        </script>
    @endif
    @if (Request::is('sites') || Request::is('sites/*/*'))
        <script>
            function initMap() {
                @if (Request::is('sites/*/*'))
                    const myLatlng = {
                        lat: {{ $site->lat }},
                        lng: {{ $site->lng }}
                    };
                @elseif (Request::is('sites'))
                    const myLatlng = {
                        lat: -6.193739172824711,
                        lng: 106.76588773727418
                    };
                @endif


                const map = new google.maps.Map(document.getElementById("googleMap"), {
                    zoom: 15,
                    center: myLatlng,
                    streetViewControl: false,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    gestureHandling: "greedy",
                });


                // Create the initial InfoWindow.
                let infoWindow = new google.maps.InfoWindow({
                    content: "Click the map to get Lat/Lng!",
                    position: myLatlng,
                });

                infoWindow.open(map);
                const input = document.getElementById("pac-input");
                const autocomplete = new google.maps.places.Autocomplete(input);
                google.maps.event.addListener(autocomplete, 'place_changed', function() {
                    var place = autocomplete.getPlace();
                    infoWindow.close();
                    infoWindow = new google.maps.InfoWindow({
                        position: {
                            lat: place.geometry.location.lat(),
                            lng: place.geometry.location.lng()
                        },
                    });
                    infoWindow.setContent(
                        JSON.stringify({
                            lat: place.geometry.location.lat(),
                            lng: place.geometry.location.lng()
                        }, null, 2)

                    );
                    infoWindow.open(map);
                    $("#site-latitude").val(place.geometry.location.lat());
                    $("#site-longitude").val(place.geometry.location.lng());
                });

                // Configure the click listener.
                map.addListener("click", (mapsMouseEvent) => {
                    // Close the current InfoWindow.
                    infoWindow.close();

                    // Create a new InfoWindow.
                    infoWindow = new google.maps.InfoWindow({
                        position: mapsMouseEvent.latLng,
                    });
                    infoWindow.setContent(
                        JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2)

                    );
                    infoWindow.open(map);
                    $("#site-latitude").val(mapsMouseEvent.latLng.toJSON().lat);
                    $("#site-longitude").val(mapsMouseEvent.latLng.toJSON().lng);
                });

            }
            $(document).ready(
                initMap
            );
        </script>
        <script type="text/javascript"
            src="https://maps.google.com/maps/api/js?key=AIzaSyAkvuKagRiFJGavzz2vXIhRJ4SWbd-A3-Y&libraries=places"></script>
    @endif
    @if (Request::is('sites/*') && !Request::is('sites/*/*'))
        <script>
            function initMap() {
                const myLatlng = {
                    lat: {{ $site->lat }},
                    lng: {{ $site->lng }}
                };
                const map = new google.maps.Map(document.getElementById("map"), {
                    zoom: 10,
                    center: myLatlng,
                    streetViewControl: false,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    // gestureHandling: "cooperative",
                    // zoomControl: false,
                });
                new google.maps.Marker({
                    position: myLatlng,
                    map,
                    // title: "Hello Gora!",
                });

            }
            $(document).ready(
                initMap
            );
            $(document).ready(function() {
                let getLiveData = function() {
                    @foreach ($site->devices as $device)
                        $.ajax({
                            type: 'POST',
                            url: '{{ url('livedata_overview') }}',
                            async: true,
                            dataType: 'json',
                            data: {
                                _token: "{{ csrf_token() }}",
                                device_id: "{{ $device->id }}",
                            },
                            success: function(data) {
                                @foreach ($device->parameters as $parameter)
                                    $('#live_{{ $parameter->slug }}').html(data.value[
                                            '{{ $parameter->slug }}'] ? data.value[
                                            '{{ $parameter->slug }}'] + ' ' +
                                        '{{ $parameter->unit }}' : "NULL");
                                    $('#updated_{{ $parameter->slug }}').html(data.value[
                                        'created_at'] ? data.value[
                                        'created_at'] : "NULL");
                                @endforeach
                            }
                        });
                    @endforeach
                }
                getLiveData();
                setInterval(getLiveData, 5000);
            });
        </script>
        <script type="text/javascript"
            src="https://maps.google.com/maps/api/js?key=AIzaSyAkvuKagRiFJGavzz2vXIhRJ4SWbd-A3-Y&libraries=places"></script>
    @endif

    @if (Request::is('devices/*') && !Request::is('devices/*/*'))
        <script>
            $(function() {
                var start = moment().startOf('hour');
                var end = moment().startOf('hour').add(32, 'hour');

                function cb_date(start, end) {
                    $('#datetimerange span').html(start.format('YYYY-MM-DD HH:mm:ss') + ' To ' + end.format(
                        'YYYY-MM-DD HH:mm:ss'));
                    // window.location.replace('google.com');
                    window.location.replace("{{ url('devices') }}/{{ $device->uuid }}?from=" + start +
                        "&to=" + end);
                }
                $('#datetimerange').daterangepicker({
                    timePicker: true,
                    // startDate: start,
                    // endDate: end,
                    // startDate: moment().startOf('hour'),
                    // endDate: moment().startOf('hour').add(32, 'hour'),
                    locale: {
                        separator: " to ",
                        format: 'YYYY-MM-DD HH:mm:ss'
                    }
                }, cb_date);
                // cb_date(start, end);
            });
            $(document).ready(function() {
                $('#parameter_list').DataTable({
                    "processing": false, //Feature control the processing indicator.
                    "serverSide": true, //Feature control DataTables' server-side processing mode.
                    "ajax": {
                        "url": "{{ url('allparameters') }}",
                        "type": "POST",
                        "data": {
                            _token: "{{ csrf_token() }}",
                            device_id: "{{ $device->id }}",
                            device_uuid: "{{ $device->uuid }}"
                        }
                    },
                });
                $('#alert_list').DataTable({
                    "processing": false, //Feature control the processing indicator.
                    "serverSide": true, //Feature control DataTables' server-side processing mode.
                    "ajax": {
                        "url": "{{ url('allalerts') }}",
                        "type": "POST",
                        "data": {
                            _token: "{{ csrf_token() }}",
                            device_id: "{{ $device->id }}",
                        }
                    },
                });
                $('#historical_log').DataTable({
                    "processing": false, //Feature control the processing indicator.
                    "serverSide": true, //Feature control DataTables' server-side processing mode.
                    "ajax": {
                        "url": "{{ url('historicallog') }}",
                        "type": "POST",
                        "data": {
                            _token: "{{ csrf_token() }}",
                            device_id: "{{ $device->id }}",
                            parameters: {!! $parameters->map(function ($query) {
                                return $query->slug;
                            }) !!}
                        }
                    }
                });
            });
            $(document).ready(function() {
                let getLiveData = function() {
                    $.ajax({
                        type: 'POST',
                        url: '{{ url('livedata') }}',
                        async: true,
                        dataType: 'json',
                        data: {
                            _token: "{{ csrf_token() }}",
                            device_id: "{{ $device->id }}",
                            range: "{{ $range }}",
                            from: {{ $from }},
                            to: {{ $to }}
                        },
                        success: function(data) {
                            @foreach ($parameters_number as $parameter)
                                window.{{ $charts['charts_gauge'][$loop->index]->id }}
                                    .setOption({
                                        series: [{
                                            data: [{
                                                value: data.value[
                                                    '{{ $parameter->slug }}'
                                                ]
                                            }]
                                        }]
                                    });
                                window.{{ $charts['charts_line'][$loop->index]->id }}
                                    .setOption({
                                        series: [{
                                            data: data.log.map(
                                                function(row) {
                                                    return [row[
                                                        'created_at'
                                                    ], row[
                                                        '{{ $parameter->slug }}'
                                                    ]];
                                                })
                                        }]
                                    });
                            @endforeach
                            @foreach ($parameters_string as $parameter)
                                $('#live_{{ $parameter->slug }}').html(data.value[
                                    '{{ $parameter->slug }}'] ? data.value[
                                    '{{ $parameter->slug }}'] : "NULL");
                                $('#previous_{{ $parameter->slug }}').html(data.log[1] !== undefined ?
                                    (data.log[1][
                                        '{{ $parameter->slug }}'
                                    ] ? data.log[1][
                                        '{{ $parameter->slug }}'
                                    ] : "NULL") : "NULL");
                            @endforeach
                        }
                    });
                }
                getLiveData();
                setInterval(getLiveData, 5000);
            });
        </script>
    @endif

    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    {{-- <script>
        $(document).ready(function() {
            var span = document.getElementById('clock');

            function time() {
                var d = new Date();
                var s = d.getSeconds();
                var m = d.getMinutes();
                var h = d.getHours();
                span.textContent =
                    ("0" + h).substr(-2) + ":" + ("0" + m).substr(-2) + ":" + ("0" + s).substr(-2);
            }
            setInterval(time, 1000);
        });
    </script> --}}


    @if (Request::is('/'))
        <script type="text/javascript">
            function initMap() {
                const myLatLng = {
                    lat: -6.2734719,
                    lng: 120.7512559
                };
                const map = new google.maps.Map(document.getElementById("map"), {
                    zoom: 5,
                    center: myLatLng,
                });

                new google.maps.Marker({
                    position: myLatLng,
                    map,
                    title: "Hello Gora!",
                });
            }

            window.initMap = initMap;
        </script>
        <script type="text/javascript" src="https://maps.google.com/maps/api/js?key=&callback=initMap"></script>
    @endif
    <!-- Github buttons -->
    <!-- Control Center for Corporate UI Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="/assets/js/corporate-ui-dashboard.js?v=1.0.0"></script>
    @livewireScripts()
</body>

</html>

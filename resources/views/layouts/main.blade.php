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
    <script src="/assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="/assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script src="/assets/js/plugins/chartjs.min.js"></script>
    <script src="/assets/js/plugins/swiper-bundle.min.js" type="text/javascript"></script>
    <script src="/assets/js/all.js"></script>
    <script src="/assets/js/jquery.dataTables.min.js"></script>
    <script src="/assets/js/dist/echarts.js"></script>
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
    @if (Request::is('devices/*') && !Request::is('devices/*/*'))
        <script>
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
                            device_id: "{{ $device->id }}"
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
            @if ($parameters_number->count())
                $(document).ready(function() {
                    setInterval(function() {
                        $.ajax({
                            type: 'POST',
                            url: '/livedata',
                            async: true,
                            dataType: 'json',
                            data: {
                                _token: "{{ csrf_token() }}",
                                device_id: "{{ $device->id }}"
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
                            }
                        });
                    }, 5000);
                });
            @endif
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
    <script>
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
    </script>


    @if (Request::is('/'))
        <script type="text/javascript" src="https://maps.google.com/maps/api/js?key=&callback=initMap"></script>
    @endif
    <!-- Github buttons -->
    <!-- Control Center for Corporate UI Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="/assets/js/corporate-ui-dashboard.min.js?v=1.0.0"></script>
    @livewireScripts()
</body>

</html>

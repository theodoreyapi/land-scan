@extends('layouts.master', [
    'title' => 'Tableau de bord',
])

@push('csss')
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/select2/css/select2.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/fontawesome/css/all.min.css">

    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/css/bootstrap-datetimepicker.min.css">

    <!-- Bootstrap Tagsinput CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css">

    <!-- Summernote CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/summernote/summernote-lite.min.css">

    <!-- Daterangepikcer CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/daterangepicker/daterangepicker.css">

    <!-- Color Picker Css -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/flatpickr/flatpickr.min.css">
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/@simonwep/pickr/themes/nano.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/css/style.css">
@endpush

@push('scripts')
    <!-- Slimscroll JS -->
    <script src="{{ URL::asset('') }}assets/js/jquery.slimscroll.min.js"></script>

    <!-- Chart JS -->
    <script src="{{ URL::asset('') }}assets/plugins/apexchart/apexcharts.min.js"></script>
    <script src="{{ URL::asset('') }}assets/plugins/apexchart/chart-data.js"></script>

    <!-- Chart JS -->
    <script src="{{ URL::asset('') }}assets/plugins/chartjs/chart.min.js"></script>
    <script src="{{ URL::asset('') }}assets/plugins/chartjs/chart-data.js"></script>

    <!-- Datetimepicker JS -->
    <script src="{{ URL::asset('') }}assets/js/moment.js"></script>
    <script src="{{ URL::asset('') }}assets/js/bootstrap-datetimepicker.min.js"></script>

    <!-- Daterangepikcer JS -->
    <script src="{{ URL::asset('') }}assets/plugins/daterangepicker/daterangepicker.js"></script>

    <!-- Summernote JS -->
    <script src="{{ URL::asset('') }}assets/plugins/summernote/summernote-lite.min.js"></script>

    <!-- Bootstrap Tagsinput JS -->
    <script src="{{ URL::asset('') }}assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>

    <!-- Select2 JS -->
    <script src="{{ URL::asset('') }}assets/plugins/select2/js/select2.min.js"></script>

    <!-- Color Picker JS -->
    <script src="{{ URL::asset('') }}assets/plugins/@simonwep/pickr/pickr.es5.min.js"></script>

    <!-- Custom JS -->
    <script src="{{ URL::asset('') }}assets/js/todo.js"></script>
    <script src="{{ URL::asset('') }}assets/js/theme-colorpicker.js"></script>
    <script src="{{ URL::asset('') }}assets/js/script.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/10.3.1/highcharts.js"></script>
    <script>
        document.querySelectorAll('.event-item').forEach(item => {
            item.addEventListener('click', function() {
                const eventId = this.getAttribute('data-id');

                fetch("{{ url('/dashboard/event') }}/" + eventId + "/stats")
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            alert("Erreur : " + data.message);
                            return;
                        }

                        document.getElementById('stats-zone').innerHTML = `
                        <h5>Statistiques</h5>
                        <ul class="list-group">
                            <li class="list-group-item"><strong>Tickets :</strong> ${data.stats.nbTickets}</li>
                            <li class="list-group-item"><strong>Portes :</strong> ${data.stats.nbPortes}</li>
                            <li class="list-group-item"><strong>Stades :</strong> ${data.stats.nbStades}</li>
                            <li class="list-group-item"><strong>Agents - Association :</strong> ${data.stats.nbAgents}</li>
                            <li class="list-group-item"><strong>Total Tickets Validés :</strong> ${data.stats.totalTicketsValides}</li>
                        </ul>

                        <h6 class="mt-4">Tickets validés par agent</h6>
                        <ul class="list-group">
                            ${
                                data.stats.ticketsParAgent.length > 0
                                    ? data.stats.ticketsParAgent.map(agent =>
                                        `<li class="list-group-item">
                                                        ${agent.agent_name} : ${agent.tickets_valides} tickets validés
                                                    </li>`).join('')
                                    : '<li class="list-group-item">Aucun ticket validé par un agent.</li>'
                            }
                        </ul>
                        <div id="chart-container" style="height: 300px; margin-top: 20px;"></div>
                    `;

                        Highcharts.chart('chart-container', {
                            chart: {
                                type: 'column'
                            },
                            title: {
                                text: 'Statistiques de l’événement'
                            },
                            xAxis: {
                                categories: data.chart.labels
                            },
                            yAxis: {
                                title: {
                                    text: 'Valeurs'
                                },
                                allowDecimals: false
                            },
                            series: [{
                                name: 'Valeurs',
                                data: data.chart.values
                            }]
                        });

                    })
                    .catch(error => {
                        console.error('Erreur AJAX :', error);
                        alert("Erreur lors du chargement des statistiques.");
                    });
            });
        });
    </script>
@endpush

@section('content')
    <div class="content">
        <!-- Breadcrumb -->
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">Tableau de bord</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="#"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            Tableau de bord
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Tableau de bord</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap ">
                <div class="mb-2">
                    <div class="input-icon w-120 position-relative">
                        <span class="input-icon-addon">
                            <i class="ti ti-calendar text-gray-9"></i>
                        </span>
                        <input type="text" class="form-control yearpicker" value="2025">
                    </div>
                </div>
                <div class="ms-2 head-icons">
                    <a href="javascript:void(0);" class="" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-original-title="Collapse" id="collapse-header">
                        <i class="ti ti-chevrons-up"></i>
                    </a>
                </div>
            </div>
        </div>
        <!-- /Breadcrumb -->

        <div class="row">
            <!-- Liste des événements -->
            <div class="col-md-4">
                <h5>Événements actifs</h5>
                <ul class="list-group" id="event-list">
                    @foreach ($events as $event)
                        <li class="list-group-item event-item" data-id="{{ $event->event_id }}" style="cursor:pointer;">
                            <h5>{{ $event->event_name }}</h5>
                            <small>{{ $event->event_date }} à {{ $event->event_time }} - {{ $event->event_date_fin }} à
                                {{ $event->event_time_fin }}</small>
                        </li>
                        <br>
                    @endforeach
                </ul>
            </div>

            <!-- Zone de stats -->
            <div class="col-md-8" id="stats-zone">
                <p>Sélectionnez un événement pour voir ses statistiques.</p>
            </div>
        </div>
    </div>
@endsection

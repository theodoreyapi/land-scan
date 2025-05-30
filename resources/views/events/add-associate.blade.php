@extends('layouts.master', [
    'title' => 'Tickets',
])

@push('csss')
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/select2/css/select2.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/fontawesome/css/all.min.css">

    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/css/bootstrap-datetimepicker.min.css">

    <!-- Color Picker Css -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/flatpickr/flatpickr.min.css">
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/@simonwep/pickr/themes/nano.min.css">

    <!-- Daterangepikcer CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/daterangepicker/daterangepicker.css">

    <!-- Datatable CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/css/dataTables.bootstrap5.min.css">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/select2/css/select2.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/css/style.css">
@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Slimscroll JS -->
    <script src="{{ URL::asset('') }}assets/js/jquery.slimscroll.min.js"></script>

    <!-- Color Picker JS -->
    <script src="{{ URL::asset('') }}assets/plugins/@simonwep/pickr/pickr.es5.min.js"></script>

    <!-- Datatable JS -->
    <script src="{{ URL::asset('') }}assets/js/jquery.dataTables.min.js"></script>
    <script src="{{ URL::asset('') }}assets/js/dataTables.bootstrap5.min.js"></script>

    <!-- Daterangepikcer JS -->
    <script src="{{ URL::asset('') }}assets/js/moment.js"></script>
    <script src="{{ URL::asset('') }}assets/plugins/daterangepicker/daterangepicker.js"></script>
    <script src="{{ URL::asset('') }}assets/js/bootstrap-datetimepicker.min.js"></script>

    <!-- Select2 JS -->
    <script src="{{ URL::asset('') }}assets/plugins/select2/js/select2.min.js"></script>

    <!-- Chart JS -->
    <script src="{{ URL::asset('') }}assets/plugins/apexchart/apexcharts.min.js"></script>
    <script src="{{ URL::asset('') }}assets/plugins/apexchart/chart-data.js"></script>

    <!-- Custom JS -->
    <script src="{{ URL::asset('') }}assets/js/theme-colorpicker.js"></script>
    <script src="{{ URL::asset('') }}assets/js/script.js"></script>

    <script>
        $('#depart').on('change', function() {
            var communeId = $(this).val();
            $('#pharmacies-list').html('Chargement...');

            if (communeId) {
                $.ajax({
                    url: '/tickets/event/' + communeId, // ici tu pointes vers ton contrôleur
                    type: 'GET',
                    success: function(response) {
                        let html = '';

                        if (response && response.length > 0) {
                            response.forEach(function(item, index) {
                                html += `
                                <div class="col-sm-4 mb-3">
                                    <div class="ticket-card d-flex align-items-center gap-2">
                                        <input class="form-check-input me-2" id="ticket_${index}"
                                            type="checkbox" name="tickets[]" value="${item.ticket_id}">
                                        <label for="ticket_${index}"
                                            class="d-flex align-items-center gap-2 m-0 w-100">
                                            <span class="text-secondary-light fw-medium">
                                                ${item.ticket_code}
                                            </span>
                                            <span class="text-secondary-light fw-medium">
                                                ${item.ticket_st}
                                            </span>
                                            <br>
                                            <span class="text-secondary-light fw-medium">
                                                ${item.ticket_free}
                                            </span>
                                            <br>
                                            <span class="text-secondary-light fw-medium">
                                                ${item.ticket_seas ?? ''}
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            `;
                            });
                        } else {
                            html =
                                '<div class="col-12"><p class="text-muted">Aucun ticket trouvé pour cet évènement.</p></div>';
                        }

                        $('#pharmacies-list').html(html);
                    },
                    error: function() {
                        $('#pharmacies-list').html(
                            '<div class="col-12"><p class="text-danger">Erreur lors de la récupération des tickets.</p></div>'
                        );
                    }
                });
            } else {
                $('#pharmacies-list').html('');
            }
        });

        $(document).on('change', 'input[name="tickets[]"]', function() {
            if ($(this).is(':checked')) {
                $(this).closest('.ticket-card').addClass('active');
            } else {
                $(this).closest('.ticket-card').removeClass('active');
            }
        });
    </script>
@endpush

@section('content')
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">Associations</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ url('index') }}"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            Tickets
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Association</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- /Breadcrumb -->

        @include('layouts.status')

        <style>
            .porte-card {
                border: 2px solid transparent;
                border-radius: 10px;
                padding: 10px;
                cursor: pointer;
                transition: border-color 0.3s;
            }

            .porte-card input[type="checkbox"] {
                width: 20px;
                height: 20px;
                cursor: pointer;
            }

            .porte-card.active {
                border-color: #03C95A;
                /* Bleu Bootstrap */
            }

            .porte-card img {
                width: 50px;
                height: 50px;
                object-fit: cover;
                border-radius: 8px;
            }

            .ticket-card {
                border: 2px solid transparent;
                border-radius: 10px;
                padding: 10px;
                cursor: pointer;
                transition: border-color 0.3s;
            }

            .ticket-card input[type="checkbox"] {
                width: 20px;
                height: 20px;
                cursor: pointer;
            }

            .ticket-card.active {
                border-color: #4E81EE;
                /* Bleu Bootstrap */
            }

            .ticket-card img {
                width: 50px;
                height: 50px;
                object-fit: cover;
                border-radius: 8px;
            }

            .agent-card {
                border: 2px solid transparent;
                border-radius: 10px;
                padding: 10px;
                cursor: pointer;
                transition: border-color 0.3s;
            }

            .agent-card input[type="checkbox"] {
                width: 20px;
                height: 20px;
                cursor: pointer;
            }

            .agent-card.active {
                border-color: orange;
            }

            .agent-card img {
                width: 50px;
                height: 50px;
                object-fit: cover;
                border-radius: 8px;
            }

            .form-check-input {
                width: 20px;
                height: 20px;
                cursor: pointer;
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const cards = document.querySelectorAll('.ticket-card');

                cards.forEach(card => {
                    const checkbox = card.querySelector('input[type="checkbox"]');

                    // Lorsqu'on clique sur la carte entière
                    card.addEventListener('click', () => {
                        // Simule un clic sur la checkbox (le navigateur gère checked automatiquement)
                        checkbox.click();
                    });

                    // Quand la checkbox change (checked ou non)
                    checkbox.addEventListener('change', () => {
                        if (checkbox.checked) {
                            card.classList.add('active');
                        } else {
                            card.classList.remove('active');
                        }
                    });

                    // Empêche que le clic direct sur le checkbox déclenche aussi le clic sur la carte
                    checkbox.addEventListener('click', e => e.stopPropagation());
                });
            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const cards = document.querySelectorAll('.agent-card');

                cards.forEach(card => {
                    const checkbox = card.querySelector('input[type="checkbox"]');

                    // Lorsqu'on clique sur la carte entière
                    card.addEventListener('click', () => {
                        // Simule un clic sur la checkbox (le navigateur gère checked automatiquement)
                        checkbox.click();
                    });

                    // Quand la checkbox change (checked ou non)
                    checkbox.addEventListener('change', () => {
                        if (checkbox.checked) {
                            card.classList.add('active');
                        } else {
                            card.classList.remove('active');
                        }
                    });

                    // Empêche que le clic direct sur le checkbox déclenche aussi le clic sur la carte
                    checkbox.addEventListener('click', e => e.stopPropagation());
                });
            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const cards = document.querySelectorAll('.porte-card');

                cards.forEach(card => {
                    const checkbox = card.querySelector('input[type="checkbox"]');

                    // Lorsqu'on clique sur la carte entière
                    card.addEventListener('click', () => {
                        // Simule un clic sur la checkbox (le navigateur gère checked automatiquement)
                        checkbox.click();
                    });

                    // Quand la checkbox change (checked ou non)
                    checkbox.addEventListener('change', () => {
                        if (checkbox.checked) {
                            card.classList.add('active');
                        } else {
                            card.classList.remove('active');
                        }
                    });

                    // Empêche que le clic direct sur le checkbox déclenche aussi le clic sur la carte
                    checkbox.addEventListener('click', e => e.stopPropagation());
                });
            });
        </script>

        <form action="{{ route('associations.store') }}" method="POST" role="form">
            @csrf
            <div class="col-md-12 card">
                <div class="mb-3 card-header">
                    <label class="form-label">Évènement <span class="text-danger">
                            *</span></label>
                    <br>
                </div>
                <div class="card-body">
                    <select name="event" required class="select" id="depart">
                        <option value="">Sélectionne</option>
                        @foreach ($events as $item)
                            <option value="{{ $item->event_id }}">
                                {{ $item->event_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                    <h5>TICKETS</h5>
                </div>
                <div class="card-body">
                    <div class="row mt-3" id="pharmacies-list">

                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                    <h5>AGENTS</h5>
                </div>
                <div class="card-body row">
                    @foreach ($agents as $key => $item)
                        <div class="col-sm-4 mb-3">
                            <div class="agent-card d-flex align-items-center gap-2">
                                <input class="form-check-input me-2" id="agent_{{ $key }}" type="checkbox"
                                    name="agents[]" value="{{ $item->agent_id }}">
                                <label for="agent_{{ $key }}"
                                    class="d-flex align-items-center gap-2 m-0 w-100">
                                    <img src="{{ $item->agent_photo != null ? URL::asset('agents/' . $item->agent_photo) : URL::asset('assets/img/users/user-01.jpg') }}"
                                        alt="{{ $item->agent_name }}">
                                    <span class="text-secondary-light fw-medium">
                                        {{ $item->agent_name }}
                                    </span>
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                    <h5>PORTES</h5>
                </div>
                <div class="card-body row">
                    @foreach ($portes as $key => $item)
                        <div class="col-sm-4 mb-3">
                            <div class="porte-card d-flex align-items-center gap-2">
                                <input class="form-check-input me-2" id="porte_{{ $key }}" type="checkbox"
                                    name="portes[]" value="{{ $item->porte_id }}">
                                <label for="porte_{{ $key }}"
                                    class="d-flex align-items-center gap-2 m-0 w-100">
                                    <span class="text-secondary-light fw-medium">
                                        {{ $item->porte_name }}
                                    </span>
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="card card-footer align-items-center justify-content-between">
                <button type="submit" class="btn btn-success">Associer</button>
            </div>
        </form>
    </div>
@endsection

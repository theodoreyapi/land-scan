@extends('layouts.master', [
    'title' => 'Evenements',
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
@endpush

@section('content')
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">Evènements</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="index.html"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            Evènements
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Liste évènement</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap ">
                <div class="me-2 mb-2"></div>
                <div class="mb-2">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#add_employee"
                        class="btn btn-primary d-flex align-items-center"><i class="ti ti-circle-plus me-2"></i>Ajouter un
                        évènement</a>
                </div>
                <div class="head-icons ms-2">
                    <a href="javascript:void(0);" class="" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-original-title="Collapse" id="collapse-header">
                        <i class="ti ti-chevrons-up"></i>
                    </a>
                </div>
            </div>
        </div>
        <!-- /Breadcrumb -->

        @include('layouts.status')

        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                <h5>Liste des évènements</h5>
            </div>
            <div class="card-body p-0">
                <div class="custom-datatable-filter table-responsive">
                    <table class="table datatable">
                        <thead class="thead-light">
                            <tr>
                                <th>Libelle</th>
                                <th>Lieu</th>
                                <th>Date</th>
                                <th>Heure</th>
                                <th>Nbre ticket</th>
                                <th>Statut</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($all as $agent)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <a href="#" class="avatar avatar-md" data-bs-toggle="modal"
                                                data-bs-target="#view_details"><img
                                                    src="{{ $agent->event_image == null ? URL::asset('assets/img/users/user-36.jpg') : URL::asset('events') . '/' . $agent->event_image }}"
                                                    class="img-fluid rounded-circle" alt="img"></a>
                                            <div class="ms-2">
                                                <p class="text-dark mb-0"><a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#view_details">{{ $agent->event_name }}</a></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $agent->event_lieu }}</td>
                                    <td>{{ $agent->event_date }}</td>
                                    <td>{{ $agent->event_time }}</td>
                                    <td>{{ $agent->total }}</td>
                                    <td>
                                        @if ($agent->event_status == 'Active')
                                            <span class="badge badge-success d-inline-flex align-items-center badge-xs">
                                                <i class="ti ti-point-filled me-1"></i>Active
                                            </span>
                                        @else
                                            <span class="badge badge-danger d-inline-flex align-items-center badge-sm">
                                                <i class="ti ti-point-filled me-1"></i>Inactive
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-icon d-inline-flex">
                                            <a href="#" class="me-2" data-bs-toggle="modal"
                                                data-bs-target="#edit_employee{{ $agent->event_id }}"><i
                                                    class="ti ti-edit"></i></a>
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#delete_modal{{ $agent->event_id }}"><i
                                                    class="ti ti-trash"></i></a>
                                        </div>
                                        <div class="modal fade" id="edit_employee{{ $agent->event_id }}">
                                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-secondary">
                                                        <div class="d-flex align-items-center">
                                                            <h4 class="modal-title me-2 text-white">Modification</h4>
                                                        </div>
                                                        <button type="button" class="btn-close custom-btn-close"
                                                            data-bs-dismiss="modal" aria-label="Close">
                                                            <i class="ti ti-x"></i>
                                                        </button>
                                                    </div>
                                                    <form action="{{ route('departments.update', $agent->event_id) }}"
                                                        method="POST" role="form" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="modal-body pb-0 ">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <label for="" class="form-label">Photo</label>
                                                                    <div
                                                                        class="d-flex align-items-center flex-wrap row-gap-3 bg-light w-100 rounded p-3 mb-4">
                                                                        <img src="{{ $agent->event_image == null ? URL::asset('assets/img/users/user-13.jpg') : URL::asset('events') . '/' . $agent->event_image }}"
                                                                            alt="img" class=""
                                                                            style="height: 150px; width: 100%;">
                                                                        <div class="profile-upload">
                                                                            <div
                                                                                class="profile-uploader d-flex align-items-center">
                                                                                <input type="file"
                                                                                    class="form-control image-sign"
                                                                                    name="photo">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Libelle <span
                                                                                class="text-danger">
                                                                                *</span></label>
                                                                        <input type="text" name="libelle" required
                                                                            class="form-control"
                                                                            value="{{ $agent->event_name }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Lieu<span
                                                                                class="text-danger">
                                                                                *</span></label>
                                                                        <input type="text" name="lieu" required
                                                                            class="form-control"
                                                                            value="{{ $agent->event_lieu }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Date <span
                                                                                class="text-danger">
                                                                                *</span></label>
                                                                        <input type="date" required name="date"
                                                                            class="form-control"
                                                                            value="{{ $agent->event_date }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Heure <span
                                                                                class="text-danger">
                                                                                *</span></label>
                                                                        <input type="time" required name="time"
                                                                            class="form-control"
                                                                            value="{{ $agent->event_time }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Statut <span
                                                                                class="text-danger">
                                                                                *</span></label>
                                                                        <br>
                                                                        <select name="statut" required class="select">
                                                                            <option
                                                                                @if ($agent->event_status == 'Active') selected @endif
                                                                                value="Active">Active</option>
                                                                            <option
                                                                                @if ($agent->event_status == 'Inactive') selected @endif
                                                                                value="Inactive">Inactive</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button"
                                                                class="btn btn-outline-light border me-2"
                                                                data-bs-dismiss="modal">Annuler</button>
                                                            <button type="submit"
                                                                class="btn btn-secondary">Modifier</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="delete_modal{{ $agent->event_id }}">
                                            <div class="modal-dialog modal-dialog-centered modal-sm">
                                                <form action="{{ route('departments.destroy', $agent->event_id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="modal-content">
                                                        <div class="modal-body text-center">
                                                            <span
                                                                class="avatar avatar-xl bg-transparent-danger text-danger mb-3">
                                                                <i class="ti ti-trash-x fs-36"></i>
                                                            </span>
                                                            <h4 class="mb-1">Confirmer la suppression</h4>
                                                            <p class="mb-3">
                                                                Vous souhaitez supprimer l'agent,
                                                                <br>
                                                            <div class="alert alert-warning alert-dismissible fade show">
                                                                <strong>Cette opération ne peut pas être annulée une
                                                                    fois supprimée.</strong>
                                                            </div>
                                                            </p>
                                                            <div class="d-flex justify-content-center">
                                                                <a href="javascript:void(0);" class="btn btn-light me-3"
                                                                    data-bs-dismiss="modal">Annuler</a>
                                                                <button type="submit" class="btn btn-danger">Oui,
                                                                    Supprimer</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add_employee">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <div class="d-flex align-items-center">
                        <h4 class="modal-title me-2 text-white">Ajout d'un nouveau évènement</h4>
                    </div>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <form action="{{ route('departments.store') }}" method="POST" role="form"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body pb-0 ">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="" class="form-label">Photo</label>
                                <div class="d-flex align-items-center flex-wrap row-gap-3 bg-light w-100 rounded p-3 mb-4">
                                    <div class="profile-upload">
                                        <div class="profile-uploader d-flex align-items-center">
                                            <input type="file" class="form-control image-sign" name="photo">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Libelle <span class="text-danger">
                                            *</span></label>
                                    <input type="text" name="libelle" required class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Lieu<span class="text-danger">
                                            *</span></label>
                                    <input type="text" name="lieu" required class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Date <span class="text-danger">
                                            *</span></label>
                                    <input type="date" required name="date" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Heure <span class="text-danger">
                                            *</span></label>
                                    <input type="time" required name="time" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Statut <span class="text-danger">
                                            *</span></label>
                                    <select name="statut" required class="select">
                                        <option value="">Sélectionne</option>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-light border me-2"
                            data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

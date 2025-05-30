@extends('layouts.master', [
    'title' => 'Agents',
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
                <h2 class="mb-1">Agents</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ url('index') }}"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            Agents
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Liste agent</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap ">
                <div class="me-2 mb-2"></div>
                <div class="mb-2">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#add_employee"
                        class="btn btn-primary d-flex align-items-center"><i class="ti ti-circle-plus me-2"></i>Ajouter un
                        agent</a>
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

        <div class="row">

            <!-- Total Plans -->
            <div class="col-lg-3 col-md-6 d-flex">
                <div class="card flex-fill">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center overflow-hidden">
                            <div>
                                <span class="avatar avatar-lg bg-dark rounded-circle"><i class="ti ti-users"></i></span>
                            </div>
                            <div class="ms-2 overflow-hidden">
                                <p class="fs-12 fw-medium mb-1 text-truncate">Total Agent</p>
                                <h4>{{ $total }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Total Plans -->

            <!-- Total Plans -->
            <div class="col-lg-3 col-md-6 d-flex">
                <div class="card flex-fill">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center overflow-hidden">
                            <div>
                                <span class="avatar avatar-lg bg-success rounded-circle"><i
                                        class="ti ti-user-share"></i></span>
                            </div>
                            <div class="ms-2 overflow-hidden">
                                <p class="fs-12 fw-medium mb-1 text-truncate">Active</p>
                                <h4>{{ $active }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Total Plans -->

            <!-- Inactive Plans -->
            <div class="col-lg-3 col-md-6 d-flex">
                <div class="card flex-fill">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center overflow-hidden">
                            <div>
                                <span class="avatar avatar-lg bg-danger rounded-circle"><i
                                        class="ti ti-user-pause"></i></span>
                            </div>
                            <div class="ms-2 overflow-hidden">
                                <p class="fs-12 fw-medium mb-1 text-truncate">InActive</p>
                                <h4>{{ $inactive }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Inactive Companies -->
            {{--
            <!-- No of Plans  -->
            <div class="col-lg-3 col-md-6 d-flex">
                <div class="card flex-fill">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center overflow-hidden">
                            <div>
                                <span class="avatar avatar-lg bg-info rounded-circle"><i class="ti ti-user-plus"></i></span>
                            </div>
                            <div class="ms-2 overflow-hidden">
                                <p class="fs-12 fw-medium mb-1 text-truncate">New Joiners</p>
                                <h4>67</h4>
                            </div>
                        </div>
                        <div>
                            <span class="badge badge-soft-secondary badge-sm fw-normal">
                                <i class="ti ti-arrow-wave-right-down"></i>
                                +19.01%
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /No of Plans --> --}}

        </div>

        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                <h5>Liste des agents</h5>
            </div>
            <div class="card-body p-0">
                <div class="custom-datatable-filter table-responsive">
                    <table class="table datatable">
                        <thead class="thead-light">
                            <tr>
                                <th>Nom</th>
                                <th>E-mail</th>
                                <th>Statut</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($agents as $agent)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <a href="#" class="avatar avatar-md" data-bs-toggle="modal"
                                                data-bs-target="#view_details"><img
                                                    src="{{ $agent->agent_photo == null ? URL::asset('assets/img/users/user-36.jpg') : URL::asset('agents') . '/' . $agent->agent_photo }}"
                                                    class="img-fluid rounded-circle" alt="img"></a>
                                            <div class="ms-2">
                                                <p class="text-dark mb-0"><a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#view_details">{{ $agent->agent_name }}</a></p>
                                                <span class="fs-12">{{ $agent->agent_phone }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $agent->agent_email }}</td>
                                    <td>
                                        @if ($agent->agent_status == 'Active')
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
                                                data-bs-target="#edit_employee{{ $agent->agent_id }}"><i
                                                    class="ti ti-edit"></i></a>
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#delete_modal{{ $agent->agent_id }}"><i
                                                    class="ti ti-trash"></i></a>
                                        </div>
                                        <div class="modal fade" id="edit_employee{{ $agent->agent_id }}">
                                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-secondary">
                                                        <div class="d-flex align-items-center">Modification</h4>
                                                        </div>
                                                        <button type="button" class="btn-close custom-btn-close"
                                                            data-bs-dismiss="modal" aria-label="Close">
                                                            <i class="ti ti-x"></i>
                                                        </button>
                                                    </div>
                                                    <form action="{{ route('agences.update', $agent->agent_id) }}"
                                                        method="POST" role="form" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="modal-body pb-0 ">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <label for="" class="form-label">Photo</label>
                                                                    <div
                                                                        class="d-flex align-items-center flex-wrap row-gap-3 bg-light w-100 rounded p-3 mb-4">
                                                                        <div
                                                                            class="d-flex align-items-center justify-content-center avatar avatar-xxl rounded-circle border border-dashed me-2 flex-shrink-0 text-dark frames">
                                                                            <img src="{{ $agent->agent_photo == null ? URL::asset('assets/img/users/user-13.jpg') : URL::asset('agents') . '/' . $agent->agent_photo }}"
                                                                                alt="img" class="rounded-circle">
                                                                        </div>
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
                                                                        <label class="form-label">Nom <span
                                                                                class="text-danger">
                                                                                *</span></label>
                                                                        <input type="text" name="nom" required
                                                                            class="form-control" placeholder="Nom complet"
                                                                            value="{{ $agent->agent_name }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Téléphone<span
                                                                                class="text-danger">
                                                                                *</span></label>
                                                                        <input type="tel" name="phone" required
                                                                            class="form-control"
                                                                            value="{{ $agent->agent_phone }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">E-mail</label>
                                                                        <input type="email" name="email"
                                                                            class="form-control"
                                                                            value="{{ $agent->agent_email }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Statut</label>
                                                                        <br>
                                                                        <select name="statut" required class="select">
                                                                            <option
                                                                                @if ($agent->agent_status == 'Active') selected @endif
                                                                                value="Active">Active</option>
                                                                            <option
                                                                                @if ($agent->agent_status == 'Inactive') selected @endif
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
                                        <div class="modal fade" id="delete_modal{{ $agent->agent_id }}">
                                            <div class="modal-dialog modal-dialog-centered modal-sm">
                                                <form action="{{ route('agences.destroy', $agent->agent_id) }}"
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
                                                                cette opération ne peut pas être annulée une
                                                                fois supprimée.
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
                        <h4 class="modal-title me-2 text-white">Ajout d'un nouveau agent</h4>
                    </div>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <form action="{{ route('agences.store') }}" method="POST" role="form" enctype="multipart/form-data">
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
                                    <label class="form-label">Nom <span class="text-danger">
                                            *</span></label>
                                    <input type="text" name="nom" required class="form-control"
                                        placeholder="Nom complet">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Téléphone<span class="text-danger">
                                            *</span></label>
                                    <input type="tel" name="phone" required class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">E-mail</label>
                                    <input type="email" name="email" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3 ">
                                    <label class="form-label">Mot de passe <span class="text-danger">
                                            *</span></label>
                                    <div class="pass-group">
                                        <input type="password" name="password" required class="pass-input form-control">
                                        <span class="ti toggle-password ti-eye-off"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Statut</label>
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

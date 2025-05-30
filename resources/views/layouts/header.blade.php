 <!-- Header -->
 <div class="header" style="background: #B5C0D0">
     <div class="main-header">

         <div class="header-left">
             <a href="#" class="logo">
                 <img src="{{ URL::asset('') }}assets/img/logo.svg" alt="Logo">
             </a>
             <a href="#" class="dark-logo">
                 <img src="{{ URL::asset('') }}assets/img/logo-white.svg" alt="Logo">
             </a>
         </div>

         <a id="mobile_btn" class="mobile_btn" href="#sidebar">
             <span class="bar-icon">
                 <span></span>
                 <span></span>
                 <span></span>
             </span>
         </a>

         <div class="header-user">
             <div class="nav user-menu nav-list">

                 <div class="me-auto d-flex align-items-center" id="header-search">
                     <a id="toggle_btn" href="javascript:void(0);" class="btn btn-menubar me-1">
                         <i class="ti ti-arrow-bar-to-left"></i>
                     </a>
                 </div>

                 <div class="d-flex align-items-center">
                     <div class="me-1">
                         <a href="#" class="btn btn-menubar btnFullscreen">
                             <i class="ti ti-maximize"></i>
                         </a>
                     </div>
                 </div>

                 <div class="dropdown profile-dropdown">
                     <a href="javascript:void(0);" class="dropdown-toggle d-flex align-items-center"
                         data-bs-toggle="dropdown">
                         <span class="avatar avatar-sm online">
                             <img src="{{ URL::asset('') }}assets/img/profiles/avatar-12.jpg" alt="Img"
                                 class="img-fluid rounded-circle">
                         </span>
                     </a>
                     <div class="dropdown-menu shadow-none">
                         <div class="card mb-0">
                             <div class="card-header">
                                 <div class="d-flex align-items-center">
                                     <span class="avatar avatar-lg me-2 avatar-rounded">
                                         <img src="{{ URL::asset('') }}assets/img/profiles/avatar-12.jpg"
                                             alt="img">
                                     </span>
                                     <div>
                                         <h5 class="mb-0">{{ Auth::user()->name }}</h5>
                                         <p class="fs-12 fw-medium mb-0">{{ Auth::user()->phone }}</p>
                                     </div>
                                 </div>
                             </div>
                             <div class="card-body">
                                 <a class="dropdown-item d-inline-flex align-items-center p-0 py-2"
                                     href="{{ url('profile') }}">
                                     <i class="ti ti-user-circle me-1"></i>Mon Profil
                                 </a>
                             </div>
                             <div class="card-footer">
                                 <a class="dropdown-item d-inline-flex align-items-center p-0 py-2 text-danger"
                                     href="{{ url('logout') }}">
                                     <i class="ti ti-login me-2"></i>Se déconnecter
                                 </a>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <div class="dropdown mobile-user-menu">
         <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
             aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
         <div class="dropdown-menu dropdown-menu-end">
             <a class="dropdown-item" href="{{ url('profile') }}">Mon Profil</a>
             <a class="dropdown-item text-danger" href="{{ url('logout') }}">Se déconnecter</a>
         </div>
     </div>
 </div>
 </div>

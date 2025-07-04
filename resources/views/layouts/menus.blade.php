 <!-- Sidebar -->
 <div class="sidebar" id="sidebar">
     <!-- Logo -->
     <div class="sidebar-logo">
         <a href="#" class="logo logo-normal">
             <img src="{{ URL::asset('') }}assets/img/logo.svg" alt="Logo">
         </a>
         <a href="#" class="logo-small">
             <img src="{{ URL::asset('') }}assets/img/logo-small.svg" alt="Logo">
         </a>
         <a href="#" class="dark-logo">
             <img src="{{ URL::asset('') }}assets/img/logo-white.svg" alt="Logo">
         </a>
     </div>
     <!-- /Logo -->
     <div class="modern-profile p-3 pb-0">
         <div class="text-center rounded bg-light p-3 mb-4 user-profile">
             <div class="avatar avatar-lg online mb-3">
                 <img src="{{ URL::asset('') }}assets/img/profiles/avatar-02.jpg" alt="Img"
                     class="img-fluid rounded-circle">
             </div>
             <h6 class="fs-12 fw-normal mb-1">Adrian Herman</h6>
             <p class="fs-10">System Admin</p>
         </div>
         <div class="sidebar-nav mb-3">
             <ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded nav-justified bg-transparent" role="tablist">
                 <li class="nav-item"><a class="nav-link active border-0" href="#">Menu</a></li>
                 <li class="nav-item"><a class="nav-link border-0" href="#">Chats</a></li>
                 <li class="nav-item"><a class="nav-link border-0" href="#">Inbox</a></li>
             </ul>
         </div>
     </div>
     <div class="sidebar-header p-3 pb-0 pt-2">
         <div class="text-center rounded bg-light p-2 mb-4 sidebar-profile d-flex align-items-center">
             <div class="avatar avatar-md onlin">
                 <img src="{{ URL::asset('') }}assets/img/profiles/avatar-02.jpg" alt="Img"
                     class="img-fluid rounded-circle">
             </div>
             <div class="text-start sidebar-profile-info ms-2">
                 <h6 class="fs-12 fw-normal mb-1">Adrian Herman</h6>
                 <p class="fs-10">System Admin</p>
             </div>
         </div>
         <div class="input-group input-group-flat d-inline-flex mb-4">
             <span class="input-icon-addon">
                 <i class="ti ti-search"></i>
             </span>
             <input type="text" class="form-control" placeholder="Search in HRMS">
             <span class="input-group-text">
                 <kbd>CTRL + / </kbd>
             </span>
         </div>
         <div class="d-flex align-items-center justify-content-between menu-item mb-3">
             <div class="me-3">
                 <a href="calendar" class="btn btn-menubar">
                     <i class="ti ti-layout-grid-remove"></i>
                 </a>
             </div>
             <div class="me-3">
                 <a href="{{ url('chat') }}" class="btn btn-menubar position-relative">
                     <i class="ti ti-brand-hipchat"></i>
                     <span
                         class="badge bg-info rounded-pill d-flex align-items-center justify-content-center header-badge">5</span>
                 </a>
             </div>
             <div class="me-3 notification-item">
                 <a href="{{ url('activity') }}" class="btn btn-menubar position-relative me-1">
                     <i class="ti ti-bell"></i>
                     <span class="notification-status-dot"></span>
                 </a>
             </div>
             <div class="me-0">
                 <a href="{{ url('email') }}" class="btn btn-menubar">
                     <i class="ti ti-message"></i>
                 </a>
             </div>
         </div>
     </div>
     <div class="sidebar-inner slimscroll">
         <div id="sidebar-menu" class="sidebar-menu">
             <ul>
                 <li class="menu-title"><span>TABLEAU DE BORD</span></li>
                 <li>
                     <ul>
                         <li class="submenu">
                             <a href="javascript:void(0);"
                                 class="{{ Request::is('index') ? 'active subdrop' : '' }}
                             {{ Request::is('admin') ? 'active subdrop' : '' }}
                             {{ Request::is('evenements') ? 'active subdrop' : '' }}
                             {{ Request::is('dashboard') ? 'active subdrop' : '' }}">
                                 <i class="ti ti-smart-home"></i>
                                 <span>Tableau de bord</span>
                                 <span class="menu-arrow"></span>
                             </a>
                             <ul>
                                 @role('admin')
                                     <li>
                                         <a href="{{ url('index') }}"
                                             class="{{ Request::is('index') ? 'active' : '' }}
                                             {{ Request::is('admin') ? 'active' : '' }}">Tableau
                                             de bord</a>
                                     </li>
                                 @endrole
                                 @role('superviseur')
                                     <li>
                                         <a href="{{ url('index') }}"
                                             class="{{ Request::is('index') ? 'active' : '' }}
                                             {{ Request::is('evenements') ? 'active' : '' }}">Tableau
                                             de bord</a>
                                     </li>
                                 @endrole
                                 @role('observateur')
                                     <li>
                                         <a href="{{ url('index') }}"
                                             class="{{ Request::is('index') ? 'active' : '' }}
                                             {{ Request::is('dashboard') ? 'active' : '' }}">Tableau
                                             de bord</a>
                                     </li>
                                 @endrole
                             </ul>
                         </li>
                     </ul>
                 </li>
                 @role('admin')
                     <li class="menu-title"><span>STADES</span></li>
                     <li>
                         <ul>
                             <li class="submenu">
                                 <a href="javascript:void(0);"
                                     class="{{ Request::is('stades') ? 'active subdrop' : '' }}
                                   {{ Request::is('portes') ? 'active subdrop' : '' }}">
                                     <i class="ti ti-home"></i><span>Stades</span>
                                     <span class="menu-arrow"></span>
                                 </a>
                                 <ul>
                                     <li><a class="{{ Request::is('stades') ? 'active' : '' }}"
                                             href="{{ url('stades') }}">Stades</a>
                                     <li><a class="{{ Request::is('portes') ? 'active' : '' }}"
                                             href="{{ url('portes') }}">Portes</a>
                                     </li>
                                 </ul>
                             </li>
                         </ul>
                     </li>
                 @endrole
                 @role(['superviseur', 'admin'])
                     <li class="menu-title"><span>EVENEMENTS</span></li>
                     <li>
                         <ul>
                             <li class="submenu">
                                 <a href="javascript:void(0);"
                                     class="{{ Request::is('agences') ? 'active subdrop' : '' }}
                                 {{ Request::is('departments') ? 'active subdrop' : '' }}
                                  {{ Request::is('designations') ? 'active subdrop' : '' }}
                                  {{ Request::is('associations') ? 'active subdrop' : '' }}
                                  {{ Request::is('add-associate') ? 'active subdrop' : '' }}">
                                     <i class="ti ti-users"></i><span>Evènements</span>
                                     <span class="menu-arrow"></span>
                                 </a>
                                 <ul>
                                     <li><a class="{{ Request::is('agences') ? 'active' : '' }}"
                                             href="{{ url('agences') }}">Agents</a>
                                     </li>
                                     <li><a class="{{ Request::is('departments') ? 'active' : '' }}"
                                             href="{{ url('departments') }}">Evènements</a></li>
                                     @role('admin')
                                         <li><a class="{{ Request::is('designations') ? 'active' : '' }}"
                                                 href="{{ url('designations') }}">Tickets</a></li>
                                     @endrole
                                     <li><a class="{{ Request::is('associations') ? 'active' : '' }}{{ Request::is('add-associate') ? 'active' : '' }}"
                                             href="{{ url('associations') }}">Associé Events - Agents - Portes</a></li>
                                 </ul>
                             </li>
                         </ul>
                     </li>
                 @endrole
                 @role('admin')
                     <li class="menu-title"><span>ADMINISTRATION</span></li>
                     <li>
                         <ul>
                             <li class="submenu">
                                 <a href="javascript:void(0);"
                                     class="{{ Request::is('users') ? 'active subdrop' : '' }}">
                                     <i class="ti ti-user-star"></i><span>Utilisateurs</span>
                                     <span class="menu-arrow"></span>
                                 </a>
                                 <ul>
                                     <li>
                                         <a href="{{ url('users') }}"
                                             class="{{ Request::is('users') ? 'active' : '' }}">Utilisateurs</a>
                                     </li>
                                 </ul>
                             </li>
                         </ul>
                     </li>
                 @endrole
             </ul>
         </div>
     </div>
 </div>
 <!-- /Sidebar -->

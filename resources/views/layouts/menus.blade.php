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
                 <li class="menu-title"><span>MAIN MENU</span></li>
                 <li>
                     <ul>
                         <li class="submenu">
                             <a href="javascript:void(0);" class="{{ Request::is('index') ? 'active subdrop' : '' }}">
                                 <i class="ti ti-smart-home"></i>
                                 <span>Tableau de bord</span>
                                 {{-- <span class="badge badge-danger fs-10 fw-medium text-white p-1">Hot</span> --}}
                                 <span class="menu-arrow"></span>
                             </a>
                             <ul>
                                 <li>
                                     <a href="{{ url('index') }}"
                                         class="{{ Request::is('index') ? 'active' : '' }}">Admin</a>
                                 </li>
                             </ul>
                         </li>
                     </ul>
                 </li>
                 {{-- <li class="menu-title"><span>CRM</span></li>
                 <li>
                     <ul>
                         <li class="{{ Request::is('activity') ? 'active' : '' }}">
                             <a href="{{ url('activity') }}">
                                 <i class="ti ti-activity"></i><span>Pist d'audit</span>
                             </a>
                         </li>
                     </ul>
                 </li> --}}
                 <li class="menu-title"><span>EVENEMENTS</span></li>
                 <li>
                     <ul>
                         <li class="submenu">
                             <a href="javascript:void(0);"
                                 class="{{ Request::is('agences') ? 'active subdrop' : '' }}
                                 {{ Request::is('departments') ? 'active subdrop' : '' }}
                                  {{ Request::is('designations') ? 'active subdrop' : '' }}
                                  {{ Request::is('associations') ? 'active subdrop' : '' }}
                                  {{ Request::is('add-associate') ? 'active subdrop' : '' }}
                                   {{ Request::is('portes') ? 'active subdrop' : '' }}">
                                 <i class="ti ti-users"></i><span>Evènements</span>
                                 <span class="menu-arrow"></span>
                             </a>
                             <ul>
                                 <li><a class="{{ Request::is('agences') ? 'active' : '' }}"
                                         href="{{ url('agences') }}">Agents</a>
                                 </li>
                                 <li><a class="{{ Request::is('departments') ? 'active' : '' }}"
                                         href="{{ url('departments') }}">Evènements</a></li>
                                 <li><a class="{{ Request::is('portes') ? 'active' : '' }}" href="portes">Portes</a>
                                 </li>
                                 <li><a class="{{ Request::is('designations') ? 'active' : '' }}"
                                         href="{{ url('designations') }}">Tickets</a></li>
                                 <li><a class="{{ Request::is('associations') ? 'active' : '' }}{{ Request::is('add-associate') ? 'active' : '' }}"
                                         href="{{ url('associations') }}">Associé Tickets - Agents - Portes</a></li>
                             </ul>
                         </li>
                     </ul>
                 </li>
                 {{-- <li class="menu-title"><span>ADMINISTRATION</span></li>
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
                         <li class="submenu">
                             <a href="javascript:void(0);"
                                 class="{{ Request::is('attendance-report') ? 'active subdrop' : '' }}
                                 {{ Request::is('daily-report') ? 'active subdrop' : '' }}
                                  {{ Request::is('leave-report') ? 'active subdrop' : '' }}
                                  {{ Request::is('employee-report') ? 'active subdrop' : '' }}
                                    ">
                                 <i class="ti ti-user-star"></i><span>Reports</span>
                                 <span class="menu-arrow"></span>
                             </a>
                             <ul>
                                 <li><a href="{{ url('employee-report') }}"
                                         class="{{ Request::is('employee-report') ? 'active' : '' }}">Rapport
                                         d'employés</a></li>
                                 <li><a href="{{ url('attendance-report') }}"
                                         class="{{ Request::is('attendance-report') ? 'active' : '' }}">Rapport de
                                         présences</a></li>
                                 <li><a href="{{ url('leave-report') }}"
                                         class="{{ Request::is('leave-report') ? 'active' : '' }}">Rapport de
                                         congés</a></li>
                                 <li><a href="{{ url('daily-report') }}"
                                         class="{{ Request::is('daily-report') ? 'active' : '' }}">Rapport
                                         quotidien</a></li>
                             </ul>
                         </li>
                         <li class="submenu">
                             <a href="javascript:void(0);"
                                 class="
                                 {{ Request::is('profile-settings') ? 'active subdrop' : '' }}
                                  {{ Request::is('security-settings') ? 'active subdrop' : '' }}
                                    {{ Request::is('email-settings') ? 'active subdrop' : '' }}
                                 {{ Request::is('email-template') ? 'active subdrop' : '' }}
                                  {{ Request::is('sms-settings') ? 'active subdrop' : '' }}
                                   {{ Request::is('sms-template') ? 'active subdrop' : '' }}
                                     ">
                                 <i class="ti ti-settings"></i><span>Settings</span>
                                 <span class="menu-arrow"></span>
                             </a>
                             <ul>
                                 <li class="submenu submenu-two">
                                     <a href="javascript:void(0);"
                                         class="{{ Request::is('profile-settings') ? 'active subdrop' : '' }}
                                 {{ Request::is('security-settings') ? 'active subdrop' : '' }}
                                  {{ Request::is('notification-settings') ? 'active subdrop' : '' }}
                                   {{ Request::is('connected-apps') ? 'active subdrop' : '' }}
                                    ">General
                                         Settings<span class="menu-arrow inside-submenu"></span></a>
                                     <ul>
                                         <li><a href="{{ url('profile-settings') }}"
                                                 class="{{ Request::is('profile-settings') ? 'active' : '' }}">Profile</a>
                                         </li>
                                         <li><a href="{{ url('security-settings') }}"
                                                 class="{{ Request::is('security-settings') ? 'active' : '' }}">Security</a>
                                         </li>

                                     </ul>
                                 </li>

                                 <li class="submenu submenu-two">
                                     <a href="javascript:void(0);"
                                         class="{{ Request::is('email-settings') ? 'active subdrop' : '' }}
                                 {{ Request::is('email-template') ? 'active subdrop' : '' }}
                                  {{ Request::is('sms-settings') ? 'active subdrop' : '' }}
                                   {{ Request::is('sms-template') ? 'active subdrop' : '' }}
                                    ">System
                                         Settings<span class="menu-arrow inside-submenu"></span></a>
                                     <ul>
                                         <li><a href="{{ url('email-settings') }}"
                                                 class="{{ Request::is('email-settings') ? 'active' : '' }}">Email
                                                 Settings</a></li>
                                         <li><a href="{{ url('email-template') }}"
                                                 class="{{ Request::is('email-template') ? 'active' : '' }}">Email
                                                 Templates</a></li>
                                         <li><a href="{{ url('sms-settings') }}"
                                                 class="{{ Request::is('sms-settings') ? 'active' : '' }}">SMS
                                                 Settings</a></li>
                                         <li><a href="{{ url('sms-template') }}"
                                                 class="{{ Request::is('sms-template') ? 'active' : '' }}">SMS
                                                 Templates</a></li>

                                     </ul>
                                 </li>
                             </ul>
                         </li>
                     </ul>
                 </li> --}}
             </ul>
         </div>
     </div>
 </div>
 <!-- /Sidebar -->

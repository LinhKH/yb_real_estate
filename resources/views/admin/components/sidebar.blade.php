<!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="javascript:void(0)" class="brand-link">
                <span class="brand-text font-weight-light">{{$siteInfo->com_name}}</span>
            </a>
            <!-- Sidebar -->
            <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                
                <div class="info">
                    <a href="javascript:void(0)" class="d-block">{{session()->get('admin_name')}}</a>
                </div>
            </div>
           <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a href="{{url('admin/dashboard')}}" class="nav-link {{(Request::path() == 'admin/dashboard')? 'active':''}}">
                            <i class="nav-icon fas fa-home"></i>
                            <p> Dashboard </p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview {{(Request::path() == 'admin/packages' || Request::path() == 'admin/properties' || Request::path() == 'admin/category' || Request::path() == 'admin/purpose' || Request::path() == 'admin/facilities')? 'menu-open':''}}">
                        <a href="javascript:void(0)" class="nav-link">
                          <i class="nav-icon fa fa-map-marker"></i>
                           <p> Properties <i class="fas fa-angle-left right"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{url('admin/properties')}}" class="nav-link {{(Request::path() == 'admin/properties')? 'active bg-primary':''}}">
                                  <i class="fas fa-ad nav-icon"></i>
                                  <p>All Properties</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url('admin/category')}}" class="nav-link {{(Request::path() == 'admin/category')? 'active bg-primary':''}}">
                                    <i class="nav-icon fa fa-cubes"></i>
                                    <p>Categories</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url('admin/purpose')}}" class="nav-link {{(Request::path() == 'admin/purpose')? 'active bg-primary':''}}">
                                    <i class="nav-icon fa fa-bookmark"></i>
                                    <p>Purpose</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url('admin/facilities')}}" class="nav-link {{(Request::path() == 'admin/facilities')? 'active':''}}">
                                    <i class="nav-icon fas fa-list"></i>
                                    <p>Facilities</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url('admin/packages')}}" class="nav-link {{(Request::path() == 'admin/packages')? 'active':''}}">
                                    <i class="nav-icon fa fa-dollar-sign"></i>
                                    <p>Packages</p>
                                </a>
                            </li>
                        </ul> 
                    </li>
                    <li class="nav-item">
                        <a href="{{url('admin/users')}}" class="nav-link {{(Request::path() == 'admin/users')? 'active':''}}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Users</p>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="{{url('admin/pages')}}" class="nav-link {{(Request::path() == 'admin/pages')? 'active':''}}">
                            <i class="nav-icon fa fa-file-word"></i>
                            <p> Pages</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{url('admin/distance')}}" class="nav-link {{(Request::path() == 'admin/distance')? 'active bg-primary':''}}">
                            <i class="nav-icon fa fa-arrows-alt"></i>
                            <p>Distances</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{url('admin/contact')}}" class="nav-link {{(Request::path() == 'admin/contact')? 'active bg-primary':''}}">
                            <i class="nav-icon fa fa-comments"></i>
                            <p>Contact Form</p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview {{(Request::path() == 'admin/country' || Request::path() == 'admin/state' || Request::path() == 'admin/city')? 'menu-open':''}}">
                        <a href="javascript:void(0)" class="nav-link">
                          <i class="nav-icon fas fa-map-marker-alt"></i>
                           <p> Locations <i class="fas fa-angle-left right"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{url('admin/country')}}" class="nav-link {{(Request::path() == 'admin/country')? 'active bg-primary':''}}">
                                  <i class="fas fa-globe nav-icon"></i>
                                  <p>Country</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url('admin/states')}}" class="nav-link {{(Request::path() == 'admin/states')? 'active bg-primary':''}}">
                                    <i class="nav-icon fas fa-flag"></i>
                                    <p>States</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url('admin/city')}}" class="nav-link {{(Request::path() == 'admin/city')? 'active bg-primary':''}}">
                                    <i class="nav-icon fas fa-city"></i>
                                    <p>City</p>
                                </a>
                            </li>
                        </ul> 
                    </li>
                    <li class="nav-item has-treeview {{(Request::path() == 'admin/banner-settings' || Request::path() == 'admin/general-settings' || Request::path() == 'admin/profile-settings'|| Request::path() == 'admin/social-settings')? 'menu-open':''}}">
                        <a href="javascript:void(0)" class="nav-link">
                          <i class="nav-icon fa fa-wrench"></i>
                           <p> Settings <i class="fas fa-angle-left right"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{url('admin/banner-settings')}}" class="nav-link {{(Request::path() == 'admin/banner-settings')? 'active bg-primary':''}}">
                                  <i class="fas fa-image nav-icon"></i>
                                  <p>Banner Settings</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url('admin/general-settings')}}" class="nav-link {{(Request::path() == 'admin/general-settings')? 'active bg-primary':''}}">
                                  <i class="fas fa-cogs nav-icon"></i>
                                  <p>General Settings</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url('admin/profile-settings')}}" class="nav-link {{(Request::path() == 'admin/profile-settings')? 'active bg-primary':''}}">
                                    <i class="nav-icon fa fa-user"></i>
                                    <p>Profile Settings</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url('admin/social-settings')}}" class="nav-link {{(Request::path() == 'admin/social-settings')? 'active bg-primary':''}}">
                                    <i class="nav-icon fa fa-list"></i>
                                    <p>Social Settings</p>
                                </a>
                            </li> 
                        </ul> 
                    </li>
                </ul>
            <!--  </li>
                </ul> -->
            </nav>
            <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
        <!-- Control Sidebar -->
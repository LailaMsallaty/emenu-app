
 <!-- Main Sidebar Container -->

  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="{{asset('images/logo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">phenixsoft | {{ Auth::user()->name}}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="text-white user-panel  mt-3 pb-3 mb-3 ">

      </div>

      @php
      if(App::getLocale()=='ar')
      $direction='left';
      else
      $direction='right';
      @endphp
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item direct">
            <a href="" class="nav-link">
              <img src="{{ asset('icon/main-category.png')}}" width="30">
              <p>
              {{__('Main Categories')}}
                <i class="fas fa-angle-left {{$direction}}"></i>

              </p>
            </a>
            <ul class="nav nav-treeview">
				<li class="nav-item">
					<a href="{{ route('categories',['type'=>'main']) }} " class="nav-link">
					  <i class="far fa-circle nav-icon"></i>
					  <p>{{ __('All Main Categories') }}</p>
					</a>
				  </li>
				  <li class="nav-item">
					<a href="{{ route('createCategory',['type'=>'main']) }}" class="nav-link">
					  <i class="far fa-circle nav-icon"></i>
					  <p>{{ __('Add Main Category')}}</p>
					</a>
				  </li>

            </ul>
          </li>
          <li class="nav-item direct">
            <a href="" class="nav-link">
              <img src="{{ asset('icon/category.png')}}" width="30">
              <p>
              {{ __('SubCategories')}}
                <i class="fas fa-angle-left {{$direction}}"></i>

              </p>
            </a>
            <ul class="nav nav-treeview">
			<li class="nav-item">
                <a href="{{ route('categories') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{ __('All Categories')}}</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('createCategory') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{ __('Add Category')}}</p>
                </a>
              </li>

            </ul>
          </li>
          <li class="nav-item direct">
            <a href="" class="nav-link">
              <img src="{{ asset('icon/material.png')}}" width="30">
              <p>
              {{ __('Materials')}}
                <i class="{{$direction}} fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('material.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{ __('All Materials')}}</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('material.create') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{ __('Add Material')}}</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item direct">
            <a href="" class="nav-link">
              <img src="{{ asset('icon/modifier.png')}}" width="30">
              <p>
                {{__('Modifier Templates')}}
                <i class="fas fa-angle-left {{$direction}}"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('modifiertemplates.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{__('All Modifier Templates')}}</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('modifiertemplates.create') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{__('Add Modifier Template')}}</p>
                </a>
              </li>
            </ul>
          </li>
		   <li class="nav-item direct">
            <a href="" class="nav-link">
              <img src="{{ asset('icon/order.png')}}" width="30">
              <p>
                {{__('Orders')}}
                <i class="fas fa-angle-left {{$direction}}"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('orders.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p> {{__('All Orders')}}</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item direct">
            <a href="" class="nav-link">
              <img src="{{ asset('icon/pages.png')}}" width="30">
              <p>
                {{__('Pages')}}
                <i class="fas fa-angle-left {{$direction}}"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('pages.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p> {{__('All Pages')}}</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('pages.create') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p> {{__('Add Page')}}</p>
                </a>
              </li>
            </ul>
          </li>

		  <li class="nav-item  direct">
            <a href="" class="nav-link ">
              <img src="{{ asset('icon/setting.png')}}" width="30">
              <p>
              {{__('Settings')}}
                <i class="{{$direction}} fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
			  <li class="nav-item">
				<a href="{{ route('settings.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{__('general settings')}}</p>
                </a>
              </li>
             <li class="nav-item">
				<!--<a href="?page=clearcache" class="nav-link">-->
				<a href="{{ route('performance.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{__('Performance')}}</p>
                </a>
              </li>
			  <li class="nav-item">

                <!--<a href="/pages/clearcache.php"> class="nav-link">-->
                <a href="{{ route('themeLogo.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{__('Theme & Logo')}}</p>
                </a>
              </li>
              <li class="nav-item">
				<!--<a href="?page=clearcache" class="nav-link">-->
				<a href="{{ route('languages.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{__('Languages')}}</p>
                </a>
              </li>
			  <li class="nav-item">
				<a href="{{ route('generateTables.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{__('Generating Tables')}}</p>
                </a>
              </li>

            </ul>
          </li>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

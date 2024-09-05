<<<<<<< HEAD
<div class="nk-sidebar">
  <div class="nk-nav-scroll">
    <ul class="metismenu" id="menu">
      <li class="nav-label">Dashboard</li>
      <li>
        <a href="{{ url('dashboard') }}" aria-expanded="false">
          <span class="nav-text">Dashboard</span>
        </a>
      </li>
      <li class="mega-menu mega-menu-sm">
        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
          <i class="icon-globe-alt menu-icon"></i><span class="nav-text">Masters</span>
        </a>
        <ul aria-expanded="false">
          @if(Auth::user()->id >= 2)
          <li class="{{ Route::is('products.*') ? 'active' : '' }}"><a href="{{ route('products.index') }}" class="nav-link"><span>Product</span></a></li>
          <li class="{{ Route::is('category.*') ? 'active' : '' }}"><a href="{{ route('category.index') }}" class="nav-link"><span>Category</span></a></li>
          <li class="{{ Route::is('subcategory.*') ? 'active' : '' }}"><a href="{{ route('subcategory.index') }}" class="nav-link"><span>Sub Category</span></a></li>
          <li class="{{ Route::is('reviews.*') ? 'active' : '' }}"><a href="{{ route('reviews.index') }}" class="nav-link"><span>Reviews</span></a></li>
          @endif
        </ul>
      </li>
      <li class="mega-menu mega-menu-sm">
        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
          <i class="icon-globe-alt menu-icon"></i><span class="nav-text">Orders</span>
        </a>
        <ul aria-expanded="false">
          @if(Auth::user()->id >= 2)
          <li class="{{ Route::is('orders.*') ? 'active' : '' }}"><a href="{{ route('orders.received') }}" class="nav-link"><span>Received</span></a></li>
          <li class="{{ Route::is('orders.*') ? 'active' : '' }}"><a href="{{ route('orders.inprogress') }}" class="nav-link"><span>In-Progress</span></a></li>
          <li class="{{ Route::is('orders.*') ? 'active' : '' }}"><a href="{{ route('orders.delivered') }}" class="nav-link"><span>Completed</span></a></li>
          <li class="{{ Route::is('orders.*') ? 'active' : '' }}"><a href="{{ route('orders.cancelled') }}" class="nav-link"><span>Cancelled</span></a></li>
          @endif
        </ul>
      </li>
    </ul>
  </div>
</div>
=======
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
      <div class="sidebar-brand">
        <a href="index.html">Bettex</a>
      </div>
      <div class="sidebar-brand sidebar-brand-sm">
        <a href="index.html">St</a>
      </div>
      <ul class="sidebar-menu">
        <li class="menu-header">Dashboard</li>
        <li class="dropdown {{ Route::is('dashboard')  ? 'active' : '' }}">
          <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Dashboard</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>
          </ul>
        </li>
        <li class="menu-header">User Management</li>
        <li class="dropdown {{ Route::is('users.*') || Route::is('roles.*')||Route::is('permissions.*') ? 'active' : '' }}">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="far fa-user"></i> <span>User</span></a>
          <ul class="dropdown-menu">
            @can('index-user')
            <li class="{{ Route::is('users.*')  ? 'active' : '' }}"><a class="nav-link" href="{{ route('users.index') }}">Users List</a></li>
            @endcan
            @can('index-role')
            <li class="{{ Route::is('roles.*')  ? 'active' : '' }}"><a class="nav-link" href="{{ route('roles.index') }}">Roles List</a></li>
            @endcan
            @can('index-permission')
            <li class="{{ Route::is('permissions.*')  ? 'active' : '' }}"><a class="nav-link" href="{{ route('permissions.index') }}">Permissions List</a></li>
            @endcan
          </ul>
        </li>
    </aside>
</div>
>>>>>>> e9c86bec46221be68b9eaceb2a158981149f1e5b

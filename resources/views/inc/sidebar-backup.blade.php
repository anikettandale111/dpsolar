<div class="main-sidebar sidebar-style-2">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="#">{{config('app.name')}}</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
      <a href="#">{{config('app.short_name')}}</a>
    </div>
    <ul class="sidebar-menu">
      <li class="menu-header">Dashboard</li>
      <li class="dropdown {{ Route::is('home')  ? 'active' : '' }}">
        <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Dashboard</span></a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="{{ route('home') }}">Dashboard</a></li>
        </ul>
      </li>
      @if(Auth::user()->id == 1)
      <li class="menu-header">User Management</li>
      <li class="dropdown {{ Route::is('users.*') || Route::is('roles.*')||Route::is('permissions.*') ? 'active' : '' }}">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="far fa-user"></i> <span>User</span></a>
        <ul class="dropdown-menu">
          @can('create-user')
          <li class="{{ Route::is('users.*')  ? 'active' : '' }}"><a class="nav-link" href="{{ route('users.index') }}">Users List</a></li>
          @endcan
          @can('create-role')
          <li class="{{ Route::is('roles.*')  ? 'active' : '' }}"><a class="nav-link" href="{{ route('roles.index') }}">Roles List</a></li>
          @endcan
          @can('create-permission')
          <li class="{{ Route::is('permissions.*')  ? 'active' : '' }}"><a class="nav-link" href="{{ route('permissions.index') }}">Permissions List</a></li>
          @endcan
        </ul>
      </li>
      @endif
      @if(Auth::user()->id >= 2)
      <li class="menu-header">Product Management</li>
      <li class="{{ Route::is('products.*') ? 'active' : '' }}"><a href="{{ route('products.index') }}" class="nav-link"><span>Product</span></a></li>
      <li class="{{ Route::is('category.*') ? 'active' : '' }}"><a href="{{ route('category.index') }}" class="nav-link"><span>Category</span></a></li>
      <li class="{{ Route::is('subcategory.*') ? 'active' : '' }}"><a href="{{ route('subcategory.index') }}" class="nav-link"><span>Sub Category</span></a></li>
      <li class="{{ Route::is('reviews.*') ? 'active' : '' }}"><a href="{{ route('reviews.index') }}" class="nav-link"><span>Reviews</span></a></li>
      @endif
  </aside>
</div>
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

<div class="header">
  <div class="header-content clearfix">
    <div class="nav-control">
      <div class="hamburger">
        <span class="toggle-icon"><i class="icon-menu"></i></span>
      </div>
    </div>
    <div class="header-right">
      <ul class="clearfix">
        <li class="icons dropdown">
          <div class="user-img c-pointer position-relative" data-toggle="dropdown">
            <span class="activity active"></span>
            <img src="{{ asset('backend/assets/images/user/1.png')}}" height="40" width="40" alt="">
          </div>
          <div class="drop-down dropdown-profile animated fadeIn dropdown-menu">
            <div class="dropdown-content-body">
              <ul>
                <li>
                  <a href="app-profile.html"><i class="icon-user"></i> <span>Profile</span></a>
                </li>
                <li>
                  <a href="javascript:void()">
                    <i class="icon-envelope-open"></i> <span>Inbox</span>
                    <div class="badge gradient-3 badge-pill gradient-1">3</div>
                  </a>
                </li>
                <hr class="my-2">
                <li>
                  <a href="page-lock.html"><i class="icon-lock"></i> <span>Lock Screen</span></a>
                </li>
                <li>
                  <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" style="background: none;border: none;"><i class="icon-key"></i> <span>Logout</span></button>
                  </form>
                </li>
              </ul>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </div>
</div>

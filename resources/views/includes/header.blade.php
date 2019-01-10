
<nav class="navbar navbar-expand-lg navbar-dark fixed-top scrolling-navbar">
  <div class="container">
    <a class="navbar-brand" href="{{ route('home') }}"> <i class="fa fa-"></i> EASS </a>
    <!-- Collapse button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#cn" aria-controls="cn"aria-expanded="false" aria-label="Toggle navigation" style="color:black !important;">
      <i class="fa fa-reorder"></i>
    </button>
    <div class="collapse navbar-collapse" id="cn">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('home') }}">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('browse.all') }}">For you</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('library') }}">Library</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('friends') }}">Friends</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('search.index') }}">Search</a>
          </li>
          @if(Auth::user()->role === 'Owner' || Auth::user()->role === 'Administrator' || Auth::user()->role === 'Uploader')
          <li class="nav-item">
            <a class="nav-link" href="{{ route('upload.index') }}">Upload</a>
          </li>
          @else
          <li class="nav-item">
            <a class="nav-link" href="{{ route('order') }}">Order</a>
          </li>
          @endif
          <li class="nav-item">
            <a class="nav-link" href="{{ route('about') }}">About</a>
          </li>
        </ul>

        <ul class="navbar-nav ml-auto">
          <!-- Dropdown -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img class="img-thumbnail" src="{{ Request::root() }}/data/users/photos/{{ Auth::user()->photo }}" style="padding: 0px;max-height:35px; max-width: 35px;" alt="User Photo">
              </a>
              <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
                  <span style="display:block; text-align:center;font-style:italic; color: #607D8B !important; margin-bottom: 5px;">{{ Auth::user()->name }}</span>
                  <a class="dropdown-item" href="{{ route('profile.my_profile') }}"><i class="fa fa-user-o"></i> My Profile</a>
                  <a class="dropdown-item" href="{{ route('bag.index') }}"><i class="fa fa-briefcase"></i> My Bag</a>
                  @if(Auth::user()->role === 'Owner' || Auth::user()->role === 'Administrator' || Auth::user()->role === 'Uploader')
                    <a class="dropdown-item" href="{{ route('profile.my_items') }}"><i class="fa fa-slack"></i> My Items</a>
                  @endif
                  @if(Auth::user()->role === 'Owner' || Auth::user()->role === 'Administrator')
                    <a class="dropdown-item" href="{{ route('dashboard_home') }}" target="_blank"><i class="fa fa-dashboard"></i> Dashboard</a>
                  @endif
                  <a class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();"><i class="fa fa-sign-out"></i> Logout</a>
                  <form id="logoutForm" action="/logout" method="POST" style="display: none;">{{ csrf_field() }}</form>
              </div>
            </li>
        </ul>
    </div>
  </div>
</nav>

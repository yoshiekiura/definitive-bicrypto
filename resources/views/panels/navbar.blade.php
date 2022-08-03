@if ($configData['mainLayoutType'] === 'horizontal' && isset($configData['mainLayoutType']))
  <nav class="header-navbar navbar-expand-lg navbar navbar-fixed align-items-center navbar-shadow navbar-brand-center {{ $configData['navbarColor'] }}"
      data-nav="brand-center">
      <div class="navbar-header d-xl-block d-none">
          <ul class="nav navbar-nav">
              <li class="nav-item">
                  <a class="navbar-brand" href="{{ url('/') }}">
                      <span class="brand-logo">
                          <svg viewbox="0 0 139 95" version="1.1" xmlns="http://www.w3.org/2000/svg"
                              xmlns:xlink="http://www.w3.org/1999/xlink" height="24">
                              <defs>
                                  <lineargradient id="linearGradient-1" x1="100%" y1="10.5120544%" x2="50%"
                                      y2="89.4879456%">
                                      <stop stop-color="#000000" offset="0%"></stop>
                                      <stop stop-color="#FFFFFF" offset="100%"></stop>
                                  </lineargradient>
                                  <lineargradient id="linearGradient-2" x1="64.0437835%" y1="46.3276743%"
                                      x2="37.373316%" y2="100%">
                                      <stop stop-color="#EEEEEE" stop-opacity="0" offset="0%"></stop>
                                      <stop stop-color="#FFFFFF" offset="100%"></stop>
                                  </lineargradient>
                              </defs>
                              <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                  <g id="Artboard" transform="translate(-400.000000, -178.000000)">
                                      <g id="Group" transform="translate(400.000000, 178.000000)">
                                          <path class="text-primary" id="Path"
                                              d="M-5.68434189e-14,2.84217094e-14 L39.1816085,2.84217094e-14 L69.3453773,32.2519224 L101.428699,2.84217094e-14 L138.784583,2.84217094e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L6.71554594,44.4188507 C2.46876683,39.9813776 0.345377275,35.1089553 0.345377275,29.8015838 C0.345377275,24.4942122 0.230251516,14.560351 -5.68434189e-14,2.84217094e-14 Z"
                                              style="fill:currentColor"></path>
                                          <path id="Path1"
                                              d="M69.3453773,32.2519224 L101.428699,1.42108547e-14 L138.784583,1.42108547e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L32.8435758,70.5039241 L69.3453773,32.2519224 Z"
                                              fill="url(#linearGradient-1)" opacity="0.2"></path>
                                          <polygon id="Path-2" fill="#000000" opacity="0.049999997"
                                              points="69.3922914 32.4202615 32.8435758 70.5039241 54.0490008 16.1851325">
                                          </polygon>
                                          <polygon id="Path-21" fill="#000000" opacity="0.099999994"
                                              points="69.3922914 32.4202615 32.8435758 70.5039241 58.3683556 20.7402338">
                                          </polygon>
                                          <polygon id="Path-3" fill="url(#linearGradient-2)" opacity="0.099999994"
                                              points="101.428699 0 83.0667527 94.1480575 130.378721 47.0740288">
                                          </polygon>
                                      </g>
                                  </g>
                              </g>
                          </svg>
                      </span>
                  </a>
              </li>
          </ul>
      </div>
      @else
      <nav
          class="header-navbar navbar navbar-expand-lg align-items-center {{ $configData['navbarClass'] }} navbar-light navbar-shadow {{ $configData['navbarColor'] }} {{ $configData['layoutWidth'] === 'boxed' && $configData['verticalMenuNavbarType'] === 'navbar-floating' ? 'container-xxl' : '' }}">
          @endif

          <div class="navbar-container d-flex content">
            <div class="bookmark-wrapper d-flex align-items-center">
                <ul class="nav navbar-nav d-xl-none">
                  <li class="nav-item"><a class="nav-link menu-toggle" href="javascript:void(0);"><i class="bi bi-list font-medium-5"></i></i></a></li>
                </ul>
              </div>
              <ul class="nav navbar-nav align-items-center ms-auto">
                <li class="nav-item dropdown dropdown-notification me-1">
                    <a href="{{ route('user.home') }}"><button class="btn btn-secondary">User Dashboard</button></a>
                </li>
                  <li class="nav-item dropdown dropdown-notification me-1">
                      <a class="nav-link ringing" href="javascript:void(0);" data-bs-toggle="dropdown">
                          <i class="bi bi-bell font-medium-5"></i>
                          @if($adminNotifications->count() > 0)
                          <span class="badge rounded-pill bg-danger badge-up">{{ $adminNotifications->count() }}</span>
                          @endif
                      </a>
                      <ul class="dropdown-menu dropdown-menu-media dropdown-menu-end">
                          <li class="dropdown-menu-header">
                              <div class="dropdown-header d-flex">
                                  @if($adminNotifications->count() > 0)
                                  <h4 class="notification-title mb-0 me-auto">Notifications</h4>
                                  <div class="badge rounded-pill badge-light-primary">@lang('You have')
                                      {{ $adminNotifications->count() }} @lang('unread notification')</div>
                                  @else
                                  <h4 class="notification-title mb-0 me-auto">@lang('No unread notification found')</h4>
                                  @endif
                              </div>
                          </li>
                          <li class="scrollable-container media-list">
                              @foreach($adminNotifications as $notification)
                              <a class="d-flex" href="{{ route('admin.notification.read',$notification->id) }}">
                                  <div class="list-item d-flex align-items-start">
                                      <div class="me-1">
                                          <div class="avatar">
                                              <img src="{{ getImage(imagePath()['profile']['user']['path'].'/'.@$notification->user->image,imagePath()['profile']['user']['size'])}}"
                                                  alt="avatar" width="32" height="32">
                                          </div>
                                      </div>
                                      <div class="list-item-body flex-grow-1">
                                          <p class="media-heading"><span
                                                  class="fw-bolder">{{ __($notification->title) }}</span></p>
                                          <small class="notification-text"><i class="bi bi-clock"></i>
                                              {{ $notification->created_at->diffForHumans() }}</small>
                                      </div>
                                  </div>
                              </a>
                              @endforeach
                          </li>
                          <li class="dropdown-menu-footer">
                              <a class="btn btn-primary w-100" href="{{ route('admin.notifications') }}">Read all
                                  notifications</a>
                          </li>
                      </ul>
                  </li>
                  <li class="nav-item dropdown dropdown-user">
                      <a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user"
                          href="javascript:void(0);" data-bs-toggle="dropdown" aria-haspopup="true">
                          <div class="user-nav d-sm-flex d-none">
                              <span class="user-name fw-bolder">
                                  @if (Auth::check())
                                  {{ Auth::user()->name }}
                                  @else
                                  John Doe
                                  @endif
                              </span>
                              <span class="user-status">
                                @if (auth()->user()->role_id == 1)
                                    Admin
                                @else
                                    {{ set_id(auth()->user()->id) }}659512
                                @endif
                              </span>
                          </div>
                          <span class="avatar">
                              <img class="round"
                                  src="{{ getImage(imagePath()['profileImage']['path'].'/'. auth()->user()->profile_photo_path,imagePath()['profileImage']['size']) }}"
                                  alt="avatar" height="40" width="40">
                              <span class="avatar-status-online"></span>
                          </span>
                      </a>
                      <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-user">
                          <h6 class="dropdown-header">Manage Profile</h6>
                          <div class="dropdown-divider"></div>
                          <a class="dropdown-item"
                              href="{{ Route::has('admin.profile.show') ? route('admin.profile.show') : 'javascript:void(0)' }}">
                              <i class="bi bi-person-circle me-50"></i> Profile
                          </a>
                          @if (Auth::check() && Laravel\Jetstream\Jetstream::hasApiFeatures())
                          <a class="dropdown-item" href="{{ route('admin.api.index') }}">
                            <i class="bi bi-key me-50"></i> API Tokens
                          </a>
                          @endif
                          @if (Auth::check())
                          <a class="dropdown-item" href="{{ route('logout') }}"
                              onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                              <i class="bi bi-box-arrow-in-left me-50"></i> Logout
                          </a>
                          <form method="POST" id="logout-form" action="{{ route('logout') }}">
                              @csrf
                          </form>
                          @endif
                  </li>
              </ul>
          </div>
      </nav>
<!-- END: Header-->

@push('script')
    <script>
        function toggleFullScreen() {
    if (!document.fullscreenElement) {
        document.documentElement.requestFullscreen();
        $('#toggleFullScreen')
        .removeClass('bi-aspect-ratio')
        .addClass('bi-fullscreen-exit');
    } else {
      if (document.exitFullscreen) {
        document.exitFullscreen();
        $('#toggleFullScreen')
        .removeClass('bi-fullscreen-exit')
        .addClass('bi-aspect-ratio');
      }
    }
  }
  </script>
@endpush

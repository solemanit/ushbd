  <header class="top-header">
      <nav class="container gap-3 navbar navbar-expand-xl w-100 navbar-dark">
          <a class="navbar-brand d-none d-xl-inline" href="{{ url('/') }}"><img src="{{ asset('images/ushbd.png') }}"
                  class="logo-img"></a>
          <a class="mobile-menu-btn d-inline d-xl-none" href="javascript:;" data-bs-toggle="offcanvas"
              data-bs-target="#offcanvasNavbar">
              <i class="bi bi-list"></i>
          </a>
          <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar">
              <div class="offcanvas-header">
                  <div class="offcanvas-logo"><img src="{{ asset('images/ushbd.png') }}" class="logo-img"
                          alt="">
                  </div>
                  <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                      aria-label="Close"></button>
              </div>
              <div class="offcanvas-body primary-menu">
                  <ul class="gap-1 navbar-nav justify-content-start flex-grow-1">
                      <li class="nav-item">
                          <a class="nav-link" href="{{ route('home') }}">Home</a>
                      </li>

                      @php
                          // Admin থেকে menu_visible pages load করা
                          $menuPages = \App\Models\Page::where('menu_visible', true)->get();
                      @endphp
                      <li class="nav-item">
                          <a class="nav-link" href="{{ route('about') }}">About</a>
                      </li>
                      @foreach ($menuPages as $page)
                          <li class="nav-item">
                              <a class="nav-link" href="{{ route('page.show', $page->slug) }}">
                                  {{ $page->title }}
                              </a>
                          </li>
                      @endforeach
                        <li class="nav-item">
                          <a class="nav-link" href="{{ route('contact.index') }}">Contact Us</a>
                      </li>
                  </ul>
              </div>

          </div>
          <ul class="flex-row navbar-nav secondary-menu">
              <li class="nav-item">
                  <a class="nav-link dark-mode-icon" href="javascript:;">
                      <div class="mode-icon">
                          <i class="bi bi-moon"></i>
                      </div>
                  </a>
              </li>
          </ul>
      </nav>
  </header>

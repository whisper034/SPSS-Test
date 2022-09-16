<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="{{ asset('js/app.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/stylesheets.css') }}">
      <link rel="icon" href="storage/assets/logos/spss-logo-polos.png">

    <title>@yield('title')</title>
  </head>
  <body>
  <header class="header">
      <div class="header-logo">
          <a href="/"><img src="{{ asset('storage/assets/logos/logo-spss-with-theme.png') }}"></a>
      </div>
      <nav class="navbar navbar-expand-md navbar-dark">
          <a class="navbar-brand" href="/"><img src="{{ asset('storage/assets/logos/logo-spss-with-theme.png') }}" width="200px"></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarCollapse">
              <ul class="navbar-nav mr-auto">
                  <li class="nav-item">
                      <a class="nav-link" href="/">Home</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="/about">About</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="/lomba">Lomba</a>
                  </li>
{{--                  <li class="nav-item">--}}
{{--                      <a class="nav-link" href="/seminar">Webinar</a>--}}
{{--                  </li>--}}
                  @guest
                      @if ($canRegister)
                          <li class="nav-item d-md-none">
                              <a class="nav-link" href="/register">Daftar</a>
                          </li>
                      @endif
                      <li class="nav-item d-md-none">
                          <a class="nav-link" href="/login">Masuk</a>
                      </li>
                  @endguest
              </ul>
              @guest
                  <div class="form-inline mt-2 mt-md-0 d-none d-md-block" style="margin: 0 -15px;">
                      @if ($canRegister)
                          <a class="btn btn-outline-info fit-content-btn" href="/register" style="width:120px; font-size:17px;">Daftar</a>
                      @endif
                      <a class="btn btn-outline-info fit-content-btn" href="/login" style="width:120px; font-size:17px;">Masuk</a>
                  </div>
              @else
                  <ul class="navbar-nav ml-auto">
                      <li class="nav-item dropdown">
                          <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                              {{ Auth::user()->name }} <span class="caret"></span>
                          </a>
                          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                              <a class="dropdown-item" href="/dashboard">Dashboard</a>
                              <a class="dropdown-item" href="/password/change">Ubah Sandi</a>
                              <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                      document.getElementById('logout-form').submit();">
                                  Keluar
                              </a>
                              {{ Form::open(['route' => 'logout', 'id' => 'logout-form', 'style' => 'display:none;']) }}
                              {{ Form::close() }}
                          </div>
                      </li>
                  </ul>
              @endguest
          </div>
      </nav>
  </header>

    @yield('content')

    <footer style="margin-top:0;">
        <div class="container-fluid">
            <div class="row">
                <div class="footer-content fc1">
                    <span class="footer-content-title font-weight-bold" style="font-size:22px; color: #9bd7ff;">Sekretariat</span>
                    <div class="sekretariat-content text-white">
                        <img src="{{ asset('storage/assets/logos/logo-himstat.png') }}" alt="logo-himstat" width="100px" height="110px">
                        <div class="address" style="margin-left: 40px;">
                            <span class="footer-content-details text-white" style="font-size:18px;">HIMPUNAN MAHASISWA STATISTIKA</span>
                            <br>
                            <span class="footer-content-details text-white" style="font-size:16px;">Universitas Bina Nusantara</span>
                            <br>
                            <span class="footer-content-details text-white" style="font-size:16px;">Kampus Syahdan</span>
                            <br>
                            <span class="footer-content-details text-white" style="font-size:16px;">Jl. Kyai H. Syahdan No. 9</span>
                        </div>
                    </div>
                </div>
                <div class="footer-content fc2">
                    <div class="medium-padding-left">
                        <span class="footer-content-title font-weight-bold" style="font-size:22px; color: #9bd7ff;">Media Sosial</span>
                        <div class="social-media-content">
                            <a href="https://student-activity.binus.ac.id/himstat/" target="_blank"><img class="logo-img" src="{{ asset('storage/assets/logos/logo-website.png') }}" style="margin-right: 10px;"></a>
                            <a href="https://www.instagram.com/himstat/" target="_blank"><img class="logo-img" src="{{ asset('storage/assets/logos/logo-instagram.png') }}"></a>
                            {{--                <a href="" target="_blank">--}}
                            <img class="logo-img" src="{{ asset('storage/assets/logos/logo-line.png') }}">
                            {{--                </a>--}}
                        </div>
                    </div>
                </div>
                <div class="footer-content fc3">
                    <span class="footer-content-title font-weight-bold" style="font-size:22px; color: #9bd7ff;">Narahubung</span>
                    <table>
                        <tr>
                            <th style="width: 10%;"></th>
                            <th style="width: 90%;"></th>
                        </tr>
                        <tr>
                            <td><img src="{{ asset('storage/assets/logos/logo-telepon.png') }}" width="22px" height="22px"></td>
                            <td><span class="footer-content-details text-white" style="font-size:16px;">Lorem Ipsum (0800 0000 0000)</span></td>
                        </tr>
                        <tr>
                            <td><img src="{{ asset('storage/assets/logos/logo-telepon.png') }}" width="22px" height="22px"></td>
                            <td><span class="footer-content-details text-white" style="font-size:16px;">Lorem Ipsum (0800 0000 0000)</span></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </footer>

    {{-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script> --}}
    <script src="{{ asset('js/countdown.js') }}"></script>

    @yield('script')
  </body>
</html>

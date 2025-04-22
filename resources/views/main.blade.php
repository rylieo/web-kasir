<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    @include('layout.include-header')
</head>


<body>
    @include('layout.loading-animation')

    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full"
        data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
        <!-- ============================================================== -->
        @include('layout.header')
        @include('layout.nav')

        <div class="page-wrapper">

            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row align-items-center">
                    <div class="col-6">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 d-flex align-items-center">
                              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="link"><i class="mdi mdi-home-outline fs-4"></i></a></li>
                              <li class="breadcrumb-item active" aria-current="page" id="breadcrumb-text">
                                @if(Route::currentRouteName() == 'dashboard')
                                    Dashboard
                                @elseif(Route::currentRouteName() == 'product')
                                    Produk
                                @elseif(Route::currentRouteName() == 'product.create')
                                    Tambah Produk
                                @elseif(Route::currentRouteName() == 'product.edit')
                                    Ubah Produk
                                @elseif(Route::currentRouteName() == 'user.list')
                                     Pengguna
                                @elseif(Route::currentRouteName() == 'user.create')
                                     Tambah Pengguna
                                @elseif(Route::currentRouteName() == 'user.edit')
                                     Ubah Pengguna
                                @elseif(Route::currentRouteName() == 'sales')
                                     Penjualan
                                @elseif(Route::currentRouteName() == 'sales.create')
                                     Tambah Penjualan
                                @elseif(Route::currentRouteName() == 'sales.post')
                                     Tambah Penjualan / Detail Harga
                                @elseif(Route::currentRouteName() == 'sales.print.show')
                                     Cetak Faktur
                                @elseif(Route::currentRouteName() == 'sales.create.member')
                                     Lihat Member
                                @else
                                    Halaman Tidak Diketahui
                                @endif
                              </li>
                            </ol>
                          </nav>
                          <h1 class="mb-0 fw-bold" id="page-title"></h1>
                    </div>
                </div>
            </div>
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                  const breadcrumbText = document.getElementById("breadcrumb-text").innerText;
                  document.getElementById("page-title").innerText = breadcrumbText;
                });
              </script>
            <div class="container-fluid">
                @yield('content')
            </div>
            @include('layout.footer')
        </div>

    </div>

    @include('layout.include-footer')
    @stack('script')
</body>

</html>

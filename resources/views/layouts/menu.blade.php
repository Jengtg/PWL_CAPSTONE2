{{-- resources/views/layouts/menu.blade.php --}}
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ url('/') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                {{-- SVG Logo Anda bisa tetap di sini --}}
                <svg width="25" viewBox="0 0 25 42" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <defs><path d="M13.7918663,0.358365126 L3.39788168,7.44174259 C0.566865006,9.69408886 -0.379795268,12.4788597 0.557900856,15.7960551 C0.68998853,16.2305145 1.09562888,17.7872135 3.12357076,19.2293357 C3.8146334,19.7207684 5.32369333,20.3834223 7.65075054,21.2172976 L7.59773219,21.2525164 L2.63468769,24.5493413 C0.445452254,26.3002124 0.0884951797,28.5083815 1.56381646,31.1738486 C2.83770406,32.8170431 5.20850219,33.2640127 7.09180128,32.5391577 C8.347334,32.0559211 11.4559176,30.0011079 16.4175519,26.3747182 C18.0338572,24.4997857 18.6973423,22.4544883 18.4080071,20.2388261 C17.963753,17.5346866 16.1776345,15.5799961 13.0496516,14.3747546 L10.9194936,13.4715819 L18.6192054,7.984237 L13.7918663,0.358365126 Z" id="path-1"></path><path d="M5.47320593,6.00457225 C4.05321814,8.216144 4.36334763,10.0722806 6.40359441,11.5729822 C8.61520715,12.571656 10.0999176,13.2171421 10.8577257,13.5094407 L15.5088241,14.433041 L18.6192054,7.984237 C15.5364148,3.11535317 13.9273018,0.573395879 13.7918663,0.358365126 C13.5790555,0.511491653 10.8061687,2.3935607 5.47320593,6.00457225 Z" id="path-3"></path><path d="M7.50063644,21.2294429 L12.3234468,23.3159332 C14.1688022,24.7579751 14.397098,26.4880487 13.008334,28.506154 C11.6195701,30.5242593 10.3099883,31.790241 9.07958868,32.3040991 C5.78142938,33.4346997 4.13234973,34 4.13234973,34 C4.13234973,34 2.75489982,33.0538207 2.37032616e-14,31.1614621 C-0.55822714,27.8186216 -0.55822714,26.0572515 -4.05231404e-15,25.8773518 C0.83734071,25.6075023 2.77988457,22.8248993 3.3049379,22.52991 C3.65497346,22.3332504 5.05353963,21.8997614 7.50063644,21.2294429 Z" id="path-4"></path><path d="M20.6,7.13333333 L25.6,13.8 C26.2627417,14.6836556 26.0836556,15.9372583 25.2,16.6 C24.8538077,16.8596443 24.4327404,17 24,17 L14,17 C12.8954305,17 12,16.1045695 12,15 C12,14.5672596 12.1403557,14.1461923 12.4,13.8 L17.4,7.13333333 C18.0627417,6.24967773 19.3163444,6.07059163 20.2,6.73333333 C20.3516113,6.84704183 20.4862915,6.981722 20.6,7.13333333 Z" id="path-5"></path></defs><g id="g-app-brand" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g id="Brand-Logo" transform="translate(-27.000000, -15.000000)"><g id="Icon" transform="translate(27.000000, 15.000000)"><g id="Mask" transform="translate(0.000000, 8.000000)"><mask id="mask-2" fill="white"><use xlink:href="#path-1"></use></mask><use fill="#696cff" xlink:href="#path-1"></use><g id="Path-3" mask="url(#mask-2)"><use fill="#696cff" xlink:href="#path-3"></use><use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-3"></use></g><g id="Path-4" mask="url(#mask-2)"><use fill="#696cff" xlink:href="#path-4"></use><use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-4"></use></g></g><g id="Triangle" transform="translate(19.000000, 11.000000) rotate(-300.000000) translate(-19.000000, -11.000000) "><use fill="#696cff" xlink:href="#path-5"></use><use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-5"></use></g></g></g></g></svg>
            </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2">{{ config('app.name', 'Sneat') }}</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">

        {{-- MENU UNTUK SEMUA PENGGUNA YANG LOGIN --}}
        @auth
            <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-home-circle"></i>
                    <div data-i18n="Dashboard">Dashboard</div>
                </a>
            </li>
        @endauth

        {{-- MENU UNTUK GUEST (JIKA SIDEBAR TAMPIL UNTUK GUEST, UMUMNYA TIDAK) --}}
        {{-- ATAU MENU PUBLIK JIKA SIDEBAR INI JUGA DIPAKAI DI HALAMAN PUBLIK --}}
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Public</span>
        </li>
        <li class="menu-item {{ request()->routeIs('events.guest.index') ? 'active' : '' }}">
            <a href="{{ route('events.guest.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-calendar-event"></i>
                <div data-i18n="Daftar Event">Daftar Event</div>
            </a>
        </li>

        @auth
            {{-- MENU KHUSUS UNTUK ROLE 'member' --}}
            @if(auth()->user()->role == 'member')
                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">Area Member</span>
                </li>
                <li class="menu-item {{ request()->routeIs('member.registrations.index') ? 'active' : '' }}">
                    {{-- Ganti dengan route yang benar --}}
                    <a href="#" class="menu-link"> 
                        <i class="menu-icon tf-icons bx bx-list-check"></i>
                        <div data-i18n="Event Saya">Event Saya</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('member.certificates.index') ? 'active' : '' }}">
                    {{-- Ganti dengan route yang benar --}}
                    <a href="#" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-file-blank"></i>
                        <div data-i18n="Sertifikat Saya">Sertifikat Saya</div>
                    </a>
                </li>
            @endif

            {{-- MENU KHUSUS UNTUK ROLE 'panitia_kegiatan' --}}
            @if(auth()->user()->role == 'panitia_kegiatan')
                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">Panitia Kegiatan</span>
                </li>
                <li class="menu-item {{ request()->routeIs('committee.events.*') ? 'open active' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons bx bx-calendar-edit"></i>
                        <div data-i18n="Kelola Event">Kelola Event</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ request()->routeIs('committee.events.index') ? 'active' : '' }}">
                            <a href="{{ route('committee.events.index') }}" class="menu-link">
                                <div data-i18n="Daftar Event">Daftar Event</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('committee.events.create') ? 'active' : '' }}">
                            <a href="{{ route('committee.events.create') }}" class="menu-link">
                                <div data-i18n="Tambah Event">Tambah Event Baru</div>
                            </a>
                        </li>
                    </ul>
                </li>
                 <li class="menu-item {{ request()->routeIs('committee.attendance.*') ? 'active' : '' }}">
                    {{-- Ganti dengan route yang benar --}}
                    <a href="#" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-qr-scan"></i>
                        <div data-i18n="Kelola Kehadiran">Kelola Kehadiran</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('committee.certificates.*') ? 'active' : '' }}">
                     {{-- Ganti dengan route yang benar --}}
                    <a href="#" class="menu-link">
                        <i class="menu-icon tf-icons bx bxs-file-pdf"></i>
                        <div data-i18n="Kelola Sertifikat">Kelola Sertifikat</div>
                    </a>
                </li>
            @endif

            {{-- MENU KHUSUS UNTUK ROLE 'tim_keuangan' --}}
            @if(auth()->user()->role == 'tim_keuangan')
                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">Tim Keuangan</span>
                </li>
                <li class="menu-item {{ request()->routeIs('finance.payments.*') ? 'active' : '' }}">
                    {{-- Ganti dengan route yang benar --}}
                    <a href="#" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-money-withdraw"></i>
                        <div data-i18n="Verifikasi Pembayaran">Verifikasi Pembayaran</div>
                    </a>
                </li>
                {{-- Tambahkan menu laporan jika perlu --}}
            @endif

            {{-- MENU KHUSUS UNTUK ROLE 'administrator' --}}
            @if(auth()->user()->role == 'administrator')
                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">Administrasi</span>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    {{-- Ganti dengan route yang benar --}}
                    <a href="#" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-group"></i>
                        <div data-i18n="Kelola Pengguna">Kelola Pengguna</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.event-categories.*') ? 'active' : '' }}">
                    {{-- Ganti dengan route yang benar --}}
                    <a href="#" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-category"></i>
                        <div data-i18n="Kelola Kategori Event">Kategori Event</div>
                    </a>
                </li>
                {{-- Tambahkan menu administrasi lainnya jika perlu --}}
            @endif

            {{-- Pengaturan Akun Umum untuk semua yang login --}}
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Akun</span>
            </li>
            <li class="menu-item {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                <a href="{{ route('profile.edit') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user-circle"></i>
                    <div data-i18n="Profil Saya">Profil Saya</div>
                </a>
            </li>
            {{-- Tombol Logout biasanya ada di Navbar atas, tapi bisa juga ditambahkan di sini jika mau --}}
            {{-- <li class="menu-item">
                <form method="POST" action="{{ route('logout') }}" id="logout-form-sidebar">
                    @csrf
                    <a class="menu-link" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();">
                        <i class="menu-icon tf-icons bx bx-log-out-circle"></i>
                        <div data-i18n="Logout">Logout</div>
                    </a>
                </form>
            </li> --}}
        @endauth



    </ul>
</aside>
<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'title' => 'SIRAMAH-RS Waleds',
    'title_prefix' => '',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_ico_only' => true,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo' => '<b>SIRAMAH-RS Waled</b>',
    'logo_img' => 'vendor/adminlte/dist/img/rswaledico.png',
    'logo_img_class' => 'brand-image',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'SIRAMAH-RS Waled',

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => false,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => true,
    'usermenu_desc' => false,
    'usermenu_profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => null,
    'layout_fixed_navbar' => null,
    'layout_fixed_footer' => null,
    'layout_dark_mode' => null,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_body' => 'text-sm',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-primary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'sidebar_mini' => 'lg',
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => false,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url' => false,
    'dashboard_url' => 'home',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
    'profile_url' => 'profile',

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For detailed instructions you can look the laravel mix section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'enabled_laravel_mix' => false,
    'laravel_mix_css_path' => 'css/app.css',
    'laravel_mix_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'menu' => [
        // Navbar items:
        [
            'type'         => 'navbar-search',
            'text'         => 'search',
            'topnav_right' => true,
        ],
        [
            'type'         => 'fullscreen-widget',
            'topnav_right' => true,
        ],

        // Sidebar items:
        [
            'type' => 'sidebar-menu-search',
            'text' => 'search',
        ],
        ['header' => 'MENU UTAMA'],
        [
            'text'        => 'Daftar Online',
            'url'         => 'daftar_online',
            'icon'        => 'fas fa-user-plus',
        ],
        [
            'text'        => 'Landing Page',
            'url'         => '',
            'icon'        => 'fas fa-home',
        ],
        [
            'text'        => 'Dashboard',
            'url'         => 'home',
            'icon'        => 'fas fa-home',
        ],
        //MENU INFO
        // [
        //     'text'        => 'Menu Informasi Umum',
        //     'icon'        => 'fas fa-info-circle',
        //     'submenu' => [
        //         // [
        //         //     'text' => 'Jadwal Dokter Poliklinik',
        //         //     'icon'    => 'fas fa-calendar-alt',
        //         //     'shift'   => 'ml-2',
        //         //     'url'  => 'info_jadwaldokter',
        //         //     // 'can' => 'admin',
        //         // ],
        //         // [
        //         //     'text' => 'Jadwal Libur Poliklinik',
        //         //     'icon'    => 'fas fa-calendar-times',
        //         //     'shift'   => 'ml-2',
        //         //     'url'  => 'info_jadwallibur',
        //         // ],
        //         // [
        //         //     'text' => 'Jadwal Operasi',
        //         //     'icon'    => 'fas fa-calendar-alt',
        //         //     'shift'   => 'ml-2',
        //         //     'url'  => 'info_jadwaloperasi',
        //         //     // 'can' => 'admin',
        //         // ],
        //         // [
        //         //     'text' => 'Status Antrian',
        //         //     'icon'    => 'fas fa-sign-in-alt',
        //         //     'url'  => 'info/antrian',
        //         //     'shift'   => 'ml-2',
        //         // ],
        //         // [
        //         //     'text' => 'Info Poliklinik',
        //         //     'icon'    => 'fas fa-clinic-medical',
        //         //     'shift'   => 'ml-2',
        //         //     'url'  => 'info/poliklinik',
        //         // ],
        //         // [
        //         //     'text' => 'Jadwal Poliklinik',
        //         //     'icon'    => 'fas fa-calendar-alt',
        //         //     'url'  => 'info/jadwal_poliklinik',
        //         //     'shift'   => 'ml-2',
        //         // ],
        //         // [
        //         //     'text' => 'Jadwal Libur Poliklinik',
        //         //     'icon'    => 'fas fa-calendar-times',
        //         //     'shift'   => 'ml-2',
        //         //     'url'  => 'info/jadwal_poli_libur',
        //         // ],
        //     ]
        // ],
        // PENDAFTARAN
        [
            'text'    => 'Aplikasi Pendaftaran',
            'icon'    => 'fas fa-user-plus',
            'can' => 'pendaftaran',
            'submenu' => [
                [
                    'text' => 'Console Antrian',
                    'icon'    => 'fas fa-desktop',
                    'url'  => 'antrian/console',
                    'shift'   => 'ml-2',
                    'can' => 'pendaftaran',
                ],
                // [
                //     'text' => 'Antrian Pendaftaran',
                //     'icon'    => 'fas fa-user-plus',
                //     'url'  => 'antrian/pendaftaran',
                //     'shift'   => 'ml-2',
                //     'can' => 'pendaftaran',
                // ],
                [
                    'text' => 'Antrian Pendaftaran',
                    'icon'    => 'fas fa-user-plus',
                    'url'  => 'pendaftaran/antrian_pendaftaran',
                    'shift'   => 'ml-2',
                    'can' => 'pendaftaran',
                ],
                [
                    'text' => 'Capaian Antrian',
                    'icon'    => 'fas fa-chart-bar',
                    'url'  => 'pendaftaran/antrian_capaian',
                    'shift'   => 'ml-2',
                    'can' => 'pendaftaran',
                ],
            ],
        ],
        // KASIR
        [
            'text'    => 'Aplikasi Kasir',
            'icon'    => 'fas fa-cash-register',
            'can' => 'kasir',
            'submenu' => [
                [
                    'text' => 'Antrian Pembayaran',
                    'icon'    => 'fas fa-hand-holding-usd',
                    'url'  => 'antrian/pembayaran',
                    'shift'   => 'ml-2',
                    'can' => 'kasir',
                ],
            ],
        ],
        // POLIKLINIK
        [
            'text'    => 'Aplikasi Poliklinik',
            'icon'    => 'fas fa-clinic-medical',
            'can' => 'poliklinik',
            'submenu' => [
                [
                    'text' => 'Antrian Pasien',
                    'icon'    => 'fas fa-user-injured',
                    'url'  => 'poliklinik/antrian',
                    'shift'   => 'ml-2',
                    'can' => 'poliklinik',
                ],
                [
                    'text' => 'Surat Kontrol Poliklinik',
                    'icon'    => 'fas fa-file-medical',
                    'url'  => 'poliklinik/suratkontrol_poliklinik',
                    'shift'   => 'ml-2',
                    'can' => 'poliklinik',
                ],
                // [
                //     'text' => 'Jadwal Dokter Poliklinik',
                //     'icon'    => 'fas fa-calendar-alt',
                //     'shift'   => 'ml-2',
                //     'url'  => 'poliklinik/jadwaldokter',
                //     'can' => 'poliklinik',
                // ],
                [
                    'text' => 'Data Pasien',
                    'icon'    => 'fas fa-user-injured',
                    'url'  => 'poliklinik/pasien',
                    'shift'   => 'ml-2',
                    'can' => 'poliklinik',
                ],
                [
                    'text' => 'Laporan Kunjungan Poliklinik',
                    'icon'    => 'fas fa-chart-line',
                    'shift'   => 'ml-2',
                    'url'  => 'poliklinik/laporan_kunjungan_poliklinik',
                    'can' => 'poliklinik',
                ],
                [
                    'text' => 'Laporan Antrian',
                    'icon'    => 'fas fa-chart-line',
                    'shift'   => 'ml-2',
                    'url'  => 'poliklinik/laporan_antrian_poliklinik',
                    'can' => 'poliklinik',
                ],
                [
                    'text' => 'Dashboard Pertanggal',
                    'icon'    => 'fas fa-chart-line',
                    'shift'   => 'ml-2',
                    'url'  => 'poliklinik/dashboard_antrian_tanggal',
                    'can' => 'poliklinik',
                ],
                [
                    'text' => 'Dashboard Perbulan',
                    'icon'    => 'fas fa-chart-line',
                    'shift'   => 'ml-2',
                    'url'  => 'poliklinik/dashboard_antrian_bulan',
                    'can' => 'poliklinik',
                ],
            ],
        ],
        // FARMASI
        [
            'text'    => 'Aplikasi Farmasi',
            'icon'    => 'fas fa-prescription-bottle-alt',
            'can' => 'farmasi',
            'submenu' => [
                [
                    'text' => 'Antrian Obat',
                    'icon'    => 'fas fa-pills',
                    'url'  => 'farmasi/antrian_farmasi',
                    'shift'   => 'ml-2',
                    'can' => 'farmasi',
                ],
                [
                    'text' => 'Obat',
                    'icon'    => 'fas fa-pills',
                    'url'  => 'farmasi/obat',
                    'shift'   => 'ml-2',
                    'can' => 'rekam-medis',
                ],
                [
                    'text' => 'E-KPO Rawat Jalan',
                    'icon'    => 'fas fa-pills',
                    'url'  => 'kpo',
                    'shift'   => 'ml-2',
                    'can' => 'rekam-medis',
                ],
            ],
        ],
        // YANMED
        [
            'text'    => 'Pelayanan Medis',
            'icon'    => 'fas fa-briefcase-medical',
            'can' => 'pelayanan-medis',
            'submenu' => [
                [
                    'text' => 'Dokter',
                    'icon'    => 'fas fa-user-md',
                    'url'  => 'pelayananmedis/dokter',
                    'shift'   => 'ml-2',
                    'can' => 'pelayanan-medis',
                ],
                [
                    'text' => 'Poliklinik',
                    'icon'    => 'fas fa-clinic-medical',
                    'url'  => 'pelayananmedis/poliklinik',
                    'shift'   => 'ml-2',
                    'can' => 'pelayanan-medis',
                ],
                [
                    'text' => 'Tarif Layanan',
                    'icon'    => 'fas fa-hand-holding-medical',
                    'url'  => 'pelayananmedis/tarif_layanan',
                    'shift'   => 'ml-2',
                    'can' => 'pelayanan-medis',

                ],
                [
                    'text' => 'Poliklinik Antrian BPJS',
                    'icon'    => 'fas fa-clinic-medical',
                    'url'  => 'pelayananmedis/poliklinik_antrian',
                    'shift'   => 'ml-2',
                    'can' => 'pelayanan-medis',
                ],
                [
                    'text' => 'Dokter Antrian BPJS',
                    'icon'    => 'fas fa-user-md',
                    'url'  => 'pelayananmedis/dokter_antrian',
                    'shift'   => 'ml-2',
                    'can' => 'pelayanan-medis',
                ],
                [
                    'text' => 'Jadwal Antrian BPJS',
                    'icon'    => 'fas fa-calendar-alt',
                    'shift'   => 'ml-2',
                    'url'  => 'pelayananmedis/jadwaldokter',
                    'can' => 'pelayanan-medis',
                ],
            ],
        ],
        // REKAM MEDIS
        [
            'text'    => 'Rekam Medis',
            'icon'    => 'fas fa-file-medical',
            'can' => 'rekam-medis',
            'submenu' => [
                [
                    'text' => 'Pasien',
                    'icon'    => 'fas fa-user-injured',
                    'url'  => 'rekammedis/pasien',
                    'shift'   => 'ml-2',
                    'active'  => ['pasien', 'pasien/create', 'regex:@^pasien(\/[0-9]+)?+$@', 'regex:@^pasien(\/[0-9]+)?\/edit+$@',],
                    'can' => 'rekam-medis',
                ],
                [
                    'text' => 'Kunjungan',
                    'icon'    => 'fas fa-hospital-user',
                    'url'  => 'rekammedis/kunjungan',
                    'shift'   => 'ml-2',
                    'can' => 'rekam-medis',
                ],
                [
                    'text' => 'Demografi Pasien',
                    'icon'    => 'fas fa-user-injured',
                    'url'  => 'pasien_daerah',
                    'shift'   => 'ml-2',
                    'can' => 'rekam-medis',
                ],
                [
                    'text' => 'Laporan Index',
                    'icon'    => 'fas fa-chart-bar',
                    'shift'   => 'ml-2',
                    'can' => 'rekam-medis',
                    'submenu' => [
                        [
                            'text' => 'Index Penyakit Rawat Jalan',
                            'icon'    => 'fas fa-disease',
                            'url'  => 'index_penyakit_rajal',
                            'shift'   => 'ml-3',
                            'can' => 'rekam-medis',
                        ],
                        [
                            'text' => 'Index Dokter',
                            'icon'    => 'fas fa-user-md',
                            'url'  => 'index_dokter',
                            'shift'   => 'ml-3',
                            'can' => 'rekam-medis',
                        ],
                        [
                            'text' => 'Index Daerah',
                            'icon'    => 'fas fa-maps',
                            'url'  => 'index_daerah',
                            'shift'   => 'ml-3',
                            'can' => 'rekam-medis',
                        ],
                    ]
                ],
                [
                    'text' => 'Laporan Kunjungan Poliklinik',
                    'icon'    => 'fas fa-disease',
                    'url'  => 'rekammedis/kunjungan_poliklinik',
                    'shift'   => 'ml-2',
                    'can' => 'rekam-medis',
                ],
                [
                    'text' => 'Diagnosa ICD-10',
                    'icon'    => 'fas fa-diagnoses',
                    'url'  => 'icd10',
                    'shift'   => 'ml-2',
                    'can' => 'rekam-medis',
                ],
                [
                    'text' => 'E-File Rekam Medis',
                    'icon'    => 'fas fa-diagnoses',
                    'shift'   => 'ml-2',
                    'can' => 'rekam-medis',
                    'url'  => 'efilerm',
                    // 'active'  => ['efilerm', 'efilerm/create' ,'regex:@^antrian/poliklinik(\/[0-9]+)?+$@', 'regex:@^antrian/poliklinik(\/[0-9]+)?\/edit+$@',  'antrian/poliklinik/create'],
                    'active'  => ['efilerm', 'efilerm/create'],

                ],
                [
                    'text' => 'Tindankan Prosedur',
                    'icon'    => 'fas fa-user-injured',
                    'url'  => 'tindakan',
                    'shift'   => 'ml-2',
                    'can' => 'rekam-medis',
                ],


            ],
        ],
        // BAGIAN UMUM
        [
            'text'    => 'Bagian Umum',
            'icon'    => 'fas fa-hospital',
            'can' => ['bagian-umum','direktur'],
            'submenu' => [
                [
                    'text' => 'Surat Masuk',
                    'icon'    => 'fas fa-envelope',
                    'url'  => 'bagianumum/suratmasuk',
                    'shift'   => 'ml-2',
                    'can' => 'bagian-umum',
                ],
                [
                    'text' => 'Disposisi',
                    'icon'    => 'fas fa-file-signature',
                    'url'  => 'bagianumum/disposisi',
                    'shift'   => 'ml-2',
                    'can' =>  ['bagian-umum','direktur'],
                ],
                [
                    'text' => 'Surat Keluar',
                    'icon'    => 'fas fa-envelope',
                    'url'  => 'bagianumum/suratkeluar',
                    'shift'   => 'ml-2',
                    'can' => 'bagian-umum',
                ],
            ],
        ],
        // BUKU TAMU
        [
            'text'    => 'Aplikasi Buku Tamu',
            'icon'    => 'fas fa-user-tie',
            'can' => ['admin'],
            'submenu' => [
                [
                    'text' => 'Buku Tamu',
                    'icon'    => 'fas fa-book',
                    'url'  => 'bukutamu',
                    'shift'   => 'ml-2',
                    'can' => 'admin',
                ],
                [
                    'text' => 'Data Tamu',
                    'icon'    => 'fas fa-book',
                    'url'  => 'bukutamu',
                    'shift'   => 'ml-2',
                    'can' => 'admin',
                ],
            ]
        ],
        // ANTRIAN BPJS
        [
            'text'    => 'Integrasi Antrian BPJS',
            'icon'    => 'fas fa-project-diagram',
            'can' => 'bpjs',
            'submenu' => [
                [
                    'text' => 'Status',
                    'icon'    => 'fas fa-info-circle',
                    'url'  => 'bpjs/antrian/status',
                    'shift'   => 'ml-2',
                    'can' => 'bpjs',
                ],
                [
                    'text' => 'Poliklinik',
                    'icon'    => 'fas fa-clinic-medical',
                    'url'  => 'bpjs/antrian/poli',
                    'shift'   => 'ml-2',
                    'can' => 'bpjs',
                ],
                [
                    'text' => 'Poliklinik',
                    'icon'    => 'fas fa-clinic-medical',
                    'url'  => 'bpjs/antrian/poli',
                    'shift'   => 'ml-2',
                    'can' => 'bpjs',
                ],
                [
                    'text' => 'Dokter',
                    'icon'    => 'fas fa-user-md',
                    'url'  => 'bpjs/antrian/dokter',
                    'shift'   => 'ml-2',
                    'can' => 'bpjs',
                ],
                [
                    'text' => 'Jadwal Dokter',
                    'icon'    => 'fas fa-calendar-alt',
                    'url'  => 'bpjs/antrian/jadwal_dokter',
                    'shift'   => 'ml-2',
                    'can' => 'bpjs',
                ],
                [
                    'text' => 'Cek Fingerprint Peserta',
                    'icon'    => 'fas fa-fingerprint',
                    'url'  => 'bpjs/antrian/fingerprint_peserta',
                    'shift'   => 'ml-2',
                    'can' => 'bpjs',
                ],
                [
                    'text' => 'Console Antrian',
                    'icon'    => 'fas fa-desktop',
                    'url'  => 'antrian/console',
                    'shift'   => 'ml-2',
                    'can' => 'pendaftaran',
                ],
                [
                    'text' => 'Antrian',
                    'icon'    => 'fas fa-hospital-user',
                    'url'  => 'bpjs/antrian/antrian',
                    'shift'   => 'ml-2',
                    'can' => 'bpjs',
                ],
                [
                    'text' => 'List Task',
                    'icon'    => 'fas fa-user-clock',
                    'url'  => 'bpjs/antrian/list_task',
                    'shift'   => 'ml-2',
                    'can' => 'bpjs',
                ],
                [
                    'text' => 'Dasboard Tanggal',
                    'icon'    => 'fas fa-calendar-day',
                    'url'  => 'bpjs/antrian/dashboard_tanggal',
                    'shift'   => 'ml-2',
                    'can' => 'bpjs',
                ],
                [
                    'text' => 'Dashboard Bulan',
                    'icon'    => 'fas fa-calendar-week',
                    'url'  => 'bpjs/antrian/dashboard_bulan',
                    'shift'   => 'ml-2',
                    'can' => 'bpjs',
                ],
                [
                    'text' => 'Jadwal Operasi',
                    'icon'    => 'fas fa-calendar-alt',
                    'url'  => 'bpjs/antrian/jadwal_operasi',
                    'shift'   => 'ml-2',
                    'can' => 'bpjs',
                ],
                [
                    'text' => 'Antrian Per Tanggal',
                    'icon'    => 'fas fa-calendar-day',
                    'url'  => 'bpjs/antrian/antrian_per_tanggal',
                    'shift'   => 'ml-2',
                    'can' => 'bpjs',
                ],
                [
                    'text' => 'Antrian Per Kodebooking',
                    'icon'    => 'fas fa-calendar-day',
                    'url'  => 'bpjs/antrian/antrian_per_kodebooking',
                    'shift'   => 'ml-2',
                    'can' => 'bpjs',
                ],
                [
                    'text' => 'Antrian Belum  Dilayani',
                    'icon'    => 'fas fa-calendar-day',
                    'url'  => 'bpjs/antrian/antrian_belum_dilayani',
                    'shift'   => 'ml-2',
                    'can' => 'bpjs',
                ],
                [
                    'text' => 'Antrian Per Dokter',
                    'icon'    => 'fas fa-calendar-day',
                    'url'  => 'bpjs/antrian/antrian_per_dokter',
                    'shift'   => 'ml-2',
                    'can' => 'bpjs',
                ],

            ],
        ],
        // VCLAIM BPJS
        [
            'text'    => 'Integrasi VClaim BPJS',
            'icon'    => 'fas fa-project-diagram',
            'can' => 'bpjs',
            'submenu' => [
                [
                    'text' => 'Lembar Pengajuan Klaim',
                    'icon'    => 'fas fa-id-card',
                    'url'  => 'vclaim/lpk',
                    'shift'   => 'ml-2',
                    'can' => 'bpjs',
                ],
                [
                    'text' => 'Monitoring',
                    'icon'    => 'fas fa-chart-line',
                    'shift'   => 'ml-2',
                    'submenu' => [
                        [
                            'text' => 'Data Kunjungan',
                            'icon'    => 'fas fa-chart-bar',
                            'url'  => 'bpjs/vclaim/monitoring_data_kunjungan',
                            'shift'   => 'ml-3',
                            'can' => 'bpjs',
                        ],
                        [
                            'text' => 'Data Klaim',
                            'icon'    => 'fas fa-chart-pie',
                            'url'  => 'bpjs/vclaim/monitoring_data_klaim',
                            'shift'   => 'ml-3',
                            'can' => 'bpjs',
                        ],
                        [
                            'text' => 'Monitoring Pelayanan Peserta',
                            'icon'    => 'fas fa-id-card',
                            'url'  => 'bpjs/vclaim/monitoring_pelayanan_peserta',
                            'shift'   => 'ml-3',
                            'can' => 'bpjs',
                        ],
                        [
                            'text' => 'Data Klaim Jasa Raharja',
                            'icon'    => 'fas fa-chart-area',
                            'url'  => 'bpjs/vclaim/monitoring_klaim_jasaraharja',
                            'shift'   => 'ml-3',
                            'can' => 'bpjs',
                        ],
                    ]

                ],
                [
                    'text' => 'PRB',
                    'icon'    => 'fas fa-first-aid',
                    'url'  => 'vclaim/prb',
                    'shift'   => 'ml-2',
                    'can' => 'bpjs',
                ],
                [
                    'text' => 'Referensi',
                    'icon'    => 'fas fa-info-circle',
                    'url'  => 'bpjs/vclaim/referensi',
                    'shift'   => 'ml-2',
                    'can' => 'bpjs',
                ],
                [
                    'text' => 'Surat Kontrol & SPRI',
                    'icon'    => 'fas fa-id-card',
                    'url'  => 'bpjs/vclaim/surat_kontrol',
                    'shift'   => 'ml-2',
                    'can' => 'bpjs',
                ],
                [
                    'text' => 'Surat Kontrol & SPRI',
                    'icon'    => 'fas fa-id-card',
                    'url'  => 'vclaim/data_surat_kontrol',
                    'shift'   => 'ml-2',
                    'can' => 'bpjs',
                ],
                [
                    'text' => 'Rujukan',
                    'icon'    => 'fas fa-id-card',
                    'url'  => 'vclaim/rujukan',
                    'shift'   => 'ml-2',
                    'can' => 'bpjs',
                ],
                [
                    'text' => 'SEP',
                    'icon'    => 'fas fa-chart-line',
                    'shift'   => 'ml-2',
                    'submenu' => [
                        [
                            'text' => 'Data SEP',
                            'icon'    => 'fas fa-id-card',
                            'url'  => 'vclaim/sep_internal',
                            'shift'   => 'ml-3',
                            'can' => 'bpjs',
                        ],
                        [
                            'text' => 'SEP Internal',
                            'icon'    => 'fas fa-id-card',
                            'url'  => 'vclaim/sep_internal',
                            'shift'   => 'ml-3',
                            'can' => 'bpjs',
                        ],
                    ]

                ],

            ],
        ],
        // SATU SEHAT
        [
            'text'    => 'Integrasi Satu Sehat',
            'icon'    => 'fas fa-project-diagram',
            'can' => 'admin',
            'submenu' => [
                [
                    'text' => 'Status',
                    'icon'    => 'fas fa-info-circle',
                    'url'  => 'satusehat/status',
                    'shift'   => 'ml-2',
                    'can' => 'admin',
                ],
                [
                    'text' => 'Patient',
                    'icon'    => 'fas fa-user-injured',
                    'url'  => 'satusehat/patient',
                    'shift'   => 'ml-2',
                    'can' => 'admin',
                    // 'active'  => ['patient', 'patient/create', 'regex:@^patient(\/[0-9]+)?+$@', 'regex:@^patient(\/[0-9]+)?\/edit+$@',],
                ],
                [
                    'text' => 'Practitioner',
                    'icon'    => 'fas fa-user-md',
                    'url'  => 'satusehat/practitioner',
                    'shift'   => 'ml-2',
                    'can' => 'admin',
                    // 'active'  => ['practitioner', 'practitioner/create', 'regex:@^practitioner(\/[0-9]+)?+$@', 'regex:@^practitioner(\/[0-9]+)?\/edit+$@',],
                ],
                [
                    'text' => 'Organization',
                    'icon'    => 'fas fa-hospital',
                    'url'  => 'satusehat/organization',
                    'shift'   => 'ml-2',
                    'can' => 'admin',
                    // 'active'  => ['practitioner', 'practitioner/create', 'regex:@^practitioner(\/[0-9]+)?+$@', 'regex:@^practitioner(\/[0-9]+)?\/edit+$@',],
                ],
                [
                    'text' => 'Location',
                    'icon'    => 'fas fa-map-marked-alt',
                    'url'  => 'satusehat/location',
                    'shift'   => 'ml-2',
                    'can' => 'admin',
                ],
                [
                    'text' => 'Encounter',
                    'icon'    => 'fas fa-hand-holding-medical',
                    'url'  => 'satusehat/encounter',
                    'shift'   => 'ml-2',
                    'can' => 'admin',
                    'active'  => ['satusehat/encounter', 'satusehat/encounter/create',],
                ],
                [
                    'text' => 'Condition',
                    'icon'    => 'fas fa-heartbeat',
                    'url'  => 'satusehat/condition',
                    'shift'   => 'ml-2',
                    'can' => 'admin',
                ],
            ],
        ],
        // MODUL TESTING
        [
            'text'    => 'Pengaturan & Testing',
            'icon'    => 'fas fa-cogs',
            'can' => 'admin',
            'submenu' => [
                [
                    'text' => 'Bar & QR Code Scanner',
                    'icon'    => 'fas fa-qrcode',
                    'url'  => 'bar_qr_scanner',
                    'shift'   => 'ml-2',
                    'can' => 'admin',
                ],
                [
                    'text' => 'Thermal Printer',
                    'icon'    => 'fas fa-print',
                    'url'  => 'thermal_printer',
                    'shift'   => 'ml-2',
                    'can' => 'admin',
                ],
                [
                    'text' => 'WhatsApp API',
                    'icon'    => 'fas fa-phone',
                    'url'  => 'whatsapp',
                    'shift'   => 'ml-2',
                    'can' => 'admin',
                ],
                [
                    'text'        => 'Log Viewer',
                    'url'         => 'log-viewer',
                    'icon'        => 'fas fa-info-circle',
                    'shift'   => 'ml-2',
                    'can' => 'admin',
                ],
            ],
        ],
        // USER ACCESS CONTROLL
        [
            'text'    => 'User Access Control',
            'icon'    => 'fas fa-users-cog',
            'can' => 'admin',
            'submenu' => [
                [
                    'text' => 'User',
                    'icon'    => 'fas fa-users',
                    'url'  => 'user',
                    'shift'   => 'ml-2',
                    'can' => 'admin',
                    'active'  => ['user', 'user/create', 'regex:@^user(\/[0-9]+)?+$@', 'regex:@^user(\/[0-9]+)?\/edit+$@',],
                ],
                [
                    'text' => 'Role & Permission',
                    'icon'    => 'fas fa-user-shield',
                    'url'  => 'role',
                    'shift'   => 'ml-2',
                    'active'  => ['role', 'role/create', 'regex:@^role(\/[0-9]+)?+$@', 'regex:@^role(\/[0-9]+)?\/edit+$@', 'regex:@^permission(\/[0-9]+)?\/edit+$@'],
                    'can' => 'admin',
                ],
            ],
        ],
        [
            'text' => 'profile',
            'url'  => 'profile',
            'icon' => 'fas fa-fw fa-user',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Plugins-Configuration
    |
    */

    'plugins' => [
        'TempusDominusBs4' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/moment/moment.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css',
                ],
            ],
        ],
        'Datatables' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/datatables/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'DatatablesPlugins' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/buttons/js/dataTables.buttons.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/buttons/js/buttons.bootstrap4.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/buttons/js/buttons.html5.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/buttons/js/buttons.print.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/jszip/jszip.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/pdfmake/pdfmake.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/pdfmake/vfs_fonts.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/buttons/css/buttons.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/select2/js/select2.full.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/select2/css/select2.min.css',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/select2-bootstrap4-theme/select2-bootstrap4.min.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/chart.js/Chart.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/chart.js/Chart.min.css',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/sweetalert2/sweetalert2.all.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css',
                ],
            ],
        ],
        'BootstrapSwitch' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/bootstrap-switch/js/bootstrap-switch.min.js',
                ],
            ],
        ],
        'Pace' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/pace-progress/themes/blue/pace-theme-flat-top.css'
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/pace-progress/pace.min.js'
                ],
            ],
        ],
        'DateRangePicker' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' =>  'vendor/moment/moment.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/daterangepicker/daterangepicker.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/daterangepicker/daterangepicker.css',
                ],
            ],
        ],
        'EkkoLightBox' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' =>  'vendor/ekko-lightbox/ekko-lightbox.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' =>  'vendor/ekko-lightbox/ekko-lightbox.css',
                ],
            ],
        ],
        'BsCustomFileInput' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/bs-custom-file-input/bs-custom-file-input.min.js',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | IFrame
    |--------------------------------------------------------------------------
    |
    | Here we change the IFrame mode configuration. Note these changes will
    | only apply to the view that extends and enable the IFrame mode.
    |
    | For detailed instructions you can look the iframe mode section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/IFrame-Mode-Configuration
    |
    */

    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
        'buttons' => [
            'close' => true,
            'close_all' => true,
            'close_all_other' => true,
            'scroll_left' => true,
            'scroll_right' => true,
            'fullscreen' => true,
        ],
        'options' => [
            'loading_screen' => 1000,
            'auto_show_new_tab' => true,
            'use_navbar_items' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'livewire' => false,
];

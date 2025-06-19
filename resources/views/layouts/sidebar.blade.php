<style>
    /* Styling Sidebar */
    .sidebar {
        background: linear-gradient(180deg, #2c3e50, #34495e); /* Warna biru gelap lembut */
        width: 300px;
        color: #ecf0f1; /* Warna teks terang */
        font-family: 'Montserrat', sans-serif;
        font-size: 0.95rem;
        padding: 1rem;
        box-shadow: 4px 0 12px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease-in-out;
    }

    .sidebar:hover {
        box-shadow: 6px 0 16px rgba(0, 0, 0, 0.15);
    }

    .sidebar .nav-item {
        margin-bottom: 0.8rem;
    }

    .sidebar .nav-link {
        color: #ecf0f1; /* Warna teks terang */
        text-decoration: none;
        padding: 0.75rem 1rem;
        border-radius: 8px;
        display: flex;
        align-items: center;
        transition: all 0.3s ease-in-out;
        font-weight: 500;
    }

    .sidebar .nav-link:hover {
        background: rgba(255, 255, 255, 0.1);
        color: #bdc3c7; /* Warna hover sedikit lebih terang */
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    }

    .sidebar .nav-link.active {
        background: #3498db; /* Warna biru terang */
        color: #ffffff;
        font-weight: 600;
        box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.2);
    }

    .sidebar .nav-link .icon {
        margin-right: 0.75rem;
        font-size: 1.2rem;
    }

    @media (max-width: 768px) {
        .sidebar {
            width: 200px;
            font-size: 0.85rem;
        }

        .sidebar .nav-link {
            padding: 0.5rem 0.75rem;
        }

        .sidebar .nav-link .icon {
            margin-right: 0.5rem;
            font-size: 1rem;
        }
    }
</style>

<div class="sidebar">
    <ul class="nav flex-column">
        <li class="nav-item"><a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><span class="icon">🏠</span> Beranda</a></li>
        <li class="nav-item"><a href="{{ route('admin.akun') }}" class="nav-link {{ request()->routeIs('admin.akun') ? 'active' : '' }}"><span class="icon">👤</span> Manajemen Akun</a></li>
        <li class="nav-item"><a href="{{ route('admin.mitra') }}" class="nav-link  {{ request()->routeIs('admin.mitra') ? 'active' : '' }}"><span class="icon">🤝</span> Manajemen Mitra</a></li>
        <li class="nav-item"><a href="{{ route('admin.kerjasama') }}" class="nav-link {{ request()->routeIs('admin.kerjasama') ? 'active' : '' }}"><span class="icon">📄</span> Manajemen Pengajuan Kerja Sama</a></li>
        <li class="nav-item"><a href="{{ route('admin.dokumentasi') }}" class="nav-link {{ request()->routeIs('admin.dokumentasi') ? 'active' : '' }}"><span class="icon">📷</span> Manajemen Dokumentasi</a></li>
        <li class="nav-item"><a href="{{ route('admin.acara') }}" class="nav-link {{ request()->routeIs('admin.acara') ? 'active' : '' }}"><span class="icon">📅</span> Manajemen Event</a></li>
        <li class="nav-item"><a href="{{ route('admin.dokumentasia') }}" class="nav-link {{ request()->routeIs('admin.dokumentasia') ? 'active' : '' }}"><span class="icon">📘</span> Implementasi Dokumentasi Event</a></li>
        <li class="nav-item"><a href="{{ route('admin.profil') }}" class="nav-link {{ request()->routeIs('admin.profil') ? 'active' : '' }}"><span class="icon">🧑</span> Profil</a></li>
    </ul>
</div>

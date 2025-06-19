<style>
    /* Styling Navbar */
    nav.navbar {
        border-radius: 5px;
        background: linear-gradient(135deg, #ffffff, #e8f0f8);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        padding: 0.25rem 1.0rem;
        transition: all 0.3s ease-in-out;
    }

    nav.navbar:hover {
        background: linear-gradient(135deg, #f5f7fa, #dce3ef);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    nav.navbar .navbar-brand {
        font-size: 1.4rem;
        color: #1d3557;
        font-weight: 700;
        font-family: 'Montserrat', sans-serif;
        letter-spacing: 0.5px;
    }

    nav.navbar .navbar-brand:hover {
        color: #007bff;
        text-shadow: 0 2px 4px rgba(0, 123, 255, 0.3);
    }

    nav.navbar .dropdown-menu {
        border-radius: 10px;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        border: none;
    }

    nav.navbar a {
        color: #495057;
        font-size: 1rem;
        font-weight: 500;
        text-decoration: none;
        transition: color 0.3s ease-in-out;
    }

    nav.navbar a:hover {
        color: #007bff;
        text-decoration: none;
    }

    nav.navbar img.rounded-circle {
        border-radius: 50%;
        width: 45px;
        height: 45px;
        object-fit: cover;
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }

    nav.navbar img.rounded-circle:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    nav.navbar .dropdown a {
        font-size: 1rem;
        padding: 0.5rem 1rem;
    }

    nav.navbar .dropdown-item:hover {
        background-color: #f1f1f1;
        text-decoration: none;
        color: #007bff;
    }

    @media (max-width: 768px) {
        nav.navbar {
            padding: 0.5rem 1rem;
        }
        nav.navbar .navbar-brand {
            font-size: 1.25rem;
        }
        nav.navbar img.rounded-circle {
            width: 40px;
            height: 40px;
        }
    }
</style>

<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Kolaborasi Mitra</a>
        <div class="dropdown ms-auto">
            <a href="#" class="d-flex align-items-center text-decoration-none" data-bs-toggle="dropdown">
                <span class="me-2">{{ Auth::user()->nama ?? 'Pengguna' }}</span>
                @php
                $imagePath = 'img/profile/' . $user->profile_picture;
                $defaultImage = 'https://dummyimage.com/150x150/edf2f7/1e3a8a.png&text=Foto+Tidak+Tersedia&font-size=24&font-family=Montserrat&font-weight=bold&rounded=true';
            @endphp
                <img src="{{ $user->profile_picture && file_exists(public_path($imagePath)) ? asset($imagePath) : $defaultImage }}" alt="Foto Pengguna" class="rounded-circle">
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="{{ route('mitra.profil') }}">Profil</a></li>
                <li><a class="dropdown-item" href="{{ route('logout') }}">Keluar</a></li>
            </ul>
        </div>
    </div>
</nav>

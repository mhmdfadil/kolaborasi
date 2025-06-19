<style>
    /* Styling Footer */
    .footer {
        background: linear-gradient(180deg, #9cb8d4, #e9ecef);
        color: #495057;
        font-family: 'Montserrat', sans-serif;
        font-size: 0.9rem;
        padding: 0.70rem 0;
        box-shadow: 0 -2px 6px rgba(0, 0, 0, 0.1);
        position: relative;
    }

    .footer::before {
        content: '';
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background: #457b9d; /* Garis pemisah warna biru lembut */
        border-radius: 50px;
    }

    .footer-text {
        margin: 0;
        color: #343a40;
        font-weight: 500;
    }

    .footer a {
        color: #007bff;
        text-decoration: none;
        font-weight: 600;
    }

    .footer a:hover {
        text-decoration: none;
    }

    .footer a:active {
        text-decoration: none; /* Menghapus garis bawah saat tautan diklik */
    }

    @media (max-width: 768px) {
        .footer {
            font-size: 0.85rem;
        }
    }
</style>

<footer class="footer text-center">
    <p class="footer-text">
        Kolaborasi Mitra | <a href="https://unimal.ac.id">Teknik Informatika, Universitas Malikussaleh</a>
    </p>
</footer>

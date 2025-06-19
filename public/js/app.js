
toggleSidebarBtn.addEventListener('click', () => {
    sidebar.classList.toggle('sidebar-open');
    sidebar.classList.toggle('sidebar-close');

    if (sidebar.classList.contains('sidebar-open')) {
        toggleSidebarIcon.classList.replace('ri-arrow-left-line', 'ri-menu-line'); // Ganti icon ke menu
    } else {
        toggleSidebarIcon.classList.replace('ri-menu-line', 'ri-arrow-left-line'); // Ganti icon ke panah
    }

    // Ganti teks pada item menu utama
    const menuItems = document.querySelectorAll('.menu-item-text');
    menuItems.forEach(item => {
        item.textContent = sidebar.classList.contains('sidebar-open') ? item.textContent : '...';
    });
});


const dashboardAdminSidebar = document.getElementById('dashboardAdminSidebar');
const dashboardAdminOverlay = document.getElementById('dashboardAdminOverlay');
const dashboardAdminMenuToggle = document.getElementById('dashboardAdminMenuToggle');

function dashboardAdminSetMenu(open) {
    dashboardAdminSidebar?.classList.toggle('dashboard-admin-sidebar-open', open);
    dashboardAdminOverlay?.classList.toggle('dashboard-admin-overlay-visible', open);
    dashboardAdminMenuToggle?.setAttribute('aria-expanded', String(open));
    document.body.classList.toggle('dashboard-admin-menu-open', open);
}

dashboardAdminMenuToggle?.addEventListener('click', () => {
    const isOpen = dashboardAdminSidebar?.classList.contains('dashboard-admin-sidebar-open');
    dashboardAdminSetMenu(!isOpen);
});

dashboardAdminOverlay?.addEventListener('click', () => {
    dashboardAdminSetMenu(false);
});

document.addEventListener('keydown', event => {
    if (event.key === 'Escape') {
        dashboardAdminSetMenu(false);
    }
});

dashboardAdminSidebar?.querySelectorAll('.dashboard-admin-nav-item').forEach(link => {
    link.addEventListener('click', () => {
        dashboardAdminSetMenu(false);

        if (link.getAttribute('href') === '#ringkasan') {
            dashboardAdminSidebar.querySelectorAll('.dashboard-admin-nav-item').forEach(item => {
                item.classList.remove('dashboard-admin-nav-item-active');
            });

            link.classList.add('dashboard-admin-nav-item-active');
        }
    });
});

document.querySelectorAll('[data-dashboard-admin-logout]').forEach(form => {
    form.addEventListener('submit', event => {
        const confirmed = window.confirm('Yakin ingin keluar dari akun Lumo?');

        if (!confirmed) {
            event.preventDefault();
        }
    });
});

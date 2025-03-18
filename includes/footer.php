        </div>
    </div>
</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Common Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Toggle sidebar on mobile
    document.querySelector('.sidebar-toggler')?.addEventListener('click', function () {
        document.querySelector('#sidebar').classList.toggle('show');
    });
    
    // Theme toggler
    document.querySelector('#themeToggle')?.addEventListener('click', function () {
        if (document.body.getAttribute('data-bs-theme') === 'dark') {
            document.body.setAttribute('data-bs-theme', 'light');
            localStorage.setItem('theme', 'light');
        } else {
            document.body.setAttribute('data-bs-theme', 'dark');
            localStorage.setItem('theme', 'dark');
        }
    });
    
    // Apply theme from local storage
    const
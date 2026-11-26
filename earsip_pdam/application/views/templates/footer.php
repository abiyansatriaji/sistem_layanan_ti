    </main>
    <!-- end main-content -->

</div>
<!-- end app-wrapper -->

<!-- ============================================================
     FOOTER
     ============================================================ -->
<footer class="app-footer">
    <div class="container-fluid" style="max-width: 1400px; padding: 0 24px;">
        &copy; <?= date('Y'); ?> <strong>Perumda Air Minum Tirta Khatulistiwa</strong>. All Rights Reserved.
        <span class="ms-3 text-muted" style="font-size: 0.7rem;">E-Arsip PDAM v2.0</span>
    </div>
</footer>

<!-- ============================================================
     SCRIPTS
     ============================================================ -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Menandai link sidebar aktif saat diklik (untuk mobile)
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.querySelector('.sidebar');
        if (sidebar) {
            const navLinks = sidebar.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    navLinks.forEach(l => l.classList.remove('active'));
                    this.classList.add('active');
                });
            });
        }
    });
</script>
</body>
</html>
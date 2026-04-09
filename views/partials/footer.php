    </div>
</main>
</div>
<script>
    window.APP_CSRF_TOKEN = '<?= e(csrf_token()) ?>';
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?php if (!empty($includeCharts)): ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<?php endif; ?>
<script src="assets/js/main.js"></script>
</body>
</html>

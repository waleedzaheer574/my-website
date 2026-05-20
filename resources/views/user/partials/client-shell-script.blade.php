<script>
  (() => {
    const dashboard = document.querySelector('.tcw-client-dashboard');
    document.querySelector('.tcw-client-sidebar-toggle')?.addEventListener('click', () => dashboard?.classList.toggle('is-sidebar-open'));
    document.querySelector('.tcw-client-sidebar-overlay')?.addEventListener('click', () => dashboard?.classList.remove('is-sidebar-open'));
    document.querySelector('.tcw-client-sidebar-close')?.addEventListener('click', () => dashboard?.classList.remove('is-sidebar-open'));
  })();
</script>

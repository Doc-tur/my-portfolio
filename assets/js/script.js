document.addEventListener('DOMContentLoaded', () => {
  const links = document.querySelectorAll('.navbar .nav-link');
  const current = location.pathname.split('/').pop() || 'index.php';
  links.forEach(link => {
    const href = link.getAttribute('href');
    if (href === current) link.classList.add('active');
  });
});

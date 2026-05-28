document.addEventListener('DOMContentLoaded', () => {
  const year = document.querySelector('#year');
  if (year) year.textContent = new Date().getFullYear();

  const navbar = document.querySelector('.navbar');
  const updateNavbar = () => navbar && navbar.classList.toggle('scrolled', window.scrollY > 16);
  updateNavbar();
  window.addEventListener('scroll', updateNavbar, { passive: true });

  const revealElements = document.querySelectorAll('.section-reveal, .skill-card, .tech-card, .project-card, .contact-link-card');
  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.12 });

  revealElements.forEach((el, index) => {
    el.style.transitionDelay = `${Math.min(index % 6, 5) * 45}ms`;
    observer.observe(el);
  });

  document.querySelectorAll('.mini-calendar button').forEach((button) => {
    button.addEventListener('click', () => {
      const calendar = button.closest('.mini-calendar');
      calendar.querySelectorAll('button').forEach((item) => item.classList.remove('active'));
      button.classList.add('active');
    });
  });

  const verbData = {
    go: ['went', 'gone', 'ir'],
    be: ['was/were', 'been', 'ser/estar'],
    have: ['had', 'had', 'tener'],
    do: ['did', 'done', 'hacer'],
    see: ['saw', 'seen', 'ver']
  };

  document.querySelectorAll('.demo-webverbs .demo-action').forEach((button) => {
    button.addEventListener('click', () => {
      const card = button.closest('.demo-webverbs');
      const input = card.querySelector('input');
      const result = card.querySelector('.verb-result');
      const key = input.value.trim().toLowerCase() || 'go';
      const data = verbData[key] || ['no encontrado', 'no encontrado', 'verbo no registrado'];
      result.innerHTML = `<b>${key}</b> → ${data[0]} / ${data[1]} / ${data[2]}`;
    });
  });

  document.querySelectorAll('.hash-btn').forEach((button) => {
    button.addEventListener('click', async () => {
      const card = button.closest('.demo-hashing');
      const input = card.querySelector('input');
      const result = card.querySelector('.hash-result');
      const value = input.value || 'portafolio';

      try {
        const encoded = new TextEncoder().encode(value);
        const hashBuffer = await crypto.subtle.digest('SHA-256', encoded);
        const hashArray = Array.from(new Uint8Array(hashBuffer));
        const hashHex = hashArray.map((byte) => byte.toString(16).padStart(2, '0')).join('');
        result.textContent = `${hashHex.slice(0, 18)}...${hashHex.slice(-8)}`;
      } catch (error) {
        result.textContent = 'Demo SHA-256 no disponible en este navegador.';
      }
    });
  });
});

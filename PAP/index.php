<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Iron Haven Gym</title>
  <meta name="description" content="O ginásio mais completo e moderno. Treina, supera-te e transforma-te no melhor de ti!">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:700,400&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="style.css"/>
</head>
<body>
  <!-- Navigation -->
  <nav class="main-nav">
    <div class="nav-flex">
      <ul class="nav-links nav-left">
        <li><a href="index.php">Início</a></li>
        <li><a href="#servicos">Serviços</a></li>
        <li><a href="planos.html">Planos</a></li>
      </ul>
      <a href="index.php" class="nav-logo">
        <img src="logo2.png" alt="Iron Haven Logo">
      </a>
      <ul class="nav-links nav-right">
        <li><a href="#equipa">Equipa</a></li>
        <li><a href="marcacoes.php">Marcações</a></li>
        <li><a href="sobre.html">Sobre</a></li>
        <li><a href="contactos.html">Contactos</a></li>
        <?php if(isset($_SESSION['user'])): ?>
          <li><a href="logout.php" class="nav-btn">Logout</a></li>
        <?php else: ?>
          <li><a href="login.html" class="nav-btn">Login</a></li>
        <?php endif; ?>
      </ul>
      <button id="nav-toggle" aria-label="Abrir Menu"><i class="fa fa-bars"></i></button>
    </div>
  </nav>
  <!-- Hero Section -->
  <header class="hero-section">
    <div class="hero-overlay"></div>
    <div class="hero-content" style="position:relative; z-index:2; text-align:center; max-width:510px; margin:auto;">
      <img src="logo2.png" alt="Iron Haven Logo">
      <h1 style="font-size:2.5rem; letter-spacing:2px; font-weight:900; color:var(--accent)">O GINÁSIO QUE TE ELEVA</h1>
      <p style="font-size:1.3rem; color:var(--gray); margin-bottom:36px;">
        Estrutura premium, equipa de topo e planos para todos os objetivos.<br> Treina forte. Vive melhor. 
      </p>
      <a href="marcacoes.php" class="btn btn-primary btn-large">Marque o seu Treino Grátis</a>
    </div>
  </header>
  <!-- Facilities/Services Section -->
  <section id="servicos" class="services-section">
    <div class="container">
      <h2 class="section-title">Estrutura & Serviços</h2>
      <div class="facilities-cards">
        <div class="facility-card">
          <i class="fa-solid fa-dumbbell"></i>
          <h3>Zona de Musculação</h3>
          <p>Peso livre, máquinas modernas e acompanhamento de instrutores.</p>
        </div>
        <div class="facility-card">
          <i class="fa-solid fa-bicycle"></i>
          <h3>Aulas de Grupo</h3>
          <p>Spinning, HIIT, Pump, Yoga e muito mais em horários flexíveis.</p>
        </div>
        <div class="facility-card">
          <i class="fa-solid fa-heart-pulse"></i>
          <h3>Cardio Premium</h3>
          <p>Equipamento topo de gama, TV individual e vista panorâmica.</p>
        </div>
        <div class="facility-card">
          <i class="fa-solid fa-utensils"></i>
          <h3>Bar Nutricional</h3>
          <p>Smoothies, snacks saudáveis e suplementos à tua medida.</p>
        </div>
        <div class="facility-card">
          <i class="fa-solid fa-spa"></i>
          <h3>Wellness & Relax</h3>
          <p>Sauna, massagem, zona de alongamento e balneários premium.</p>
        </div>
      </div>
    </div>
  </section>
  <!-- Plans Preview Section -->
  <section class="services-section" style="background:#111214;">
    <div class="container">
      <h2 class="section-title">Planos para Todos</h2>
      <div class="plans-preview">
        <div class="plan-card">
          <h3>Plano Standard</h3>
          <div class="price">29€ /mês</div>
          <ul>
            <li>Musculação & Cardio ilimitado</li>
            <li>Aulas de grupo</li>
            <li>Acesso 7h-23h</li>
          </ul>
          <a href="planos.html" class="btn btn-primary">Ver Mais</a>
        </div>
        <div class="plan-card" style="border:3px solid var(--accent2);">
          <h3>Plano Gold</h3>
          <div class="price">45€ /mês</div>
          <ul>
            <li>Tudo do Standard</li>
            <li>Personal Trainer mensal</li>
            <li>Consulta Nutrição grátis</li>
            <li>Acesso 24h</li>
          </ul>
          <a href="planos.html" class="btn btn-primary">Ver Mais</a>
        </div>
        <div class="plan-card">
          <h3>Plano Free Pass</h3>
          <div class="price">10€ /semana</div>
          <ul>
            <li>Acesso livre a todos os espaços</li>
            <li>Sem fidelização</li>
            <li>Ideal para experimentar</li>
          </ul>
          <a href="planos.html" class="btn btn-primary">Ver Mais</a>
        </div>
      </div>
    </div>
  </section>
  <!-- Team Preview Section -->
  <section id="equipa" class="services-section">
    <div class="container">
      <h2 class="section-title">A Nossa Equipa</h2>
      <div class="services-cards">
        <div class="service-card">
          <img src="https://randomuser.me/api/portraits/men/34.jpg" alt="Pedro Gomes" style="width:76px; border-radius:50%; margin-bottom:14px;">
          <h3>Pedro Gomes</h3>
          <p>Personal Trainer <br> Especialista em Musculação</p>
        </div>
        <div class="service-card">
          <img src="https://randomuser.me/api/portraits/women/45.jpg" alt="Ana Silva" style="width:76px; border-radius:50%; margin-bottom:14px;">
          <h3>Ana Silva</h3>
          <p>Instrutora de Aulas de Grupo <br> HIIT & Yoga</p>
        </div>
        <div class="service-card">
          <img src="https://randomuser.me/api/portraits/men/22.jpg" alt="Carlos Nunes" style="width:76px; border-radius:50%; margin-bottom:14px;">
          <h3>Carlos Nunes</h3>
          <p>Nutricionista <br> Consultoria e Wellness</p>
        </div>
      </div>
      <div style="text-align:center; margin-top:28px;">
        <a href="equipa.html" class="btn">Ver Toda a Equipa</a>
      </div>
    </div>
  </section>
  <!-- Reviews Section -->
  <section id="testemunhos" class="testimonials-section">
    <div class="container">
      <h2 class="section-title">O que dizem os nossos membros</h2>
      <div id="reviews-container" class="reviews-list"></div>
      <button id="show-all-reviews" class="btn" style="margin:24px auto;display:none;">Ver todas as reviews</button>
      <?php if(isset($_SESSION['user'])): ?>
      <section id="adicionar-review" class="testimonials-section" style="max-width:420px; margin:36px auto;">
        <h3 style="color:var(--accent);text-align:center;margin-bottom:18px;">Deixe a sua review</h3>
        <form id="reviewForm" style="display:flex;flex-direction:column;align-items:center;gap:18px;background:var(--card-bg);padding:26px 20px;border-radius:18px;box-shadow:0 6px 24px rgba(0,0,0,0.12);">
          <div id="starRating" style="font-size:2rem;display:flex;gap:8px;cursor:pointer;"></div>
          <textarea id="reviewText" placeholder="Como foi a sua experiência?" required rows="3" style="width:100%;max-width:320px;resize:none;padding:10px;border-radius:10px;border:1px solid #FFD70022;background:rgba(255,255,255,0.07);color:var(--white);"></textarea>
          <button type="submit" class="btn btn-primary btn-large" style="width:100%;max-width:220px;">Enviar Review</button>
          <div id="reviewMsg" style="margin-top:8px;color:#FFD700;font-weight:700;display:none"></div>
        </form>
      </section>
      <?php endif; ?>
    </div>
  </section>
  <!-- Call to Action Section -->
  <section class="cta-section">
    <div class="container cta-content">
      <h2>Pronto para mudar?</h2>
      <a href="marcacoes.php" class="btn btn-primary btn-large">Agende o seu treino experimental</a>
    </div>
  </section>
  <!-- Footer -->
  <footer class="main-footer">
    <div class="container footer-flex">
      <div class="footer-brand">
        <img src="logo2.png" alt="Iron Haven Logo">
        <p>Iron Haven &copy; 2025 - Todos os direitos reservados</p>
      </div>
      <div class="footer-links">
        <a href="index.php">Início</a>
        <a href="sobre.html">Sobre</a>
        <a href="planos.html">Planos</a>
        <a href="marcacoes.php">Marcações</a>
        <a href="login.html">Login</a>
      </div>
      <div class="footer-social">
        <a href="#"><i class="fab fa-facebook-f"></i></a>
        <a href="#"><i class="fab fa-instagram"></i></a>
        <a href="#"><i class="fab fa-youtube"></i></a>
      </div>
    </div>
  </footer>
  <script>
    // Mobile navigation
    const navToggle = document.getElementById('nav-toggle');
    const navLinksLeft = document.querySelector('.nav-left');
    const navLinksRight = document.querySelector('.nav-right');
    navToggle.onclick = () => {
      navLinksLeft.classList.toggle('open');
      navLinksRight.classList.toggle('open');
    };

    // --- Reviews Section ---
    function escapeHTML(str) {
  return str.replace(/[<>&"]/g, c =>
    ({'<':'&lt;','>':'&gt;','&':'&amp;','"':'&quot;'}[c])
  );
}
let showingAllReviews = false;
let allReviewsData = [];
function renderReviews(showAll = false) {
  const container = document.getElementById('reviews-container');
  const btn = document.getElementById('show-all-reviews');
  if (!container) return;
  container.innerHTML = '';
  if (!allReviewsData || allReviewsData.length === 0) {
    container.innerHTML = `<div style="color:#FFD700;text-align:center;font-weight:600;">Ainda não há reviews. Seja o primeiro a partilhar a sua experiência!</div>`;
    btn.style.display = "none";
    return;
  }
  let reviewsToShow = showAll ? allReviewsData : allReviewsData.slice(0,3);
  reviewsToShow.forEach(r=>{
    let initial = (r.username || "U")[0].toUpperCase();
    container.innerHTML += `
      <div class="review-card">
        <div class="review-stars">
          ${'<span style="color:#FFD700">&#9733;</span>'.repeat(r.rating)}
          ${'<span style="color:#444">&#9733;</span>'.repeat(5-r.rating)}
        </div>
        <div class="review-text">“${escapeHTML(r.review)}”</div>
        <div class="review-user">
          <div class="user-avatar">${initial}</div>
          <span class="user-name">${escapeHTML(r.username)}</span>
          <span class="review-date">${new Date(r.created_at).toLocaleDateString()}</span>
        </div>
      </div>
    `;
  });
  if (allReviewsData.length > 3) {
    btn.style.display = "block";
    btn.textContent = showAll ? "Ver menos" : "Ver todas as reviews";
  } else {
    btn.style.display = "none";
  }
}
function loadReviews(showAll = false) {
  fetch('reviews.php')
    .then(r=>r.json())
    .then(data=>{
      allReviewsData = data;
      showingAllReviews = showAll;
      renderReviews(showAll);
    });
}
loadReviews();

// Handle toggle
const btn = document.getElementById('show-all-reviews');
btn.onclick = function() {
  showingAllReviews = !showingAllReviews;
  renderReviews(showingAllReviews);
};

    // Review star rating UI
    let selectedRating = 5;
    const starContainer = document.getElementById('starRating');
    if(starContainer){
      function renderStars(rating){
        starContainer.innerHTML = '';
        for(let i=1;i<=5;i++){
          starContainer.innerHTML += `<span class="star" data-star="${i}" style="color:${i<=rating?'#FFD700':'#888'};">&#9733;</span>`;
        }
      }
      renderStars(selectedRating);
      starContainer.addEventListener('mouseover', e=>{
        if(e.target.classList.contains('star')){
          renderStars(e.target.dataset.star);
        }
      });
      starContainer.addEventListener('mouseout', ()=>renderStars(selectedRating));
      starContainer.addEventListener('click', e=>{
        if(e.target.classList.contains('star')){
          selectedRating = e.target.dataset.star;
          renderStars(selectedRating);
        }
      });
    }

    // Review form submission
    const reviewForm = document.getElementById('reviewForm');
    if (reviewForm) {
      reviewForm.onsubmit = function(e) {
        e.preventDefault();
        const review = document.getElementById('reviewText').value.trim();
        const rating = selectedRating;
        const msg = document.getElementById('reviewMsg');
        msg.style.display = 'none';
        fetch('user_status.php', { credentials: 'same-origin' })
          .then(res => res.json())
          .then(user => {
            if (!user.logged_in) {
              msg.style.color = '#e04040';
              msg.textContent = 'Precisa de estar autenticado para deixar uma review!';
              msg.style.display = 'block';
              return;
            }
            fetch('adicionar_review.php', {
              method: 'POST',
              headers: {'Content-Type': 'application/json'},
              credentials: 'same-origin',
              body: JSON.stringify({review, rating})
            })
            .then(r => r.json())
            .then(data => {
              if (data.success) {
                msg.style.color = '#37c93b';
                msg.textContent = 'Review enviada!';
                msg.style.display = 'block';
                document.getElementById('reviewText').value = '';
                selectedRating = 5; if(starContainer) renderStars(selectedRating);
                loadReviews();
              } else {
                msg.style.color = '#e04040';
                msg.textContent = data.error || 'Erro ao enviar!';
                msg.style.display = 'block';
              }
            })
            .catch(()=>{
              msg.style.color = '#e04040';
              msg.textContent = "Erro no servidor!";
              msg.style.display = 'block';
            });
          });
      }
    }
  </script>
</body>
</html>
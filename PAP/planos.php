<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Planos | Iron Haven</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,900&display=swap" rel="stylesheet">
  <!-- Font Awesome for social icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
  <!-- NAVBAR -->
   <nav class="main-nav">
    <div class="nav-flex">
      <ul class="nav-links nav-left">
        <li><a href="index.php">Início</a></li>
        <li><a href="index.php#servicos">Serviços</a></li>
        <li><a href="planos.php">Planos</a></li>
      </ul>
      <a href="index.php" class="nav-logo">
        <img src="logo2.png" alt="Iron Haven Logo">
      </a>
      <ul class="nav-links nav-right">
        <li><a href="index.php#equipa">Equipa</a></li>
        <li><a href="marcacoes.php">Marcações</a></li>
        <li><a href="progresso.php">Progresso</a></li>
        <li><a href="sobre.html">Sobre</a></li>
        <li><a href="contactos.html">Contactos</a></li>
        <?php if(isset($_SESSION['user'])): ?>
          <li><a href="logout.php" class="nav-btn" id="logout-link">Logout</a></li>
        <?php else: ?>
          <li><a href="login.html" class="nav-btn">Login</a></li>
        <?php endif; ?>
      </ul>
      <button id="nav-toggle" aria-label="Abrir Menu"><i class="fa fa-bars"></i></button>
    </div>
  </nav>

  <!-- PLANS SECTION -->
  <section class="planos">
    <h1>Os Nossos Planos</h1>
    <div class="planos-container">

      <!-- Plano Standard -->
      <div class="plan-detail">
        <h3>Plano Standard</h3>
        <div class="price">29€ <span style="font-size:1rem;">/mês</span></div>
        <ul>
          <li>Acesso total musculação e cardio</li>
          <li>Aulas de grupo ilimitadas</li>
          <li>Acesso 7h - 23h</li>
          <li>Sem taxa de inscrição</li>
        </ul>
        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
          <input type="hidden" name="cmd" value="_s-xclick" />
          <input type="hidden" name="hosted_button_id" value="PYZMJETGVDBNU" />
          <input type="hidden" name="currency_code" value="EUR" />
          <button type="submit" class="btn btn-primary">Inscrever-se</button>
        </form>
      </div>

      <!-- Plano Gold -->
      <div class="plan-detail" style="border:2.5px solid var(--accent);">
        <h3>Plano Gold</h3>
        <div class="price">45€ <span style="font-size:1rem;">/mês</span></div>
        <ul>
          <li>Tudo do Standard</li>
          <li>Personal Trainer mensal</li>
          <li>Consulta Nutrição grátis</li>
          <li>Acesso 24h</li>
          <li>Prioridade em marcações</li>
        </ul>
        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
          <input type="hidden" name="cmd" value="_s-xclick" />
          <input type="hidden" name="hosted_button_id" value="B3HWV6G4ED9PC" />
          <input type="hidden" name="currency_code" value="EUR" />
          <button type="submit" class="btn btn-primary">Inscrever-se</button>
        </form>
      </div>

      <!-- Plano Free Pass -->
      <div class="plan-detail">
        <h3>Plano Free Pass</h3>
        <div class="price">10€ <span style="font-size:1rem;">/semana</span></div>
        <ul>
          <li>Acesso livre a todos os espaços</li>
          <li>Sem fidelização</li>
          <li>Ideal para experimentar</li>
        </ul>
        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
          <input type="hidden" name="cmd" value="_s-xclick" />
          <input type="hidden" name="hosted_button_id" value="2V689GV24KCRY" />
          <input type="hidden" name="currency_code" value="EUR" />
          <button type="submit" class="btn btn-primary">Inscrever-se</button>
        </form>
      </div>
    </div>
  </section>

  <!-- FOOTER -->
  <footer class="main-footer">
    <div class="container footer-flex">
      <div class="footer-brand">
        <img src="logo2.png" alt="Iron Haven Logo">
        <p>Iron Haven &copy; 2025 - Todos os direitos reservados</p>
      </div>
      <div class="footer-links">
        <a href="index.php">Início</a>
        <a href="sobre.html">Sobre</a>
        <a href="planos.php">Planos</a>
        <a href="marcacoes.php">Marcações</a>
        <a href="progresso.php">Progresso</a>
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
    const navToggle = document.getElementById('nav-toggle');
    const navLinksLeft = document.querySelector('.nav-left');
    const navLinksRight = document.querySelector('.nav-right');
    if(navToggle){
      navToggle.onclick = () => {
        navLinksLeft.classList.toggle('open');
        navLinksRight.classList.toggle('open');
      };
    }
    function setupLogoutConfirm(){
      const link = document.getElementById('logout-link');
      if(link){
        link.addEventListener('click', function(ev){
          if(!confirm('Tem a certeza que deseja terminar sessão?')) ev.preventDefault();
        });
      }
    }
    setupLogoutConfirm();
  </script>
</body>
</html>

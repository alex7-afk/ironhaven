<?php
session_start();
$basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
if ($basePath === '/' || $basePath === '\\') {
    $basePath = '';
}
?>
<!DOCTYPE html>

<html lang="pt">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Marcações | Iron Haven</title>
  <link href="https://fonts.googleapis.com/css?family=Montserrat:700,400&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="https://unpkg.com/tippy.js@6/dist/tippy.css" />
  <style>
    .login-required-msg {
      color: #e04040;
      font-weight: bold;
      text-align: center;
      margin: 20px 0;
    }
  </style>
</head>
<body class="pagina-marcacoes">
  <nav class="main-nav">
    <div class="nav-flex">
      <ul class="nav-links nav-left">
        <li><a href="index.php">Início</a></li>
        <li><a href="planos.html">Planos</a></li>
      </ul>
      <a href="index.php" class="nav-logo">
        <img src="logo2.png" alt="Iron Haven Logo">
      </a>
      <ul class="nav-links nav-right">
        <li><a href="equipa.html">Equipa</a></li>
        <li class="dropdown"><a href="marcacoes.php">Marcações</a>
          <ul class="dropdown-menu">
            <li><a href="marcacoes.php?tipo=training">Treinos</a></li>
            <li><a href="marcacoes.php?tipo=consultation">Nutrição</a></li>
            <li><a href="marcacoes.php?tipo=evaluation">Avaliações</a></li>
          </ul>
        </li>
        <li><a href="progresso.php">Progresso</a></li>
        <li><a href="blog.html">Blog</a></li>
        <li><a href="sobre.html">Sobre</a></li>
        <li><a href="contactos.html">Contactos</a></li>
        <?php if(!empty($_SESSION['user']['is_admin']) || !empty($_SESSION['is_admin'])): ?>
          <li><a href="admin_dashboard.php">Admin</a></li>
        <?php endif; ?>
        <?php if(isset($_SESSION['user'])): ?>
          <li><a href="logout.php" class="nav-btn" id="logout-link">Logout</a></li>
        <?php else: ?>
          <li><a href="login.html" class="nav-btn">Login</a></li>
        <?php endif; ?>
      </ul>
      <button id="nav-toggle" aria-label="Abrir Menu"><i class="fa fa-bars"></i></button>
    </div>
  </nav>
  <div class="main-content">
    <h2 class="section-title" style="text-align:center;">Agende a sua Sessão</h2>
    <div class="calendar-controls" style="display: flex; gap: 10px; justify-content: center; margin-bottom: 20px;">
      <button id="prevWeekBtn" class="calendar-controls-btn">Semana Anterior</button>
      <button id="nextWeekBtn" class="calendar-controls-btn">Próxima Semana</button>
    </div>
    <div id="loginMsg"></div>
    <div id="calendario"></div>
     <button id="tutorialBtn" class="calendar-controls-btn" style="margin-top:20px;">Como marcar?</button>
    <div id="tutorialSection" style="display:none; margin-top:10px; text-align:left;">
      <h3>Tutorial</h3>
      <p>Use o menu 'Marcações' no topo para escolher o tipo de marcação.</p>
      <p>De seguida, escolha um horário disponível no calendário e preencha a mensagem.</p>
      <p>Confirme para guardar a marcação. Terá uma confirmação imediata no ecrã.</p>
    </div>
  </div>
  <!-- MODAL FORM FOR BOOKING -->
  <div id="formOverlay">
    <form id="formMarcacao">
      <h3>Nova Marcação</h3>
      <label>Nome:</label>
      <input type="text" id="nome" required readonly>
      <label>Email:</label>
      <input type="email" id="email" required readonly>
      <label>Mensagem:</label>
      <textarea id="mensagem" required></textarea>
      <input type="hidden" id="appointmentType" value="training">
      <input type="hidden" id="dataHoraInicio">
      <input type="hidden" id="dataHoraFim">
      <button type="submit">Confirmar</button>
      <button type="button" class="cancelar" onclick="document.getElementById('formOverlay').style.display='none'">Cancelar</button>
    </form>
  </div>
  <footer class="main-footer">
  <div class="footer-container">
    <div class="footer-brand">
      <img src="logo2.png" alt="Iron Haven Logo" class="footer-logo">
      <p>Iron Haven &copy; 2025<br>
        <span class="footer-small">Todos os direitos reservados</span>
      </p>
    </div>
    <div class="footer-links">
      <h4>Navegação</h4>
      <ul>
        <li><a href="index.php">Início</a></li>
        <li><a href="sobre.html">Sobre</a></li>
        <li><a href="planos.html">Planos</a></li>
        <li><a href="marcacoes.php">Marcações</a></li>
        <li><a href="progresso.php">Progresso</a></li>
        <li><a href="blog.html">Blog</a></li>
        <li><a href="login.html">Login</a></li>
      </ul>
    </div>
    <div class="footer-social">
      <h4>Siga-nos</h4>
      <div class="social-icons">
        <a href="#"><i class="fab fa-facebook-f"></i></a>
        <a href="#"><i class="fab fa-instagram"></i></a>
        <a href="#"><i class="fab fa-youtube"></i></a>
      </div>
    </div>
  
  </div>
</footer>
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
  <script src="https://unpkg.com/@popperjs/core@2"></script>
  <script src="https://unpkg.com/tippy.js@6"></script>
  <script>
    const BASE_PATH = <?php echo json_encode($basePath); ?>;
  </script>
  <script>
  let calendar; 
  let currentType = 'training'; // default
  const paramType = new URLSearchParams(window.location.search).get('tipo');
  if(['training','consultation','evaluation'].includes(paramType)){
    currentType = paramType;
  }

  const typeColors = {
    'training': '#41e041',
    'consultation': '#6fd5a7',
    'evaluation': '#7ed3f6'
  };

  function checkLoginAndSetup() {
    fetch(`${BASE_PATH}/user_status.php`, { credentials: 'same-origin' })
      .then(res => res.json())
      .then(user => {
        if (!user.logged_in) {
          document.getElementById('loginMsg').innerHTML = 
            "<div class='login-required-msg'>Faça login para marcar uma sessão.<br><a href='login.html'>Login</a> | <a href='registrar.html'>Registar</a></div>";
          document.getElementById('formOverlay').style.display = 'none';
        } else {
          document.getElementById('loginMsg').innerHTML = "";
          document.getElementById('nome').value = user.username;
          document.getElementById('email').value = user.email;
        }
      });
  }

  document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('appointmentType').value = currentType;

    checkLoginAndSetup();

    const calendarEl = document.getElementById('calendario');
    calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'timeGridWeek',
      locale: 'pt',
      selectable: true,
      editable: false,
      allDaySlot: false,
      slotMinTime: "08:00:00",
      slotMaxTime: "20:00:00",
      headerToolbar: false,
      events: function(info, successCallback, failureCallback) {
        fetch('api_marcacoes.php', { credentials: 'same-origin' })
          .then(response => response.json())
          .then(data => {
            const filtered = data.filter(ev => ev.appointment_type === currentType)
              .map(ev => ({
                 title: ev.title + ' - ' +
                  (ev.appointment_type === 'training' ? 'Treino' :
                    ev.appointment_type === 'consultation' ? 'Nutrição' : 'Avaliação'),
                start: ev.start,
                end: ev.end,
                description: `<strong>${ev.title}</strong><br>${ev.mensagem}<br><i>${ev.email}</i>`,
                color: typeColors[ev.appointment_type] || '#FFD700'
              }));
            successCallback(filtered);
          })
          .catch(failureCallback);
      },
      eventClick: function(info) {
        tippy(info.el, {
          content: info.event.extendedProps.description || '',
          allowHTML: true,
          trigger: 'manual',
           theme: 'material',
          placement: 'top',
          onShow(instance) {
            setTimeout(() => instance.hide(), 3000);
          }
        }).show();
      },
      select: function(info) {
        fetch(`${BASE_PATH}/user_status.php`, { credentials: 'same-origin' }).then(res=>res.json()).then(user=>{
          if (user.logged_in) {
            document.getElementById('nome').value = user.username;
            document.getElementById('email').value = user.email;
            document.getElementById('dataHoraInicio').value = info.startStr;
            document.getElementById('dataHoraFim').value = info.endStr;
            document.getElementById('formOverlay').style.display = 'flex';
          } else {
            alert('Faça login para marcar uma sessão!');
            document.getElementById('formOverlay').style.display = 'none';
          }
        });
      }
    });
    calendar.render();

    document.getElementById('nextWeekBtn').onclick = function() {
      calendar.next();
    };
    document.getElementById('prevWeekBtn').onclick = function() {
      calendar.prev();
    };
    document.getElementById('tutorialBtn').onclick = function() {
      const section = document.getElementById('tutorialSection');
      section.style.display = section.style.display === 'none' ? 'block' : 'none';
    };
  });

  document.getElementById('formMarcacao').addEventListener('submit', function(e) {
    e.preventDefault();
    fetch(`${BASE_PATH}/user_status.php`, { credentials: "same-origin" })
      .then(res => res.json())
      .then(user => {
        if (!user.logged_in) {
          alert('Faça login para marcar uma sessão!');
          return;
        }
        const nome = user.username;
        const email = user.email;
        const mensagem = document.getElementById('mensagem').value;
        const tipo = document.getElementById('appointmentType').value;
        const start = document.getElementById('dataHoraInicio').value;
        const end = document.getElementById('dataHoraFim').value;

        fetch('api_marcacoes.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          credentials: 'same-origin',
          body: JSON.stringify({
            title: nome,
            emails: email,
            mensagem: mensagem,
            appointment_type: tipo,
            start: start,
            end: end
          })
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            calendar.refetchEvents();
            alert('Marcação guardada com sucesso!');
            document.getElementById('formOverlay').style.display = 'none';
            document.getElementById('formMarcacao').reset();
          } else {
            alert(data.error || 'Erro ao guardar marcação!');
          }
        })
        .catch(() => alert('Erro ao guardar marcação!'));
      });
  });

  
  const navToggle = document.getElementById('nav-toggle');
  const navLinksLeft = document.querySelector('.nav-left');
  const navLinksRight = document.querySelector('.nav-right');
  if(navToggle){
    navToggle.onclick = () => {
      navLinksLeft.classList.toggle('open');
      navLinksRight.classList.toggle('open');
    };
  }
const dropdown = document.querySelector('.dropdown');
  if(dropdown){
    dropdown.addEventListener('click', function(ev){
      if(window.innerWidth <= 900){
        ev.preventDefault();
        dropdown.classList.toggle('open');
      }
    });
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
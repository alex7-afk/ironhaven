<!DOCTYPE html>
<?php session_start(); ?>
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
        <li><a href="marcacoes.html">Marcações</a></li>
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
    <div class="calendar-type-controls" style="display: flex; gap: 10px; justify-content: center; margin-bottom: 20px;">
      <button class="app-type-btn active" id="btn-treinos">Treinos</button>
      <button class="app-type-btn" id="btn-consultas">Consultas</button>
      <button class="app-type-btn" id="btn-avaliacoes">Avaliações</button>
      <button onclick="toggleTheme()">Alternar Tema</button>
    </div>
    <div class="calendar-controls" style="display: flex; gap: 10px; justify-content: center; margin-bottom: 20px;">
      <button id="prevWeekBtn" class="calendar-controls-btn">Semana Anterior</button>
      <button id="nextWeekBtn" class="calendar-controls-btn">Próxima Semana</button>
    </div>
    <div id="loginMsg"></div>
    <div id="calendario"></div>
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
  let calendar;
  let isDark = false;
  let currentType = 'training'; // default

  const typeColors = {
    'training': '#41e041',
    'consultation': '#6fd5a7',
    'evaluation': '#7ed3f6'
  };

  function updateAppointmentType(type) {
    document.getElementById('appointmentType').value = type;
    currentType = type;
  }

  function highlightButton(type) {
    document.querySelectorAll('.app-type-btn').forEach(btn => btn.classList.remove('active'));
    if (type === 'training') document.getElementById('btn-treinos').classList.add('active');
    if (type === 'consultation') document.getElementById('btn-consultas').classList.add('active');
    if (type === 'evaluation') document.getElementById('btn-avaliacoes').classList.add('active');
  }

  function checkLoginAndSetup() {
    fetch('user_status.php', { credentials: 'same-origin' })
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
    document.getElementById('btn-treinos').onclick = function() {
      updateAppointmentType('training');
      highlightButton('training');
      calendar.refetchEvents();
    }
    document.getElementById('btn-consultas').onclick = function() {
      updateAppointmentType('consultation');
      highlightButton('consultation');
      calendar.refetchEvents();
    }
    document.getElementById('btn-avaliacoes').onclick = function() {
      updateAppointmentType('evaluation');
      highlightButton('evaluation');
      calendar.refetchEvents();
    }

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
                    ev.appointment_type === 'consultation' ? 'Consulta' : 'Avaliação'),
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
          theme: isDark ? 'light' : 'material',
          placement: 'top',
          onShow(instance) {
            setTimeout(() => instance.hide(), 3000);
          }
        }).show();
      },
      select: function(info) {
        fetch('user_status.php', { credentials: 'same-origin' }).then(res=>res.json()).then(user=>{
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
  });

  document.getElementById('formMarcacao').addEventListener('submit', function(e) {
    e.preventDefault();
    fetch('user_status.php', { credentials: "same-origin" })
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

  function toggleTheme() {
    document.body.classList.toggle('light-mode');
    isDark = !isDark;
  }
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

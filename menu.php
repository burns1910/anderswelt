</head>
<body>
  <div class="jumbotron bg-primary text-center text-white" style="margin-bottom:0">
    <h1>Anderswelt Planungskosmos</h1>
  </div>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark sticky-top mb-4">
      <a class="navbar-brand" href="/anderswelt/index.php">
        <img src="/anderswelt/ressources/img/logo-inv.png" style="width:40px;">
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".aw-navbar">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse w-100 order-1 order-sm-0 aw-navbar">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="/anderswelt/views/veranstaltungen.php"><i class="far fa-calendar-alt"></i> Veranstaltungen</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/anderswelt/views/users.php"><i class="fas fa-comments"></i> User</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/anderswelt/views/roles.php"><i class="fas fa-comments"></i> Rollen</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/anderswelt/views/permissions.php"><i class="fas fa-comments"></i> Berechtigungen</a>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled" href="#">Keine Berechtigung</a>
          </li>
        </ul>
      </div>
        <div class="navbar-collapse collapse w-100 order-3 aw-navbar">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" data-toggle="dropdown"><i class="fas fa-user-astronaut"></i> Einstellungen</a>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="/anderswelt/views/admin.php"><i class="fas fa-user-astronaut"></i> Admin</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="/anderswelt/logout.php"><i class="fas fa-comments"></i> Logout</a>
            </div>
          </li>
        </ul>
      </div>
    </nav>
    <div class="alert alert-success" hidden></div>
    <div class="alert alert-danger" hidden></div>
    <div class="alert alert-info" hidden></div>

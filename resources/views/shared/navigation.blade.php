<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="/">The Vinyl Shop</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsNav">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="/">Inicio</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/shop">Tienda</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/contact-us">Contacto</a>
        </li>
      </ul>
      {{--  Auth navigation  --}}
      <ul class="navbar-nav ml-auto">
        @guest
          <li class="nav-item">
            <a class="nav-link" href="/login"><i class="fas fa-sign-in-alt"></i>Inciar sesión</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/register"><i class="fas fa-signature"></i>Registrarse</a>
          </li>
        @endguest

        <li class="nav-item">
          <a class="nav-link" href="/basket">
            <i class="fas fa-shopping-basket"></i>Carrito
            <span class="badge badge-success">4</span></a>
        </li>

        @auth
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#!" data-toggle="dropdown">
            {{ auth()->user()->name }} <span class="caret"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" href="/user/profile"><i class="fas fa-user-cog"></i>Actualizar perfil</a>
              <a class="dropdown-item" href="/user/password"><i class="fas fa-key"></i>Cambiar contraseña</a>
              <a class="dropdown-item" href="/user/history"><i class="fas fa-box-open"></i>Historial de pedidos</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="/logout"><i class="fas fa-sign-out-alt"></i>Salir</a>
              @if(auth()->user()->admin)
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="/admin/genres"><i class="fas fa-microphone-alt"></i>Géneros</a>
                <a class="dropdown-item" href="/admin/records"><i class="fas fa-compact-disc"></i>Discos</a>
                <a class="dropdown-item" href="/admin/users"><i class="fas fa-users-cog"></i>Usuarios</a>
                <a class="dropdown-item" href="/admin/orders"><i class="fas fa-box-open"></i>Ordenes</a>
              @endif
            </div>
          </li>
        @endauth
      </ul>
    </div>
  </div>
</nav>
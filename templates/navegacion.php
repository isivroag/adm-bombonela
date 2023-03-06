<aside class="main-sidebar sidebar-light-primary elevation-3 ">
  <!-- Brand Logo -->

  <a href="inicio.php" class="brand-link">

    <img src="img/bombonela.png" alt="Logo" class="brand-image  " style="opacity: .8">
    <span class="brand-text font-weight-bold">BOMBONELA</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar ">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex ">
      <div class="image">
        <img src="img/user.png" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block"><?php echo $_SESSION['s_nombre']; ?></a>
        <input type="hidden" id="iduser" name="iduser" value="<?php echo  $_SESSION['s_usuario']; ?>">
        <input type="hidden" id="nameuser" name="nameuser" value="<?php echo $_SESSION['s_nombre']; ?>">
        <input type="hidden" id="tipousuario" name="tipousuario" value="<?php echo $_SESSION['s_rol']; ?>">
        <input type="hidden" id="fechasys" name="fechasys" value="<?php echo date('Y-m-d') ?>">
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar  text-white flex-column nav-compact nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->


        <li class="nav-item ">
          <a href="inicio.php" class="nav-link <?php echo ($pagina == 'home') ? "active" : ""; ?> ">
            <i class="nav-icon fas fa-home "></i>
            <p>
              Home
            </p>
          </a>
        </li>
        
        <li class="nav-item  has-treeview <?php echo ($pagina == 'corted' || $pagina == 'personal'  ) ? "menu-open" : ""; ?>">
          <a href="#" class="nav-link  <?php echo ($pagina == 'corted' || $pagina == 'personal' ) ? "active" : ""; ?>">
            <i class="nav-icon fas fa-bars "></i>
            <p>
              Reportes
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>


          <ul class="nav nav-treeview">
          <li class="nav-item">
              <a href="cntacorted.php" class="nav-link <?php echo ($pagina == 'corted') ? "active seleccionado" : ""; ?>  ">
                <i class="fas fa-user-md nav-icon"></i>
                <p>Corte del día</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="cntaprospecto.php" class="nav-link <?php echo ($pagina == 'prospectos') ? "active seleccionado" : ""; ?>  ">
                <i class="fas fa-id-card nav-icon"></i>
                <p>Ingresos</p>
              </a>
            </li>
      
          
  
          </ul>

        </li>







        <!-- ADMINISTRACION-->
       




        <?php if ($_SESSION['s_rol'] == '2') { ?>
          <hr class="sidebar-divider">
          <li class="nav-item">
            <a href="cntausuarios.php" class="nav-link <?php echo ($pagina == 'usuarios') ? "active" : ""; ?> ">
              <i class="fas fa-user-shield"></i>
              <p>Usuarios</p>
            </a>
          </li>
        <?php } ?>

        <hr class="sidebar-divider">
        <li class="nav-item">
          <a class="nav-link" href="bd/logout.php">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <p>Salir</p>
          </a>
        </li>

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
<!-- Main Sidebar Container -->
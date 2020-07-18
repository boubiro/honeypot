<nav class="navbar navbar-expand-lg bg-dark navbar-dark">
   <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
      <span class="navbar-toggler-icon"></span>
   </button>
   <a class="navbar-brand" href="../main_menu"><img src="../../image/logo.png" height="35"> Universitas Budi Luhur</a>

   <div class="collapse navbar-collapse" id="collapsibleNavbar">
      <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
         <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
            <i class="fas fa-tools"></i> Setting
            </a>
            <div class="dropdown-menu">
               <a class="dropdown-item" href="../user_setting">User Setting</a>
               <a class="dropdown-item" href="../snort_redirector_setting">Snort Redirector Setting</a>
            </div>
         </li>
         <li class="nav-item">
            <a class="nav-link" href="../redirected_ip"><i class="fas fa-lock"></i> Redirected IP</a>
         </li>
         <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
            <i class="fas fa-list-ul"></i> Log
            </a>
            <div class="dropdown-menu">
               <a class="dropdown-item" href="../redirected_ip_log">Redirected IP Log</a>
               <a class="dropdown-item" href="../event_log">Event Log</a>
            </div>
         </li>
         <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
            <i class="fas fa-clipboard-list"></i> Tools
            </a>
            <div class="dropdown-menu">
               <a class="dropdown-item" href="../base">BASE</a>
               <a class="dropdown-item" href="../hihat_analysis_tool">HIHAT</a>
               <a class="dropdown-item" href="../kippo_graph">Kippo Graph</a>
            </div>
         </li>
      </ul>
      <ul class="navbar-nav">
         <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
               <i class="fas fa-user"></i> <?php print $_SESSION["name"]; ?>
            </a>
            <div class="dropdown-menu">
               <a class="dropdown-item" href="../../module/logout.php">Logout</a>
            </div>
         </li>
      </ul
   </div>  
</nav>
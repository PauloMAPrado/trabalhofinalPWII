<!-- Abre o menu de navegação -->
<nav class="navbar bg-dark navbar-expand-lg bg-body-tertiary"
            data-bs-theme="dark">
            <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo base_url('/') ?>">
            <!--Logo do Projeto-->
            <img src="<?php echo base_url('public/assets/images/logo_bargain2.png') ?>" alt="Bargain" width="130">
        </a>
                <button class="navbar-toggler" type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse"
                    id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                        <!-- Link Home-->
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page"
                                href="#">
                                <i class="bi bi-house-fill"></i>
                                Home Admin
                            </a>
                        </li>

                        <!-- Link Home-->
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page"
                                href="<?php echo base_url('login/logout') ?>">
                                <i class="bi bi-lock-fill"></i>
                                Sair
                            </a>
                        </li>

                    </ul>

                    <div class="d-flex">
                        <span class="text-danger text-outline-danger me-2"> <i class="bi bi-person-circle"></i> <?php echo $_SESSION['usuario_logado']->usuarios_nome ?> </span>

                    </div>
                </div>
            </div>
        </nav>
        <!-- Fecha o menu de navegação -->
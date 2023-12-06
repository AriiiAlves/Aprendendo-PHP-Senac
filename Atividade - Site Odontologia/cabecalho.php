<?php include("conectadb.php") ?>
<nav>
        <ul>
            <li class="dropdown">
                <a class="dropbtn">Dentistas</a>
                <div class="dropdown-content">
                    <a href="cadastra_dentista.php">Cadastro</a>
                    <a href="lista_dentista.php">Lista</a>
                </div>
            </li>
            <li class="dropdown">
                <a class="dropbtn">Pacientes</a>
                <div class="dropdown-content">
                    <a href="cadastra_paciente.php">Cadastro</a>
                    <a href="lista_paciente.php">Lista</a>
                </div>
            </li>
            <li>
                <a href="agendamento.php">Agendamento</a>
            </li>
        </ul>
    </nav>
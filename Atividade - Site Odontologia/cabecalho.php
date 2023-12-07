<?php include("conectadb.php") ?>
<nav>
    <ul>
        <li>
            <a href="index.php">Home</a>
        </li>
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
        <li class="dropdown">
            <a class="dropbtn">Agendamento</a>
            <div class="dropdown-content" style="width: 11em;">
                <a href="agendamento.php">Agendar</a>
                <a href="lista_agendamento.php">Ver agendamentos</a>
            </div>
        </li>
    </ul>
</nav>
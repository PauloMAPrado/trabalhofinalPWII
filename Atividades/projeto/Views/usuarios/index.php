<div class="container pt-4 pb-5 bg-light">
    <h2 class="border-bottom border-2 border-primary">
         <?= $data['pagina'] ?>
    </h2>

    <?php
    
    // Mensangem de retorno
     if(isset($_SESSION['msg'])){
        echo$_SESSION['msg']['texto'];
        #echo msg($data['msg']['texto'], $data['msg']['color']); 
    } 

    ?>
    <div class="container-fluid p-3">
        <form class="d-flex" action="<?php echo base_url('usuarios/search'); ?>" role="search" method="POST">
            <input class="form-control me-2" name="pesquisar" type="search" placeholder="Pesquisar" aria-label="Search">
            <button type="submit" class="btn btn-outline-primary" type="submit"> Pesquisar</button>
        </form>
    </div>

    <table class="table">
        <!-- Cabeçalho da tabela -->
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Usuarios</th>
                <th scope="col">CPF</th>
                <th scope="col">
                    <a class="btn btn-primary" href="<?php echo base_url('usuarios/new'); ?>">
                    Novo
                    </a>
                </th>
            </tr>
        </thead>
        <!-- Corpo da tabela -->
        <tbody class="table-group-divider">
            <?php 
            foreach($data['usuarios'] as $usuarios ){?>
            <tr>
                <td><?= $usuarios->usuarios_id; ?></td>
                <td><?= $usuarios->usuarios_nome; ?></td>
                <td><?= $usuarios->usuarios_cpf; ?></td>
                <td>
                    <a class="btn btn-secondary" href="<?php echo base_url('usuarios/edit/'.$usuarios->usuarios_id); ?>">Editar</a>
                    <a class="btn btn-danger" href="<?php echo base_url('usuarios/delete/'.$usuarios->usuarios_id); ?>">Excluir</a>
                </td>
            </tr>
            <?php }?>
        </tbody>
    </table>

</div>

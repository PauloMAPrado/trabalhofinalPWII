<?php

?>

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
        <form class="d-flex" action="<?php echo base_url('cidades/search'); ?>" role="search" method="POST">
            <input class="form-control me-2" name="pesquisar" type="search" placeholder="Pesquisar" aria-label="Search">
            <button type="submit" class="btn btn-outline-success" type="submit">pesquisar</button>
        </form>
    </div>

    <table class="table">
        <!-- Cabeçalho da tabela -->
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Cidade</th>
                <th scope="col">Estado</th>
                <th scope="col">
                    <a class="btn btn-primary" href="<?php echo base_url('cidades/new'); ?>">
                    Novo
                    </a>
                </th>
            </tr>
        </thead>
        <!-- Corpo da tabela -->
        <tbody class="table-group-divider">
            <?php 
            foreach($data['cidades'] as $cidades ){?>
            <tr>
                <td><?= $cidades->cidades_id; ?></td>
                <td><?= $cidades->cidades_nome; ?></td>
                <td><?= $cidades->cidades_uf; ?></td>
                <td>
                    <a class="btn btn-secondary" href="<?php echo base_url('cidades/edit/'.$cidades->cidades_id); ?>">Editar</a>
                    <a class="btn btn-danger" href="<?php echo base_url('cidades/delete/'.$cidades->cidades_id); ?>">Excluir</a>
                </td>
            </tr>
            <?php }?>
        </tbody>
    </table>

</div>

<?php

?>

<div class="container pt-4 pb-5 bg-light">
    <h2 class="border-bottom border-2 border-primary">
         <?= $data['pagina'] ?>
    </h2>

    <?php
    
    // Mensangem de retorno
     if(isset($_SESSION['msg'])){
        echo $_SESSION['msg']['texto'];
        #echo msg($data['msg']['texto'], $data['msg']['color']); 
    } 

    ?>
    <div class="container-fluid p-3">
        <form class="d-flex" action="<?php echo base_url('categorias/search'); ?>" role="search" method="POST">
            <input class="form-control me-2" name="pesquisar" type="search" placeholder="Pesquisar" aria-label="Search">
            <button type="submit" class="btn btn-outline-success" type="submit">pesquisar</button>
        </form>
    </div>

    <table class="table">
        <!-- Cabeçalho da tabela -->
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Categoria</th>
                <th scope="col">
                    <a class="btn btn-primary" href="<?php echo base_url('categorias/new'); ?>">
                    Novo
                    </a>
                </th>
            </tr>
        </thead>
        <!-- Corpo da tabela -->
        <tbody class="table-group-divider">
            <?php 
            foreach($data['categorias'] as $categorias ){?>
            <tr>
                <td><?= $categorias->categorias_id; ?></td>
                <td><?= $categorias->categorias_nome; ?></td>
                <td>
                    <a class="btn btn-secondary" href="<?php echo base_url('categorias/edit/'.$categorias->categorias_id); ?>">Editar</a>
                    <a class="btn btn-danger" href="<?php echo base_url('categorias/delete/'.$categorias->categorias_id); ?>">Excluir</a>
                </td>
            </tr>
            <?php }?>
        </tbody>
    </table>

</div>

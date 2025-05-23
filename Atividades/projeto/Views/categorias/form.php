<div class="container pt-4 pb-5 bg-light">
    
    <h2 class="border-bottom border-2 border-primary">
        <?= ucfirst($data['pagina']) ?>
    </h2>
    <form action="<?php echo base_url('categorias/'.$data['method']); ?>" method="post">
        <div class="mb-3">
            <label for="categorias_nome" class="form-label"> Categoria </label>
            <input type="text" class="form-control" name="categorias_nome" 
            value="<?= $data['categorias']->categorias_nome; ?>"  id="categorias_nome">
        </div>


        <input type="hidden" name="categorias_id" value="<?= $data['categorias']->categorias_id; ?>" >

        <div class="mb-3">
            <input class="btn btn-success" type="submit" name="<?= $data['method']; ?>" value="Salvar">
        </div>
    
    </form>

</div>

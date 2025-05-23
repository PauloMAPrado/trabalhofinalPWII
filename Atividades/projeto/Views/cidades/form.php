<div class="container pt-4 pb-5 bg-light">
    
    <h2 class="border-bottom border-2 border-primary">
        <?= ucfirst($data['pagina']) ?>
    </h2>
    <form action="<?php echo base_url('cidades/'.$data['method']); ?>" method="post">
        <div class="mb-3">
            <label for="cidades_nome" class="form-label"> Cidade </label>
            <input type="text" class="form-control" name="cidades_nome" value="<?= $data['cidades']->cidades_nome; ?>"  id="cidades_nome">
        </div>

        <div class="mb-3">
            <label for="cidades_uf" class="form-label"> Estado </label>
            <input type="text" class="form-control"  name="cidades_uf" value="<?= $data['cidades']->cidades_uf; ?>" id="cidades_uf">
        </div>

        <input type="hidden" name="cidades_id" value="<?= $data['cidades']->cidades_id; ?>" >

        <div class="mb-3">
            <input class="btn btn-success" type="submit" name="<?= $data['method']; ?>" value="Salvar">
        </div>
    
    </form>

</div>

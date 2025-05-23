<div class="container pt-4 pb-5 bg-light">
    
    <h2 class="border-bottom border-2 border-primary">
        <?= ucfirst($data['pagina']) ?>
    </h2>
    <form action="<?php echo base_url('usuarios/'.$data['method']); ?>" method="post">
        <div class="mb-3">
            <label for="usuarios_nome" class="form-label"> Nome </label>
            <input type="text" class="form-control" name="usuarios_nome" value="<?= $data['usuarios']->usuarios_nome; ?>"  id="usuarios_nome">
        </div>

        <div class="mb-3">
            <label for="usuarios_sobrenome" class="form-label"> Sobrenome </label>
            <input type="text" class="form-control" name="usuarios_sobrenome" value="<?= $data['usuarios']->usuarios_sobrenome; ?>"  id="usuarios_sobrenome">
        </div>

        <div class="mb-3">
            <label for="usuarios_cpf" class="form-label"> CPF </label>
            <input type="text" class="form-control"  name="usuarios_cpf" value="<?= $data['usuarios']->usuarios_cpf; ?>" id="usuarios_cpf">
        </div>

        <div class="mb-3">
            <label for="usuarios_email" class="form-label"> E-mail </label>
            <input type="email" class="form-control"  name="usuarios_email" value="<?= $data['usuarios']->usuarios_email; ?>" id="usuarios_email">
        </div>

        <div class="mb-3">
            <label for="usuarios_fone" class="form-label"> Nº telefone </label>
            <input type="text" class="form-control"  name="usuarios_fone" value="<?= $data['usuarios']->usuarios_fone; ?>" id="usuarios_fone">
        </div>

        <div class="mb-3">
            <label for="usuarios_senha" class="form-label"> Senha </label>
            <input type="password" class="form-control"  name="usuarios_senha" value="<?= $data['usuarios']->usuarios_senha; ?>" id="usuarios_senha">
        </div>

        <input type="hidden" name="usuarios_id" value="<?= $data['usuarios']->usuarios_id; ?>" >

        <div class="mb-3">
            <input class="btn btn-success" type="submit" name="<?= $data['method']; ?>" value="Salvar">
        </div>
    
    </form>

</div>

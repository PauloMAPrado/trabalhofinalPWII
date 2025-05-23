<div class="container pt-4 pb-5 bg-light">
    <h2 class="border-bottom border-2 border-primary">
         Destaques
    </h2>

    <div class="row mt-4">
        <?php
        $car = ['fastback.jpeg','kwid.jpeg','porsh.jpeg','tracker.jpeg'];
        for($i=0;$i< count($car);$i++){
        ?>
        <div class="col-sm-3 mb-3 mb-sm-0">
            <div class="card">
            <img src="<?= base_url('public/assets/upload/'.$car[$i])?>" 
            class="card-img-top" alt="carro">
            <div class="card-body">
                <h5 class="card-title"><?= $car[$i] ?></h5>
                <p class="card-text">Completo</p>
                <a href="#" class="btn btn-primary">Comprar</a>
            </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
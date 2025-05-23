<!-- Cabeçalho -->
<header class="bg-dark text-white text-center py-5">
      <div class="container">
        <h1 class="display-4">Encontre seu próximo carro</h1>
        <p class="lead">Busque entre diversas opções disponíveis</p>
      </div>
    </header>

    <!-- Seção de Filtros -->
    <section class="py-5 bg-light">
      <div class="container">
        <h2 class="mb-4">Filtrar Resultados</h2>
        <form class="row g-3">
          <div class="col-md-3">
            <label for="marca" class="form-label">Marca</label>
            <select id="marca" class="form-select">
              <option selected>Escolha...</option>
              <option>Ford</option>
              <option>Chevrolet</option>
              <option>Volkswagen</option>
              <!-- Adicione mais opções conforme necessário -->
            </select>
          </div>
          <div class="col-md-3">
            <label for="modelo" class="form-label">Modelo</label>
            <select id="modelo" class="form-select">
              <option selected>Escolha...</option>
              <option>Fiesta</option>
              <option>Onix</option>
              <option>Gol</option>
              <!-- Adicione mais opções conforme necessário -->
            </select>
          </div>
          <div class="col-md-2">
            <label for="ano" class="form-label">Ano</label>
            <select id="ano" class="form-select">
              <option selected>Escolha...</option>
              <option>2025</option>
              <option>2024</option>
              <option>2023</option>
              <!-- Adicione mais opções conforme necessário -->
            </select>
          </div>
          <div class="col-md-2">
            <label for="preco" class="form-label">Preço Máximo</label>
            <select id="preco" class="form-select">
              <option selected>Escolha...</option>
              <option>R$ 50.000</option>
              <option>R$ 100.000</option>
              <option>R$ 150.000</option>
              <!-- Adicione mais opções conforme necessário -->
            </select>
          </div>
          <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">Buscar</button>
          </div>
        </form>
      </div>
    </section>

    <!-- Seção de Resultados -->
    <section class="py-5">
      <div class="container">
        <h2 class="mb-4">Resultados da Busca</h2>
        <div class="row">
            <?php
            $car = ['fastback.jpeg','kwid.jpeg','porsh.jpeg','tracker.jpeg'];
            for($i=0;$i< count($car);$i++){
            ?>

            <!-- Card de Veículo -->
            <div class="col-md-4">
              <div class="card mb-4">
                <img src="<?= base_url('public/assets/upload/'.$car[$i])?>" class="card-img-top" alt="Imagem do Veículo">
                <div class="card-body">
                  <h5 class="card-title"><?= $car[$i] ?></h5>
                  <p class="card-text">R$ 45.000</p>
                  <p class="card-text"><small class="text-muted">São Paulo - SP</small></p>
                  <a href="#" class="btn btn-primary">Ver Detalhes</a>
                </div>
              </div>
            </div>
          <!-- Repita os cards conforme necessário -->
          <?php } ?>
        </div>
      </div>
    </section>

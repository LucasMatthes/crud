<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <title>Cadastro</title>
  </head>
  <body>
        <div class="container">
            <div class="row">
                <div class="col">

                <?php 
                    if(count($_POST) > 0) {
                        $dados = $_POST;
                        $erros = [];

                        if(trim($dados['nome']) === "") {
                            $erros['nome'] = 'Nome é obrigatório';
                        }

                        if(isset($dados['nascimento'])) {
                            $data = DateTime::createFromFormat(
                                'd/m/Y', $dados['nascimento']);
                            if(!$data) {
                                $erros['nascimento'] = 'Data deve estar no padrão dd/mm/aaaa';
                            }
                        }

                        if(!filter_var($dados['email'], FILTER_VALIDATE_EMAIL)) {
                            $erros['email'] = 'Email inválido';
                        }

                        if (!filter_var($dados['site'], FILTER_VALIDATE_URL)) {
                            $erros['site'] = 'Site inválido';
                        }

                        $filhosConfig = [
                            "options" => ["min_range" => 0, "max_range" => 20]
                        ];
                        if (!filter_var($dados['filhos'], FILTER_VALIDATE_INT,
                            $filhosConfig) && $dados['filhos'] != 0) {
                            $erros['filhos'] = 'Quantidade de filhos inválida (0-20).';
                        }

                        $salarioConfig = ['options' => ['decimal' => ',']];
                        if (!filter_var($dados['salario'],
                            FILTER_VALIDATE_FLOAT, $salarioConfig)) {
                            $erros['salario'] = 'Salário inválido';
                        }

                        if(!count($erros)) {
                            require_once "conexao.php";

                            $sql = "INSERT INTO cadastro 
                            (nome, nascimento, email, site, filhos, salario)
                            VALUES (?, ?, ?, ?, ?, ?)";

                            $conexao = novaConexao();
                            $stmt = $conexao->prepare($sql);

                            $params = [
                                $dados['nome'],
                                $data ? $data->format('Y-m-d') : null,
                                $dados['email'],
                                $dados['site'],
                                $dados['filhos'],
                                $dados['salario'],
                            ];

                            $stmt->bind_param("ssssid", ...$params);

                            if($stmt->execute()) {
                                unset($dados);
                            }
                        }
                    }
                ?>

                <h1>Cadastro</h1>
                <form action="#" method="post">
                    
                    <div class="form-group"">
                        <label for="nome">Nome</label>
                        <input type="text" 
                            class="form-control <?= $erros['nome'] ? 'is-invalid' : ''?>"
                            id="nome" name="nome" placeholder="Nome">
                        <div class="invalid-feedback">
                            <?= $erros['nome'] ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nascimento">Nascimento</label>
                        <input type="text"
                            class="form-control <?= $erros['nascimento'] ? 'is-invalid' : ''?>"
                            id="nascimento" name="nascimento"
                            placeholder="Nascimento">
                        <div class="invalid-feedback">
                            <?= $erros['nascimento'] ?>
                        </div>
                    </div>
                

                
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="text"
                            class="form-control <?= $erros['email'] ? 'is-invalid' : ''?>"
                            id="email" name="email" placeholder="E-mail">
                        <div class="invalid-feedback">
                            <?= $erros['email'] ?>
                        </div>
                    </div>

                    <div class="form-group"">
                        <label for="site">Site</label>
                        <input type="text"
                            class="form-control <?= $erros['site'] ? 'is-invalid' : ''?>"
                            id="site" name="site" placeholder="Site">
                        <div class="invalid-feedback">
                            <?= $erros['site'] ?>
                        </div>
                    </div>
                

                
                    <div class="form-group">
                        <label for="filhos">Qtde de Filhos</label>
                        <input type="number" 
                            class="form-control <?= $erros['filhos'] ? 'is-invalid' : ''?>"
                            id="filhos" name="filhos"
                            placeholder="Qtde de Filhos">
                        <div class="invalid-feedback">
                            <?= $erros['filhos'] ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="salario">Salário</label>
                        <input type="text"
                            class="form-control <?= $erros['salario'] ? 'is-invalid' : ''?>"
                            id="salario" name="salario"
                            placeholder="Salário">
                        <div class="invalid-feedback">
                            <?= $erros['salario'] ?>
                        </div>
                    </div>
                    

                    <button class="btn btn-primary btn-lg">Enviar</button>
                    <a href="index.php" class="btn btn-primary btn-lg">Voltar</a>
                </form>

                </div>
            </div>
        </div>

        <!-- Optional JavaScript; choose one of the two! -->

        <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

        <!-- Option 2: jQuery, Popper.js, and Bootstrap JS
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
        -->
  </body>
</html>
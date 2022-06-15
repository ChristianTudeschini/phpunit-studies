<?php

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\Service\Avaliador;

require 'vendor/autoload.php';

$leilao = new Leilao('Fusca');

$chris = new Usuario('Chris');
$lucas = new Usuario('Lucas');

$leilao->recebeLance(new Lance($lucas, 2500));
$leilao->recebeLance(new Lance($chris, 2000));

$leiloeiro = new Avaliador();
$leiloeiro->avalia($leilao);

$maiorValor = $leiloeiro->getMaiorValor();

echo $maiorValor;
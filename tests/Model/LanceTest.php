<?php

namespace Alura\Leilao\Tests\Model;

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use PHPUnit\Framework\TestCase;

class LanceTest extends TestCase
{
  /**
   * @dataProvider geraLances
   */
  public function testLeilaoDeveReceberLances(
    int $quantidade, 
    Leilao $leilao, 
    array $valores
  ){
    static::assertCount($quantidade, $leilao->getLances());
    foreach ($valores as $i => $valorEsperado) {
      static::assertEquals($valorEsperado, $leilao->getLances()[$i]->getValor());
    }
  }

  public function geraLances()
  {
    $chris = new Usuario('Chris');
    $malu = new Usuario('Malu');
    $isaias = new Usuario('Isaias');

    $leilao1 = new Leilao('Celular');
    $leilao1->recebeLance(new Lance($chris, 600));
    $leilao1->recebeLance(new Lance($malu, 900));
    $leilao1->recebeLance(new Lance($isaias, 700));

    $leilao2 = new Leilao('Computador');
    $leilao2->recebeLance(new Lance($malu, 900));
    $leilao2->recebeLance(new Lance($chris, 600));

    return [
      [3, $leilao1, [600, 900, 700]],
      [2, $leilao2, [900, 600]],
    ];
  }
}
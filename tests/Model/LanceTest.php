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
  ) {
    $this->assertCount($quantidade, $leilao->getLances());
    foreach ($valores as $i => $valorEsperado) {
      $this->assertEquals($valorEsperado, $leilao->getLances()[$i]->getValor());
    }
  }

  public function testLeilaoNaoPodeReceberMaisDeUmLancePorUsuario()
  {
    $leilao = new Leilao('Funko Pop');
    $chris = new Usuario('Chris');

    $leilao->recebeLance(new Lance($chris, 100));
    $leilao->recebeLance(new Lance($chris, 200));

    $this->assertCount(1, $leilao->getLances());
    $this->assertEquals(100, $leilao->getLances()[0]->getValor());
  }

  public function testLeilaoNaoPodeReceberMaisDeCincoLancesPorUsuario()
  {
    $leilao = new Leilao('Playstation 5');
    $chris = new Usuario('Chris');
    $isaias = new Usuario('Isaias');

    $leilao->recebeLance(new Lance($chris, 1000));
    $leilao->recebeLance(new Lance($isaias, 1200));
    $leilao->recebeLance(new Lance($chris, 1500));
    $leilao->recebeLance(new Lance($isaias, 1700));
    $leilao->recebeLance(new Lance($chris, 2000));
    $leilao->recebeLance(new Lance($isaias, 2300));
    $leilao->recebeLance(new Lance($chris, 2500));
    $leilao->recebeLance(new Lance($isaias, 3000));
    $leilao->recebeLance(new Lance($chris, 3200));
    $leilao->recebeLance(new Lance($isaias, 5000));

    $leilao->recebeLance(new Lance($chris, 10000));

    $this->assertCount(10, $leilao->getLances());
    $this->assertEquals(5000, $leilao->getLances()[array_key_last($leilao->getLances())]->getValor());
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
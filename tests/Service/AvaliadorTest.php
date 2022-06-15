<?php

namespace Alura\Leilao\Tests\Service;

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\Service\Avaliador;
use PHPUnit\Framework\TestCase;

class AvaliadorTest extends TestCase
{
  public function testMaiorValorPorOrdemCrescente() {
    // Arrange
    $leilao = new Leilao('Fusca');

    $chris = new Usuario('Chris');
    $lucas = new Usuario('Lucas');

    $leilao->recebeLance(new Lance($chris, 2000));
    $leilao->recebeLance(new Lance($lucas, 2500));
    
    $leiloeiro = new Avaliador();
    
    // Act
    $leiloeiro->avalia($leilao);

    $maiorValor = $leiloeiro->getMaiorValor();
    
    // Assert
    $this->assertEquals(2500, $maiorValor);
  }

  public function testMaiorValorPorOrdemDecrescente() {
    // Arrange
    $leilao = new Leilao('Fusca');

    $chris = new Usuario('Chris');
    $lucas = new Usuario('Lucas');

    $leilao->recebeLance(new Lance($lucas, 2500));
    $leilao->recebeLance(new Lance($chris, 2000));
    
    $leiloeiro = new Avaliador();
    
    // Act
    $leiloeiro->avalia($leilao);

    $maiorValor = $leiloeiro->getMaiorValor();
    
    // Assert
    $this->assertEquals(2500, $maiorValor);
  }

  public function testMenorValorPorOrdemCrescente() {
    // Arrange
    $leilao = new Leilao('Fusca');

    $chris = new Usuario('Chris');
    $lucas = new Usuario('Lucas');

    $leilao->recebeLance(new Lance($chris, 2000));
    $leilao->recebeLance(new Lance($lucas, 2500));
    
    $leiloeiro = new Avaliador();
    
    // Act
    $leiloeiro->avalia($leilao);

    $menorValor = $leiloeiro->getMenorValor();
    
    // Assert
    $this->assertEquals(2000, $menorValor);
  }

  public function testMenorValorPorOrdemDecrescente() {
    // Arrange
    $leilao = new Leilao('Fusca');

    $chris = new Usuario('Chris');
    $lucas = new Usuario('Lucas');

    $leilao->recebeLance(new Lance($lucas, 2500));
    $leilao->recebeLance(new Lance($chris, 2000));
    
    $leiloeiro = new Avaliador();
    
    // Act
    $leiloeiro->avalia($leilao);

    $menorValor = $leiloeiro->getMenorValor();
    
    // Assert
    $this->assertEquals(2000, $menorValor);
  }
}
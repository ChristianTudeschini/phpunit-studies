<?php

namespace Alura\Leilao\Tests\Service;

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\Service\Avaliador;
use PHPUnit\Framework\TestCase;

class AvaliadorTest extends TestCase
{
  /** @var Avaliador */
  private $leiloeiro;

  protected function setUp(): void
  {
    $this->leiloeiro = new Avaliador();
  }

  /**
   * @dataProvider leilaoEmOrdemCrescente
   * @dataProvider leilaoEmOrdemDecrescente
   * @dataProvider leilaoEmOrdemAleatoria
   */
  public function testMaiorValor(Leilao $leilao) {
    // Act
    $this->leiloeiro->avalia($leilao);

    $maiorValor = $this->leiloeiro->getMaiorValor();
    
    // Assert
    $this->assertEquals(4500, $maiorValor);
  }

  /**
   * @dataProvider leilaoEmOrdemCrescente
   * @dataProvider leilaoEmOrdemDecrescente
   * @dataProvider leilaoEmOrdemAleatoria
   */
  public function testMenorValor(Leilao $leilao) {
    // Act
    $this->leiloeiro->avalia($leilao);

    $menorValor = $this->leiloeiro->getMenorValor();
    
    // Assert
    $this->assertEquals(2000, $menorValor);
  }

  /**
   * @dataProvider leilaoEmOrdemAleatoria
   * @dataProvider leilaoEmOrdemCrescente
   * @dataProvider leilaoEmOrdemDecrescente
   */
  public function testAvaliadorDeveBuscar3MaioresValores(Leilao $leilao)
  {
      $this->leiloeiro->avalia($leilao);

      $maiores = $this->leiloeiro->getMaioresLances();
      $this->assertCount(3, $maiores);
      $this->assertEquals(4500, $maiores[0]->getValor());
      $this->assertEquals(3000, $maiores[1]->getValor());
      $this->assertEquals(2200, $maiores[2]->getValor());
  }

  public function testLeilaoVazioNaoPodeSerAvaliado()
  {
    $this->expectException(\DomainException::class);
    $this->expectExceptionMessage('Não foi possível avaliar o leilão');
    $leilao = new Leilao('Nintendo Switch');
    $this->leiloeiro->avalia($leilao);
  }

  public function testLeilaoFinalizado()
  {
    $this->expectException(\DomainException::class);
    $this->expectExceptionMessage('Leilão já foi finalizado');

    $leilao = new Leilao('Ingresso pro show da Dua Lipa');
    $leilao->recebeLance(new Lance(new Usuario('Chris'), 1000));
    $leilao->finaliza();

    $this->leiloeiro->avalia($leilao);
  }

  public function leilaoEmOrdemCrescente()
  {
    // Arrange
    $leilao = new Leilao('Fusca');

    $chris = new Usuario('Chris');
    $beatriz = new Usuario('Beatriz');
    $isaias = new Usuario('Isaias');
    $lucas = new Usuario('Lucas');

    $leilao->recebeLance(new Lance($chris, 2000));
    $leilao->recebeLance(new Lance($beatriz, 3000));
    $leilao->recebeLance(new Lance($isaias, 2200));
    $leilao->recebeLance(new Lance($lucas, 4500));

    return [
      [$leilao]
    ];
  }

  public function leilaoEmOrdemDecrescente()
  {
    // Arrange
    $leilao = new Leilao('Fusca');

    $lucas = new Usuario('Lucas');
    $beatriz = new Usuario('Beatriz');
    $isaias = new Usuario('Isaias');
    $chris = new Usuario('Chris');

    $leilao->recebeLance(new Lance($lucas, 4500));
    $leilao->recebeLance(new Lance($beatriz, 3000));
    $leilao->recebeLance(new Lance($isaias, 2200));
    $leilao->recebeLance(new Lance($chris, 2000));

    return [
      [$leilao]
    ];
  }

  public function leilaoEmOrdemAleatoria()
  {
    // Arrange
    $leilao = new Leilao('Fusca');

    $chris = new Usuario('Chris');
    $malu = new Usuario('Malu');
    $isaias = new Usuario('Isaias');
    $leticia = new Usuario('Leticia');

    $leilao->recebeLance(new Lance($chris, 2000));
    $leilao->recebeLance(new Lance($malu, 4500));
    $leilao->recebeLance(new Lance($isaias, 2200));
    $leilao->recebeLance(new Lance($leticia, 3000));

    return [
      [$leilao]
    ];
  }
}
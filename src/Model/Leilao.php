<?php

namespace Alura\Leilao\Model;

class Leilao
{
    /** @var Lance[] */
    private $lances;
    /** @var string */
    private $descricao;
    /** @var bool */
    private $finalizado;

    public function __construct(string $descricao)
    {
        $this->descricao = $descricao;
        $this->lances = [];
        $this->finalizado = false;
    }

    public function recebeLance(Lance $lance)
    {
        if (!empty($this->lances) && $this->verificaUltimoLance($lance)) {
            throw new \DomainException('Usuário não pode propor 2 lances seguidos');
        }

        $totalLancesUsuario = $this->quantidadeLancesPorUsuario($lance->getUsuario());

        if ($totalLancesUsuario >= 5) {
            throw new \DomainException('Usuário não pode propor mais de 5 lances por leilão');
        }

        $this->lances[] = $lance;
    }

    /**
     * @return Lance[]
     */
    public function getLances(): array
    {
        return $this->lances;
    }

    /**
     * @return void
     */
    public function finaliza(): void
    {
        $this->finalizado = true;
    }

    public function foiFinalizado(): bool
    {
        return $this->finalizado;
    }

    /**
     * @param Lance $lance
     * @return bool
     */
    private function verificaUltimoLance(Lance $lance)
    {
        $ultimoLance = $this->lances[array_key_last($this->lances)];
        return $lance->getUsuario() == $ultimoLance->getUsuario();
    }

    /**
     * @param Usuario $usuario
     * @return int
     */
    private function quantidadeLancesPorUsuario(Usuario $usuario): int
    {
        return array_reduce($this->lances, function (int $totalAcumulado, Lance $lanceAtual) use ($usuario) {
            if ($lanceAtual->getUsuario() == $usuario) {
                return $totalAcumulado + 1;
            }

            return $totalAcumulado;
        }, 0);
    }
}

<?php

class Produto{
    private string $nome;
    private int $codigo;
    private string $categoria;
    private int $quantidade;
    private string $unidadeMedida;

    public function __construct(string $nome, int $codigo, string $categoria, int $quantidade, string $unidadeMedida) {
        $this->nome = $nome;
        $this->codigo = $codigo;
        $this->categoria = $categoria;
        $this->quantidade = $quantidade;
        $this->unidadeMedida = $unidadeMedida;
    }

    /**
     * @return string
     */
    public function getNome(): string {
        return $this->nome;
    }
    
    /**
     * @return int
     */
    public function getCodigo(): int {
        return $this->codigo;
    }
    
    /**
     * @return string
     */
    public function getCategoria(): string {
        return $this->categoria;
    }
    
    /**
     * @return int
     */
    public function getQuantidade(): int {
        return $this->quantidade;
    }
    
    /**
     * @return string
     */
    public function getUnidadeMedida(): string {
        return $this->unidadeMedida;
    }

    /**
     * Método estático para criar uma instância a partir de um response do banco de dados.
     * @param array $data
     * @return Produto
     */
    public static function createProduto(array $data): Produto {
        return new Produto(
            $data['nome'],
            $data['code'],
            $data['category'],
            $data['quantidade'],
            $data['unidadeMedida']
        );
    }
}



?>
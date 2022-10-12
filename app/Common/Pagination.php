<?php
namespace App\Common;

class Pagination
{
    private $itemsPerPage; // Quantidade de itens por página
    private $totalResults; // Total de dados cadastrados em banco
    private $currentPage; // Página atual
    private $totalPages; // QUantidade de páginas

    public function __construct($totalResults, $currentPage = 1, $itemsPerPage = 2)
    {
        $this->totalResults = $totalResults;
        $this->itemsPerPage = $itemsPerPage;
        $this->currentPage = $currentPage > 0 ? $currentPage : 1;
        $this->calculateTotalPage();
    }

    private function calculateTotalPage()
    {
        $this->totalPages = $this->totalResults > 0 ? ceil($this->totalResults / $this->itemsPerPage) : 1;
        $this->currentPage = $this->currentPage <= $this->totalPages ? $this->currentPage : $this->totalPages;
    }

    public function slice()
    {
        $offset = $this->itemsPerPage * ($this->currentPage - 1);
        return $offset.','.$this->itemsPerPage;
    }

    public function calculateButtons()
    {
        if($this->totalPages == 1) return [];
        $paginas = [];

        for($i = 1; $i <= $this->totalPages; $i++) {
            $paginas[] = [
                'pagina'    => $i,
                'current'   => $i == $this->currentPage
            ];
        }

        return $paginas;
    }


}
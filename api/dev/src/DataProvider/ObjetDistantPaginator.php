<?php

namespace App\DataProvider;
use ApiPlatform\Core\DataProvider\PaginatorInterface;
use App\Service\ObjetDistantHelper;
use Exception;
use Traversable;

class ObjetDistantPaginator implements PaginatorInterface, \IteratorAggregate
{
    private $iterator;
    private ObjetDistantHelper $objetHelper;
    private int $currentPage;
    private int $resultMax;
    private array $context;
    public function __construct(ObjetDistantHelper $objetHelper, int $currentPage, int $resultMax, array $context = [])
    {
        $this->objetHelper = $objetHelper;
        $this->currentPage = $currentPage;
        $this->resultMax = $resultMax;
        $this->context = $context;
        $this->getIterator();
    }

    public function getLastPage(): float
    {
        return ceil($this->getTotalItems() / $this->getItemsPerPage()) ?: 1.;
    }
    public function getTotalItems(): float
    {
        return $this->objetHelper->count($this->context);
    }
    public function getCurrentPage(): float
    {
        return $this->currentPage;
    }
    public function getItemsPerPage(): float
    {
        return $this->resultMax;
    }
    public function count(): int
    {
        return iterator_count($this->getIterator());
    }

    public function getIterator(): Traversable|array|\ArrayIterator
    {
        if ($this->iterator == null) {
            $offset = ($this->getCurrentPage() - 1) * $this->getItemsPerPage();
            $this->iterator = new \ArrayIterator($this->
            objetHelper->fetchMany($this->getItemsPerPage(), $offset, $this->context["filters"]));
        }
        return $this->iterator;
    }
}
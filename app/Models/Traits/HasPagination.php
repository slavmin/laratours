<?php


namespace App\Models\Traits;

trait HasPagination
{
    /**
     * @var int
     */
    private $pageSizeLimit = 20;

    public function getPerPage()
    {
        $pageSize = request('page_size', $this->perPage);

        return min($pageSize, $this->pageSizeLimit);
    }
}
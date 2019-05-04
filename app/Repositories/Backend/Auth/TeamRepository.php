<?php

namespace App\Repositories\Backend\Auth;

use App\Models\Auth\Team;
use App\Repositories\BaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class TeamRepository.
 */
class TeamRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Team::class;
    }


    /**
     * @return mixed
     */
    public function getDeletedCount(): int
    {
        return $this->model
            ->onlyTrashed()
            ->count();
    }

    /**
     * @param int $paged
     * @param string $orderBy
     * @param string $sort
     * @return LengthAwarePaginator
     */
    public function getActivePaginated($paged = 25, $orderBy = 'created_at', $sort = 'desc'): LengthAwarePaginator
    {
        return $this->model
            //->active()
            ->orderBy($orderBy, $sort)
            ->paginate($paged);
    }

    /**
     * @param int $paged
     * @param string $orderBy
     * @param string $sort
     * @return LengthAwarePaginator
     */
    public function getDeletedPaginated($paged = 25, $orderBy = 'created_at', $sort = 'desc'): LengthAwarePaginator
    {
        return $this->model
            ->onlyTrashed()
            ->orderBy($orderBy, $sort)
            ->paginate($paged);
    }

    /**
     * @param int $paged
     * @param string $orderBy
     * @param string $sort
     * @return LengthAwarePaginator
     */
    public function getInactivePaginated($paged = 25, $orderBy = 'created_at', $sort = 'desc'): LengthAwarePaginator
    {
        return $this->model
            ->active(false)
            ->orderBy($orderBy, $sort)
            ->paginate($paged);
    }

}
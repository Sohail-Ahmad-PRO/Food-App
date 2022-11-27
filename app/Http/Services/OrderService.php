<?php

namespace App\Http\Services;

use App\Http\Repositories\OrderRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class OrderService
{
    /**
     * @var OrderRepository $repository
     */
    private OrderRepository $repository;

    /**
     * @param OrderRepository $repository
     */
    public function __construct(OrderRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param array $payload
     * @return Builder|Model|null
     */
    public function create(array $payload): null|Builder|Model
    {
        return $this->repository->create($payload);
    }
}

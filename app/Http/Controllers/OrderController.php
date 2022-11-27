<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Http\Services\OrderService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class OrderController
{
    /**
     * @var OrderService $service
     */
    private OrderService $service;

    /**
     * @param OrderService $service
     */
    public function __construct(OrderService $service)
    {
        $this->service = $service;
    }

    /**
     * @param OrderRequest $request
     * @return Builder|Model|null
     */
    public function create(OrderRequest $request): null|Builder|Model
    {
        return $this->service->create($request->all());
    }
}

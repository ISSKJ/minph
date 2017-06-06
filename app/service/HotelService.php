<?php

use Minph\App;

class HotelService
{
    private $repository;

    public function __construct()
    {
        $this->repository = App::make('repository', 'HotelRepository');
    }

    public function getHotels(int $page = 1)
    {
        return $this->repository->getPagingHotels($page);
    }
}

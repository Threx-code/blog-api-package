<?php

namespace App\Contract;

interface BlogContract
{
    public function fetchAll();

    public function fetch($id);

    public function getBlogViews($id);

    public function getViews();
}

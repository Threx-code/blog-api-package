<?php

namespace Oluwatosin\Blog\Contracts;

interface BaseContract
{
    public function fetchall();
    public function by_id($id);
    public function create_new($data);
    public function update_item($id);
    public function delete_item($id);
}

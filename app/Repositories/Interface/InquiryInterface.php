<?php

namespace App\Repositories\Interface;

use Illuminate\Pagination\LengthAwarePaginator;

interface InquiryInterface
{
    public function all(int $perPage = 15, array $filters = []): LengthAwarePaginator;
    public function findById(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
}

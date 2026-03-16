<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseApiController extends Controller
{
    protected $repository;
    public function __construct($repository)
    {
        $this->repository = $repository;
    }
}

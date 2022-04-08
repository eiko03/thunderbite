<?php
namespace App\Repositories;
use App\Traits\ManageFlashResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

class Repository
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, ManageFlashResponse;
}

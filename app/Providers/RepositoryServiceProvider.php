<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Eloquent\AuthRepository;
use App\Repositories\Interface\AuthInterface;
use App\Repositories\Eloquent\CategoryRepository;
use App\Repositories\Interface\CategoryInterface;
use App\Repositories\Eloquent\BrandRepository;
use App\Repositories\Interface\BrandInterface;
use App\Repositories\Interface\VehicleInterface;
use App\Repositories\Eloquent\VehicleRepository;
use App\Repositories\Interface\DriverInterface;
use App\Repositories\Eloquent\DriverRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(AuthInterface::class, AuthRepository::class);
        $this->app->bind(CategoryInterface::class, CategoryRepository::class);
        $this->app->bind(BrandInterface::class, BrandRepository::class);
        $this->app->bind(VehicleInterface::class, VehicleRepository::class);
        $this->app->bind(DriverInterface::class, DriverRepository::class);
    }
}
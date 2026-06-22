<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Interface\UserInterface;
use App\Repositories\Eloquent\CategoryRepository;
use App\Repositories\Interface\CategoryInterface;
use App\Repositories\Eloquent\BrandRepository;
use App\Repositories\Interface\BrandInterface;
use App\Repositories\Interface\VehicleInterface;
use App\Repositories\Eloquent\VehicleRepository;


class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(CategoryInterface::class, CategoryRepository::class);
        $this->app->bind(BrandInterface::class, BrandRepository::class);
        $this->app->bind(VehicleInterface::class, VehicleRepository::class);
    }
}
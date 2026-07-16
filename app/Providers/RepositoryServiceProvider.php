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
use App\Repositories\Interface\BookingInterface;
use App\Repositories\Eloquent\BookingRepository;
use App\Repositories\Interface\PaymentInterface;
use App\Repositories\Eloquent\PaymentRepository;
use App\Repositories\Interface\PromotionInterface;
use App\Repositories\Eloquent\PromotionRepository;
use App\Repositories\Interface\InquiryInterface;
use App\Repositories\Eloquent\InquiryRepository;
use App\Repositories\Interface\RoleInterface;
use App\Repositories\Eloquent\RoleRepository;
use App\Repositories\Interface\DepositSettingInterface;
use App\Repositories\Eloquent\DepositSettingRepository;
use App\Repositories\Interface\DriverInterface;
use App\Repositories\Eloquent\DriverRepository;
use App\Repositories\Interface\UserInterface;
use App\Repositories\Eloquent\UserRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(AuthInterface::class, AuthRepository::class);
        $this->app->bind(CategoryInterface::class, CategoryRepository::class);
        $this->app->bind(BrandInterface::class, BrandRepository::class);
        $this->app->bind(VehicleInterface::class, VehicleRepository::class);
        $this->app->bind(DriverInterface::class, DriverRepository::class);
        $this->app->bind(BookingInterface::class, BookingRepository::class);
        $this->app->bind(PaymentInterface::class, PaymentRepository::class);
        $this->app->bind(PromotionInterface::class, PromotionRepository::class);
        $this->app->bind(InquiryInterface::class, InquiryRepository::class);
        $this->app->bind(RoleInterface::class, RoleRepository::class);
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(DepositSettingInterface::class, DepositSettingRepository::class);
    }
}
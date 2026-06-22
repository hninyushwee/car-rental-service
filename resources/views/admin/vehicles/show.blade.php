<x-admin.layout>
    @php
        $vehicles = [
            1 => ['name' => 'Toyota Land Cruiser', 'category' => 'SUV', 'brand' => 'Toyota', 'model' => 'Land Cruiser 300', 'plate' => 'SKL-101', 'price' => 129, 'status' => 'Available', 'fuel' => 'Diesel', 'transmission' => 'Automatic', 'seats' => 7, 'mileage' => '18,420 km', 'vin' => 'JTMCY7AJ8P4010101', 'location' => 'Downtown Hub'],
            2 => ['name' => 'Tesla Model S', 'category' => 'Electric', 'brand' => 'Tesla', 'model' => 'Model S Plaid', 'plate' => 'EV-204', 'price' => 189, 'status' => 'Rented', 'fuel' => 'Electric', 'transmission' => 'Automatic', 'seats' => 5, 'mileage' => '9,880 km', 'vin' => '5YJSA1E60PF020204', 'location' => 'Airport Branch'],
            3 => ['name' => 'Mercedes G-Wagon', 'category' => 'Luxury', 'brand' => 'Mercedes', 'model' => 'G 63 AMG', 'plate' => 'LUX-330', 'price' => 249, 'status' => 'Available', 'fuel' => 'Petrol', 'transmission' => 'Automatic', 'seats' => 5, 'mileage' => '12,150 km', 'vin' => 'W1NYC7HJ5PX033030', 'location' => 'Executive Garage'],
            4 => ['name' => 'Honda CR-V', 'category' => 'SUV', 'brand' => 'Honda', 'model' => 'CR-V Touring', 'plate' => 'CRV-442', 'price' => 89, 'status' => 'Maintenance', 'fuel' => 'Petrol', 'transmission' => 'Automatic', 'seats' => 5, 'mileage' => '25,710 km', 'vin' => '7FARS6H90PE044204', 'location' => 'Service Bay'],
            5 => ['name' => 'Ford F-150 Raptor', 'category' => 'Truck', 'brand' => 'Ford', 'model' => 'F-150 Raptor', 'plate' => 'TRK-550', 'price' => 159, 'status' => 'Available', 'fuel' => 'Petrol', 'transmission' => 'Automatic', 'seats' => 5, 'mileage' => '16,300 km', 'vin' => '1FTFW1RG8PFA05505', 'location' => 'North Lot'],
            6 => ['name' => 'BMW 7 Series', 'category' => 'Luxury', 'brand' => 'BMW', 'model' => '740i xDrive', 'plate' => 'BMW-706', 'price' => 199, 'status' => 'Rented', 'fuel' => 'Petrol', 'transmission' => 'Automatic', 'seats' => 5, 'mileage' => '10,620 km', 'vin' => 'WBA7T2C05PCH07006', 'location' => 'City Center'],
            7 => ['name' => 'Hyundai Tucson', 'category' => 'SUV', 'brand' => 'Hyundai', 'model' => 'Tucson Limited', 'plate' => 'TUC-707', 'price' => 79, 'status' => 'Available', 'fuel' => 'Hybrid', 'transmission' => 'Automatic', 'seats' => 5, 'mileage' => '14,905 km', 'vin' => 'KM8JEDD16PU077707', 'location' => 'West Branch'],
            8 => ['name' => 'Porsche Taycan', 'category' => 'Electric', 'brand' => 'Porsche', 'model' => 'Taycan 4S', 'plate' => 'EV-808', 'price' => 229, 'status' => 'Available', 'fuel' => 'Electric', 'transmission' => 'Automatic', 'seats' => 4, 'mileage' => '7,540 km', 'vin' => 'WP0AB2Y19PSA08808', 'location' => 'Executive Garage'],
            9 => ['name' => 'Chevrolet Suburban', 'category' => 'SUV', 'brand' => 'Chevrolet', 'model' => 'Suburban High Country', 'plate' => 'SUB-909', 'price' => 139, 'status' => 'Maintenance', 'fuel' => 'Petrol', 'transmission' => 'Automatic', 'seats' => 8, 'mileage' => '28,140 km', 'vin' => '1GNSKJKD2PR099909', 'location' => 'Service Bay'],
            10 => ['name' => 'Audi Q7', 'category' => 'SUV', 'brand' => 'Audi', 'model' => 'Q7 Premium Plus', 'plate' => 'AUD-710', 'price' => 149, 'status' => 'Available', 'fuel' => 'Petrol', 'transmission' => 'Automatic', 'seats' => 7, 'mileage' => '11,830 km', 'vin' => 'WA1LXAF74PD010710', 'location' => 'Downtown Hub'],
            11 => ['name' => 'Nissan Leaf', 'category' => 'Electric', 'brand' => 'Nissan', 'model' => 'Leaf SV Plus', 'plate' => 'EV-111', 'price' => 69, 'status' => 'Available', 'fuel' => 'Electric', 'transmission' => 'Automatic', 'seats' => 5, 'mileage' => '19,050 km', 'vin' => '1N4BZ1CV2PC011111', 'location' => 'Airport Branch'],
            12 => ['name' => 'Range Rover Velar', 'category' => 'Luxury', 'brand' => 'Land Rover', 'model' => 'Velar Dynamic', 'plate' => 'RR-812', 'price' => 219, 'status' => 'Rented', 'fuel' => 'Petrol', 'transmission' => 'Automatic', 'seats' => 5, 'mileage' => '13,770 km', 'vin' => 'SALYL2EXXPA012812', 'location' => 'Executive Garage'],
        ];

        $vehicle = $vehicles[$vehicleId] ?? $vehicles[1];
        $statusClass = match ($vehicle['status']) {
            'Available' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300',
            'Rented' => 'bg-cyan-100 text-cyan-700 dark:bg-cyan-950 dark:text-cyan-300',
            default => 'bg-amber-100 text-amber-700 dark:bg-amber-950 dark:text-amber-300',
        };
    @endphp

    <div class="p-4 sm:p-6 md:p-8">
        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <a href="{{ route('admin.vehicle.index') }}" class="mb-3 inline-flex items-center gap-2 text-sm font-semibold text-cyan-600 hover:text-cyan-700 dark:text-cyan-400">
                    <i data-lucide="arrow-left" class="h-4 w-4"></i>
                    Back to vehicles
                </a>
                <h1 class="text-3xl font-bold text-slate-900 dark:text-white">{{ $vehicle['name'] }}</h1>
                <p class="mt-1 text-slate-600 dark:text-slate-400">{{ $vehicle['brand'] }} {{ $vehicle['model'] }} vehicle profile and fleet details.</p>
            </div>

            <div class="flex flex-wrap gap-3">
                <button type="button" class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700">
                    <i data-lucide="edit-2" class="h-4 w-4"></i>
                    Edit
                </button>
                <button type="button" class="inline-flex items-center justify-center gap-2 rounded-lg bg-gradient-to-r from-cyan-500 to-blue-600 px-4 py-2.5 text-sm font-bold text-white shadow-lg transition hover:shadow-xl">
                    <i data-lucide="calendar-plus" class="h-4 w-4"></i>
                    New Booking
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
            <section class="xl:col-span-2 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-800">
                <div class="flex aspect-[16/7] items-center justify-center bg-gradient-to-br from-cyan-500 via-blue-600 to-slate-900">
                    <i data-lucide="car" class="h-24 w-24 text-white/70"></i>
                </div>
                <div class="p-6">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                        <div>
                            <h2 class="text-xl font-bold text-slate-900 dark:text-white">{{ $vehicle['brand'] }} {{ $vehicle['model'] }}</h2>
                            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ $vehicle['category'] }} fleet class</p>
                        </div>
                        <span class="inline-flex w-fit items-center gap-2 rounded-full px-3 py-1 text-xs font-bold {{ $statusClass }}">
                            <span class="h-2 w-2 rounded-full bg-current"></span>
                            {{ $vehicle['status'] }}
                        </span>
                    </div>

                    <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        <div class="rounded-xl bg-slate-50 p-4 dark:bg-slate-900">
                            <p class="text-xs font-medium text-slate-500 dark:text-slate-400">Daily Rate</p>
                            <p class="mt-2 text-2xl font-bold text-slate-900 dark:text-white">${{ $vehicle['price'] }}</p>
                        </div>
                        <div class="rounded-xl bg-slate-50 p-4 dark:bg-slate-900">
                            <p class="text-xs font-medium text-slate-500 dark:text-slate-400">Plate Number</p>
                            <p class="mt-2 text-lg font-bold text-slate-900 dark:text-white">{{ $vehicle['plate'] }}</p>
                        </div>
                        <div class="rounded-xl bg-slate-50 p-4 dark:bg-slate-900">
                            <p class="text-xs font-medium text-slate-500 dark:text-slate-400">Mileage</p>
                            <p class="mt-2 text-lg font-bold text-slate-900 dark:text-white">{{ $vehicle['mileage'] }}</p>
                        </div>
                        <div class="rounded-xl bg-slate-50 p-4 dark:bg-slate-900">
                            <p class="text-xs font-medium text-slate-500 dark:text-slate-400">Location</p>
                            <p class="mt-2 text-lg font-bold text-slate-900 dark:text-white">{{ $vehicle['location'] }}</p>
                        </div>
                    </div>
                </div>
            </section>

            <aside class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                <h2 class="text-lg font-bold text-slate-900 dark:text-white">Specifications</h2>
                <div class="mt-5 space-y-4">
                    @foreach ([
                        'Category' => $vehicle['category'],
                        'Brand' => $vehicle['brand'],
                        'Model' => $vehicle['model'],
                        'Fuel Type' => $vehicle['fuel'],
                        'Transmission' => $vehicle['transmission'],
                        'Seats' => $vehicle['seats'],
                        'VIN' => $vehicle['vin'],
                    ] as $label => $value)
                        <div class="flex items-start justify-between gap-4 border-b border-slate-100 pb-3 last:border-0 dark:border-slate-700">
                            <span class="text-sm text-slate-500 dark:text-slate-400">{{ $label }}</span>
                            <span class="text-right text-sm font-semibold text-slate-900 dark:text-white">{{ $value }}</span>
                        </div>
                    @endforeach
                </div>
            </aside>
        </div>

        <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-2">
            <section class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                <h2 class="text-lg font-bold text-slate-900 dark:text-white">Recent Activity</h2>
                <div class="mt-5 space-y-4">
                    <div class="flex gap-3">
                        <span class="mt-1 h-2.5 w-2.5 rounded-full bg-cyan-500"></span>
                        <div>
                            <p class="text-sm font-semibold text-slate-900 dark:text-white">Vehicle inspection completed</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Today at 09:30 AM</p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <span class="mt-1 h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                        <div>
                            <p class="text-sm font-semibold text-slate-900 dark:text-white">Pricing updated to ${{ $vehicle['price'] }} per day</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Yesterday at 04:12 PM</p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <span class="mt-1 h-2.5 w-2.5 rounded-full bg-amber-500"></span>
                        <div>
                            <p class="text-sm font-semibold text-slate-900 dark:text-white">Fleet record synchronized</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400">2 days ago</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                <h2 class="text-lg font-bold text-slate-900 dark:text-white">Booking Summary</h2>
                <div class="mt-5 grid grid-cols-3 gap-3">
                    <div class="rounded-xl bg-cyan-50 p-4 text-center dark:bg-cyan-950/40">
                        <p class="text-2xl font-bold text-cyan-700 dark:text-cyan-300">18</p>
                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Bookings</p>
                    </div>
                    <div class="rounded-xl bg-emerald-50 p-4 text-center dark:bg-emerald-950/40">
                        <p class="text-2xl font-bold text-emerald-700 dark:text-emerald-300">96%</p>
                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Uptime</p>
                    </div>
                    <div class="rounded-xl bg-blue-50 p-4 text-center dark:bg-blue-950/40">
                        <p class="text-2xl font-bold text-blue-700 dark:text-blue-300">4.8</p>
                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Rating</p>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-admin.layout>

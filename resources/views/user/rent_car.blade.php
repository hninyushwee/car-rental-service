<x-user.layout :hideFooter="true">

@push('styles')
<style>
  .fade-up {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.8s ease-out;
  }
  .fade-up.visible { opacity: 1; transform: translateY(0); }
  
  .car-tag {
    @apply inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold;
  }
  .badge-popular {
    @apply bg-red-100 text-red-700;
  }
  .badge-eco {
    @apply bg-emerald-100 text-emerald-700;
  }
  .badge-luxury {
    @apply bg-amber-100 text-amber-700;
  }
</style>
@endpush

<!-- Hero Section -->
<div class="pt-24 pb-8 bg-gradient-to-b from-slate-800 to-slate-700">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
    <h1 class="text-5xl md:text-6xl font-black text-white">Find Your Perfect Ride</h1>
    <p class="mt-4 text-xl text-slate-200">Premium vehicles, competitive prices, and exceptional service</p>
  </div>
</div>

<!-- Search Bar Section (transitions to white) -->
<div class="bg-white">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
    <div class="rounded-2xl bg-gradient-to-r from-cyan-50 to-blue-50 p-6 border border-cyan-200 shadow-xl">
      <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5 items-end">
        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">📍 Location</label>
          <input type="text" placeholder="Pickup location" class="w-full rounded-lg border border-slate-200 px-4 py-2.5 text-sm font-medium bg-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-400/20">
        </div>
        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">📅 From</label>
          <input type="date" class="w-full rounded-lg border border-slate-200 px-4 py-2.5 text-sm font-medium bg-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-400/20">
        </div>
        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">📅 To</label>
          <input type="date" class="w-full rounded-lg border border-slate-200 px-4 py-2.5 text-sm font-medium bg-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-400/20">
        </div>
        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">💰 Budget</label>
          <select class="w-full rounded-lg border border-slate-200 px-4 py-2.5 text-sm font-medium bg-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-400/20">
            <option>All Prices</option>
            <option>Under $50/day</option>
            <option>$50-100/day</option>
            <option>$100-150/day</option>
            <option>$150+/day</option>
          </select>
        </div>
        <button class="w-full rounded-lg bg-cyan-500 px-6 py-2.5 text-sm font-bold text-white shadow-lg hover:bg-cyan-600 transition-all active:scale-95">
          Search
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Main Content -->
<div class="bg-white pb-16">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <!-- Filters & Sort -->
    <div class="py-8 border-b border-slate-100">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex flex-wrap gap-2">
          <button class="filter-chip rounded-full border-2 border-cyan-400 bg-cyan-50 px-4 py-2 text-sm font-bold text-cyan-700 transition-all">
            All Vehicles
          </button>
          <button class="filter-chip rounded-full border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:border-cyan-400 hover:bg-cyan-50 transition-all">
            Luxury
          </button>
          <button class="filter-chip rounded-full border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:border-cyan-400 hover:bg-cyan-50 transition-all">
            SUV
          </button>
          <button class="filter-chip rounded-full border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:border-cyan-400 hover:bg-cyan-50 transition-all">
            Electric
          </button>
          <button class="filter-chip rounded-full border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:border-cyan-400 hover:bg-cyan-50 transition-all">
            Economy
          </button>
        </div>
        <div class="flex items-center gap-2">
          <span class="text-sm font-medium text-slate-600">Sort:</span>
          <select class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium focus:border-cyan-500 focus:outline-none">
            <option>Popular</option>
            <option>Price: Low to High</option>
            <option>Price: High to Low</option>
            <option>Top Rated</option>
            <option>Newest</option>
          </select>
        </div>
      </div>
    </div>

    <!-- Cars Grid -->
    <div class="py-12 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
      @php
        $cars = [
          ['id' => 1, 'name' => 'Tesla Model 3', 'type' => 'Electric', 'price' => 85, 'rating' => 4.9, 'reviews' => 324, 'img' => 'https://images.unsplash.com/photo-1606664515524-ed2f786a0bd6?auto=format&fit=crop&w=600&q=80', 'specs' => ['Auto', '5 seats', 'EV'], 'badge' => 'eco', 'popular' => true],
          ['id' => 2, 'name' => 'BMW 7 Series', 'type' => 'Luxury', 'price' => 180, 'rating' => 4.95, 'reviews' => 512, 'img' => 'https://images.unsplash.com/photo-1549399542-7e3f8b83ad38?auto=format&fit=crop&w=600&q=80', 'specs' => ['Auto', '5 seats', 'Diesel'], 'badge' => 'luxury', 'popular' => true],
          ['id' => 3, 'name' => 'Mercedes S-Class', 'type' => 'Luxury', 'price' => 200, 'rating' => 5.0, 'reviews' => 428, 'img' => 'https://images.unsplash.com/photo-1542282088-fe8426682b8f?auto=format&fit=crop&w=600&q=80', 'specs' => ['Auto', '5 seats', 'Diesel'], 'badge' => 'luxury', 'popular' => true],
          ['id' => 4, 'name' => 'Range Rover', 'type' => 'SUV', 'price' => 220, 'rating' => 4.8, 'reviews' => 367, 'img' => 'https://images.unsplash.com/photo-1606611013016-969c19d14444?auto=format&fit=crop&w=600&q=80', 'specs' => ['Auto', '7 seats', 'Hybrid'], 'badge' => null, 'popular' => false],
          ['id' => 5, 'name' => 'Honda Civic', 'type' => 'Economy', 'price' => 45, 'rating' => 4.7, 'reviews' => 189, 'img' => 'https://images.unsplash.com/photo-1568605114967-8130f3a36994?auto=format&fit=crop&w=600&q=80', 'specs' => ['Manual', '5 seats', 'Petrol'], 'badge' => null, 'popular' => false],
          ['id' => 6, 'name' => 'Porsche 911', 'type' => 'Sports', 'price' => 350, 'rating' => 4.99, 'reviews' => 287, 'img' => 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=600&q=80', 'specs' => ['Auto', '2 seats', 'Petrol'], 'badge' => null, 'popular' => false],
        ];
      @endphp

      @foreach($cars as $car)
      <div class="group rounded-2xl border border-slate-200 bg-white shadow-sm hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 overflow-hidden">
        <!-- Image -->
        <div class="relative overflow-hidden h-56 bg-slate-100">
          <img class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110" src="{{ $car['img'] }}" alt="{{ $car['name'] }}" />
          
          <!-- Badges -->
          <div class="absolute top-3 left-3 flex flex-col gap-2">
            @if($car['popular'])
            <span class="car-tag badge-popular">🔥 Popular</span>
            @endif
            @if($car['badge'] === 'luxury')
            <span class="car-tag badge-luxury">👑 Luxury</span>
            @elseif($car['badge'] === 'eco')
            <span class="car-tag badge-eco">♻️ Eco</span>
            @endif
          </div>

          <!-- Rating Badge -->
          <div class="absolute top-3 right-3 flex items-center gap-1 bg-white/95 backdrop-blur-sm rounded-full px-3 py-1 text-sm font-bold text-slate-900 shadow-md">
            <i data-lucide="star" class="h-4 w-4 fill-amber-400 text-amber-400"></i>
            {{ $car['rating'] }}
          </div>

          <!-- Overlay on Hover -->
          <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        </div>

        <!-- Content -->
        <div class="p-5">
          <!-- Header -->
          <div class="mb-2">
            <h3 class="text-lg font-bold text-slate-900">{{ $car['name'] }}</h3>
            <p class="text-xs text-slate-500 font-medium">{{ $car['type'] }} • {{ $car['reviews'] }} reviews</p>
          </div>

          <!-- Specs -->
          <div class="mb-4 flex flex-wrap gap-2">
            @foreach($car['specs'] as $spec)
            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-slate-100 text-xs font-medium text-slate-700">
              <i data-lucide="check" class="h-3 w-3 text-cyan-500"></i>
              {{ $spec }}
            </span>
            @endforeach
          </div>

          <!-- Footer -->
          <div class="flex items-center justify-between border-t border-slate-100 pt-4">
            <div>
              <p class="text-lg font-black text-slate-950">${{ $car['price'] }}</p>
              <p class="text-xs text-slate-500">per day</p>
            </div>
            <button class="book-btn rounded-lg bg-cyan-500 px-4 py-2.5 text-sm font-bold text-white shadow-md hover:bg-cyan-600 active:scale-95 transition-all"
                    data-car="{{ json_encode($car) }}">
              Book Now
            </button>
          </div>
        </div>
      </div>
      @endforeach
    </div>

    <!-- CTA Section -->
    <div class="mt-16 rounded-2xl bg-gradient-to-r from-cyan-500 to-blue-600 p-8 md:p-12 text-white text-center shadow-xl">
      <h2 class="text-3xl md:text-4xl font-black">Can't Find What You're Looking For?</h2>
      <p class="mt-2 text-cyan-100">Contact our team for custom rental solutions</p>
      <button class="mt-6 px-8 py-3 rounded-lg bg-white text-cyan-600 font-bold hover:bg-cyan-50 transition-colors shadow-lg">
        Get in Touch
      </button>
    </div>
  </div>
</div>

<!-- Booking Modal -->
<div id="bookingModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm p-4">
  <div class="w-full max-w-2xl max-h-[90vh] overflow-y-auto rounded-2xl bg-white shadow-2xl">
    <div class="sticky top-0 flex items-center justify-between border-b border-slate-100 bg-white px-6 py-4">
      <h2 class="text-2xl font-black text-slate-900">Complete Your Booking</h2>
      <button id="closeModal" class="rounded-lg p-1 hover:bg-slate-100 transition">
        <i data-lucide="x" class="h-6 w-6 text-slate-400"></i>
      </button>
    </div>
    
    <div class="p-6 space-y-4">
      <div class="flex items-center gap-4 pb-4 border-b border-slate-100">
        <img id="carImg" class="h-16 w-16 rounded-xl object-cover shadow-md" src="" alt="">
        <div>
          <h3 id="carName" class="font-bold text-slate-900"></h3>
          <p id="carPrice" class="text-sm text-cyan-600 font-semibold"></p>
        </div>
      </div>

      <div class="grid gap-4 sm:grid-cols-2">
        <div>
          <label class="block text-xs font-bold text-slate-600 uppercase mb-2">Pickup Date</label>
          <input type="date" id="pickupDate" class="w-full rounded-lg border border-slate-200 px-4 py-2.5 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-400/20">
        </div>
        <div>
          <label class="block text-xs font-bold text-slate-600 uppercase mb-2">Return Date</label>
          <input type="date" id="returnDate" class="w-full rounded-lg border border-slate-200 px-4 py-2.5 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-400/20">
        </div>
      </div>

      <div>
        <label class="block text-xs font-bold text-slate-600 uppercase mb-2">Pickup Location</label>
        <input type="text" placeholder="Enter location" class="w-full rounded-lg border border-slate-200 px-4 py-2.5 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-400/20">
      </div>

      <button id="confirmBook" class="w-full rounded-lg bg-cyan-500 py-3 text-sm font-bold text-white hover:bg-cyan-600 transition-all shadow-lg">
        Confirm Booking
      </button>
    </div>

    <!-- Pricing -->
    <div class="border-t border-slate-100 bg-slate-50 px-6 py-4">
      <div class="space-y-2 text-sm">
        <div class="flex justify-between">
          <span class="text-slate-600">Daily Rate</span>
          <span id="dailyRate" class="font-semibold">$0</span>
        </div>
        <div class="flex justify-between">
          <span class="text-slate-600">Days</span>
          <span id="days" class="font-semibold">0</span>
        </div>
        <div class="border-t border-slate-200 pt-2 flex justify-between text-base font-bold">
          <span>Total</span>
          <span id="totalPrice" class="text-cyan-600">$0</span>
        </div>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
  let selectedCar = null;

  // Fade-up animation
  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.fade-up').forEach(el => el.classList.add('visible'));
  });

  // Set default dates
  const today = new Date();
  const tomorrow = new Date(today);
  tomorrow.setDate(tomorrow.getDate() + 1);
  const nextDay = new Date(tomorrow);
  nextDay.setDate(nextDay.getDate() + 1);
  
  document.getElementById('pickupDate').value = tomorrow.toISOString().split('T')[0];
  document.getElementById('returnDate').value = nextDay.toISOString().split('T')[0];

  // Booking modal
  const modal = document.getElementById('bookingModal');
  const closeBtn = document.getElementById('closeModal');
  const bookBtns = document.querySelectorAll('.book-btn');

  bookBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      selectedCar = JSON.parse(btn.dataset.car);
      document.getElementById('carImg').src = selectedCar.img;
      document.getElementById('carName').innerText = selectedCar.name;
      document.getElementById('carPrice').innerText = `$${selectedCar.price}/day`;
      document.getElementById('dailyRate').innerText = `$${selectedCar.price}`;
      modal.classList.remove('hidden');
      modal.classList.add('flex');
      calculateTotal();
    });
  });

  closeBtn.addEventListener('click', () => {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
  });

  function calculateTotal() {
    const pickup = new Date(document.getElementById('pickupDate').value);
    const ret = new Date(document.getElementById('returnDate').value);
    const days = Math.ceil((ret - pickup) / (1000 * 60 * 60 * 24)) || 1;
    const total = selectedCar.price * days;
    
    document.getElementById('days').innerText = days;
    document.getElementById('totalPrice').innerText = `$${total}`;
  }

  document.getElementById('pickupDate').addEventListener('change', calculateTotal);
  document.getElementById('returnDate').addEventListener('change', calculateTotal);

  document.getElementById('confirmBook').addEventListener('click', () => {
    alert('🎉 Booking confirmed! Check your email for details.');
    modal.classList.add('hidden');
  });
</script>
@endpush

</x-user.layout>
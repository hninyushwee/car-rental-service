<x-user.layout :hideFooter="true">

@push('styles')
<style>
  .fade-up {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.8s cubic-bezier(0.2, 0.9, 0.4, 1.1),
                transform 0.8s cubic-bezier(0.2, 0.9, 0.4, 1.1);
  }
  .fade-up.visible {
    opacity: 1;
    transform: translateY(0);
  }
  
  .badge-verified {
    @apply inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200;
  }
  
  .rating-stars {
    @apply flex items-center gap-0.5;
  }
  
  .driver-card-premium {
    @apply border-2 border-amber-300 shadow-lg shadow-amber-100/50;
  }
</style>
@endpush

<!-- Hero Section -->
<div class="pt-24 pb-8 bg-gradient-to-b from-slate-50 to-white fade-up">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
    <h1 class="text-4xl md:text-5xl font-black text-slate-950">Premium Chauffeur Services</h1>
    <p class="mt-3 text-lg text-slate-600">Select from our verified fleet of professional drivers</p>
    <div class="mt-6 flex items-center justify-center gap-8 text-sm">
      <div class="flex items-center gap-2"><i data-lucide="check-circle" class="h-5 w-5 text-emerald-600"></i> Verified Drivers</div>
      <div class="flex items-center gap-2"><i data-lucide="shield" class="h-5 w-5 text-emerald-600"></i> Secure Booking</div>
      <div class="flex items-center gap-2"><i data-lucide="star" class="h-5 w-5 text-emerald-600"></i> Top Rated</div>
    </div>
  </div>
</div>

<div class="pb-16 bg-white">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    {{-- Advanced Filter & Sort Bar --}}
    <div class="mb-8 rounded-2xl bg-gradient-to-r from-slate-50 to-slate-100/50 p-5 border border-slate-200 shadow-sm">
      <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex flex-wrap gap-2">
          <button class="filter-chip rounded-full border-2 border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:border-cyan-400 hover:bg-cyan-50 data-filter='all' cursor-pointer" data-filter="all">
            <i data-lucide="list" class="h-4 w-4 inline mr-1"></i>All Drivers
          </button>
          <button class="filter-chip rounded-full border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 transition hover:border-cyan-400 hover:bg-cyan-50" data-filter="luxury">
            <i data-lucide="crown" class="h-4 w-4 inline mr-1"></i>Luxury
          </button>
          <button class="filter-chip rounded-full border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 transition hover:border-cyan-400 hover:bg-cyan-50" data-filter="executive">
            <i data-lucide="briefcase" class="h-4 w-4 inline mr-1"></i>Executive
          </button>
          <button class="filter-chip rounded-full border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 transition hover:border-cyan-400 hover:bg-cyan-50" data-filter="vip">
            <i data-lucide="zap" class="h-4 w-4 inline mr-1"></i>VIP
          </button>
          <button class="filter-chip rounded-full border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 transition hover:border-cyan-400 hover:bg-cyan-50" data-filter="airport">
            <i data-lucide="plane" class="h-4 w-4 inline mr-1"></i>Airport
          </button>
        </div>
        <div class="flex items-center gap-3">
          <span class="text-sm font-medium text-slate-600">Sort:</span>
          <select id="sortSelect" class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium focus:border-cyan-400 focus:outline-none focus:ring-2 focus:ring-cyan-400/20 transition">
            <option value="rating">⭐ Top Rated</option>
            <option value="price">💰 Lowest Price</option>
            <option value="exp">👨‍💼 Most Experienced</option>
            <option value="newest">✨ Newest Joins</option>
          </select>
        </div>
      </div>
    </div>

    {{-- Driver cards grid --}}
    <div id="driversGrid" class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
      @php
        $drivers = [
          ['id' => 1, 'name' => 'Michael Chen', 'type' => 'luxury', 'exp' => 8, 'rating' => 4.9, 'reviews' => 234, 'price' => 89, 'img' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=400&q=80', 'languages' => 'English, Mandarin', 'vehicle' => 'Mercedes S-Class', 'verified' => true, 'badge' => 'Premium'],
          ['id' => 2, 'name' => 'Sophia Rodriguez', 'type' => 'executive', 'exp' => 12, 'rating' => 5.0, 'reviews' => 456, 'price' => 120, 'img' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=400&q=80', 'languages' => 'English, Spanish', 'vehicle' => 'BMW 7 Series', 'verified' => true, 'badge' => 'Elite'],
          ['id' => 3, 'name' => 'David Kim', 'type' => 'airport', 'exp' => 6, 'rating' => 4.8, 'reviews' => 189, 'price' => 75, 'img' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=400&q=80', 'languages' => 'English, Korean', 'vehicle' => 'Tesla Model S', 'verified' => true, 'badge' => null],
          ['id' => 4, 'name' => 'Emma Wilson', 'type' => 'vip', 'exp' => 10, 'rating' => 4.9, 'reviews' => 312, 'price' => 150, 'img' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=400&q=80', 'languages' => 'English, French', 'vehicle' => 'Range Rover', 'verified' => true, 'badge' => 'Premium'],
          ['id' => 5, 'name' => 'James O\'Connor', 'type' => 'vip', 'exp' => 15, 'rating' => 5.0, 'reviews' => 567, 'price' => 180, 'img' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=400&q=80', 'languages' => 'English, Irish', 'vehicle' => 'Porsche Cayenne', 'verified' => true, 'badge' => 'Elite'],
          ['id' => 6, 'name' => 'Aisha Khan', 'type' => 'executive', 'exp' => 7, 'rating' => 4.7, 'reviews' => 156, 'price' => 95, 'img' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&w=400&q=80', 'languages' => 'English, Urdu', 'vehicle' => 'Audi A8', 'verified' => true, 'badge' => null],
        ];
      @endphp
      @foreach($drivers as $driver)
      <div class="driver-card group rounded-2xl border border-slate-200 bg-white shadow-sm hover:shadow-lg transition-all duration-500 hover:-translate-y-1 {{ $driver['rating'] == 5.0 ? 'driver-card-premium' : '' }}"
           data-type="{{ $driver['type'] }}"
           data-price="{{ $driver['price'] }}"
           data-rating="{{ $driver['rating'] }}"
           data-exp="{{ $driver['exp'] }}"
           data-reviews="{{ $driver['reviews'] }}">
        
        {{-- Driver Image --}}
        <div class="relative overflow-hidden rounded-t-2xl h-48">
          <img class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110" src="{{ $driver['img'] }}" alt="{{ $driver['name'] }}" />
          
          {{-- Badges --}}
          <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
          <div class="absolute left-3 top-3 flex flex-col gap-2">
            <span class="rounded-full bg-cyan-400 px-3 py-1 text-xs font-bold text-slate-950 shadow-md">{{ ucfirst($driver['type']) }}</span>
            @if($driver['badge'])
            <span class="rounded-full bg-amber-300 px-3 py-1 text-xs font-bold text-amber-900 shadow-md">🏆 {{ $driver['badge'] }}</span>
            @endif
          </div>
          
          {{-- Rating Badge --}}
          <div class="absolute right-3 top-3 flex items-center gap-1 rounded-full bg-white/95 px-3 py-1 text-xs font-bold text-slate-900 backdrop-blur-sm shadow-md">
            <i data-lucide="star" class="h-3.5 w-3.5 fill-amber-400 text-amber-400"></i>
            {{ $driver['rating'] }}
          </div>
        </div>
        
        {{-- Driver Info --}}
        <div class="p-4">
          <div class="flex items-start justify-between">
            <div class="flex-1">
              <h3 class="text-lg font-black text-slate-900">{{ $driver['name'] }}</h3>
              @if($driver['verified'])
              <span class="badge-verified mt-1">
                <i data-lucide="check" class="h-3 w-3"></i> Verified
              </span>
              @endif
            </div>
          </div>
          
          {{-- Vehicle & Experience --}}
          <div class="mt-2 space-y-1 text-sm">
            <p class="flex items-center gap-2 text-slate-700"><i data-lucide="car" class="h-4 w-4 text-cyan-500"></i> {{ $driver['vehicle'] }}</p>
            <p class="flex items-center gap-2 text-slate-600"><i data-lucide="clock" class="h-4 w-4 text-cyan-500"></i> {{ $driver['exp'] }} years experience</p>
            <p class="flex items-center gap-2 text-slate-600"><i data-lucide="message-circle" class="h-4 w-4 text-cyan-500"></i> {{ $driver['reviews'] }} reviews</p>
          </div>
          
          {{-- Languages --}}
          <div class="mt-2 flex flex-wrap gap-1">
            @foreach(explode(', ', $driver['languages']) as $lang)
            <span class="inline-block rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-700">{{ $lang }}</span>
            @endforeach
          </div>
          
          {{-- Price & CTA --}}
          <div class="mt-4 flex items-end justify-between border-t border-slate-100 pt-4">
            <div>
              <p class="text-lg font-black text-slate-950">${{ $driver['price'] }}</p>
              <p class="text-xs font-medium text-slate-500">per day</p>
            </div>
            <button class="book-driver-btn rounded-lg bg-cyan-400 px-4 py-2 text-sm font-bold text-slate-950 shadow-md transition hover:bg-cyan-300 hover:shadow-lg active:scale-95"
                    data-id="{{ $driver['id'] }}"
                    data-name="{{ $driver['name'] }}"
                    data-price="{{ $driver['price'] }}"
                    data-img="{{ $driver['img'] }}"
                    data-type="{{ $driver['type'] }}"
                    data-vehicle="{{ $driver['vehicle'] }}"
                    data-exp="{{ $driver['exp'] }}">
              Hire Now
            </button>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</div>

{{-- Premium Booking Modal --}}
<div id="bookingModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm transition-all duration-300 p-4">
  <div class="w-full max-w-2xl max-h-[90vh] overflow-y-auto rounded-2xl bg-white shadow-2xl">
    {{-- Modal Header --}}
    <div class="sticky top-0 flex items-center justify-between border-b border-slate-100 bg-white px-6 py-4">
      <h3 class="text-2xl font-black text-slate-900">Confirm Booking</h3>
      <button id="closeModalBtn" class="rounded-lg p-1 transition hover:bg-slate-100">
        <i data-lucide="x" class="h-6 w-6 text-slate-400"></i>
      </button>
    </div>
    
    {{-- Driver Summary --}}
    <div class="border-b border-slate-100 bg-slate-50/50 px-6 py-4">
      <div class="flex items-center gap-4">
        <img id="modalDriverImg" class="h-16 w-16 rounded-xl object-cover shadow-md" src="" alt="">
        <div class="flex-1">
          <div class="flex items-center gap-2">
            <h4 id="modalDriverName" class="text-lg font-bold text-slate-900"></h4>
            <i data-lucide="check-circle" class="h-4 w-4 text-emerald-600"></i>
          </div>
          <p id="modalDriverVehicle" class="text-sm text-slate-600"></p>
          <p id="modalDriverType" class="text-xs font-semibold text-cyan-600 mt-1"></p>
        </div>
      </div>
    </div>
    
    {{-- Booking Form --}}
    <form id="hireForm" class="space-y-4 px-6 py-5">
      <input type="hidden" id="driver_id" name="driver_id">
      
      {{-- Date Section --}}
      <div class="rounded-xl border border-slate-200 p-4 bg-slate-50/50">
        <h4 class="text-sm font-bold text-slate-900 mb-3 flex items-center gap-2">
          <i data-lucide="calendar" class="h-4 w-4 text-cyan-500"></i>
          Schedule
        </h4>
        <div class="grid gap-3 sm:grid-cols-2">
          <div>
            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider">Start date</label>
            <input type="date" id="hire_start_date" required class="mt-1.5 w-full rounded-lg border border-slate-200 px-4 py-2.5 text-sm font-medium focus:border-cyan-500 focus:outline-none focus:ring-4 focus:ring-cyan-400/20 transition">
          </div>
          <div>
            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider">End date</label>
            <input type="date" id="hire_end_date" required class="mt-1.5 w-full rounded-lg border border-slate-200 px-4 py-2.5 text-sm font-medium focus:border-cyan-500 focus:outline-none focus:ring-4 focus:ring-cyan-400/20 transition">
          </div>
        </div>
      </div>
      
      {{-- Location Section --}}
      <div class="rounded-xl border border-slate-200 p-4 bg-slate-50/50">
        <h4 class="text-sm font-bold text-slate-900 mb-3 flex items-center gap-2">
          <i data-lucide="map-pin" class="h-4 w-4 text-cyan-500"></i>
          Location
        </h4>
        <input type="text" placeholder="Pickup location (hotel, airport, address...)" required class="w-full rounded-lg border border-slate-200 px-4 py-2.5 text-sm font-medium placeholder:text-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-4 focus:ring-cyan-400/20 transition">
      </div>
      
      {{-- Special Requests --}}
      <div class="rounded-xl border border-slate-200 p-4 bg-slate-50/50">
        <h4 class="text-sm font-bold text-slate-900 mb-3 flex items-center gap-2">
          <i data-lucide="message-square" class="h-4 w-4 text-cyan-500"></i>
          Special Requests
        </h4>
        <textarea rows="2" placeholder="Child seat, luggage requirements, preferences..." class="w-full rounded-lg border border-slate-200 px-4 py-2.5 text-sm font-medium placeholder:text-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-4 focus:ring-cyan-400/20 transition"></textarea>
      </div>
      
      {{-- Terms & Submit --}}
      <div class="rounded-lg border border-amber-200 bg-amber-50 p-3 text-xs text-amber-800 flex items-start gap-2">
        <i data-lucide="alert-circle" class="h-4 w-4 shrink-0 mt-0.5"></i>
        <span>By confirming, you agree to our chauffeur terms and secure payment processing.</span>
      </div>
      
      <button type="submit" class="w-full rounded-lg bg-gradient-to-r from-cyan-400 to-cyan-500 py-3 text-sm font-bold text-slate-950 shadow-md transition hover:shadow-lg hover:from-cyan-500 hover:to-cyan-600 active:scale-95">
        Confirm & Pay
      </button>
    </form>
    
    {{-- Pricing Breakdown --}}
    <div class="sticky bottom-0 border-t border-slate-100 bg-slate-50/50 px-6 py-4">
      <div class="space-y-2 text-sm">
        <div class="flex justify-between">
          <span class="text-slate-600">Daily rate</span>
          <span id="modalDailyRate" class="font-semibold text-slate-900">$0</span>
        </div>
        <div class="flex justify-between">
          <span class="text-slate-600">Days</span>
          <span id="modalDays" class="font-semibold text-slate-900">0</span>
        </div>
        <div class="border-t border-slate-200 pt-2 flex justify-between text-base font-bold">
          <span>Total</span>
          <span id="modalTotalPrice" class="text-cyan-600 text-lg">$0</span>
        </div>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
  // Filter and sort
  const filterChips = document.querySelectorAll('.filter-chip');
  const sortSelect = document.getElementById('sortSelect');
  const driversGrid = document.getElementById('driversGrid');
  let currentFilter = 'all';

  function filterAndSort() {
    let cards = Array.from(document.querySelectorAll('.driver-card'));
    // Filter
    if (currentFilter !== 'all') {
      cards = cards.filter(card => card.dataset.type === currentFilter);
    }
    // Sort
    const sortBy = sortSelect.value;
    cards.sort((a, b) => {
      if (sortBy === 'rating') return parseFloat(b.dataset.rating) - parseFloat(a.dataset.rating);
      if (sortBy === 'price') return parseFloat(a.dataset.price) - parseFloat(b.dataset.price);
      if (sortBy === 'exp') return parseInt(b.dataset.exp) - parseInt(a.dataset.exp);
      if (sortBy === 'newest') return 0; // New drivers first (implementation can be extended)
      return 0;
    });
    // Reorder DOM
    cards.forEach(card => driversGrid.appendChild(card));
  }

  filterChips.forEach(chip => {
    chip.addEventListener('click', () => {
      filterChips.forEach(c => {
        c.classList.remove('bg-cyan-50', 'border-cyan-400', 'text-cyan-700');
        c.classList.remove('border-2');
        c.classList.add('border');
      });
      chip.classList.add('bg-cyan-50', 'border-cyan-400', 'text-cyan-700');
      chip.classList.remove('border');
      chip.classList.add('border-2');
      currentFilter = chip.dataset.filter;
      filterAndSort();
    });
  });
  sortSelect.addEventListener('change', filterAndSort);

  // Modal handling
  const modal = document.getElementById('bookingModal');
  const closeModalBtn = document.getElementById('closeModalBtn');
  const bookBtns = document.querySelectorAll('.book-driver-btn');

  function openModal(driver) {
    document.getElementById('modalDriverImg').src = driver.img;
    document.getElementById('modalDriverName').innerText = driver.name;
    document.getElementById('modalDriverVehicle').innerText = driver.vehicle;
    document.getElementById('modalDriverType').innerText = ucfirst(driver.type) + ' • ' + driver.exp + ' years experience';
    document.getElementById('modalDailyRate').innerText = `$${driver.price}`;
    document.getElementById('driver_id').value = driver.id;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    calculateModalTotal();
  }

  function calculateModalTotal() {
    const start = document.getElementById('hire_start_date').value;
    const end = document.getElementById('hire_end_date').value;
    const price = document.getElementById('modalDailyRate').innerText.replace('$', '');
    
    if (start && end && price) {
      const days = Math.max(1, Math.ceil((new Date(end) - new Date(start)) / (1000 * 60 * 60 * 24)));
      const total = parseFloat(price) * days;
      document.getElementById('modalDays').innerText = days + (days === 1 ? ' day' : ' days');
      document.getElementById('modalTotalPrice').innerText = `$${total.toFixed(2)}`;
    } else {
      document.getElementById('modalDays').innerText = '0 days';
      document.getElementById('modalTotalPrice').innerText = '$0';
    }
  }

  function ucfirst(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
  }

  bookBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      const driver = {
        id: btn.dataset.id,
        name: btn.dataset.name,
        price: parseInt(btn.dataset.price),
        type: btn.dataset.type,
        vehicle: btn.dataset.vehicle,
        exp: btn.dataset.exp,
        img: btn.dataset.img
      };
      openModal(driver);
    });
  });

  document.getElementById('hire_start_date').addEventListener('change', calculateModalTotal);
  document.getElementById('hire_end_date').addEventListener('change', calculateModalTotal);

  closeModalBtn.addEventListener('click', () => {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
  });
  
  modal.addEventListener('click', (e) => {
    if (e.target === modal) closeModalBtn.click();
  });

  // Set default dates (tomorrow and +2 days)
  const tomorrow = new Date();
  tomorrow.setDate(tomorrow.getDate() + 1);
  const dayAfter = new Date();
  dayAfter.setDate(dayAfter.getDate() + 2);
  document.getElementById('hire_start_date').value = tomorrow.toISOString().split('T')[0];
  document.getElementById('hire_end_date').value = dayAfter.toISOString().split('T')[0];

  // Demo submit handler
  document.getElementById('hireForm').addEventListener('submit', (e) => {
    e.preventDefault();
    const total = document.getElementById('modalTotalPrice').innerText;
    const driverName = document.getElementById('modalDriverName').innerText;
    alert(`🎉 Booking Confirmed!\n\nDriver: ${driverName}\nTotal: ${total}\n\nYou will receive a confirmation email shortly.`);
    modal.classList.add('hidden');
  });

  // Fade-up observer
  const fadeElements = document.querySelectorAll('.fade-up');
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) entry.target.classList.add('visible');
    });
  }, { threshold: 0.1 });
  fadeElements.forEach(el => observer.observe(el));
</script>
@endpush

</x-user.layout>
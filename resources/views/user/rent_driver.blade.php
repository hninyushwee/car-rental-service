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
</style>
@endpush

<div class="pt-24 pb-16 bg-white fade-up">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    {{-- Page header --}}
    <div class="mb-8 text-center">
      <h1 class="text-3xl font-black text-slate-950">Hire a professional driver</h1>
      <p class="mt-2 text-slate-500">Experience the ultimate comfort – let our expert chauffeurs drive you anywhere.</p>
    </div>

    {{-- Filter bar --}}
    <div class="mb-8 flex flex-wrap items-center justify-between gap-4 rounded-2xl bg-slate-50 p-4 shadow-sm border border-slate-200">
      <div class="flex flex-wrap gap-3">
        <button class="filter-chip rounded-full border border-slate-300 bg-white px-4 py-1.5 text-sm font-medium text-slate-700 transition hover:border-cyan-400 hover:bg-cyan-50 active:bg-cyan-50" data-filter="all">All</button>
        <button class="filter-chip rounded-full border border-slate-300 bg-white px-4 py-1.5 text-sm font-medium text-slate-700 transition hover:border-cyan-400 hover:bg-cyan-50" data-filter="luxury">Luxury</button>
        <button class="filter-chip rounded-full border border-slate-300 bg-white px-4 py-1.5 text-sm font-medium text-slate-700 transition hover:border-cyan-400 hover:bg-cyan-50" data-filter="executive">Executive</button>
        <button class="filter-chip rounded-full border border-slate-300 bg-white px-4 py-1.5 text-sm font-medium text-slate-700 transition hover:border-cyan-400 hover:bg-cyan-50" data-filter="vip">VIP</button>
        <button class="filter-chip rounded-full border border-slate-300 bg-white px-4 py-1.5 text-sm font-medium text-slate-700 transition hover:border-cyan-400 hover:bg-cyan-50" data-filter="airport">Airport Pro</button>
      </div>
      <div class="flex items-center gap-3">
        <span class="text-sm text-slate-600">Sort by:</span>
        <select id="sortSelect" class="rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-sm focus:border-cyan-400 focus:outline-none">
          <option value="rating">Rating (high to low)</option>
          <option value="price">Price (low to high)</option>
          <option value="exp">Experience (most years)</option>
        </select>
      </div>
    </div>

    {{-- Driver cards grid --}}
    <div id="driversGrid" class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
      @php
        $drivers = [
          ['id' => 1, 'name' => 'Michael Chen', 'type' => 'luxury', 'exp' => 8, 'rating' => 4.9, 'price' => 89, 'img' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=400&q=80', 'languages' => 'English, Mandarin', 'vehicle' => 'Mercedes S-Class'],
          ['id' => 2, 'name' => 'Sophia Rodriguez', 'type' => 'executive', 'exp' => 12, 'rating' => 5.0, 'price' => 120, 'img' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=400&q=80', 'languages' => 'English, Spanish', 'vehicle' => 'BMW 7 Series'],
          ['id' => 3, 'name' => 'David Kim', 'type' => 'airport', 'exp' => 6, 'rating' => 4.8, 'price' => 75, 'img' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=400&q=80', 'languages' => 'English, Korean', 'vehicle' => 'Tesla Model S'],
          ['id' => 4, 'name' => 'Emma Wilson', 'type' => 'vip', 'exp' => 10, 'rating' => 4.9, 'price' => 150, 'img' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=400&q=80', 'languages' => 'English, French', 'vehicle' => 'Range Rover'],
          ['id' => 5, 'name' => 'James O\'Connor', 'type' => 'vip', 'exp' => 15, 'rating' => 5.0, 'price' => 180, 'img' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=400&q=80', 'languages' => 'English, Irish', 'vehicle' => 'Porsche Cayenne'],
          ['id' => 6, 'name' => 'Aisha Khan', 'type' => 'executive', 'exp' => 7, 'rating' => 4.7, 'price' => 95, 'img' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&w=400&q=80', 'languages' => 'English, Urdu', 'vehicle' => 'Audi A8'],
        ];
      @endphp
      @foreach($drivers as $driver)
      <div class="driver-card group rounded-2xl border border-slate-200 bg-white shadow-sm transition-all duration-500 hover:shadow-xl hover:-translate-y-2 hover:border-cyan-300"
           data-type="{{ $driver['type'] }}"
           data-price="{{ $driver['price'] }}"
           data-rating="{{ $driver['rating'] }}"
           data-exp="{{ $driver['exp'] }}">
        <div class="relative overflow-hidden rounded-t-2xl">
          <img class="h-56 w-full object-cover transition-transform duration-700 group-hover:scale-110" src="{{ $driver['img'] }}" alt="{{ $driver['name'] }}" />
          <div class="absolute left-3 top-3 rounded-full bg-cyan-400 px-2 py-0.5 text-xs font-bold text-slate-950">{{ ucfirst($driver['type']) }}</div>
          <div class="absolute right-3 top-3 rounded-full bg-white/90 px-2 py-0.5 text-xs font-semibold text-slate-800 backdrop-blur-sm">⭐ {{ $driver['rating'] }}</div>
        </div>
        <div class="p-5">
          <h3 class="text-xl font-black text-slate-900">{{ $driver['name'] }}</h3>
          <p class="text-sm text-cyan-600">{{ $driver['vehicle'] }} · {{ $driver['exp'] }} years exp.</p>
          <div class="mt-2 flex flex-wrap gap-2 text-xs text-slate-500">
            <span class="flex items-center gap-1"><i data-lucide="languages" class="h-3 w-3"></i> {{ $driver['languages'] }}</span>
          </div>
          <div class="mt-4 flex items-center justify-between">
            <div>
              <p class="text-lg font-black text-slate-950">${{ $driver['price'] }}<span class="text-sm font-medium text-slate-500">/day</span></p>
            </div>
            <button class="book-driver-btn rounded-xl bg-cyan-400 px-4 py-2 text-sm font-bold text-slate-950 transition hover:bg-cyan-300 hover:scale-105"
                    data-id="{{ $driver['id'] }}"
                    data-name="{{ $driver['name'] }}"
                    data-price="{{ $driver['price'] }}"
                    data-img="{{ $driver['img'] }}"
                    data-type="{{ $driver['type'] }}">
              Hire Now
            </button>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</div>

{{-- Booking Modal (hidden by default) --}}
<div id="bookingModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm transition-all duration-300">
  <div class="w-full max-w-lg rounded-2xl bg-white p-6 shadow-2xl">
    <div class="flex items-center justify-between">
      <h3 class="text-xl font-bold text-slate-900">Hire Driver</h3>
      <button id="closeModalBtn" class="text-slate-400 hover:text-slate-600">
        <i data-lucide="x" class="h-5 w-5"></i>
      </button>
    </div>
    <div class="mt-4 flex gap-4 border-b border-slate-100 pb-4">
      <img id="modalDriverImg" class="h-16 w-16 rounded-full object-cover" src="" alt="">
      <div>
        <h4 id="modalDriverName" class="font-bold text-slate-900"></h4>
        <p id="modalDriverType" class="text-sm text-cyan-600"></p>
        <p id="modalDriverPrice" class="text-sm font-semibold text-slate-700"></p>
      </div>
    </div>
    <form id="hireForm" class="mt-4 space-y-4">
      <input type="hidden" id="driver_id" name="driver_id">
      <div class="grid gap-4 sm:grid-cols-2">
        <div>
          <label class="block text-sm font-medium text-slate-700">Start date</label>
          <input type="date" id="hire_start_date" required class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:border-cyan-400 focus:outline-none focus:ring-1 focus:ring-cyan-400">
        </div>
        <div>
          <label class="block text-sm font-medium text-slate-700">End date</label>
          <input type="date" id="hire_end_date" required class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:border-cyan-400 focus:outline-none focus:ring-1 focus:ring-cyan-400">
        </div>
        <div class="sm:col-span-2">
          <label class="block text-sm font-medium text-slate-700">Pickup location</label>
          <input type="text" placeholder="City or airport" required class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:border-cyan-400 focus:outline-none focus:ring-1 focus:ring-cyan-400">
        </div>
        <div class="sm:col-span-2">
          <label class="block text-sm font-medium text-slate-700">Special requests (optional)</label>
          <textarea rows="2" placeholder="e.g., child seat, extra luggage" class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:border-cyan-400 focus:outline-none focus:ring-1 focus:ring-cyan-400"></textarea>
        </div>
      </div>
      <div class="mt-4 flex items-center justify-between border-t border-slate-100 pt-4">
        <div>
          <p class="text-xs text-slate-500">Total estimated</p>
          <p id="modalTotalPrice" class="text-2xl font-black text-cyan-600">$0</p>
        </div>
        <button type="submit" class="rounded-xl bg-cyan-400 px-6 py-2.5 text-sm font-bold text-slate-950 transition hover:bg-cyan-300 hover:scale-105">Confirm Hire</button>
      </div>
    </form>
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
      return 0;
    });
    // Reorder DOM
    cards.forEach(card => driversGrid.appendChild(card));
  }

  filterChips.forEach(chip => {
    chip.addEventListener('click', () => {
      filterChips.forEach(c => c.classList.remove('bg-cyan-50', 'border-cyan-400', 'text-cyan-700'));
      chip.classList.add('bg-cyan-50', 'border-cyan-400', 'text-cyan-700');
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
    document.getElementById('modalDriverType').innerText = driver.type.charAt(0).toUpperCase() + driver.type.slice(1);
    document.getElementById('modalDriverPrice').innerHTML = `$${driver.price}/day`;
    document.getElementById('driver_id').value = driver.id;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    calculateModalTotal();
  }

  function calculateModalTotal() {
    const start = document.getElementById('hire_start_date').value;
    const end = document.getElementById('hire_end_date').value;
    const price = parseFloat(document.querySelector('.book-driver-btn.active')?.dataset.price || 0);
    if (start && end && price) {
      const days = Math.max(1, Math.ceil((new Date(end) - new Date(start)) / (1000 * 60 * 60 * 24)));
      const total = price * days;
      document.getElementById('modalTotalPrice').innerText = `$${total}`;
    } else {
      document.getElementById('modalTotalPrice').innerText = `$0`;
    }
  }

  bookBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      // Mark active for price calculation
      document.querySelectorAll('.book-driver-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      const driver = {
        id: btn.dataset.id,
        name: btn.dataset.name,
        price: parseInt(btn.dataset.price),
        type: btn.dataset.type,
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
    alert(`Demo: Driver hired successfully! Total: ${total}. No actual charge.`);
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
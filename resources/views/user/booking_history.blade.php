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
  .status-badge {
    @apply inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold;
  }
  .status-confirmed { @apply bg-green-100 text-green-800; }
  .status-pending { @apply bg-yellow-100 text-yellow-800; }
  .status-completed { @apply bg-blue-100 text-blue-800; }
  .status-cancelled { @apply bg-red-100 text-red-800; }
</style>
@endpush

<div class="pt-24 pb-16 bg-white fade-up">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 ">
    {{-- Page header --}}
    <div class="mb-8">
      <h1 class="text-3xl font-black text-slate-950">Booking History</h1>
      <p class="mt-1 text-slate-500">View and manage all your past and upcoming reservations.</p>
    </div>

    {{-- Tabs --}}
    <div class="mb-6 border-b border-slate-200">
      <nav class="flex gap-6">
        <button class="tab-btn pb-3 text-sm font-semibold transition-all duration-200 border-b-2 border-cyan-500 text-cyan-600" data-tab="active">Active / Upcoming</button>
        <button class="tab-btn pb-3 text-sm font-semibold text-slate-600 transition-all hover:text-slate-900" data-tab="past">Past</button>
        <button class="tab-btn pb-3 text-sm font-semibold text-slate-600 transition-all hover:text-slate-900" data-tab="cancelled">Cancelled</button>
      </nav>
    </div>

    {{-- Search bar --}}
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
      <div class="relative max-w-sm flex-1">
        <i data-lucide="search" class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"></i>
        <input type="text" id="searchInput" placeholder="Search by booking ID, vehicle, or driver..." class="w-full rounded-xl border border-slate-200 py-2 pl-9 pr-4 text-sm focus:border-cyan-400 focus:outline-none focus:ring-1 focus:ring-cyan-400">
      </div>
      <div class="flex gap-3">
        <select id="typeFilter" class="rounded-xl border border-slate-200 px-3 py-2 text-sm focus:border-cyan-400 focus:outline-none">
          <option value="all">All types</option>
          <option>Car Rental</option>
          <option>Driver Hire</option>
          <option>License Service</option>
          <option>Marketplace Purchase</option>
        </select>
      </div>
    </div>

    {{-- Bookings Table --}}
    <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-white shadow-sm">
      <table class="min-w-full divide-y divide-slate-200">
        <thead class="bg-slate-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Booking ID</th>
            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Type</th>
            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Details</th>
            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Dates</th>
            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Total</th>
            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Status</th>
            <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">Action</th>
          </tr>
        </thead>
        <tbody id="bookingsTableBody" class="divide-y divide-slate-200 bg-white">
          {{-- Sample data rows will be populated via JavaScript --}}
        </tbody>
      </table>
    </div>

    {{-- Pagination (demo) --}}
    <div class="mt-6 flex justify-between items-center">
      <p class="text-sm text-slate-500" id="resultsCount">Showing 0 of 0 bookings</p>
      <div class="flex gap-2">
        <button id="prevPageBtn" class="rounded-lg border border-slate-200 px-3 py-1 text-sm text-slate-600 hover:bg-slate-50 disabled:opacity-50" disabled>Previous</button>
        <span id="pageIndicator" class="px-3 py-1 text-sm text-slate-700">Page 1</span>
        <button id="nextPageBtn" class="rounded-lg border border-slate-200 px-3 py-1 text-sm text-slate-600 hover:bg-slate-50">Next</button>
      </div>
    </div>
  </div>
</div>

{{-- Booking Details Modal --}}
<div id="detailsModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm transition-all duration-300">
  <div class="w-full max-w-2xl rounded-2xl bg-white p-6 shadow-2xl">
    <div class="flex items-center justify-between">
      <h3 class="text-xl font-bold text-slate-900">Booking Details</h3>
      <button id="closeDetailsModal" class="text-slate-400 hover:text-slate-600">
        <i data-lucide="x" class="h-5 w-5"></i>
      </button>
    </div>
    <div id="modalContent" class="mt-4 space-y-3 text-sm">
      {{-- Dynamic content loaded via JS --}}
    </div>
  </div>
</div>

@push('scripts')
<script>
  // Sample booking data
  const allBookings = [
    { id: 'SKY-1001', type: 'Car Rental', item: 'Tesla Model 3', dates: 'May 10, 2025 - May 15, 2025', total: 445, status: 'confirmed', details: 'Pickup: SFO Airport, Dropoff: SFO Airport', driver: null },
    { id: 'SKY-1002', type: 'Driver Hire', item: 'Michael Chen', dates: 'May 12, 2025 - May 14, 2025', total: 178, status: 'completed', details: 'Luxury sedan, airport transfer', driver: 'Michael Chen' },
    { id: 'SKY-1003', type: 'Car Rental', item: 'BMW X5', dates: 'Jun 01, 2025 - Jun 07, 2025', total: 852, status: 'upcoming', details: 'Pickup: Downtown LA, Dropoff: LAX', driver: null },
    { id: 'SKY-1004', type: 'License Service', item: 'License Renewal', dates: 'May 20, 2025', total: 49, status: 'completed', details: 'Online service – document submitted', driver: null },
    { id: 'SKY-1005', type: 'Marketplace Purchase', item: '2021 Honda Accord', dates: 'Apr 25, 2025', total: 25900, status: 'completed', details: 'Seller: Private – payment completed', driver: null },
    { id: 'SKY-1006', type: 'Driver Hire', item: 'Sophia Rodriguez', dates: 'Jul 15, 2025 - Jul 18, 2025', total: 360, status: 'upcoming', details: 'Executive chauffeur, corporate event', driver: 'Sophia Rodriguez' },
    { id: 'SKY-1007', type: 'Car Rental', item: 'Mercedes C-Class', dates: 'Mar 01, 2025 - Mar 05, 2025', total: 472, status: 'cancelled', details: 'Cancelled by user', driver: null },
  ];

  let currentTab = 'active';
  let currentPage = 1;
  const rowsPerPage = 5;
  let filteredBookings = [];

  function getBookingsByTab() {
    if (currentTab === 'active') return allBookings.filter(b => b.status === 'confirmed' || b.status === 'upcoming');
    if (currentTab === 'past') return allBookings.filter(b => b.status === 'completed');
    if (currentTab === 'cancelled') return allBookings.filter(b => b.status === 'cancelled');
    return [];
  }

  function filterBySearchAndType() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const type = document.getElementById('typeFilter').value;
    let base = getBookingsByTab();
    if (searchTerm) {
      base = base.filter(b => b.id.toLowerCase().includes(searchTerm) || b.item.toLowerCase().includes(searchTerm));
    }
    if (type !== 'all') {
      base = base.filter(b => b.type === type);
    }
    return base;
  }

  function renderTable() {
    filteredBookings = filterBySearchAndType();
    const totalPages = Math.ceil(filteredBookings.length / rowsPerPage);
    if (currentPage > totalPages) currentPage = totalPages || 1;
    const start = (currentPage - 1) * rowsPerPage;
    const pageBookings = filteredBookings.slice(start, start + rowsPerPage);
    const tbody = document.getElementById('bookingsTableBody');
    tbody.innerHTML = '';
    pageBookings.forEach(b => {
      let statusClass = '';
      if (b.status === 'confirmed' || b.status === 'upcoming') statusClass = 'status-confirmed';
      else if (b.status === 'completed') statusClass = 'status-completed';
      else if (b.status === 'cancelled') statusClass = 'status-cancelled';
      let statusText = b.status === 'upcoming' ? 'Upcoming' : (b.status.charAt(0).toUpperCase() + b.status.slice(1));
      const row = `<tr class="hover:bg-slate-50 transition">
        <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-slate-900">${b.id}</td>
        <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600">${b.type}</td>
        <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600">${b.item}</td>
        <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600">${b.dates}</td>
        <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-slate-900">$${b.total.toLocaleString()}</td>
        <td class="whitespace-nowrap px-6 py-4"><span class="status-badge ${statusClass}">${statusText}</span></td>
        <td class="whitespace-nowrap px-6 py-4 text-right">
          <button class="view-details text-cyan-600 hover:text-cyan-800 text-sm font-medium" data-booking='${JSON.stringify(b)}'>View Details</button>
        </td>
      </tr>`;
      tbody.insertAdjacentHTML('beforeend', row);
    });
    document.getElementById('resultsCount').innerText = `Showing ${pageBookings.length} of ${filteredBookings.length} bookings`;
    document.getElementById('pageIndicator').innerText = `Page ${currentPage}`;
    document.getElementById('prevPageBtn').disabled = currentPage === 1;
    document.getElementById('nextPageBtn').disabled = currentPage === totalPages || totalPages === 0;
    // attach detail listeners
    document.querySelectorAll('.view-details').forEach(btn => {
      btn.addEventListener('click', (e) => {
        const booking = JSON.parse(btn.dataset.booking);
        showModal(booking);
      });
    });
  }

  function showModal(booking) {
    const modal = document.getElementById('detailsModal');
    const modalContent = document.getElementById('modalContent');
    modalContent.innerHTML = `
      <div class="grid grid-cols-2 gap-3">
        <div><span class="font-medium">Booking ID:</span> ${booking.id}</div>
        <div><span class="font-medium">Type:</span> ${booking.type}</div>
        <div><span class="font-medium">Item:</span> ${booking.item}</div>
        <div><span class="font-medium">Dates:</span> ${booking.dates}</div>
        <div><span class="font-medium">Total:</span> $${booking.total.toLocaleString()}</div>
        <div><span class="font-medium">Status:</span> ${booking.status}</div>
        <div class="col-span-2"><span class="font-medium">Details:</span> ${booking.details}</div>
        ${booking.driver ? `<div class="col-span-2"><span class="font-medium">Driver:</span> ${booking.driver}</div>` : ''}
      </div>
      <div class="mt-4 pt-3 border-t border-slate-100">
        <button id="closeModalBtn" class="rounded-lg bg-slate-800 px-4 py-2 text-sm text-white hover:bg-slate-700">Close</button>
      </div>
    `;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.getElementById('closeModalBtn').addEventListener('click', () => {
      modal.classList.add('hidden');
      modal.classList.remove('flex');
    });
  }

  // Event listeners
  document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.tab-btn').forEach(b => {
        b.classList.remove('border-cyan-500', 'text-cyan-600');
        b.classList.add('text-slate-600');
      });
      btn.classList.add('border-cyan-500', 'text-cyan-600');
      btn.classList.remove('text-slate-600');
      currentTab = btn.dataset.tab;
      currentPage = 1;
      renderTable();
    });
  });

  document.getElementById('searchInput').addEventListener('input', () => { currentPage = 1; renderTable(); });
  document.getElementById('typeFilter').addEventListener('change', () => { currentPage = 1; renderTable(); });
  document.getElementById('prevPageBtn').addEventListener('click', () => { if (currentPage > 1) { currentPage--; renderTable(); } });
  document.getElementById('nextPageBtn').addEventListener('click', () => { if (currentPage < Math.ceil(filteredBookings.length / rowsPerPage)) { currentPage++; renderTable(); } });

  document.getElementById('closeDetailsModal')?.addEventListener('click', () => {
    document.getElementById('detailsModal').classList.add('hidden');
  });
  window.addEventListener('click', (e) => {
    const modal = document.getElementById('detailsModal');
    if (e.target === modal) modal.classList.add('hidden');
  });

  // Initial render
  renderTable();

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
<x-user.layout>

@push('styles')
<style>
  /* Fade-up animation */
  .fade-up {
    opacity: 1;
    transform: translateY(0);
    transition: opacity 0.8s cubic-bezier(0.2, 0.9, 0.4, 1.1),
                transform 0.8s cubic-bezier(0.2, 0.9, 0.4, 1.1);
  }
  .fade-up.visible {
    opacity: 1;
    transform: translateY(0);
  }

  /* Owl Carousel custom nav & dots */
  /* Override owl-theme defaults with higher specificity */
  .owl-theme .owl-nav button.owl-prev,
  .owl-theme .owl-nav button.owl-next {
    position: absolute !important;
    top: 50% !important;
    transform: translateY(-50%) !important;
    width: 44px !important;
    height: 44px !important;
    border-radius: 50% !important;
    background: white !important;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    font-size: 28px !important;
    color: #0f172a !important;
    transition: all 0.3s ease !important;
    margin: 0 !important;
    padding: 0 !important;
    line-height: 1 !important;
    border: none !important;
  }
  .owl-theme .owl-nav button.owl-prev:hover,
  .owl-theme .owl-nav button.owl-next:hover {
    background: #06b6d4 !important;
    color: white !important;
    box-shadow: 0 6px 16px rgba(6, 182, 212, 0.3) !important;
    transform: translateY(-50%) scale(1.05) !important;
  }
  .owl-theme .owl-nav button.owl-prev { left: -22px !important; }
  .owl-theme .owl-nav button.owl-next { right: -22px !important; }

  .owl-theme .owl-dots {
    margin-top: 28px !important;
    display: flex !important;
    justify-content: center !important;
    gap: 12px !important;
  }
  .owl-theme .owl-dot {
    width: 12px !important;
    height: 12px !important;
    border-radius: 50% !important;
    background-color: #94a3b8 !important;
    transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1) !important;
    cursor: pointer !important;
  }
  .owl-theme .owl-dot.active {
    width: 32px !important;
    border-radius: 20px !important;
    background: linear-gradient(135deg, #06b6d4, #0891b2) !important;
    box-shadow: 0 0 8px rgba(6, 182, 212, 0.5) !important;
  }
  .owl-theme .owl-dot:hover {
    background-color: #64748b !important;
    transform: scale(1.3) !important;
  }

  @media (max-width: 768px) {
    .owl-theme .owl-nav button.owl-prev,
    .owl-theme .owl-nav button.owl-next {
      width: 36px !important;
      height: 36px !important;
      font-size: 22px !important;
    }
    .owl-theme .owl-nav button.owl-prev { left: -12px !important; }
    .owl-theme .owl-nav button.owl-next { right: -12px !important; }
  }

  /* Pulse animation for contact buttons */
  @keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
  }
  .pulse-hover:hover {
    animation: pulse 0.5s ease-in-out;
  }
</style>
@endpush

{{-- 1. HERO SECTION --}}
<section data-hero-section aria-labelledby="hero-heading" class="relative overflow-hidden bg-slate-950 pt-24 text-white lg:pt-32 fade-up">
  <div class="absolute inset-0 -z-10">
    <div class="absolute inset-0 bg-gradient-to-br from-slate-950/95 via-slate-950/80 to-slate-950/40"></div>
    <img loading="lazy" class="h-full w-full object-cover" src="https://images.unsplash.com/photo-1542362567-b07e54358753?auto=format&fit=crop&w=1800&q=80" alt="Premium Sports Car" />
  </div>

  <div class="relative mx-auto grid max-w-7xl items-center gap-12 px-4 pb-18 sm:px-6 lg:grid-cols-[1fr_0.92fr] lg:px-8 lg:pb-22">
    <div class="transform transition-all duration-700 hover:translate-y-[-5px]">
      <p class="mb-4 inline-flex items-center gap-2 rounded-full bg-cyan-500/10 px-4 py-1.5 text-xs font-bold uppercase tracking-widest text-cyan-400 ring-1 ring-cyan-400/20 backdrop-blur-md">
        <i data-lucide="sparkles" class="h-4 w-4"></i> Premium mobility, simplified
      </p>
      <h1 id="hero-heading" class="max-w-3xl text-3xl font-black leading-tight sm:text-4xl lg:text-5xl tracking-tight text-white">
        Your Trusted <br>
        <span class="bg-gradient-to-r from-cyan-400 to-cyan-200 bg-clip-text text-transparent">Automotive Partner</span>
      </h1>
      <p class="mt-6 max-w-2xl leading-8 text-slate-200">Rent verified vehicles, book professional drivers, manage licensing needs, and explore premium automotive services from one polished portal.</p>
      
      <div class="mt-8 flex flex-col gap-4 sm:flex-row">
        <a href="/login" class="group inline-flex items-center justify-center gap-2 rounded-lg bg-cyan-400 px-6 py-3.5 text-sm font-bold text-black shadow-sm hover:bg-cyan-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-cyan-300 focus-visible:ring-offset-2 focus-visible:ring-offset-slate-950">
          Rent a Car <i data-lucide="arrow-right" class="h-4 w-4 transition-all duration-300 group-hover:translate-x-1"></i>
        </a>
        <a href="#services" class="group inline-flex items-center justify-center gap-2 rounded-xl border border-white/20 bg-white/5 px-6 py-3.5 text-sm font-bold text-white backdrop-blur-sm transition-all duration-300 hover:border-cyan-400/50 hover:text-cyan-100 hover:scale-105 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-cyan-300 focus-visible:ring-offset-2 focus-visible:ring-offset-slate-950">
          Explore Marketplace <i data-lucide="shopping-bag" class="h-4 w-4 transition-all duration-300 group-hover:rotate-12"></i>
        </a>
      </div>
 
      <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-3xl border border-white/10 bg-white/10 px-4 py-4 text-center text-sm text-slate-200 transition hover:border-cyan-400/30 hover:bg-white/15">
          <p class="font-black text-white">24/7</p>
          <p class="mt-2">Support whenever you need it</p>
        </div>
        <div class="rounded-3xl border border-white/10 bg-white/10 px-4 py-4 text-center text-sm text-slate-200 transition hover:border-cyan-400/30 hover:bg-white/15">
          <p class="font-black text-white">500+</p>
          <p class="mt-2">Verified vehicles</p>
        </div>
        <div class="rounded-3xl border border-white/10 bg-white/10 px-4 py-4 text-center text-sm text-slate-200 transition hover:border-cyan-400/30 hover:bg-white/15">
          <p class="font-black text-white">95%</p>
          <p class="mt-2">Repeat customer satisfaction</p>
        </div>
        <div class="rounded-3xl border border-white/10 bg-white/10 px-4 py-4 text-center text-sm text-slate-200 transition hover:border-cyan-400/30 hover:bg-white/15">
          <p class="font-black text-white">Fast</p>
          <p class="mt-2">Instant booking confirmation</p>
        </div>
      </div>
 
      <div class="mt-4 grid gap-4 sm:grid-cols-2 border-t border-white/10 pt-8">
        <div class="flex items-center gap-3 rounded-3xl bg-white/10 p-4 text-sm font-medium text-slate-200 transition-all duration-300 hover:-translate-y-0.5 hover:bg-white/15"><i data-lucide="check-circle-2" class="h-5 w-5 text-cyan-400"></i>Professional Drivers</div>
        <div class="flex items-center gap-3 rounded-3xl bg-white/10 p-4 text-sm font-medium text-slate-200 transition-all duration-300 hover:-translate-y-0.5 hover:bg-white/15"><i data-lucide="check-circle-2" class="h-5 w-5 text-cyan-400"></i>Verified Vehicles</div>
        <div class="flex items-center gap-3 rounded-3xl bg-white/10 p-4 text-sm font-medium text-slate-200 transition-all duration-300 hover:-translate-y-0.5 hover:bg-white/15"><i data-lucide="check-circle-2" class="h-5 w-5 text-cyan-400"></i>Secure Payments</div>
        <div class="flex items-center gap-3 rounded-3xl bg-white/10 p-4 text-sm font-medium text-slate-200 transition-all duration-300 hover:-translate-y-0.5 hover:bg-white/15"><i data-lucide="check-circle-2" class="h-5 w-5 text-cyan-400"></i>License Assistance</div>
      </div>
    </div>

    <div class="relative">
      <div class="relative rounded-2xl border border-white/10 bg-white/5 p-3 shadow-2xl shadow-black/20 backdrop-blur-md transition-all duration-500 hover:scale-105 hover:shadow-cyan-500/20">
        <img class="aspect-[4/3] w-full rounded-xl object-cover transition-all duration-700 hover:brightness-110" src="https://images.unsplash.com/photo-1555215695-3004980ad54e?auto=format&fit=crop&w=1200&q=85" alt="Modern luxury SUV parked in a city" />
      </div>
      <div class="absolute -bottom-6 left-6 max-w-xs rounded-xl border border-slate-200 bg-white p-3 shadow-2xl transition-all duration-300 hover:shadow-cyan-500/10 hover:scale-105 backdrop-blur-sm">
        <div class="flex items-center gap-4">
          <span class="grid h-10 w-10 place-items-center rounded-xl bg-cyan-950 text-cyan-400 ring-1 ring-cyan-400/20 transition-all duration-300 hover:bg-cyan-900">
            <i data-lucide="shield-check" class="h-5 w-5"></i>
          </span>
          <div>
            <p class="text-sm font-black tracking-tight text-cyan-950">Verified Fleet</p>
            <p class="text-xs text-slate-500 mt-0.5">Inspected, insured, and ready.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- 2. WHY SKYLINE --}}
<section aria-labelledby="why-heading" class="bg-white py-12 fade-up">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="text-center max-w-3xl mx-auto">
      <p class="text-xs font-bold uppercase tracking-widest text-cyan-600 bg-cyan-50 inline-block px-3 py-1 rounded-full">Why SkyLine</p>
      <h2 id="why-heading" class="mt-4 text-3xl font-black text-slate-950 sm:text-4xl tracking-tight">Driven by excellence, trusted by thousands</h2>
      <p class="mt-4 text-slate-600 text-base leading-relaxed">We combine cutting‑edge technology, absolute transparency, and top‑tier customer service to give you the ultimate automotive experience.</p>
    </div>
    <div class="mt-10 grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
      <div class="group rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition-all duration-500 hover:-translate-y-3 hover:shadow-xl hover:border-cyan-300">
        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-cyan-50 text-cyan-600 transition-all duration-300 group-hover:bg-cyan-100 group-hover:scale-110"><i data-lucide="clock" class="h-6 w-6"></i></div>
        <h3 class="mt-5 text-xl font-bold text-slate-900 group-hover:text-cyan-600 transition-colors">24/7 Support</h3>
        <p class="mt-2 text-slate-600 text-sm leading-6">Our team is always ready to assist you, day or night, for any request or emergency road service.</p>
      </div>
      <div class="group rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition-all duration-500 hover:-translate-y-3 hover:shadow-xl hover:border-cyan-300">
        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-cyan-50 text-cyan-600 transition-all duration-300 group-hover:bg-cyan-100 group-hover:scale-110"><i data-lucide="shield" class="h-6 w-6"></i></div>
        <h3 class="mt-5 text-xl font-bold text-slate-900 group-hover:text-cyan-600 transition-colors">Fully Insured</h3>
        <p class="mt-2 text-slate-600 text-sm leading-6">Every premium vehicle and professional driver is fully insured, granting you absolute peace of mind.</p>
      </div>
      <div class="group rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition-all duration-500 hover:-translate-y-3 hover:shadow-xl hover:border-cyan-300">
        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-cyan-50 text-cyan-600 transition-all duration-300 group-hover:bg-cyan-100 group-hover:scale-110"><i data-lucide="map-pin" class="h-6 w-6"></i></div>
        <h3 class="mt-5 text-xl font-bold text-slate-900 group-hover:text-cyan-600 transition-colors">Wide Network</h3>
        <p class="mt-2 text-slate-600 text-sm leading-6">Operational in 50+ major cities, we seamlessly bring ultra‑premium mobility wherever you land.</p>
      </div>
    </div>
  </div>
</section>

{{-- 3. FEATURED VEHICLES --}}
<section id="vehicles" aria-labelledby="fleet-heading" class="bg-slate-100 py-12 fade-up">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-end gap-4 mb-10">
      <div class="text-left max-w-3xl">
        <p class="text-xs font-bold uppercase tracking-widest text-cyan-600 bg-cyan-50 inline-block px-3 py-1 rounded-full">Featured Fleet</p>
        <h2 id="fleet-heading" class="mt-4 text-3xl font-black text-slate-950 sm:text-4xl tracking-tight">Ready For Your Next Booking</h2>
        <p class="mt-4 text-slate-600 text-base leading-relaxed">Impeccably maintained machinery. Pick your ideal ride from our premium tier offerings.</p>
      </div>
      <a href="/login" class="rounded-xl bg-slate-950 px-6 py-3 text-sm font-bold text-white transition-all duration-300 hover:bg-slate-800 hover:scale-105 hover:shadow-xl shrink-0 inline-block text-center">View Full Fleet &rarr;</a>
    </div>
    <div class="owl-carousel fleet-carousel">
      @forelse($vehicles as $v)
      @php
        $img = $v->images[0] ?? null;
        $imgUrl = $img ? (Str::startsWith($img, 'http') ? $img : asset('storage/'.$img)) : 'https://images.unsplash.com/photo-1549399542-7e3f8b83ad38?auto=format&fit=crop&w=600&q=80';
        $specs = collect();
        if ($v->capacity) $specs->push($v->capacity.' seats');
        if ($v->color) $specs->push($v->color);
      @endphp
      <div class="item px-2">
      <div class="group rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 overflow-hidden">
        <div class="relative overflow-hidden h-44 bg-slate-100 dark:bg-slate-800">
          <img loading="lazy" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110" src="{{ $imgUrl }}" alt="{{ $v->brand->name ?? '' }} {{ $v->model }}" />
          <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        </div>
        <div class="p-3">
          <div class="flex items-center justify-between mb-3">
            <div>
              <h3 class="text-base font-bold text-slate-900 dark:text-white">{{ $v->brand->name ?? '' }} {{ $v->model }}</h3>
              <p class="mt-1.5 text-xs text-slate-500 dark:text-slate-400 font-medium">{{ $v->category->name ?? 'Standard' }}</p>
            </div>
            <div class="flex items-center gap-1 text-xs font-medium text-slate-600 dark:text-slate-400">
              <i data-lucide="map-pin" class="h-3.5 w-3.5"></i>
              {{ $v->location ?? 'Yangon' }}
            </div>
          </div>
          <div class="mb-3 flex flex-wrap gap-2">
            @foreach($specs as $spec)
            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-slate-100 dark:bg-slate-800 text-xs font-medium text-slate-700 dark:text-slate-300">
              <i data-lucide="check" class="h-3 w-3 text-cyan-500"></i>
              {{ $spec }}
            </span>
            @endforeach
          </div>
          <div class="flex items-center justify-between border-t border-slate-100 dark:border-slate-800 pt-3">
            <div>
              <p class="font-black text-slate-950 dark:text-white">MMK {{ number_format($v->price_per_day) }}</p>
              <p class="text-sm text-slate-500 dark:text-slate-400">per day</p>
            </div>
            <a href="/login" class="inline-block rounded-lg bg-cyan-400 dark:bg-cyan-500 px-4 py-2.5 text-sm font-bold text-black shadow-sm hover:bg-cyan-500 dark:hover:bg-cyan-400 active:scale-95 transition-all">Book Now</a>
          </div>
        </div>
      </div>
      </div>
      @empty
      <div class="text-center py-16 text-slate-500">
        <i data-lucide="car" class="h-12 w-12 mx-auto opacity-40"></i>
        <p class="mt-4 font-semibold">No vehicles available at the moment.</p>
      </div>
      @endforelse
    </div>
  </div>
</section>

{{-- 4. SERVICES OVERVIEW --}}
<section id="services" aria-labelledby="services-heading" class="bg-white py-12 fade-up">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="text-center max-w-3xl mx-auto mb-10">
      <p class="text-xs font-bold uppercase tracking-widest text-cyan-600 bg-cyan-50 inline-block px-3 py-1 rounded-full">Services Overview</p>
      <h2 id="services-heading" class="mt-4 text-3xl font-black text-slate-950 sm:text-4xl tracking-tight">Complete Automotive Support</h2>
      <p class="mt-4 text-slate-600 text-base">Everything structural your driving ecosystem requires under a modern digital layout.</p>
    </div>
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
      @php
        $services = [
          ['icon' => 'car', 'title' => 'Car Rental', 'desc' => 'Flexible daily and weekly rentals from economy cars to executive SUVs.'],
          ['icon' => 'user-check', 'title' => 'Driver Service', 'desc' => 'Vetted chauffeurs for corporate trips, events, airport transfers, and tours.'],
          ['icon' => 'badge-check', 'title' => 'License Services', 'desc' => 'Guided assistance for renewals, paperwork, appointments, and compliance.'],
          ['icon' => 'shopping-bag', 'title' => 'Marketplace', 'desc' => 'Browse inspected listings, accessories, service packages, and upgrades.'],
        ];
      @endphp
      @foreach($services as $service)
      <article class="group rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition-all duration-500 hover:-translate-y-2 hover:shadow-xl hover:border-cyan-300 flex flex-col justify-between">
        <div>
          <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-cyan-50 text-cyan-600 transition-all duration-300 group-hover:bg-cyan-100 group-hover:scale-110">
            <i data-lucide="{{ $service['icon'] }}" class="h-6 w-6"></i>
          </div>
          <h3 class="mt-5 text-lg font-black text-slate-900 group-hover:text-cyan-600 transition-colors">{{ $service['title'] }}</h3>
          <p class="mt-3 text-sm leading-6 text-slate-600">{{ $service['desc'] }}</p>
        </div>
        <a href="#contact" class="mt-6 text-sm font-bold text-cyan-600 transition-all duration-300 group-hover:text-cyan-800 group-hover:translate-x-1 inline-flex items-center gap-1 self-start" aria-label="Contact us to learn more about services">
          Learn More <i data-lucide="arrow-right" class="h-3 w-3"></i>
        </a>
      </article>
      @endforeach
    </div>
  </div>
</section>

{{-- 5. EXPERT DRIVERS LICENSE TYPES --}}
<section aria-labelledby="expert-heading" class="bg-slate-100 py-12 fade-up">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-end gap-4 mb-10">
      <div class="text-left max-w-3xl">
        <p class="text-xs font-bold uppercase tracking-widest text-cyan-600 bg-cyan-50 inline-block px-3 py-1 rounded-full">Expert Drivers</p>
        <h2 id="expert-heading" class="mt-4 text-3xl font-black text-slate-950 sm:text-4xl tracking-tight">Ready For Your Next Booking</h2>
        <p class="mt-4 text-slate-600 text-base leading-relaxed">All drivers are deeply vetted, background‑checked, and highly trained to ensure a reliable journey.</p>
      </div>
      <a href="/login" class="rounded-xl bg-slate-950 px-6 py-3 text-sm font-bold text-white transition-all duration-300 hover:bg-slate-800 hover:scale-105 hover:shadow-xl shrink-0 inline-block text-center">View All Drivers &rarr;</a>
    </div>
    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
      @php
        $licenseDescriptions = [
          'Kha (ခ)' => 'Private cars (up to 3 tons)',
          'Ga (ဂ)' => 'Tractors & heavy machinery',
          'Gha (ဃ)' => 'Taxis & commercial vans',
          'Nga (င)' => 'Large buses & cargo trucks',
        ];
        $licenseColors = [
          'Kha (ခ)' => ['from-yellow-400', 'to-yellow-500', 'border-yellow-200', 'bg-yellow-100', 'text-yellow-700'],
          'Ga (ဂ)' => ['from-blue-500', 'to-blue-600', 'border-blue-200', 'bg-blue-100', 'text-blue-700'],
          'Gha (ဃ)' => ['from-orange-500', 'to-orange-600', 'border-orange-200', 'bg-orange-100', 'text-orange-700'],
          'Nga (င)' => ['from-pink-500', 'to-pink-600', 'border-pink-200', 'bg-pink-100', 'text-pink-700'],
        ];
      @endphp
      @forelse($drivingLicenseTypes as $lt)
      @php
        $colors = $licenseColors[$lt->type] ?? $licenseColors['Kha (ခ)'];
        $desc = $licenseDescriptions[$lt->type] ?? '';
        $imgUrl = $lt->image ? (Str::startsWith($lt->image, 'http') ? $lt->image : asset('storage/'.$lt->image)) : '';
      @endphp
      <div class="group rounded-2xl border-2 {{ $colors[2] ?? 'border-yellow-200' }} dark:border-slate-700 bg-white dark:bg-slate-900 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 overflow-hidden flex flex-col">
        <div class="bg-gradient-to-r {{ $colors[0] ?? 'from-yellow-400' }} {{ $colors[1] ?? 'to-yellow-500' }} px-4 py-4 text-white relative overflow-hidden">
          <div class="absolute inset-0 opacity-20">
            <div class="absolute -top-6 -right-6 w-20 h-20 bg-white rounded-full blur-2xl"></div>
            <div class="absolute -bottom-6 -left-6 w-16 h-16 bg-white rounded-full blur-2xl"></div>
          </div>
          <div class="relative z-10">
            <h3 class="text-lg font-bold">{{ $lt->type }}</h3>
            @if($desc)
            <p class="mt-0.5 text-xs text-white/80 font-medium">{{ $desc }}</p>
            @endif
          </div>
        </div>
        <div class="p-4 flex-1 flex flex-col">
          @if($imgUrl)
          <div class="mb-3 -mx-4 -mt-4 h-32 overflow-hidden">
            <img src="{{ $imgUrl }}" alt="{{ $lt->type }}" class="h-full w-full object-cover" loading="lazy">
          </div>
          @endif
          <div class="flex items-center gap-2 mb-3">
            <span class="inline-flex items-center gap-1 rounded-full px-2.5 py-1 text-[11px] font-semibold {{ $colors[3] ?? 'bg-yellow-100' }} {{ $colors[4] ?? 'text-yellow-700' }} dark:bg-slate-800 dark:text-slate-300">
              <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
              {{ $lt->drivers_count ?? 0 }} driver{{ $lt->drivers_count !== 1 ? 's' : '' }} available
            </span>
          </div>
          <div class="mt-auto flex items-center justify-between border-t border-slate-100 dark:border-slate-800 pt-3">
            <div>
              <p class="font-black text-slate-950 dark:text-white text-sm">MMK {{ number_format($lt->price ?? 0) }}</p>
              <p class="text-[11px] text-slate-500 dark:text-slate-400">per day</p>
            </div>
            <a href="/login" class="inline-block rounded-lg bg-cyan-400 dark:bg-cyan-500 px-3 py-1.5 text-xs font-bold text-black shadow-sm hover:bg-cyan-500 dark:hover:bg-cyan-400 active:scale-95 transition-all">Hire Now</a>
          </div>
        </div>
      </div>
      @empty
      <div class="lg:col-span-4 text-center py-16 text-slate-500">
        <i data-lucide="users" class="h-12 w-12 mx-auto opacity-40"></i>
        <p class="mt-4 font-semibold">No drivers available at the moment.</p>
      </div>
      @endforelse
    </div>
  </div>
</section>

{{-- 6. HOW IT WORKS --}}
<section aria-labelledby="how-heading" class="bg-white py-12 fade-up">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="text-center max-w-3xl mx-auto">
      <p class="text-xs font-bold uppercase tracking-widest text-cyan-600 bg-cyan-50 inline-block px-3 py-1 rounded-full">Simple Process</p>
      <h2 id="how-heading" class="mt-4 text-3xl font-black text-slate-950 sm:text-4xl tracking-tight">How SkyLine works</h2>
      <p class="mt-4 text-slate-600 text-base">From simple initial search up to premium driving execution — entirely effortless.</p>
    </div>
    <div class="mt-10 grid gap-8 sm:grid-cols-3">
      <div class="group text-center transition-all duration-500 hover:-translate-y-2">
        <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-cyan-50 text-cyan-600 transition-all duration-300 group-hover:bg-cyan-100 group-hover:scale-110">
          <i data-lucide="search" class="h-10 w-10"></i>
        </div>
        <h3 class="mt-5 text-xl font-bold text-slate-900 group-hover:text-cyan-600 transition-colors">1. Choose a vehicle</h3>
        <p class="mt-2 text-slate-600 text-sm leading-6 max-w-xs mx-auto">Browse our fleet of premium cars, SUVs, and executive sedans.</p>
      </div>
      <div class="group text-center transition-all duration-500 hover:-translate-y-2">
        <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-cyan-50 text-cyan-600 transition-all duration-300 group-hover:bg-cyan-100 group-hover:scale-110">
          <i data-lucide="calendar-check" class="h-10 w-10"></i>
        </div>
        <h3 class="mt-5 text-xl font-bold text-slate-900 group-hover:text-cyan-600 transition-colors">2. Book instantly</h3>
        <p class="mt-2 text-slate-600 text-sm leading-6 max-w-xs mx-auto">Select dates, add your preferred driver profile, and confirm securely.</p>
      </div>
      <div class="group text-center transition-all duration-500 hover:-translate-y-2">
        <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-cyan-50 text-cyan-600 transition-all duration-300 group-hover:bg-cyan-100 group-hover:scale-110">
          <i data-lucide="car-front" class="h-10 w-10"></i>
        </div>
        <h3 class="mt-5 text-xl font-bold text-slate-900 group-hover:text-cyan-600 transition-colors">3. Drive & enjoy</h3>
        <p class="mt-2 text-slate-600 text-sm leading-6 max-w-xs mx-auto">Pick up keys easily or get chauffeured directly to your location.</p>
      </div>
    </div>
  </div>
</section>

{{-- 7. TRUST STATS --}}
<section id="about" aria-labelledby="stats-heading" class="bg-white py-12 fade-up">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="text-center max-w-3xl mx-auto mb-10">
      <p class="text-xs font-bold uppercase tracking-widest text-cyan-600 bg-cyan-50 inline-block px-3 py-1 rounded-full">SkyLine By The Numbers</p>
      <h2 id="stats-heading" class="mt-4 text-3xl font-black text-slate-950 sm:text-4xl tracking-tight">We Don’t Just Talk – We Deliver</h2>
      <p class="mt-4 text-slate-600 text-base">Real figures, real trust, real results.</p>
    </div>
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
      <div class="group rounded-2xl border border-slate-200 p-6 text-center transition-all duration-500 hover:shadow-xl hover:-translate-y-2 hover:border-cyan-300">
        <p class="text-4xl font-black text-slate-950 transition-all duration-300 group-hover:text-cyan-600 group-hover:scale-110 inline-block">
          <span class="stat-number" data-target="500">0</span>+
        </p>
        <p class="mt-2 text-sm font-semibold text-slate-500 group-hover:text-cyan-500">Vehicles</p>
      </div>
      <div class="group rounded-2xl border border-slate-200 p-6 text-center transition-all duration-500 hover:shadow-xl hover:-translate-y-2 hover:border-cyan-300">
        <p class="text-4xl font-black text-slate-950 transition-all duration-300 group-hover:text-cyan-600 group-hover:scale-110 inline-block">
          <span class="stat-number" data-target="1000">0</span>+
        </p>
        <p class="mt-2 text-sm font-semibold text-slate-500 group-hover:text-cyan-500">Happy Customers</p>
      </div>
      <div class="group rounded-2xl border border-slate-200 p-6 text-center transition-all duration-500 hover:shadow-xl hover:-translate-y-2 hover:border-cyan-300">
        <p class="text-4xl font-black text-slate-950 transition-all duration-300 group-hover:text-cyan-600 group-hover:scale-110 inline-block">
          <span class="stat-number" data-target="24">0</span>/7
        </p>
        <p class="mt-2 text-sm font-semibold text-slate-500 group-hover:text-cyan-500">Support</p>
      </div>
      <div class="group rounded-2xl border border-slate-200 p-6 text-center transition-all duration-500 hover:shadow-xl hover:-translate-y-2 hover:border-cyan-300">
        <p class="text-4xl font-black text-slate-950 transition-all duration-300 group-hover:text-cyan-600 group-hover:scale-110 inline-block">
          <span class="stat-number" data-target="100">0</span>%
        </p>
        <p class="mt-2 text-sm font-semibold text-slate-500 group-hover:text-cyan-500">Secure Payments</p>
      </div>
    </div>
  </div>
</section>

{{-- 9. CONTACT CTA --}}
<section id="contact" aria-labelledby="contact-heading" class="py-12 fade-up">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="rounded-2xl bg-gradient-to-br from-slate-800 to-slate-950 px-6 py-10 shadow-2xl transition-all duration-500 hover:shadow-cyan-900/30 sm:px-10 lg:flex lg:items-center lg:justify-between">
      <div class="text-center lg:text-left">
        <h2 id="contact-heading" class="text-3xl font-black tracking-tight text-white">Need Immediate Assistance?</h2>
        <p class="mt-3 max-w-2xl text-slate-300 text-sm leading-relaxed">Our support infrastructure responds 24/7 regarding high‑tier vehicle rentals, licensing tracking updates, and direct marketplace queries.</p>
      </div>
      <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-center lg:mt-0">
        <a href="mailto:support@skyline.demo" class="group inline-flex items-center justify-center gap-2 rounded-lg bg-cyan-400 px-6 py-3.5 text-sm font-bold text-black shadow-sm hover:bg-cyan-500">
          Contact Us <i data-lucide="mail" class="h-4 w-4 transition-transform duration-300 group-hover:rotate-12"></i>
        </a>
        <a href="mailto:support@skyline.demo" class="group rounded-xl border border-white/25 bg-white/5 px-6 py-3.5 text-sm font-bold text-white transition-all duration-300 hover:border-cyan-400/50 hover:text-cyan-100 hover:scale-105 pulse-hover inline-flex items-center justify-center gap-2"
           aria-label="Send an inquiry by email">
          Send Inquiry <i data-lucide="send" class="h-4 w-4 inline ml-1 transition-transform duration-300 group-hover:translate-x-1"></i>
        </a>
      </div>
    </div>
  </div>
</section>

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    var waitForCarousel = setInterval(function () {
      if (typeof window.$ !== 'undefined' && typeof window.$.fn.owlCarousel === 'function') {
        clearInterval(waitForCarousel);
        $('.fleet-carousel').owlCarousel({
          loop: true,
          margin: 24,
          nav: true,
          navText: ['‹', '›'],
          dots: true,
          autoplay: true,
          autoplayTimeout: 4000,
          autoplayHoverPause: true,
          responsive: {
            0: { items: 1, margin: 16 },
            640: { items: 2, margin: 20 },
            1024: { items: 3, margin: 24 },
            1280: { items: 4, margin: 24 }
          }
        });
      }
    }, 200);

    const fadeElements = document.querySelectorAll('.fade-up');
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
        }
      });
    }, { threshold: 0.1 });
    fadeElements.forEach(el => observer.observe(el));

    function animateNumbers() {
      const statNumbers = document.querySelectorAll('.stat-number');
      statNumbers.forEach(stat => {
        const target = parseInt(stat.getAttribute('data-target'));
        if (isNaN(target)) return;
        let current = 0;
        const increment = target / 50;
        const updateNumber = () => {
          current += increment;
          if (current < target) {
            stat.innerText = Math.floor(current);
            requestAnimationFrame(updateNumber);
          } else {
            stat.innerText = target;
          }
        };
        updateNumber();
      });
    }

    const statsSection = document.querySelector('#about');
    if (statsSection) {
      const statsObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            animateNumbers();
            statsObserver.unobserve(entry.target);
          }
        });
      }, { threshold: 0.5 });
      statsObserver.observe(statsSection);
    }
  });
</script>
@endpush
</x-user.layout> 

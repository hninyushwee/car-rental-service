<x-user.layout>

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
  .stat-number {
    display: inline-block;
  }
</style>
@endpush

{{-- HERO SECTION --}}
<section data-hero-section class="relative overflow-hidden bg-slate-950 pt-24 text-white lg:pt-32 pb-24 lg:pb-36 fade-up">
  <div class="absolute inset-0 -z-10">
    <div class="absolute inset-0 bg-gradient-to-br from-slate-950/90 via-slate-950/70 to-slate-950/30"></div>
    <img class="h-full w-full object-cover" src="https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?auto=format&fit=crop&w=1800&q=80" alt="Luxury car on road" />
  </div>
  <div class="relative mx-auto max-w-7xl px-4 pb-14 text-center sm:px-6 lg:px-8 lg:pb-18">
    <p class="mb-4 inline-flex items-center gap-2 rounded-full bg-cyan-500/10 px-4 py-1.5 text-xs font-bold uppercase tracking-widest text-cyan-400 ring-1 ring-cyan-400/20 backdrop-blur-md">
      <i data-lucide="info" class="h-4 w-4"></i> Our Story
    </p>
    <h1 class="text-4xl font-black tracking-tight sm:text-5xl lg:text-6xl max-w-4xl mx-auto leading-tight">
      Driving the future of <br><span class="bg-gradient-to-r from-cyan-400 via-cyan-200 to-white bg-clip-text text-transparent">premium journey</span>
    </h1>
    <p class="mt-6 max-w-2xl mx-auto text-base sm:text-lg leading-relaxed text-slate-300">
      We started SkyLine with one goal: to make premium mobility effortless, transparent, and accessible to everyone.
    </p>
    <div class="mt-8 flex flex-col gap-4 sm:flex-row justify-center">
      <a href="#vehicles" class="group inline-flex items-center justify-center gap-2 rounded-xl bg-cyan-400 px-6 py-3.5 text-sm font-bold text-slate-950 shadow-lg shadow-cyan-400/20 transition-all duration-300 hover:bg-cyan-300 hover:scale-105">
        Rent a Car <i data-lucide="arrow-right" class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1"></i>
      </a>
      <a href="#services" class="group inline-flex items-center justify-center gap-2 rounded-xl border border-white/20 bg-white/5 px-6 py-3.5 text-sm font-bold text-white backdrop-blur-sm transition-all duration-300 hover:border-cyan-400/50 hover:text-cyan-100 hover:scale-105">
        Explore Services <i data-lucide="shopping-bag" class="h-4 w-4 transition-transform duration-300 group-hover:rotate-12"></i>
      </a>
    </div>
  </div>
</section>

{{-- MODERN MISSION & VISION --}}
<section class="bg-white py-24 fade-up">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="mx-auto max-w-3xl text-center">
            <span
                class="inline-flex items-center rounded-full bg-cyan-100 px-4 py-1 text-xs font-bold uppercase tracking-widest text-cyan-700">
                Our Purpose
            </span>

            <h2 class="mt-5 text-3xl font-black tracking-tight text-slate-900 sm:text-4xl">
                Mission & Vision
            </h2>

            <p class="mt-5 text-lg text-slate-600">
                Building a smarter and more reliable future for transportation.
            </p>
        </div>

        {{-- Cards --}}
        <div class="mt-16 grid gap-8 lg:grid-cols-2">

            {{-- Mission --}}
            <div
                class="group relative overflow-hidden rounded-[32px] border border-slate-200 bg-white p-10 shadow-sm transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl">

                <div
                    class="absolute right-0 top-0 h-40 w-40 translate-x-10 -translate-y-10 rounded-full bg-cyan-100 blur-3xl">
                </div>

                <div
                    class="relative flex h-20 w-20 items-center justify-center rounded-3xl bg-gradient-to-br from-cyan-200 to-blue-400 text-slate-950 transition-all duration-300 group-hover:scale-110">
                    <i data-lucide="target" class="h-9 w-9"></i>
                </div>

                <h3 class="relative mt-8 text-2xl font-black text-slate-900">
                    Our Mission
                </h3>

                <p class="relative mt-5 text-lg leading-relaxed text-slate-600">
                    To redefine mobility through a seamless digital platform
                    where customers can rent vehicles, hire professional drivers,
                    and discover trusted automotive services with confidence.
                </p>

                <div class="relative mt-8 flex items-center gap-3">
                    <div class="h-3 w-3 rounded-full bg-cyan-500 animate-pulse"></div>
                    <span class="text-sm font-semibold text-cyan-700">
                        Driving innovation today
                    </span>
                </div>
            </div>

            {{-- Vision --}}
            <div
                class="group relative overflow-hidden rounded-[32px] border border-cyan-200 bg-gradient-to-br from-cyan-50 to-white p-10 shadow-sm transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl">

                <div
                    class="absolute bottom-0 left-0 h-40 w-40 -translate-x-10 translate-y-10 rounded-full bg-cyan-200/60 blur-3xl">
                </div>

                <div
                    class="relative flex h-20 w-20 items-center justify-center rounded-3xl bg-gradient-to-br from-cyan-200 to-blue-400 text-slate-950 transition-all duration-300 group-hover:scale-110">
                    <i data-lucide="eye" class="h-9 w-9"></i>
                </div>

                <h3 class="relative mt-8 text-2xl font-black text-slate-900">
                    Our Vision
                </h3>

                <p class="relative mt-5 text-lg leading-relaxed text-slate-600">
                    To become the most trusted automotive ecosystem by connecting
                    people with vehicles, drivers, and transportation solutions
                    anytime and anywhere.
                </p>

                <div class="relative mt-8 flex items-center gap-3">
                    <div class="h-3 w-3 rounded-full bg-cyan-500"></div>
                    <span class="text-sm font-semibold text-cyan-700">
                        Creating the future of mobility
                    </span>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- CORE VALUES --}}
<section class="bg-slate-100 py-16 fade-up">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="text-center max-w-3xl mx-auto mb-10">
      <p class="text-xs font-bold uppercase tracking-widest text-cyan-600 bg-cyan-50 inline-block px-3 py-1 rounded-full">What We Stand For</p>
      <h2 class="mt-4 text-3xl font-black text-slate-950 sm:text-4xl tracking-tight">Core Values</h2>
      <p class="mt-4 text-slate-600">These principles guide everything we do, from product development to customer support.</p>
    </div>
    <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
      <div class="group rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition-all duration-500 hover:-translate-y-3 hover:shadow-xl hover:border-cyan-300">
        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-cyan-50 text-cyan-600 transition-all duration-300 group-hover:bg-cyan-100 group-hover:scale-110">
          <i data-lucide="shield-check" class="h-6 w-6"></i>
        </div>
        <h3 class="mt-5 text-xl font-bold text-slate-900 group-hover:text-cyan-600 transition-colors">Trust & Transparency</h3>
        <p class="mt-2 text-slate-600 text-sm leading-6">No hidden fees. Every vehicle and driver is fully vetted and insured.</p>
      </div>
      <div class="group rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition-all duration-500 hover:-translate-y-3 hover:shadow-xl hover:border-cyan-300">
        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-cyan-50 text-cyan-600 transition-all duration-300 group-hover:bg-cyan-100 group-hover:scale-110">
          <i data-lucide="zap" class="h-6 w-6"></i>
        </div>
        <h3 class="mt-5 text-xl font-bold text-slate-900 group-hover:text-cyan-600 transition-colors">Innovation</h3>
        <p class="mt-2 text-slate-600 text-sm leading-6">We constantly evolve our platform to make booking smoother and smarter.</p>
      </div>
      <div class="group rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition-all duration-500 hover:-translate-y-3 hover:shadow-xl hover:border-cyan-300">
        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-cyan-50 text-cyan-600 transition-all duration-300 group-hover:bg-cyan-100 group-hover:scale-110">
          <i data-lucide="users" class="h-6 w-6"></i>
        </div>
        <h3 class="mt-5 text-xl font-bold text-slate-900 group-hover:text-cyan-600 transition-colors">Customer First</h3>
        <p class="mt-2 text-slate-600 text-sm leading-6">24/7 support and a relentless focus on your satisfaction.</p>
      </div>
    </div>
  </div>
</section>

{{-- REDESIGNED: OUR JOURNEY (Timeline Track) --}}
<section class="bg-white py-20 fade-up">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="text-center max-w-3xl mx-auto mb-16">
      <p class="text-xs font-bold uppercase tracking-widest text-cyan-600 bg-cyan-50 inline-block px-3 py-1 rounded-full">Milestones</p>
      <h2 class="mt-4 text-3xl font-black text-slate-950 sm:text-4xl tracking-tight">Our Journey</h2>
      <p class="mt-4 text-slate-600">From a bold idea to a trusted platform – the road so far.</p>
    </div>
    
    {{-- Timeline Setup --}}
    <div class="relative">
      {{-- Background Timeline Bar (desktop/large screens view) --}}
      <div class="absolute top-[39px] hidden h-0.5 w-full bg-slate-100 lg:block"></div>
      
      <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-4 relative z-10">
        {{-- Item 1 --}}
        <div class="group relative flex flex-col items-center lg:items-start text-center lg:text-left">
          <div class="flex h-20 w-20 items-center justify-center rounded-2xl bg-gradient-to-br from-cyan-200 to-blue-400 font-black text-xl text-slate-950 ring-8 ring-white transition-all duration-300 group-hover:scale-105 shadow-md shadow-cyan-400/10">
            2021
          </div>
          <div class="mt-6">
            <h3 class="text-lg font-bold text-slate-950 group-hover:text-cyan-600 transition-colors">Founded</h3>
            <p class="mt-2 text-sm text-slate-600 leading-relaxed">SkyLine launched with 20 premium cars in California.</p>
          </div>
        </div>
        
        {{-- Item 2 --}}
        <div class="group relative flex flex-col items-center lg:items-start text-center lg:text-left">
          <div class="flex h-20 w-20 items-center justify-center rounded-2xl bg-gradient-to-br from-cyan-200 to-blue-400 font-black text-xl text-slate-950 ring-8 ring-white transition-all duration-300 group-hover:scale-105 shadow-md shadow-cyan-400/10">
            2022
          </div>
          <div class="mt-6">
            <h3 class="text-lg font-bold text-slate-950 group-hover:text-cyan-600 transition-colors">Driver Service</h3>
            <p class="mt-2 text-sm text-slate-600 leading-relaxed">Introduced professional chauffeurs for airport transfers.</p>
          </div>
        </div>
        
        {{-- Item 3 --}}
        <div class="group relative flex flex-col items-center lg:items-start text-center lg:text-left">
          <div class="flex h-20 w-20 items-center justify-center rounded-2xl bg-gradient-to-br from-cyan-200 to-blue-400 font-black text-xl text-slate-950 ring-8 ring-white transition-all duration-300 group-hover:scale-105 shadow-md shadow-cyan-400/10">
            2023
          </div>
          <div class="mt-6">
            <h3 class="text-lg font-bold text-slate-950 group-hover:text-cyan-600 transition-colors">Nationwide Expansion</h3>
            <p class="mt-2 text-sm text-slate-600 leading-relaxed">Expanded services to 20+ major cities across the country.</p>
          </div>
        </div>
        
        {{-- Item 4 --}}
        <div class="group relative flex flex-col items-center lg:items-start text-center lg:text-left">
          <div class="flex h-20 w-20 items-center justify-center rounded-2xl bg-gradient-to-br from-cyan-200 to-blue-400 font-black text-xl text-slate-950 ring-8 ring-white transition-all duration-300 group-hover:scale-105 shadow-md shadow-cyan-400/10">
            2024
          </div>
          <div class="mt-6">
            <h3 class="text-lg font-bold text-slate-950 group-hover:text-cyan-600 transition-colors">Marketplace Launch</h3>
            <p class="mt-2 text-sm text-slate-600 leading-relaxed">Opened platform for peer-to-peer premium car sales.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- TEAM SECTION --}}
<section class="bg-slate-100 py-16 fade-up">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="text-center max-w-3xl mx-auto mb-10">
      <p class="text-xs font-bold uppercase tracking-widest text-cyan-600 bg-cyan-50 inline-block px-3 py-1 rounded-full">Leadership</p>
      <h2 class="mt-4 text-3xl font-black text-slate-950 sm:text-4xl tracking-tight">Meet the team behind SkyLine</h2>
      <p class="mt-4 text-slate-600">Passionate experts driving the future of mobility.</p>
    </div>
    <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
      @php
        $team = [
          ['name' => 'Alex Rivera', 'role' => 'CEO & Founder', 'img' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=400&q=80', 'bio' => 'Former automotive executive with 15+ years of experience.'],
          ['name' => 'Sophia Chen', 'role' => 'CTO', 'img' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=400&q=80', 'bio' => 'Tech leader passionate about seamless user experiences.'],
          ['name' => 'Marcus Lee', 'role' => 'Head of Operations', 'img' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=400&q=80', 'bio' => 'Ensuring every ride is smooth and every vehicle is pristine.'],
        ];
      @endphp
      @foreach($team as $member)
      <div class="group rounded-2xl border border-slate-200 bg-white p-6 text-center transition-all duration-500 hover:-translate-y-2 hover:shadow-xl hover:border-cyan-300">
        <img class="mx-auto h-28 w-28 rounded-full object-cover ring-4 ring-cyan-100 transition-all duration-300 group-hover:ring-cyan-300" src="{{ $member['img'] }}" alt="{{ $member['name'] }}" />
        <h3 class="mt-4 text-xl font-bold text-slate-900">{{ $member['name'] }}</h3>
        <p class="text-sm text-cyan-600">{{ $member['role'] }}</p>
        <p class="mt-2 text-sm text-slate-500">{{ $member['bio'] }}</p>
      </div>
      @endforeach
    </div>
  </div>
</section>

{{-- WHY CHOOSE US --}}
<section class="bg-slate-50 py-24 fade-up">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="mx-auto max-w-3xl text-center">
            <span
                class="inline-flex rounded-full bg-cyan-100 px-4 py-1 text-xs font-bold uppercase tracking-widest text-cyan-700">
                Why Choose SkyLine
            </span>

            <h2 class="mt-5 text-3xl font-black tracking-tight text-slate-900 sm:text-4xl">
                More Than Just Car Rental
            </h2>

            <p class="mt-5 text-lg text-slate-600">
                We provide a complete transportation ecosystem designed for comfort,
                safety, and convenience.
            </p>
        </div>

        <div class="mt-16 grid gap-8 md:grid-cols-2 xl:grid-cols-4">

            {{-- Feature 1 --}}
            <div
                class="group relative overflow-hidden rounded-3xl border border-slate-200 bg-white p-8 shadow-sm transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl">

                <div
                    class="absolute right-0 top-0 h-24 w-24 translate-x-6 -translate-y-6 rounded-full bg-cyan-100 blur-2xl">
                </div>

                <div
                    class="flex h-16 w-16 items-center justify-center rounded-2xl bg-cyan-100 text-cyan-600 transition-all duration-300 group-hover:scale-110">
                    <i data-lucide="shield-check" class="h-8 w-8"></i>
                </div>

                <h3 class="mt-6 text-xl font-bold text-slate-900">
                    Safety First
                </h3>

                <p class="mt-3 text-slate-600 leading-relaxed">
                    Every vehicle is inspected regularly and every driver passes
                    strict verification checks.
                </p>
            </div>

            {{-- Feature 2 --}}
            <div
                class="group relative overflow-hidden rounded-3xl border border-slate-200 bg-white p-8 shadow-sm transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl">

                <div
                    class="absolute right-0 top-0 h-24 w-24 translate-x-6 -translate-y-6 rounded-full bg-cyan-100 blur-2xl">
                </div>

                <div
                    class="flex h-16 w-16 items-center justify-center rounded-2xl bg-cyan-100 text-cyan-600 transition-all duration-300 group-hover:scale-110">
                    <i data-lucide="headphones" class="h-8 w-8"></i>
                </div>

                <h3 class="mt-6 text-xl font-bold text-slate-900">
                    24/7 Support
                </h3>

                <p class="mt-3 text-slate-600 leading-relaxed">
                    Our support team is always available whenever you need help.
                </p>
            </div>

            {{-- Feature 3 --}}
            <div
                class="group relative overflow-hidden rounded-3xl border border-slate-200 bg-white p-8 shadow-sm transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl">

                <div
                    class="absolute right-0 top-0 h-24 w-24 translate-x-6 -translate-y-6 rounded-full bg-cyan-100 blur-2xl">
                </div>

                <div
                    class="flex h-16 w-16 items-center justify-center rounded-2xl bg-cyan-100 text-cyan-600 transition-all duration-300 group-hover:scale-110">
                    <i data-lucide="map-pinned" class="h-8 w-8"></i>
                </div>

                <h3 class="mt-6 text-xl font-bold text-slate-900">
                    Wide Coverage
                </h3>

                <p class="mt-3 text-slate-600 leading-relaxed">
                    Access vehicles and professional drivers across multiple cities.
                </p>
            </div>

            {{-- Feature 4 --}}
            <div
                class="group relative overflow-hidden rounded-3xl border border-slate-200 bg-white p-8 shadow-sm transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl">

                <div
                    class="absolute right-0 top-0 h-24 w-24 translate-x-6 -translate-y-6 rounded-full bg-cyan-100 blur-2xl">
                </div>

                <div
                    class="flex h-16 w-16 items-center justify-center rounded-2xl bg-cyan-100 text-cyan-600 transition-all duration-300 group-hover:scale-110">
                    <i data-lucide="wallet" class="h-8 w-8"></i>
                </div>

                <h3 class="mt-6 text-xl font-bold text-slate-900">
                    Transparent Pricing
                </h3>

                <p class="mt-3 text-slate-600 leading-relaxed">
                    No hidden charges. Clear pricing from booking to completion.
                </p>
            </div>

        </div>
    </div>
</section>


@push('scripts')
<script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- 2. Initialize the icons on the page -->
    <script>
      lucide.createIcons();
    </script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Fade-up observer
    const fadeElements = document.querySelectorAll('.fade-up');
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
        }
      });
    }, { threshold: 0.1 });
    fadeElements.forEach(el => observer.observe(el));

    // Counting animation for stats
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

    // FIXED: Adjusted targets from '.bg-slate-900' to modern matching identifier '.js-stats-section'
    const statsSection = document.querySelector('.js-stats-section');
    if (statsSection) {
      const statsObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            animateNumbers();
            statsObserver.unobserve(entry.target);
          }
        });
      }, { threshold: 0.3 });
      statsObserver.observe(statsSection);
    }
  });
</script>
@endpush

</x-user.layout>
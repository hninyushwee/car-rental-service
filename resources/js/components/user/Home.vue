<template>
  <div class="home-page">
    <!-- 1. HERO SECTION -->
    <section class="relative overflow-hidden bg-slate-950 pt-10 text-white lg:pt-32 fade-up">
      <div class="absolute inset-0 -z-10">
        <div class="absolute inset-0 bg-gradient-to-br from-slate-950/95 via-slate-950/80 to-slate-950/40"></div>
        <img 
          class="h-full w-full object-cover" 
          src="https://images.unsplash.com/photo-1542362567-b07e54358753?auto=format&fit=crop&w=1800&q=80" 
          alt="Premium Sports Car" 
        />
      </div>

      <div class="relative mx-auto grid max-w-7xl items-center gap-12 px-4 pb-18 sm:px-6 lg:grid-cols-[1fr_0.92fr] lg:px-8 lg:pb-22">
        <div class="transform transition-all duration-700 hover:translate-y-[-5px]">
          <p class="mb-4 inline-flex items-center gap-2 rounded-full bg-cyan-500/10 px-4 py-1.5 text-xs font-bold uppercase tracking-widest text-cyan-400 ring-1 ring-cyan-400/20 backdrop-blur-md">
            <i data-lucide="sparkles" class="h-4 w-4"></i> Premium mobility, simplified
          </p>
          <h1 class="max-w-3xl text-3xl font-black leading-tight sm:text-4xl lg:text-5xl tracking-tight text-white">
            Your Trusted <br>
            <span class="bg-gradient-to-r from-cyan-400 to-cyan-200 bg-clip-text text-transparent">Automotive Partner</span>
          </h1>
          <p class="mt-6 max-w-2xl leading-8 text-slate-200">
            Rent verified vehicles, book professional drivers, manage licensing needs, and explore premium automotive services from one polished platform.
          </p>
          
          <div class="mt-8 flex flex-col gap-4 sm:flex-row">
            <a href="#vehicles" class="group inline-flex items-center justify-center gap-2 rounded-xl bg-cyan-400 px-6 py-3.5 text-sm font-bold text-slate-950 shadow-lg shadow-cyan-400/20 transition-all duration-300 hover:bg-cyan-300 hover:shadow-cyan-400/40 hover:scale-105">
              Rent a Car <i data-lucide="arrow-right" class="h-4 w-4 transition-all duration-300 group-hover:translate-x-1"></i>
            </a>
            <a href="#services" class="group inline-flex items-center justify-center gap-2 rounded-xl border border-white/20 bg-white/5 px-6 py-3.5 text-sm font-bold text-white backdrop-blur-sm transition-all duration-300 hover:border-white/40 hover:bg-white/10">
              Explore Marketplace <i data-lucide="shopping-bag" class="h-4 w-4 transition-all duration-300 group-hover:rotate-12"></i>
            </a>
          </div>

          <div class="mt-4 grid gap-4 sm:grid-cols-2 border-t border-white/10 pt-8">
            <div class="flex items-center gap-3 text-sm font-medium text-slate-200 transition-all duration-300 hover:translate-x-1">
              <i data-lucide="check-circle-2" class="h-5 w-5 text-cyan-400"></i>Premium Fleet
            </div>
            <div class="flex items-center gap-3 text-sm font-medium text-slate-200 transition-all duration-300 hover:translate-x-1">
              <i data-lucide="check-circle-2" class="h-5 w-5 text-cyan-400"></i>Vetted Drivers
            </div>
            <div class="flex items-center gap-3 text-sm font-medium text-slate-200 transition-all duration-300 hover:translate-x-1">
              <i data-lucide="check-circle-2" class="h-5 w-5 text-cyan-400"></i>Secure Bookings
            </div>
            <div class="flex items-center gap-3 text-sm font-medium text-slate-200 transition-all duration-300 hover:translate-x-1">
              <i data-lucide="check-circle-2" class="h-5 w-5 text-cyan-400"></i>Licensing Help
            </div>
          </div>
        </div>

        <div class="relative">
          <div class="relative rounded-2xl border border-white/10 bg-white/5 p-3 shadow-2xl shadow-black/20 backdrop-blur-md transition-all duration-500 hover:scale-105 hover:shadow-cyan-500/20">
            <img 
              class="aspect-[4/3] w-full rounded-xl object-cover transition-all duration-700 hover:brightness-110" 
              src="https://images.unsplash.com/photo-1555215695-3004980ad54e?auto=format&fit=crop&w=600&q=80" 
              alt="Luxury Car"
            />
          </div>
          <div class="absolute -bottom-6 left-6 max-w-xs rounded-xl border border-slate-200 bg-white p-3 shadow-2xl transition-all duration-300 hover:shadow-cyan-500/10 hover:scale-105 backdrop-blur-md">
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

    <!-- 2. WHY SKYLINE -->
    <section class="bg-white py-12 fade-up">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto">
          <p class="text-xs font-bold uppercase tracking-widest text-cyan-600 bg-cyan-50 inline-block px-3 py-1 rounded-full">Why SkyLine</p>
          <h2 class="mt-4 text-3xl font-black text-slate-950 sm:text-4xl tracking-tight">Driven by excellence, trusted by thousands</h2>
          <p class="mt-4 text-slate-600 text-base leading-relaxed">We combine cutting-edge technology, absolute transparency, and top-tier customer service to give you the ultimate automotive experience.</p>
        </div>
        <div class="mt-10 grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
          <div v-for="feature in whyFeatures" :key="feature.id" class="group rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition-all duration-500 hover:-translate-y-3 hover:shadow-xl hover:border-cyan-300">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-cyan-50 text-cyan-600 transition-all duration-300 group-hover:bg-cyan-100 group-hover:scale-110">
              <i :data-lucide="feature.icon" class="h-6 w-6"></i>
            </div>
            <h3 class="mt-5 text-xl font-bold text-slate-900 group-hover:text-cyan-600 transition-colors">{{ feature.title }}</h3>
            <p class="mt-2 text-slate-600 text-sm leading-6">{{ feature.description }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- 3. FEATURED VEHICLES -->
    <section id="vehicles" class="bg-slate-100 py-12 fade-up">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-end gap-4 mb-10">
          <div class="text-left max-w-3xl">
            <p class="text-xs font-bold uppercase tracking-widest text-cyan-600 bg-cyan-50 inline-block px-3 py-1 rounded-full">Featured Fleet</p>
            <h2 class="mt-4 text-3xl font-black text-slate-950 sm:text-4xl tracking-tight">Ready For Your Next Booking</h2>
            <p class="mt-4 text-slate-600 text-base leading-relaxed">Impeccably maintained machinery. Pick your ideal ride from our premium tier offerings.</p>
          </div>
          <button class="rounded-xl bg-slate-950 px-6 py-3 text-sm font-bold text-white transition-all duration-300 hover:bg-slate-800 hover:scale-105 hover:shadow-xl shrink-0">View Full Fleet &rarr;</button>
        </div>
        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
          <article v-for="car in cars" :key="car.id" class="group overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition-all duration-500 hover:shadow-xl hover:-translate-y-2 hover:border-cyan-300">
            <div class="relative overflow-hidden">
              <img class="h-56 w-full object-cover transition-transform duration-700 group-hover:scale-110" :src="car.img" :alt="car.name" />
              <span class="absolute right-3 top-3 rounded-full bg-white/90 px-2.5 py-1 text-xs font-semibold text-slate-800 backdrop-blur-sm transition-all duration-300 group-hover:bg-cyan-400 group-hover:text-slate-900">{{ car.rating }} ⭐</span>
            </div>
            <div class="p-3">
              <h3 class="text-xl font-black text-slate-900 transition-colors group-hover:text-cyan-600">{{ car.name }}</h3>
              <p class="mt-2 text-sm text-slate-500 leading-relaxed">{{ car.desc }}</p>
              <div class="mt-5 flex items-center justify-between pt-4 border-t border-slate-100">
                <p class="font-black text-slate-950 text-lg">${{ car.price }}<span class="text-sm font-semibold text-slate-500">/day</span></p>
                <button class="rounded-xl bg-cyan-400 px-5 py-2.5 text-sm font-bold text-slate-950 transition-all duration-300 hover:bg-cyan-300 hover:scale-105 shadow-sm shadow-cyan-400/10">View Details</button>
              </div>
            </div>
          </article>
        </div>
      </div>
    </section>

    <!-- 4. SERVICES OVERVIEW -->
    <section id="services" class="bg-white py-12 fade-up">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-10">
          <p class="text-xs font-bold uppercase tracking-widest text-cyan-600 bg-cyan-50 inline-block px-3 py-1 rounded-full">Services Overview</p>
          <h2 class="mt-4 text-3xl font-black text-slate-950 sm:text-4xl tracking-tight">Complete Automotive Support</h2>
          <p class="mt-4 text-slate-600 text-base">Everything structural your driving ecosystem requires under a modern digital layout.</p>
        </div>
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
          <article v-for="service in services" :key="service.id" class="group rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition-all duration-500 hover:-translate-y-2 hover:shadow-xl hover:border-cyan-300 flex flex-col justify-between">
            <div>
              <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-cyan-50 text-cyan-600 transition-all duration-300 group-hover:bg-cyan-100 group-hover:scale-110">
                <i :data-lucide="service.icon" class="h-6 w-6"></i>
              </div>
              <h3 class="mt-5 text-lg font-black text-slate-900 group-hover:text-cyan-600 transition-colors">{{ service.title }}</h3>
              <p class="mt-3 text-sm leading-6 text-slate-600">{{ service.desc }}</p>
            </div>
            <button class="mt-6 text-sm font-bold text-cyan-600 transition-all duration-300 group-hover:text-cyan-800 group-hover:translate-x-1 inline-flex items-center gap-1 self-start">
              Learn More <i data-lucide="arrow-right" class="h-3 w-3"></i>
            </button>
          </article>
        </div>
      </div>
    </section>

    <!-- 5. PROFESSIONAL DRIVERS CAROUSEL -->
    <section class="bg-slate-100 py-12 fade-up">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-end gap-4 mb-10">
          <div class="text-left max-w-3xl">
            <p class="text-xs font-bold uppercase tracking-widest text-cyan-600 bg-cyan-50 inline-block px-3 py-1 rounded-full">Expert Drivers</p>
            <h2 class="mt-4 text-3xl font-black text-slate-950 sm:text-4xl tracking-tight">Meet Our Professional Chauffeurs</h2>
            <p class="mt-4 text-slate-600 text-base leading-relaxed">All drivers are deeply vetted, background-checked, and highly trained to ensure a reliable journey.</p>
          </div>
          <button class="rounded-xl bg-slate-950 px-6 py-3 text-sm font-bold text-white transition-all duration-300 hover:bg-slate-800 hover:scale-105 hover:shadow-xl shrink-0">View All Drivers &rarr;</button>
        </div>
        <div class="owl-carousel driver-carousel">
          <div v-for="driver in drivers" :key="driver.id" class="item px-2">
            <div class="bg-white rounded-2xl overflow-hidden border border-slate-200 shadow-md transition-all duration-300 hover:shadow-cyan-500/10 hover:-translate-y-2 hover:border-cyan-300">
              <img class="h-48 w-full object-cover transition-all duration-500" :src="driver.img" :alt="driver.name" />
              <div class="p-5">
                <h3 class="text-lg font-bold text-slate-900">{{ driver.name }}</h3>
                <p class="text-xs text-cyan-600 font-semibold mt-0.5">{{ driver.role }}</p>
                <div class="mt-3 flex flex-wrap gap-2 text-xs text-slate-500">
                  <span class="flex items-center gap-1"><i data-lucide="briefcase" class="h-3 w-3"></i> {{ driver.exp }}</span>
                  <span class="flex items-center gap-1"><i data-lucide="languages" class="h-3 w-3"></i> {{ driver.languages }}</span>
                </div>
                <div class="mt-5 flex justify-between items-center pt-3 border-t border-slate-100">
                  <div class="flex gap-0.5 text-cyan-500">
                    <i v-for="i in 5" :key="i" data-lucide="star" :class="`h-3.5 w-3.5 ${i <= driver.rating ? 'fill-current' : 'opacity-30'}`"></i>
                  </div>
                  <button class="bg-cyan-400 hover:bg-cyan-300 text-slate-950 text-xs font-bold px-4 py-2 rounded-xl transition-all duration-300 hover:scale-105 shadow-sm shadow-cyan-400/10">Book Now</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- 6. HOW IT WORKS -->
    <section class="bg-white py-12 fade-up">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto">
          <p class="text-xs font-bold uppercase tracking-widest text-cyan-600 bg-cyan-50 inline-block px-3 py-1 rounded-full">Simple Process</p>
          <h2 class="mt-4 text-3xl font-black text-slate-950 sm:text-4xl tracking-tight">How SkyLine works</h2>
          <p class="mt-4 text-slate-600 text-base">From simple initial search up to premium driving execution — entirely effortless.</p>
        </div>
        <div class="mt-10 grid gap-8 sm:grid-cols-3">
          <div v-for="step in howItWorks" :key="step.id" class="group text-center transition-all duration-500 hover:-translate-y-2">
            <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-cyan-50 text-cyan-600 transition-all duration-300 group-hover:bg-cyan-100 group-hover:scale-110">
              <i :data-lucide="step.icon" class="h-10 w-10"></i>
            </div>
            <h3 class="mt-5 text-xl font-bold text-slate-900 group-hover:text-cyan-600 transition-colors">{{ step.title }}</h3>
            <p class="mt-2 text-slate-600 text-sm leading-6 max-w-xs mx-auto">{{ step.description }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- 7. CARS FOR SALE -->
    <section id="sale" class="bg-slate-100 py-12 fade-up">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-end gap-4 mb-10">
          <div class="text-left max-w-3xl">
            <p class="text-xs font-bold uppercase tracking-widest text-cyan-600 bg-cyan-50 inline-block px-3 py-1 rounded-full">Cars For Sale</p>
            <h2 class="mt-4 text-3xl font-black text-slate-950 sm:text-4xl tracking-tight">Direct From Verified Sellers</h2>
            <p class="mt-4 text-slate-600 text-base">Every individual unit profile maintains clear independent structural data records.</p>
          </div>
          <button class="rounded-xl bg-slate-950 px-6 py-3 text-sm font-bold text-white transition-all duration-300 hover:bg-slate-800 hover:scale-105 hover:shadow-xl shrink-0">View All Listings &rarr;</button>
        </div>
        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
          <article v-for="vehicle in saleVehicles" :key="vehicle.id" class="group overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-md transition-all duration-500 hover:shadow-xl hover:-translate-y-2 hover:border-cyan-300">
            <div class="relative overflow-hidden">
              <img class="h-56 w-full object-cover transition-transform duration-700 group-hover:scale-110" :src="vehicle.img" :alt="vehicle.title" />
              <span class="absolute left-3 top-3 rounded-full bg-cyan-400 px-3 py-1 text-xs font-bold text-slate-900 shadow-md transition-all duration-300 group-hover:bg-cyan-500">For Sale</span>
            </div>
            <div class="p-5">
              <h3 class="text-xl font-black text-slate-900 transition-colors group-hover:text-cyan-600">{{ vehicle.title }}</h3>
              <p class="mt-1 text-sm text-slate-500">1.5L Turbo · {{ vehicle.miles }} miles</p>
              <div class="mt-4 flex flex-wrap gap-3 border-t border-slate-100 pt-4 text-xs text-slate-600">
                <div class="flex items-center gap-1"><i data-lucide="fuel" class="h-3.5 w-3.5"></i> {{ vehicle.mpg }}</div>
                <div class="flex items-center gap-1"><i data-lucide="gauge" class="h-3.5 w-3.5"></i> Automatic</div>
                <div class="flex items-center gap-1"><i data-lucide="calendar" class="h-3.5 w-3.5"></i> 2021</div>
                <div class="flex items-center gap-1"><i data-lucide="map-pin" class="h-3.5 w-3.5"></i> {{ vehicle.location }}</div>
              </div>
              <div class="mt-5 flex items-center justify-between pt-4 border-t border-slate-100">
                <p class="font-black text-slate-950 text-lg">${{ vehicle.price }}</p>
                <button class="rounded-xl bg-cyan-400 px-5 py-2.5 text-sm font-bold text-slate-950 transition-all duration-300 hover:bg-cyan-300 hover:scale-105 shadow-sm shadow-cyan-400/10">View Listing</button>
              </div>
            </div>
          </article>
        </div>
      </div>
    </section>

    <!-- 8. TRUST STATS -->
    <section id="about" class="bg-white py-12 fade-up">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-10">
          <p class="text-xs font-bold uppercase tracking-widest text-cyan-600 bg-cyan-50 inline-block px-3 py-1 rounded-full">SkyLine By The Numbers</p>
          <h2 class="mt-4 text-3xl font-black text-slate-950 sm:text-4xl tracking-tight">We Don't Just Talk – We Deliver</h2>
          <p class="mt-4 text-slate-600 text-base">Real figures, real trust, real results.</p>
        </div>
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
          <div v-for="stat in stats" :key="stat.id" class="group rounded-2xl border border-slate-200 p-6 text-center transition-all duration-500 hover:shadow-xl hover:-translate-y-2 hover:border-cyan-300">
            <p class="text-4xl font-black text-slate-950 transition-all duration-300 group-hover:text-cyan-600 group-hover:scale-110 inline-block">
              <span class="stat-number" :data-target="stat.target">0</span>{{ stat.suffix }}
            </p>
            <p class="mt-2 text-sm font-semibold text-slate-500 group-hover:text-cyan-500">{{ stat.label }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- 9. CONTACT CTA -->
    <section id="contact" class="py-12 fade-up">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="rounded-2xl bg-gradient-to-br from-slate-800 to-slate-950 px-6 py-10 shadow-2xl transition-all duration-500 hover:shadow-cyan-900/30 sm:px-10 lg:flex lg:items-center lg:justify-between">
          <div class="text-center lg:text-left">
            <h2 class="text-3xl font-black tracking-tight text-white">Need Immediate Assistance?</h2>
            <p class="mt-3 max-w-2xl text-slate-300 text-sm leading-relaxed">Our support infrastructure responds 24/7 regarding high-tier vehicle rentals, licensing tracking updates, and direct marketplace inquiries.</p>
          </div>
          <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-center lg:mt-0">
            <a href="mailto:support@skyline.demo" class="group inline-flex items-center justify-center gap-2 rounded-xl bg-cyan-400 px-6 py-3.5 text-sm font-bold text-slate-950 transition-all duration-300 hover:bg-cyan-300 hover:shadow-lg hover:shadow-cyan-400/30 hover:scale-105">
              Contact Us <i data-lucide="mail" class="h-4 w-4 transition-transform duration-300 group-hover:rotate-12"></i>
            </a>
            <button class="group rounded-xl border border-white/25 bg-white/5 px-6 py-3.5 text-sm font-bold text-white transition-all duration-300 hover:border-cyan-400/50 hover:text-cyan-100 hover:shadow-lg hover:shadow-cyan-400/10 hover:scale-105">
              Send Inquiry <i data-lucide="send" class="h-4 w-4 inline ml-1 transition-transform duration-300 group-hover:translate-x-1"></i>
            </button>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
export default {
  name: 'Home',
  data() {
    return {
      whyFeatures: [
        {
          id: 1,
          icon: 'clock',
          title: '24/7 Support',
          description: 'Our team is always ready to assist you, day or night, for any request or emergency road service.'
        },
        {
          id: 2,
          icon: 'shield',
          title: 'Fully Insured',
          description: 'Every premium vehicle and professional driver is fully insured, granting you absolute peace of mind.'
        },
        {
          id: 3,
          icon: 'map-pin',
          title: 'Wide Network',
          description: 'Operational in 50+ major cities, we seamlessly bring ultra-premium mobility wherever you land.'
        }
      ],
      cars: [
        {
          id: 1,
          name: 'Tesla Model 3',
          price: 89,
          rating: 4.9,
          img: 'https://images.unsplash.com/photo-1606664515524-ed2f786a0bd6?auto=format&fit=crop&w=900&q=80',
          desc: 'Electric excellence meets urban efficiency.'
        },
        {
          id: 2,
          name: 'BMW X5 Executive',
          price: 142,
          rating: 4.8,
          img: 'https://images.unsplash.com/photo-1617814076668-7772a3f5036a?auto=format&fit=crop&w=900&q=80',
          desc: 'Luxury SUV comfort, corporate prestige.'
        },
        {
          id: 3,
          name: 'Mercedes C-Class',
          price: 118,
          rating: 4.7,
          img: 'https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?auto=format&fit=crop&w=900&q=80',
          desc: 'Business class elegance redefined.'
        }
      ],
      services: [
        {
          id: 1,
          icon: 'car',
          title: 'Car Rental',
          desc: 'Flexible daily and weekly rentals from economy cars to executive SUVs.'
        },
        {
          id: 2,
          icon: 'user-check',
          title: 'Driver Service',
          desc: 'Vetted chauffeurs for corporate trips, events, airport transfers, and tours.'
        },
        {
          id: 3,
          icon: 'badge-check',
          title: 'License Services',
          desc: 'Guided assistance for renewals, paperwork, appointments, and compliance.'
        },
        {
          id: 4,
          icon: 'shopping-bag',
          title: 'Marketplace',
          desc: 'Browse inspected listings, accessories, service packages, and upgrades.'
        }
      ],
      drivers: [
        {
          id: 1,
          name: 'Michael Chen',
          role: 'Luxury Sedan Specialist',
          exp: '8 years',
          rating: 4.9,
          languages: '3 Languages',
          img: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=300&q=80'
        },
        {
          id: 2,
          name: 'Sophia Rodriguez',
          role: 'Executive Chauffeur',
          exp: '12 years',
          rating: 5.0,
          languages: '4 Languages',
          img: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=300&q=80'
        },
        {
          id: 3,
          name: 'David Kim',
          role: 'Airport Transfer Pro',
          exp: '6 years',
          rating: 4.8,
          languages: '2 Languages',
          img: 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=300&q=80'
        },
        {
          id: 4,
          name: 'Emma Wilson',
          role: 'Corporate Driver',
          exp: '10 years',
          rating: 4.9,
          languages: '3 Languages',
          img: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=300&q=80'
        },
        {
          id: 5,
          name: 'James O\'Connor',
          role: 'VIP Chauffeur',
          exp: '15 years',
          rating: 5.0,
          languages: '5 Languages',
          img: 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=300&q=80'
        }
      ],
      howItWorks: [
        {
          id: 1,
          icon: 'search',
          title: '1. Choose a vehicle',
          description: 'Browse our fleet of premium cars, SUVs, and executive sedans.'
        },
        {
          id: 2,
          icon: 'calendar-check',
          title: '2. Book instantly',
          description: 'Select dates, add your preferred driver profile, and confirm securely.'
        },
        {
          id: 3,
          icon: 'car-front',
          title: '3. Drive & enjoy',
          description: 'Pick up keys easily or get chauffeured directly to your location.'
        }
      ],
      saleVehicles: [
        {
          id: 1,
          title: '2021 Honda Accord EX-L',
          miles: '28,400',
          price: '24,500',
          location: 'Austin, TX',
          mpg: '32 MPG',
          img: 'https://images.unsplash.com/photo-1580273916550-e323be2ae537?auto=format&fit=crop&w=900&q=80'
        },
        {
          id: 2,
          title: '2022 Audi A4 Premium',
          miles: '19,100',
          price: '32,800',
          location: 'Miami, FL',
          mpg: '31 MPG',
          img: 'https://images.unsplash.com/photo-1606016159991-dfe12bb70d5f?auto=format&fit=crop&w=900&q=80'
        },
        {
          id: 3,
          title: '2020 BMW 3 Series',
          miles: '34,200',
          price: '28,900',
          location: 'Los Angeles, CA',
          mpg: '30 MPG',
          img: 'https://images.unsplash.com/photo-1556189250-72ba954cff0d?auto=format&fit=crop&w=900&q=80'
        }
      ],
      stats: [
        {
          id: 1,
          target: 500,
          suffix: '+',
          label: 'Vehicles'
        },
        {
          id: 2,
          target: 1000,
          suffix: '+',
          label: 'Happy Customers'
        },
        {
          id: 3,
          target: 24,
          suffix: '/7',
          label: 'Support'
        },
        {
          id: 4,
          target: 100,
          suffix: '%',
          label: 'Secure Payments'
        }
      ]
    }
  },
  mounted() {
    this.initCarousel();
    this.initFadeUpAnimation();
    this.initStatNumbers();
  },
  methods: {
    initCarousel() {
      // Initialize Owl Carousel for drivers
      if (typeof jQuery !== 'undefined' && jQuery().owlCarousel) {
        jQuery('.driver-carousel').owlCarousel({
          loop: true,
          margin: 24,
          nav: true,
          dots: true,
          autoplay: true,
          autoplayTimeout: 5000,
          autoplayHoverPause: true,
          responsive: {
            0: { items: 1, margin: 16 },
            640: { items: 2, margin: 20 },
            1024: { items: 3, margin: 24 },
            1280: { items: 4, margin: 24 }
          }
        });
      }
    },
    initFadeUpAnimation() {
      // Fade-up animation with Intersection Observer
      const fadeElements = document.querySelectorAll('.fade-up');
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('visible');
          }
        });
      }, { threshold: 0.1 });
      fadeElements.forEach(el => observer.observe(el));
    },
    initStatNumbers() {
      // Animate numbers when stats section is visible
      const statsSection = document.querySelector('#about');
      if (statsSection) {
        const statsObserver = new IntersectionObserver((entries) => {
          entries.forEach(entry => {
            if (entry.isIntersecting) {
              this.animateNumbers();
              statsObserver.unobserve(entry.target);
            }
          });
        }, { threshold: 0.5 });
        statsObserver.observe(statsSection);
      }
    },
    animateNumbers() {
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
  }
}
</script>

<style scoped>
/* Fade-up animation */
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

/* Owl Carousel custom nav & dots */
.driver-carousel .owl-nav button {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  width: 44px;
  height: 44px;
  border-radius: 50%;
  background: white !important;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 28px !important;
  color: #0f172a !important;
}

.driver-carousel .owl-nav button:hover {
  background: #06b6d4 !important;
  color: white !important;
  box-shadow: 0 6px 16px rgba(6, 182, 212, 0.3);
  transform: translateY(-50%) scale(1.05);
}

.driver-carousel .owl-nav button.owl-prev { left: -22px; }
.driver-carousel .owl-nav button.owl-next { right: -22px; }

.driver-carousel .owl-dots {
  margin-top: 28px;
  display: flex;
  justify-content: center;
  gap: 12px;
}

.driver-carousel .owl-dot {
  width: 12px;
  height: 12px;
  border-radius: 50%;
  background-color: #94a3b8 !important;
  transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
  cursor: pointer;
}

.driver-carousel .owl-dot.active {
  width: 32px;
  border-radius: 20px;
  background: linear-gradient(135deg, #06b6d4, #0891b2) !important;
  box-shadow: 0 0 8px rgba(6, 182, 212, 0.5);
}

.driver-carousel .owl-dot:hover {
  background-color: #64748b !important;
  transform: scale(1.3);
}

@media (max-width: 768px) {
  .driver-carousel .owl-nav button {
    width: 36px;
    height: 36px;
    font-size: 22px !important;
  }
  .driver-carousel .owl-nav button.owl-prev { left: -12px; }
  .driver-carousel .owl-nav button.owl-next { right: -12px; }
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

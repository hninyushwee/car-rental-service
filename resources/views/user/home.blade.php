
<x-user.layout>
      <!-- Hero: two-column desktop layout that stacks naturally on smaller screens. -->
      <section id="home" class="relative overflow-hidden bg-slate-950 pt-28 text-white lg:pt-32">
        <div class="absolute inset-0 opacity-40">
          <img class="h-full w-full object-cover" src="https://images.unsplash.com/photo-1542362567-b07e54358753?auto=format&fit=crop&w=1800&q=80" alt="" />
        </div>
        <div class="absolute inset-0 bg-gradient-to-br from-slate-950 via-slate-950/50 to-slate-900/40"></div>

        <div class="relative mx-auto grid max-w-7xl items-center gap-12 px-4 pb-20 pt-12 sm:px-6 lg:grid-cols-[1fr_0.92fr] lg:px-8 lg:pb-28">
          <div>
            <p class="mb-4 inline-flex items-center gap-2 rounded bg-white/10 px-3 py-1 text-sm font-semibold text-cyan-100 ring-1 ring-white/15">
              <i data-lucide="sparkles" class="h-4 w-4"></i> Premium mobility, simplified
            </p>
            <h1 class="max-w-3xl text-4xl font-black leading-tight sm:text-5xl lg:text-6xl">Your Trusted Automotive Partner</h1>
            <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-200">Rent verified vehicles, book professional drivers, manage licensing needs, and explore premium automotive services from one polished portal.</p>
            <div class="mt-8 flex flex-col gap-3 sm:flex-row">
              <a href="#vehicles" class="inline-flex items-center justify-center gap-2 rounded bg-cyan-400 px-6 py-3 text-sm font-bold text-slate-950 shadow-glow transition hover:bg-cyan-300">
                Rent a Car <i data-lucide="arrow-right" class="h-4 w-4"></i>
              </a>
              <a href="#services" class="inline-flex items-center justify-center gap-2 rounded border border-white/25 px-6 py-3 text-sm font-bold text-white transition hover:border-cyan-200 hover:text-cyan-100">
                Explore Marketplace <i data-lucide="shopping-bag" class="h-4 w-4"></i>
              </a>
            </div>
            <div class="mt-8 grid gap-3 sm:grid-cols-2">
              <div class="flex items-center gap-2 text-sm font-semibold text-slate-200"><i data-lucide="check-circle-2" class="h-5 w-5 text-cyan-300"></i>Professional Drivers</div>
              <div class="flex items-center gap-2 text-sm font-semibold text-slate-200"><i data-lucide="check-circle-2" class="h-5 w-5 text-cyan-300"></i>Verified Vehicles</div>
              <div class="flex items-center gap-2 text-sm font-semibold text-slate-200"><i data-lucide="check-circle-2" class="h-5 w-5 text-cyan-300"></i>Secure Payments</div>
              <div class="flex items-center gap-2 text-sm font-semibold text-slate-200"><i data-lucide="check-circle-2" class="h-5 w-5 text-cyan-300"></i>License Assistance</div>
            </div>
          </div>

          <div class="relative">
            <div class="relative rounded border border-white/15 bg-white/10 p-3 shadow-2xl shadow-cyan-950/40 backdrop-blur">
              <img class="aspect-[4/3] w-full rounded object-cover" src="https://images.unsplash.com/photo-1555215695-3004980ad54e?auto=format&fit=crop&w=1200&q=85" alt="Modern luxury SUV parked in a city" />
            </div>
            <div class="absolute -bottom-6 left-6 max-w-xs rounded border border-slate-200 bg-white p-4 text-slate-950 shadow-2xl">
              <div class="flex items-center gap-3">
                <span class="grid h-11 w-11 place-items-center rounded bg-cyan-100 text-cyan-700"><i data-lucide="shield-check" class="h-5 w-5"></i></span>
                <div>
                  <p class="text-sm font-black">Verified Fleet</p>
                  <p class="text-xs text-slate-500">Inspected, insured, and ready today.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
 
      <!-- Featured vehicles: sample inventory cards for the landing page. -->
      <section id="vehicles" class="bg-slate-100 py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
            <div>
              <p class="text-sm font-bold uppercase tracking-widest text-cyan-600">Featured Vehicles</p>
              <h2 class="mt-3 text-3xl font-black text-slate-950 sm:text-4xl">Ready for your next booking</h2>
            </div>
            <button class="rounded bg-slate-950 px-5 py-3 text-sm font-bold text-white transition hover:bg-slate-800">View Full Fleet</button>
          </div>
          <div class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            <article class="overflow-hidden rounded border border-slate-200 bg-white shadow-sm transition hover:shadow-xl hover:-translate-y-1">
              <div class="relative">
                <img class="h-56 w-full object-cover" src="https://images.unsplash.com/photo-1606664515524-ed2f786a0bd6?auto=format&fit=crop&w=900&q=80" alt="Tesla Model 3" />
                <span class="absolute right-3 top-3 rounded-full bg-white/90 px-2 py-0.5 text-xs font-semibold text-slate-800 backdrop-blur-sm">⭐ 4.9</span>
              </div>
                <div class="p-5">
                <h3 class="text-lg font-black">Tesla Model 3</h3>
                <p class="mt-2 text-sm text-slate-500">Electric sedan, autopilot ready</p>
                <div class="mt-5 flex items-center justify-between">
                  <p class="font-black text-slate-950">$89<span class="text-sm font-semibold text-slate-500">/day</span></p>
                  <button class="rounded bg-cyan-400 px-4 py-2 text-sm font-bold text-slate-950 hover:bg-cyan-300">View Details</button>
                </div>  
              </div>
            </article>
            <article class="overflow-hidden rounded border border-slate-200 bg-white shadow-sm transition hover:shadow-xl hover:-translate-y-1">
              <div class="relative">
                <img class="h-56 w-full object-cover" src="https://images.unsplash.com/photo-1606664515524-ed2f786a0bd6?auto=format&fit=crop&w=900&q=80" alt="Tesla Model 3" />
                <span class="absolute right-3 top-3 rounded-full bg-white/90 px-2 py-0.5 text-xs font-semibold text-slate-800 backdrop-blur-sm">⭐ 4.9</span>
              </div>
                <div class="p-5">
                <h3 class="text-lg font-black">Tesla Model 3</h3>
                <p class="mt-2 text-sm text-slate-500">Electric sedan, autopilot ready</p>
                <div class="mt-5 flex items-center justify-between">
                  <p class="font-black text-slate-950">$89<span class="text-sm font-semibold text-slate-500">/day</span></p>
                  <button class="rounded bg-cyan-400 px-4 py-2 text-sm font-bold text-slate-950 hover:bg-cyan-300">View Details</button>
                </div>  
              </div>
            </article>
            <article class="overflow-hidden rounded border border-slate-200 bg-white shadow-sm transition hover:shadow-xl hover:-translate-y-1">
              <div class="relative">
                <img class="h-56 w-full object-cover" src="https://images.unsplash.com/photo-1606664515524-ed2f786a0bd6?auto=format&fit=crop&w=900&q=80" alt="Tesla Model 3" />
                <span class="absolute right-3 top-3 rounded-full bg-white/90 px-2 py-0.5 text-xs font-semibold text-slate-800 backdrop-blur-sm">⭐ 4.9</span>
              </div>
                <div class="p-5">
                <h3 class="text-lg font-black">Tesla Model 3</h3>
                <p class="mt-2 text-sm text-slate-500">Electric sedan, autopilot ready</p>
                <div class="mt-5 flex items-center justify-between">
                  <p class="font-black text-slate-950">$89<span class="text-sm font-semibold text-slate-500">/day</span></p>
                  <button class="rounded bg-cyan-400 px-4 py-2 text-sm font-bold text-slate-950 hover:bg-cyan-300">View Details</button>
                </div>  
              </div>
            </article>
            
          </div>
        </div>
      </section>

      <!-- Services overview: four core SkyLine offerings. -->
      <section id="services" class="bg-white py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div class="max-w-2xl">
            <p class="text-sm font-bold uppercase tracking-widest text-cyan-600">Services Overview</p>
            <h2 class="mt-3 text-3xl font-black text-slate-950 sm:text-4xl">Complete automotive support in one place</h2>
          </div>
          <div class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            <article class="rounded border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
              <i data-lucide="car" class="h-9 w-9 text-cyan-600"></i>
              <h3 class="mt-5 text-lg font-black">Car Rental</h3>
              <p class="mt-3 text-sm leading-6 text-slate-600">Flexible daily and weekly rentals from economy cars to executive SUVs.</p>
              <button class="mt-5 text-sm font-bold text-cyan-700 hover:text-cyan-900">Learn More</button>
            </article>
            <article class="rounded border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
              <i data-lucide="user-check" class="h-9 w-9 text-cyan-600"></i>
              <h3 class="mt-5 text-lg font-black">Driver Service</h3>
              <p class="mt-3 text-sm leading-6 text-slate-600">Vetted chauffeurs for corporate trips, events, airport transfers, and tours.</p>
              <button class="mt-5 text-sm font-bold text-cyan-700 hover:text-cyan-900">Learn More</button>
            </article>
            <article class="rounded border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
              <i data-lucide="badge-check" class="h-9 w-9 text-cyan-600"></i>
              <h3 class="mt-5 text-lg font-black">License Services</h3>
              <p class="mt-3 text-sm leading-6 text-slate-600">Guided assistance for renewals, paperwork, appointments, and compliance.</p>
              <button class="mt-5 text-sm font-bold text-cyan-700 hover:text-cyan-900">Learn More</button>
            </article>
            <article class="rounded border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
              <i data-lucide="shopping-bag" class="h-9 w-9 text-cyan-600"></i>
              <h3 class="mt-5 text-lg font-black">Marketplace</h3>
              <p class="mt-3 text-sm leading-6 text-slate-600">Browse inspected listings, accessories, service packages, and upgrades.</p>
              <button class="mt-5 text-sm font-bold text-cyan-700 hover:text-cyan-900">Learn More</button>
            </article>
          </div>
        </div>
      </section>

      
      <!-- User A's Car Listings for Sale -->
      <section id="sale" class="bg-slate-100 py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div class="flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-end">
            <div>
              <p class="text-sm font-bold uppercase tracking-widest text-cyan-600">Cars for Sale </p>
              <h2 class="mt-3 text-3xl font-black text-slate-950 sm:text-4xl">Direct from verified seller</h2>
            </div>
            <button class="rounded bg-slate-950 px-5 py-3 text-sm font-bold text-white transition hover:bg-slate-800">
              View all listings
            </button>
          </div>
          <div class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            <article class="overflow-hidden rounded border border-slate-200 bg-white shadow-sm transition hover:shadow-xl hover:-translate-y-1">
              <div class="relative">
                <img class="h-56 w-full object-cover" src="https://images.unsplash.com/photo-1580273916550-e323be2ae537?auto=format&fit=crop&w=900&q=80" alt="2021 Honda Accord" />
                <span class="absolute left-3 top-3 rounded-full bg-cyan-400 px-3 py-1 text-xs font-bold text-slate-900 shadow-md">For Sale</span>
              </div>
              <div class="p-5">
                <div class="flex items-start justify-between">
                  <div>
                    <h3 class="text-xl font-black text-slate-900">2021 Honda Accord EX-L</h3>
                    <p class="mt-1 text-sm text-slate-500">1.5L Turbo · 28,400 miles</p>
                  </div>
                </div>
                <div class="mt-4 flex flex-wrap gap-3 border-t border-slate-100 pt-4 text-xs text-slate-600">
                  <div class="flex items-center gap-1"><i data-lucide="fuel" class="h-3.5 w-3.5"></i> 32 MPG</div>
                  <div class="flex items-center gap-1"><i data-lucide="gauge" class="h-3.5 w-3.5"></i> Automatic</div>
                  <div class="flex items-center gap-1"><i data-lucide="calendar" class="h-3.5 w-3.5"></i> 2021</div>
                  <div class="flex items-center gap-1"><i data-lucide="map-pin" class="h-3.5 w-3.5"></i> Austin, TX</div>
                </div>
                <div class="mt-5 flex items-center justify-between">
                  <p class="font-black text-slate-950">$89<span class="text-sm font-semibold text-slate-500">/day</span></p>
                  <button class="rounded bg-cyan-400 px-4 py-2 text-sm font-bold text-slate-950 hover:bg-cyan-300">Booking</button>
                </div> 
              </div>
            </article>
            <article class="overflow-hidden rounded border border-slate-200 bg-white shadow-sm transition hover:shadow-xl hover:-translate-y-1">
              <div class="relative">
                <img class="h-56 w-full object-cover" src="https://images.unsplash.com/photo-1580273916550-e323be2ae537?auto=format&fit=crop&w=900&q=80" alt="2021 Honda Accord" />
                <span class="absolute left-3 top-3 rounded-full bg-cyan-400 px-3 py-1 text-xs font-bold text-slate-900 shadow-md">For Sale</span>
              </div>
              <div class="p-5">
                <div class="flex items-start justify-between">
                  <div>
                    <h3 class="text-xl font-black text-slate-900">2021 Honda Accord EX-L</h3>
                    <p class="mt-1 text-sm text-slate-500">1.5L Turbo · 28,400 miles</p>
                  </div>
                </div>
                <div class="mt-4 flex flex-wrap gap-3 border-t border-slate-100 pt-4 text-xs text-slate-600">
                  <div class="flex items-center gap-1"><i data-lucide="fuel" class="h-3.5 w-3.5"></i> 32 MPG</div>
                  <div class="flex items-center gap-1"><i data-lucide="gauge" class="h-3.5 w-3.5"></i> Automatic</div>
                  <div class="flex items-center gap-1"><i data-lucide="calendar" class="h-3.5 w-3.5"></i> 2021</div>
                  <div class="flex items-center gap-1"><i data-lucide="map-pin" class="h-3.5 w-3.5"></i> Austin, TX</div>
                </div>
                <div class="mt-5 flex items-center justify-between">
                  <p class="font-black text-slate-950">$89<span class="text-sm font-semibold text-slate-500">/day</span></p>
                  <button class="rounded bg-cyan-400 px-4 py-2 text-sm font-bold text-slate-950 hover:bg-cyan-300">Booking</button>
                </div> 
              </div>
            </article>
            <article class="overflow-hidden rounded border border-slate-200 bg-white shadow-sm transition hover:shadow-xl hover:-translate-y-1">
              <div class="relative">
                <img class="h-56 w-full object-cover" src="https://images.unsplash.com/photo-1580273916550-e323be2ae537?auto=format&fit=crop&w=900&q=80" alt="2021 Honda Accord" />
                <span class="absolute left-3 top-3 rounded-full bg-cyan-400 px-3 py-1 text-xs font-bold text-slate-900 shadow-md">For Sale</span>
              </div>
              <div class="p-5">
                <div class="flex items-start justify-between">
                  <div>
                    <h3 class="text-xl font-black text-slate-900">2021 Honda Accord EX-L</h3>
                    <p class="mt-1 text-sm text-slate-500">1.5L Turbo · 28,400 miles</p>
                  </div>
                </div>
                <div class="mt-4 flex flex-wrap gap-3 border-t border-slate-100 pt-4 text-xs text-slate-600">
                  <div class="flex items-center gap-1"><i data-lucide="fuel" class="h-3.5 w-3.5"></i> 32 MPG</div>
                  <div class="flex items-center gap-1"><i data-lucide="gauge" class="h-3.5 w-3.5"></i> Automatic</div>
                  <div class="flex items-center gap-1"><i data-lucide="calendar" class="h-3.5 w-3.5"></i> 2021</div>
                  <div class="flex items-center gap-1"><i data-lucide="map-pin" class="h-3.5 w-3.5"></i> Austin, TX</div>
                </div>
                <div class="mt-5 flex items-center justify-between">
                  <p class="font-black text-slate-950">$89<span class="text-sm font-semibold text-slate-500">/day</span></p>
                  <button class="rounded bg-cyan-400 px-4 py-2 text-sm font-bold text-slate-950 hover:bg-cyan-300">Booking</button>
                </div> 
              </div>
            </article>
          </div>


        </div>
      </section>
      <!-- Trust stats: compact proof points for scanning. -->
      <section id="about" class="bg-white py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <div class="rounded border border-slate-200 p-6 text-center">
              <p class="text-4xl font-black text-slate-950">500+</p>
              <p class="mt-2 text-sm font-semibold text-slate-500">Vehicles</p>
            </div>
            <div class="rounded border border-slate-200 p-6 text-center">
              <p class="text-4xl font-black text-slate-950">1000+</p>
              <p class="mt-2 text-sm font-semibold text-slate-500">Happy Customers</p>
            </div>
            <div class="rounded border border-slate-200 p-6 text-center">
              <p class="text-4xl font-black text-slate-950">24/7</p>
              <p class="mt-2 text-sm font-semibold text-slate-500">Support</p>
            </div>
            <div class="rounded border border-slate-200 p-6 text-center">
              <p class="text-4xl font-black text-slate-950">100%</p>
              <p class="mt-2 text-sm font-semibold text-slate-500">Secure Payments</p>
            </div>
          </div>
        </div>
      </section>

      <!-- Contact CTA: high-contrast support banner. -->
      <section id="contact" class="bg-white py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div class="rounded bg-slate-950 px-6 py-10 text-white shadow-2xl sm:px-10 lg:flex lg:items-center lg:justify-between">
            <div>
              <h2 class="text-3xl font-black">Need Assistance?</h2>
              <p class="mt-3 max-w-2xl text-slate-300">Our support team can help with bookings, licensing, driver assignments, and marketplace inquiries.</p>
            </div>
            <div class="mt-6 flex flex-col gap-3 sm:flex-row lg:mt-0">
              <a href="mailto:support@skyline.demo" class="inline-flex items-center justify-center rounded bg-cyan-400 px-5 py-3 text-sm font-bold text-slate-950 hover:bg-cyan-300">Contact Us</a>
              <button class="rounded border border-white/25 px-5 py-3 text-sm font-bold text-white hover:border-cyan-200 hover:text-cyan-100">Send Inquiry</button>
            </div>
          </div>
        </div>
      </section>
    </main>
</x-user.layout>
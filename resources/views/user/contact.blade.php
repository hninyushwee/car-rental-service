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
  /* Smooth Accordion Panel transition overrides */
  .accordion-content {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  }
</style>
@endpush

{{-- HERO SECTION --}}
<section data-hero-section class="relative overflow-hidden bg-slate-950 pt-24 text-white lg:pt-32 pb-24 lg:pb-36 fade-up">
  <div class="absolute inset-0 -z-10">
    <div class="absolute inset-0 bg-gradient-to-b from-slate-950/80 via-slate-950/90 to-slate-950"></div>
    <img class="h-full w-full object-cover opacity-45" src="https://images.unsplash.com/photo-1449965408869-eaa3f722e40d?auto=format&fit=crop&w=1800&q=80" alt="Customer support background" />
  </div>
  <div class="relative mx-auto max-w-7xl px-4 pb-14 text-center sm:px-6 lg:px-8 lg:pb-18">
    <p class="mb-5 inline-flex items-center gap-2 rounded-full bg-cyan-500/10 px-4 py-1.5 text-xs font-bold uppercase tracking-widest text-cyan-400 ring-1 ring-cyan-400/20 backdrop-blur-md">
      <i data-lucide="phone" class="h-4 w-4"></i> Get in touch
    </p>
    <h1 class="text-4xl font-black tracking-tight sm:text-5xl lg:text-6xl max-w-4xl mx-auto leading-tight">
      We’re here to assist your <br><span class="bg-gradient-to-r from-cyan-400 via-cyan-200 to-white bg-clip-text text-transparent">premium journey</span>
    </h1>
    <p class="mt-6 max-w-2xl mx-auto text-base sm:text-lg leading-relaxed text-slate-300">
      Have questions about our fleet, bespoke driver packages, or enterprise sales? Drop us a line and let our concierge team handle the rest.
    </p>
  </div>
</section>

{{-- CONTACT CORE: FORM & CARDS GRID --}}
<section class="relative bg-white pt-24 pb-12 z-20 fade-up">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="grid gap-12 lg:grid-cols-12 lg:items-start">
      
      <!-- Contact Form Container -->
      <div class="rounded-3xl bg-white p-6 shadow-xl shadow-slate-100/70 border border-slate-100 lg:col-span-7 sm:p-10">
        <h2 class="text-2xl font-black text-slate-900 tracking-tight sm:text-3xl">Send us a message</h2>
        <p class="mt-2 text-sm text-slate-500">Expect a personalized response from our concierge team within 24 hours.</p>
        
        <form class="mt-8 space-y-6">
          <div class="grid gap-5 sm:grid-cols-2">
            <div>
              <label class="block text-xs font-bold uppercase tracking-wide text-slate-700 mb-2">First name</label>
              <input type="text" required class="w-full rounded-xl border border-slate-200/80 bg-slate-50/50 px-4 py-3 text-sm transition focus:border-cyan-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-cyan-500/10" placeholder="John">
            </div>
            <div>
              <label class="block text-xs font-bold uppercase tracking-wide text-slate-700 mb-2">Last name</label>
              <input type="text" required class="w-full rounded-xl border border-slate-200/80 bg-slate-50/50 px-4 py-3 text-sm transition focus:border-cyan-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-cyan-500/10" placeholder="Doe">
            </div>
          </div>
          
          <div class="grid gap-5 sm:grid-cols-2">
            <div>
              <label class="block text-xs font-bold uppercase tracking-wide text-slate-700 mb-2">Email address</label>
              <input type="email" required class="w-full rounded-xl border border-slate-200/80 bg-slate-50/50 px-4 py-3 text-sm transition focus:border-cyan-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-cyan-500/10" placeholder="john@example.com">
            </div>
            <div>
              <label class="block text-xs font-bold uppercase tracking-wide text-slate-700 mb-2">Phone number <span class="text-slate-400 font-normal">(optional)</span></label>
              <input type="tel" class="w-full rounded-xl border border-slate-200/80 bg-slate-50/50 px-4 py-3 text-sm transition focus:border-cyan-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-cyan-500/10" placeholder="+1 (555) 000-0000">
            </div>
          </div>
          
          <div>
            <label class="block text-xs font-bold uppercase tracking-wide text-slate-700 mb-2">Inquiry Type</label>
            <div class="relative">
              <select class="w-full appearance-none rounded-xl border border-slate-200/80 bg-slate-50/50 px-4 py-3 text-sm transition focus:border-cyan-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-cyan-500/10 text-slate-800">
                <option>General inquiry</option>
                <option>Booking support & changes</option>
                <option>Chauffeur & driver services</option>
                <option>Corporate accounts</option>
                <option>Marketplace partnerships</option>
              </select>
              <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                <i data-lucide="chevron-down" class="h-4 w-4"></i>
              </div>
            </div>
          </div>
          
          <div>
            <label class="block text-xs font-bold uppercase tracking-wide text-slate-700 mb-2">Message</label>
            <textarea rows="4" required class="w-full rounded-xl border border-slate-200/80 bg-slate-50/50 px-4 py-3 text-sm transition focus:border-cyan-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-cyan-500/10" placeholder="Tell us how we can help make your journey perfect..."></textarea>
          </div>
          
          <button type="submit" class="group inline-flex items-center justify-center gap-2 rounded-xl bg-cyan-400 px-6 py-3.5 text-sm font-bold text-slate-950 shadow-lg shadow-cyan-400/20 transition-all duration-300 hover:bg-cyan-300 hover:scale-[1.02] w-full sm:w-auto">
            Send Message <i data-lucide="send" class="h-4 w-4 transition-transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5"></i>
          </button>
        </form>
      </div>

      <!-- Modern Info Panel Cards Block -->
      <div class="space-y-6 lg:col-span-5">
        {{-- Card 1: Map/Location --}}
        <div class="group rounded-2xl border border-slate-100 bg-slate-50/70 p-6 transition-all duration-300 hover:bg-white hover:shadow-xl hover:shadow-slate-100/80">
          <div class="flex items-start gap-4">
            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-cyan-500/10 text-cyan-600 transition-colors group-hover:bg-cyan-500 group-hover:text-white">
              <i data-lucide="map-pin" class="h-5 w-5"></i>
            </div>
            <div>
              <h3 class="text-lg font-bold text-slate-900">Headquarters</h3>
              <p class="mt-1.5 text-slate-600 text-sm leading-relaxed">
                123 Innovation Drive, Suite 400<br>San Francisco, CA 94105
              </p>
              <a href="#operational-hub" class="mt-3 inline-flex items-center gap-1 text-xs font-bold text-cyan-600 uppercase tracking-wider hover:text-cyan-700">
                View layout below <i data-lucide="arrow-right" class="h-3 w-3"></i>
              </a>
            </div>
          </div>
        </div>

        {{-- Card 2: Phone Hub --}}
        <div class="group rounded-2xl border border-slate-100 bg-slate-50/70 p-6 transition-all duration-300 hover:bg-white hover:shadow-xl hover:shadow-slate-100/80">
          <div class="flex items-start gap-4">
            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-cyan-500/10 text-cyan-600 transition-colors group-hover:bg-cyan-500 group-hover:text-white">
              <i data-lucide="phone" class="h-5 w-5"></i>
            </div>
            <div>
              <h3 class="text-lg font-bold text-slate-900">Call center</h3>
              <div class="mt-1.5 space-y-1 text-slate-600 text-sm">
                <p><span class="font-medium text-slate-800">Concierge Desk:</span> +1 (800) 123-SKYLINE</p>
                <p><span class="font-medium text-slate-800">24/7 Support Roadside:</span> +1 (800) 555-0199</p>
              </div>
            </div>
          </div>
        </div>

        {{-- Card 3: Email Channels --}}
        <div class="group rounded-2xl border border-slate-100 bg-slate-50/70 p-6 transition-all duration-300 hover:bg-white hover:shadow-xl hover:shadow-slate-100/80">
          <div class="flex items-start gap-4">
            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-cyan-500/10 text-cyan-600 transition-colors group-hover:bg-cyan-500 group-hover:text-white">
              <i data-lucide="mail" class="h-5 w-5"></i>
            </div>
            <div>
              <h3 class="text-lg font-bold text-slate-900">Digital channels</h3>
              <div class="mt-1.5 space-y-1 text-slate-600 text-sm">
                <p><span class="font-medium text-slate-800">General Inquiries:</span> hello@skyline.demo</p>
                <p><span class="font-medium text-slate-800">Booking Adjustments:</span> support@skyline.demo</p>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

{{-- ALIGNED OPERATIONAL HUB: HOURS & COMPACT GOOGLE MAP SIDE-BY-SIDE --}}
<section id="operational-hub" class="bg-slate-50 py-20 fade-up">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="text-center max-w-3xl mx-auto mb-12">
      <p class="text-xs font-bold uppercase tracking-widest text-cyan-600 bg-cyan-100/60 inline-block px-3 py-1 rounded-full">Availability & Location</p>
      <h2 class="mt-4 text-3xl font-black text-slate-950 tracking-tight sm:text-4xl">Hours & Flagship Location</h2>
    </div>
    
    <div class="grid gap-8 lg:grid-cols-2 lg:items-stretch">
      {{-- Operational Windows Card --}}
      <div class="flex flex-col justify-between rounded-3xl bg-white p-6 shadow-sm border border-slate-200/60 sm:p-8">
        <div>
          <h3 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
            <i data-lucide="clock" class="h-5 w-5 text-cyan-500"></i> Office Schedule
          </h3>
          <div class="divide-y divide-slate-100 text-sm">
            <div class="flex justify-between py-3.5">
              <span class="font-semibold text-slate-800">Monday – Friday</span>
              <span class="text-slate-600">9:00 AM – 8:00 PM (EST)</span>
            </div>
            <div class="flex justify-between py-3.5">
              <span class="font-semibold text-slate-800">Saturday</span>
              <span class="text-slate-600">10:00 AM – 6:00 PM (EST)</span>
            </div>
            <div class="flex justify-between py-3.5">
              <span class="font-semibold text-slate-800">Sunday</span>
              <span class="flex items-center gap-1.5 text-cyan-600 font-medium">
                <span class="h-1.5 w-1.5 rounded-full bg-cyan-500 animate-pulse"></span> Digital Support Only
              </span>
            </div>
          </div>
        </div>
        <div class="mt-6 pt-4 text-xs text-slate-500 border-t border-slate-100 flex items-center gap-1.5">
          <i data-lucide="shield-alert" class="h-4 w-4 text-slate-400 shrink-0"></i> Active reservations receive immediate priority dispatch coverage.
        </div>
      </div>

      {{-- NEW ALIGNED COMPACT LIVE MAP CARD --}}
      <div class="overflow-hidden rounded-3xl shadow-sm border border-slate-200/60 min-h-[280px] lg:min-h-full relative group bg-white p-2">
        <div class="w-full h-full rounded-2xl overflow-hidden relative">
          <iframe 
            src="https://www.google.com/maps/embed?pb=!11m18!1m12!1m3!1d3153.0862045579974!2d-122.39654162346583!3d37.787948971982!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8085806665c55555%3A0xa6ecffaaed89345c!2sSan%20Francisco%2C%20CA%2094105!5e0!3m2!1sen!2sus!4v1710000000000!5m2!1sen!2sus" 
            class="w-full h-full min-h-[260px] lg:absolute lg:inset-0 lg:h-full border-0 grayscale opacity-90 contrast-115 transition-all duration-500 hover:grayscale-0 hover:opacity-100" 
            allowfullscreen="" 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade">
          </iframe>
          <div class="absolute bottom-3 left-3 right-3 rounded-xl border border-white/20 bg-slate-950/80 p-2.5 text-center backdrop-blur-md">
            <p class="text-xs font-semibold text-white flex items-center justify-center gap-1.5">
              <i data-lucide="navigation" class="h-3.5 w-3.5 text-cyan-400 animate-bounce"></i> 123 Innovation Drive, San Francisco, CA
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- ACCORDION FAQ INTEGRATION --}}
<section class="bg-slate-50 pb-20 fade-up">
  <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
    <div class="text-center max-w-3xl mx-auto mb-12">
      <p class="text-xs font-bold uppercase tracking-widest text-cyan-600 bg-cyan-50 inline-block px-3 py-1 rounded-full">FAQ</p>
      <h2 class="mt-4 text-3xl font-black text-slate-950 tracking-tight sm:text-4xl">Quick assistance hub</h2>
    </div>
    
    <div class="space-y-4">
      {{-- Item 1 --}}
      <div class="js-accordion-item rounded-2xl border border-slate-200/70 bg-white p-5 transition-all duration-300">
        <button class="js-accordion-trigger flex w-full items-center justify-between font-bold text-slate-900 text-left focus:outline-none">
          <span>How do I rent a vehicle through SkyLine?</span>
          <i data-lucide="plus" class="js-accordion-icon h-4 w-4 text-slate-500 transition-transform duration-300"></i>
        </button>
        <div class="accordion-content">
          <p class="pt-4 text-sm leading-relaxed text-slate-600">
            Simply explore our digital vehicle registry marketplace, select your target date bracket, add premium options such as personalized private chauffeur assignment, and finalize checkout. All confirmation document data hits your mailbox instantaneously.
          </p>
        </div>
      </div>

      {{-- Item 2 --}}
      <div class="js-accordion-item rounded-2xl border border-slate-200/70 bg-white p-5 transition-all duration-300">
        <button class="js-accordion-trigger flex w-full items-center justify-between font-bold text-slate-900 text-left focus:outline-none">
          <span>Can I secure stand-alone personal driver services?</span>
          <i data-lucide="plus" class="js-accordion-icon h-4 w-4 text-slate-500 transition-transform duration-300"></i>
        </button>
        <div class="accordion-content">
          <p class="pt-4 text-sm leading-relaxed text-slate-600">
            Yes, perfectly. You can reserve professional chauffeur teams independently for designated flight terminal transit protocols or corporate events directly without renting from our core vehicle fleet.
          </p>
        </div>
      </div>

      {{-- Item 3 --}}
      <div class="js-accordion-item rounded-2xl border border-slate-200/70 bg-white p-5 transition-all duration-300">
        <button class="js-accordion-trigger flex w-full items-center justify-between font-bold text-slate-900 text-left focus:outline-none">
          <span>What cancellation structure do you enforce?</span>
          <i data-lucide="plus" class="js-accordion-icon h-4 w-4 text-slate-500 transition-transform duration-300"></i>
        </button>
        <div class="accordion-content">
          <p class="pt-4 text-sm leading-relaxed text-slate-600">
            We render full programmatic updates and booking waivers up to 24 hours prior to structural delivery setup times. Cancellations initiated short notice past this point can acquire mild localized handling expenses.
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- CALL TO ACTION --}}
<section class="py-16 fade-up">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="rounded-2xl bg-gradient-to-br from-slate-800 to-slate-950 px-6 py-12 text-center shadow-2xl transition-all duration-500 hover:shadow-cyan-900/30 sm:px-10">
      <h2 class="text-3xl font-black tracking-tight text-white">Ready to experience SkyLine?</h2>
      <p class="mt-3 max-w-2xl mx-auto text-slate-300 text-sm">Join thousands of satisfied customers – rent your first car or book a driver today.</p>
      <div class="mt-8 flex flex-col gap-3 sm:flex-row justify-center">
        <a href="#vehicles" class="group inline-flex items-center justify-center gap-2 rounded-xl bg-cyan-400 px-6 py-3.5 text-sm font-bold text-slate-950 transition-all duration-300 hover:bg-cyan-300 hover:scale-105">
          Rent a Car <i data-lucide="arrow-right" class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1"></i>
        </a>
        <a href="#services" class="group inline-flex items-center justify-center gap-2 rounded-xl border border-white/25 bg-white/5 px-6 py-3.5 text-sm font-bold text-white backdrop-blur-sm transition-all duration-300 hover:border-cyan-400/50 hover:text-cyan-100 hover:scale-105">
          Explore Services <i data-lucide="shopping-bag" class="h-4 w-4 transition-transform duration-300 group-hover:rotate-12"></i>
        </a>
      </div>
    </div>
  </div>
</section>

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Fade-up observer engine
    const fadeElements = document.querySelectorAll('.fade-up');
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
        }
      });
    }, { threshold: 0.05 });
    fadeElements.forEach(el => observer.observe(el));

    // Refined JavaScript Accordion Engine
    const accordionTriggers = document.querySelectorAll('.js-accordion-trigger');
    accordionTriggers.forEach(trigger => {
      trigger.addEventListener('click', function() {
        const item = this.closest('.js-accordion-item');
        const content = item.querySelector('.accordion-content');
        const icon = item.querySelector('.js-accordion-icon');
        const isOpen = content.style.maxHeight && content.style.maxHeight !== '0px';

        // Close all neighboring sibling elements first
        document.querySelectorAll('.accordion-content').forEach(el => el.style.maxHeight = '0px');
        document.querySelectorAll('.js-accordion-icon').forEach(ic => {
          ic.style.transform = 'rotate(0deg)';
          ic.setAttribute('data-lucide', 'plus');
        });
        document.querySelectorAll('.js-accordion-item').forEach(it => it.classList.remove('border-cyan-300/70', 'shadow-md'));

        // Toggle state parameters
        if (!isOpen) {
          content.style.maxHeight = content.scrollHeight + "px";
          icon.style.transform = 'rotate(45deg)'; 
          item.classList.add('border-cyan-300/70', 'shadow-md');
        }
      });
    });
  });
</script>
@endpush

</x-user.layout>
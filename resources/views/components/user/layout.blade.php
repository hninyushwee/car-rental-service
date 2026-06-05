<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="SkyLine Automotive landing page and customer portal skeleton." />
  <title>SkyLine Automotive | Landing & Portal</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @stack('styles')
</head>
<body class="bg-slate-50 text-slate-900 antialiased overflow-x-hidden">
  <div id="app" class="min-h-screen">

    {{-- header --}}
    <x-user.partials.nav />
    {{-- sidebar --}}
    <x-user.partials.sidebar />
    {{-- content --}}
    <main id="mainContent" class="transition-all duration-300">
      {{ $slot }}
    </main>
    <!-- Footer -->
    <x-user.partials.footer />

    <!-- Demo toggle -->
    <button id="authToggle" type="button" class="fixed bottom-4 right-4 z-50 max-w-[calc(100vw-2rem)] rounded bg-cyan-400 px-4 py-3 text-xs font-black text-slate-950 shadow-2xl shadow-cyan-950/30 transition hover:bg-cyan-300">
      Switch Auth State: Guest
    </button>
  </div>

<script>
  // State
  const state = {
    authenticated: false,
    sidebarCollapsed: false,
    testimonialIndex: 0
  };

  const testimonials = [ /* your testimonials array, unchanged */ ];

  // DOM elements
  const header = document.getElementById("siteHeader");
  const mobileMenu = document.getElementById("mobileMenu");
  const mobileMenuButton = document.getElementById("mobileMenuButton");
  const authToggle = document.getElementById("authToggle");
  const sidebar = document.getElementById("dashboardSidebar");
  const sidebarToggleButtons = document.querySelectorAll("[data-sidebar-toggle]");
  const mainContent = document.getElementById("mainContent");
  const notificationButton = document.getElementById("notificationButton");
  const notificationDropdown = document.getElementById("notificationDropdown");
  const profileButton = document.getElementById("profileButton");
  const profileDropdown = document.getElementById("profileDropdown");
  const logo = document.getElementById("logo");
  const navcontent = document.querySelectorAll("[data-nav-contrast]");
  const logoText = document.getElementById("logoText");
  const authNavUI = document.querySelectorAll("[data-auth-ui]");
  const sidebarToggle = document.getElementById("sidebarToggle");

  // Helper: close dropdowns
  function closeDropdowns() {
    notificationDropdown?.classList.add("hidden");
    profileDropdown?.classList.add("hidden");
    notificationButton?.setAttribute("aria-expanded", "false");
    profileButton?.setAttribute("aria-expanded", "false");
  }
// Helper: adjust sidebar positioning for auth state
function setSidebarPosition(authenticated) {
  if (!sidebar) return;
  if (authenticated) {
    // Auth: sidebar starts at top-0, higher z-index
    sidebar.classList.remove("top-20");
    sidebar.classList.add("top-0", "z-50");
    // Lower navbar z-index so sidebar covers it
    header.classList.add("z-40");
    header.classList.remove("z-50");
  } else {
    // Guest: sidebar starts below navbar, normal z-index
    sidebar.classList.add("top-20");
    sidebar.classList.remove("top-0", "z-50");
    header.classList.add("z-50");
    header.classList.remove("z-40");
  }
}

// Auth state (modified)
function setAuthState(authenticated) {
  state.authenticated = authenticated;
  document.querySelectorAll("[data-guest-ui]").forEach(el => el.classList.toggle("hidden", authenticated));
  authNavUI.forEach(el => el.classList.toggle("hidden", !authenticated));

  if (authenticated) {
    sidebar?.classList.remove("hidden");
    if (logo) logo.classList.add("hidden");
    navcontent.forEach(el => el.classList.add("hidden"));
    const isMobile = window.innerWidth < 768;
    setSidebarCollapsed(isMobile);
    setSidebarPosition(true);   // apply auth positioning
  } else {
    sidebar?.classList.add("hidden");
    if (logo) logo.classList.remove("hidden");
    navcontent.forEach(el => el.classList.remove("hidden"));
    if (mainContent) {
      mainContent.classList.remove("lg:pl-68", "lg:pl-20", "pl-64", "pl-16");
    }
    setSidebarPosition(false);  // revert to guest positioning
  }
  authToggle.textContent = `Switch Auth State: ${authenticated ? "Logged In" : "Guest"}`;
  closeDropdowns();
  setHeaderStyle();  // already defined to keep navbar solid white when auth
}
  // Header style on scroll – different behaviour for guest vs auth
  function setHeaderStyle() {
    if (state.authenticated) {
      // AUTHENTICATED: always white background, no scroll effect
      // header.classList.add("bg-white");
      header.classList.add("bg-white/95", "backdrop-blur", "shadow-l");
      // Force dark text/buttons
      navcontent.forEach((item) => {
        item.classList.add("text-slate-950");
        item.classList.remove("text-white", "text-white/90");
      });
      document.querySelectorAll("[data-nav-contrast-button]").forEach((item) => {
        item.classList.add("text-slate-800", "border-slate-300");
        item.classList.remove("text-white", "border-white/30");
      });
      return;
    }

    // GUEST MODE: scroll effect (transparent → white)
    const solid = window.scrollY > 24;
    header.classList.toggle("bg-white/95", solid);
    header.classList.toggle("shadow-xl", solid);
    header.classList.toggle("backdrop-blur", solid);

    navcontent.forEach((item) => {
      item.classList.toggle("text-white", !solid);
      item.classList.toggle("text-slate-950", solid);
      item.classList.toggle("text-white/90", !solid && item.tagName === "A");
    });

    document.querySelectorAll("[data-nav-contrast-button]").forEach((item) => {
      item.classList.toggle("text-white", !solid);
      item.classList.toggle("border-white/30", !solid);
      item.classList.toggle("text-slate-800", solid);
      item.classList.toggle("border-slate-300", solid);
    });
  }

  // Sidebar collapse logic (responsive)
  function setSidebarCollapsed(collapsed) {
    if (!sidebar) return;
    state.sidebarCollapsed = collapsed;

    if (collapsed) {
      sidebar.classList.remove("w-60", "md:w-68");
      sidebar.classList.add("w-16", "md:w-20");
      if (logoText) logoText.classList.add("hidden");
      if (sidebarToggle) {
        sidebarToggle.classList.remove("lg:pl-68", "pl-64");
        sidebarToggle.classList.add("lg:pl-20", "pl-16");
      }
      document.querySelectorAll("[data-sidebar-label]").forEach(el => el.classList.add("hidden"));
      if (mainContent) {
        mainContent.classList.remove("lg:pl-68", "pl-64");
        mainContent.classList.add("lg:pl-20", "pl-16");
      }
    } else {
      sidebar.classList.remove("w-16", "md:w-20");
      sidebar.classList.add("w-60", "md:w-68");
      if (logoText) logoText.classList.remove("hidden");
      if (sidebarToggle) {
        sidebarToggle.classList.remove("lg:pl-20", "pl-16");
        sidebarToggle.classList.add("lg:pl-68", "pl-64");
      }
      document.querySelectorAll("[data-sidebar-label]").forEach(el => el.classList.remove("hidden"));
      if (mainContent) {
        mainContent.classList.remove("lg:pl-20", "pl-16");
        mainContent.classList.add("lg:pl-68", "pl-64");
      }
    }

    sidebarToggleButtons.forEach(btn => {
      const icon = btn.querySelector("i");
      if (icon && typeof lucide !== "undefined") {
        icon.setAttribute("data-lucide", collapsed ? "panel-right" : "panel-left");
        lucide.createIcons();
      }
      btn.setAttribute("aria-expanded", String(!collapsed));
    });
  }

  function toggleSidebarCollapse() {
    if (!state.authenticated) return;
    setSidebarCollapsed(!state.sidebarCollapsed);
  }


  // Testimonial carousel (unchanged)
  function renderTestimonial() {
    const current = testimonials[state.testimonialIndex];
    const photo = document.getElementById("testimonialPhoto");
    const nameEl = document.getElementById("testimonialName");
    const reviewEl = document.getElementById("testimonialReview");
    const ratingEl = document.getElementById("testimonialRating");
    if (photo) photo.src = current.photo;
    if (nameEl) nameEl.textContent = current.name;
    if (reviewEl) reviewEl.textContent = current.review;
    if (ratingEl) {
      ratingEl.innerHTML = Array.from({ length: 5 }, (_, i) =>
        `<i data-lucide="star" class="h-5 w-5 ${i < current.rating ? "fill-current" : "opacity-30"}"></i>`
      ).join("");
    }
    if (typeof lucide !== "undefined") lucide.createIcons();
  }

  // Event listeners
  if (mobileMenuButton) {
    mobileMenuButton.addEventListener("click", () => {
      const isOpen = !mobileMenu.classList.contains("hidden");
      mobileMenu.classList.toggle("hidden", isOpen);
      mobileMenuButton.setAttribute("aria-expanded", String(!isOpen));
    });
  }

  document.querySelectorAll("#mobileMenu a").forEach(link => {
    link.addEventListener("click", () => {
      mobileMenu?.classList.add("hidden");
      mobileMenuButton?.setAttribute("aria-expanded", "false");
    });
  });

  sidebarToggleButtons.forEach(btn => {
    btn.removeEventListener("click", toggleSidebarCollapse);
    btn.addEventListener("click", toggleSidebarCollapse);
  });

  if (authToggle) {
    authToggle.addEventListener("click", () => setAuthState(!state.authenticated));
  }

  if (notificationButton && notificationDropdown) {
    notificationButton.addEventListener("click", (e) => {
      e.stopPropagation();
      profileDropdown?.classList.add("hidden");
      notificationDropdown.classList.toggle("hidden");
      notificationButton.setAttribute("aria-expanded", String(!notificationDropdown.classList.contains("hidden")));
    });
  }

  if (profileButton && profileDropdown) {
    profileButton.addEventListener("click", (e) => {
      e.stopPropagation();
      notificationDropdown?.classList.add("hidden");
      profileDropdown.classList.toggle("hidden");
      profileButton.setAttribute("aria-expanded", String(!profileDropdown.classList.contains("hidden")));
    });
  }

  document.addEventListener("click", closeDropdowns);
  [notificationDropdown, profileDropdown].forEach(drop => {
    drop?.addEventListener("click", (e) => e.stopPropagation());
  });

  const prevBtn = document.getElementById("testimonialPrev");
  const nextBtn = document.getElementById("testimonialNext");
  if (prevBtn) {
    prevBtn.addEventListener("click", () => {
      state.testimonialIndex = (state.testimonialIndex - 1 + testimonials.length) % testimonials.length;
      renderTestimonial();
    });
  }
  if (nextBtn) {
    nextBtn.addEventListener("click", () => {
      state.testimonialIndex = (state.testimonialIndex + 1) % testimonials.length;
      renderTestimonial();
    });
  }

  // Resize listener
  window.addEventListener("resize", () => {
    if (state.authenticated) {
      const isMobile = window.innerWidth < 768;
      if (isMobile && !state.sidebarCollapsed) {
        setSidebarCollapsed(true);
      }
    }
  });

  // Initialize
  window.addEventListener("scroll", () => setHeaderStyle(), { passive: true });
  if (typeof lucide !== "undefined") lucide.createIcons();
  renderTestimonial();
  setAuthState(false); // start as guest
</script>
  @stack('scripts')
</body>
</html>
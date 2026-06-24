<x-auth.layout>
     @section('header')
         Sign in to SkyLine
     @endsection
     <div class="bg-white/10 backdrop-blur-md rounded-2xl shadow-2xl p-8 border border-white/20 animate-fade-in"
         style="animation-delay: 0.1s;">
         
         <div id="globalAuthAlert"
             class="hidden mb-4 rounded-xl border p-4 text-sm flex items-start gap-3 bg-red-500/20 text-red-200 border-red-500/30">
             <i data-lucide="x-circle" class="w-5 h-5 flex-shrink-0 text-red-400"></i>
             <span id="globalAlertMessage" class="font-medium"></span>
         </div>
         <form id="loginForm" class="space-y-4">
             @csrf
             <div class="group">
                 <label for="email" class="block text-sm font-semibold text-white mb-2">
                     <span class="inline-flex items-center gap-2">
                         <i data-lucide="mail" class="w-5 h-5 text-cyan-400"></i>
                         Email Address
                     </span>
                 </label>
                 <input type="email" id="email" name="email" required
                     class="w-full px-4 py-2 rounded-lg bg-white/10 text-white border-2 border-white/20">
                 <span id="emailError" class="text-xs text-red-400 font-medium mt-1 hidden block"></span>
             </div>
             <div class="group">
                 <label for="password" class="block text-sm font-semibold text-white mb-2">
                     <span class="inline-flex items-center gap-2">
                         <i data-lucide="key" class="w-5 h-5 text-cyan-400"></i>
                         Password
                     </span>
                 </label>
                 <input type="password" id="password" name="password" required
                     class="w-full px-4 py-2 rounded-lg bg-white/10 text-white border-2 border-white/20">
                 <span id="passwordError" class="text-xs text-red-400 font-medium mt-1 hidden block"></span>
             </div>
             <button type="submit" id="loginSubmitBtn"
                 class="w-full py-2 px-6 rounded-lg bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-bold shadow-lg hover:shadow-xl hover:from-cyan-600 hover:to-blue-700 transition-all duration-300 transform hover:scale-105 flex items-center justify-center gap-2 group">
                 <i data-lucide="log-in" class="w-5 h-5 group-hover:translate-x-1 transition-transform"></i>
                 <span id="loginBtnText">Sign In</span>
             </button>
         </form>
         <div class="flex items-center gap-3 my-6">
             <div class="flex-1 h-px bg-white/20"></div>
             <span class="text-xs font-medium text-white/50">OR</span>
             <div class="flex-1 h-px bg-white/20"></div>
         </div>
         <div class="grid grid-cols-2 gap-3 mb-6">
             <button type="button"
                 class="px-4 py-2 rounded-lg bg-white/10 border-2 border-white/20 hover:border-white/40 text-white font-semibold transition-all duration-300 transform hover:scale-105 flex items-center justify-center gap-2">
                 <span class="text-sm">Google</span>
             </button>
             <button type="button"
                 class="px-4 py-2 rounded-lg bg-white/10 border-2 border-white/20 hover:border-white/40 text-white font-semibold transition-all duration-300 transform hover:scale-105 flex items-center justify-center gap-2">
                 <span class="text-sm">GitHub</span>
             </button>
         </div>
         <p class="text-center text-white/70">
             Don't have an account?
             <a href="{{ url('/register') }}"
                 class="font-bold text-cyan-400 hover:text-cyan-300 transition-colors">Create
                 one now</a>
         </p>
     </div>
     @push('scripts')
         <script>
             document.addEventListener('DOMContentLoaded', function() {
                 // Fetching key DOM layout nodes via jQuery selectors
                 const $form = $('#loginForm');
                 const $btn = $('#loginSubmitBtn');
                 const $btnText = $('#loginBtnText');
                 const $alert = $('#globalAuthAlert');
                 const $alertMsg = $('#globalAlertMessage');
                 // Global Ajax configuration to automatically append CSRF parameters
                 $.ajaxSetup({
                     headers: {
                         'X-CSRF-TOKEN': $("input[name='_token']").val(),
                         'Accept': 'application/json'
                     }
                 });
                 // Trap form submit interaction
                 $form.on('submit', function(e) {
                     e.preventDefault();
                     
                     // Resetting previous runtime error indicators from user view
                     $('.text-xs').addClass('hidden').text('');
                     $alert.addClass('hidden');
                     // Activating visual loading feedback on submit trigger button
                     $btn.attr('disabled', true).addClass('opacity-75');
                     $btnText.text('Verifying...');
                     // Packaging input state details for request payload transfer
                     const payload = {
                         'email': $('#email').val().trim(),
                         'password': $('#password').val()
                     };
                     // Despatching async API verification request through jQuery AJAX
                     $.ajax({
                         url: "/api/login",
                         method: 'POST',
                         contentType: 'application/json',
                         dataType: 'json',
                         data: JSON.stringify(payload),
                         success: function(response) {
                             if (response.success) {
                                 // Update interface context states upon valid match verification
                                 $btnText.text('Authenticated! Redirecting...');
                                 // Sanctum Architecture Integration: Saving the validated access token inside local browser memory storage
                                 localStorage.setItem('access_token', response.access_token);
                                 // Micro-delay navigation sequence to route target safely to administration desk
                                 setTimeout(() => {
                                    //  window.location.href = "{{ url('/admin/categories') }}";
                                     window.location.href = "{{ url('/admin') }}";
                                 }, 800);
                             }
                         },
                         error: function(xhr) {
                             // Restore button interactivity properties upon failure occurrence 
                             $btn.attr('disabled', false).removeClass('opacity-75');
                             $btnText.text('Sign In');
                             if (xhr.status === 422) {
                                 // Inject validation specific warning alerts under exact input nodes
                                 const validationErrors = xhr.responseJSON?.errors || {};
                                 if (validationErrors.email) {
                                     $('#emailError').removeClass('hidden').text(validationErrors.email[0]);
                                 }
                                 if (validationErrors.password) {
                                     $('#passwordError').removeClass('hidden').text(validationErrors.password[0]);
                                 }
                             } else {
                                 // Display structural access authentication blockages on the upper card warning alert
                                 const errorMessage = xhr.responseJSON?.message || 'Invalid email or password credentials.';
                                 $alertMsg.text(errorMessage);
                                 $alert.removeClass('hidden');
                             }
                         }
                     })
                 })
             })
         </script>
     @endpush
</x-auth.layout>


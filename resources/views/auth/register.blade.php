<x-auth.layout>
    @section('header')
        Create account for SkyLine
    @endsection

    <div class="bg-white/10 backdrop-blur-md rounded-2xl shadow-2xl p-8 border border-white/20 animate-fade-in"
        style="animation-delay: 0.1s;">

        <div id="globalRegisterAlert"
            class="hidden mb-4 rounded-xl border p-4 text-sm flex items-start gap-3 bg-red-500/20 text-red-200 border-red-500/30">
            <i data-lucide="x-circle" class="w-5 h-5 flex-shrink-0 text-red-400"></i>
            <span id="globalAlertMessage" class="font-medium"></span>
        </div>

        <form id="registerForm" class="space-y-4">
            @csrf
            <div class="group">
                <label for="name" class="block text-sm font-semibold text-white mb-2">
                    Name
                </label>
                <input type="text" id="name" name="name" placeholder="Doe" required
                    class="w-full px-4 py-2 rounded-lg bg-white/10 border-2 border-white/20 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/30 transition-all duration-300 placeholder-white/50 text-white backdrop-blur-sm group-hover:border-white/30">
                <span id="nameError" class="text-xs text-red-400 font-medium mt-1 hidden block"></span>
            </div>

            <div class="group">
                <label for="email" class="block text-sm font-semibold text-white mb-2">
                    <span class="inline-flex items-center gap-2">
                        <i data-lucide="mail" class="w-5 h-5 text-cyan-400"></i>
                        Email Address
                    </span>
                </label>
                <input type="email" id="email" name="email" placeholder="your@email.com" required
                    class="w-full px-4 py-2 rounded-lg bg-white/10 border-2 border-white/20 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/30 transition-all duration-300 placeholder-white/50 text-white backdrop-blur-sm group-hover:border-white/30">
                <span id="emailError" class="text-xs text-red-400 font-medium mt-1 hidden block"></span>
            </div>

            <div class="group">
                <label for="password" class="block text-sm font-semibold text-white mb-2">
                    <span class="inline-flex items-center gap-2">
                        <i data-lucide="key" class="w-5 h-5 text-cyan-400"></i>
                        Password
                    </span>
                </label>
                <input type="password" id="password" name="password" placeholder="••••••••" required
                    class="w-full px-4 py-2 rounded-lg bg-white/10 border-2 border-white/20 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/30 transition-all duration-300 placeholder-white/50 text-white backdrop-blur-sm group-hover:border-white/30">
                <span id="passwordError" class="text-xs text-red-400 font-medium mt-1 hidden block"></span>
            </div>

            <div class="group">
                <label for="password_confirmation" class="block text-sm font-semibold text-white mb-2">
                    <span class="inline-flex items-center gap-2">
                        <i data-lucide="shield-check" class="w-5 h-5 text-cyan-400"></i>
                        Confirm Password
                    </span>
                </label>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="••••••••"
                    required
                    class="w-full px-4 py-2 rounded-lg bg-white/10 border-2 border-white/20 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/30 transition-all duration-300 placeholder-white/50 text-white backdrop-blur-sm group-hover:border-white/30">
            </div>

            <div class="group">
                <label for="phone" class="block text-sm font-semibold text-white mb-2">
                    <span class="inline-flex items-center gap-2">
                        <i data-lucide="phone" class="w-5 h-5 text-cyan-400"></i>
                        Phone Number
                    </span>
                </label>
                <input type="tel" id="phone" name="phone" placeholder="+95 9123 456 789"
                    class="w-full px-4 py-2 rounded-lg bg-white/10 border-2 border-white/20 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/30 transition-all duration-300 placeholder-white/50 text-white backdrop-blur-sm group-hover:border-white/30">
                <span id="phoneError" class="text-xs text-red-400 font-medium mt-1 hidden block"></span>
            </div>

            <label class="flex items-start gap-3 cursor-pointer group">
                <input type="checkbox" name="terms" required
                    class="w-5 h-5 rounded-lg bg-white/10 border-2 border-white/20 checked:bg-cyan-500 checked:border-cyan-500 focus:ring-2 focus:ring-cyan-400/30 cursor-pointer transition-all duration-300 mt-0.5">
                <span class="text-sm font-medium text-white/80 group-hover:text-white transition-colors">I
                    agree to the <a href="#" class="text-cyan-400 hover:underline">Terms of
                        Service</a> and <a href="#" class="text-cyan-400 hover:underline">Privacy
                        Policy</a></span>
            </label>

            <button type="submit" id="regSubmitBtn"
                class="w-full py-2 px-6 rounded-lg bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-bold shadow-lg hover:shadow-xl hover:from-cyan-600 hover:to-blue-700 transition-all duration-300 transform hover:scale-105 flex items-center justify-center gap-2 group">
                <i data-lucide="user-check" class="w-5 h-5 group-hover:translate-x-1 transition-transform"></i>
                <span id="regBtnText">Create Account</span>
            </button>
        </form>

        <div class="flex items-center gap-3 my-6">
            <div class="flex-1 h-px bg-white/20"></div>
            <span class="text-xs font-medium text-white/50">OR</span>
            <div class="flex-1 h-px bg-white/20"></div>
        </div>

        <p class="text-center text-white/70">
            Already have an account?
            <a href="/login" class="font-bold text-cyan-400 hover:text-cyan-300 transition-colors">
                Sign in here
            </a>
        </p>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Fetching essential DOM elements using jQuery selectors
                const $form = $('#registerForm');
                const $btn = $('#regSubmitBtn');
                const $btnText = $('#regBtnText');
                const $globalAlert = $('#globalRegisterAlert');
                const $globalMsg = $('#globalAlertMessage');

                // Configuration setup for global AJAX requests (Attaching CSRF protection token)
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $("input[name='_token']").val()
                    }
                });

                // Handling register form submission event logic
                $form.on('submit', function(e) {
                    e.preventDefault();
                    
                    // Resetting previous validation and alert UI status
                    $('#nameError, #emailError, #passwordError, #phoneError').addClass('hidden').text('');
                    $globalAlert.addClass('hidden');

                    // Visual UI feedback indicators during ongoing request processing
                    $btn.attr('disabled', true).addClass('opacity-75');
                    $btnText.text('Processing registration...');

                    // Form payload compilation object mapping fields to values
                    const payloadData = {
                        name: $('#name').val().trim(),
                        email: $('#email').val().trim(),
                        password: $('#password').val(),
                        password_confirmation: $('#password_confirmation').val(),
                        phone: $('#phone').val().trim(),
                    };

                    // Initiating modern async REST API communication call using jQuery AJAX
                    $.ajax({
                        url : "{{ route('api.register') }}",
                        method : 'POST',
                        contentType : 'application/json',
                        dataType : 'json',
                        data : JSON.stringify(payloadData),
                        success : function(response){
                            if(response.success){
                                // Visual interface update to reflect successful registration procedure
                                $btnText.text('Success! Access Token Granted...');

                                // Smooth time delay prior routing user context inside secure dashboard workspace
                                setTimeout(() => {
                                    window.location.href = "{{ url('/login') }}";
                                }, 800);
                            }
                        },
                        error : function(xhr) {
                            // Recovering initial action button functionality state upon encountering issues
                            $btn.attr('disabled', false).removeClass('opacity-75');
                            $btnText.text('Create Account');

                            if(xhr.status === 422){
                                // Mapping localized input syntax validation discrepancies dynamically below input slots
                                const validationErrors = xhr.responseJSON?.errors || {};
                                if(validationErrors.name){
                                    $('#nameError').removeClass('hidden').text(validationErrors.name[0]);
                                }
                                if(validationErrors.email){
                                    $('#emailError').removeClass('hidden').text(validationErrors.email[0]);
                                }
                                if(validationErrors.password){
                                    $('#passwordError').removeClass('hidden').text(validationErrors.password[0]);
                                }
                                if(validationErrors.phone){
                                    $('#phoneError').removeClass('hidden').text(validationErrors.phone[0]);
                                }
                            } else {
                                // Capturing unexpected internal systems blockades inside generic alert panel block
                                const fallBackMsg = xhr.responseJSON?.message || 'Something went wrong! Please try again';
                                $globalMsg.text(fallBackMsg);
                                $globalAlert.removeClass('hidden');
                            }
                        }
                    });
                });
            });
        </script>
    @endpush
</x-auth.layout>
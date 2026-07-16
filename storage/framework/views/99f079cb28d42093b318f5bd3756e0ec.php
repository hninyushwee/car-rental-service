<?php if (isset($component)) { $__componentOriginal12e87bc479fccb706aae85303437553c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal12e87bc479fccb706aae85303437553c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.auth.layout','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('auth.layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <?php $__env->startSection('header'); ?>
        Sign in to SkyLine
    <?php $__env->stopSection(); ?>

    <div class="bg-white/10 backdrop-blur-md rounded-2xl shadow-2xl p-8 border border-white/20 animate-fade-in"
        style="animation-delay: 0.1s;">

        <div id="globalAuthAlert"
            class="hidden mb-4 rounded-xl border p-4 text-sm flex items-start gap-3 bg-red-500/20 text-red-200 border-red-500/30">
            <i data-lucide="x-circle" class="w-5 h-5 flex-shrink-0 text-red-400"></i>
            <span id="globalAlertMessage" class="font-medium"></span>
        </div>

        <form id="loginForm" data-auth-login-form data-redirect="<?php echo e($redirect ?? route('admin.dashboard')); ?>" method="POST" action="<?php echo e(route('api.login')); ?>" class="space-y-4">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="expected_role" value="<?php echo e($expected_role ?? ''); ?>">
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
                <div class="relative">
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-2 pr-10 rounded-lg bg-white/10 text-white border-2 border-white/20">
                    <button type="button" onclick="togglePassword(this, 'password')"
                        class="absolute right-2 top-1/2 -translate-y-1/2 text-white/60 hover:text-white transition-colors">
                        <i data-lucide="eye" class="h-4 w-4"></i>
                    </button>
                </div>
                <span id="passwordError" class="text-xs text-red-400 font-medium mt-1 hidden block"></span>
            </div>
            <button type="submit" id="loginSubmitBtn"
                class="w-full py-2 px-6 rounded-lg bg-cyan-400 text-black font-bold shadow-sm hover:bg-cyan-500 transition-all duration-300 transform hover:scale-105 flex items-center justify-center gap-2 group">
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

        <?php if($showRegisterLink): ?>
            <p class="text-center text-white/70">
                Don't have an account?
                <a href="<?php echo e(url('/register')); ?>"
                    class="font-bold text-cyan-400 hover:text-cyan-300 transition-colors">Create one now</a>
            </p>
        <?php endif; ?>
    </div>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal12e87bc479fccb706aae85303437553c)): ?>
<?php $attributes = $__attributesOriginal12e87bc479fccb706aae85303437553c; ?>
<?php unset($__attributesOriginal12e87bc479fccb706aae85303437553c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal12e87bc479fccb706aae85303437553c)): ?>
<?php $component = $__componentOriginal12e87bc479fccb706aae85303437553c; ?>
<?php unset($__componentOriginal12e87bc479fccb706aae85303437553c); ?>
<?php endif; ?>
<?php /**PATH C:\Users\hp\Documents\Portfolio\car-rental-service\resources\views/auth/login.blade.php ENDPATH**/ ?>
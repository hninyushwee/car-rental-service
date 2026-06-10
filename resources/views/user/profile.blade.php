<x-user.layout>
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
        <!-- Header with Avatar -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8 animate-fade-in">
            <!-- Background Banner -->
            <div class="h-32 bg-gradient-to-r from-cyan-500 to-blue-600"></div>

            <!-- Avatar & Basic Info -->
            <div class="px-8 pb-8">
                <div class="flex flex-col md:flex-row items-start md:items-end gap-6 -mt-16 mb-8">
                    <div class="flex-shrink-0">
                        <img src="https://ui-avatars.com/api/?name=John+Doe&size=128&background=06b6d4&color=fff" alt="Profile Avatar" class="w-32 h-32 rounded-xl border-4 border-white shadow-lg">
                    </div>
                    <div class="flex-1">
                        <h1 class="text-3xl font-bold text-slate-900 mb-2">John Doe</h1>
                        <div class="flex flex-wrap gap-4 text-slate-600">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <span>john@example.com</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                <span>+1 (555) 123-4567</span>
                            </div>
                        </div>
                    </div>
                    <button class="px-8 py-3 rounded-lg bg-cyan-500 text-white font-semibold hover:bg-cyan-600 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                        Edit Profile
                    </button>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-3 gap-4">
                    <div class="bg-gradient-to-br from-cyan-50 to-blue-50 rounded-lg p-4 border border-cyan-200">
                        <p class="text-3xl font-bold text-cyan-600 mb-1">24</p>
                        <p class="text-sm text-slate-600">Total Bookings</p>
                    </div>
                    <div class="bg-gradient-to-br from-emerald-50 to-teal-50 rounded-lg p-4 border border-emerald-200">
                        <p class="text-3xl font-bold text-emerald-600 mb-1">2,450</p>
                        <p class="text-sm text-slate-600">Miles Driven</p>
                    </div>
                    <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-lg p-4 border border-amber-200">
                        <p class="text-3xl font-bold text-amber-600 mb-1">Gold</p>
                        <p class="text-sm text-slate-600">Member Status</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Personal Information -->
                <div class="bg-white rounded-xl shadow-lg p-8 animate-fade-in" style="animation-delay: 0.1s;">
                    <h2 class="text-2xl font-bold text-slate-900 mb-6 flex items-center gap-3">
                        <div class="p-3 bg-cyan-100 rounded-lg">
                            <svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        Personal Information
                    </h2>

                    <form class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- First Name -->
                            <div>
                                <label class="block text-sm font-semibold text-slate-900 mb-2">First Name</label>
                                <input type="text" value="John" class="w-full px-4 py-3 rounded-lg border-2 border-slate-200 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 transition-all duration-300 text-slate-900">
                            </div>

                            <!-- Last Name -->
                            <div>
                                <label class="block text-sm font-semibold text-slate-900 mb-2">Last Name</label>
                                <input type="text" value="Doe" class="w-full px-4 py-3 rounded-lg border-2 border-slate-200 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 transition-all duration-300 text-slate-900">
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-semibold text-slate-900 mb-2">Email Address</label>
                                <input type="email" value="john@example.com" class="w-full px-4 py-3 rounded-lg border-2 border-slate-200 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 transition-all duration-300 text-slate-900">
                            </div>

                            <!-- Phone -->
                            <div>
                                <label class="block text-sm font-semibold text-slate-900 mb-2">Phone Number</label>
                                <input type="tel" value="+1 (555) 123-4567" class="w-full px-4 py-3 rounded-lg border-2 border-slate-200 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 transition-all duration-300 text-slate-900">
                            </div>
                        </div>

                        <!-- Date of Birth -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-900 mb-2">Date of Birth</label>
                            <input type="date" value="1990-05-15" class="w-full px-4 py-3 rounded-lg border-2 border-slate-200 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 transition-all duration-300 text-slate-900">
                        </div>

                        <!-- License Information -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-slate-900 mb-2">License Number</label>
                                <input type="text" value="DL-123456789" class="w-full px-4 py-3 rounded-lg border-2 border-slate-200 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 transition-all duration-300 text-slate-900">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-900 mb-2">License Expiry</label>
                                <input type="date" value="2026-05-15" class="w-full px-4 py-3 rounded-lg border-2 border-slate-200 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 transition-all duration-300 text-slate-900">
                            </div>
                        </div>

                        <button type="submit" class="px-6 py-3 rounded-lg bg-cyan-500 text-white font-semibold hover:bg-cyan-600 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                            Save Changes
                        </button>
                    </form>
                </div>

                <!-- Address Information -->
                <div class="bg-white rounded-xl shadow-lg p-8 animate-fade-in" style="animation-delay: 0.2s;">
                    <h2 class="text-2xl font-bold text-slate-900 mb-6 flex items-center gap-3">
                        <div class="p-3 bg-blue-100 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        Address Information
                    </h2>

                    <form class="space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-slate-900 mb-2">Street Address</label>
                            <input type="text" value="123 Main Street" class="w-full px-4 py-3 rounded-lg border-2 border-slate-200 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 transition-all duration-300 text-slate-900">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-slate-900 mb-2">City</label>
                                <input type="text" value="New York" class="w-full px-4 py-3 rounded-lg border-2 border-slate-200 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 transition-all duration-300 text-slate-900">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-900 mb-2">State</label>
                                <input type="text" value="NY" class="w-full px-4 py-3 rounded-lg border-2 border-slate-200 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 transition-all duration-300 text-slate-900">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-slate-900 mb-2">ZIP Code</label>
                                <input type="text" value="10001" class="w-full px-4 py-3 rounded-lg border-2 border-slate-200 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 transition-all duration-300 text-slate-900">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-900 mb-2">Country</label>
                                <input type="text" value="United States" class="w-full px-4 py-3 rounded-lg border-2 border-slate-200 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 transition-all duration-300 text-slate-900">
                            </div>
                        </div>

                        <button type="submit" class="px-6 py-3 rounded-lg bg-cyan-500 text-white font-semibold hover:bg-cyan-600 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                            Save Changes
                        </button>
                    </form>
                </div>

                <!-- Preferences -->
                <div class="bg-white rounded-xl shadow-lg p-8 animate-fade-in" style="animation-delay: 0.3s;">
                    <h2 class="text-2xl font-bold text-slate-900 mb-6 flex items-center gap-3">
                        <div class="p-3 bg-emerald-100 rounded-lg">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        Preferences
                    </h2>

                    <div class="space-y-6">
                        <!-- Notification Settings -->
                        <div class="space-y-4">
                            <h3 class="font-semibold text-slate-900">Notification Settings</h3>
                            <div class="space-y-3">
                                <label class="flex items-center gap-3 p-3 rounded-lg hover:bg-slate-50 cursor-pointer transition-colors">
                                    <input type="checkbox" checked class="w-5 h-5 rounded text-cyan-500 focus:ring-cyan-500">
                                    <span class="text-slate-700">Email notifications for bookings</span>
                                </label>
                                <label class="flex items-center gap-3 p-3 rounded-lg hover:bg-slate-50 cursor-pointer transition-colors">
                                    <input type="checkbox" checked class="w-5 h-5 rounded text-cyan-500 focus:ring-cyan-500">
                                    <span class="text-slate-700">SMS notifications for important updates</span>
                                </label>
                                <label class="flex items-center gap-3 p-3 rounded-lg hover:bg-slate-50 cursor-pointer transition-colors">
                                    <input type="checkbox" class="w-5 h-5 rounded text-cyan-500 focus:ring-cyan-500">
                                    <span class="text-slate-700">Promotional emails and offers</span>
                                </label>
                            </div>
                        </div>

                        <!-- Privacy Settings -->
                        <div class="space-y-4 pt-6 border-t border-slate-200">
                            <h3 class="font-semibold text-slate-900">Privacy Settings</h3>
                            <div class="space-y-3">
                                <label class="flex items-center gap-3 p-3 rounded-lg hover:bg-slate-50 cursor-pointer transition-colors">
                                    <input type="checkbox" checked class="w-5 h-5 rounded text-cyan-500 focus:ring-cyan-500">
                                    <span class="text-slate-700">Make profile visible to other users</span>
                                </label>
                                <label class="flex items-center gap-3 p-3 rounded-lg hover:bg-slate-50 cursor-pointer transition-colors">
                                    <input type="checkbox" checked class="w-5 h-5 rounded text-cyan-500 focus:ring-cyan-500">
                                    <span class="text-slate-700">Allow reviews on my profile</span>
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="w-full px-6 py-3 rounded-lg bg-cyan-500 text-white font-semibold hover:bg-cyan-600 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                            Save Preferences
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-8">
                <!-- Security Settings -->
                <div class="bg-white rounded-xl shadow-lg p-6 animate-fade-in" style="animation-delay: 0.4s;">
                    <h3 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        Security Settings
                    </h3>
                    <div class="space-y-3">
                        <button class="w-full px-4 py-2 rounded-lg bg-slate-100 text-slate-900 font-semibold hover:bg-slate-200 transition-all duration-300 text-sm">
                            Change Password
                        </button>
                        <button class="w-full px-4 py-2 rounded-lg bg-slate-100 text-slate-900 font-semibold hover:bg-slate-200 transition-all duration-300 text-sm">
                            Two-Factor Authentication
                        </button>
                        <button class="w-full px-4 py-2 rounded-lg bg-slate-100 text-slate-900 font-semibold hover:bg-slate-200 transition-all duration-300 text-sm">
                            Active Sessions
                        </button>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="bg-white rounded-xl shadow-lg p-6 animate-fade-in" style="animation-delay: 0.5s;">
                    <h3 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.658 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                        </svg>
                        Quick Links
                    </h3>
                    <div class="space-y-2">
                        <a href="#" class="block px-4 py-2 rounded-lg hover:bg-slate-100 text-slate-700 hover:text-cyan-600 transition-all duration-300 text-sm font-medium">
                            → My Bookings
                        </a>
                        <a href="#" class="block px-4 py-2 rounded-lg hover:bg-slate-100 text-slate-700 hover:text-cyan-600 transition-all duration-300 text-sm font-medium">
                            → Saved Vehicles
                        </a>
                        <a href="#" class="block px-4 py-2 rounded-lg hover:bg-slate-100 text-slate-700 hover:text-cyan-600 transition-all duration-300 text-sm font-medium">
                            → Reviews & Ratings
                        </a>
                        <a href="#" class="block px-4 py-2 rounded-lg hover:bg-slate-100 text-slate-700 hover:text-cyan-600 transition-all duration-300 text-sm font-medium">
                            → Payment Methods
                        </a>
                    </div>
                </div>

                <!-- Danger Zone -->
                <div class="bg-red-50 rounded-xl shadow-lg p-6 border-2 border-red-200 animate-fade-in" style="animation-delay: 0.6s;">
                    <h3 class="text-lg font-bold text-red-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0 4v2M7 9h.01M7 13h.01M7 17h.01M17 9h.01M17 13h.01M17 17h.01"></path>
                        </svg>
                        Danger Zone
                    </h3>
                    <p class="text-sm text-red-800 mb-4">Once you delete your account, there is no going back. Please be certain.</p>
                    <button class="w-full px-4 py-2 rounded-lg bg-red-600 text-white font-semibold hover:bg-red-700 transition-all duration-300 text-sm">
                        Delete Account
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes fade-in {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in {
        animation: fade-in 0.5s ease-out forwards;
        opacity: 0;
    }
</style>
</x-user.layout>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Profile Header Card -->
            <div class="relative overflow-hidden bg-white shadow-xl sm:rounded-3xl border border-white/20">
                <!-- Cover Gradient -->
                <div class="h-32 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600"></div>
                
                <div class="px-8 pb-8">
                    <div class="relative flex items-end -mt-12 mb-6">
                        <!-- Avatar Placeholder -->
                        <div class="flex items-center justify-center w-24 h-24 rounded-2xl bg-white shadow-lg border-4 border-white overflow-hidden">
                            <span class="text-3xl font-bold text-indigo-600">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        </div>
                        <div class="ml-6 flex-1">
                            <h1 class="text-2xl font-bold text-gray-900">{{ Auth::user()->name }}</h1>
                            <p class="text-gray-500 font-medium">{{ Auth::user()->email }}</p>
                        </div>
                        <div class="hidden sm:block">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-100">
                                <span class="w-2 h-2 mr-1.5 rounded-full bg-indigo-500"></span>
                                Active Account
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col md:flex-row gap-8">
                <!-- Sidebar Navigation -->
                <aside class="md:w-1/4">
                    <nav class="sticky top-24 space-y-2">
                        <a href="#personal-info" class="flex items-center px-4 py-3 text-sm font-medium text-indigo-700 bg-indigo-50 rounded-xl border border-indigo-100 transition-all duration-200">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            Personal Info
                        </a>
                        <a href="#password-security" class="flex items-center px-4 py-3 text-sm font-medium text-gray-600 hover:text-indigo-600 hover:bg-white rounded-xl transition-all duration-200">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                            Security
                        </a>
                        <a href="#danger-zone" class="flex items-center px-4 py-3 text-sm font-medium text-gray-600 hover:text-red-600 hover:bg-white rounded-xl transition-all duration-200">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            Danger Zone
                        </a>
                    </nav>
                </aside>

                <!-- Content Area -->
                <div class="md:w-3/4 space-y-8">
                    <!-- Personal Information -->
                    <section id="personal-info" class="scroll-mt-24 bg-white shadow-xl sm:rounded-3xl border border-gray-100 overflow-hidden">
                        <div class="p-8">
                            <div class="max-w-2xl">
                                @include('profile.partials.update-profile-information-form')
                            </div>
                        </div>
                    </section>

                    <!-- Password Update -->
                    <section id="password-security" class="scroll-mt-24 bg-white shadow-xl sm:rounded-3xl border border-gray-100 overflow-hidden">
                        <div class="p-8">
                            <div class="max-w-2xl">
                                @include('profile.partials.update-password-form')
                            </div>
                        </div>
                    </section>

                    <!-- Danger Zone -->
                    <section id="danger-zone" class="scroll-mt-24 bg-red-50/50 shadow-xl sm:rounded-3xl border border-red-100 overflow-hidden">
                        <div class="p-8">
                            <div class="max-w-2xl">
                                @include('profile.partials.delete-user-form')
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

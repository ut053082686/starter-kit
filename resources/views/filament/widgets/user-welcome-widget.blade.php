<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex items-center gap-x-4">
            {{-- Avatar User --}}
            <img src="{{ filament()->getUserAvatarUrl(auth()->user()) }}" 
                 alt="Avatar" 
                 class="h-16 w-16 rounded-full bg-gray-200">
            
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
                    Halo, {{ auth()->user()->name }}! 👋
                </h2>
                <p class="text-gray-500 dark:text-gray-400 mt-1">
                    Selamat datang di Panel Pengguna.
                    <br>
                    Role Anda: <span class="font-semibold text-primary-600">{{ auth()->user()->getRoleNames()->first() }}</span>
                </p>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
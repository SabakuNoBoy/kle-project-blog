<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'KLE Blog' }}</title>
    <meta name="description" content="KLE Blog - Teknoloji, tasarım ve yazılım hakkında güncel yazılar.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-gray-50 text-gray-900 font-sans antialiased min-h-screen flex flex-col justify-between">

    {{-- Navbar --}}
    <nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-gray-100">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="flex justify-between items-center h-14">
                {{-- Logo --}}
                <a href="/" wire:navigate class="flex items-center gap-2">
                    <div
                        class="w-8 h-8 bg-red-600 rounded-lg flex items-center justify-center text-white font-bold text-sm">
                        K</div>
                    <span class="text-lg font-bold text-gray-900">KLE<span class="text-red-600">Blog</span></span>
                </a>

                {{-- Auth --}}
                <div class="flex items-center gap-3">
                    @if(session('api_token'))
                        <a href="/dashboard" wire:navigate
                            class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">Yönetim
                            Paneli</a>
                        <a href="/logout" wire:navigate
                            class="text-sm text-gray-400 hover:text-red-600 transition-colors">Çıkış</a>
                    @else
                        <a href="/login" wire:navigate
                            class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">Giriş Yap</a>
                        <a href="/register" wire:navigate
                            class="bg-gray-900 hover:bg-gray-800 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">Kayıt
                            Ol</a>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <main class="flex-grow w-full max-w-6xl mx-auto px-4 sm:px-6 py-8">
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <footer class="bg-white border-t border-gray-100 py-6 mt-auto shrink-0 w-full">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <a href="/" class="flex items-center gap-2">
                    <div
                        class="w-8 h-8 bg-red-600 rounded-lg flex items-center justify-center text-white font-bold text-sm shadow-sm">
                        K</div>
                    <span class="text-base font-bold text-gray-900">KLE<span class="text-red-600">Blog</span></span>
                </a>
                <div class="flex items-center gap-5 text-sm text-gray-500">
                    <a href="/agreement/gizlilik-politikasi" wire:navigate
                        class="hover:text-red-600 transition-colors">Gizlilik Politikası</a>
                    <span class="text-gray-200">|</span>
                    <a href="/agreement/kullanim-kosullari" wire:navigate
                        class="hover:text-red-600 transition-colors">Kullanım Koşulları</a>
                    <span class="text-gray-200">|</span>
                    <p class="font-medium">&copy; {{ date('Y') }} KLE Blog. Tüm hakları saklıdır.</p>
                </div>
            </div>
        </div>
    </footer>

    {{-- Global Modal Popup --}}
    @if(session('success_popup'))
        <div x-data="{ show: true }" x-show="show" class="fixed inset-0 z-[100] flex items-center justify-center p-4">

            {{-- Backdrop --}}
            <div x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" @click="show = false"></div>

            {{-- Modal Box --}}
            <div x-show="show" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                class="relative bg-white rounded-2xl shadow-2xl p-8 max-w-sm w-full text-center border border-gray-100">

                <div
                    class="w-16 h-16 mx-auto bg-green-50 text-green-500 rounded-full flex items-center justify-center mb-5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>

                <h3 class="text-2xl font-bold text-gray-900 mb-2">Başarılı!</h3>
                <p class="text-gray-500 mb-8">{{ session('success_popup') }}</p>

                <button @click="show = false"
                    class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-3 rounded-xl transition-colors text-lg">
                    Tamam
                </button>
            </div>
        </div>
    @endif

    @livewireScripts
</body>

</html>
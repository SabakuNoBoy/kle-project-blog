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
                        <a href="/post/create" wire:navigate
                            class="text-sm font-medium text-red-600 hover:text-red-700 transition-colors">Yazı Ekle</a>
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
    <footer class="bg-white border-t border-gray-100 py-6 mt-auto shrink-0 w-full" x-data="{ openModal: null }">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <a href="/" class="flex items-center gap-2">
                    <div
                        class="w-8 h-8 bg-red-600 rounded-lg flex items-center justify-center text-white font-bold text-sm shadow-sm">
                        K</div>
                    <span class="text-base font-bold text-gray-900">KLE<span class="text-red-600">Blog</span></span>
                </a>
                <div class="flex flex-wrap justify-center md:items-center gap-5 text-sm text-gray-500">
                    <a href="/agreements/gizlilik-politikasi" wire:navigate
                        class="hover:text-red-600 transition-colors">Gizlilik Politikası</a>
                    <span class="text-gray-200 hidden md:inline">|</span>
                    <a href="/agreements/kullanim-kosullari" wire:navigate
                        class="hover:text-red-600 transition-colors">Kullanım Koşulları</a>
                    <span class="text-gray-200 hidden md:inline">|</span>
                    <p class="font-medium">&copy; {{ date('Y') }} KLE Blog. Tüm hakları saklıdır.</p>
                </div>
            </div>
        </div>

    </footer>
    </footer>

    @livewireScripts
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        window.addEventListener('swal', event => {
            const data = event.detail[0] || event.detail;
            Swal.fire({
                title: data.title,
                text: data.text,
                icon: data.icon,
                confirmButtonColor: '#dc2626',
                confirmButtonText: 'Tamam',
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'rounded-xl px-8 py-3'
                }
            }).then((result) => {
                if (result.isConfirmed && data.redirect) {
                    window.location.href = data.redirect;
                }
            });
        });

        // Handle legacy session success_popup if still used
        @if(session('success_popup'))
            Swal.fire({
                title: 'Başarılı!',
                text: "{{ session('success_popup') }}",
                icon: 'success',
                confirmButtonColor: '#dc2626',
                confirmButtonText: 'Tamam'
            });
        @endif
    </script>
</body>

</html>
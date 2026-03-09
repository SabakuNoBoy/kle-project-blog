<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servis Kesintisi - KLE Blog</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .glass {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
        }
    </style>
</head>

<body class="bg-gray-50 flex items-center justify-center min-h-screen p-4">
    <div class="max-w-md w-full text-center">
        {{-- Logo --}}
        <div class="flex justify-center mb-8">
            <div class="flex items-center gap-2">
                <div
                    class="w-12 h-12 bg-red-600 rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-lg ring-4 ring-red-100">
                    K</div>
                <span class="text-2xl font-black text-gray-900 tracking-tight">KLE<span
                        class="text-red-600">Blog</span></span>
            </div>
        </div>

        {{-- Error Container --}}
        <div
            class="bg-white rounded-[2.5rem] p-10 shadow-2xl shadow-red-500/5 border border-gray-100 relative overflow-hidden">
            {{-- Decorative Element --}}
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-red-50 rounded-full blur-3xl opacity-60"></div>

            <div class="relative z-10">
                {{-- Icon --}}
                <div
                    class="w-20 h-20 bg-red-50 text-red-600 rounded-full flex items-center justify-center mx-auto mb-6 ring-8 ring-red-50/50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>

                <h1 class="text-2xl font-bold text-gray-900 mb-3">Sistem Bakımda</h1>
                <p class="text-gray-500 mb-8 leading-relaxed">
                    Şu anda ana sunucumuza erişim sağlayamıyoruz. Teknik ekibimiz üzerinde çalışıyor. Lütfen kısa bir
                    süre sonra tekrar deneyin.
                </p>

                <div class="space-y-3">
                    <a href="/"
                        class="block w-full bg-red-600 hover:bg-red-700 text-white font-bold py-4 rounded-2xl transition-all shadow-lg shadow-red-600/20 active:scale-[0.98]">
                        Yeniden Dene
                    </a>
                    <button onclick="window.location.reload()"
                        class="block w-full bg-gray-50 hover:bg-gray-100 text-gray-700 font-semibold py-4 rounded-2xl transition-all border border-gray-100">
                        Sayfayı Yenile
                    </button>
                </div>
            </div>
        </div>

        <p class="mt-8 text-sm text-gray-400">
            SabakuNoBoy tarafından güçlendirildi.
        </p>
    </div>
</body>

</html>
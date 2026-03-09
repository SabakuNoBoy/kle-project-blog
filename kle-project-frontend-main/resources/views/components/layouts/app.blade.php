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
                    <button @click="openModal = 'privacy'" type="button"
                        class="hover:text-red-600 transition-colors">Gizlilik Politikası</button>
                    <span class="text-gray-200 hidden md:inline">|</span>
                    <button @click="openModal = 'terms'" type="button"
                        class="hover:text-red-600 transition-colors">Kullanım Koşulları</button>
                    <span class="text-gray-200 hidden md:inline">|</span>
                    <p class="font-medium">&copy; {{ date('Y') }} KLE Blog. Tüm hakları saklıdır.</p>
                </div>
            </div>
        </div>

        {{-- Agreements Modals --}}
        <template x-teleport="body">
            <div x-show="openModal !== null" style="display: none; z-index: 99999;"
                class="fixed inset-0 flex items-center justify-center p-4">
                {{-- Backdrop --}}
                <div x-show="openModal !== null" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm"
                    @click="openModal = null"></div>

                {{-- Modal Box --}}
                <div x-show="openModal !== null" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                    x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                    class="relative bg-white rounded-3xl shadow-2xl p-8 md:p-12 max-w-4xl w-full max-h-[90vh] overflow-y-auto border border-gray-100">

                    {{-- Close Button --}}
                    <button @click="openModal = null"
                        class="absolute top-6 right-6 text-gray-400 hover:text-red-600 bg-gray-50 hover:bg-red-50 p-2 rounded-full transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    {{-- Privacy Content --}}
                    <div x-show="openModal === 'privacy'">
                        <div class="text-center mb-8">
                            <div
                                class="w-16 h-16 bg-red-50 text-red-600 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Gizlilik Politikası</h2>
                        </div>
                        <div
                            class="text-gray-600 space-y-5 leading-relaxed text-left text-base bg-gray-50/50 p-6 md:p-8 rounded-2xl border border-gray-100">
                            <div>
                                <h4 class="font-bold text-gray-900 text-lg mb-2">1. Giriş</h4>
                                <p>KLE Blog olarak kullanıcılarımızın gizliliğine son derece önem veriyoruz. Bu metin,
                                    sitemizi ziyaret ettiğinizde, üye olduğunuzda veya içeriklerimizle etkileşime
                                    geçtiğinizde toplanan verilerin nasıl işlendiğini ve korunduğunu açıklamaktadır.</p>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 text-lg mb-2">2. Toplanan Bilgiler</h4>
                                <p>Platformumuza kayıt olurken sağladığınız isim, e-posta adresi gibi kişisel bilgiler
                                    sistemimizde şifrelenerek ve güvenli veri tabanlarımızda saklanmaktadır. Ayrıca site
                                    içi istatistikleri ve deneyiminizi geliştirmek adına IP adresiniz, kullandığınız
                                    tarayıcı türü gibi anonim veriler analitik süreçleri için işlenebilir.</p>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 text-lg mb-2">3. Çerezler (Cookies)</h4>
                                <p>Sitemiz, kullanıcıların tercihlerini hatırlamak, oturum durumunu korumak ve
                                    kişiselleştirilmiş bir deneyim sunmak amacıyla çerezleri (cookies) kullanmaktadır.
                                    Tarayıcı ayarlarınız üzerinden çerezleri dilediğiniz zaman yönetebilir veya
                                    silebilirsiniz.</p>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 text-lg mb-2">4. Bilgilerin Paylaşımı</h4>
                                <p>Kullanıcı verileriniz, tamamen yasal zorunluluklar veya resmi idari talepler
                                    haricinde hiçbir üçüncü taraf şirket veya şahısla ticari/pazarlama amaçlı olarak
                                    kesinlikle paylaşılmamaktadır.</p>
                            </div>
                        </div>
                    </div>

                    {{-- Terms Content --}}
                    <div x-show="openModal === 'terms'">
                        <div class="text-center mb-8">
                            <div
                                class="w-16 h-16 bg-red-50 text-red-600 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Kullanım Koşulları</h2>
                        </div>
                        <div
                            class="text-gray-600 space-y-5 leading-relaxed text-left text-base bg-gray-50/50 p-6 md:p-8 rounded-2xl border border-gray-100">
                            <div>
                                <h4 class="font-bold text-gray-900 text-lg mb-2">1. Kabul Edilme</h4>
                                <p>KLE Blog platformuna giriş yaparak, içerikleri okuyarak veya üyelik oluşturarak
                                    aşağıda belirtilen şartları ve kuralları peşinen kabul etmiş olursunuz.</p>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 text-lg mb-2">2. İçerik ve Telif Hakkı</h4>
                                <p>Platformumuzda yayınlanan her türlü makale, tasarım, görsel, logo ve kod
                                    parçacıklarının telif hakları KLE Blog platformuna veya ilgili orijinal yazarlarına
                                    aittir. Bu içeriklerin kaynak gösterilmeden veya izinsiz olarak başka platformlarda
                                    kullanılması, kopyalanması veya ticari amaçla dağıtılmasına izin verilmez.</p>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 text-lg mb-2">3. Kullanıcı Davranışları</h4>
                                <p>Platform üzerinde makale paylaşan veya yorum bırakan tüm kullanıcılar, topluluk
                                    kurallarına uymakla yükümlüdür. Küfür, dil, din, ırk ayrımı, hakaret, nefret söylemi
                                    ve yasal olmayan metinler/görseller paylaşmak yasaktır. Bu kurala uymayan hesaplar
                                    önceden uyarılmaksızın kalıcı olarak platformdan uzaklaştırılır.</p>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 text-lg mb-2">4. Değişiklik Hakları</h4>
                                <p>KLE Blog yönetimi, platformun sürdürülebilirliği ve yasal regülasyonlara uyum
                                    kapsamında, önceden haber vermeksizin kullanım koşullarını, gizlilik politikalarını
                                    ve sistem özelliklerini değiştirme hakkını her zaman saklı tutar.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
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
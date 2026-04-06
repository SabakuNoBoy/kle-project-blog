<div class="min-h-[80vh] flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-sm">
        <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
            <div class="text-center mb-8">
                <a href="/" wire:navigate>
                    <div
                        class="w-10 h-10 bg-red-600 text-white rounded-lg flex items-center justify-center text-lg font-bold mx-auto mb-4">
                        K</div>
                </a>
                <h1 class="text-xl font-bold text-gray-900">Giriş Yap</h1>
                <p class="text-gray-500 text-sm mt-1">Hesabınıza giriş yapın</p>
            </div>

            {{-- General error alert (connection errors, server errors) --}}


            <form wire:submit="login" class="space-y-4" novalidate>
                <div>
                    <label class="text-xs font-medium text-gray-500 mb-1 block">E-posta</label>
                    <input type="email" wire:model="email"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all"
                        placeholder="ornek@email.com">

                </div>

                <div>
                    <label class="text-xs font-medium text-gray-500 mb-1 block">Şifre</label>
                    <input type="password" wire:model="password"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all"
                        placeholder="••••••••">

                </div>

                <button type="submit"
                    class="w-full bg-red-600 hover:bg-red-700 text-white py-2.5 rounded-lg text-sm font-medium transition-colors">
                    Giriş Yap
                </button>
            </form>

            <div class="mt-6 pt-6 border-t border-gray-100 text-center">
                <p class="text-sm text-gray-500">Hesabınız yok mu?
                    <a href="/register" wire:navigate class="text-red-600 hover:text-red-700 font-medium">Kayıt Ol</a>
                </p>
            </div>
        </div>
    </div>
</div>
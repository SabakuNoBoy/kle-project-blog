<div>
    @if($isSuccess)
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center">
            <div class="bg-white rounded-2xl p-10 shadow-xl text-center max-w-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-green-500 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Başarılı!</h3>
                <p class="text-gray-500 text-sm">Ürün ekleme isteği gönderildi. Yönlendiriliyorsunuz...</p>
            </div>
        </div>
        <script>setTimeout(function(){ window.location.href = '/'; }, 2500);</script>
    @endif

    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-2xl p-8 md:p-10 shadow-sm border border-gray-100">
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900 mb-2">Yeni Ürün Ekle</h1>
                <p class="text-gray-500 text-sm">Kataloğa yeni bir ürün ekleyin.</p>
            </div>

            @error('form_error')
                <div class="bg-red-50 text-red-600 text-sm p-3 rounded-lg border border-red-100 mb-6">{{ $message }}</div>
            @enderror

            <form wire:submit.prevent="createProduct" class="space-y-4">
                <div>
                    <label class="text-xs font-medium text-gray-500 mb-1 block">Ürün Adı</label>
                    <input type="text" wire:model="product_name"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all"
                        placeholder="Örn: Akıllı Saat">
                    @error('product_name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="text-xs font-medium text-gray-500 mb-1 block">Fiyat (₺)</label>
                    <input type="number" step="0.01" wire:model="product_price"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all"
                        placeholder="Örn: 1999.99">
                    @error('product_price') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="text-xs font-medium text-gray-500 mb-1 block">Açıklama</label>
                    <textarea wire:model="description"
                        class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all"
                        rows="5" placeholder="Ürünün detaylı açıklaması..."></textarea>
                    @error('description') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <button type="submit"
                    class="w-full bg-red-600 hover:bg-red-700 text-white py-2.5 rounded-lg text-sm font-medium transition-colors">
                    <span wire:loading.remove>Ürünü Kaydet</span>
                    <span wire:loading>Gönderiliyor...</span>
                </button>
                <p class="text-center text-xs text-gray-400">Ürünler admin onayından sonra yayınlanır.</p>
            </form>
        </div>

        <div class="mt-6 text-center">
            <a href="/" class="text-sm text-gray-400 hover:text-red-600 transition-colors">← Vazgeç ve geri dön</a>
        </div>
    </div>
</div>
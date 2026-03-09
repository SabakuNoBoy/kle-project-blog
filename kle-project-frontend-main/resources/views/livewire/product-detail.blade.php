<div>
    <div class="max-w-2xl mx-auto">
        @if($product)
            <div class="bg-white rounded-2xl p-8 md:p-10 shadow-sm border border-gray-100">

                @if(session('success'))
                    <div class="bg-green-50 text-green-600 text-sm p-3 rounded-lg border border-green-100 mb-6">
                        {{ session('success') }}</div>
                @endif
                @if($errors->has('form'))
                    <div class="bg-red-50 text-red-600 text-sm p-3 rounded-lg border border-red-100 mb-6">
                        {{ $errors->first('form') }}</div>
                @endif

                @if(!$editMode)
                    <div class="flex flex-col md:flex-row justify-between items-start mb-6 pb-6 border-b border-gray-100">
                        <div>
                            <span class="text-xs font-medium text-red-600 bg-red-50 px-2 py-0.5 rounded inline-block mb-3">Ürün
                                Detayı</span>
                            <h2 class="text-2xl font-bold text-gray-900 mb-3">{{ $product['product_name'] }}</h2>
                            @if(!($product['is_approved'] ?? false))
                                <span
                                    class="inline-flex items-center gap-1 bg-amber-50 text-amber-700 text-xs px-2.5 py-1 rounded border border-amber-200 mb-3">
                                    Admin Onayı Bekliyor
                                </span>
                            @endif
                            <div class="flex items-center gap-2 text-sm text-gray-500">
                                <div
                                    class="w-6 h-6 rounded-full bg-gray-100 flex items-center justify-center text-[10px] font-medium text-gray-500">
                                    {{ substr($product['user']['name'] ?? 'U', 0, 1) }}
                                </div>
                                <span>{{ $product['user']['name'] ?? 'Kullanıcı' }}</span>
                                <span class="text-gray-300">·</span>
                                <span
                                    class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($product['created_at'])->format('d M Y') }}</span>
                            </div>
                        </div>
                        <div class="mt-4 md:mt-0">
                            <span
                                class="text-xl font-bold text-green-600 bg-green-50 px-4 py-2 rounded-lg border border-green-100">
                                ₺{{ number_format($product['product_price'], 2) }}
                            </span>
                        </div>
                    </div>

                    <div class="text-gray-600 leading-relaxed mb-6">
                        {!! nl2br(e($product['description'])) !!}
                    </div>

                    @if($isOwner)
                        <div class="flex gap-2 pt-4 border-t border-gray-100">
                            <button wire:click="enableEditMode"
                                class="bg-gray-900 hover:bg-gray-800 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">Düzenle</button>
                            <button wire:click="deleteProduct"
                                onclick="confirm('Bu ürünü silmek istediğinize emin misiniz?') || event.stopImmediatePropagation()"
                                class="bg-red-50 hover:bg-red-100 text-red-600 px-4 py-2 rounded-lg text-sm font-medium transition-colors border border-red-200">Sil</button>
                        </div>
                    @endif
                @else
                    <div class="mb-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-1">Ürünü Düzenle</h2>
                        <p class="text-gray-500 text-sm">Mevcut ürün bilgilerini güncelleyin.</p>
                    </div>

                    <form wire:submit.prevent="updateProduct" class="space-y-4">
                        <div>
                            <label class="text-xs font-medium text-gray-500 mb-1 block">Ürün Adı</label>
                            <input type="text" wire:model="product_name"
                                class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all">
                            @error('product_name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="text-xs font-medium text-gray-500 mb-1 block">Fiyat (₺)</label>
                            <input type="number" step="0.01" wire:model="product_price"
                                class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all">
                            @error('product_price') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label class="text-xs font-medium text-gray-500 mb-1 block">Açıklama</label>
                            <textarea wire:model="description"
                                class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all"
                                rows="5"></textarea>
                            @error('description') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div class="flex gap-2">
                            <button type="submit"
                                class="flex-1 bg-red-600 hover:bg-red-700 text-white py-2.5 rounded-lg text-sm font-medium transition-colors">
                                <span wire:loading.remove wire:target="updateProduct">Güncelle</span>
                                <span wire:loading wire:target="updateProduct">Güncelleniyor...</span>
                            </button>
                            <button type="button" wire:click="cancelEdit"
                                class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-5 py-2.5 rounded-lg text-sm font-medium transition-colors">İptal</button>
                        </div>
                    </form>
                @endif

                <div class="mt-6 pt-4 {{ !$editMode ? 'border-t border-gray-100' : '' }}">
                    <a href="/" wire:navigate class="text-sm text-gray-400 hover:text-red-600 transition-colors">← Ana
                        Sayfaya Dön</a>
                </div>
            </div>
        @else
            <div class="text-center py-16">
                <svg class="animate-spin h-8 w-8 text-red-600 mx-auto mb-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg>
                <p class="text-sm text-gray-400">Yükleniyor...</p>
            </div>
        @endif
    </div>
</div>
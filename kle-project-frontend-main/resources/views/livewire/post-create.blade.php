<div>
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-2xl p-8 md:p-10 shadow-sm border border-gray-100">
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900 mb-2">Yeni Yazı Oluştur</h1>
                <p class="text-gray-500 text-sm">Düşüncelerinizi yazıya dökün ve topluluğumuzla paylaşın.</p>
            </div>

            <form wire:submit="createPost" class="space-y-5">
                <div>
                    <label class="text-xs font-medium text-gray-500 mb-1 block">Başlık</label>
                    <input type="text" wire:model="title"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all"
                        placeholder="Yazı başlığı...">
                    @error('title') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="text-xs font-medium text-gray-500 mb-1 block">Kategori</label>
                    <select wire:model="category_id"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all">
                        <option value="">Kategori seçin...</option>
                        @foreach($categories as $category)
                            <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="text-xs font-medium text-gray-500 mb-1 block">İçerik</label>
                    <textarea wire:model="content"
                        class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all"
                        rows="8" placeholder="Yazınızı buraya yazın..."></textarea>
                    @error('content') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-medium text-gray-500 block">Kapak Görseli</label>
                    
                    @error('image')
                        <div class="bg-red-50 text-red-600 text-sm p-4 rounded-xl border border-red-100 flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            <span>Resim eklenemedi veya çok büyük: {{ $message }}</span>
                        </div>
                    @enderror

                    <div class="relative border-2 border-dashed border-gray-200 rounded-xl p-6 text-center hover:border-red-300 transition-colors @error('image') border-red-300 bg-red-50 @enderror">
                        <input type="file" wire:model.live="image"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" accept="image/*">
                        
                        @if ($image && !$errors->has('image'))
                            <div class="w-full h-48 overflow-hidden rounded-lg">
                                <img src="{{ $image->temporaryUrl() }}" class="w-full h-full object-cover">
                            </div>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-300 mx-auto mb-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-xs text-gray-400">Tıklayarak yükleyin · PNG, JPG (max 2MB)</p>
                        @endif
                        
                        <!-- Uploading indicator -->
                        <div wire:loading wire:target="image" class="absolute inset-0 bg-white/90 flex items-center justify-center rounded-xl z-20">
                            <span class="text-sm font-medium text-gray-600">Yükleniyor...</span>
                        </div>
                    </div>
                </div>

                @if(session()->has('message'))
                    <div class="bg-green-50 text-green-600 text-sm p-3 rounded-lg border border-green-100">
                        {{ session('message') }}
                    </div>
                @endif

                @error('form_error')
                    <div class="bg-red-50 text-red-600 text-sm p-3 rounded-lg border border-red-100">
                        {{ $message }}
                    </div>
                @enderror

                <button type="submit"
                    class="w-full bg-red-600 hover:bg-red-700 text-white py-2.5 rounded-lg text-sm font-medium transition-colors">
                    Yayınla
                </button>
                <p class="text-center text-xs text-gray-400">Yazılar yayınlanmadan önce admin onayından geçer.</p>
            </form>
        </div>

        <div class="mt-6 text-center">
            <a href="/dashboard" wire:navigate class="text-sm text-gray-400 hover:text-red-600 transition-colors">←
                İptal et ve geri dön</a>
        </div>
    </div>
</div>
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

                <div>
                    <label class="text-xs font-medium text-gray-500 mb-1 block">Kapak Görseli</label>
                    <div
                        class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center hover:border-red-300 transition-colors relative">
                        <input type="file" wire:model="image"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-300 mx-auto mb-2" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="text-xs text-gray-400">Tıklayarak yükleyin · PNG, JPG (max 2MB)</p>
                    </div>
                    @error('image') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
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
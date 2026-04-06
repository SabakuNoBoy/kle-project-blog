<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Yazıyı Düzenle</h1>
            <p class="mt-2 text-sm text-gray-600">Yazınızın içeriğini ve görselini buradan güncelleyebilirsiniz.</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <form wire:submit.prevent="updatePost" class="p-8">
                @error('form_error')
                    <div class="mb-6 p-4 bg-red-50 border border-red-100 text-red-600 rounded-xl text-sm">
                        {{ $message }}
                    </div>
                @enderror

                <div class="space-y-6">
                    {{-- Title --}}
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Başlık</label>
                        <input wire:model="title" type="text" id="title"
                            class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-all placeholder:text-gray-400"
                            placeholder="Yazınızın başlığını girin...">
                        @error('title') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- Category --}}
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                        <select wire:model="category_id" id="category_id"
                            class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-all appearance-none bg-white">
                            <option value="">Kategori Seçin</option>
                            @foreach($categories as $category)
                                <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- Image --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kapak Görseli</label>

                        <div class="mt-2 flex items-center gap-6">
                            @if ($image)
                                <div class="relative w-40 h-40 rounded-xl overflow-hidden bg-gray-100 ring-1 ring-gray-200">
                                    <img src="{{ $image->temporaryUrl() }}" class="w-full h-full object-cover">
                                </div>
                            @elseif ($existingImageUrl)
                                <div class="relative w-40 h-40 rounded-xl overflow-hidden bg-gray-100 ring-1 ring-gray-200">
                                    <img src="{{ $existingImageUrl }}" class="w-full h-full object-cover">
                                </div>
                            @endif

                            <div class="flex-1">
                                <label
                                    class="relative cursor-pointer bg-white rounded-xl py-3 px-4 border-2 border-dashed border-gray-200 hover:border-red-400 transition-colors flex flex-col items-center justify-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                    </svg>
                                    <span class="text-sm font-medium text-gray-600">Yeni görsel yükleyin</span>
                                    <span class="text-xs text-gray-400 font-normal">PNG, JPG up to 5MB</span>
                                    <input type="file" wire:model="image" class="hidden">
                                </label>
                            </div>
                        </div>
                        @error('image') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- Content --}}
                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-1">İçerik</label>
                        <textarea wire:model="content" id="content" rows="12"
                            class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-all placeholder:text-gray-400"
                            placeholder="Yazınızın içeriğini buraya yazın..."></textarea>
                        @error('content') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="mt-8 flex items-center justify-between border-t border-gray-50 pt-8">
                    <button type="button" wire:click="deletePost" wire:confirm="Bu yazıyı silmek istediğinizden emin misiniz? Bu işlem geri alınamaz."
                        class="px-6 py-2.5 text-red-600 font-medium hover:bg-red-50 rounded-xl transition-all flex items-center gap-2 group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Yazıyı Sil
                    </button>

                    <div class="flex items-center gap-3">
                        <a href="/dashboard" wire:navigate
                            class="px-6 py-2.5 text-gray-700 font-medium hover:bg-gray-50 rounded-xl transition-colors">
                            İptal
                        </a>
                        <button type="submit" wire:loading.attr="disabled"
                            class="px-8 py-2.5 bg-red-600 text-white font-semibold rounded-xl hover:bg-red-700 focus:ring-4 focus:ring-red-500/20 active:scale-[0.98] transition-all disabled:opacity-50 disabled:pointer-events-none shadow-sm shadow-red-200">
                            <span wire:loading.remove>Güncelle</span>
                            <span wire:loading>Güncelleniyor...</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
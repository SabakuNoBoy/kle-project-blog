<div>
    {{-- Header --}}
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Keşfet</h1>
                <p class="text-gray-500 text-sm mt-1">Teknoloji, tasarım ve yazılım hakkında güncel yazılar</p>
            </div>

            @if(session('api_token'))
                <a href="/post/create" wire:navigate
                    class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-5 py-2.5 rounded-full text-sm font-medium transition-colors shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Oluştur
                </a>
            @endif
        </div>

        {{-- Search & Filter --}}
        <div class="flex flex-col md:flex-row items-stretch md:items-center gap-4">
            {{-- Search Bar --}}
            <div class="relative flex-1 group">
                <input type="text" wire:model.live.debounce.300ms="search"
                    class="w-full bg-white/90 backdrop-blur-md border border-gray-100 shadow-sm rounded-full py-2.5 pl-12 pr-4 text-center text-sm focus:ring-4 focus:ring-red-500/10 focus:border-red-500/30 transition-all hover:bg-white placeholder-gray-400"
                    placeholder="Gönderilerde ara...">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 transition-colors group-hover:text-red-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>

            {{-- Filter Dropdown --}}
            <div class="relative shrink-0" x-data="{ open: false }">
                <button @click="open = !open" @click.away="open = false"
                    class="flex items-center justify-between gap-3 bg-white/90 backdrop-blur-md border border-gray-100 shadow-sm hover:shadow-md px-5 py-2.5 rounded-full text-sm font-semibold text-gray-700 transition-all hover:bg-white min-w-[160px]">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        Kategoriler
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 transition-transform duration-200" :class="{'rotate-180': open}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                {{-- Dropdown Menu --}}
                <div x-show="open" 
                     x-transition.opacity.duration.200ms
                     style="display: none;"
                     class="absolute right-0 mt-3 w-56 bg-white/95 backdrop-blur-xl border border-gray-100 rounded-2xl shadow-xl overflow-hidden z-20">
                    
                    <div class="p-2 flex flex-col max-h-80 overflow-y-auto">
                        <button wire:click="setCategory(null); open = false"
                            class="text-left w-full px-4 py-3 rounded-xl text-sm font-medium transition-colors flex items-center justify-between {{ is_null($selectedCategory) ? 'bg-red-50 text-red-600' : 'text-gray-600 hover:bg-gray-50' }}">
                            Tümü
                            @if(is_null($selectedCategory))
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            @endif
                        </button>
                        
                        @foreach($categories as $category)
                            <button wire:click="setCategory('{{ $category['slug'] }}'); open = false"
                                class="text-left w-full px-4 py-3 rounded-xl text-sm font-medium transition-colors flex items-center justify-between {{ $selectedCategory === $category['slug'] ? 'bg-red-50 text-red-600' : 'text-gray-600 hover:bg-gray-50' }}">
                                {{ $category['name'] }}
                                @if($selectedCategory === $category['slug'])
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                @endif
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Pinterest-style Masonry Grid --}}
    <div class="columns-1 sm:columns-2 lg:columns-3 xl:columns-4 gap-4 space-y-4">
        @foreach($posts as $post)
            <a href="/post/{{ $post['slug'] }}" wire:navigate
                class="group block bg-white rounded-2xl overflow-hidden border border-gray-100 hover:shadow-md transition-all duration-300 break-inside-avoid mb-4">
                <div class="relative overflow-hidden">
                    <img src="{{ !empty($post['image_url']) ? (str_starts_with($post['image_url'], 'http') ? $post['image_url'] : 'http://localhost:8000' . $post['image_url']) : 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?q=80&w=800' }}"
                        class="w-full group-hover:scale-105 transition-transform duration-500" alt="{{ $post['title'] }}">
                </div>
                <div class="p-4">
                    <h3
                        class="text-sm font-semibold text-gray-900 group-hover:text-red-600 transition-colors mb-2 leading-snug line-clamp-2">
                        {{ $post['title'] }}
                    </h3>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div
                                class="w-6 h-6 rounded-full bg-gray-100 flex items-center justify-center text-[10px] font-semibold text-gray-500">
                                {{ substr($post['user']['name'] ?? 'U', 0, 1) }}
                            </div>
                            <span class="text-xs text-gray-400">{{ $post['user']['name'] ?? 'Yazar' }}</span>
                        </div>
                        <span
                            class="text-[10px] text-gray-300">{{ \Carbon\Carbon::parse($post['created_at'])->format('d M') }}</span>
                    </div>
                </div>
            </a>
        @endforeach
    </div>

    @if(empty($posts))
        <div class="py-20 text-center">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-gray-400" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M9 12h6m-3-3v6m-7 4h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Yazı bulunamadı</h3>
            <p class="text-gray-500 text-sm">Arama kriterlerinize uygun yazı yok.</p>
        </div>
    @endif

</div>
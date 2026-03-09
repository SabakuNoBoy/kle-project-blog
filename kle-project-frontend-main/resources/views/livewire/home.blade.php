<div>
    {{-- Error Alert --}}
    @if($error)
        <div class="mb-6 flex items-start gap-3 bg-red-50 border border-red-100 text-red-600 rounded-2xl px-5 py-4 text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ $error }}
        </div>
    @endif

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
        <div class="relative z-50 flex flex-col md:flex-row items-stretch md:items-center gap-4">
            {{-- Search Bar --}}
            <div class="relative flex-1 group">
                <input type="text" wire:model.live.debounce.300ms="search"
                    class="w-full bg-white border border-gray-100 shadow-sm rounded-full py-2.5 pl-12 pr-4 text-center text-sm focus:ring-4 focus:ring-red-500/10 focus:border-red-500/30 transition-all hover:shadow-md placeholder-gray-400"
                    placeholder="Gönderilerde ara...">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 transition-colors group-hover:text-red-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>

            {{-- Date Filter --}}
            <div class="relative shrink-0 flex items-center bg-white border border-gray-100 shadow-sm px-4 py-1.5 rounded-full hover:shadow-md transition-all group">
                 <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2 group-hover:text-red-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                 </svg>
                 <input type="month" wire:model.live="selectedDate" class="bg-transparent border-none text-sm font-semibold text-gray-700 py-1 focus:ring-0 cursor-pointer outline-none">
            </div>

            {{-- Filter Dropdown --}}
            <div class="relative shrink-0" x-data="{ open: false }">
                <button @click="open = !open" @click.away="open = false"
                    class="flex items-center justify-between gap-3 bg-white backdrop-blur-md border border-gray-100 shadow-sm hover:shadow-md px-5 py-2.5 rounded-full text-sm font-semibold text-gray-700 transition-all hover:bg-white min-w-[160px]">
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
                     class="absolute right-0 mt-3 w-56 bg-white backdrop-blur-xl border border-gray-100 rounded-2xl shadow-xl overflow-hidden z-20">
                    
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

            {{-- Author Dropdown --}}
            <div class="relative shrink-0" x-data="{ open: false }">
                <button @click="open = !open" @click.away="open = false"
                    class="flex items-center justify-between gap-3 bg-white backdrop-blur-md border border-gray-100 shadow-sm hover:shadow-md px-5 py-2.5 rounded-full text-sm font-semibold text-gray-700 transition-all hover:bg-white min-w-[160px]">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Yazarlar
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 transition-transform duration-200" :class="{'rotate-180': open}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                {{-- Dropdown Menu --}}
                <div x-show="open" 
                     x-transition.opacity.duration.200ms
                     style="display: none;"
                     class="absolute right-0 mt-3 w-56 bg-white backdrop-blur-xl border border-gray-100 rounded-2xl shadow-xl overflow-hidden z-20">
                    
                    <div class="p-2 flex flex-col max-h-80 overflow-y-auto">
                        <button wire:click="$set('selectedAuthor', null); open = false"
                            class="text-left w-full px-4 py-3 rounded-xl text-sm font-medium transition-colors flex items-center justify-between {{ is_null($selectedAuthor) ? 'bg-red-50 text-red-600' : 'text-gray-600 hover:bg-gray-50' }}">
                            Tümü
                            @if(is_null($selectedAuthor))
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            @endif
                        </button>
                        
                        @if(is_array($authors))
                            @foreach($authors as $author)
                                @if(is_array($author) && isset($author['id']))
                                    <button wire:click="$set('selectedAuthor', '{{ $author['id'] }}'); open = false"
                                        class="text-left w-full px-4 py-3 rounded-xl text-sm font-medium transition-colors flex items-center justify-between {{ $selectedAuthor == $author['id'] ? 'bg-red-50 text-red-600' : 'text-gray-600 hover:bg-gray-50' }}">
                                        {{ $author['name'] ?? 'Bilinmeyen' }}
                                        @if($selectedAuthor == $author['id'])
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        @endif
                                    </button>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>



        </div>
    </div>

    {{-- Pinterest-style Masonry Grid --}}
    <div class="columns-1 sm:columns-2 lg:columns-3 xl:columns-4 gap-4 space-y-4">
        @foreach($posts as $post)
            <a href="/post/{{ $post['slug'] }}" wire:navigate
                class="group block rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 break-inside-avoid mb-4 bg-gray-900">

                {{-- Image with overlays --}}
                <div class="relative overflow-hidden">
                    <img src="{{ !empty($post['image_url']) ? (str_starts_with($post['image_url'], 'http') ? $post['image_url'] : 'http://localhost:8000' . $post['image_url']) : 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?q=80&w=800' }}"
                        class="w-full object-cover group-hover:scale-105 transition-transform duration-500 brightness-90 group-hover:brightness-75"
                        alt="{{ $post['title'] }}">

                    {{-- Category badge — top left overlay --}}
                    @if(!empty($post['category']))
                        <a href="/category/{{ $post['category']['slug'] }}" wire:navigate
                           class="absolute top-3 left-3 z-10 text-[10px] font-semibold text-white bg-red-600/90 backdrop-blur-sm px-2.5 py-1 rounded-full hover:bg-red-700 transition-colors"
                           @click.stop>
                            {{ $post['category']['name'] }}
                        </a>
                    @endif

                    {{-- Dark gradient + title overlay at bottom --}}
                    <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent px-4 pt-10 pb-3">
                        <h3 class="text-sm font-semibold text-white leading-snug line-clamp-2 drop-shadow">
                            {{ $post['title'] }}
                        </h3>
                    </div>
                </div>

                {{-- Author row below image --}}
                <div class="flex items-center justify-between px-3 py-2 bg-white border-t border-gray-100">
                    <div class="flex items-center gap-1.5">
                        <div class="w-5 h-5 rounded-full bg-red-100 flex items-center justify-center text-[9px] font-bold text-red-600 shrink-0">
                            {{ strtoupper(substr($post['user']['name'] ?? 'U', 0, 1)) }}
                        </div>
                        <span class="text-[11px] text-gray-500 font-medium truncate max-w-[100px]">{{ $post['user']['name'] ?? 'Yazar' }}</span>
                    </div>
                    <div class="flex items-center gap-2 text-[10px] text-gray-400 shrink-0">
                        {{-- Comment count --}}
                        <span class="inline-flex items-center gap-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.77 9.77 0 01-4-.825L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            {{ $post['comments_count'] ?? 0 }}
                        </span>
                        <span>{{ \Carbon\Carbon::parse($post['created_at'])->format('d M') }}</span>
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
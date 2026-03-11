<div>
    <div class="mb-10">
        <div class="flex items-center gap-2 mb-3">
            <div
                class="w-8 h-8 bg-red-50 text-red-600 rounded-lg flex items-center justify-center text-sm font-semibold">
                #</div>
            <span class="text-xs font-medium text-gray-400 uppercase tracking-wider">Kategori</span>
        </div>
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3">{{ $category['name'] }}</h1>
        <p class="text-gray-500 text-sm">Bu kategoride {{ count($category['posts'] ?? []) }} yazı bulunmaktadır.</p>
    </div>

    {{-- Posts Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($category['posts'] ?? [] as $post)
            <a href="/post/{{ $post['slug'] }}" wire:navigate
                class="group block bg-white rounded-xl overflow-hidden border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                <div class="relative aspect-[4/3] overflow-hidden">
                    <img src="{{ !empty($post['image_url']) ? $post['image_url'] : 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?q=80&w=800' }}"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                        alt="{{ $post['title'] }}">
                </div>
                <div class="p-5">
                    <div class="flex items-center gap-2 mb-3">
                        <span
                            class="text-[10px] font-semibold text-red-600 bg-red-50 px-2 py-0.5 rounded">{{ $category['name'] }}</span>
                        <span class="text-gray-300">·</span>
                        <span
                            class="text-[10px] text-gray-400">{{ \Carbon\Carbon::parse($post['created_at'])->format('d M Y') }}</span>
                    </div>
                    <h3
                        class="text-base font-semibold text-gray-900 group-hover:text-red-600 transition-colors mb-3 line-clamp-2 leading-snug">
                        {{ $post['title'] }}
                    </h3>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div
                                class="w-6 h-6 rounded-full bg-gray-100 flex items-center justify-center text-[10px] font-semibold text-gray-500">
                                {{ substr($post['user']['name'] ?? 'U', 0, 1) }}
                            </div>
                            <span class="text-xs text-gray-500">{{ $post['user']['name'] ?? 'Yazar' }}</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="flex items-center gap-1 text-[10px] {{ ($post['is_liked'] ?? false) ? 'text-red-500' : 'text-gray-300 hover:text-red-500' }} font-bold transition-colors">
                                @if($post['is_liked'] ?? false)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 fill-none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                @endif
                                <span>{{ $post['likes_count'] ?? 0 }}</span>
                            </div>
                            {{-- Comment count --}}
                            <div class="flex items-center gap-1 text-[10px] text-gray-300 font-bold">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.77 9.77 0 01-4-.825L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                </svg>
                                <span>{{ $post['comments_count'] ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        @empty
            <div class="col-span-full py-16 text-center bg-white rounded-xl border border-gray-100">
                <p class="text-gray-500 text-sm mb-4">Bu kategoride henüz yazı yok.</p>
                <a href="/" wire:navigate
                    class="inline-block bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg text-sm font-medium transition-colors">
                    Diğer Kategorileri Keşfet
                </a>
            </div>
        @endforelse
    </div>
</div>
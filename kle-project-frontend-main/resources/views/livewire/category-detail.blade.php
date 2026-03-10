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
                    <img src="{{ !empty($post['image_url']) ? (str_starts_with($post['image_url'], 'http') ? $post['image_url'] : 'http://localhost:8000' . $post['image_url']) : 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?q=80&w=800' }}"
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
                    <div class="flex items-center gap-2">
                        <div
                            class="w-6 h-6 rounded-full bg-gray-100 flex items-center justify-center text-[10px] font-semibold text-gray-500">
                            {{ substr($post['user']['name'] ?? 'U', 0, 1) }}
                        </div>
                        <span class="text-xs text-gray-500">{{ $post['user']['name'] ?? 'Yazar' }}</span>
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
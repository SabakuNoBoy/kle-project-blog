<div>
    <div class="max-w-3xl mx-auto">
        {{-- Back --}}
        <a href="/" wire:navigate
            class="inline-flex items-center gap-1 text-sm text-gray-400 hover:text-gray-600 transition-colors mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Geri Dön
        </a>

        {{-- Header --}}
        <div class="mb-8">
            <div class="flex items-center gap-2 mb-3">
                <span
                    class="text-xs font-medium text-red-600 bg-red-50 px-2 py-0.5 rounded">{{ $post['category']['name'] }}</span>
                <span class="text-gray-300">·</span>
                <span
                    class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($post['created_at'])->format('d F Y') }}</span>
            </div>

            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 leading-tight mb-6">
                {{ $post['title'] }}
            </h1>

            <div class="flex items-center justify-between py-4 border-y border-gray-100">
                <div class="flex items-center gap-3">
                    <div
                        class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-sm font-medium text-gray-500">
                        {{ substr($post['user']['name'] ?? 'U', 0, 1) }}
                    </div>
                    <div>
                        <div class="text-sm font-medium text-gray-900">{{ $post['user']['name'] }}</div>
                        <div class="text-xs text-gray-400">Yazar</div>
                    </div>
                </div>

                {{-- Like Button --}}
                <button wire:click="toggleLike" class="flex items-center gap-2 group transition-all">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center transition-colors {{ $post['is_liked'] ? 'bg-red-50' : 'bg-gray-50 hover:bg-red-50' }}">
                        @if($post['is_liked'])
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 group-hover:text-red-600 fill-none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        @endif
                    </div>
                    <span class="text-sm font-medium {{ $post['is_liked'] ? 'text-red-600' : 'text-gray-500 group-hover:text-red-600' }}">
                        {{ $post['likes_count'] ?? 0 }} Beğeni
                    </span>
                </button>
            </div>
        </div>

        {{-- Image --}}
        @if(isset($post['image_url']))
            <div class="mb-8 rounded-xl overflow-hidden bg-gray-50 flex justify-center">
                <img src="{{ str_starts_with($post['image_url'], 'http') ? $post['image_url'] : 'http://localhost:8000/storage/' . $post['image_url'] }}" 
                     class="max-h-[500px] w-full object-contain" 
                     alt="{{ $post['title'] }}">
            </div>
        @endif

        {{-- Content --}}
        <article class="prose prose-gray max-w-none mb-12 text-gray-600 leading-relaxed">
            {!! $post['content'] !!}
        </article>

        {{-- Comments --}}
        <section class="pt-8 border-t border-gray-100" id="comments">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">
                Yorumlar <span class="text-gray-400 font-normal">({{ count($post['comments'] ?? []) }})</span>
            </h3>

            @if($isLoggedIn)
                <form wire:submit="submitComment" class="mb-8">
                    <textarea wire:model="commentContent"
                        class="w-full border border-gray-200 rounded-xl p-4 text-sm focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all"
                        rows="3" placeholder="Yorumunuzu yazın..."></textarea>

                    @error('commentContent') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    @error('comment_error') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror

                    @if(session()->has('comment_success'))
                        <div class="bg-green-50 text-green-600 text-sm p-3 rounded-lg border border-green-100 mt-3">
                            {{ session('comment_success') }}
                        </div>
                    @else
                        <div class="mt-3 flex justify-end">
                            <button type="submit"
                                class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg text-sm font-medium transition-colors">
                                Yorum Yap
                            </button>
                        </div>
                    @endif
                </form>
            @else
                <div class="bg-gray-50 rounded-xl p-6 text-center mb-8 border border-gray-100">
                    <p class="text-gray-500 text-sm mb-3">Yorum yapabilmek için giriş yapmalısınız.</p>
                    <a href="/login" wire:navigate
                        class="inline-block bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg text-sm font-medium transition-colors">Giriş
                        Yap</a>
                </div>
            @endif

            <div class="space-y-4">
                @forelse($post['comments'] ?? [] as $comment)
                    <div class="bg-white rounded-xl p-5 border border-gray-100">
                        <div class="flex items-center gap-3 mb-3">
                            <div
                                class="w-7 h-7 rounded-full bg-red-50 flex items-center justify-center text-xs font-medium text-red-600">
                                {{ substr($comment['user']['name'] ?? 'U', 0, 1) }}
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">{{ $comment['user']['name'] }}</div>
                                <div class="text-[10px] text-gray-400">
                                    {{ \Carbon\Carbon::parse($comment['created_at'])->diffForHumans() }}</div>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 leading-relaxed">{{ $comment['content'] }}</p>
                    </div>
                @empty
                    <p class="text-center text-sm text-gray-400 py-6">Henüz yorum yok. İlk yorumu siz yapın.</p>
                @endforelse
            </div>
        </section>
    </div>
</div>
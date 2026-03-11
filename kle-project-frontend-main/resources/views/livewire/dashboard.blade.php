<div>
    <div class="flex flex-col lg:flex-row gap-8">
        {{-- Sidebar --}}
        <div class="w-full lg:w-64 shrink-0">
            <div class="bg-white rounded-xl p-6 border border-gray-100 sticky top-20">
                <div class="text-center mb-6">
                    <div
                        class="w-14 h-14 rounded-full bg-red-50 flex items-center justify-center text-xl font-bold text-red-600 mx-auto mb-3">
                        {{ substr($user['name'] ?? 'U', 0, 1) }}
                    </div>
                    <h2 class="text-base font-semibold text-gray-900">{{ $user['name'] }}</h2>
                    <p class="text-xs text-gray-400 mt-1">{{ $user['email'] }}</p>
                </div>

                <nav class="space-y-1">
                    <a href="/dashboard"
                        class="flex items-center gap-2 px-3 py-2 rounded-lg bg-red-600 text-white text-sm font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        Genel Bakış
                    </a>
                    <a href="/post/create" wire:navigate
                        class="flex items-center gap-2 px-3 py-2 rounded-lg text-gray-600 hover:bg-gray-50 text-sm transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Yazı Oluştur
                    </a>
                    <div class="pt-4 mt-4 border-t border-gray-100">
                        <a href="/logout" wire:navigate
                            class="flex items-center gap-2 px-3 py-2 rounded-lg text-gray-400 hover:text-red-600 text-sm transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Çıkış Yap
                        </a>
                    </div>
                </nav>
            </div>
        </div>

        {{-- Main --}}
        <div class="flex-1">
            {{-- Stats --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <div class="bg-white p-5 rounded-xl border border-gray-100">
                    <div class="text-2xl font-bold text-gray-900">{{ $stats['posts_count'] }}</div>
                    <div class="text-xs text-gray-400 mt-1">Toplam Yazı</div>
                </div>
                <div class="bg-white p-5 rounded-xl border border-gray-100">
                    <div class="text-2xl font-bold text-gray-900">{{ $stats['likes_count'] }}</div>
                    <div class="text-xs text-gray-400 mt-1">Beğeni</div>
                </div>
                <div class="bg-white p-5 rounded-xl border border-gray-100">
                    <div class="text-2xl font-bold text-gray-900">{{ $stats['comments_count'] }}</div>
                    <div class="text-xs text-gray-400 mt-1">Yorum</div>
                </div>
            </div>

            {{-- User Posts --}}
            <div class="bg-white p-6 rounded-xl border border-gray-100 mb-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-900">Yazılarım</h3>
                    <a href="/post/create" wire:navigate class="text-sm font-medium text-red-600 hover:text-red-700 transition-colors">
                        + Yeni Yazı Ekle
                    </a>
                </div>

                @if(count($posts) > 0)
                    <div class="space-y-4">
                        @foreach($posts as $post)
                            <div class="flex items-start justify-between p-4 border border-gray-100 rounded-xl hover:border-gray-200 transition-colors">
                                <div>
                                    <h4 class="font-semibold text-gray-900 mb-1">
                                        @if($post['is_approved'])
                                            <a href="/post/{{ $post['slug'] }}" wire:navigate class="hover:text-red-600 transition-colors">
                                                <img src="{{ !empty($post['image_url']) ? $post['image_url'] : 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?q=80&w=800' }}" alt="{{ $post['title'] }}" class="w-10 h-10 object-cover rounded-md mr-2 inline-block">
                                                {{ $post['title'] }}
                                            </a>
                                        @else
                                            <span class="text-gray-900">{{ $post['title'] }}</span>
                                        @endif
                                    </h4>
                                    <div class="flex items-center gap-3 text-xs text-gray-400">
                                        <span>{{ \Carbon\Carbon::parse($post['created_at'])->format('d M Y') }}</span>
                                        <span>•</span>
                                        <span>{{ $post['category']['name'] ?? 'Kategori Yok' }}</span>
                                    </div>
                                </div>
                                <div class="shrink-0 ml-4 flex items-center gap-2">
                                    @if($post['is_approved'])
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-medium bg-green-50 text-green-600">
                                            Yayında
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-medium bg-yellow-50 text-yellow-600">
                                            Onay Bekliyor
                                        </span>
                                    @endif

                                    <div class="flex items-center gap-1 border-l pl-2 ml-2 border-gray-100">
                                        <a href="/post/{{ $post['id'] }}/edit" wire:navigate
                                            class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                            title="Düzenle">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-12 text-center border-2 border-dashed border-gray-100 rounded-xl">
                        <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002 2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <h4 class="text-sm font-medium text-gray-900 mb-1">Henüz hiç yazınız yok</h4>
                        <p class="text-xs text-gray-500 mb-4">İlk makalenizi hemen şimdi oluşturabilirsiniz.</p>
                        <a href="/post/create" wire:navigate class="inline-flex items-center text-sm font-medium text-red-600 hover:text-red-700">Maceraya Başla &rarr;</a>
                    </div>
                @endif
            </div>

            {{-- Profile Update Form --}}
            <div class="bg-white p-6 rounded-xl border border-gray-100">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Profil Bilgilerim</h3>

                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-50 text-green-700 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="mb-4 p-4 bg-red-50 text-red-700 rounded-lg">
                        {{ session('error') }}
                    </div>
                @endif

                <form wire:submit.prevent="updateProfile" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Ad Soyad</label>
                        <input type="text" wire:model="name"
                            class="w-full rounded-lg border border-gray-300 focus:ring-red-500 focus:border-red-500">
                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">E-posta</label>
                        <input type="email" wire:model="email"
                            class="w-full rounded-lg border border-gray-300 focus:ring-red-500 focus:border-red-500">
                        @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Yeni Şifre (İsteğe bağlı)</label>
                        <input type="password" wire:model="password"
                            class="w-full rounded-lg border border-gray-300 focus:ring-red-500 focus:border-red-500">
                        @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Yeni Şifre Tekrar</label>
                        <input type="password" wire:model="password_confirmation"
                            class="w-full rounded-lg border border-gray-300 focus:ring-red-500 focus:border-red-500">
                    </div>

                    <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 font-medium rounded-lg text-sm transition-colors">
                        Bilgileri Güncelle
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
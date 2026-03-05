<div>
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-2xl p-8 md:p-10 shadow-sm border border-gray-100">
            <div class="mb-8">
                <span class="text-xs font-medium text-red-600 uppercase tracking-wider">Yasal Belge</span>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mt-2 mb-4">{{ $agreement['title'] }}</h1>
                <div class="w-12 h-0.5 bg-red-600 rounded-full"></div>
            </div>

            <div class="prose prose-gray max-w-none text-gray-600 leading-relaxed">
                {!! nl2br(e($agreement['content'])) !!}
            </div>

            <div
                class="mt-10 pt-6 border-t border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-xs text-gray-400">
                    Son güncelleme: {{ \Carbon\Carbon::parse($agreement['updated_at'])->format('d M Y') }}
                </p>
            </div>
        </div>

        <div class="mt-6 text-center">
            <a href="/" wire:navigate class="text-sm text-gray-400 hover:text-red-600 transition-colors">← Ana Sayfaya
                Dön</a>
        </div>
    </div>
</div>
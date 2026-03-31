<x-filament-panels::page.simple>
    <div x-data="{ showLogin: false }" class="w-full">
        <!-- Initial Options View -->
        <div x-show="!showLogin" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100" class="flex flex-col space-y-4">
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold tracking-tight text-gray-950 dark:text-white">
                    Hoş Geldiniz
                </h2>

                @if(session()->has('error'))
                    <div class="mt-4 p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                        role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                    Lütfen devam etmek için bir seçenek belirleyin.
                </p>
            </div>

            <a href="{{ env('FRONTEND_URL', 'http://localhost:8001') }}"
                class="w-full justify-center text-center items-center gap-2 rounded-full border border-transparent bg-red-600 px-4 py-3 text-sm font-semibold text-gray-950 dark:text-white shadow-sm hover:focus:ring-2 hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-600 focus:ring-offset-2 transition">
                Siteye Dön
            </a>

            <button @click="showLogin = true" type="button"
                class="w-full justify-center text-center items-center gap-2 rounded-full border-2 border-red-600 bg-transparent px-4 py-3 text-sm font-semibold text-red-600 dark:text-red-500 dark:border-red-500 shadow-sm hover:bg-red-50 dark:hover:bg-red-500/10 focus:outline-none focus:ring-2 focus:ring-red-600 dark:focus:ring-red-500 focus:ring-offset-2 transition">
                Admin Girişi
            </button>
        </div>

        <!-- Real Login Form View -->
        <div x-show="showLogin" style="display: none;" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100">
            <button @click="showLogin = false" type="button"
                class="mb-6 flex items-center text-sm font-medium text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-500 transition">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Geri Dön
            </button>

            <x-filament-panels::form id="form" wire:submit="authenticate">
                {{ $this->form }}

                <x-filament-panels::form.actions :actions="$this->getCachedFormActions()"
                    :full-width="$this->hasFullWidthFormActions()" />
            </x-filament-panels::form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('livewire:navigated', () => {
            initSwal();
        });

        document.addEventListener('DOMContentLoaded', () => {
            initSwal();
        });

        window.addEventListener('swal', (event) => {
            const data = event.detail[0] || event.detail;
            fireSwal(data);
        });

        function initSwal() {
            @if(session()->has('swal'))
                fireSwal(@json(session('swal')));
            @endif
        }

        function fireSwal(data) {
            Swal.fire({
                title: data.title,
                text: data.text,
                icon: data.icon,
                confirmButtonColor: '#dc2626',
                confirmButtonText: 'Tamam',
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'rounded-xl px-8 py-3'
                }
            }).then((result) => {
                if (result.isConfirmed && data.redirect) {
                    window.location.href = data.redirect;
                }
            });
        }
    </script>
</x-filament-panels::page.simple>
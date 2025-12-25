<x-app-layout>
    <div class="py-16">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            @if(auth()->user()->role === 'admin')
                {{-- Админ панель --}}
                <div class="relative overflow-hidden bg-white shadow-lg border rounded-lg " style="border-color: #e2e2e2; ">
                    <!-- Градиентный декоративный элемент -->
                    <div class="absolute top-0 left-0 w-full h-2" style="background: linear-gradient(90deg, #67E1D2 0%, #285EC5 100%);"></div>
                    
                    <div class="p-8">
                        <div class="flex items-center justify-between mb-6 ">
                            <div>
                                <h1 class="text-3xl font-bold text-slate-900 mb-2 mt-2 ml-4">Admin Dashboard</h1>
                                <p class="text-slate-600 text-lg ml-4">Управление заявками и назначениями</p>
                            </div>
                            <div class="w-16 h-16 flex items-center justify-center" style="background: linear-gradient(90.82deg, #2A9EB1 0%, #283A89 100%); border-radius: 0;">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                        </div>

                        <!-- Статистика для админа -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                            <div class="bg-white p-5 border" style="border-color: #e2e2e2; border-radius: 0;">
                                <p class="text-sm text-slate-600 ">Всего заявок</p>
                                <p class="mt-2 text-3xl font-semibold" style="color: #345DAB;">{{ $stats['total'] }}</p>
                            </div>

                            <div class="bg-white p-5 border" style="border-color: #e2e2e2; border-radius: 0;">
                                <p class="text-sm text-slate-600">В работе</p>
                                <p class="mt-2 text-3xl font-semibold text-orange-600">{{ $stats['in_progress'] }}</p>
                            </div>

                            <div class="bg-white p-5 border" style="border-color: #e2e2e2; border-radius: 0;">
                                <p class="text-sm text-slate-600">Выполнено</p>
                                <p class="mt-2 text-3xl font-semibold text-green-600">{{ $stats['done'] }}</p>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <a href="{{ route('admin.tickets.index') }}"
                               class="inline-flex items-center px-6 py-3 text-white font-medium shadow-sm hover:opacity-95 transition"
                               style="background: linear-gradient(90.82deg, #2A9EB1 0%, #283A89 100%); border-radius: 0;">
                                Перейти в админку
                            </a>
                        </div>
                    </div>
                </div>
            @else
                {{-- Пользовательская панель --}}
                <div class="relative overflow-hidden bg-white shadow-lg border rounded-xl" style="border-color: #e2e2e2; ">
                    <!-- Градиентная полоска сверху -->
                    <div class="absolute top-0 left-0 w-full h-2" style="background: linear-gradient(90deg, #67E1D2 0%, #285EC5 100%);"></div>
                    
                    <div class="p-8">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h1 class="text-3xl font-bold text-slate-900 mb-2 mt-4 ml-4 ">QazaqGaz Service Desk</h1>
                                <p class="text-slate-600 text-lg ml-4">Система управления заявками</p>
                            </div>
                            <div class="hidden md:block">
                                <div class="w-20 h-20 flex items-center justify-center border" style="border-color: #e2e2e2; background: #FAFCFF; border-radius: 0;">
                                    <svg class="w-10 h-10" style="color: #345DAB;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Статистика пользователя -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                            <div class="bg-white p-5 border" style="border-color: #e2e2e2; border-radius: 0;">
                                <p class="text-sm text-slate-600">Мои заявки</p>
                                <p class="mt-2 text-3xl font-semibold" style="color: #345DAB;">{{ $stats['total'] }}</p>
                            </div>

                            <div class="bg-white p-5 border" style="border-color: #e2e2e2; border-radius: 0;">
                                <p class="text-sm text-slate-600">В обработке</p>
                                <p class="mt-2 text-3xl font-semibold text-orange-600">{{ $stats['in_progress'] }}</p>
                            </div>

                            <div class="bg-white p-5 border" style="border-color: #e2e2e2; border-radius: 0;">
                                <p class="text-sm text-slate-600">Решено</p>
                                <p class="mt-2 text-3xl font-semibold text-green-600">{{ $stats['done'] }}</p>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-3">
                            <a href="{{ route('tickets.create') }}"
                               class="inline-flex items-center justify-center px-6 py-3 text-white font-medium shadow-sm hover:opacity-95 transition"
                               style="background: linear-gradient(90.82deg, #2A9EB1 0%, #283A89 100%); border-radius: 0;">
                                Создать заявку
                            </a>

                            <a href="{{ route('tickets.index') }}"
                               class="inline-flex items-center justify-center px-6 py-3 font-medium border-2 bg-white hover:bg-slate-50 transition"
                               style="border-color: #345DAB; color: #345DAB; border-radius: 0;">
                                Мои заявки
                            </a>
                        </div>
                    </div>
                </div>
            @endif

                
    </div>
</x-app-layout>
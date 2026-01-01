<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            @if(auth()->user()->role === 'admin')
                {{-- Админ панель --}}
                <div class="relative overflow-hidden bg-white border border-slate-200 rounded-2xl shadow-sm">
                    {{-- top accent --}}
                    <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-cyan-400 via-sky-600 to-indigo-700"></div>

                    <div class="p-6 sm:p-8">
                        <div class="flex items-start sm:items-center justify-between gap-6 mb-6">
                            <div>
                                <h1 class="text-2xl sm:text-3xl font-semibold text-slate-900">
                                    Admin Dashboard
                                </h1>
                                <p class="mt-1 text-slate-600">
                                    Управление заявками и назначениями
                                </p>
                            </div>

                            <div class="shrink-0 w-12 h-12 sm:w-14 sm:h-14 rounded-xl flex items-center justify-center
                                        bg-gradient-to-br from-cyan-500 to-indigo-700">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                        </div>

                        {{-- Статистика --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="rounded-2xl border border-slate-200 bg-slate-50/60 p-5">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm text-slate-600">Всего заявок</p>
                                    <span class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </span>
                                </div>
                                <div class="mt-3 text-3xl font-semibold" style="color:#345DAB;">
                                    {{ $stats['total'] }}
                                </div>
                            </div>

                            <div class="rounded-2xl border border-slate-200 bg-orange-50/60 p-5">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm text-slate-600">В работе</p>
                                    <span class="w-10 h-10 rounded-xl bg-white border border-orange-200 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </span>
                                </div>
                                <div class="mt-3 text-3xl font-semibold text-orange-600">
                                    {{ $stats['in_progress'] }}
                                </div>
                            </div>

                            <div class="rounded-2xl border border-slate-200 bg-green-50/60 p-5">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm text-slate-600">Выполнено</p>
                                    <span class="w-10 h-10 rounded-xl bg-white border border-green-200 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </span>
                                </div>
                                <div class="mt-3 text-3xl font-semibold text-green-600">
                                    {{ $stats['done'] }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <a href="{{ route('admin.tickets.index') }}"
                               class="inline-flex items-center justify-center px-6 py-3 rounded-xl text-white font-medium shadow-sm hover:opacity-95 transition
                                      bg-gradient-to-r from-cyan-500 to-indigo-700">
                                Перейти в админку
                            </a>
                        </div>
                    </div>
                </div>

            @else
                {{-- Пользовательская панель --}}
                <div class="relative overflow-hidden bg-white border border-slate-200 rounded-2xl shadow-sm">
                    {{-- top accent --}}
                    <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-cyan-400 via-sky-600 to-indigo-700"></div>

                    <div class="p-6 sm:p-8">
                        <div class="flex items-start sm:items-center justify-between gap-6 mb-6">
                            <div>
                                <h1 class="text-2xl sm:text-3xl font-semibold text-slate-900">
                                    QazaqGaz Service Desk
                                </h1>
                                <p class="mt-1 text-slate-600">
                                    Система управления заявками
                                </p>
                            </div>

                            <div class="hidden md:flex w-14 h-14 rounded-xl items-center justify-center border border-slate-200 bg-slate-50">
                                <svg class="w-7 h-7" style="color:#345DAB;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                        </div>

                        {{-- Статистика пользователя --}}
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                            {{-- Мои заявки --}}
                            <div class="rounded-2xl border border-slate-200 bg-slate-50/60 p-5">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm text-slate-600">Мои заявки</p>
                                    <span class="text-xs px-2 py-1 rounded-lg bg-white border border-slate-200 text-slate-600">
                                        total
                                    </span>
                                </div>
                                <div class="mt-3 text-3xl font-semibold" style="color:#345DAB;">
                                    {{ $stats['total'] }}
                                </div>
                                <div class="mt-2 text-sm text-slate-500">
                                    Все созданные вами заявки
                                </div>
                            </div>

                            {{-- В обработке + превью --}}
                            <div class="rounded-2xl border border-orange-200 bg-orange-50/60 p-5">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm text-slate-700">В обработке</p>
                                    <div class="text-3xl font-semibold text-orange-600">
                                        {{ $stats['in_progress'] }}
                                    </div>
                                </div>
                                <div class="mt-4 space-y-2">
                                    @forelse($inProgressPreview as $t)
                                    <a href="{{ route('tickets.index') }}#ticket-{{ $t->id }}"
                                    class="group flex items-center gap-3 rounded-xl bg-white/80 border border-orange-200 px-3 py-2 hover:bg-white hover:shadow-sm transition">
                                    <span class="text-xs font-semibold text-orange-700">№ {{ $t->id }}</span>
                                    <span class="text-sm text-slate-700 truncate flex-1">{{ $t->title }}</span>
                                </a>
                                @empty
                                <div class="text-sm text-slate-500">
                                    Нет заявок в работе
                                </div>
                                @endforelse
                            </div>
                            <a href="{{ route('tickets.index') }}?status=in_progress" class="mt-4 inline-flex items-center gap-1 text-sm font-medium text-orange-700 hover:text-orange-800 transition">
                                Смотреть все <span class="translate-y-[1px]">→</span>
                            </a>
                        </div>
                        {{-- Решено + превью --}}
                        <div class="rounded-2xl border border-green-200 bg-green-50/60 p-5">
                            <div class="flex items-center justify-between">
                                <p class="text-sm text-slate-700">Решено</p>
                                <div class="text-3xl font-semibold text-green-600">
                                    {{ $stats['done'] }}
                                </div>
                            </div>
                            <div class="mt-4 space-y-2">
                                @forelse($donePreview as $t)
                                <a href="{{ route('tickets.index') }}#ticket-{{ $t->id }}" class="group flex items-center gap-3 rounded-xl bg-white/80 border border-green-200 px-3 py-2 hover:bg-white hover:shadow-sm transition">
                                    <span class="text-xs font-semibold text-green-700">№ {{ $t->id }}</span>
                                    <span class="text-sm text-slate-700 truncate flex-1">{{ $t->title }}</span>
                                </a>
                                @empty
                                <div class="text-sm text-slate-500">
                                    Нет завершенных заявок
                                </div>
                                @endforelse
                            </div>
                            <a href="{{ route('tickets.index') }}?status=done" class="mt-4 inline-flex items-center gap-1 text-sm font-medium text-green-700 hover:text-green-800 transition">
                                Смотреть все <span class="translate-y-[1px]">→</span>
                            </a>
                            </div> 
                       

                        {{-- Кнопки --}}
                        <div class="mt-6 flex flex-col sm:flex-row gap-3">
                            <a href="{{ route('tickets.create') }}"
                               class="inline-flex items-center justify-center px-6 py-3 rounded-xl text-white font-medium shadow-sm hover:opacity-95 transition
                                      bg-gradient-to-r from-cyan-500 to-indigo-700">
                                Создать заявку
                            </a>

                            <a href="{{ route('tickets.index') }}"
                               class="inline-flex items-center justify-center px-6 py-3 rounded-xl font-medium border bg-white hover:bg-slate-50 transition"
                               style="border-color:#345DAB; color:#345DAB;">
                                Мои заявки
                            </a>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
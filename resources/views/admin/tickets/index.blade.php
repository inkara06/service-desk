<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @php
                // Какие параметры считаем "фильтрами" (не q)
                $filterKeys = ['status','priority','assignee_id','from','to'];
                $hasFilters = request()->hasAny($filterKeys);
            @endphp

            {{-- Header --}}
            <div class="relative overflow-hidden bg-white border border-slate-200 rounded-2xl shadow-sm">
                <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-cyan-400 via-sky-600 to-indigo-700"></div>

                <div class="p-6 sm:p-8">
                    <h1 class="text-2xl sm:text-3xl font-semibold text-slate-900">Админка: все заявки</h1>
                    <p class="mt-1 text-slate-600">Поиск и управление статусами</p>
                </div>
            </div>

            {{-- SEARCH + ADVANCED FILTERS (единственный form) --}}
            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden"
                 x-data="{ advOpen: false }">
                <div class="h-1.5 bg-gradient-to-r from-cyan-400 via-sky-600 to-indigo-700"></div>

                <form method="GET" action="{{ route('admin.tickets.index') }}" class="p-4 sm:p-5">
                    {{-- Top row --}}
                    <div class="flex flex-col lg:flex-row lg:items-end gap-3">
                        <div class="flex-1">
                            <label class="block text-xs font-semibold text-slate-600 mb-1">Поиск</label>
                            <input
                                type="text"
                                name="q"
                                value="{{ request('q') }}"
                                placeholder="ID / тема / описание / автор"
                                class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm
                                       focus:outline-none focus:ring-2 focus:ring-cyan-300"
                            >
                        </div>

                        <div class="flex flex-wrap gap-2">
                            <button type="button"
                                    @click="advOpen = !advOpen"
                                    class="px-4 py-2 rounded-xl border border-slate-200 bg-white text-sm font-medium text-slate-700
                                           hover:bg-slate-50 transition whitespace-nowrap">
                                Расширенный поиск
                                @if($hasFilters)
                                    <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-semibold
                                                 bg-amber-50 text-amber-800 border border-amber-200">
                                        Фильтры активны
                                    </span>
                                @endif
                                <span class="ml-2 text-slate-400" x-text="advOpen ? '▲' : '▼'"></span>
                            </button>

                            <button
                                class="px-5 py-2 rounded-xl text-white text-sm font-medium shadow-sm hover:opacity-95 transition whitespace-nowrap"
                                style="background: linear-gradient(90.82deg,#2A9EB1 0%,#283A89 100%);"
                            >
                                Найти
                            </button>

                            @if(request()->query())
                                <a href="{{ route('admin.tickets.index') }}"
                                   class="px-4 py-2 rounded-xl border border-slate-200 bg-white text-sm font-medium text-slate-700
                                          hover:bg-slate-50 transition whitespace-nowrap">
                                    Сброс
                                </a>
                            @endif
                        </div>
                    </div>

                    {{-- Advanced dropdown --}}
                    <div x-show="advOpen" x-transition class="mt-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">

                            {{-- Status --}}
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">Статус</label>
                                <select name="status"
                                        class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm
                                               focus:outline-none focus:ring-2 focus:ring-cyan-300">
                                    <option value="">Все</option>
                                    <option value="new" @selected(request('status')==='new')>Новая</option>
                                    <option value="in_progress" @selected(request('status')==='in_progress')>В обработке</option>
                                    <option value="done" @selected(request('status')==='done')>Решено</option>
                                    <option value="rejected" @selected(request('status')==='rejected')>Отклонено</option>
                                </select>
                            </div>

                            {{-- Priority --}}
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">Приоритет</label>
                                <select name="priority"
                                        class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm
                                               focus:outline-none focus:ring-2 focus:ring-cyan-300">
                                    <option value="">Все</option>
                                    @foreach($priorities as $p)
                                        <option value="{{ $p }}" @selected(request('priority')===$p)>{{ $p }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Assignee --}}
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">Исполнитель</label>
                                <select name="assignee_id"
                                        class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm
                                               focus:outline-none focus:ring-2 focus:ring-cyan-300">
                                    <option value="">Все</option>
                                    @foreach($assignees as $a)
                                        <option value="{{ $a->id }}" @selected((string)request('assignee_id')===(string)$a->id)>
                                            {{ $a->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- From --}}
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">С даты</label>
                                <input type="date" name="from" value="{{ request('from') }}"
                                       class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm
                                              focus:outline-none focus:ring-2 focus:ring-cyan-300">
                            </div>

                            {{-- To --}}
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">По дату</label>
                                <input type="date" name="to" value="{{ request('to') }}"
                                       class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm
                                              focus:outline-none focus:ring-2 focus:ring-cyan-300">
                            </div>

                        </div>

                        <div class="mt-3 text-xs text-slate-500">
                            Подсказка: пустые поля не влияют на поиск.
                        </div>
                    </div>
                </form>
            </div>

            {{-- Table --}}
            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-600 uppercase tracking-wider">ID</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-600 uppercase tracking-wider">Название</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-600 uppercase tracking-wider">Автор</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-600 uppercase tracking-wider">Категория</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-600 uppercase tracking-wider">Приоритет</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-600 uppercase tracking-wider">Статус</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-600 uppercase tracking-wider">Исполнитель</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-600 uppercase tracking-wider">Срок</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-200">
                            @forelse($tickets as $t)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap font-semibold" style="color:#345DAB;">
                                        #{{ $t->id }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="font-medium text-slate-900">{{ $t->title }}</div>
                                        @if(!empty($t->description))
                                            <div class="text-xs text-slate-500 mt-1">
                                                {{ \Illuminate\Support\Str::limit($t->description, 70) }}
                                            </div>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-slate-600">
                                        {{ $t->author?->email ?? '—' }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-slate-600">
                                        {{ $t->category ?? '—' }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-slate-600">
                                        {{ $t->priority ?? '—' }}
                                    </td>

                                    {{-- Статус --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <form method="POST" action="{{ route('admin.tickets.status', $t) }}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="assignee_id" value="{{ $t->assignee_id }}">
                                            <input type="hidden" name="due_date" value="{{ $t->due_date }}">

                                            <select name="status"
                                                    class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm
                                                           focus:outline-none focus:ring-2 focus:ring-cyan-300"
                                                    onchange="this.form.submit()">
                                                <option value="new" @selected($t->status==='new')>Новая</option>
                                                <option value="in_progress" @selected($t->status==='in_progress')>В обработке</option>
                                                <option value="done" @selected($t->status==='done')>Решено</option>
                                                <option value="rejected" @selected($t->status==='rejected')>Отклонено</option>
                                            </select>
                                        </form>
                                    </td>

                                    {{-- Исполнитель --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <form method="POST" action="{{ route('admin.tickets.status', $t) }}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="{{ $t->status }}">
                                            <input type="hidden" name="due_date" value="{{ $t->due_date }}">

                                            <select name="assignee_id"
                                                    class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm
                                                           focus:outline-none focus:ring-2 focus:ring-cyan-300"
                                                    onchange="this.form.submit()">
                                                <option value="">—</option>
                                                @foreach($assignees as $a)
                                                    <option value="{{ $a->id }}" @selected((string)$t->assignee_id === (string)$a->id)>
                                                        {{ $a->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </form>
                                    </td>

                                    {{-- Срок --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <form method="POST" action="{{ route('admin.tickets.status', $t) }}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="{{ $t->status }}">
                                            <input type="hidden" name="assignee_id" value="{{ $t->assignee_id }}">

                                            <input type="date"
                                                   name="due_date"
                                                   value="{{ $t->due_date }}"
                                                   class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm
                                                          focus:outline-none focus:ring-2 focus:ring-cyan-300"
                                                   onchange="this.form.submit()">
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-10 text-center text-slate-500">
                                        Заявок пока нет.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="pt-2">
                {{ $tickets->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
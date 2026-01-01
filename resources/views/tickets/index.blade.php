<x-app-layout>
    <div class="py-16">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Header --}}
            <div class="relative overflow-hidden bg-white shadow-lg border rounded-xl" style="border-color:#e2e2e2;">
                <div class="absolute top-0 left-0 w-full h-2" style="background: linear-gradient(90deg, #67E1D2 0%, #285EC5 100%);"></div>

                <div class="p-4 sm:p-4 flex flex-col sm:flex-row sm:items-right sm:justify-between gap-4">
                    <div>
                        <h1 class="text-l sm:text-3xl font-bold text-slate-900">Мои заявки</h1>
                        <p class="mt-1 text-slate-600">Список ваших обращений в Service Desk</p>
                    </div>

                    <a href="{{ route('tickets.create') }}"
                       class="inline-flex items-center justify-center px-5 py-3 text-white font-medium shadow-sm hover:opacity-95 transition"
                       style="background: linear-gradient(90.82deg, #2A9EB1 0%, #283A89 100%);">
                        + Создать заявку
                    </a>
                </div>
            </div>
            @php
            $currentStatus = request('status'); // null или 'in_progress' и т.д.
            
            $filters = [
            ['label' => 'Все', 'value' => null],
            ['label' => 'В обработке', 'value' => 'in_progress'],
            ['label' => 'Решено', 'value' => 'done'],
            ['label' => 'Отклонено', 'value' => 'rejected'],
            ];
            @endphp

            <div class="flex flex-wrap items-center gap-2">
                @foreach($filters as $f)
                @php
                $isActive = ($currentStatus === $f['value']) || ($currentStatus === null && $f['value'] === null);
                $url = $f['value']
                ? route('tickets.index', ['status' => $f['value']])
                : route('tickets.index');
                @endphp
                
                <a href="{{ $url }}"
                class="px-3 py-2 text-sm rounded-xl border transition {{ $isActive ? 'text-white border-transparent shadow-sm' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-50' }}"
                style="{{ $isActive ? 'background: linear-gradient(90.82deg, #2A9EB1 0%, #283A89 100%);' : '' }}">
                {{ $f['label'] }}
            </a>
                @endforeach
            </div>

            {{-- List --}}
            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
            <table class="min-w-full w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Заголовок</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Категория / Приоритет</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Дата</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Статус</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-200">
                @forelse($tickets as $t)
                    @php
                        $statusColors = [
                            'new' => 'bg-blue-100 text-blue-800',
                            'in_progress' => 'bg-orange-100 text-orange-800',
                            'done' => 'bg-green-100 text-green-800',
                            'rejected' => 'bg-red-100 text-red-800',
                        ];
                        $statusLabels = [
                            'new' => 'Новая',
                            'in_progress' => 'В обработке',
                            'done' => 'Решено',
                            'rejected' => 'Отклонено',
                        ];
                    @endphp

                    <tr id="ticket-{{ $t->id }}" class="hover:bg-slate-50 transition scroll-mt-24">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold" style="color:#345DAB;">
                            #{{ $t->id }}
                        </td>

                        <td class="px-6 py-4 text-sm text-slate-900">
                            <div class="font-medium">{{ $t->title }}</div>
                            @if(!empty($t->description))
                                <div class="text-xs text-slate-500 mt-1">
                                    {{ \Illuminate\Support\Str::limit($t->description, 70) }}
                                </div>
                            @endif
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                            <span class="font-medium">{{ $t->category }}</span>
                            <span class="text-slate-400">•</span>
                            <span>{{ $t->priority }}</span>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                            {{ $t->created_at->format('d.m.Y H:i') }}
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold
                                         {{ $statusColors[$t->status] ?? 'bg-slate-100 text-slate-700' }}">
                                {{ $statusLabels[$t->status] ?? $t->status }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-slate-500">
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

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (!location.hash) return;
            const el = document.querySelector(location.hash);
            if (!el) return;

            el.classList.add('ring-2', 'ring-cyan-300');
        });
    </script>
</x-app-layout>
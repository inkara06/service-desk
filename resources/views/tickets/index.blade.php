<x-app-layout>
    <div class="max-w-5xl mx-auto p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-semibold">Мои заявки</h1>
            <a href="{{ route('tickets.create') }}" class="px-4 py-2 rounded bg-black text-white">
                Создать заявку
            </a>
        </div>

        <div class="bg-white rounded shadow divide-y">
            @forelse($tickets as $t)
                <div class="p-4 flex items-center justify-between">
                    <div>
                        <div class="font-medium">{{ $t->title }}</div>
                        <div class="text-sm text-gray-500">
                            {{ $t->category }} • {{ $t->priority }} • {{ $t->created_at->format('d.m.Y H:i') }}
                        </div>
                    </div>
                    <span class="text-sm px-2 py-1 rounded bg-gray-100">{{ $t->status }}</span>
                </div>
            @empty
                <div class="p-4 text-gray-500">Заявок пока нет.</div>
            @endforelse
        </div>

        <div class="mt-4">{{ $tickets->links() }}</div>
    </div>
</x-app-layout>
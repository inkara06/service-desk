<x-app-layout>
    <div class="max-w-6xl mx-auto p-6">
        <h1 class="text-2xl font-semibold mb-6">Админка: все заявки</h1>

        <div class="bg-white rounded shadow overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left p-3">ID</th>
                        <th class="text-left p-3">Название</th>
                        <th class="text-left p-3">Автор</th>
                        <th class="text-left p-3">Категория</th>
                        <th class="text-left p-3">Приоритет</th>
                        <th class="text-left p-3">Статус</th>
                        <th class="text-left p-3">Исполнитель</th>
                        <th class="text-left p-3">Срок</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @foreach($tickets as $t)
                        <tr>
                            <td class="p-3">{{ $t->id }}</td>
                            <td class="p-3">{{ $t->title }}</td>
                            <td class="p-3">{{ $t->author?->email }}</td>
                            <td class="p-3">{{ $t->category }}</td>
                            <td class="p-3">{{ $t->priority }}</td>

                            {{-- Статус --}}
                            <td class="p-3">
                                <form method="POST" action="{{ route('admin.tickets.status', $t) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="assignee_id" value="{{ $t->assignee_id }}">
                                    <input type="hidden" name="due_date" value="{{ $t->due_date }}">
                                    <select name="status" class="border rounded px-2 py-1" onchange="this.form.submit()">
                                        @foreach(['new','in_progress','done','rejected'] as $s)
                                            <option value="{{ $s }}" @selected($t->status===$s)>{{ $s }}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>

                            {{-- Исполнитель --}}
                            <td class="p-3">
                                <form method="POST" action="{{ route('admin.tickets.status', $t) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="{{ $t->status }}">
                                    <input type="hidden" name="due_date" value="{{ $t->due_date }}">
                                    <select name="assignee_id" class="border rounded px-2 py-1" onchange="this.form.submit()">
                                        <option value="">—</option>
                                        @foreach($users as $u)
                                            <option value="{{ $u->id }}" @selected($t->assignee_id===$u->id)>{{ $u->name }}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>

                            {{-- Срок --}}
                            <td class="p-3">
                                <form method="POST" action="{{ route('admin.tickets.status', $t) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="{{ $t->status }}">
                                    <input type="hidden" name="assignee_id" value="{{ $t->assignee_id }}">
                                    <input type="date" name="due_date" value="{{ $t->due_date }}" class="border rounded px-2 py-1" onchange="this.form.submit()">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $tickets->links() }}</div>
    </div>
</x-app-layout>
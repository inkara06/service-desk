<x-app-layout>
    <div class="max-w-3xl mx-auto p-6">
        <h1 class="text-2xl font-semibold mb-6">Создать заявку</h1>

        <form method="POST" action="{{ route('tickets.store') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium mb-1">Название</label>
                <input name="title" value="{{ old('title') }}" class="w-full border rounded px-3 py-2" required>
                @error('title') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Категория</label>
                <input name="category" value="{{ old('category') }}" class="w-full border rounded px-3 py-2" required>
                @error('category') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Приоритет</label>
                <select name="priority" class="w-full border rounded px-3 py-2" required>
                    <option value="low">low</option>
                    <option value="medium" selected>medium</option>
                    <option value="high">high</option>
                </select>
                @error('priority') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Описание</label>
                <textarea name="description" class="w-full border rounded px-3 py-2" rows="5" required>{{ old('description') }}</textarea>
                @error('description') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Срок исполнения (необязательно)</label>
                <input type="date" name="due_date" value="{{ old('due_date') }}" class="w-full border rounded px-3 py-2">
                @error('due_date') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
            </div>

            <button class="px-4 py-2 rounded bg-black text-white">Создать</button>
        </form>
    </div>
</x-app-layout>
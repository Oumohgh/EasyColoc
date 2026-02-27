<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Categories - {{ $colocation->name }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if($membership->role === 'owner')
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-sm font-semibold text-gray-700 mb-2">Add Category</h3>
                    <form method="POST" action="{{ route('categories.store', $colocation) }}" class="flex gap-3">
                        @csrf
                        <input type="hidden" name="colocation_id" value="{{ $colocation->id }}">
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="Category name"
                               class="flex-1 rounded-md border-gray-300" required>
                        <button class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm font-semibold">
                            Add
                        </button>
                    </form>

                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-sm font-semibold text-gray-700 mb-3">Category List</h3>
                <ul class="space-y-2 text-sm">
                    @forelse($categories as $category)
                        <li class="border rounded-md px-3 py-2 text-gray-700">{{ $category->name }}</li>
                    @empty
                        <li class="text-gray-400">Pas encore de categories.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Expenses - {{ $colocation->name }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="GET" class="flex items-end gap-3 mb-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Month</label>
                        <input type="month" name="month" value="{{ $month }}"
                               class="mt-1 rounded-md border-gray-300">
                    </div>
                    <button class="px-3 py-2 bg-gray-800 text-white text-sm rounded-md">Filter</button>
                    <a href="{{ route('colocations.expenses', $colocation) }}"
                       class="px-3 py-2 text-sm text-gray-600">Reset</a>
                </form>

                <h3 class="text-sm font-semibold text-gray-700 mb-2">Add Expense</h3>
                <form method="POST" action="{{ route('expenses.store', $colocation) }}" class="grid grid-cols-1 md:grid-cols-6 gap-3">
                    @csrf
                    <input type="hidden" name="colocation_id" value="{{ $colocation->id }}">

                    <div class="md:col-span-2">
                        <input type="text" name="title" placeholder="Title" value="{{ old('title') }}"
                               class="w-full rounded-md border-gray-300" required>
                        @error('title')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <input type="number" step="0.01" name="amount" placeholder="Amount" value="{{ old('amount') }}"
                               class="w-full rounded-md border-gray-300" required>
                        @error('amount')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <input type="date" name="date" value="{{ old('date', now()->toDateString()) }}"
                               class="w-full rounded-md border-gray-300" required>
                        @error('date')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <select name="category_id" class="w-full rounded-md border-gray-300">
                            <option value="">Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <select name="user_id" class="w-full rounded-md border-gray-300" required>
                            <option value="">Payer</option>
                            @foreach($members as $member)
                                <option value="{{ $member->id }}" @selected(old('user_id') == $member->id)>
                                    {{ $member->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="md:col-span-6">
                        <button class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-md">
                            Add
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 border-b">
                            <tr>
                                <th class="text-left px-4 py-2 text-xs font-semibold text-gray-500 uppercase">Title</th>
                                <th class="text-left px-4 py-2 text-xs font-semibold text-gray-500 uppercase">Amount</th>
                                <th class="text-left px-4 py-2 text-xs font-semibold text-gray-500 uppercase">Date</th>
                                <th class="text-left px-4 py-2 text-xs font-semibold text-gray-500 uppercase">Payer</th>
                                <th class="text-left px-4 py-2 text-xs font-semibold text-gray-500 uppercase">Category</th>
                                <th class="text-left px-4 py-2 text-xs font-semibold text-gray-500 uppercase">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @forelse($expenses as $expense)
                                <tr>
                                    <td class="px-4 py-3 font-semibold text-gray-800">{{ $expense->title }}</td>
                                    <td class="px-4 py-3 text-gray-500">{{ number_format($expense->amount, 2) }}</td>
                                    <td class="px-4 py-3 text-gray-500">{{ $expense->date }}</td>
                                    <td class="px-4 py-3 text-gray-500">{{ $expense->payer->name ?? '-' }}</td>
                                    <td class="px-4 py-3 text-gray-500">{{ $expense->category->name ?? '-' }}</td>
                                    <td class="px-4 py-3">
                                        @if($expense->user_id === auth()->id())
                                            <form method="POST" action="{{ route('expenses.destroy', $expense) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button class="text-xs text-red-600 font-semibold"
                                                        onclick="return confirm('Delete this expense?')">
                                                    Delete
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-xs text-gray-300">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-6 text-center text-gray-400">No expenses found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

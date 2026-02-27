<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Colocations
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-4">
                <p class="text-sm text-gray-500">Your colocations and memberships.</p>
                <a href="{{ route('colocations.create') }}"
                   class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm font-semibold">
                    Create Colocation
                </a>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50 border-b">
                                <tr>
                                    <th class="text-left px-4 py-2 text-xs font-semibold text-gray-500 uppercase">Name</th>
                                    <th class="text-left px-4 py-2 text-xs font-semibold text-gray-500 uppercase">Role</th>
                                    <th class="text-left px-4 py-2 text-xs font-semibold text-gray-500 uppercase">Status</th>
                                    <th class="text-left px-4 py-2 text-xs font-semibold text-gray-500 uppercase">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @forelse($colocations as $colocation)
                                    <tr>
                                        <td class="px-4 py-3 font-semibold text-gray-800">{{ $colocation->name }}</td>
                                        <td class="px-4 py-3 text-gray-500">{{ $colocation->pivot->role }}</td>
                                        <td class="px-4 py-3">
                                            <span class="px-2 py-0.5 rounded-full text-xs
                                                {{ $colocation->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                                {{ $colocation->status }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <a href="{{ route('colocations.show', $colocation) }}"
                                               class="text-indigo-600 text-xs font-semibold">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-6 text-center text-gray-400">No colocations yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

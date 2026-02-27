<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $colocation->name }}
            </h2>
            @if($membership->role === 'owner')
                <form method="POST" action="{{ route('colocations.destroy', $colocation) }}">
                    @csrf
                    @method('DELETE')
                    <button class="text-sm text-red-600 font-semibold"
                            onclick="return confirm('Cancel this colocation?')">
                        Cancel Colocation
                    </button>
                </form>
            @endif
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <p class="text-gray-600">{{ $colocation->description ?? 'No description.' }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <a href="{{ route('colocations.members', $colocation) }}" class="bg-white p-5 shadow-sm rounded-lg">
                    <p class="text-sm text-gray-500">Members</p>
                    <p class="text-lg font-semibold">{{ $members->count() }}</p>
                </a>
                <a href="{{ route('colocations.expenses', $colocation) }}" class="bg-white p-5 shadow-sm rounded-lg">
                    <p class="text-sm text-gray-500">Expenses</p>
                    <p class="text-lg font-semibold">{{ $expenses->count() }}</p>
                </a>
                <a href="{{ route('colocations.balances', $colocation) }}" class="bg-white p-5 shadow-sm rounded-lg">
                    <p class="text-sm text-gray-500">Balances</p>
                    <p class="text-lg font-semibold">View</p>
                </a>
                <a href="{{ route('colocations.categories', $colocation) }}" class="bg-white p-5 shadow-sm rounded-lg">
                    <p class="text-sm text-gray-500">Categories</p>
                    <p class="text-lg font-semibold">Manage</p>
                </a>
                <a href="{{ route('colocations.invitations', $colocation) }}" class="bg-white p-5 shadow-sm rounded-lg">
                    <p class="text-sm text-gray-500">Invitations</p>
                    <p class="text-lg font-semibold">View</p>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>

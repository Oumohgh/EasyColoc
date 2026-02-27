<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Members - {{ $colocation->name }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 border-b">
                            <tr>
                                <th class="text-left px-4 py-2 text-xs font-semibold text-gray-500 uppercase">Name</th>
                                <th class="text-left px-4 py-2 text-xs font-semibold text-gray-500 uppercase">Role</th>
                                <th class="text-left px-4 py-2 text-xs font-semibold text-gray-500 uppercase">Joined</th>
                                <th class="text-left px-4 py-2 text-xs font-semibold text-gray-500 uppercase">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @foreach($members as $member)
                                <tr>
                                    <td class="px-4 py-3 font-semibold text-gray-800">{{ $member->name }}</td>
                                    <td class="px-4 py-3 text-gray-500">{{ $member->pivot->role }}</td>
                                    <td class="px-4 py-3 text-gray-500">
                                        {{ $member->pivot->joined_at ? \Illuminate\Support\Carbon::parse($member->pivot->joined_at)->format('Y-m-d') : '-' }}
                                    </td>
                                    <td class="px-4 py-3">
                                        @if($membership->role === 'owner' && $member->pivot->role !== 'owner')
                                            <form method="POST" action="{{ route('memberships.destroy', $member->pivot->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button class="text-xs text-red-600 font-semibold"
                                                        onclick="return confirm('Remove this member?')">
                                                    Remove
                                                </button>
                                            </form>
                                        @elseif($member->id === auth()->id() && $membership->role !== 'owner')
                                            <form method="POST" action="{{ route('colocations.leave', $colocation) }}">
                                                @csrf
                                                <button class="text-xs text-gray-600 font-semibold"
                                                        onclick="return confirm('Leave this colocation?')">
                                                    Leave
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-xs text-gray-300">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

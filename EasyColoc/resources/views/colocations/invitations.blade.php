<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Invitations - {{ $colocation->name }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if($membership->role === 'owner')
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-sm font-semibold text-gray-700 mb-2">Invite a member</h3>
                    <form method="POST" action="{{ route('invitations.store', $colocation) }}" class="flex gap-3">
                        @csrf
                        <input type="hidden" name="colocation_id" value="{{ $colocation->id }}">
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Email"
                               class="flex-1 rounded-md border-gray-300" required>
                        <button class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm font-semibold">
                            Send
                        </button>
                    </form>
                    @error('email')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-sm font-semibold text-gray-700 mb-3">Colocation Invitations</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 border-b">
                            <tr>
                                <th class="text-left px-4 py-2 text-xs font-semibold text-gray-500 uppercase">Email</th>
                                <th class="text-left px-4 py-2 text-xs font-semibold text-gray-500 uppercase">Status</th>
                                <th class="text-left px-4 py-2 text-xs font-semibold text-gray-500 uppercase">Created</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @forelse($invitations as $invitation)
                                <tr>
                                    <td class="px-4 py-3 text-gray-700">{{ $invitation->email }}</td>
                                    <td class="px-4 py-3 text-gray-500">{{ $invitation->status }}</td>
                                    <td class="px-4 py-3 text-gray-500">{{ $invitation->created_at->format('Y-m-d') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-4 py-6 text-center text-gray-400">No invitations yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <p class="mt-2 text-xs text-gray-400">Invitations expire after 7 days.</p>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-sm font-semibold text-gray-700 mb-3">My Pending Invitations</h3>
                @if($myInvitations->count())
                    <div class="space-y-3">
                        @foreach($myInvitations as $invite)
                            <div class="flex items-center justify-between border rounded-md px-4 py-3">
                                <div>
                                    <p class="text-sm font-semibold text-gray-800">{{ $invite->colocation->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $invite->email }}</p>
                                </div>
                                <div class="flex gap-2">
                                    <form method="POST" action="{{ route('invitations.accept', $invite->token) }}">
                                        @csrf
                                        <button class="px-3 py-1.5 bg-green-600 text-white text-xs rounded-md">Accept</button>
                                    </form>
                                    <form method="POST" action="{{ route('invitations.refuse', $invite->token) }}">
                                        @csrf
                                        <button class="px-3 py-1.5 bg-gray-200 text-gray-700 text-xs rounded-md">Refuse</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-500">You have no pending invitations.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

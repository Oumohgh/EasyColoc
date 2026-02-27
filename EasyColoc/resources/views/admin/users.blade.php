<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Users
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50 border-b">
                                <tr>
                                    <th class="text-left px-4 py-2 text-xs font-semibold text-gray-500 uppercase">Name</th>
                                    <th class="text-left px-4 py-2 text-xs font-semibold text-gray-500 uppercase">Email</th>
                                    <th class="text-left px-4 py-2 text-xs font-semibold text-gray-500 uppercase">Role</th>
                                    <th class="text-left px-4 py-2 text-xs font-semibold text-gray-500 uppercase">Status</th>
                                    <th class="text-left px-4 py-2 text-xs font-semibold text-gray-500 uppercase">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @forelse($users as $user)
                                    <tr>
                                        <td class="px-4 py-3 font-semibold text-gray-800">{{ $user->name }}</td>
                                        <td class="px-4 py-3 text-gray-500">{{ $user->email }}</td>
                                        <td class="px-4 py-3 text-gray-500">
                                            {{ $user->is_admin ? 'Admin' : 'User' }}
                                        </td>
                                        <td class="px-4 py-3">
                                            @if($user->is_banned)
                                                <span class="px-2 py-0.5 rounded-full text-xs bg-red-100 text-red-600">Banned</span>
                                            @else
                                                <span class="px-2 py-0.5 rounded-full text-xs bg-green-100 text-green-700">Active</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">
                                            @if($user->is_banned)
                                                <form method="POST" action="{{ route('admin.users.unban', $user) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button class="text-green-600 text-xs font-semibold">Unban</button>
                                                </form>
                                            @elseif(!$user->is_admin)
                                                <form method="POST" action="{{ route('admin.users.ban', $user) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button class="text-red-600 text-xs font-semibold">Ban</button>
                                                </form>
                                            @else
                                                <span class="text-gray-300 text-xs">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-6 text-center text-gray-400">No users found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

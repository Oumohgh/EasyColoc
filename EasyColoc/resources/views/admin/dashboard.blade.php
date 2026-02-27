<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admin Dashboard
        </h2>
    </x-slot>


        <div class="grid grid-cols-2 xl:grid-cols-4 gap-4 mb-7">


            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <div class="w-9 h-9 rounded-lg bg-blue-50 flex items-center justify-center mb-4">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>
                <div class="text-3xl font-extrabold text-gray-900">{{ $totalUsers }}</div>
                <div class="text-xs text-gray-500 mt-1">Total Users</div>
            </div>


            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <div class="w-9 h-9 rounded-lg bg-violet-50 flex items-center justify-center mb-4">
                    <svg class="w-5 h-5 text-violet-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                        <polyline points="9 22 9 12 15 12 15 22"/>
                    </svg>
                </div>
                <div class="text-3xl font-extrabold text-gray-900">{{ $activeColocations }}</div>
                <div class="text-xs text-gray-500 mt-1">Active Colocations</div>
            </div>


            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <div class="w-9 h-9 rounded-lg bg-amber-50 flex items-center justify-center mb-4">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/>
                        <line x1="1" y1="10" x2="23" y2="10"/>
                    </svg>
                </div>
                <div class="text-3xl font-extrabold text-gray-900">{{ $totalExpenses }}</div>
                <div class="text-xs text-gray-500 mt-1">Total Expenses</div>
            </div>


            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <div class="w-9 h-9 rounded-lg bg-red-50 flex items-center justify-center mb-4">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/>
                    </svg>
                </div>
                <div class="text-3xl font-extrabold text-gray-900">{{ $bannedUsers }}</div>
                <div class="text-xs text-gray-500 mt-1">Banned Users</div>
            </div>

        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-7">

            <div class="px-5 py-4 border-b border-gray-100">
                <h2 class="text-sm font-bold text-gray-800">Recent Users</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="text-left text-xs font-bold text-gray-400 uppercase tracking-wider px-5 py-3">Name</th>
                            <th class="text-left text-xs font-bold text-gray-400 uppercase tracking-wider px-5 py-3">Email</th>
                            <th class="text-left text-xs font-bold text-gray-400 uppercase tracking-wider px-5 py-3">Reputation</th>
                            <th class="text-left text-xs font-bold text-gray-400 uppercase tracking-wider px-5 py-3">Status</th>
                            <th class="text-left text-xs font-bold text-gray-400 uppercase tracking-wider px-5 py-3">Joined</th>
                            <th class="text-left text-xs font-bold text-gray-400 uppercase tracking-wider px-5 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">

                        @forelse($recentUsers as $user)
                        <tr class="hover:bg-gray-50 transition">


                            <td class="px-5 py-3.5 font-semibold text-gray-800">
                                {{ $user->name }}
                                @if($user->is_admin)
                                    <span class="ml-1 px-1.5 py-0.5 rounded text-[10px] font-bold bg-blue-100 text-blue-600">
                                        ADMIN
                                    </span>
                                @endif
                            </td>


                            <td class="px-5 py-3.5 text-gray-500">
                                {{ $user->email }}
                            </td>


                            <td class="px-5 py-3.5 font-semibold {{ $user->reputation >= 0 ? 'text-green-600' : 'text-red-500' }}">
                                {{ $user->reputation >= 0 ? '+' : '' }}{{ $user->reputation }}
                            </td>


                            <td class="px-5 py-3.5">
                                @if($user->is_banned)
                                    <span class="px-2 py-0.5 rounded-full text-[11px] font-semibold bg-red-100 text-red-600">
                                        Banned
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full text-[11px] font-semibold bg-green-100 text-green-700">
                                        Active
                                    </span>
                                @endif
                            </td>


                            <td class="px-5 py-3.5 text-gray-500">
                                {{ $user->created_at->format('M d, Y') }}
                            </td>


                            <td class="px-5 py-3.5">
                                @if($user->is_banned)
                                    <form method="POST"
                                          action="{{ route('admin.users.unban', $user) }}"
                                          class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="px-2.5 py-1 rounded-lg text-xs font-semibold
                                                   border border-green-200 text-green-600
                                                   hover:bg-green-50 transition">
                                            Unban
                                        </button>
                                    </form>
                                @elseif(!$user->is_admin)
                                    <button
                                        onclick="openBanModal('{{ $user->name }}', {{ $user->id }})"
                                        class="px-2.5 py-1 rounded-lg text-xs font-semibold
                                               border border-red-200 text-red-500
                                               hover:bg-red-50 transition">
                                        Ban
                                    </button>
                                @else
                                    <span class="text-gray-300 text-xs">—</span>
                                @endif
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-5 py-8 text-center text-gray-400 text-sm">
                                No users found.
                            </td>
                        </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>


        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">

            <div class="px-5 py-4 border-b border-gray-100">
                <h2 class="text-sm font-bold text-gray-800">Recent Colocations</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="text-left text-xs font-bold text-gray-400 uppercase tracking-wider px-5 py-3">Name</th>
                            <th class="text-left text-xs font-bold text-gray-400 uppercase tracking-wider px-5 py-3">Owner</th>
                            <th class="text-left text-xs font-bold text-gray-400 uppercase tracking-wider px-5 py-3">Members</th>
                            <th class="text-left text-xs font-bold text-gray-400 uppercase tracking-wider px-5 py-3">Expenses Total</th>
                            <th class="text-left text-xs font-bold text-gray-400 uppercase tracking-wider px-5 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">

                        @forelse($recentColocations as $colocation)
                        <tr class="hover:bg-gray-50 transition">


                            <td class="px-5 py-3.5 font-semibold text-gray-800">
                                {{ $colocation->name }}
                            </td>


                            <td class="px-5 py-3.5 text-gray-600">
                                {{ optional($colocation->getOwner())->name ?? '—' }}
                            </td>


                            <td class="px-5 py-3.5 text-gray-600">
                                {{ $colocation->activeMembers()->count() }}
                            </td>


                            <td class="px-5 py-3.5 font-semibold text-gray-800">
                                {{ number_format($colocation->expenses()->sum('amount'), 2) }} MAD
                            </td>


                            <td class="px-5 py-3.5">
                                @if($colocation->status === 'active')
                                    <span class="px-2 py-0.5 rounded-full text-[11px] font-semibold bg-green-100 text-green-700">
                                        Active
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full text-[11px] font-semibold bg-gray-100 text-gray-500">
                                        Cancelled
                                    </span>
                                @endif
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-5 py-8 text-center text-gray-400 text-sm">
                                Aucune colocations trouve
                            </td>
                        </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>

    </div>


    <div id="ban-modal"
         class="fixed inset-0 z-50 hidden items-center justify-center bg-black/45 backdrop-blur-sm">

        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm mx-4 p-7">

            <div class="flex items-center justify-center w-12 h-12 rounded-full bg-red-100 mx-auto mb-4">
                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/>
                </svg>
            </div>

            <h3 class="text-base font-extrabold text-gray-900 text-center mb-1">Ban User</h3>
            <p class="text-sm text-gray-500 text-center mb-6">
                Es-tu sur de vouloir bannir

            </p>

            <form id="ban-form" method="POST" action="">
                @csrf
                @method('PATCH')
                <div class="flex gap-3">
                    <button type="button" onclick="closeBanModal()"
                        class="flex-1 py-2 border border-gray-200 rounded-xl text-sm
                               font-semibold text-gray-600 hover:bg-gray-50 transition">
                        Cancel
                    </button>
                    <button type="submit"
                        class="flex-1 py-2 bg-red-500 hover:bg-red-600 text-white
                               rounded-xl text-sm font-bold transition">
                        Oui,Banner
                    </button>
                </div>
            </form>

        </div>
    </div>


    <script>
        function openBanModal(name, userId) {
            document.getElementById('ban-user-name').textContent = name;
            document.getElementById('ban-form').action = '{{ url("admin/users") }}/' + userId + '/ban';
            const modal = document.getElementById('ban-modal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeBanModal() {
            const modal = document.getElementById('ban-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        document.getElementById('ban-modal').addEventListener('click', function(e) {
            if (e.target === this) closeBanModal();
        });
    </script>

</x-app-layout>

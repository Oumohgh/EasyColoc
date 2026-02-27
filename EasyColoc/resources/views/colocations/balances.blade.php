<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Balances - {{ $colocation->name }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-sm font-semibold text-gray-700 mb-3">Member Balances</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 border-b">
                            <tr>
                                <th class="text-left px-4 py-2 text-xs font-semibold text-gray-500 uppercase">Member</th>
                                <th class="text-left px-4 py-2 text-xs font-semibold text-gray-500 uppercase">Total Paid</th>
                                <th class="text-left px-4 py-2 text-xs font-semibold text-gray-500 uppercase">Share</th>
                                <th class="text-left px-4 py-2 text-xs font-semibold text-gray-500 uppercase">Balance</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @foreach($balances as $item)
                                <tr>
                                    <td class="px-4 py-3 font-semibold text-gray-800">{{ $item['member']->name }}</td>
                                    <td class="px-4 py-3 text-gray-500">{{ number_format($item['paid'], 2) }}</td>
                                    <td class="px-4 py-3 text-gray-500">{{ number_format($item['share'], 2) }}</td>
                                    <td class="px-4 py-3 font-semibold {{ $item['balance'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                        {{ number_format($item['balance'], 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-sm font-semibold text-gray-700 mb-3">Who Owes Who</h3>
                @if(count($settlements))
                    <ul class="space-y-2 text-sm">
                        @foreach($settlements as $settlement)
                            <li class="text-gray-700">
                                <span class="font-semibold">{{ $settlement['from']->name }}</span>
                                owes
                                <span class="font-semibold">{{ $settlement['to']->name }}</span>
                                <span class="font-semibold">{{ number_format($settlement['amount'], 2) }}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-sm text-gray-500">No settlements needed.</p>
                @endif
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-sm font-semibold text-gray-700 mb-3">My Unpaid Shares</h3>
                @if($myUnpaidShares->count())
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50 border-b">
                                <tr>
                                    <th class="text-left px-4 py-2 text-xs font-semibold text-gray-500 uppercase">Expense</th>
                                    <th class="text-left px-4 py-2 text-xs font-semibold text-gray-500 uppercase">Amount</th>
                                    <th class="text-left px-4 py-2 text-xs font-semibold text-gray-500 uppercase">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @foreach($myUnpaidShares as $share)
                                    <tr>
                                        <td class="px-4 py-3 text-gray-700">{{ $share->expense->title }}</td>
                                        <td class="px-4 py-3 text-gray-500">{{ number_format($share->amount_owned, 2) }}</td>
                                        <td class="px-4 py-3">
                                            <form method="POST" action="{{ route('payments.store', $share) }}">
                                                @csrf
                                                <button class="text-xs text-indigo-600 font-semibold">
                                                    marquer comme paye
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-sm text-gray-500">Vous n avez pas d impayes.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

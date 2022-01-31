<div>
    <div class="grid grid-cols-3 gap-8">
        <div>
            <label for="search" class="block text-sm font-medium text-gray-700">Quick search</label>
            <x-jet-input id="search" class="block mt-1 w-full" type="text" wire:model="search"/>
        </div>

        <div class="col-span-2">
            <label for="search" class="block text-sm font-medium text-gray-700">Filter by popular tokens</label>
            <div class="mt-1 space-x-1">
                @foreach($popular_tokens as $token)
                    <input id="token_{{ $token->id }}"  wire:model="token_ids" value="{{ $token->id }}" type="checkbox" class="hidden focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                    <label for="token_{{ $token->id }}" class="inline-flex cursor-pointer items-center px-3 py-1 rounded text-sm font-bold text-blue-800 {{ in_array($token->id, $token_ids) ? 'bg-blue-300' : 'bg-blue-100'  }}">
                        {{ $token->name }}
                    </label>
                @endforeach
            </div>
        </div>
    </div>
    <div class="mt-6 flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Token Pair
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                APY
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Farm
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Edit</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($token_combinations as $token_combination)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $token_combination->from_token->name }}-{{ $token_combination->to_token->name }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $token_combination->apy }}%
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ $token_combination->farm->url }}" target="_blank" class="text-indigo-600 hover:text-indigo-900">
                                    {{ $token_combination->farm->name }}
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="#" class="text-indigo-600 hover:text-indigo-900">View</a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {!! $token_combinations->links() !!}
                </div>
            </div>
        </div>
    </div>
</div>

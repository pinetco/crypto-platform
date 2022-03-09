<div>
    <div class="grid grid-cols-3 gap-8">
        <div>
            <label for="search" class="block text-sm font-medium text-gray-700">@lang('Quick search')</label>
            <x-jet-input id="search" class="block mt-1 w-full" type="text" wire:model="search"/>
        </div>

        <div>
            <label for="token_type" class="block text-sm font-medium text-gray-700">@lang('Token Type')</label>
            <select id="token_type" wire:model="token_type" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                <option value="">@lang('Any')</option>
                @foreach(\App\Models\TokenType::get() as $tokenType)
                    <option value="{{ $tokenType->identifier }}">{{ $tokenType->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="pair_type" class="block text-sm font-medium text-gray-700">@lang('Pair Type')</label>
            <select id="pair_type" wire:model="pair_type" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                <option value="">@lang('Any')</option>
                @foreach(\App\Models\PairType::get() as $pairType)
                    <option value="{{ $pairType->identifier }}">{{ $pairType->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="protocol_id" class="block text-sm font-medium text-gray-700">@lang('Protocol')</label>
            <select id="protocol_id" wire:model="protocol_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                <option value="">@lang('Any')</option>
                @foreach(\App\Models\Protocol::get() as $protocol)
                    <option value="{{ $protocol->id }}">{{ $protocol->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-span-2">
            <label for="search" class="block text-sm font-medium text-gray-700">@lang('Filter by popular tokens')</label>
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
                                @lang('Protocol')
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                @lang('Pair Type')
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                @lang('Pair')
                            </th>
                            <th wire:click="sortBy('apy')" scope="col" class="px-6 py-3 cursor-pointer text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                @lang('APR/APY') <x-icons.sort/>
                            </th>
                            <th wire:click="sortBy('tvl')" scope="col" class="px-6 py-3 cursor-pointer text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                @lang('TVL') <x-icons.sort/>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                @lang('How to invest')
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                @lang('Token performance')
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">@lang('Action')</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($token_combinations as $token_combination)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ $token_combination->protocol->url }}" target="_blank" class="text-indigo-600 hover:text-indigo-900 flex items-center">
                                    @if($token_combination->protocol->icon_path)
                                        <img class="mr-2" src="{{ asset($token_combination->protocol->icon_path) }}" alt="{{ $token_combination->protocol->name }}">
                                    @endif
                                    {{ $token_combination->protocol->name }}
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $token_combination->pair_type->name }}
                            </td>
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
                                {{ $token_combination->tvl < 100 ? $token_combination->tvl : number_format($token_combination->tvl) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">

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

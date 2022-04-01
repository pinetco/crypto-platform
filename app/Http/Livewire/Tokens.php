<?php

namespace App\Http\Livewire;

use App\Models\PairType;
use App\Models\TokenCombination;
use App\Models\TokenType;
use Livewire\Component;
use Livewire\WithPagination;

class Tokens extends Component
{
    use WithPagination, WithSorting;

    public $search;
    public $token_type_id;
    public $pair_type_id;
    public $protocol_id;

    public $token_ids = [];

    public $popular_tokens = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'token_type_id' => ['except' => ''],
        'pair_type_id' => ['except' => ''],
        'protocol_id' => ['except' => ''],
        'token_ids' => ['except' => []],
    ];

    public function mount()
    {
        $this->popular_tokens = \App\Models\Token::popular()->get();
    }

    public function render()
    {
        return view('livewire.tokens', [
            'token_combinations' => $this->getTokenCombinations(),
        ]);
    }

    public function updated()
    {
        $this->resetPage();
    }

    protected function getTokenCombinations()
    {
        return TokenCombination::with('protocol:id,name,icon_path,url', 'pair_type:id,name', 'from_token:id,name,logo_url', 'to_token:id,name,logo_url')
            ->when($this->search, function ($q) {
                $q->search($this->search);
            })
            ->when($this->token_type_id, function ($q) {
                $q->whereHasTokens('token_type_id', $this->token_type_id);
            })
            ->when($this->pair_type_id, function ($q) {
                $q->where('pair_type_id', $this->pair_type_id);
            })
            ->when($this->protocol_id, function ($q) {
                $q->where('protocol_id', $this->protocol_id);
            })
            ->when($this->token_ids, function ($q) {
                $q->where(function ($q) {
                    $q->whereIn('from_token_id', $this->token_ids)
                        ->orWhereIn('to_token_id', $this->token_ids);
                });
            })
            ->when($this->sort_by, function ($q) {
                $q->orderBy($this->sort_by, $this->sort_direction);
            }, function ($q) {
                $q->orderByDesc('apy');
            })
            ->paginate();
    }
}

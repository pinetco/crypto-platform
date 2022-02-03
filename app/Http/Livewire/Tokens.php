<?php

namespace App\Http\Livewire;

use App\Models\TokenCombination;
use Livewire\Component;
use Livewire\WithPagination;

class Tokens extends Component
{
    use WithPagination, WithSorting;

    public $search;

    public $token_ids = [];

    public $popular_tokens = [];

    protected $queryString = [
        'search' => ['except' => ''],
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

    public function updatingSearch()
    {
        $this->resetPage();
    }

    protected function getTokenCombinations()
    {
        return TokenCombination::with('farm:id,name,url', 'from_token:id,name', 'to_token:id,name')
            ->when($this->search, function ($q) {
                $q->where(function ($q) {
                    $q->whereHas('from_token', function ($q) {
                        $q->where('name', 'like', "%{$this->search}%");
                    })->orWhereHas('to_token', function ($q) {
                        $q->where('name', 'like', "%{$this->search}%");
                    });
                });
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

<?php

namespace App\Http\Livewire;

use App\Models\TokenCombination;
use Livewire\Component;
use Livewire\WithPagination;

class Tokens extends Component
{
    use WithPagination;

    public $search;

    protected $queryString = [
        'search' => ['except' => '']
    ];

    public function render()
    {
        return view('livewire.tokens', [
            'token_combinations' => $this->getTokenCombinations()
        ]);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    protected function getTokenCombinations()
    {
        return TokenCombination::orderByDesc('apy')
            ->with('from_token:id,name', 'to_token:id,name')
            ->when($this->search, function ($q) {
                $q->whereHas('from_token', function($q) {
                    $q->where('name', 'like', "%{$this->search}%");
                })->orWhereHas('to_token', function($q) {
                    $q->where('name', 'like', "%{$this->search}%");
                });
            })
            ->paginate();
    }
}

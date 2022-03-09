<?php

namespace Tests\Unit;

use App\Jobs\Importers\Orca;
use App\Jobs\Importers\Raydium;
use App\Jobs\Importers\SolanaLido;
use App\Jobs\Importers\TulipGarden;
use Tests\TestCase;
use App\Models\Token;
use App\Models\TokenCombination;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TokenImportTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_imports_tokens_and_combinations_from_raydium()
    {
        Raydium::dispatch();

        $this->assertTrue(Token::count() > 0);
        $this->assertTrue(TokenCombination::count() > 0);
    }

    /** @test */
    public function it_imports_tokens_and_combinations_from_solfarm()
    {
        TulipGarden::dispatch();

        $this->assertTrue(Token::count() > 0);
        $this->assertTrue(TokenCombination::count() > 0);
    }

    /** @test */
    public function it_imports_tokens_and_combinations_from_orca()
    {
        Orca::dispatch();

        $this->assertTrue(Token::count() > 0);
        $this->assertTrue(TokenCombination::count() > 0);
    }

    /** @test */
    public function it_imports_tokens_and_combinations_from_solana_lido()
    {
        SolanaLido::dispatch();

        $this->assertTrue(Token::count() > 0);
        $this->assertTrue(TokenCombination::count() > 0);
    }
}

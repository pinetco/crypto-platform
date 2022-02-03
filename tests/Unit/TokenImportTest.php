<?php

namespace Tests\Unit;

use App\Importers\OrcaImporter;
use App\Importers\SolanaLidoImporter;
use Tests\TestCase;
use App\Models\Token;
use App\Models\TokenCombination;
use App\Importers\RaydiumImporter;
use App\Importers\SolfarmImporter;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TokenImportTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_imports_tokens_and_combinations_from_raydium()
    {
        RaydiumImporter::make()->handle();

        $this->assertTrue(Token::count() > 0);
        $this->assertTrue(TokenCombination::count() > 0);
    }

    /** @test */
    public function it_imports_tokens_and_combinations_from_solfarm()
    {
        SolfarmImporter::make()->handle();

        $this->assertTrue(Token::count() > 0);
        $this->assertTrue(TokenCombination::count() > 0);
    }

    /** @test */
    public function it_imports_tokens_and_combinations_from_orca()
    {
        OrcaImporter::make()->handle();

        $this->assertTrue(Token::count() > 0);
        $this->assertTrue(TokenCombination::count() > 0);
    }

    /** @test */
    public function it_imports_tokens_and_combinations_from_solana_lido()
    {
        SolanaLidoImporter::make()->handle();

        $this->assertTrue(Token::count() > 0);
        $this->assertTrue(TokenCombination::count() > 0);
    }
}

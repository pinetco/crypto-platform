<?php

namespace App\Jobs\Importers;

use App\Models\Protocol;
use Illuminate\Support\Collection;

abstract class Importer
{
    /** @var Protocol */
    protected $protocol;

    public abstract function getProtocol(): Protocol;

    public abstract function getData(): Collection;

    public abstract function import($record);

    public function handle()
    {
        $this->protocol = $this->getProtocol();

        foreach ($this->getData() as $record) {
            $this->import($record);
        }
    }
}

<?php

namespace Jakmall\Recruitment\Calculator\Commands;

use Illuminate\Console\Command;

class ClearHistoryCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'history:clear';

    /**
     * @var string
     */
    protected $description = "Clear saved history";
    protected $urlFile = "src/history.txt";


    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): void
    {
        file_put_contents($this->urlFile, "");
        $this->info('History cleared!');
    }

}

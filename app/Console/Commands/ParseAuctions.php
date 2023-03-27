<?php

namespace App\Console\Commands;

use App\Actions\ParseAuctionsAction;
use Illuminate\Console\Command;

class ParseAuctions extends Command
{
    /**
     * @var string
     */
    protected $signature = 'app:parse-auctions {--page=1}';

    /**
     * @var string
     */
    protected $description = 'This command is parsing auctions from default service';

    /**
     * @param ParseAuctionsAction $action
     * @return void
     */
    public function handle(ParseAuctionsAction $action): void
    {
        $this->info('Parsing...');

        $page = (int)$this->option('page');
        $action->execute($page);

        $this->info('Successfully parsed auctions');
    }
}

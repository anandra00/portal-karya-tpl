<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Core\Models\Visitor;

class LogVisitorJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected array $visitorData;

    /**
     * Create a new job instance.
     */
    public function __construct(array $visitorData)
    {
        $this->visitorData = $visitorData;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Visitor::create($this->visitorData);
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Sale;

class UpdateSalesDiscount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sales:update-discount';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update sales discount totals from sale items';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Updating sales discount totals...');
        
        $sales = Sale::with('saleItems')->get();
        $updated = 0;
        
        foreach ($sales as $sale) {
            // Calculate total discount from sale items
            $totalDiscount = $sale->saleItems->sum('discount_amount');
            
            // Update sale discount
            $sale->update(['discount' => $totalDiscount]);
            
            if ($totalDiscount > 0) {
                $updated++;
                $this->line("Sale #{$sale->invoice_number}: Discount updated to {$totalDiscount}");
            }
        }
        
        $this->info("Successfully updated {$updated} sales with discount data.");
        $this->info("Total sales processed: {$sales->count()}");
        
        return 0;
    }
}

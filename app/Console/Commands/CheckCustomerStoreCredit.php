<?php

namespace App\Console\Commands;

use App\Models\StoreCreditHistory;
use App\Models\User;
use Illuminate\Console\Command;

class CheckCustomerStoreCredit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-customer-store-credit {user?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check that customers store credit matches their history';

    private int $discrepanciesCount = 0;

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $user = $this->argument('user');

        if (!$user) {
            $this->confirm('Are you sure you want to check all users? This may take some time.');
        }

        if ($user) {
            $user = User::find($user);
            $this->processUser($user);
        } else {
            $users = User::all();
            foreach ($users as $user) {
                $this->processUser($user);
            }

            $this->info("{$users->count()} users checked, found $this->discrepanciesCount discrepancies");
        }
    }

    private function processUser(User $user): void
    {
        $storeCreditHistory = $user->store_credit_history;
        $expectedStoreCredit = $storeCreditHistory->reduce(
            fn (float $carry, StoreCreditHistory $item) => $carry + $item->credit, 0
        );

        if (round($expectedStoreCredit, 2) !== round($user->store_credit, 2)) {
            $this->warn("User #$user->id has €$user->store_credit of credit, but their history expects €$expectedStoreCredit");
            $this->discrepanciesCount++;
        }
    }
}

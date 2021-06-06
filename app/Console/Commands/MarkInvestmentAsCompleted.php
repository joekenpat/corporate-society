<?php

namespace App\Console\Commands;

use App\Models\Investment;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class MarkInvestmentAsCompleted extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'investment:markCompleted';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'find investment with matured date and mark as completed and award earnings to user';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Execute the console command.
   *
   * @return int
   */
  public function handle()
  {
    $counter = 1;
    Log::info('Mark investment as completed job Started');
    $investments = Investment::with(['user:id,available_balance,investment_balance'])->where('ends_at', '<=', now())->whereCompletedAt(null)->get();
    foreach ($investments as $investment) {
      Log::info(sprintf('Processing Data: %s ', $counter));
      $investmentUser = $investment->user;
      Log::info(sprintf('User: %s init Available balance: $%s', $investmentUser->id, number_format($investmentUser->available_balance, 2)));
      Log::info(sprintf('User: %s init Investment balance: $%s', $investmentUser->id, number_format($investmentUser->investment_balance, 2)));
      $investmentUser->available_balance = $investment->user->available_balance + ($investment->amount + $investment->roi);
      $investmentUser->investment_balance = $investment->user->investment_balance - $investment->amount;
      $investmentUser->update();
      Log::info(sprintf('Added $%s to User: %s', number_format($investment->amount + $investment->earning, 2), $investment->user->id));
      $investmentUser->refresh();
      Log::info(sprintf('User: %s Final Available balance: $%s', $investmentUser->id, number_format($investmentUser->available_balance, 2)));
      Log::info(sprintf('User: %s Final Investment balance: $%s', $investmentUser->id, number_format($investmentUser->investment_balance, 2)));
      $investment->completed_at = now();
      $investment->update();
      Log::info(sprintf('Marked Investment: %s as Completed', $investment->id));
      $counter++;
    }
    Log::info('Mark investment as completed job Ended');
    $counter = null;
    return 0;
  }
}

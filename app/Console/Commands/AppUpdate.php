<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Candidate;
use Illuminate\Support\Facades\Redis;
use PHP\Math\BigInteger\BigInteger;
use Minter\MinterAPI;

class AppUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update {--delay= : Number of seconds to delay command}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return mixed
     */
    public function handle()
    {
        //return false;

        ini_set('precision', 45);

        sleep(intval($this->option('delay')));

        $api = new MinterAPI('127.0.0.1:8841');

        $syncStatus = Redis::get('app:sync');

        if ($syncStatus !== 'in_progress') {
            Redis::set('app:sync', 'in_progress');

            for ($i = 0; $i < 10000; $i++) {
                // Get node status
                $status = $api->getStatus()->result;

                $nodeLatestBlock = $status->latest_block_height;
                $appLatestBlock = (Redis::get('app:lastBlockChecked') !== null) ? (int) Redis::get('app:lastBlockChecked') : 0;

                if ($appLatestBlock !== $nodeLatestBlock) {

                    if ($appLatestBlock == $nodeLatestBlock) {
                        Redis::set('app:sync', 'done');
                        break;
                    }

                    $block = $api->getBlock($appLatestBlock + 1)->result;
                    $transactions = $block->transactions;

                    if (count($transactions) > 0) {
                        foreach ($transactions as $transaction) {
                            // Looking for new candidates
                            if ($transaction->type === 6) {
                                $declareTime = date_parse($block->time);
                                $declareUnixTime = strtotime($declareTime['month'] . '/' . $declareTime['day'] . '/' . $declareTime['year'] . ' ' . $declareTime['hour'] . ':' . $declareTime['minute'] . ':' . $declareTime['second']);

                                if (!Candidate::where('public_key', $transaction->data->pub_key)->first()) {
                                    $candidate = new Candidate([
                                        'address' => $transaction->data->address,
                                        'public_key' => $transaction->data->pub_key,
                                        'declared_at_block' => $block->height,
                                        'declared_at_time' => $declareUnixTime
                                    ]);
                                    $candidate->save();
                                }
                            }
                        }
                    }

                    // Increment the app block
                    Redis::set('app:lastBlockChecked', $appLatestBlock + 1);
                } else {
                    Redis::set('app:sync', 'done');
                }
            }

            Redis::set('app:sync', 'done');
        }

        $candidates = Candidate::all();
        $candidatesSyncStatus = Redis::get('app:candidates-sync');

        if ($candidatesSyncStatus !== 'in_progress') {
            Redis::set('app:candidates-sync', 'in_progress');

            $validators = $api->getValidators()->result;

            foreach ($candidates as $candidate) {
                // Get candidate data
                $candidateData = $api->getCandidate($candidate->public_key);

                if ($candidateData->code === 0) {
                    $candidateData = $candidateData->result->candidate;

                    // Update candidate data
                    $candidate->status = $candidateData->status;

                    $totalStake = new BigInteger(0);
                    $selfStake = new BigInteger(0);
                    foreach ($candidateData->stakes as $stake) {
                        $totalStake->add($stake->bip_value);

                        if ($stake->owner === $candidateData->candidate_address) {
                            $selfStake->add($stake->bip_value);
                        }
                    }
                    $candidate->stake_total = $totalStake->getValue();
                    $candidate->stake_self = $selfStake->getValue();

                    if ($candidate->commission === null) {
                        $candidate->commission = $candidateData->commission;
                    }

                    foreach ($validators as $validator) {
                        if ($validator->candidate->pub_key === $candidate->public_key) {
                            $candidate->reward_accumulated = $validator->accumulated_reward;
                            $candidate->blocks_missed = $validator->absent_times;
                        }
                    }

                    $candidate->delegates = count($candidateData->stakes);
                    $candidate->save();
                }
            }

            Redis::set('app:candidates-sync', 'done');
        }
    }
}

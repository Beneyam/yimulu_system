<?php

namespace App\Console\Commands;

use App\Purchase_stat;
use App\Sales_stat;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class StatSummary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:summary';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Summary ';

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
        //
        $sales_first_date = Carbon::create('2020-04-01');
        $purchase_first_date = Carbon::create('2020-04-01');
        $last_date = Carbon::yesterday()->endOfDay();

        $purchase = Purchase_stat::select('purchase_date')->orderBy('purchase_date', 'desc')->first();
        $sales = Sales_stat::select('sales_date')->orderBy('sales_date', 'desc')->first();

        if (isset($purchase->purchase_date)) {
            $purchase_first_date = Carbon::create($purchase->purchase_date);
        }
        if (isset($sales->sales_date)) {
            $sales_first_date = Carbon::create($sales->sales_date);
        }
        $purchase_stat = DB::statement("INSERT INTO purchase_stats(purchase_id, yimulu_sales_type_id, quantity, purchase_date) SELECT purchase_id,yimulu_sales_type_id, count(id) as quantity, date(created_at) as purchase_date  from yimulu_saless where created_at>'".$purchase_first_date->endOfDay()->toDateTimeString()."' AND created_at<='".$last_date->toDateTimeString()."' GROUP By date(created_at),purchase_id,yimulu_sales_type_id");
        $sales_stat = DB::statement("INSERT INTO sales_stats( yimulu_sales_type_id, user_id, quantity, sales_date) SELECT yimulu_saless.yimulu_sales_type_id,  yimulu_sales.user_id,COUNT(yimulu_saless.yimulu_sales_type_id) as quantity, date(yimulu_sales.created_at) as sales_date from yimulu_salesINNER JOIN yimulu_saless ON yimulu_sales.yimulu_sales_id=yimulu_saless.id where yimulu_sales.created_at>'".$sales_first_date->endOfDay()->toDateTimeString()."' AND yimulu_sales.created_at<='".$last_date->toDateTimeString()."' GROUP by yimulu_saless.yimulu_sales_type_id, yimulu_sales.user_id, date(created_at)");
       // dd($sales_stat);
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\ParserController;

class Parser extends Command
{
	/**
	* The name and signature of the console command.
	*
	* @var string
	*/
	protected $signature = 'parse:podcast
											{url : The RSS feed URL}';

	/**
	* The console command description.
	*
	* @var string
	*/
	protected $description = 'Parse and store a RSS feed given the url';

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
	* @param  App\Http\Controllers\ParserController  $parser
	* @return mixed
	*/
	public function handle(ParserController $parser)
	{
		if ($this->confirm('Do you really wish to run this command?')) {
			$this->line('Staring parsing');
			$this->line('Result:');
			$result = $parser->store($this->argument('url'));
			if($result['status']==200){
				$this->info($result['message']);
				return 0;
			}else{
				$this->error($result['message']);
				return 1;
			}
		}else{
			$this->error('Parse cancelled');
            return 1;
		}
	}
}

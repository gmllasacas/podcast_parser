<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Box;

class ParserTest extends TestCase
{
	/**
	* Test for empty URL.
	*
	* @return void
	*/
	public function test_without_url_command()
	{
		$this->expectException(\Symfony\Component\Console\Exception\RuntimeException::class);
		$this->artisan('parse:podcast');
	}
	
	/**
	* Test for a denied confirmation.
	*
	* @return void
	*/
	public function test_cancel_parse_command()
	{
		$this->artisan('parse:podcast https://feeds.simplecast.com/54nAGcIl')
			->expectsConfirmation('Do you really wish to run this command?', 'no')
			->expectsOutput('Parse cancelled')
			->doesntExpectOutput('Parsed correctly')
			->assertExitCode(1);
	}

	/**
	* Test for a invalid URL.
	*
	* @return void
	*/
	public function test_invalid_url_command()
	{
		$this->artisan('parse:podcast invalidurl')
			->expectsConfirmation('Do you really wish to run this command?', 'yes')
			->expectsOutput('Staring parsing')
			->expectsOutput('Result:')
			->expectsOutput('The URL is invalid')
			->doesntExpectOutput('Parsed correctly')
			->assertExitCode(1);
	}

	/**
	* Test for a correct parse and store.
	*
	* @return void
	*/
	public function test_valid_parse_command()
	{
		$this->artisan('parse:podcast https://feeds.simplecast.com/54nAGcIl')
			->expectsConfirmation('Do you really wish to run this command?', 'yes')
			->expectsOutput('Staring parsing')
			->expectsOutput('Result:')
			->expectsOutput('Parsed correctly')
			->doesntExpectOutput('Parsed incorrectly')
			->assertExitCode(0);
	}

}

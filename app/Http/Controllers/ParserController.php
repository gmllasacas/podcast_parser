<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Episode;
use App\Models\Podcast;
use XMLReader;
use SimpleXMLElement;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class ParserController extends Controller
{

	/**
	* Function that validate the XML from a URL and parse it.
	*
	* @param  String  RSS feed $url
	* @return  Array
	*/
	public function parse(String $url)
	{
		$element_tag = 'item';
		$count = 0;
		$parsed = [];
		
		if(empty($url)) return $parsed;

		$xml = new XMLReader();
		try {
			if (!$xml->open($url)) {
				$xml->close();
				return $parsed;
			}

			while ($xml->read()) {
				if ($xml->name === 'channel' && $xml->nodeType == XMLReader::ELEMENT) {
					$element = new SimpleXMLElement($xml->readOuterXML());
					$atom = $element->children('atom', true);
					$atom_att = $atom->attributes();
					$parsed['podcast']['title'] = (string) $element->title;
					$parsed['podcast']['artwork_url'] = (string) $element->image->url;
					$parsed['podcast']['description'] = (string) $element->description;
					$parsed['podcast']['language'] = (string) $element->language;
					$parsed['podcast']['rss_url'] = (string) $atom_att['href'];
					$parsed['podcast']['website_url'] = (string) $element->link;
				}elseif ($xml->name === $element_tag && $xml->nodeType == XMLReader::ELEMENT) {
					$element = new SimpleXMLElement($xml->readOuterXML());
					$element_att = $element->enclosure->attributes();
					$parsed['episode'][$count]['title'] = (string) $element->title;
					$parsed['episode'][$count]['description'] = (string) $element->description;
					$parsed['episode'][$count]['audio_url'] = (string) $element_att['url'];
					$xml->next($element_tag);
					unset($element);
					$count++;
				}
			}

			$xml->close();
			return $parsed;
		} catch (\Exception $e) {
			//return $e->getMessage();
			return 'The URL has a malformed or invalid XML';
		}
	}

	/**
	* Function that store the RSS feed
	*
	* @param  String  RSS feed $url
	* @return  Array
	*/
	public function store(String $url)
	{

		$input = [
			'url' => $url,
		];

		$validator = Validator::make($input,
			[
				'url'=>'url'
			],
			[
				'url'=>'The URL is invalid'
			]
		);

		if ($validator->fails()) {
			$errors = '';
			foreach ($validator->errors()->all() as $error) {
				$errors .= $error;
			}
			return [
				'status' => '400',
				'message' => $errors,
			];
		}else{		
			$data = $this->parse($url);

			if(is_array($data)){
				if(Arr::exists($data, 'podcast')){
					$podcast = new Podcast();
					$podcast->fill($data['podcast']);
					if(!$podcast->save()){
						return [
							'status' => '400',
							'message' => 'Error at save',
						];
					}else{
						if(Arr::exists($data, 'episode')){
							foreach ($data['episode'] as &$item) {
								$episode = new Episode();
								$item['podcast_id'] = $podcast->id;
								$episode->fill($item);
								$episode->save();
							}
						}

						return [
							'status' => '200',
							//'message' => 'Podcast with '.count($data['episode']).' episode(s) saved, ID: '.$podcast->id,
							'message' => 'Parsed correctly',
						];
					}
				}else{
					return [
						'status' => '400',
						'message' => 'Parsed incorrectly',
					];
				}
			}else{
				return [
					'status' => '500',
					'message' => $data,
				];
			}
		}
	}
}

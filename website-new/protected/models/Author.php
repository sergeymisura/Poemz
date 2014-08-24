<?php
/**
 * Base class for Author model
 *
 * @package Regent.Common.Models
 *
 */
class Author extends AuthorBase
{
	public function pullWikiInfo()
	{
		/**
		 * @var  Http  $http
		 */
		$http = Yii::app()->http;

		try
		{
			$response = $http->get(
				'http://en.wikipedia.org/w/api.php',
				array(
					'format' => 'json',
					'action' => 'query',
					'prop' => 'extracts|info|pageimages',
					'inprop' => 'url',
					'exsentences' => '10',
					'pithumbsize' => '160',
					'titles' => $this->name
				)
			);

			$data = json_decode($response->data(), true);
			//var_dump($data);die();
			if ($data && isset($data['query']) && isset($data['query']['pages']) && count($data['query']['pages']) > 0)
			{
				$ids = array_keys($data['query']['pages']);
				$page = $data['query']['pages'][$ids[0]];
				$this->wiki_url = $page['fullurl'];
				$this->wiki_excerpt = $page['extract'];

				if (isset($page['thumbnail']))
				{
					$thumb_url = $page['thumbnail']['source'];
					if ($page['thumbnail']['width'] < 160) {
						$thumb_url = str_replace('/' . $page['thumbnail']['width'] . 'px-', '/160px-', $thumb_url);
					}
					$content = @file_get_contents($thumb_url);
					if ($content)
					{
						$image = new Image;
						$image->author_id = $this->submitter_id;
						$image->content = $content;
						$image->square(160);
						$image->save();

						$this->avatar_id = $image->id;
					}
				}

				return true;
			}

		}
		catch (HttpCurlException $ex)
		{
			return false;
		}
	}
}

<?php
/**
 * Base class for Author model
 *
 * @package Regent.Common.Models
 *
 * @property  string  $avatarUrl
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
					'titles' => $this->name,
					'redirects' => '1'
				)
			);

			$data = json_decode($response->data(), true);

			if ($data && isset($data['query']) && isset($data['query']['pages']) && count($data['query']['pages']) > 0)
			{
				$ids = array_keys($data['query']['pages']);
				$page = $data['query']['pages'][$ids[0]];
				if (!isset($page['extract']))
				{
					return false;
				}
				$this->wiki_url = $page['fullurl'];
				$this->wiki_excerpt = $page['extract'];

				if (isset($page['pageimage']))
				{
					$response = $http->get(
						'http://en.wikipedia.org/w/api.php',
						array(
							'format' => 'json',
							'action' => 'query',
							'prop' => 'imageinfo',
							'iiprop' => 'url',
							'titles' => 'File:' . $page['pageimage']
						)
					);

					$image_data = json_decode($response->data(), true);
					if ($image_data && isset($image_data['query']) && isset($image_data['query']['pages']) && count($image_data['query']['pages']) > 0)
					{
						$ids = array_keys($image_data['query']['pages']);
						$image_page = $image_data['query']['pages'][$ids[0]];

						if (isset($image_page['imageinfo']) && count($image_page['imageinfo']) && isset($image_page['imageinfo'][0]['url']))
						{
							$content = @file_get_contents($image_page['imageinfo'][0]['url']);
							if ($content)
							{
								$image = new Image;
								$image->author_id = $this->submitter_id;
								$image->content = $content;
								$image->save();

								$this->avatar_original_id = $image->id;
								$this->avatar_id = $image->square(200)->id;
							}
						}
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

	public function getAvatarUrl()
	{
		if ($this->avatar_id == null)
		{
			return Yii::app()->baseUrl . '/assets/img/mystery_man.png';
		}
		return $this->avatar->url;
	}
}

<?php
/**
 * Extension for Yii CClientScript that allows to load the list of resource files from a file
 *
 * @package CanDo.Components
 *
 */
class ClientScript extends CClientScript
{
	/**
	 * Loads a list of the resources from a file and registers them in the page
	 *
	 * @param   string   $file_name  A file that contains resources descriptions
	 * @param   boolean  $debug      True to load source scripts, false to load pre-compiled scripts instead
	 *
	 * @return  void
	 *
	 * @throws  CException
	 */
	public function loadResourcesFile($file_name, $debug)
	{
		$resources = json_decode(file_get_contents($file_name), true);
		if ($resources == null)
		{
			throw new CException('Cannot load resource file');
		}

		$assets = Yii::app()->baseUrl . '/' . 'assets' . '/';

		if ($debug)
		{
			foreach ($resources['javascript'] as $name => $options)
			{
				if (isset($options['url']))
				{
					$url = $assets . $options['url'] . '/';
				}
				else
				{
					$url = $assets;
				}
				foreach ($options['files'] as $file)
				{
					$this->registerScriptFile($url . $file);
				}
			}
			if (isset($resources['css']))
			{
				foreach ($resources['css']['files'] as $file)
				{
					$this->registerCssFile($assets . $file);
				}
			}
			if (isset($resources['less']))
			{
				$this->registerScriptFile($assets . 'js/lib/less-1.6.2.min.js');
				foreach ($resources['less'] as $name => $options)
				{
					foreach ($options['files'] as $file)
					{
						$this->registerLinkTag('stylesheet/less', 'text/css', $assets . $file);
					}
				}
			}
		}
		else
		{
			$hash = file_get_contents(Yii::app()->basePath . '/.hash');
			$cdn = Yii::app()->params->contains('cdn') ? Yii::app()->params['cdn'] : null;
			foreach ($resources['javascript'] as $name => $options)
			{
				if ($cdn != null)
				{
					$this->registerScriptFile(
						'http://' . $cdn . Yii::app()->createUrl(
							'site/assets',
							array(
								'hash' => $hash,
								'type' => 'js',
								'file' => $name . '.js'
							)
						)
					);
				}
				else
				{
					$this->registerScriptFile($assets . 'js' . '/' . 'compiled' . '/' . $name . '.js?' . $hash);
				}
			}
			foreach ($resources['css']['files'] as $file) {
				if ($cdn != null)
				{
					$name = substr($file, strpos($file, '/') + 1);
					$this->registerCssFile(
						'http://' . $cdn . Yii::app()->createUrl(
							'site/assets',
							array(
								'hash' => $hash,
								'type' => 'css',
								'file' => $name
							)
						)
					);
				}
				else
				{
					$this->registerCssFile($assets . $file . '?' . $hash);
				}
			}
		}
	}

	public function buildResources($file_name, $hash_only=false)
	{
		$resources = json_decode(file_get_contents($file_name), true);
		if ($resources == null)
		{
			throw new CException('Cannot load resource file');
		}

		$default_source_path = Yii::app()->basePath . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'assets';
		$compiler_path = Yii::getPathOfAlias('common') . DIRECTORY_SEPARATOR . 'compiler.jar';
		$output_path = $default_source_path . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'compiled';

		if (!is_dir($output_path))
		{
			if (!mkdir($output_path))
			{
				throw new CException('Unable to create output directory for JavaScript files.');
			}
		}

		$content = array_key_exists('salt', $resources) ? $resources['salt'] : '';
		foreach ($resources['javascript'] as $name => $options)
		{
			$output = $output_path . DIRECTORY_SEPARATOR . $name . '.js';
			$sources = array();
			if (isset($options['path']))
			{
				if (strpos($options['path'], ':') !== false)
				{
					$pair = explode(':', $options['path']);
					$source_path = Yii::getPathOfAlias($pair[0]) . DIRECTORY_SEPARATOR . $pair[1];
				}
				else
				{
					$source_path = $options['path'];
				}
			}
			else
			{
				$source_path = $default_source_path;
			}
			foreach ($options['files'] as $file)
			{
				$sources[] = '--js ' . $source_path . DIRECTORY_SEPARATOR . $file;
			}
			$cmd = 'java -jar ' . $compiler_path . ' --compilation_level ' . $options['level'] . ' ';
			$cmd .= implode(' ', $sources);
			$cmd .= ' --js_output_file ' . $output;

			if (!$hash_only)
			{
				passthru($cmd);
			}

			$content .= file_get_contents($output);
		}

		foreach ($resources['css']['files'] as $file)
		{
			$content .= file_get_contents($default_source_path . DIRECTORY_SEPARATOR . $file);
		}

		file_put_contents(Yii::app()->basePath . '/.hash', sha1($content));
	}
}

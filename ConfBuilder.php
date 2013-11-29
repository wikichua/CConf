<?php namespace CConf;

class ConfBuilder extends ConfFactory
{
	protected $configDirectory = '';

	public function setConfigDirectory($dir)
	{
		$this->configDirectory = $dir;
	}

	public function getConfigDirectory()
	{
		return $this->configDirectory;
	}

	public function set($key,$values = [])
	{
		if(is_array($key))
		{
			$this->pushToConfigAsArray($key);
		}	
	}

	public function get($key)
	{
		if(strpos($key,'.') > 0)
		{
			$result = $this->getFromConfigsNestedArray($key);
		}else{
			$result = $this->getFromConfigs($key);
		}

		if(is_null($result))
		{
			$result = $this->getFromConfigFile($key);
		}

		return $result;
	}

}
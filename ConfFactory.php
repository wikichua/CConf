<?php namespace CConf;

class ConfFactory
{
	protected $configs = [];
	protected $staticConfigs = [];

	public function pushToConfigAsArray(array $keys)
	{
		$this->configs = array_merge_recursive($this->configs,$keys);
	}

	public function pushToConfigAsSingle($keys,$values)
	{
		if(strpos($keys,'.') > 0)
		{
			$parts = array_filter(explode('.', $keys));
			$result = [];
		    $ref = &$result;
		    foreach($parts as $p) {
		        if(!isset($ref[$p])) {
		            $ref[$p] = array();
		        }
		        $ref = &$ref[$p];
		    }
		    $ref = $values;

			$this->pushToConfigAsArray($result);
		}
	}

	public function getFromConfigs($key)
	{
		$temp_config = @$this->configs[$key];
		return $temp_config;
	}

	public function getFromConfigsNestedArray($keys,$temp_configs = '')
	{
		$temp_configs = empty($temp_configs)? $this->configs:$temp_configs;
		foreach(explode('.',$keys) as $key){
			if(isset($temp_configs[$key]))
			{	
				$temp_configs = $temp_configs[$key];
			}
			else{
				return null;
			}
		}
		return $temp_configs;

	}

	public function getFromConfigFile($keys)
	{
		$temp_configs = $this->readFromConfigFile($keys);

		return $this->getFromConfigsNestedArray($keys,$temp_configs);
	}

	protected function readFromConfigFile($keys)
	{
		$keyData = explode('.',$keys);
		$file = $keyData[0];
		$directory = $this->getConfigDirectory();
		array_shift($keyData);
		if(!isset($this->staticConfigs[$file]))
		{
			$this->staticConfigs[$file] = require_once($directory.$file.'.php');
		}
		return $this->staticConfigs;
	}
}
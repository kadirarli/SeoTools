<?php namespace Vinicius73\SEO\Generators;

use Vinicius73\SEO\Contracts\TwitterAware;

class TwitterGenerator
{
	/**
	 * The prefix used by the twitter protocol.
	 *
	 * @const TWITTER_PREFIX
	 */
	const TWITTER_PREFIX = 'twitter:';

	/**
	 * The tag used by the twitter protocol.
	 *
	 * @const TWITTER_TAG
	 */
	const TWITTER_TAG = '<meta property="[property]" content="[value]" />';

	/**
	 * The properties that we are going to generate.
	 *
	 * @var array
	 */
	protected $properties = array();

	/**
	 * The properties that are required.
	 *
	 * @var array
	 */
	protected $required = array(
		'title',
		'url'
	);

	/**
	 * Render the twitter tags.
	 *
	 * @return string
	 */
	public function generate()
	{
		$html = array();

		foreach ($this->properties as $property => $value):
			if (is_array($value)):
				if(strpos($property,':') > 0):
					//$property = explode(':', $property);
					foreach ($value as $_value) {
						$html[] = strtr(
							static::TWITTER_TAG,
							array(
								'[property]' => $property,
								'[value]'    => $_value
							)
						);
					}
				else:
					foreach ($value as $_value){
						$html[] = strtr(
							static::TWITTER_TAG,
							array(
								'[property]' => static::TWITTER_PREFIX . $property,
								'[value]'    => $_value
							)
						);
					}
				endif;
			else:
				if(strpos($property,':') > 0):
					$html[] = strtr(
						static::TWITTER_TAG,
						array(
							'[property]' => $property,
							'[value]'    => $value
						)
					);
				else:
					$html[] = strtr(
						static::TWITTER_TAG,
						array(
							'[property]' => static::TWITTER_PREFIX . $property,
							'[value]'    => $value
						)
					);
				endif;
			endif;
		endforeach;

		return implode(PHP_EOL, $html);
	}

	/**
	 * Set the twitter properties from a raw array.
	 *
	 * @param array $properties
	 */
	public function fromRaw($properties)
	{
		$this->validateProperties($properties);

		foreach ($properties as $property => $value) {
			$this->properties[$property] = $value;
		}
	}

	/**
	 * Use the twitter data of a twitter aware object.
	 *
	 * @param TwitterAware $object
	 */
	public function fromObject(TwitterAware $object)
	{
		$properties = $object->getTwitterData();

		$this->validateProperties($properties);

		foreach ($properties as $property => $value) {
			$this->properties[$property] = $value;
		}
	}

	/**
	 * Reset all the properties.
	 *
	 * @return void
	 */
	public function reset()
	{
		$this->properties = array();
	}

	/**
	 * Validate to make sure the properties contain all required ones.
	 *
	 * @param array $properties
	 */
	protected function validateProperties($properties)
	{
		foreach ($this->required as $required) {
			if (!array_key_exists($required, $properties)) {
				throw new \InvalidArgumentException("Required twitter property [$required] is not present.");
			}
		}
	}
}

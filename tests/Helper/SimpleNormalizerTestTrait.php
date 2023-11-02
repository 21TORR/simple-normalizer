<?php declare(strict_types=1);

namespace Tests\Torr\SimpleNormalizer\Helper;

use Symfony\Component\DependencyInjection\ServiceLocator;
use Torr\SimpleNormalizer\Normalizer\SimpleNormalizer;
use Torr\SimpleNormalizer\Normalizer\SimpleObjectNormalizerInterface;

/**
 * @api
 */
trait SimpleNormalizerTestTrait
{
	/**
	 * Receives a list of simple object normalizers and returns
	 */
	private function createNormalizer (SimpleObjectNormalizerInterface ...$normalizers) : SimpleNormalizer
	{
		$locators = [];

		foreach ($normalizers as $normalizer)
		{
			$locators[$normalizer::getNormalizedType()] = static fn () => $normalizer;
		}

		return new SimpleNormalizer(new ServiceLocator($locators));
	}
}

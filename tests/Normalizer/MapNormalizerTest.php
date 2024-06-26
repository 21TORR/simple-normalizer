<?php declare(strict_types=1);

namespace Tests\Torr\SimpleNormalizer\Normalizer;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ServiceLocator;
use Torr\SimpleNormalizer\Normalizer\SimpleNormalizer;

/**
 * @internal
 */
final class MapNormalizerTest extends TestCase
{
	/**
	 *
	 */
	public function testNonEmptyMap () : void
	{
		$normalizer = new SimpleNormalizer(new ServiceLocator([]));
		$result = $normalizer->normalizeMap([
			"o" => "hai",
		], []);

		self::assertSame('{"o":"hai"}', json_encode($result));
	}

	/**
	 *
	 */
	public function testEmptyMap () : void
	{
		$normalizer = new SimpleNormalizer(new ServiceLocator([]));
		$result = $normalizer->normalizeMap([], []);

		self::assertSame('{}', json_encode($result));
	}
}

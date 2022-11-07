<?php declare(strict_types=1);

namespace Tests\Torr\SimpleNormalizer\Normalizer;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ServiceLocator;
use Tests\Torr\SimpleNormalizer\Fixture\DummyVO;
use Torr\SimpleNormalizer\Exception\ObjectTypeNotSupportedException;
use Torr\SimpleNormalizer\Normalizer\SimpleNormalizer;
use Torr\SimpleNormalizer\Normalizer\SimpleObjectNormalizerInterface;

final class ObjectNormalizationTest extends TestCase
{
	/**
	 *
	 */
	public function testNormalizeObject () : void
	{
		$dummyNormalizer = new class implements SimpleObjectNormalizerInterface
		{
			public function normalize (object $value, array $context, SimpleNormalizer $normalizer) : mixed
			{
				\assert($value instanceof DummyVO);
				return [
					"id" => $value->id,
				];
			}

			public static function getNormalizedType () : string
			{
				return DummyVO::class;
			}
		};

		$value = new DummyVO(42);
		$normalizer = new SimpleNormalizer(new ServiceLocator([
			$dummyNormalizer::getNormalizedType() => static fn () => $dummyNormalizer,
		]));

		self::assertEquals(["id" => 42], $normalizer->normalize($value));
	}

	/**
	 *
	 */
	public function testMissingNormalizer () : void
	{
		$this->expectException(ObjectTypeNotSupportedException::class);

		$normalizer = new SimpleNormalizer(new ServiceLocator([]));
		$normalizer->normalize(new DummyVO(11));
	}
}

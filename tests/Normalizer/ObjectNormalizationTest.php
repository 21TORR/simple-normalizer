<?php declare(strict_types=1);

namespace Tests\Torr\SimpleNormalizer\Normalizer;

use PHPUnit\Framework\TestCase;
use Tests\Torr\SimpleNormalizer\Fixture\DummyVO;
use Torr\SimpleNormalizer\Exception\ObjectTypeNotSupportedException;
use Torr\SimpleNormalizer\Normalizer\SimpleNormalizer;
use Torr\SimpleNormalizer\Normalizer\SimpleObjectNormalizerInterface;
use Torr\SimpleNormalizer\Test\SimpleNormalizerTestTrait;

/**
 * @internal
 */
final class ObjectNormalizationTest extends TestCase
{
	use SimpleNormalizerTestTrait;

	/**
	 *
	 */
	public function testNormalizeObject () : void
	{
		$dummyNormalizer = new class() implements SimpleObjectNormalizerInterface {
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
		$normalizer = $this->createNormalizer($dummyNormalizer);

		self::assertSame(["id" => 42], $normalizer->normalize($value));
	}

	/**
	 *
	 */
	public function testMissingNormalizer () : void
	{
		$this->expectException(ObjectTypeNotSupportedException::class);

		$normalizer = $this->createNormalizer();
		$normalizer->normalize(new DummyVO(11));
	}
}

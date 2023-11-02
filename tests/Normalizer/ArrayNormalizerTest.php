<?php declare(strict_types=1);

namespace Tests\Torr\SimpleNormalizer\Normalizer;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ServiceLocator;
use Tests\Torr\SimpleNormalizer\Helper\SimpleNormalizerTestTrait;
use Torr\SimpleNormalizer\Normalizer\SimpleNormalizer;

final class ArrayNormalizerTest extends TestCase
{
	use SimpleNormalizerTestTrait;

	/**
	 *
	 */
	public function provideListArray () : iterable
	{
		yield [[1, 2, 3, 4], [1, 2, 3, 4]];
		yield [[1, null, 3, null], [1, 3]];
		yield [[], []];
		yield [[null], []];
	}

	/**
	 * @dataProvider provideListArray
	 */
	public function testListArray (array $input, array $expected) : void
	{
		$normalizer = $this->createNormalizer();
		$actual = $normalizer->normalize($input);

		self::assertEquals($expected, $actual);
		self::assertTrue(\array_is_list($actual));
	}

	/**
	 *
	 */
	public function provideAssociativeArray () : iterable
	{
		yield [["a" => 1, "b" => 2, "c" => 3, "d" => 4], ["a" => 1, "b" => 2, "c" => 3, "d" => 4]];
		yield [["a" => 1, "b" => null, "c" => 3, "d" => null], ["a" => 1, "b" => null, "c" => 3, "d" => null]];
		yield [["empty" => null], ["empty" => null]];
	}

	/**
	 * @dataProvider provideAssociativeArray
	 */
	public function testAssociativeArray (array $input, array $expected) : void
	{
		$normalizer = $this->createNormalizer();
		$actual = $normalizer->normalize($input);

		self::assertEquals($expected, $actual);
		self::assertFalse(\array_is_list($actual));
	}
}

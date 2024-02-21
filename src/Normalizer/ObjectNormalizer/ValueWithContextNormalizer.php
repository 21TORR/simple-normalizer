<?php declare(strict_types=1);

namespace Torr\SimpleNormalizer\Normalizer\ObjectNormalizer;

use Torr\SimpleNormalizer\Data\ValueWithContext;
use Torr\SimpleNormalizer\Normalizer\SimpleNormalizer;
use Torr\SimpleNormalizer\Normalizer\SimpleObjectNormalizerInterface;

final class ValueWithContextNormalizer implements SimpleObjectNormalizerInterface
{
	/**
	 * @inheritDoc
	 */
	public function normalize (object $value, array $context, SimpleNormalizer $normalizer) : mixed
	{
		\assert($value instanceof ValueWithContext);

		return $normalizer->normalize(
			$value->value,
			\array_replace($context, $value->context),
		);
	}


	/**
	 * @inheritDoc
	 */
	public static function getNormalizedType () : string
	{
		return ValueWithContext::class;
	}
}

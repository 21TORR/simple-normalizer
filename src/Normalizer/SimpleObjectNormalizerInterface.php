<?php declare(strict_types=1);

namespace Torr\SimpleNormalizer\Normalizer;

interface SimpleObjectNormalizerInterface
{
	/**
	 * Normalizes the given value
	 */
	public function normalize (object $value, array $context, SimpleNormalizer $normalizer) : mixed;

	/**
	 * Returns the FQCN of the class that is normalized using this normalizer
	 */
	public static function getNormalizedType () : string;
}

<?php declare(strict_types=1);

namespace Torr\SimpleNormalizer\Exception;

/**
 * Generic failure exception, for usage inside of custom normalizers.
 */
class NormalizationFailedException extends \RuntimeException implements NormalizerExceptionInterface
{
}

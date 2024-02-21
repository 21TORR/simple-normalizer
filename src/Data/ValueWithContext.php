<?php declare(strict_types=1);

namespace Torr\SimpleNormalizer\Data;

final readonly class ValueWithContext
{
	/**
	 */
	public function __construct (
		public mixed $value,
		public array $context = [],
	) {}
}

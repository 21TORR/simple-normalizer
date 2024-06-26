<?php declare(strict_types=1);

namespace Torr\SimpleNormalizer\Normalizer;

use Doctrine\Common\Util\ClassUtils;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\DependencyInjection\ServiceLocator;
use Torr\SimpleNormalizer\Exception\ObjectTypeNotSupportedException;
use Torr\SimpleNormalizer\Exception\UnsupportedTypeException;

/**
 * The normalizer to use in your app.
 *
 * Can't be readonly, as it needs to be mock-able.
 *
 * @final
 */
class SimpleNormalizer
{
	/**
	 * @param ServiceLocator<SimpleObjectNormalizerInterface> $objectNormalizers
	 */
	public function __construct (
		private readonly ServiceLocator $objectNormalizers,
	) {}

	/**
	 */
	public function normalize (mixed $value, array $context = []) : mixed
	{
		if (null === $value || \is_scalar($value))
		{
			return $value;
		}

		if (\is_array($value))
		{
			return $this->normalizeArray($value, $context);
		}

		if (\is_object($value))
		{
			try
			{
				$className = $value::class;

				if (class_exists(ClassUtils::class))
				{
					$className = ClassUtils::getRealClass($className);
				}

				$normalizer = $this->objectNormalizers->get($className);
				\assert($normalizer instanceof SimpleObjectNormalizerInterface);

				return $normalizer->normalize($value, $context, $this);
			}
			catch (ServiceNotFoundException $exception)
			{
				throw new ObjectTypeNotSupportedException(sprintf(
					"Can't normalize type %s",
					get_debug_type($value),
				), 0, $exception);
			}
		}

		throw new UnsupportedTypeException(sprintf(
			"Can't normalize type %s",
			get_debug_type($value),
		));
	}

	/**
	 */
	public function normalizeArray (array $array, array $context) : array
	{
		$result = [];
		$isList = array_is_list($array);

		foreach ($array as $key => $value)
		{
			$normalized = $this->normalize($value, $context);

			// if the array was a list and the normalized value is null, just filter it out
			if ($isList && null === $normalized)
			{
				continue;
			}

			if ($isList)
			{
				// for list: reindex without holes
				$result[] = $normalized;
			}
			else
			{
				// for map: keep key
				$result[$key] = $normalized;
			}
		}

		return $result;
	}

	/**
	 * Normalizes a map of values.
	 * Will JSON-encode to `{}` when empty.
	 */
	public function normalizeMap (array $array, array $context) : array|\stdClass
	{
		// return stdClass if the array is empty here, as it will be automatically normalized to `{}` in JSON.
		return $this->normalizeArray($array, $context) ?: new \stdClass();
	}
}

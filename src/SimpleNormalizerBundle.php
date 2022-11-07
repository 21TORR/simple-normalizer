<?php declare(strict_types=1);

namespace Torr\SimpleNormalizer;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Torr\BundleHelpers\Bundle\BundleExtension;
use Torr\SimpleNormalizer\Normalizer\SimpleObjectNormalizerInterface;

final class SimpleNormalizerBundle extends Bundle
{
	/**
	 * @inheritDoc
	 */
	public function getContainerExtension () : ExtensionInterface
	{
		return new BundleExtension($this);
	}

	/**
	 * @inheritDoc
	 */
	public function build (ContainerBuilder $container) : void
	{
		$container->registerForAutoconfiguration(SimpleObjectNormalizerInterface::class)
			->addTag("torr.normalizer.simple-object-normalizer");
	}

	/**
	 * @inheritDoc
	 */
	public function getPath () : string
	{
		return \dirname(__DIR__);
	}
}

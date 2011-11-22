<?php
namespace Kalkuli\ServerBundle;

use Symfony\Component\Serializer;

class HttpUtils {
	public static function deserializeRequest($request, $targetClass, $format) {
		$serializer = new Serializer\Serializer(
			array($format => new Serializer\Normalizer\GetSetMethodNormalizer()),
			array($format => new Serializer\Encoder\JsonEncoder())
		);

		return $serializer->denormalize(
			$serializer->decode($request->getContent(), $format),
				$targetClass,
				$format
		);
	}
}
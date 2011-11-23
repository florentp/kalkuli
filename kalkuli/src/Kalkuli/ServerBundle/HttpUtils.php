<?php
namespace Kalkuli\ServerBundle;

use Symfony\Component\Serializer;

class HttpUtils {
	public static function jsonDenormalizeRequest($request, $targetClass, $path = '') {
		$serializer = new Serializer\Serializer(
			array('json' => new Serializer\Normalizer\GetSetMethodNormalizer()),
			array('json' => new Serializer\Encoder\JsonEncoder())
		);

		$decodedContent = $serializer->decode($request->getContent(), 'json');

		if (!is_empty($path)) {
			foreach (preg_split('/\./', $path) as $partOfPath) {
				$decodedContent = $decodedContent[$partOfPath];
			}
		}

		return $serializer->denormalize($decodedContent, $targetClass, 'json');
	}

	public static function jsonDecodeRequest($request, $path = '') {
		$decodedContent = json_decode($request->getContent(), true);

		if (!is_empty($path)) {
			foreach (preg_split('/\./', $path) as $partOfPath) {
				$decodedContent = $decodedContent[$partOfPath];
			}
		}

		return $decodedContent;
	}
}
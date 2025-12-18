<?php

/*
 * This file is part of the Dragonpay library.
 *
 * (c) Jefferson Claud <jeffclaud17@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 *
 * Extended by Bo Sanchez Inc. to support HMAC-SHA256 validation
 */

namespace Crazymeeks\Foundation\PaymentGateway;

use Crazymeeks\Encryption\Sha1Encryption;
use Crazymeeks\Encryption\HmacSha256Encryption;

class SignatureValidator
{
	/**
	 * Validate HMAC-SHA256 signature
	 *
	 * @param array $data Callback data with txnid, refno, status, message, amount, signature
	 * @param string $secretKey Merchant secret key
	 * @return bool
	 */
	public static function validateHmacSha256Signature($data, $secretKey)
	{
		$required = ['txnid', 'refno', 'status', 'message', 'amount', 'signature'];
		foreach ($required as $param) {
			if (!isset($data[$param])) {
				return false;
			}
		}

		$messageParams = [
			$data['txnid'],
			$data['refno'],
			$data['status'],
			$data['message'],
			number_format((float)$data['amount'], 2, '.', '')
		];

		$digestor = new HmacSha256Encryption($secretKey);
		$computed = $digestor->make($messageParams);

		return hash_equals($computed, strtoupper($data['signature']));
	}

	/**
	 * Validate SHA-1 digest (legacy)
	 *
	 * @param array $data Callback data with txnid, refno, status, message, digest
	 * @param string $password Merchant password
	 * @return bool
	 */
	public static function validateSha1Digest($data, $password)
	{
		$digestParams = [
			$data['txnid'],
			$data['refno'],
			$data['status'],
			$data['message'],
			$password
		];

		$digestor = new Sha1Encryption();
		$computed = $digestor->make($digestParams);

		return hash_equals($computed, $data['digest']);
	}

	/**
	 * Auto-detect signature type and validate
	 *
	 * @param array $data Callback data
	 * @param string $password Merchant password/secret
	 * @return array ['valid' => bool, 'algorithm' => string]
	 */
	public static function validate($data, $password)
	{
		// Try HMAC-SHA256 first (if signature parameter present)
		if (isset($data['signature'])) {
			return [
				'valid' => self::validateHmacSha256Signature($data, $password),
				'algorithm' => 'hmac-sha256'
			];
		}

		// Fallback to SHA-1 (if digest parameter present)
		if (isset($data['digest'])) {
			return [
				'valid' => self::validateSha1Digest($data, $password),
				'algorithm' => 'sha1'
			];
		}

		return [
			'valid' => false,
			'algorithm' => 'unknown'
		];
	}
}

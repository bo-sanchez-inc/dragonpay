<?php

/*
 * This file is part of the Dragonpay library.
 *
 * (c) Jefferson Claud <jeffclaud17@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 *
 * Extended by Bo Sanchez Inc. to support HMAC-SHA256
 */

namespace Crazymeeks\Encryption;

use Crazymeeks\Contracts\DigestInterface;

class HmacSha256Encryption implements DigestInterface
{
	/**
	 * The secret key for HMAC
	 * @var string
	 */
	protected $secretKey;

	/**
	 * Constructor
	 * @param string $secretKey The merchant secret key
	 */
	public function __construct($secretKey)
	{
		$this->secretKey = $secretKey;
	}

	/**
	 * Create HMAC-SHA256 digest
	 *
	 * @inheritDoc
	 * @param array $data The data to be encrypted
	 * @return string The HMAC-SHA256 signature (uppercase hex)
	 */
	public function make(array $data)
	{
		// Build message string by joining with colons
		$message = implode(':', $data);

		// Determine if secret key is hex-encoded
		$isHexKey = $this->isHexEncoded($this->secretKey);

		// Prepare key for HMAC
		if ($isHexKey) {
			// Hex decode: convert hex string to binary
			$keyBytes = hex2bin($this->secretKey);
		} else {
			// UTF-8: use key as-is
			$keyBytes = $this->secretKey;
		}

		// Compute HMAC-SHA256 signature (return uppercase hex)
		return strtoupper(hash_hmac('sha256', $message, $keyBytes));
	}

	/**
	 * Check if a string is hex-encoded
	 *
	 * @param string $str
	 * @return bool
	 */
	protected function isHexEncoded($str)
	{
		return ctype_xdigit($str) && strlen($str) % 2 === 0;
	}
}

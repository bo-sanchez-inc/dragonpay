<?php

/*
 * This file is part of the Dragonpay library.
 *
 * (c) Jefferson Claud <jeffclaud17@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 *
 * Extended by Bo Sanchez Inc. for RSA-SHA256 support
 */

namespace Crazymeeks\Encryption;

use Crazymeeks\Contracts\AsymmetricSignatureInterface;

class RsaSha256Signature implements AsymmetricSignatureInterface
{
	/**
	 * Merchant ID
	 * @var string
	 */
	protected $merchantId;

	/**
	 * API Key
	 * @var string
	 */
	protected $apiKey;

	/**
	 * Test mode flag
	 * @var bool
	 */
	protected $isTestMode;

	/**
	 * Cached public key
	 * @var string|null
	 */
	protected $publicKey;

	/**
	 * Constructor
	 *
	 * @param string $merchantId Merchant ID
	 * @param string $apiKey API Key
	 * @param bool $isTestMode True for test environment
	 */
	public function __construct($merchantId, $apiKey, $isTestMode = true)
	{
		$this->merchantId = $merchantId;
		$this->apiKey = $apiKey;
		$this->isTestMode = $isTestMode;
		$this->publicKey = null;
	}

	/**
	 * Verify RSA-SHA256 signature
	 *
	 * TODO: Implement RSA-SHA256 verification
	 *
	 * Implementation steps:
	 * 1. Get public key(s) from Dragonpay API
	 * 2. Decode base64 signature
	 * 3. Verify signature using RSA with SHA-256
	 * 4. Return verification result
	 *
	 * @param string $message The message that was signed
	 * @param string $signature The base64-encoded signature
	 * @return bool
	 * @throws \Exception Not yet implemented
	 */
	public function verify($message, $signature)
	{
		throw new \Exception('RSA-SHA256 signature verification not yet implemented. This feature is planned for a future release after March 31, 2026.');
	}

	/**
	 * Get public key from cache or API
	 *
	 * TODO: Implement public key fetching
	 *
	 * Implementation steps:
	 * 1. Check if key is cached and not expired
	 * 2. If not cached or expired, fetch from Dragonpay API
	 * 3. Cache the key with expiration timestamp
	 * 4. Return PEM-formatted public key
	 *
	 * API Endpoint: <baseurl>/keys/callback
	 *
	 * @return string
	 * @throws \Exception Not yet implemented
	 */
	public function getPublicKey()
	{
		throw new \Exception('Public key fetching not yet implemented. API endpoint: <baseurl>/keys/callback');
	}

	/**
	 * Refresh public key from Dragonpay API
	 *
	 * TODO: Implement key refresh strategy
	 *
	 * Implementation steps:
	 * 1. Call Dragonpay API: GET <baseurl>/keys/callback
	 * 2. Parse response to get active public keys
	 * 3. Update cache with new keys
	 * 4. Set cache expiration (recommended: 24 hours)
	 *
	 * @return void
	 * @throws \Exception Not yet implemented
	 */
	public function refreshPublicKey()
	{
		throw new \Exception('Public key refresh not yet implemented. Cache refresh strategy pending.');
	}
}

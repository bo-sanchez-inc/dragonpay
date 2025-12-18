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

namespace Crazymeeks\Contracts;

interface AsymmetricSignatureInterface
{
	/**
	 * Verify RSA-SHA256 signature
	 *
	 * @param string $message The message that was signed
	 * @param string $signature The base64-encoded signature
	 * @return bool True if signature is valid
	 */
	public function verify($message, $signature);

	/**
	 * Get public key from cache or API
	 *
	 * @return string PEM-formatted public key
	 */
	public function getPublicKey();

	/**
	 * Refresh public key from Dragonpay API
	 *
	 * @return void
	 */
	public function refreshPublicKey();
}

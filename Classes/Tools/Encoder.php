<?php
/**
 * Created by PhpStorm.
 * User: frank
 * Date: 31.01.18
 * Time: 15:29
 */

namespace SUDHAUS7\Datavault\Tools;


class Encoder {

	/**
	 * @var array
	 */
	protected $pubkeys = [];


	/**
	 * @var string
	 */
	protected $content = '';

	/**
	 * @var string
	 */
	protected $method = 'RC4';

	public function __construct($content,$pubKeys = [],$method='RC4') {
		if (is_array($content)) $content=\json_encode( $content );
		if (\is_object( $content)) throw new \Exception('No support for Objects');
		$this->content = $content;
		$this->setPubkeys($pubKeys);
		$this->setMethod( $method);

	}
	public function setContent($content) {
		$this->content = $content;
	}

	public function run() {
		$signatures = array_keys($this->pubkeys);
		$pubkeys = array_values($this->pubkeys);
		$iv = \openssl_random_pseudo_bytes(32);
		foreach ($pubkeys as $idx=>$key) {
			$pubkeys[$idx] = \openssl_get_publickey($key);
		}

		\openssl_seal($this->content, $sealed, $ekeys, $pubkeys, $this->method, $iv);
		$this->content = '';
		foreach ($pubkeys as $key) {
			 \openssl_free_key($key);
		}
		$envelope = [];
		foreach ($ekeys as $k=>$ekey) {
			$envelope[$signatures[$k]]=base64_encode($ekey);
		}
		$b64_iv = base64_encode( $iv );
		$b64_envelope = base64_encode(json_encode( $envelope ));
		$b64_data = base64_encode( $sealed );
		return $this->method.':'.$b64_iv.':'.$b64_envelope.':'.$b64_data;
	}

	public function addPubkey($key) {
		$checksum = Keys::getChecksum( $key );
		$this->pubkeys[$checksum] = $key;
	}

	public function getChecksums() {
		return array_keys($this->pubkeys);
	}

	/**
	 * @return array
	 */
	public function getPubkeys(): array {
		return array_values($this->pubkeys);
	}

	/**
	 * @param array $pubkeys
	 */
	public function setPubkeys( array $pubkeys ) {
		foreach ($pubkeys as $key) {
			$checksum = Keys::getChecksum( $key );
			$this->pubkeys[$checksum] = $key;
		}
	}

	/**
	 * @return string
	 */
	public function getMethod(): string {
		return $this->method;
	}

	/**
	 * @param string $method
	 */
	public function setMethod( string $method ) {
		$valid = ['RC4','AES128','AES256','DES'];
		if (\in_array( $method, $valid)) $this->method = $method;
	}


	/**
	 * @param $row array
	 * @param $fields array
	 * @param $publicKeys array
	 * @param string $method
	 *
	 * @return array
	 */
	public static function encodeArray($row,$fields,$publicKeys,$method='RC4') {
		$checksums = null;
		foreach ($fields as $field) {
			if (isset($row[$field]) && !empty($row[$field])) {
				$encoder = new Encoder( $row[$field],$publicKeys,$method);
				$row[$field] = $encoder->run();
				if (!$checksums) $checksums=$encoder->getChecksums();
			}
		}
		return [$row,$checksums];
	}

}

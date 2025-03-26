<?php
/**
 * @copyright 2012-2025 MetricWise, Inc.
 * @license https://opensource.org/licenses/MIT
 */
class MetricWiseAPI
{
	/**
	 * @var string
	 */
	private $accessKey;

	/**
	 * @var string
	 */
	private $error;
	
	/**
	 * @var string
	 */
	private $hostname;

	/**
	 * @var string
	 */
	private $username;

	/**
	 * @param string $accessKey
	 */
	public function setAccessKey($accessKey) {
		$this->accessKey = $accessKey;
	}

	/**
	 * @param string $hostname
	 */
	public function setHostname($hostname) {
		$this->hostname = $hostname;
	}

	/**
	 * @param string $username
	 */
	public function setUsername($username) {
		$this->username = $username;
	}

	/**
	 * @return string
	 */
	public function getError() {
		return $this->error;
	}

	/**
	 * @param array $lead
	 */
	public function submitLead($lead) {
		$curl = curl_init("$this->hostname/mwapi/lead");
		curl_setopt($curl, CURLOPT_HTTPHEADER, array("x-api-key: $this->username:$this->accessKey"));
		curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($lead));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($curl);
		$this->error = curl_error($curl);
		$errno = curl_errno($curl);
		$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		curl_close($curl);

		if ($errno) {
			return false;
		}

		if (202 != $httpcode) {
			$this->error = json_decode($result)->message;
			return false;
		}

		return true;
	}
}

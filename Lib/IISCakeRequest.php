<?php
/**
 * IIS compatible CakeRequest
 *
 * Licensed under The MIT License.
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Marc Würth
 * @author Marc Würth <ravage@bluewin.ch>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @link https://github.com/ravage84/ValidForeignKeyBehavior
 */

App::uses('CakeRequest', 'Network');

/**
 * An IIS compatible CakeRequest derivate
 *
 * Re-implements the _uri method to enable case insensitive base paths.
 *
 * @link https://github.com/cakephp/cakephp/pull/1359 The backstory on GitHub.
 */
class IISCakeRequest extends CakeRequest {

/**
 * The IIS compatible method, which allows insensitive base paths.
 *
 * @return string
 * @see CakeRequest::_url()
 */
	protected function _url() {
		if (!empty($_SERVER['PATH_INFO'])) {
			return $_SERVER['PATH_INFO'];
		} elseif (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], '://') === false) {
			$uri = $_SERVER['REQUEST_URI'];
		} elseif (isset($_SERVER['REQUEST_URI'])) {
			$qPosition = strpos($_SERVER['REQUEST_URI'], '?');
			if ($qPosition !== false && strpos($_SERVER['REQUEST_URI'], '://') > $qPosition) {
				$uri = $_SERVER['REQUEST_URI'];
			} else {
				$uri = substr($_SERVER['REQUEST_URI'], strlen(Configure::read('App.fullBaseUrl')));
			}
		} elseif (isset($_SERVER['PHP_SELF']) && isset($_SERVER['SCRIPT_NAME'])) {
			$uri = str_replace($_SERVER['SCRIPT_NAME'], '', $_SERVER['PHP_SELF']);
		} elseif (isset($_SERVER['HTTP_X_REWRITE_URL'])) {
			$uri = $_SERVER['HTTP_X_REWRITE_URL'];
		} elseif ($var = env('argv')) {
			$uri = $var[0];
		}

		$base = $this->base;

		// FIX: We use case insensitive stripos instead:
		if (strlen($base) > 0 && stripos($uri, $base) === 0) {
			$uri = substr($uri, strlen($base));
		}
		if (strpos($uri, '?') !== false) {
			list($uri) = explode('?', $uri, 2);
		}
		if (empty($uri) || $uri === '/' || $uri === '//' || $uri === '/index.php') {
			$uri = '/';
		}
		$endsWithIndex = '/webroot/index.php';
		$endsWithLength = strlen($endsWithIndex);
		if (
			strlen($uri) >= $endsWithLength &&
			substr($uri, -$endsWithLength) === $endsWithIndex
		) {
			$uri = '/';
		}
		return $uri;
	}

}

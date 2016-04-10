<?php

/**
 * This file is part of the Nginx Config Processor package.
 *
 * (c) Roman Piták <roman@pitak.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

namespace App\SYPanel\Ngnix;

abstract class Printable {

	public function __toString() {
		return $this->prettyPrint(0);
	}

	abstract public function prettyPrint($indentLevel, $spacesPerIndent = 4);
}
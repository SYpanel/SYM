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

class Scope extends Printable {

	/** @var Directive $parentDirective */
	protected $parentDirective = null;

	/** @var Directive[] $directives */
	protected $directives = [];

	/** @var Printable[] $printables */
	protected $printables = [];

	/**
	 * Provides fluid interface.
	 *
	 * @return Scope
	 */
	public static function create() {
		return new self();
	}

	/*
	 * ========== Factories ==========
	 */

	/**
	 * Create new Scope from a file.
	 *
	 * @param $filePath
	 * @return Scope
	 */
	public static function fromFile($filePath) {
		return self::fromString(new File($filePath));
	}

	/**
	 * Create new Scope from the configuration string.
	 *
	 * @param \RomanPitak\Nginx\Config\Text $configString
	 * @return Scope
	 * @throws Exception
	 */
	public static function fromString(Text $configString) {
		$scope = new Scope();
		while (false === $configString->eof()) {

			if (true === $configString->isEmptyLine()) {
				$scope->addPrintable(EmptyLine::fromString($configString));
			}

			$char = $configString->getChar();

			if ('#' === $char) {
				$scope->addPrintable(Comment::fromString($configString));
				continue;
			}

			if (('a' <= $char) && ('z' >= $char)) {
				$scope->addDirective(Directive::fromString($configString));
				continue;
			}

			if ('}' === $configString->getChar()) {
				break;
			}

			$configString->inc();
		}

		return $scope;
	}

	/**
	 * Add printable element.
	 *
	 * @param Printable $printable
	 */
	protected function addPrintable(Printable $printable) {
		$this->printables[] = $printable;
	}

	/*
	 * ========== Getters ==========
	 */

	/**
	 * Add a Directive to the list of this Scopes directives
	 *
	 * Adds the Directive and sets the Directives parent Scope to $this.
	 *
	 * @param Directive $directive
	 * @return $this
	 */
	public function addDirective(Directive $directive) {
		if ($directive->getParentScope() !== $this) {
			$directive->setParentScope($this);
		}

		$this->directives[] = $directive;
		$this->addPrintable($directive);

		return $this;
	}

	/*
	 * ========== Setters ==========
	 */

	/**
	 * Write this Scope into a file.
	 *
	 * @param $filePath
	 * @throws Exception
	 */
	public function saveToFile($filePath) {
		$handle = @fopen($filePath, 'w');
		if (false === $handle) {
			throw new Exception('Cannot open file "' . $filePath . '" for writing.');
		}

		$bytesWritten = @fwrite($handle, (string)$this);
		if (false === $bytesWritten) {
			fclose($handle);
			throw new Exception('Cannot write into file "' . $filePath . '".');
		}

		$closed = @fclose($handle);
		if (false === $closed) {
			throw new Exception('Cannot close file handle for "' . $filePath . '".');
		}
	}

	/**
	 * Get parent Directive.
	 *
	 * @return Directive|null
	 */
	public function getParentDirective() {
		return $this->parentDirective;
	}

	/**
	 * Set parent directive for this Scope.
	 *
	 * Sets parent directive for this Scope and also
	 * sets the $parentDirective->setChildScope($this)
	 *
	 * @param Directive $parentDirective
	 * @return $this
	 */
	public function setParentDirective(Directive $parentDirective) {
		$this->parentDirective = $parentDirective;

		if ($parentDirective->getChildScope() !== $this) {
			$parentDirective->setChildScope($this);
		}

		return $this;
	}

	public function getDirectives() {
		return $this->directives;
	}

	/*
	 * ========== Printable ==========
	 */

	public function __toString() {
		return $this->prettyPrint(-1);
	}

	/**
	 * Pretty print with indentation.
	 *
	 * @param     $indentLevel
	 * @param int $spacesPerIndent
	 * @return string
	 */
	public function prettyPrint($indentLevel, $spacesPerIndent = 4) {
		$resultString = "";
		foreach ($this->printables as $printable) {
			$resultString .= $printable->prettyPrint($indentLevel + 1, $spacesPerIndent);
		}

		return $resultString;
	}
}

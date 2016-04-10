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

class Directive extends Printable {

	/** @var string $name */
	protected $name;

	/** @var string $value */
	protected $value;

	/** @var Scope $childScope */
	protected $childScope = null;

	/** @var Scope $parentScope */
	protected $parentScope = null;

	/** @var Comment $comment */
	protected $comment = null;

	/**
	 * @param string  $name
	 * @param string  $value
	 * @param Scope   $childScope
	 * @param Scope   $parentScope
	 * @param Comment $comment
	 */
	public function __construct(
		$name,
		$value = null,
		Scope $childScope = null,
		Scope $parentScope = null,
		Comment $comment = null
	) {
		$this->name = $name;
		$this->value = $value;
		if (!is_null($childScope)) {
			$this->setChildScope($childScope);
		}
		if (!is_null($parentScope)) {
			$this->setParentScope($parentScope);
		}
		if (!is_null($comment)) {
			$this->setComment($comment);
		}
	}

	/**
	 * Provides fluid interface.
	 *
	 * @param         $name
	 * @param null    $value
	 * @param Scope   $childScope
	 * @param Scope   $parentScope
	 * @param Comment $comment
	 * @return Directive
	 */
	public static function create(
		$name,
		$value = null,
		Scope $childScope = null,
		Scope $parentScope = null,
		Comment $comment = null
	) {
		return new self($name, $value, $childScope, $parentScope, $comment);
	}

	/**
	 * @param \SYPanel\Ngnix\Text $configString
	 * @return self
	 * @throws Exception
	 */
	public static function fromString(Text $configString) {
		$text = '';
		while (false === $configString->eof()) {
			$char = $configString->getChar();
			if ('{' === $char) {
				return self::newDirectiveWithScope($text, $configString);
			}
			if (';' === $char) {
				return self::newDirectiveWithoutScope($text, $configString);
			}
			$text .= $char;
			$configString->inc();
		}
		throw new Exception('Could not create directive.');
	}

	/*
	 * ========== Factories ==========
	 */

	protected static function newDirectiveWithScope(
		$nameString,
		Text $scopeString
	) {
		$scopeString->inc();
		list($name, $value) = self::processText($nameString);
		$directive = new Directive($name, $value);

		$comment = self::checkRestOfTheLineForComment($scopeString);
		if (false !== $comment) {
			$directive->setComment($comment);
		}

		$childScope = Scope::fromString($scopeString);
		$childScope->setParentDirective($directive);
		$directive->setChildScope($childScope);

		$scopeString->inc();

		$comment = self::checkRestOfTheLineForComment($scopeString);
		if (false !== $comment) {
			$directive->setComment($comment);
		}

		return $directive;
	}

	protected static function processText($text) {
		$result = self::checkKeyValue($text);
		if (is_array($result)) {
			return $result;
		}
		$result = self::checkKey($text);
		if (is_array($result)) {
			return $result;
		}
		throw new Exception('Text "' . $text . '" did not match pattern.');
	}

	protected static function checkKeyValue($text) {
		if (1 === preg_match('#^([a-z][a-z0-9._/+-]*)\s+([^;{]+)$#', $text, $matches)) {
			return [$matches[1], rtrim($matches[2])];
		}

		return false;
	}

	protected static function checkKey($text) {
		if (1 === preg_match('#^([a-z][a-z0-9._/+-]*)\s*$#', $text, $matches)) {
			return [$matches[1], null];
		}

		return false;
	}

	protected static function checkRestOfTheLineForComment(Text $configString) {
		$restOfTheLine = $configString->getRestOfTheLine();
		if (1 !== preg_match('/^\s*#/', $restOfTheLine)) {
			return false;
		}

		$commentPosition = strpos($restOfTheLine, '#');
		$configString->inc($commentPosition);

		return Comment::fromString($configString);
	}

	protected static function newDirectiveWithoutScope(
		$nameString,
		Text $configString
	) {
		$configString->inc();
		list($name, $value) = self::processText($nameString);
		$directive = new Directive($name, $value);

		$comment = self::checkRestOfTheLineForComment($configString);
		if (false !== $comment) {
			$directive->setComment($comment);
		}

		return $directive;
	}

	/**
	 * @return string
	 */
	public function getValue() {
		return $this->value;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/*
	 * ========== Getters ==========
	 */

	/**
	 * Get parent Scope
	 *
	 * @return Scope|null
	 */
	public function getParentScope() {
		return $this->parentScope;
	}

	/**
	 * Sets the parent Scope for this Directive.
	 *
	 * @param Scope $parentScope
	 * @return $this
	 */
	public function setParentScope(Scope $parentScope) {
		$this->parentScope = $parentScope;

		return $this;
	}

	/**
	 * Set the comment text for this Directive.
	 *
	 * This will overwrite the existing comment.
	 *
	 * @param $text
	 * @return $this
	 */
	public function setCommentText($text) {
		$this->getComment()->setText($text);

		return $this;
	}

	/**
	 * Get the associated Comment for this Directive.
	 *
	 * @return Comment
	 */
	public function getComment() {
		if (is_null($this->comment)) {
			$this->comment = new Comment();
		}

		return $this->comment;
	}

	/*
	 * ========== Setters ==========
	 */

	/**
	 * Set the associated Comment object for this Directive.
	 *
	 * This will overwrite the existing comment.
	 *
	 * @param Comment $comment
	 * @return $this
	 */
	public function setComment(Comment $comment) {
		$this->comment = $comment;

		return $this;
	}

	/**
	 * Pretty print with indentation.
	 *
	 * @param     $indentLevel
	 * @param int $spacesPerIndent
	 * @return string
	 */
	public function prettyPrint($indentLevel, $spacesPerIndent = 4) {
		$indent = str_repeat(str_repeat(' ', $spacesPerIndent), $indentLevel);

		$resultString = $indent . $this->name;
		if (!is_null($this->value)) {
			$resultString .= " " . $this->value;
		}

		if (is_null($this->getChildScope())) {
			$resultString .= ";";
		} else {
			$resultString .= " {";
		}

		if (false === $this->hasComment()) {
			$resultString .= "\n";
		} else {
			if (false === $this->getComment()->isMultiline()) {
				$resultString .= " " . $this->comment->prettyPrint(0, 0);
			} else {
				$comment = $this->getComment()->prettyPrint($indentLevel, $spacesPerIndent);
				$resultString = $comment . $resultString;
			}
		}

		if (!is_null($this->getChildScope())) {
			$resultString .= "" . $this->childScope->prettyPrint($indentLevel, $spacesPerIndent) . $indent . "}\n";
		}

		return $resultString;
	}

	/**
	 * Get child Scope.
	 *
	 * @return Scope|null
	 */
	public function getChildScope() {
		return $this->childScope;
	}

	/**
	 * Sets the child Scope for this Directive.
	 *
	 * Sets the child Scope for this Directive and also
	 * sets the $childScope->setParentDirective($this).
	 *
	 * @param Scope $childScope
	 * @return $this
	 */
	public function setChildScope(Scope $childScope) {
		$this->childScope = $childScope;

		if ($childScope->getParentDirective() !== $this) {
			$childScope->setParentDirective($this);
		}

		return $this;
	}

	/*
	 * ========== Printing ==========
	 */

	/**
	 * Does this Directive have a Comment associated with it?
	 *
	 * @return bool
	 */
	public function hasComment() {
		return (!$this->getComment()->isEmpty());
	}
}

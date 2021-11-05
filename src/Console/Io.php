<?php

namespace Queue\Console;

use Cake\Console\CommandInterface;
use Cake\Console\ConsoleIo;
use Cake\Console\Exception\StopException;
use Cake\Console\Helper;

/**
 * Composition class as proxy towards ConsoleIO - basically a shell replacement for inside business logic.
 */
class Io {

	/**
	 * @var \Cake\Console\ConsoleIo
	 */
	protected $_io;

	/**
	 * @param \Cake\Console\ConsoleIo $io
	 */
	public function __construct(ConsoleIo $io) {
		$this->_io = $io;
	}

	/**
	 * Output at the verbose level.
	 *
	 * @param array|string $message A string or an array of strings to output
	 * @param int $newlines Number of newlines to append
	 * @return int|null The number of bytes returned from writing to stdout.
	 */
	public function verbose($message, $newlines = 1) {
		return $this->_io->verbose($message, $newlines);
	}

	/**
	 * Output at all levels.
	 *
	 * @param array|string $message A string or an array of strings to output
	 * @param int $newlines Number of newlines to append
	 * @return int|null The number of bytes returned from writing to stdout.
	 */
	public function quiet($message, $newlines = 1) {
		return $this->_io->quiet($message, $newlines);
	}

	/**
	 * Outputs a single or multiple messages to stdout. If no parameters
	 * are passed outputs just a newline.
	 *
	 * ### Output levels
	 *
	 * There are 3 built-in output level. ConsoleIo::QUIET, ConsoleIo::NORMAL, ConsoleIo::VERBOSE.
	 * The verbose and quiet output levels, map to the `verbose` and `quiet` output switches
	 * present in most shells. Using ConsoleIo::QUIET for a message means it will always display.
	 * While using ConsoleIo::VERBOSE means it will only display when verbose output is toggled.
	 *
	 * @link http://book.cakephp.org/3.0/en/console-and-shells.html#ConsoleIo::out
	 * @param array<string>|string $message A string or an array of strings to output
	 * @param int $newlines Number of newlines to append
	 * @param int $level The message's output level, see above.
	 * @return int|null The number of bytes returned from writing to stdout.
	 */
	public function out($message = '', $newlines = 1, $level = ConsoleIo::NORMAL) {
		return $this->_io->out($message, $newlines, $level);
	}

	/**
	 * Outputs a single or multiple error messages to stderr. If no parameters
	 * are passed outputs just a newline.
	 *
	 * @param array<string>|string $message A string or an array of strings to output
	 * @param int $newlines Number of newlines to append
	 * @return int|null The number of bytes returned from writing to stderr.
	 */
	public function err($message = '', $newlines = 1) {
		$messages = (array)$message;
		foreach ($messages as $key => $message) {
			$messages[$key] = '<error>' . $message . '</error>';
		}

		return $this->_io->err($messages, $newlines);
	}

	/**
	 * Convenience method for out() that wraps message between <info /> tag
	 *
	 * @see http://book.cakephp.org/3.0/en/console-and-shells.html#ConsoleIo::out
	 * @param array<string>|string $message A string or an array of strings to output
	 * @param int $newlines Number of newlines to append
	 * @param int $level The message's output level, see above.
	 * @return int|null The number of bytes returned from writing to stdout.
	 */
	public function info($message = '', $newlines = 1, $level = ConsoleIo::NORMAL) {
		$messages = (array)$message;
		foreach ($messages as $key => $message) {
			$messages[$key] = '<info>' . $message . '</info>';
		}

		return $this->out($messages, $newlines, $level);
	}

	/**
	 * Convenience method for out() that wraps message between <comment /> tag
	 *
	 * @see http://book.cakephp.org/3.0/en/console-and-shells.html#ConsoleIo::out
	 * @param array<string>|string $message A string or an array of strings to output
	 * @param int $newlines Number of newlines to append
	 * @param int $level The message's output level, see above.
	 * @return int|null The number of bytes returned from writing to stdout.
	 */
	public function comment($message = '', $newlines = 1, $level = ConsoleIo::NORMAL) {
		$messages = (array)$message;
		foreach ($messages as $key => $message) {
			$messages[$key] = '<comment>' . $message . '</comment>';
		}

		return $this->out($messages, $newlines, $level);
	}

	/**
	 * Convenience method for err() that wraps message between <warning /> tag
	 *
	 * @see http://book.cakephp.org/3.0/en/console-and-shells.html#ConsoleIo::err
	 * @param array<string>|string $message A string or an array of strings to output
	 * @param int $newlines Number of newlines to append
	 * @return int|null The number of bytes returned from writing to stderr.
	 */
	public function warn($message = '', $newlines = 1) {
		$messages = (array)$message;
		foreach ($messages as $key => $message) {
			$messages[$key] = '<warning>' . $message . '</warning>';
		}

		return $this->_io->err($messages, $newlines);
	}

	/**
	 * Convenience method for out() that wraps message between <success /> tag
	 *
	 * @see http://book.cakephp.org/3.0/en/console-and-shells.html#ConsoleIo::out
	 * @param array<string>|string $message A string or an array of strings to output
	 * @param int $newlines Number of newlines to append
	 * @param int $level The message's output level, see above.
	 * @return int|null The number of bytes returned from writing to stdout.
	 */
	public function success($message = '', $newlines = 1, $level = ConsoleIo::NORMAL) {
		$messages = (array)$message;
		foreach ($messages as $key => $message) {
			$messages[$key] = '<success>' . $message . '</success>';
		}

		return $this->out($messages, $newlines, $level);
	}

	/**
	 * Returns a single or multiple linefeeds sequences.
	 *
	 * @link http://book.cakephp.org/3.0/en/console-and-shells.html#ConsoleIo::nl
	 * @param int $multiplier Number of times the linefeed sequence should be repeated
	 * @return string
	 */
	public function nl($multiplier = 1) {
		return $this->_io->nl($multiplier);
	}

	/**
	 * Outputs a series of minus characters to the standard output, acts as a visual separator.
	 *
	 * @link http://book.cakephp.org/3.0/en/console-and-shells.html#ConsoleIo::hr
	 * @param int $newlines Number of newlines to pre- and append
	 * @param int $width Width of the line, defaults to 63
	 * @return void
	 */
	public function hr($newlines = 0, $width = 63) {
		$this->_io->hr($newlines, $width);
	}

	/**
	 * Displays a formatted error message
	 * and exits the application with status code 1
	 *
	 * @link http://book.cakephp.org/3.0/en/console-and-shells.html#styling-output
	 * @param string $message The error message
	 * @param int $exitCode The exit code for the shell task.
	 * @throws \Cake\Console\Exception\StopException
	 * @return void
	 */
	public function abort($message, $exitCode = CommandInterface::CODE_ERROR) {
		$this->_io->err('<error>' . $message . '</error>');

		throw new StopException($message, $exitCode);
	}

	/**
	 * Create and render the output for a helper object. If the helper
	 * object has not already been loaded, it will be loaded and constructed.
	 *
	 * @param string $name The name of the helper to render
	 * @param array $settings Configuration data for the helper.
	 * @return \Cake\Console\Helper The created helper instance.
	 */
	public function helper(string $name, array $settings = []): Helper {
		return $this->_io->helper($name, $settings);
	}

	/**
	 * Overwrite some already output text.
	 *
	 * Useful for building progress bars, or when you want to replace
	 * text already output to the screen with new text.
	 *
	 * **Warning** You cannot overwrite text that contains newlines.
	 *
	 * @param array|string $message The message to output.
	 * @param int $newlines Number of newlines to append.
	 * @param int|null $size The number of bytes to overwrite. Defaults to the
	 *    length of the last message output.
	 * @return void
	 */
	public function overwrite($message, int $newlines = 1, ?int $size = null): void {
		$this->_io->overwrite($message, $newlines, $size);
	}

}

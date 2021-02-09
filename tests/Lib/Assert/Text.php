<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Lib\Assert\Text;

class TextTest extends TestCase
{
	/** @var string */
	private const SAMPLE_EMAIL = 'test@test.cz';

	/** @var string */
	private const SAMPLE_NOT_EMAIL = 'test.cz';

	/** @var string */
	private const SAMPLE_TEXT = 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci possimus neque ad corporis itaque facere fugit veritatis porro eaque tempora officia ea libero, consectetur earum esse laboriosam modi doloremque. Nobis?';

	/**
	 * Test is successful if sample email is recognized as email
	 *
	 * @return void
	 */
	public function testIsEmail()
	{
		$this->assertTrue(Text::isEmail(self::SAMPLE_EMAIL));
	}

	/**
	 * Test is successful if sample non email is recognized as email
	 *
	 * @return void
	 */
	public function testIsNotEmail()
	{
		$this->assertFalse(Text::isEmail(self::SAMPLE_NOT_EMAIL));
	}

	/**
	 * Test is successful if sample text has less than 300 characters
	 *
	 * @return void
	 */
	public function testTextLengthIsLesThan()
	{
		$this->assertTrue(Text::hasMax(300, self::SAMPLE_TEXT));
	}

	/**
	 * Test is successful if sample text has more than 200 characters
	 *
	 * @return void
	 */
	public function testTextLengthIsNotLesThan()
	{
		$this->assertFalse(Text::hasMax(200, self::SAMPLE_TEXT));
	}


	/**
	 * Test is successful if sample text has more than 100 characters
	 *
	 * @return void
	 */
	public function testTextLengthIsMoreThan()
	{
		$this->assertTrue(Text::hasMin(100, self::SAMPLE_TEXT));
	}

	/**
	 * Test is sucessful if sample text has less than 400 characters
	 *
	 * @return void
	 */
	public function testTextLengthIsNotMoreThan()
	{
		$this->assertFalse(Text::hasMin(400, self::SAMPLE_TEXT));
	}
}

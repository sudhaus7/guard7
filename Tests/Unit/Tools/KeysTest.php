<?php


namespace Unit\Tools;

use Nimut\TestingFramework\TestCase\UnitTestCase;
use SUDHAUS7\Guard7\KeyNotReadableException;
use SUDHAUS7\Guard7\Tools\Keys;
use SUDHAUS7\Guard7\WrongKeyPassException;

class KeysTest extends UnitTestCase
{
    private $password = 'test123';
    
    /**
     * @test
     */
    public function canCreatePrivateKey()
    {
        $keypair = Keys::createKey();
        static::assertArrayHasKey('private', $keypair);
        static::assertNotFalse(strpos($keypair['private'], '-----BEGIN PRIVATE KEY-----'));
    }
    
    /**
     * @test
     */
    public function canCreatePublicKey()
    {
        $keypair = Keys::createKey();
        static::assertArrayHasKey('public', $keypair);
        static::assertNotFalse(strpos($keypair['public'], '-----BEGIN PUBLIC KEY-----'));
    }
    
    /**
     * @test
     */
    public function canCreateEncryptedPrivateKey()
    {
        $keypair = Keys::createKey($this->password);
        static::assertArrayHasKey('private', $keypair);
        static::assertNotFalse(strpos($keypair['private'], '-----BEGIN ENCRYPTED PRIVATE KEY-----'));
    }
    
    
    /**
     * @test
     */
    public function unlockKeyWithPasswordGetsKeyResourceFromEncryptedKey()
    {
        $keypair = Keys::createKey($this->password);
        $keyresource = Keys::unlockKey($keypair['private'], $this->password);
        static::assertTrue(is_resource($keyresource));
    }
    
    /**
     * @test
     */
    public function unlockKeyWithWrongPasswortThrowsException()
    {
        $this->expectException(WrongKeyPassException::class);
        $keypair = Keys::createKey($this->password);
        $keyresource = Keys::unlockKey($keypair['private'], 'wrongpassword');
    }
    
    /**
     * @test
     */
    public function unlockKeyWithInvalidPemKey()
    {
        $this->expectException(KeyNotReadableException::class);
        Keys::unlockKey('wrong key', null);
    }
    
    /**
     * @test
     */
    public function unlockKeyWithoutPasswordGetsKeyResourceFromUnencryptedKey()
    {
        $keypair = Keys::createKey();
        $keyresource = Keys::unlockKey($keypair['private'], null);
        static::assertTrue(\is_resource($keyresource));
    }
    
    /**
     * @test
     */
    public function unlockKeyToPemCreatesPEMFormatedPrivateKeyFromEncryptedPrivateKey()
    {
        $keypair = Keys::createKey($this->password);
        $privkey = Keys::unlockKeyToPem($keypair['private'], $this->password);
        static::assertNotFalse(strpos($privkey, '-----BEGIN PRIVATE KEY-----'));
    }
    
    /**
     * @test
     */
    public function lockPrivateKeyLocksAnUnencryptedKey()
    {
        $keypair = Keys::createKey();
        $keyresource = Keys::unlockKey($keypair['private'], null);
        $locked = Keys::lockPrivateKey($keyresource, $this->password);
        static::assertNotFalse(strpos($locked, '-----BEGIN ENCRYPTED PRIVATE KEY-----'));
    }
    
    /**
     * @test
     */
    public function checksumCreatesValidChecksumForPrivateKey()
    {
        $body = bin2hex(random_bytes(128));
        $checksum = sha1($body);
        $generatedChecksum = Keys::getChecksum('-----BEGIN PRIVATE KEY-----'."\n".wordwrap($body, 72, "\n", true)."\n-----END PRIVATE KEY-----\n");
        static::assertEquals($generatedChecksum, $checksum);
    }
    
    /**
     * @test
     */
    public function checksumCreatesValidChecksumForEncryptedPrivateKey()
    {
        $body = bin2hex(random_bytes(128));
        $checksum = sha1($body);
        $generatedChecksum = Keys::getChecksum('-----BEGIN ENCRYPTED PRIVATE KEY-----'."\n".wordwrap($body, 72, "\n", true)."\n-----END ENCRYPTED PRIVATE KEY-----\n");
        static::assertEquals($generatedChecksum, $checksum);
    }
    
    /**
     * @test
     */
    public function checksumCreatesValidChecksumForPublicKey()
    {
        $body = bin2hex(random_bytes(128));
        $checksum = sha1($body);
        $generatedChecksum = Keys::getChecksum('-----BEGIN PUBLIC KEY-----'."\n".wordwrap($body, 72, "\n", true)."\n-----END PUBLIC KEY-----\n");
        static::assertEquals($generatedChecksum, $checksum);
    }
}

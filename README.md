Guard7
(old name datavault)

A Typo3 (8) Plugin to facilitate asymetric RSA encryption with multiple public keys 

!!! work in progress !!!
work in progress !!!

Working:

Encryption / Decryption of arbitrary text-fields in tables
Public/Private Key management for FE Users
Backend: Decryption on Client, List module and TCA Fields. Rudimentary Support for Private Keys and Password encrypted Private Keys

Tools for generating keys, validating keys and encrtyption/decryption in PHP and JS for Plugins.

PageTS base confguration of to be encrypted database fields and tables.

PageTS based configuration for additional Public Keys (not sure if that is a good idea anymore)

Commandline locking and unlocking for all configured fields

Signal slot for collection of Public keys on encryption

TODO:
- Re-encoding of dirty datasets 
- documentation
- comments
- licenses
- Backport to 7.6
- Testing/proofing for 9.x


fberger@sudhaus7.de

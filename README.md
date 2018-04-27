Guard7
(old name datavault)

A Typo3 (8) Plugin to facilitate asymetric RSA encryption with multiple public keys 

!!! work in progress !!!
work in progress !!!

Working:

- Asymetric encryption / decryption of arbitrary text-fields in tables with several public keys.

- Public/Private Key management for FE Users

- Backend: Decryption on Client, List module and TCA Fields. 
- Rudimentary Support for Private Keys and Password encrypted Private Keys

- Tools for generating keys, validating keys and encrtyption/decryption in PHP and JS for Plugins.

- PageTS base confguration of to be encrypted database fields and tables.

- PageTS based configuration for additional Public Keys (not sure anymore if that is a good idea, input welcome )

- Commandline locking and unlocking for all configured fields

- Signal slot for collection of Public keys on encryption

TODO:
- Re-encoding of dirty datasets 
- documentation
- comments
- licenses
- Testing/proofing for 9.x


fberger@sudhaus7.de

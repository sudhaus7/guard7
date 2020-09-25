.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt

.. _about:

What does it do?
================
This extension implements a cryptographical system based on OpenSSL to

- create and validate private and public keys
- manage public keys inside the TYPO3 CMS
- configure fields in database tables to be encrypted
- tools to encrypt and decrypt arbitrary data
- support for automatic encryption for extbase models
- key management for frontend users
- client side decryption of data in the backend

A typical usecase could be that a frontend users data is encrypted with the frontend users public key, and one or more administrators public keys. A frontend users private key will be unlocked when the user logs in, in order for the user to be able to view and edit their data. An administrator can as well unlock the users data in the TYPO3 Backend by giving their private key temporarily. Otherwise the Data will be stored inaccessible in the database.

Another typical use case could be the storage of booking or order data in the database, which is encrypted with the administrators public keys and can only be read through providing a private key.

For a would be hacker or leaked backups of the database the encrypted texts would be useless to extract data.

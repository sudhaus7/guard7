CREATE TABLE tx_sudhaus7datavault_data (
  uid int(11) NOT NULL auto_increment,
  pid int(11) NOT NULL DEFAULT '0',

  tablename varchar(64) NOT NULL DEFAULT '',
  tableuid  int(11) NOT NULL DEFAULT '0',
  fieldname varchar(64) NOT NULL DEFAULT '',
  secretdata LONGTEXT,

  PRIMARY KEY (uid),
  UNIQUE idxmain (tablename,tableuid,fieldname)
);

CREATE TABLE tx_sudhaus7datavault_signatures (
  uid int(11) NOT NULL auto_increment,
  pid int(11) NOT NULL DEFAULT '0',
  parent int(11) NOT NULL DEFAULT '0',
  signature char(32) NOT NULL DEFAULT '',
  PRIMARY KEY (uid),
  INDEX idxparent(parent),
  INDEX idxsignature(signature)
);


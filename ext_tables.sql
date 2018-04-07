CREATE TABLE tx_guard7_domain_model_data (
  uid int(11) NOT NULL auto_increment,
  pid int(11) NOT NULL DEFAULT '0',
  tstamp int(11) NOT NULL DEFAULT '0',


  tablename varchar(64) NOT NULL DEFAULT '',
  tableuid  int(11) NOT NULL DEFAULT '0',
  fieldname varchar(64) NOT NULL DEFAULT '',
  secretdata LONGTEXT,
  needsreencode int(3) NOT NULL DEFAULT '0',

  PRIMARY KEY (uid),
  UNIQUE idxmain (tablename,tableuid,fieldname)
);

CREATE TABLE tx_guard7_signatures (
  uid int(11) NOT NULL auto_increment,
  pid int(11) NOT NULL DEFAULT '0',
  parent int(11) NOT NULL DEFAULT '0',
  signature char(32) NOT NULL DEFAULT '',
  PRIMARY KEY (uid),
  INDEX idxparent(parent),
  INDEX idxsignature(signature)
);


CREATE TABLE fe_users (
  tx_guard7_publickey  TEXT,
  tx_guard7_privatekey TEXT
);


CREATE TABLE tx_workshopblog_domain_model_blog (
    uid int(11) NOT NULL auto_increment,
    pid int(11) NOT NULL DEFAULT '0',
    tstamp int(11) unsigned NOT NULL DEFAULT '0',
    crdate int(11) unsigned NOT NULL DEFAULT '0',
    cruser_id int(11) unsigned NOT NULL DEFAULT '0',
    deleted tinyint(4) unsigned NOT NULL DEFAULT '0',
    hidden tinyint(4) unsigned NOT NULL DEFAULT '0',
  title varchar(255) DEFAULT '' NOT NULL,
  date int(11) DEFAULT '0' NOT NULL,
  teaser text,
  bodytext text,
    PRIMARY KEY (uid),
    KEY parent (pid)
);

create table tx_workshopblog_domain_model_comment (
      uid int(11) NOT NULL auto_increment,
      pid int(11) NOT NULL DEFAULT '0',
      tstamp int(11) unsigned NOT NULL DEFAULT '0',
      crdate int(11) unsigned NOT NULL DEFAULT '0',
      cruser_id int(11) unsigned NOT NULL DEFAULT '0',
      deleted tinyint(4) unsigned NOT NULL DEFAULT '0',
      hidden tinyint(4) unsigned NOT NULL DEFAULT '0',
    commentor varchar(255) DEFAULT '' NOT NULL,
    comment text,
    date int(11) DEFAULT '0' NOT NULL,
    blog int(11) DEFAULT '0' NOT NULL,
      PRIMARY KEY (uid),
      KEY parent (pid)
);

delimiter $$

CREATE TABLE `mpadmin` (
  `idmpadmin` int(12) NOT NULL AUTO_INCREMENT,
  `mpadmin` varchar(45) NOT NULL,
  `mppassword` text NOT NULL,
  `mpemail` varchar(45) NOT NULL,
  `mprank` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`idmpadmin`),
  UNIQUE KEY `idmpadmin_UNIQUE` (`idmpadmin`),
  UNIQUE KEY `mpadmin_UNIQUE` (`mpadmin`),
  UNIQUE KEY `mpemail_UNIQUE` (`mpemail`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Administrators'$$


delimiter $$

CREATE TABLE `mpfeedback` (
  `idmpfeedback` int(12) NOT NULL AUTO_INCREMENT,
  `idmpuser` int(12) NOT NULL,
  `mpfeedback` text NOT NULL,
  `mpanswer` text,
  `mpstatus` tinyint(4) NOT NULL,
  PRIMARY KEY (`idmpfeedback`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Support / Feedback'$$


delimiter $$

CREATE TABLE `mpnewsletter` (
  `idmpnewsletter` int(12) NOT NULL AUTO_INCREMENT,
  `mpcontent` text NOT NULL,
  `mpdate` date NOT NULL,
  PRIMARY KEY (`idmpnewsletter`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Newsletter table'$$


delimiter $$

CREATE TABLE `mpsecurityquestion` (
  `idmpsecurity` int(12) NOT NULL AUTO_INCREMENT,
  `idmpuser` int(12) NOT NULL,
  `mpquestion` text NOT NULL,
  `mpanswer` text NOT NULL,
  PRIMARY KEY (`idmpsecurity`),
  UNIQUE KEY `mpidsecurity_UNIQUE` (`idmpsecurity`),
  UNIQUE KEY `idmpuser_UNIQUE` (`idmpuser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Security question and answer for user, in case of forgetting'$$


delimiter $$

CREATE TABLE `mpsubscription` (
  `idmpsubscription` int(12) NOT NULL AUTO_INCREMENT,
  `idmpuser` int(12) NOT NULL,
  PRIMARY KEY (`idmpsubscription`),
  UNIQUE KEY `idmpuser_UNIQUE` (`idmpuser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Users that have subscribed to the newsletter'$$


delimiter $$

CREATE TABLE `mpuser` (
  `idmpuser` int(12) NOT NULL AUTO_INCREMENT,
  `mpusername` varchar(20) NOT NULL,
  `mpfirstname` varchar(20) NOT NULL,
  `mplastname` varchar(20) NOT NULL,
  `mpuserpwd` varchar(20) NOT NULL,
  `mpuseremail` varchar(45) NOT NULL,
  `mpbirthdate` date NOT NULL,
  `mpcountry` varchar(30) NOT NULL,
  `mpcity` varchar(30) NOT NULL,
  `mpsecurityq` varchar(45) NOT NULL,
  `mpsecuritya` varchar(45) NOT NULL,
  `mpsubscribe` int(1) NOT NULL,
  PRIMARY KEY (`idmpuser`),
  UNIQUE KEY `idmpuser` (`idmpuser`),
  UNIQUE KEY `mpusername` (`mpusername`),
  UNIQUE KEY `mpuseremail` (`mpuseremail`)
) ENGINE=MyISAM AUTO_INCREMENT=4080 DEFAULT CHARSET=utf8$$


delimiter $$

CREATE TABLE `mpuserbanking` (
  `idmpuserbanking` int(12) NOT NULL AUTO_INCREMENT,
  `idmpuser` int(12) NOT NULL,
  `mpusername` text NOT NULL,
  PRIMARY KEY (`idmpuserbanking`),
  UNIQUE KEY `idmpuserbanking_UNIQUE` (`idmpuserbanking`),
  UNIQUE KEY `idmpuser_UNIQUE` (`idmpuser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='User payment usernames (paypal)'$$


delimiter $$

CREATE TABLE `mpusernumbers` (
  `idmpusernumbers` int(12) NOT NULL AUTO_INCREMENT,
  `idmpuser` int(12) NOT NULL,
  `mpdate` date NOT NULL,
  `mpnrcount` tinyint(2) NOT NULL,
  `mpnumbers` text NOT NULL,
  PRIMARY KEY (`idmpusernumbers`),
  UNIQUE KEY `idmpusernumbers_UNIQUE` (`idmpusernumbers`),
  UNIQUE KEY `idmpuser_UNIQUE` (`idmpuser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Selected user number combinations'$$


delimiter $$

CREATE TABLE `mpwinners` (
  `idmpwinners` int(12) NOT NULL AUTO_INCREMENT,
  `idmpuser` int(12) NOT NULL,
  `mpcategory` tinyint(4) NOT NULL,
  `mpprize` int(12) NOT NULL,
  `mpdate` date NOT NULL,
  PRIMARY KEY (`idmpwinners`),
  UNIQUE KEY `idmpwinners_UNIQUE` (`idmpwinners`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Winners'$$


delimiter $$

CREATE TABLE `mpwinningnumbers` (
  `idmpwinningnumbers` int(12) NOT NULL AUTO_INCREMENT,
  `mpwinningnumbers` text NOT NULL,
  `mpdate` date NOT NULL,
  PRIMARY KEY (`idmpwinningnumbers`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Winning numbers'$$



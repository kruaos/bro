-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Feb 14, 2021 at 10:01 PM
-- Server version: 5.0.51
-- PHP Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Database: `finance`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `account`
-- 

CREATE TABLE `account` (
  `AccountNo` varchar(20) NOT NULL default '',
  `AccountName` varchar(50) default NULL,
  `Bank` varchar(50) default NULL,
  `Branch` varchar(50) default NULL,
  `Balance` float(9,2) NOT NULL default '0.00',
  `CreateDate` date default NULL,
  `LastUpdate` date default NULL,
  `Status` varchar(10) default NULL,
  PRIMARY KEY  (`AccountNo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `accountbook`
-- 

CREATE TABLE `accountbook` (
  `IDAccBook` int(10) NOT NULL auto_increment,
  `DateDoc` date default NULL,
  `Detail` varchar(255) NOT NULL default '',
  `Income` float(9,2) default NULL,
  `Expenses` float(9,2) default NULL,
  `Comment` varchar(128) default NULL,
  `CreateDate` date default NULL,
  `LastUpdate` date default NULL,
  `Username` varchar(10) NOT NULL default '',
  PRIMARY KEY  (`IDAccBook`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `bankbalance`
-- 

CREATE TABLE `bankbalance` (
  `bankid` text character set utf8 collate utf8_unicode_ci NOT NULL,
  `bookbalance` float(10,2) NOT NULL,
  `lastupdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Table structure for table `bankevent`
-- 

CREATE TABLE `bankevent` (
  `num` int(6) NOT NULL auto_increment,
  `bankid` char(10) collate utf8_unicode_ci default NULL,
  `workno` char(4) collate utf8_unicode_ci default NULL,
  `income` float(10,2) default NULL,
  `code` varchar(2) collate utf8_unicode_ci default NULL,
  `createdate` datetime default NULL,
  `deptime` char(8) collate utf8_unicode_ci NOT NULL,
  `time` char(20) collate utf8_unicode_ci NOT NULL,
  `bank_event_status` int(1) NOT NULL,
  `bank_event_lastupdate` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`num`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4020 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `bankmember`
-- 

CREATE TABLE `bankmember` (
  `bankno` int(4) NOT NULL auto_increment,
  `bankid` varchar(10) collate utf8_unicode_ci NOT NULL,
  `pname` varchar(10) collate utf8_unicode_ci default NULL,
  `fname` varchar(50) collate utf8_unicode_ci default NULL,
  `lname` varchar(50) collate utf8_unicode_ci default NULL,
  `idcard` varchar(13) collate utf8_unicode_ci default NULL,
  `address` varchar(50) collate utf8_unicode_ci default NULL,
  `telephone` varchar(10) collate utf8_unicode_ci default NULL,
  `birthday` date default NULL,
  `bankstatus` char(2) collate utf8_unicode_ci default NULL,
  `workno` int(4) default NULL,
  `createdate` datetime default NULL,
  `lastupdate` datetime default NULL,
  `bankname` text collate utf8_unicode_ci,
  `bookbalance` float default NULL,
  PRIMARY KEY  (`bankno`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=451 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `copy of deposit`
-- 

CREATE TABLE `copy of deposit` (
  `IDDeposit` int(9) NOT NULL auto_increment,
  `IDRegFund` varchar(10) NOT NULL default '',
  `Username` varchar(10) NOT NULL default '',
  `CreateDate` date default NULL,
  `LastUpdate` date default NULL,
  `Amount` float(9,2) NOT NULL default '0.00',
  `Receive` varchar(18) NOT NULL default 'I',
  `DepositStatus` char(1) NOT NULL default 'P',
  PRIMARY KEY  (`IDDeposit`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=47639 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `deposit`
-- 

CREATE TABLE `deposit` (
  `IDDeposit` int(9) NOT NULL auto_increment,
  `IDRegFund` varchar(10) NOT NULL default '',
  `Username` varchar(10) NOT NULL default '',
  `CreateDate` date default NULL,
  `LastUpdate` date default NULL,
  `Amount` float(9,2) NOT NULL default '0.00',
  `Receive` varchar(18) NOT NULL default 'I',
  `DepositStatus` char(1) NOT NULL default 'P',
  PRIMARY KEY  (`IDDeposit`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=383579 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `depositless`
-- 

CREATE TABLE `depositless` (
  `IDDeposit` int(9) NOT NULL auto_increment,
  `IDRegFund` varchar(10) default NULL,
  `Username` varchar(10) default NULL,
  `LessDate` date default NULL,
  `Firstname` varchar(50) default NULL,
  `Lastname` varchar(50) default NULL,
  `FundType` varchar(128) default NULL,
  `Title` varchar(10) default NULL,
  `IDMember` varchar(81) default NULL,
  PRIMARY KEY  (`IDDeposit`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24680 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `depositstatement`
-- 

CREATE TABLE `depositstatement` (
  `IDMember` tinyint(8) NOT NULL default '0',
  `AmountSave` tinyint(6) default NULL,
  `AmountFriend` tinyint(6) default NULL,
  PRIMARY KEY  (`IDMember`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `deposit_n`
-- 

CREATE TABLE `deposit_n` (
  `IDDeposit` int(9) NOT NULL auto_increment,
  `IDMember` varchar(10) NOT NULL default '',
  `Username` varchar(10) NOT NULL default '',
  `CreateDate` date default NULL,
  `LastUpdate` date default NULL,
  `Amount_FixDep` float(9,2) NOT NULL default '0.00',
  `Amount_Insura` float(9,2) NOT NULL default '0.00',
  `Receive` varchar(18) NOT NULL default 'I',
  `DepositStatus` char(1) NOT NULL default 'P',
  `IDDeposit_FixDep` varchar(10) default '',
  `IDDeposit_Insura` varchar(10) default '',
  `IDRegFund_FixDep` varchar(10) default '',
  `IDRegFund_Insura` varchar(10) default '',
  `DepositPage` int(11) NOT NULL,
  PRIMARY KEY  (`IDDeposit`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4290 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `employee`
-- 

CREATE TABLE `employee` (
  `Username` varchar(10) NOT NULL default '',
  `Firstname` varchar(50) NOT NULL default '',
  `Lastname` varchar(50) NOT NULL default '',
  `EmpPassword` varchar(10) NOT NULL default '',
  `UserLevel` varchar(50) NOT NULL default '',
  `CreateDate` date default NULL,
  `LastUpdate` date default NULL,
  `Status` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`Username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `fundtype`
-- 

CREATE TABLE `fundtype` (
  `IDFund` int(4) NOT NULL auto_increment,
  `Description` varchar(128) NOT NULL default '',
  `CreateDate` date default NULL,
  `LastUpdate` date default NULL,
  `Amount` float(9,2) default NULL,
  PRIMARY KEY  (`IDFund`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `header`
-- 

CREATE TABLE `header` (
  `HeadReport` varchar(250) NOT NULL default ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `interest`
-- 

CREATE TABLE `interest` (
  `IDInterest` int(11) NOT NULL auto_increment,
  `Description` varchar(50) NOT NULL default '',
  `PercentInterest` float(3,2) NOT NULL default '0.00',
  `CreateDate` date default NULL,
  `LastUpdate` date default NULL,
  PRIMARY KEY  (`IDInterest`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `loanbook`
-- 

CREATE TABLE `loanbook` (
  `RefNo` varchar(10) NOT NULL default '0',
  `Username` varchar(10) NOT NULL default '',
  `Insurer1` varchar(10) default NULL,
  `Insurer2` varchar(10) default NULL,
  `InterestRate` float(9,2) NOT NULL default '0.00',
  `Instalment` tinyint(4) NOT NULL default '0',
  `Amount` float(9,2) NOT NULL default '0.00',
  `LoanStatus` varchar(10) NOT NULL default '',
  `CreateDate` date default NULL,
  `LastUpdate` date default NULL,
  `IDMember` varchar(10) NOT NULL default '',
  `IDReason` int(10) NOT NULL default '0',
  `DateDoc` date default NULL,
  `PayStatus` tinyint(1) default NULL,
  `LimitDate` date default NULL,
  `Guaranty` varchar(128) default NULL,
  PRIMARY KEY  (`RefNo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `loanpayment`
-- 

CREATE TABLE `loanpayment` (
  `IDLoanPay` int(11) NOT NULL auto_increment,
  `RefNo` varchar(10) NOT NULL default '',
  `Username` varchar(10) NOT NULL default '',
  `InstalmentNo` tinyint(4) default NULL,
  `Interest` double(15,2) default NULL,
  `Payment` float(9,2) default NULL,
  `PayTotal` double(15,2) default NULL,
  `PayInterest` double(9,2) default NULL,
  `InterestOutst` float(9,2) default NULL,
  `CreateDate` date default NULL,
  `LastUpdate` date default NULL,
  `ReceiveStatus` char(1) default NULL,
  PRIMARY KEY  (`IDLoanPay`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=43649 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `loanpaymentlastdate`
-- 

CREATE TABLE `loanpaymentlastdate` (
  `LoanPaymentLastDateID` int(6) NOT NULL auto_increment,
  `IDMember` int(6) NOT NULL,
  `RefNo` int(6) NOT NULL,
  `LastDate` date NOT NULL,
  `IDLoanPay` int(6) NOT NULL,
  PRIMARY KEY  (`LoanPaymentLastDateID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=719 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `loanpaymentless`
-- 

CREATE TABLE `loanpaymentless` (
  `IDLoanLess` int(9) NOT NULL auto_increment,
  `IDMember` varchar(10) default NULL,
  `Firstname` varchar(50) default NULL,
  `Lastname` varchar(50) default NULL,
  `LessDate` date default NULL,
  `Username` varchar(10) default NULL,
  `Title` varchar(10) default NULL,
  PRIMARY KEY  (`IDLoanLess`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6032 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `loantransaction`
-- 

CREATE TABLE `loantransaction` (
  `IDLoanTran` int(10) NOT NULL auto_increment,
  PRIMARY KEY  (`IDLoanTran`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `loanview`
-- 

CREATE TABLE `loanview` (
  `IDLoanView` int(11) NOT NULL auto_increment,
  `Instalment` tinyint(3) NOT NULL default '0',
  `PaymentRate` float(9,2) NOT NULL default '0.00',
  `Interest` float(9,2) NOT NULL default '0.00',
  `Payment` float(9,2) NOT NULL default '0.00',
  `Username` varchar(10) NOT NULL default '',
  `CreateDate` date default NULL,
  `LastUpdate` date default NULL,
  `PaymentAVG` float(9,2) default NULL,
  `Total` float(9,2) default NULL,
  PRIMARY KEY  (`IDLoanView`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=70963 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `loan_order`
-- 

CREATE TABLE `loan_order` (
  `loan_order_id` int(4) NOT NULL auto_increment,
  `loan_order_number` int(4) NOT NULL,
  `loan_order_debtor_member_id` int(4) NOT NULL,
  `loan_order_depter_fullname` varchar(100) NOT NULL,
  `loan_order_warrantor1_member_id` int(4) NOT NULL,
  `loan_order_warrantor1_fullname` varchar(100) NOT NULL,
  `loan_order_warrantor2_member_id` int(4) NOT NULL,
  `loan_order_warrantor2_fullname` varchar(100) NOT NULL,
  `loan_order_guaranty1` varchar(100) NOT NULL,
  `loan_order_guaranty1_name` varchar(200) NOT NULL,
  `loan_order_guaranty2` varchar(100) NOT NULL,
  `loan_order_guaranty2_name` varchar(200) NOT NULL,
  `loan_order_amount` int(10) NOT NULL,
  `loan_order_time_month` int(4) NOT NULL,
  `loan_order_start_debtor` date NOT NULL,
  `loan_order_stop_debtor` date NOT NULL,
  `loan_order_principle` int(10) NOT NULL,
  `loan_order_princitple_for_pay` int(10) NOT NULL,
  `loan_order_interest` int(10) NOT NULL,
  `loan_order_pay_amount` int(10) NOT NULL,
  `loan_order_status` int(2) NOT NULL,
  `loan_order_type` int(2) NOT NULL,
  `loan_order_createdate` datetime NOT NULL,
  `loan_order_lastupdate` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`loan_order_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2887 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `logloanbook`
-- 

CREATE TABLE `logloanbook` (
  `IDLogLoanBook` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`IDLogLoanBook`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `logloanpayment`
-- 

CREATE TABLE `logloanpayment` (
  `IDLogLoanPayment` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`IDLogLoanPayment`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `member`
-- 

CREATE TABLE `member` (
  `IDMember` varchar(10) NOT NULL default '',
  `Title` varchar(10) default NULL,
  `Firstname` varchar(50) NOT NULL default '',
  `Lastname` varchar(50) NOT NULL default '',
  `AddressNum` varchar(50) default NULL,
  `AddressGroup` varchar(50) default NULL,
  `Tambol` varchar(50) default NULL,
  `Amphur` varchar(50) default NULL,
  `Province` varchar(50) default NULL,
  `Birthday` date default NULL,
  `ExpireDate` date default NULL,
  `MemberStatus` varchar(128) default '0',
  `Comment` varchar(128) default NULL,
  `CreateDate` date default NULL,
  `LastUpdate` date default NULL,
  `IDCard` varchar(20) default NULL,
  `DateResign` date default NULL,
  PRIMARY KEY  (`IDMember`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `paymentfriendfund`
-- 

CREATE TABLE `paymentfriendfund` (
  `IDFriendFund` int(9) NOT NULL auto_increment,
  `IDMember` varchar(10) default NULL,
  `IDRegFund` varchar(10) default NULL,
  `Username` varchar(10) default NULL,
  `Amount` float(9,2) default NULL,
  `CreateDate` date default NULL,
  `LastUpdate` date default NULL,
  PRIMARY KEY  (`IDFriendFund`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `prim_key`
-- 

CREATE TABLE `prim_key` (
  `NameTable` varchar(50) NOT NULL default '',
  `NameKey` varchar(50) NOT NULL default '',
  `LastKey` varchar(10) NOT NULL default '',
  PRIMARY KEY  (`NameTable`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `reason`
-- 

CREATE TABLE `reason` (
  `IDReason` int(10) NOT NULL auto_increment,
  `DetailReason` varchar(128) NOT NULL default '',
  `CreateDate` date default NULL,
  `LastUpdate` date default NULL,
  PRIMARY KEY  (`IDReason`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `regfund`
-- 

CREATE TABLE `regfund` (
  `IDRegFund` varchar(10) NOT NULL default '0',
  `IDFund` int(10) NOT NULL default '0',
  `IDMember` varchar(10) NOT NULL default '',
  `Closedate` date default NULL,
  `CreateDate` date default NULL,
  `LastUpdate` date default NULL,
  `Balance` float(9,2) NOT NULL default '0.00',
  PRIMARY KEY  (`IDRegFund`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `tempfriendtype`
-- 

CREATE TABLE `tempfriendtype` (
  `IDMember` varchar(10) NOT NULL default '',
  `Title` varchar(10) default NULL,
  `Firstname` varchar(50) default NULL,
  `Lastname` varchar(50) default NULL,
  `Destcription` varchar(128) default NULL,
  `Amount` float(9,2) default NULL,
  PRIMARY KEY  (`IDMember`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `tempsavetype`
-- 

CREATE TABLE `tempsavetype` (
  `IDMember` varchar(10) NOT NULL default '',
  `Title` varchar(10) default NULL,
  `Firstname` varchar(50) default NULL,
  `Lastname` varchar(50) default NULL,
  `Destcription` varchar(128) default NULL,
  `Amount` float(9,2) default NULL,
  PRIMARY KEY  (`IDMember`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- SQL Migration
-- RESOURCES TABLE
RENAME TABLE `documents` to `resources`;
RENAME TABLE `document_categories` to `resources_categories`;
ALTER TABLE `resources` CHANGE `on_home` `is_global` BOOLEAN;
ALTER TABLE `resources` CHANGE `document_path` `path` TEXT;
ALTER TABLE `resources` ADD `is_link` BOOLEAN NOT NULL DEFAULT 0;
ALTER TABLE `resources` ADD `is_featured` BOOLEAN NOT NULL DEFAULT 0;
ALTER TABLE `resources` ADD `date_added` DATE NOT NULL;
ALTER TABLE `resources_categories` ADD `url_friendly` TEXT NOT NULL;
ALTER TABLE `resources_categories` ADD `order` int(5) NOT NULL DEFAULT 0;
-- DEPRECATED TABLES
DROP TABLE `projects`;
DROP TABLE `project_galleries`;
DROP TABLE `content_pages`;
DROP TABLE `gallery`;
-- CONTENT TABLE
ALTER TABLE `content` CHANGE `data` `data` VARCHAR(1500) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;
UPDATE `content` SET `data` = `text` WHERE `text` <> '';
UPDATE `content` SET `data` = `image_path` WHERE `image_path` <> '';
ALTER TABLE `content` DROP `image_path`;
ALTER TABLE `content` DROP `text`;
ALTER TABLE `content` DROP `page_id`;
DELETE FROM `content` WHERE `key_name` IN ('list_directors', 'list_staff', 'list_consultants');
-- CALENDAR TABLE
ALTER TABLE `calendar` DROP `recurring`;
-- NEW TABLES
CREATE TABLE `resources_meetings` (
	`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, 
	`calendar_id` INT(11) UNSIGNED NOT NULL,
	`agenda_path` TEXT(250),
	`minutes_path` TEXT(250), 
	PRIMARY KEY (`id`),
	FOREIGN KEY (calendar_id) REFERENCES calendar(id) ON DELETE CASCADE
);
CREATE TABLE `list_board_members` (
	`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, 
	`name` TEXT(250) NOT NULL,
	`title` TEXT(250) NOT NULL,
	`bio` TEXT(1250), 
	`order` INT(5) DEFAULT 0, 
	PRIMARY KEY (`id`)
);
CREATE TABLE `list_staff` (
	`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, 
	`name` TEXT(250) NOT NULL,
	`title` TEXT(1250), 
	`order` INT(5) DEFAULT 0, 
	PRIMARY KEY (`id`)
);
CREATE TABLE `notices` (
	`id` INT(11) unsigned NOT NULL AUTO_INCREMENT,
	`type_id` INT(11) unsigned NOT NULL,
	`order` INT(5) DEFAULT 0,
	`add_date` date NOT NULL,
	`notice_date` date NOT NULL,
	`heading_text` TEXT(250),
	`body_text` TEXT(1000),
	`resource_id` INT(11) unsigned DEFAULT NULL,
	PRIMARY KEY(`id`)
);
CREATE TABLE `notices_types` (
	`id` INT(11) unsigned NOT NULL AUTO_INCREMENT,
	`type_name` TEXT(50) NOT NULL,
	`friendly_name` TEXT(50) NOT NULL,
	`order` INT(5) DEFAULT 0,
	PRIMARY KEY(`id`)
);
-- ALTERATIONS AND FOREIGN KEYS
ALTER TABLE `notices` ADD FOREIGN KEY (`type_id`) REFERENCES `notices_types`(`id`) ON DELETE CASCADE;
ALTER TABLE `notices` ADD FOREIGN KEY (`resource_id`) REFERENCES `resources`(`id`) ON DELETE CASCADE;
-- INSERTIONS
INSERT INTO `list_board_members`
(`id`, `name`, `title`, `bio`, `order`) 
VALUES
(1, 'John Delehant', 'President', 'John was elected to the board of Directors in 2011. Prior to his retirement John worked as a Civil Litigation Specialist from 1972 to 2008. He ran a practice with 130 +/- employees representing individuals, professionals, associations, corporations and public/governmental entities. In addition to his vast knowledge and legal expertise, John offers a unique diplomatic perspective when considering the issues facing SMMWC.', 1),
(2, 'Ben Banks', 'Vice-President', 'Ben originally served on the board from 2001 to 2004. He was re-elected to the Board in 2010. He has been working for Wyndham Resorts for the past 33 years, and is the General Manager of the San Luis Bay Inn Timeshares. Ben’s contribution to the Board is his practical knowledge gained from his 28 years of experience as a General Manager running timeshares associations, hotels and numerous other recreational operations.', 2),
(3, 'Gerri Hall', 'Secretary', 'Gerri was elected to the Board of Directors in 2006. She also serves as a board member for the San Luis Bay Estates Master Association as well as the Pelican Point Home Owners Association. Gerri has been a resident of San Luis Bay Estates for 30 years. She contributes great historical knowledge of this area. Her active engagement in the community allows her to share the many opinions found within San Luis Bay Estates.', 3),
(4, 'Tom Athey', 'Financial Officer', 'Tom has been on the BOD since 2001. As a Professor Emeritus for the College of Business, Cal Poly Pomona he has taught courses in Strategic Thinking, Executive Information Systems, Project Management, and System Development. In addition to teaching, Tom has 20 years of experience as a management consultant to senior executives in business, government, and education. Tom uses his B.S. in Physics, M.S. in Applied Math, and a PhD in Business Finance to keep the short term and long term challenges of SMMWC financially secure.', 4),
(5, 'Rick Koon', 'Director/General Manager', 'Rick was elected to the Board in 1999. He has previously been the Utility Manager for SMMWC and is now the General Manager of San Miguelito Mutual Water Company. He is also the General Manager of the Cayucos Sanitary District. Rick draws from his background in land surveying, civil engineering, administrative and construction management to direct SMMWC daily. His knowledge of all things operational and regulatory is an asset to the Board', 5),
(6, 'Rob Rossi', 'Director', 'Rob has been on the Board since 1989. He is a Licensed Architect, Developer and Vintner. He serves on numerous Boards, from banking to charitable organizations. Rob’s involvement in the development of various subdivisions, resorts, vineyards and his overall knowledge of the Avila area, contributes an understanding of the wide range of challenges facing SMMWC.', 6),
(7, 'Vic Montgomery', 'Director', 'Vic has been on the BOD since 2009. He is a Principal at RRM Design Group, a Licensed Architect since 1980, and has been an employee at RRM for 39 years. Vic has 30 years of experience as President, CEO and Chairman of the Board at RRM Design Group. Vic’s knowledge of Community Planning Design helps provide direction for the future of SMMWC.', 7);
INSERT INTO `list_staff`
(`id`, `name`, `title`, `order`) 
VALUES
(1, 'Dawn Barlow', 'Customer Service & Operations Support', 1),
(2, 'Michelle Edson', 'Accounting & Administrative Support', 2),
(3, 'Dan Migliazzo', 'Utility Manager', 3),
(4, 'Chris Mitchell', 'System Operator II', 4),
(5, 'Ray Barlow', 'System Operator I', 5);
INSERT INTO `faq`
(`id`, `question`, `answer`, `order`)
VALUES
(1, 'Where is your office located? What hours are you open?', 'Our office is at 1561 Sparrow Street (behind Cal-Fire Station 62). Our office hours are Monday through Friday 9:00 a.m. to 4:30 p.m.', 1),
(2, 'Can I request my water bill for a specific date or cycle? How often is my meter read?', 'No. The Company reads all water meters once a month, which usually takes place during the last 3 days of the month.', 2),
(3, 'Explain my billing cycle.', 'Your bill is for one month, mailed on the 1st of the month. SMMWC is not responsible for bills lost in the mail or not delivered. If you do not receive your bill by the 10th of the month, please call our office, (805)595-2348.', 3),
(4, 'When is my bill due?', 'Payment is due on or before the 28th of each month. Should the 28th fall on a weekend, payment is due by 8:00 a.m. the following Monday. An account is considered past due on the 29th. Please note that payments received in the mail on the business day following the due date are not considered on time, post marks and the date on the check are not taken into consideration.', 4),
(5, 'How do I pay my bill?', 'The following payment methods are available:<br /><b>Mail</b> your payment to: San Miguelito Mutual Water Company, P.O. Box 2120, Avila Beach, CA 93424-2120<br /><br />Deposit payment in the <b>Drop Box</b> located by the P.O. Box station on Lupine Canyon Road.<br /><br /><b>Pay in person –</b> Check and exact cash payments are accepted in the San Miguelito Mutual Water Company office located at 1561 Sparrow Street (behind Cal-Fire), San Luis Obispo, CA 93405. For after-hours payment, please use the payment slot by the front entrance.<br /><br /><b>Automatic Payment Service (Auto-Debit) -</b> Utility bill is paid automatically from your checking account on the 15th of the month. Please call (805) 595-2348 to receive an application to sign up for San Miguelito Mutual Water Company Automatic Payment Service or download the application from this website.', 5),
(6, 'What happens if the Company receives a non-sufficient funds notice from my bank?', 'A $25.00 returned payment fee will be added to your account for each occurrence and the payment reversed. SMMWC will contact you via telephone and USPS regarding the returned payment. The fee and payment in full must be received in our office within ten (10) days. If contact attempts are made with no response, the account will become subject to delinquent fees and/or disconnection of services.  ', 6),
(7, 'What are the charges on my bill?', 'Your bill will consist of a monthly availability charge for water that includes the first 1,500 gallons of water usage. There will be an overage charge for any additional water used above that amount. Sewer is charged monthly at a flat availability rate for residents. For commercial sewer rates, please refer to SMMWCs Rate Schedule. For further explanation of water/sewer charges, please contact our office at (805)595-2348.', 7),
(8, 'Can the water meter be re-read if I think there might be a reading error?', 'Yes. Customer Service will have the meter read and re-checked for any errors. At that time, the meter will also be checked for malfunctions and leaks. We will contact you with our findings.', 8),
(9, 'Why am I billed if I don’t live here full-time and/or I never use water?', 'We recognize that some property owners only use their homes occasionally. However, as a mutual water company each of the major customer groups; Residential, Commercial, and Irrigation, is slated to pay their fair share of the costs based on usage and impact on the SMMWC system. For example if residents as a group use half of the water supplied by the company, they should pay half of the cost. Similarly, if commercial generates one-third of the sewage they should pay one-third of the cost of providing sewer service. SMMWC rate structure reflects these goals.', 9),
(10, 'What is my water pressure?', 'Due to variances in our delivery methods and the area topography, water pressure varies throughout our service area. Please contact our office (805)595-2348.', 10),
(11, 'How can I find a leak on my property?', 'First, turn everything off in the house. Then go out to the water meter. Check to see if the dials are turning, if they are, you have a water leak between the meter and inside the house. Watch the meter for 5 – 10 minutes. If the dials do not move, then your leak could be caused by a number of other problems. Check that your toilets are not slowly draining and refilling. The next step would be to check the sprinkler system. Turn on one valve and visually check to see if a sprinkler head is off or cracked. Then go out to the meter and check the speed of the sweeping hand. Compare this speed to the other valves. If one is moving much faster, that might be the valve that is leaking. Also check the valves as they are being turned off. Make sure they turn off quickly without leaking.', 11),
(12, 'Who fixes my water leak?', 'It is the customers’ responsibility to fix any water leak past the meter toward the house. SMMWC is responsible from the meter to the street.', 12),
(13, 'Who is responsible if my sewer line is plugged?', 'The customer is responsible for the sewer lateral from the house to the sewer main in the street.', 13),
(14, 'What is the water hardness in grains?', 'On average the water hardness is 29 grains.', 14),
(15, 'Who do I contact after hours for a water or sewer problem?', 'If a water or sewer emergency occurs after regular business hours which are Monday through Friday 9:00 am to 4:30 pm, call (805)595-2348, option 4 to report the problem. Our answering service will contact standby personnel to respond to the emergency. Please report all pertinent information to the answering service.', 15),
(16, 'Where can I get a copy of the San Miguelito Mutual Water Company’s Annual Water Quality Report?', 'A copy of the Annual Water Quality Report (CCR) is mailed to every customer of San Miguelito Mutual Water Company by July 1st of each year; a copy can be picked up at the company office or accessed on our website. This report contains all pertinent information regarding the quality of the water delivered to our customers.', 16);
-- Superadmin user
INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`) VALUES
(3, 0x00000000000000000000000000000001, 'devadmin', '07a2f6f04cc159e1f04bcd24ab1872b95f04a5f4', NULL, 'ryan@ryankoon.com', NULL, NULL, NULL, NULL, 1467766805, 1467766805, 1, 'Developer', 'Admin', NULL, NULL);
-- Test user DELETE IN PROD
INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`) VALUES
(6, 0x00000000000000000000000000000001, 'testuser', 'b77a408b1c7015cb8ec0a5f3e46ae59ee1d4292d', NULL, 'testuser', NULL, NULL, NULL, NULL, 1470160836, 1470160836, 1, 'Test', 'User', NULL, NULL);
INSERT INTO `notices_types`
(`id`, `type_name`, `friendly_name`, `order`)
VALUES
(1, 'special_notice', 'Special', 2),
(2, 'notice', 'General', 1);
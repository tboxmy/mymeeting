-- phpMyAdmin SQL Dump
-- version 3.1.0-beta1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 26, 2009 at 03:53 PM
-- Server version: 5.0.67
-- PHP Version: 5.2.6-2ubuntu4.1

SET FOREIGN_KEY_CHECKS=0;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

SET AUTOCOMMIT=0;
START TRANSACTION;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mymeetingdb`
--

--
-- Dumping data for table `acos`
--


--
-- Dumping data for table `announcements`
--


--
-- Dumping data for table `aros`
--


--
-- Dumping data for table `aros_acos`
--


--
-- Dumping data for table `attachments`
--


--
-- Dumping data for table `attendances`
--


--
-- Dumping data for table `comments`
--


--
-- Dumping data for table `committees`
--


--
-- Dumping data for table `committeetodos`
--


--
-- Dumping data for table `decisions`
--


--
-- Dumping data for table `decisions_groups`
--


--
-- Dumping data for table `decisions_users`
--


--
-- Dumping data for table `groups`
--


--
-- Dumping data for table `groupstatuses`
--


--
-- Dumping data for table `hashes`
--


--
-- Dumping data for table `items`
--


--
-- Dumping data for table `logs`
--

INSERT DELAYED IGNORE INTO `logs` (`id`, `targetid`, `user_id`, `controller`, `action`, `url`, `timestamp`, `message`) VALUES
(1, 0, 1, 'committees', 'mainpage', '/', '2009-02-26 15:50:26', '[CommitteesController beforeFilter 1] '),
(2, 0, 1, 'committees', 'mainpage', '/', '2009-02-26 15:50:26', '[CommitteesController beforeFilter 1] lastvisitedpage: /'),
(3, 0, 1, 'committees', 'mainpage', '/', '2009-02-26 15:50:26', '[CommitteesController beforeFilter 1] Redirecting to haschangedpassword from committees/mainpage'),
(4, 0, 1, 'users', 'haschangedpassword', 'users/haschangedpassword', '2009-02-26 15:50:26', '[UsersController beforeFilter 1] '),
(5, 0, 1, 'users', 'haschangedpassword', 'users/haschangedpassword', '2009-02-26 15:50:26', '[UsersController haschangedpassword 1] LOGGED IN'),
(6, 0, 1, 'users', 'haschangedpassword', 'users/haschangedpassword', '2009-02-26 15:50:27', '[UsersController haschangedpassword 1] User has changed password. Session haschanged=Y'),
(7, 0, 1, 'committees', 'mainpage', '/', '2009-02-26 15:50:27', '[CommitteesController beforeFilter 1] '),
(8, 0, 1, 'users', 'logout', 'logout', '2009-02-26 15:52:34', '[UsersController beforeFilter 1] ');

--
-- Dumping data for table `meetings`
--


--
-- Dumping data for table `meetingtodos`
--


--
-- Dumping data for table `memberships`
--


--
-- Dumping data for table `notifications`
--


--
-- Dumping data for table `roles`
--

INSERT DELAYED IGNORE INTO `roles` (`id`, `name`, `deleted`, `deleted_date`) VALUES
(1, 'admin', 0, NULL),
(2, 'member', 0, NULL);

--
-- Dumping data for table `settings`
--


--
-- Dumping data for table `systemtodos`
--


--
-- Dumping data for table `templates`
--

INSERT DELAYED IGNORE INTO `templates` (`id`, `model`, `foreign_key`, `type`, `title`, `description`, `template`) VALUES
(1, 'System', 0, 'invite', 'Jemputan ke mesyuarat', 'Emel yang dihantar untuk menjemput ahli ke mesyuarat', '<p>ASSALAMUALAIKUM DAN SALAM SEJAHTERA</p><p>%name,</p><p><strong><span style=''text-decoration: underline;''>JEMPUTAN KE MESYUARAT</span></strong></p><p>Dengan segala hormatnya merujuk perkara di atas.</p><p>2. Sukacita dimaklumkan bahawa satu mesyuarat  %Meeting.meeting_title akan diadakan. Maklumat adalah seperti berikut:</p><p>Tarikh &amp; masa: %Meeting.meeting_date</p><p>Tempat: %Meeting.venue</p><p>Maklumat mesyuarat: %Link.meeting:Sini</p><p>3. Tuan/puan adalah dengan segala hormatnya dijemput hadir. Pengesahan kehadiran boleh dilakukan di %Link:confirm:sini. Kerjasama dan perhatian tuan/puan didahului dengan ucapan terima kasih.</p><p>&nbsp;</p><p>Terima kasih.</p>'),
(2, 'System', 0, 'uninvite', 'Tidak perlu hadir ke mesyuarat', 'Emel untuk dihantar sekiranya mesyuarat dibatalkan', '<p>ASSALAMUALAIKUM DAN SALAM SEJAHTERA</p><p>%name,</p><p><strong><span style=''text-decoration: underline;''>JEMPUTAN KE MESYUARAT DIBATALKAN<br /></span></strong></p><p>Dengan segala hormatnya merujuk perkara di atas.</p><p>2. Adalah ini dimaklumkan bahawa tuan/puan tidak perlu menghadiri mesyuarat  %Meeting.meeting_title seperti berikut:</p><p>Tarikh &amp; masa: %Meeting.meeting_date</p><p>Tempat: %Meeting.venue</p><p>&nbsp;</p><p>Terima kasih.</p>'),
(3, 'System', 0, 'change', 'Perubahan mesyuarat', 'Emel untuk dihantar jika terdapat perubahan kepada maklumat mesyuarat', '<p>ASSALAMUALAIKUM DAN SALAM SEJAHTERA</p><p>%name,</p><p><strong><span style=''text-decoration: underline;''>PERUBAHAN MASA/TEMPAT MESYUARAT</span></strong></p><p>Dengan segala hormatnya merujuk perkara di atas.</p><p>2. Adalah ini dimaklumkan bahawa terdapat perubahan untuk mesyuarat  %OldMeeting.meeting_title . Maklumat lama adalah seperti berikut:</p><p>Tarikh &amp; masa (lama): %OldMeeting.meeting_date</p><p>Tempat (lama): %OldMeeting.venue</p><p><span style=''text-decoration: underline;''>Maklumat mesyuarat terkini adalah seperti berikut:</span></p><p>Mesyuarat: %Meeting.meeting_title</p><p>Tarikh &amp; masa: %Meeting.meeting_date</p><p>Tempat: %Meeting.venue</p><p>3. Maklumat mesyuarat boleh dilihat di %Link.meeting:sini. Tuan/puan adalah dengan segala hormatnya dijemput hadir. Kerjasama dan perhatian tuan/puan didahului dengan ucapan terima kasih.</p><p>&nbsp;</p><p>Terima kasih.</p>'),
(4, 'System', 0, 'cancel', 'Pembatalan mesyuarat', 'Emel untuk dihantar sekiranya mesyuarat dibatalkan', '<p>ASSALAMUALAIKUM DAN SALAM SEJAHTERA</p><p>%name,</p><p><strong><span style=''text-decoration: underline;''>PEMBATALAN MESYUARAT</span></strong></p><p>Dengan segala hormatnya merujuk perkara di atas.</p><p>2. Dukacita dimaklumkan bahawa mesyuarat  %Meeting.meeting_title telah dibatalkan.</p><p>Terima kasih.</p>'),
(5, 'System', 0, 'meeting reminder', 'Peringatan mesyuarat', 'Emel untuk dihantar sebagai peringatan mesyuarat yang akan datang', '<p>ASSALAMUALAIKUM DAN SALAM SEJAHTERA</p><p>%name,</p><p><strong><span style=''text-decoration: underline;''>PERINGATAN UNTUK HADIR KE MESYUARAT</span></strong></p><p>Dengan segala hormatnya merujuk perkara di atas.</p><p>2. Sebagai peringatan, adalah dengan ini dimaklumkan bahawa tuan/puan telah dijemput untuk menghadiri mesyuarat  %Meeting.meeting_title pada %Meeting.meeting_date di %Meeting.venue.</p><p>Terima kasih.</p>'),
(6, 'System', 0, 'status reminder', 'Peringatan kemaskini status tindakan', 'Emel untuk menghantar peringatan kepada ahli mesyuarat untuk mengemaskini status tindakan.', '<p>ASSALAMUALAIKUM DAN SALAM SEJAHTERA</p><p>%name,</p><p><strong><span style=''text-decoration: underline;''>PERINGATAN UNTUK MENGEMASKINI STATUS TINDAKAN<br /></span></strong></p><p>Dengan segala hormatnya merujuk perkara di atas.</p><p>2. Sebagai peringatan, adalah dengan ini dimaklumkan bahawa tuan/puan masih belum mengemaskini status tindakan tuan/puan untuk keputusan mesyuarat seperti berikut:</p><p>=================<br /> %Decision.description<br /> =================</p><p>yang telah dipertanggungjwabkan kepada tuan/puan di dalam mesyuarat %Meeting.meeting_title pada %Meeting.meeting_date. Tuan/puan masih mempunyai %days_left hari lagi untuk membuat kemaskini.</p><p>3. Tuan/puan klik di  %Link.decision:sini untuk melihat maklumat keputusan.</p><p>&nbsp;</p><p>Terima kasih.</p>'),
(7, 'System', 0, 'meeting comment', 'Komen untuk mesyuarat', 'Emel untuk dihantar apabila terdapat komen yang ditinggalkan untuk mesyuarat', '<p>ASSALAMUALAIKUM DAN SALAM SEJAHTERA</p><p>%name,</p><p><strong><span style=''text-decoration: underline;''>MAKLUMAN TENTANG KOMEN YANG DITINGGALKAN UNTUK MESYUARAT<br /></span></strong></p><p>Dengan segala hormatnya merujuk perkara di atas.</p><p>2. %Comment.user telah meninggalkan komen untuk mesyuarat %Meeting.meeting_num. Komennya adalah seperti berikut:</p><p>================<br /> %Comment.comment<br /> ================</p><p>3. Maklumat mesyuarat boleh dilihat di %Link.meeting:sini.</p><p>&nbsp;</p><p>Terima kasih.</p>'),
(8, 'System', 0, 'decision comment', 'Komen untuk keputusan', 'Emel untuk dihantar apabila terdapat komen yang ditinggalkan untuk keputusan', '<p>ASSALAMUALAIKUM DAN SALAM SEJAHTERA</p><p>%name,</p><p><strong><span style=''text-decoration: underline;''>MAKLUMAN TENTANG KOMEN YANG DITINGGALKAN UNTUK MESYUARAT<br /></span></strong></p><p>Dengan segala hormatnya merujuk perkara di atas.</p><p>2. %Comment.user telah meninggalkan komen untuk keputusan yang dibuat dalam mesyuarat %Meeting.meeting_num. Komennya adalah seperti berikut:</p><p>================<br /> %Comment.comment<br /> ================</p><p>Keputusan yang dirujuk adalah:</p><p>================<br /> %Decision.description<br /> ================</p><p>3. Maklumat keputusan boleh dilihat di %Link.decision:sini.</p><p>&nbsp;</p><p>Terima kasih.</p>'),
(9, 'System', 0, 'status comment', 'Komen untuk status', 'Emel untuk dihantar apabila terdapat komen yang ditinggalkan untuk status tindakan', '<p>ASSALAMUALAIKUM DAN SALAM SEJAHTERA</p><p>%name,</p><p><strong><span style=''text-decoration: underline;''>MAKLUMAN TENTANG KOMEN YANG DITINGGALKAN UNTUK STATUS TINDAKAN<br /></span></strong></p><p>Dengan segala hormatnya merujuk perkara di atas.</p><p>2. %Comment.user telah meninggalkan komen untuk status tidakan yang telah diambil bagi keputusan yang dibuat dalam mesyuarat %Meeting.meeting_num. Komennya adalah seperti berikut:</p><p>================<br /> %Comment.comment<br /> ================</p><p>Keputusan yang dirujuk adalah:</p><p>================<br /> %Decision.description<br /> ================</p><p>Status tindakan yang dirujuk adalah:</p><p>================<br /> %Status.description<br /> ================</p><p>3. Maklumat keputusan dan status tindakan boleh dilihat di %Link.decision:sini.</p><p>&nbsp;</p><p>Terima kasih.</p>'),
(10, 'SystemOnly', 0, 'forgot password', 'Kata laluan baru', 'Emel yang dihantar apabila ahli terlupa kata laluan', '<p>ASSALAMUALAIKUM DAN SALAM SEJAHTERA</p><p>%name,</p><p><strong><span style=''text-decoration: underline;''>KATA LALUAN BARU<br /></span></strong></p><p>Dengan segala hormatnya merujuk perkara di atas.</p><p>2. Satu permintaan telah dilakukan di MyMeeting untuk set semula kata laluan tuan/puan. Oleh yang demikian, kata laluan baru telah dijana untuk kegunaan tuan/puan. Kata laluan baru tuan/puan ialah %newpassword</p><p>Harap maklum.</p><p>&nbsp;</p><p>Terima kasih.</p>'),
(11, 'SystemOnly', 0, 'forgot username', 'Dapatkan semula kata nama', 'Emel yang dihantar apabila ahli terlupa kata nama', '<p>ASSALAMUALAIKUM DAN SALAM SEJAHTERA</p><p>%name,</p><p><strong><span style=''text-decoration: underline;''>MENDAPATKAN SEMULA KATA NAMA<br /></span></strong></p><p>Dengan segala hormatnya merujuk perkara di atas.</p><p>2. Satu permintaan telah dilakukan di MyMeeting untuk mendapatkan semula kata nama tuan/puan.&nbsp; Kata nama tuan/puan ialah %username</p><p>Harap maklum.</p><p>&nbsp;</p><p>Terima kasih.</p>');

--
-- Dumping data for table `titles`
--

INSERT DELAYED IGNORE INTO `titles` (`id`, `short_name`, `long_name`, `created`, `updated`) VALUES
(1, 'Y.Bhg Tan ', 'Y.Bhg Tan Sri', '2009-02-26 13:36:52', '2009-02-26 13:36:52'),
(2, 'Y.Bhg Datu', 'Y.Bhg Datuk', '2009-02-26 13:36:52', '2009-02-26 13:36:52'),
(3, 'Y.Bhg Dato', 'Y.Bhg Dato''', '2009-02-26 13:36:52', '2009-02-26 13:36:52'),
(4, 'Y.Brs Dr.', 'Y.Brs Dr.', '2009-02-26 13:36:52', '2009-02-26 13:36:52'),
(5, 'Hj.', 'Hj.', '2009-02-26 13:36:52', '2009-02-26 13:36:52'),
(6, 'En.', 'En.', '2009-02-26 13:36:52', '2009-02-26 13:36:52'),
(7, 'Pn.', 'Pn.', '2009-02-26 13:36:52', '2009-02-26 13:36:52'),
(8, 'Cik', 'Cik', '2009-02-26 13:36:52', '2009-02-26 13:36:52');

--
-- Dumping data for table `users`
--

INSERT DELAYED IGNORE INTO `users` (`id`, `username`, `password`, `superuser`, `protocol`, `job_title`, `bahagian`, `grade`, `name`, `email`, `telephone`, `mobile`, `fax`, `address`, `title_id`, `deleted`, `deleted_date`, `created`, `updated`) VALUES
(1, 'admin', 'cf6232df41ddc9900c4822a5507c56403fc80247', 1, 0, NULL, NULL, NULL, 'admin', 'noreply@mymeeting.com', NULL, NULL, NULL, NULL, 0, 0, NULL, '2009-02-26 13:36:52', '2009-02-26 13:36:52');

--
-- Dumping data for table `userstatuses`
--


--
-- Dumping data for table `users_groups`
--


--
-- Dumping data for table `wfmodels`
--


--
-- Dumping data for table `wfstatuses`
--


--
-- Dumping data for table `workflows`
--


SET FOREIGN_KEY_CHECKS=1;

COMMIT;

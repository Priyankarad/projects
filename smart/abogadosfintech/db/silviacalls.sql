-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 18, 2017 at 08:51 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `silviacalls`
--

-- --------------------------------------------------------

--
-- Table structure for table `svc_admin`
--

CREATE TABLE IF NOT EXISTS `svc_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `name` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `user_group` varchar(256) NOT NULL,
  `status` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `svc_admin`
--

INSERT INTO `svc_admin` (`id`, `username`, `password`, `name`, `email`, `user_group`, `status`) VALUES
(1, 'svcadmin', 'svcadmin@123##', 'Super Admin', 'admin@admin.com', 'Admin', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `svc_blog_contents`
--

CREATE TABLE IF NOT EXISTS `svc_blog_contents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `blog_id` int(11) NOT NULL,
  `blog_title` varchar(255) DEFAULT NULL,
  `blog_desc` text,
  `language_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `language_id` (`language_id`),
  KEY `blog_id` (`blog_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `svc_blog_contents`
--

INSERT INTO `svc_blog_contents` (`id`, `blog_id`, `blog_title`, `blog_desc`, `language_id`) VALUES
(1, 1, 'Lorem Ipsum is simply dummy text', '<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n', 1),
(2, 1, 'b1', '<p>b1</p>\r\n', 2),
(3, 2, 'There are many variations of passages of Lorem Ipsum available', '<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#39;t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn&#39;t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p>\r\n\r\n<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#39;t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn&#39;t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p>\r\n\r\n<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#39;t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn&#39;t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p>\r\n', 1),
(4, 2, 'fghgfhfgh', '<p>fghgfhgfhf</p>\r\n', 2);

-- --------------------------------------------------------

--
-- Table structure for table `svc_blog_posts`
--

CREATE TABLE IF NOT EXISTS `svc_blog_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `createdate` varchar(255) DEFAULT NULL,
  `blog_slug` varchar(255) DEFAULT NULL,
  `flag` enum('0','1') DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `svc_blog_posts`
--

INSERT INTO `svc_blog_posts` (`id`, `createdate`, `blog_slug`, `flag`) VALUES
(1, '1497686912', 'lorem-ipsum-is-simply-dummy-text', '1'),
(2, '1497789097', 'there-are-many-variations-of-passages-of-lorem-ipsum-available', '1');

-- --------------------------------------------------------

--
-- Table structure for table `svc_config`
--

CREATE TABLE IF NOT EXISTS `svc_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `config_type` varchar(256) NOT NULL,
  `config_val` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `svc_config`
--

INSERT INTO `svc_config` (`id`, `config_type`, `config_val`) VALUES
(13, 'project_name', 'Silvia Calls'),
(16, 'facebook_url', 'http://facebook.com'),
(17, 'twitter_url', 'http://twitter.com'),
(18, 'linkedin_url', 'http://linkedin.com'),
(19, 'contact_email', 'subh.laha@gmail.com'),
(21, 'instagram_url', 'http://instagram.com');

-- --------------------------------------------------------

--
-- Table structure for table `svc_feedback`
--

CREATE TABLE IF NOT EXISTS `svc_feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `message` text,
  `createdate` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `svc_feedback`
--

INSERT INTO `svc_feedback` (`id`, `name`, `email`, `message`, `createdate`) VALUES
(1, 'Subhasis Laha', 'subh.laha@gmail.com', 'asdasdsad', '1497803205'),
(2, 'Subhasis Laha', 'subh.laha@gmail.com', 'dasdasdsa', '1497803358'),
(3, 'Subhasis Laha', 'subh.laha@gmail.com', 'test Message', '1497805150');

-- --------------------------------------------------------

--
-- Table structure for table `svc_languages`
--

CREATE TABLE IF NOT EXISTS `svc_languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language` varchar(255) DEFAULT NULL,
  `code` varchar(10) DEFAULT NULL,
  `is_default` enum('0','1') NOT NULL DEFAULT '0',
  `flag` enum('0','1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `svc_languages`
--

INSERT INTO `svc_languages` (`id`, `language`, `code`, `is_default`, `flag`) VALUES
(1, 'english', 'en', '1', '1'),
(2, 'spanish', 'es', '0', '1');

-- --------------------------------------------------------

--
-- Table structure for table `svc_media_library`
--

CREATE TABLE IF NOT EXISTS `svc_media_library` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image_title` varchar(255) DEFAULT NULL,
  `image_path` text,
  `createdate` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `svc_media_library`
--

INSERT INTO `svc_media_library` (`id`, `image_title`, `image_path`, `createdate`) VALUES
(13, 'Main Background Image', '1497720219.jpg', '1497699972'),
(14, 'Middle Section Image 1', '1497720245.jpg', '1497720245'),
(15, 'Bottom Section 1 Image', '1497720296.jpg', '1497720296'),
(16, 'Bottom Section 2 Image', '1497720309.jpg', '1497720309'),
(17, 'Bottom Section 3 Image', '1497720330.jpg', '1497720330'),
(18, 'Middle Section Image 2', '1497722642.jpg', '1497722642'),
(19, 'Circulo Legal Logo', '1497775247.png', '1497775247'),
(20, 'BBVX CA Logo', '1497775264.png', '1497775264'),
(21, 'Wonga Logo', '1497775281.png', '1497775281');

-- --------------------------------------------------------

--
-- Table structure for table `svc_pages`
--

CREATE TABLE IF NOT EXISTS `svc_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_name` varchar(255) DEFAULT NULL,
  `page_slug` varchar(255) DEFAULT NULL,
  `media_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `svc_pages`
--

INSERT INTO `svc_pages` (`id`, `page_name`, `page_slug`, `media_id`) VALUES
(1, 'Home Section', '', 13),
(3, 'About Me', 'about-me', 15),
(4, 'Bottom Section 1', 'bottom-section-one', 15),
(5, 'Bottom Section 2', 'bottom-section-two', 16),
(6, 'Bottom Section 3', 'bottom-section-three', 17),
(7, 'Contact', 'contact-me', 0),
(8, 'Bottom Section Heading', NULL, 0),
(9, 'Middle Section 1', 'middle-section-one', 14),
(10, 'Middle Section 2', 'middle-section-two', 18);

-- --------------------------------------------------------

--
-- Table structure for table `svc_page_content`
--

CREATE TABLE IF NOT EXISTS `svc_page_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `page_title` varchar(255) DEFAULT NULL,
  `page_desc` text,
  `language_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `page_id` (`page_id`),
  KEY `language_id` (`language_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `svc_page_content`
--

INSERT INTO `svc_page_content` (`id`, `page_id`, `page_title`, `page_desc`, `language_id`) VALUES
(1, 1, 'Silvia Calls Insa', '<p>Silvia Calls is a FinTech lawyer specialized in helping&nbsp; startups&nbsp; grow and consolidate in FinTech sector.</p>\r\n', 1),
(2, 1, 'b1', '<p>b1</p>\r\n', 2),
(4, 7, 'Contact Me', '<p><strong>My Name</strong></p>\r\n\r\n<ul>\r\n	<li>Phone: 123456789</li>\r\n	<li>Mob: 123456789</li>\r\n	<li>Location: City, State, Country, Pincode</li>\r\n</ul>\r\n', 1),
(5, 7, 'adasdsd', '<p>asdsdsad</p>\r\n', 2),
(6, 4, 'Bottom Section 1', '<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#39;Content here, content here&#39;, making it look like readable English.</p>\r\n', 1),
(7, 4, 'adasdsa', '<p>asdasd</p>\r\n', 2),
(8, 5, 'Bottom Section 2', '<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#39;Content here, content here&#39;, making it look like readable English.</p>\r\n', 1),
(9, 5, 'gfdgfdg', '<p>fdgdfgdf</p>\r\n', 2),
(10, 6, 'Bottom Section 3', '<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#39;Content here, content here&#39;, making it look like readable English.</p>\r\n', 1),
(11, 6, 'jghjhgj', '<p>ghjghj</p>\r\n', 2),
(12, 3, 'About Me', '<p>About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me</p>\r\n\r\n<p>About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me</p>\r\n\r\n<p>About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me About Me</p>\r\n\r\n<p><img alt="" src="http://localhost/silviacalls/svcallscontrolpanel/userfiles/1497775264.png" style="height:120px; width:217px" /><img alt="" src="http://localhost/silviacalls/svcallscontrolpanel/userfiles/1497775247.png" style="height:120px; width:383px" /><img alt="" src="http://localhost/silviacalls/svcallscontrolpanel/userfiles/1497775281.png" style="height:120px; width:191px" /></p>\r\n', 1),
(13, 3, 'dgdg', '<p>gdfg</p>\r\n', 2),
(16, 8, 'FinTech Consultancy', '', 1),
(17, 8, 'dfgdfgdf', '', 2),
(18, 9, 'Lorem Ipsum is simply dummy text', '<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n', 1),
(19, 9, 'sadsad', '<p>adasda</p>\r\n', 2),
(20, 10, 'It is a long established fact', '<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#39;Content here, content here&#39;, making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &#39;lorem ipsum&#39; will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>\r\n\r\n<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#39;Content here, content here&#39;, making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &#39;lorem ipsum&#39; will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>\r\n\r\n<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#39;Content here, content here&#39;, making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &#39;lorem ipsum&#39; will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>\r\n', 1),
(21, 10, 'asdasd', '<p>adadsd</p>\r\n', 2);

-- --------------------------------------------------------

--
-- Table structure for table `svc_terms`
--

CREATE TABLE IF NOT EXISTS `svc_terms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `term` varchar(255) DEFAULT NULL,
  `flag` enum('0','1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `svc_terms`
--

INSERT INTO `svc_terms` (`id`, `term`, `flag`) VALUES
(8, 'Home', '1'),
(9, 'About Me', '1'),
(10, 'Blog', '1'),
(11, 'Contact Me', '1'),
(12, 'All rights reserved', '1'),
(13, 'Learn More', '1'),
(14, 'Menu', '1'),
(15, 'Blog Posts', '1'),
(16, 'Posted On', '1'),
(17, 'No Blog Posts Found', '1'),
(18, 'Read More', '1'),
(19, 'Contact Details', '1'),
(20, 'Do you have an enquiry? Please fill up the details below and send me your message.', '1'),
(21, 'Enquiry Form', '1'),
(22, 'Name', '1'),
(23, 'Email', '1'),
(24, 'Enter your message', '1'),
(25, 'Send Message', '1'),
(26, 'Reset', '1'),
(27, 'Result', '1'),
(28, 'Message Sent Successfully', '1'),
(29, 'Invalid Captcha Entered', '1');

-- --------------------------------------------------------

--
-- Table structure for table `svc_term_language`
--

CREATE TABLE IF NOT EXISTS `svc_term_language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `term_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `language_term` text,
  PRIMARY KEY (`id`),
  KEY `term_id` (`term_id`),
  KEY `language_id` (`language_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=63 ;

--
-- Dumping data for table `svc_term_language`
--

INSERT INTO `svc_term_language` (`id`, `term_id`, `language_id`, `language_term`) VALUES
(19, 13, 1, 'Learn More'),
(20, 13, 2, 'Aprende mÃ¡s'),
(21, 12, 1, 'All rights reserved'),
(22, 12, 2, 'Todos los derechos reservados'),
(23, 11, 1, 'Contact Me'),
(24, 11, 2, 'ContÃ¡ctame'),
(25, 10, 1, 'Blog'),
(26, 10, 2, 'Blog'),
(27, 9, 1, 'About Me'),
(28, 9, 2, 'Sobre mi'),
(29, 8, 1, 'Home'),
(30, 8, 2, 'Casa'),
(31, 14, 1, 'Menu'),
(32, 14, 2, 'MenÃº'),
(33, 15, 1, 'Blog Posts'),
(34, 15, 2, 'Publicaciones de blog'),
(35, 16, 1, 'Posted On'),
(36, 16, 2, 'Publicado en'),
(37, 17, 1, 'No Blog Posts Found'),
(38, 17, 2, 'No se han encontrado entradas en el blog'),
(39, 18, 1, 'Read More'),
(40, 18, 2, 'Lee mas'),
(41, 19, 1, 'Contact Details'),
(42, 19, 2, 'Detalles de contacto'),
(43, 20, 1, 'Do you have an enquiry? Please fill up the details below and send me your message.'),
(44, 20, 2, 'Â¿Tiene alguna pregunta? Por favor, rellene los detalles a continuaciÃ³n y envÃ­eme su mensaje.'),
(45, 21, 1, 'Enquiry Form'),
(46, 21, 2, 'Formulario de Consulta'),
(47, 27, 1, 'Result'),
(48, 27, 2, 'Resultado'),
(49, 26, 1, 'Reset'),
(50, 26, 2, 'Reiniciar'),
(51, 25, 1, 'Send Message'),
(52, 25, 2, 'Enviar mensaje'),
(53, 24, 1, 'Enter your message'),
(54, 24, 2, 'Ingrese su mensaje'),
(55, 23, 1, 'Email'),
(56, 23, 2, 'Email'),
(57, 22, 1, 'Name'),
(58, 22, 2, 'Nombre'),
(59, 29, 1, 'Invalid Captcha Entered'),
(60, 29, 2, 'Captcha no vÃ¡lido ingresado'),
(61, 28, 1, 'Message Sent Successfully'),
(62, 28, 2, 'Mensaje enviado con Ã©xito');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `svc_blog_contents`
--
ALTER TABLE `svc_blog_contents`
  ADD CONSTRAINT `svc_blog_contents_ibfk_1` FOREIGN KEY (`language_id`) REFERENCES `svc_languages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `svc_blog_contents_ibfk_2` FOREIGN KEY (`blog_id`) REFERENCES `svc_blog_posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `svc_page_content`
--
ALTER TABLE `svc_page_content`
  ADD CONSTRAINT `svc_page_content_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `svc_pages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `svc_page_content_ibfk_2` FOREIGN KEY (`language_id`) REFERENCES `svc_languages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `svc_term_language`
--
ALTER TABLE `svc_term_language`
  ADD CONSTRAINT `svc_term_language_ibfk_1` FOREIGN KEY (`term_id`) REFERENCES `svc_terms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `svc_term_language_ibfk_2` FOREIGN KEY (`language_id`) REFERENCES `svc_languages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

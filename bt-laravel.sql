-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 24, 2020 at 03:09 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bt-laravel`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `author` bigint(20) UNSIGNED NOT NULL,
  `comment_parent` bigint(20) NOT NULL,
  `comment_content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment_status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `author`, `comment_parent`, `comment_content`, `comment_status`, `created_at`, `updated_at`) VALUES
(4, 63, 58, 0, 'ok test', 1, '2020-11-06 04:33:08', '2020-11-07 01:42:40'),
(8, 63, 73, 0, '22sadsaf', 1, '2020-11-06 08:53:45', '2020-11-06 10:08:18'),
(11, 63, 58, 4, 'reply', 1, '2020-11-07 01:43:34', '2020-11-07 01:43:34'),
(27, 64, 58, 0, 'hello everybody', 1, '2020-11-11 02:40:12', '2020-11-11 02:40:12'),
(31, 137, 73, 0, 'hello bồ', 1, '2020-11-18 02:30:13', '2020-11-18 02:30:13'),
(32, 137, 73, 31, 'ỵghjgu', 1, '2020-11-18 03:11:47', '2020-11-18 03:11:47'),
(33, 137, 73, 31, 'hjgvjhv', 1, '2020-11-18 03:11:54', '2020-11-18 03:11:54'),
(34, 63, 73, 0, 'sdasf', 1, '2020-11-21 03:06:24', '2020-11-21 03:06:24'),
(35, 65, 73, 0, 'hmm!', 1, '2020-11-23 08:37:08', '2020-11-23 08:37:08');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2020_10_09_083820_posts_table', 1),
(5, '2020_10_09_083938_categories_table', 1),
(6, '2020_10_14_024040_add_socialite_fields_to_users_table', 2),
(7, '2020_10_14_075133_add_column_categories', 3),
(13, '2020_10_26_071139_create_postmeta_table', 4),
(14, '2020_10_26_071613_create_usermeta_table', 4),
(17, '2020_10_26_083310_add_column_postmeta', 5),
(18, '2020_10_27_011623_create_postmeta_table', 6),
(19, '2020_10_27_011721_create_usermeta_table', 6),
(20, '2020_10_29_085913_add_column_user', 7),
(21, '2020_11_06_012410_add_clumn_post', 8),
(22, '2020_11_06_013851_create_comments_table', 9),
(25, '2020_11_16_150630_add_column_vote_count_posts', 10),
(26, '2020_11_20_144533_add_column_show_terms', 11),
(27, '2020_11_20_144609_add_column_show_posts', 11);

-- --------------------------------------------------------

--
-- Table structure for table `postmeta`
--

CREATE TABLE `postmeta` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `postmeta`
--

INSERT INTO `postmeta` (`id`, `post_id`, `meta_key`, `meta_value`) VALUES
(45, 66, 'meta_image', '2020/10/minh-phuong-roi-tp-hcm.jpg'),
(46, 65, 'meta_image', '2020/10/skysports-cristiano-ronaldo-51-7794-6910-1603840369.jpg'),
(47, 64, 'meta_image', '2020/10/shutterstock-1066576061-6413-1603785114.jpg'),
(48, 68, 'meta_image', '2020/10/vne-homestay-lua-khach-1603796-1510-8802-1603797243.jpg'),
(49, 63, 'meta_image', '2020/10/cay-xanh-0-2046-1603846800.jpg'),
(54, 105, 'meta_image', '2020/11/trump-biden-1-9516-1604640430.jpg'),
(56, 125, 'meta_image', '2020/11/csm-cardiovascular-disease1-ae5cb7a78a-1544443842_680x0.jpg'),
(57, 126, 'meta_image', '2020/11/8.png'),
(59, 131, 'meta_image', '2020/11/ASEAN-6607-1605521352.jpg'),
(60, 137, 'meta_image', '2020/11/a-1605652443-3963-1605652499.jpg'),
(61, 138, 'meta_image', '2020/11/b-1b-lancer-5-5375-1588381936-1703-1605632458.jpg'),
(62, 139, 'meta_image', '2020/11/20201118102438-IMG-8279-JPG-1711-1605676888.jpg'),
(63, 141, 'meta_image', '2020/11/e158d46c-1f8a-44d3-b613-9d0aa5-8290-3688-1605840744.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `summary` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author` bigint(20) UNSIGNED NOT NULL,
  `post_parent` bigint(20) UNSIGNED NOT NULL,
  `post_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment_count` bigint(20) NOT NULL,
  `vote_count` int(11) NOT NULL DEFAULT 0,
  `show` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `summary`, `content`, `author`, `post_parent`, `post_type`, `status`, `comment_count`, `vote_count`, `show`, `created_at`, `updated_at`) VALUES
(63, 'Bão Molave áp sát Quảng Nam - Quảng Ngãi', 'Sáng 28/10, bão Molave đã áp sát bờ biển từ Quảng Nam đến Phú Yên gây mưa lớn, gió mạnh quật đổ nhiều cây xanh, bảng quảng cáo', '<p>TP Tuy Ho&agrave;,&nbsp;<strong>Ph&uacute; Y&ecirc;n</strong>&nbsp;s&aacute;ng nay mưa tầm t&atilde;, gi&oacute; r&iacute;t li&ecirc;n hồi. Những h&agrave;ng c&acirc;y dọc đường Nguyễn Tất Th&agrave;nh, H&ugrave;ng Vương, Nguyễn Du... bị gi&oacute; cuốn nghi&ecirc;ng ngả.</p><p>Qu&aacute;n s&aacute;, đường phố vắng vẻ, nhiều cửa h&agrave;ng đ&oacute;ng cửa. Nhiều người d&acirc;n sống tr&ecirc;n đường Nguyễn Tất Th&agrave;nh căng d&acirc;y, đưa lốp xe l&ecirc;n m&aacute;i t&ocirc;n để chằng chống nh&agrave; cửa.</p><p>Anh Trương C&ocirc;ng Đồng, 41 tuổi, chủ cửa h&agrave;ng sửa xe ở th&agrave;nh phố đ&oacute;ng tiệm do b&atilde;o nhưng &ocirc;t&ocirc; của một người đi đường thủng b&aacute;nh, gọi v&agrave;o điện thoại n&ecirc;n hỗ trợ. &quot;Thấy họ gặp kh&oacute;, m&igrave;nh gi&uacute;p đỡ chứ h&ocirc;m nay đ&oacute;ng cửa để đảm bảo an to&agrave;n&quot;, anh Đồng n&oacute;i.</p>', 58, 0, 'boards', 'public', 4, 0, 0, '2020-10-27 18:22:23', '2020-11-21 03:06:24'),
(64, 'Năm cách khiến trẻ nghe lời mà không cần đánh mắng', 'Thay vì chỉ yêu cầu \"bỏ hộp sữa đó đi\", bạn cần giải thích tại sao không được uống sữa bởi trẻ em sẽ phản kháng nếu không hiểu mệnh lệnh', '<p><em>Carrie, mẹ của b&eacute; g&aacute;i 6 tuổi, thường gặp kh&oacute; khăn trong việc khiến con nghe lời. Việc nu&ocirc;i dạy con c&aacute;i n&ecirc;n kh&oacute; khăn, khiến c&ocirc; cảm thấy &aacute;p lực v&agrave; mệt mỏi. Carrie tham gia nhiều kh&oacute;a học, đọc t&agrave;i liệu v&agrave; r&uacute;t ra một số b&agrave;i học cho bản th&acirc;n. Dưới đ&acirc;y l&agrave; năm c&aacute;ch c&ocirc; khiến con nghe lời m&agrave; kh&ocirc;ng phải đ&aacute;nh, mắng.</em></p><p><strong>N&oacute;i một từ</strong></p><p>Trước kia, t&ocirc;i thường giao con g&aacute;i mang b&aacute;t, đĩa v&agrave;o bồn rửa sau khi ăn. Tuy nhi&ecirc;n, kh&ocirc;ng một bữa ăn n&agrave;o m&agrave; đứa trẻ tự gi&aacute;c l&agrave;m việc n&agrave;y. T&ocirc;i lu&ocirc;n phải nhắc nhở 2-3 lần con vẫn kh&ocirc;ng chịu l&agrave;m. Đ&ocirc;i khi, ch&uacute;ng cũng kh&ocirc;ng nhớ.</p><p>Để giải quyết, t&ocirc;i đ&atilde; diễn đạt mệnh lệnh của m&igrave;nh bằng c&aacute;ch n&oacute;i ngắn gọn nhất để g&acirc;y ch&uacute; &yacute;, k&iacute;ch hoạt tr&iacute; nhớ của con. Tất cả những g&igrave; t&ocirc;i n&oacute;i l&agrave; &quot;đĩa&quot;, thay thế cho những chỉ dẫn d&agrave;i d&ograve;ng.</p><p>L&uacute;c đầu, con nh&igrave;n t&ocirc;i như người ngo&agrave;i h&agrave;nh tinh nhưng một gi&acirc;y sau, con nhặt b&aacute;t đĩa v&agrave; đi v&agrave;o bếp. Sau khoảng một th&aacute;ng &aacute;p dụng, t&ocirc;i kh&ocirc;ng cần n&oacute;i g&igrave; cả bởi con tự gi&aacute;c l&agrave;m nhiệm vụ của m&igrave;nh. Điều n&agrave;y cũng tương tự khi t&ocirc;i n&oacute;i &quot;răng&quot; nếu muốn con đi đ&aacute;nh răng, &quot;gi&agrave;y&quot; nếu cần con đi gi&agrave;y v&agrave; đến trường.</p><p><strong>Cung cấp đầy đủ th&ocirc;ng tin</strong></p><p>Trẻ em kh&ocirc;ng phải robot được lập tr&igrave;nh để thực hiện mọi chỉ thị của ch&uacute;ng ta. Ch&uacute;ng cũng c&oacute; tư duy v&agrave; mong muốn tự lập, do đ&oacute; thường phản kh&aacute;ng lại c&aacute;c mệnh lệnh nếu kh&ocirc;ng thấy được sự hợp l&yacute;. Hiểu được điều n&agrave;y, t&ocirc;i thường biến mệnh lệnh của m&igrave;nh th&agrave;nh những lời chỉ dạy.</p><p>Thay v&igrave; chỉ y&ecirc;u cầu con &quot;bỏ hộp sữa đ&oacute; đi&quot;, t&ocirc;i giải th&iacute;ch &quot;sữa bị hỏng v&igrave; để b&ecirc;n ngo&agrave;i qu&aacute; l&acirc;u, con kh&ocirc;ng n&ecirc;n uống&quot;. Tương tự khi con hay giẫm ch&acirc;n l&ecirc;n ghế, t&ocirc;i n&oacute;i &quot;ghế l&agrave; để ngồi&quot; chứ kh&ocirc;ng qu&aacute;t &quot;ngồi im&quot; hoặc &quot;ngồi xuống&quot; như trước kia. Con g&aacute;i t&ocirc;i bắt đầu ngồi xuống v&agrave; tự x&uacute;c ăn. Việc n&agrave;y c&oacute; thể kh&ocirc;ng t&aacute;c dụng ngay lập tức hoặc lần sau đứa trẻ vẫn t&aacute;i phạm, tuy nhi&ecirc;n n&oacute; cung cấp th&ecirc;m hiểu biết v&agrave; kỹ năng sống cho trẻ em, đồng thời gi&uacute;p cha mẹ trở n&ecirc;n thấu đ&aacute;o, r&otilde; r&agrave;ng hơn.</p>', 58, 0, 'boards', 'public', 1, 5, 0, '2020-10-27 18:24:47', '2020-11-20 04:48:04'),
(65, 'Ronaldo lỡ hẹn với Messi vì nCoV', 'Cristiano Ronaldo vẫn dương tính với nCoV nên không thể dự trận Juventus gặp Barca ở bảng G Champions League', '<p>Theo quy định của UEFA, cầu thủ phải &acirc;m t&iacute;nh với nCoV trong v&ograve;ng 24 giờ trước thời điểm b&oacute;ng lăn mới được thi đấu. Với kết quả x&eacute;t nghiệm dương t&iacute;nh lần ba h&ocirc;m 27/10, Ronaldo buộc phải vắng mặt trận Juventus gặp Barca, l&uacute;c 3h00 ng&agrave;y 29/10 (giờ H&agrave; Nội).</p><p>Ronaldo được th&ocirc;ng b&aacute;o nhiễm nCoV từ 13/10. Anh sau đ&oacute; trở về Italy tr&ecirc;n chuyến bay cứu hộ v&agrave; tự c&aacute;ch ly trong biệt thự tại Turin. H&ocirc;m 22/10, si&ecirc;u sao 35 tuổi x&eacute;t nghiệm lần hai v&agrave; kết quả l&agrave; dương t&iacute;nh.</p>', 58, 0, 'boards', 'private', 1, 1, 0, '2020-10-27 18:27:16', '2020-11-23 08:37:08'),
(66, 'HLV Chung Hae Seong trở lại, Minh Phương r', 'HLV Chung Hae Seong trở lại, Minh Phương rời TP HCM', '<p>HLV Chung Hae Seong trở lại, Minh Phương rời TP HCM</p>', 58, 0, 'boards', 'public', 0, 2, 0, '2020-10-27 18:27:38', '2020-11-19 10:09:54'),
(68, 'Khách bị lừa tiền khi đặt homestay \'ma\' ở Đà Lạ', 'Homestay ở Đà Lạt đã chuyển nhượng kinh doanh, nhưng người quản lý trước lợi dụng kênh đặt phòng cũ để nhận tiền cọc của khách.', '<p>Tối 23/10, Hải Nam, một du kh&aacute;ch TP HCM (*), li&ecirc;n hệ qua fanpage của homestay The Nakedsoul để đặt ph&ograve;ng. Ph&iacute;a cơ sở lưu tr&uacute; phản hồi, th&ocirc;ng b&aacute;o gi&aacute; ph&ograve;ng, dịch vụ v&agrave; c&aacute;ch thức giao dịch. Nam c&oacute; nhu cầu đặt ph&ograve;ng 4 đ&ecirc;m, tổng chi ph&iacute; l&agrave; 1,6 triệu đồng, đ&atilde; thanh to&aacute;n to&agrave;n bộ số tiền tr&ecirc;n d&ugrave; ph&iacute;a cơ sở lưu tr&uacute; chỉ y&ecirc;u cầu đặt cọc một nửa.</p><p>Tuy nhi&ecirc;n, sau khi Nam chuyển khoản, đại diện The Nakedsoul kh&ocirc;ng trả lời tin nhắn hay phản hồi bằng bất cứ h&igrave;nh thức n&agrave;o để x&aacute;c nhận giao dịch của kh&aacute;ch. Đồng thời, người n&agrave;y chặn t&agrave;i khoản của Nam n&ecirc;n anh kh&ocirc;ng thể gửi tin nhắn.</p><p>Nam chia sẻ trường hợp của m&igrave;nh tr&ecirc;n một số cộng đồng du lịch tr&ecirc;n mạng x&atilde; hội, kh&ocirc;ng &iacute;t người từng rơi v&agrave;o t&igrave;nh cảnh tương tự đ&atilde; l&ecirc;n tiếng. Những du kh&aacute;ch n&agrave;y c&ugrave;ng trao đổi th&ocirc;ng tin để tổng hợp chứng cứ, tr&igrave;nh b&aacute;o c&ocirc;ng an. Trong đ&oacute; c&oacute; Nguyễn Phương Anh (quận T&acirc;n B&igrave;nh, TP HCM) cũng từng mất oan 1,3 triệu đồng tiền ph&ograve;ng. Phương Anh cho biết chị thấy b&agrave;i quảng c&aacute;o homestay n&agrave;y tr&ecirc;n Facebook. Nơi n&agrave;y c&oacute; view đẹp, khoảng s&acirc;n l&agrave;m tiệc nướng, ph&ograve;ng rộng, gi&aacute; phải chăng, ph&ugrave; hợp với nhu cầu n&ecirc;n chị đặt ph&ograve;ng. Thanh to&aacute;n xong, Phương Anh cũng kh&ocirc;ng thể li&ecirc;n hệ với chủ homestay.</p><p>Thực tế, cơ sở hạ tầng của The Nakedsoul đ&atilde; được sang nhượng cho chủ mới, đổi t&ecirc;n th&agrave;nh Niebo Homestay Đ&agrave; Lạt từ th&aacute;ng 4/2020. Sau đ&oacute;, admin cũ tiếp tục lợi dụng fanpage cũ để nhận tiền đặt cọc ph&ograve;ng của kh&aacute;ch mới. Nhiều du kh&aacute;ch đến nơi mới vỡ lở m&igrave;nh đ&atilde; chuyển tiền cho chủ cũ.</p><p>Nhận ph&agrave;n n&agrave;n từ nhiều kh&aacute;ch, Vũ T&ugrave;ng, chủ của homestay mới, đăng đ&iacute;nh ch&iacute;nh tr&ecirc;n fanpage rằng anh kh&ocirc;ng li&ecirc;n quan đến thương hiệu cũ v&agrave; cũng kh&ocirc;ng thể hỗ trợ nếu kh&aacute;ch bị lừa. Vũ T&ugrave;ng mong c&aacute;c nạn nh&acirc;n th&ocirc;ng cảm, v&agrave; k&ecirc;u gọi mọi người b&aacute;o c&aacute;o fanpage cũ với ban quản trị Facebook, nhằm tr&aacute;nh th&ecirc;m trường hợp đ&aacute;ng tiếc xảy ra.</p>', 58, 0, 'boards', 'private', 0, 1, 0, '2020-10-27 19:10:50', '2020-11-18 10:45:07'),
(105, '\'Cửa thắng\' nào cho Trump và Biden?', '\"Cửa thắng\" vẫn được chia cho cả Trump và Biden, song Biden có nhiều cách hơn và dường như đang dần giành ưu thế tại các bang chiến trường.', '<p>Biden hiện c&oacute; 264 phiếu đại cử tri v&agrave; chỉ c&ograve;n thiếu 6 phiếu để đắc cử, theo dự b&aacute;o của AP v&agrave; Fox News. C&aacute;c h&atilde;ng tin kh&aacute;c cho rằng Biden chưa thắng ở bang Arizona, n&ecirc;n mới chỉ t&iacute;nh cho &ocirc;ng c&oacute; 253 phiếu đại cử tri.</p>\r\n\r\n<p>Trump hiện c&oacute; 214 phiếu v&agrave; chắc chắn c&oacute; th&ecirc;m ba phiếu đại cử tri tại bang Alaska, d&ugrave; bang n&agrave;y chưa kiểm phiếu xong. Bốn bang nữa hiện vẫn kiểm phiếu l&agrave; Nevada, Bắc Carolina, Georgia v&agrave; Pennsylvania.</p>\r\n\r\n<p><img alt=\"Tổng thống Mỹ Donald Trump (phải) và ứng viên tổng thống đảng Dân chủ Joe Biden. Ảnh: AFP.\" src=\"https://i1-vnexpress.vnecdn.net/2020/11/06/trump-biden-1-9516-1604640430.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=3_n_sadECRqilIbS4uLE-Q\" /></p>\r\n\r\n<p>Tổng thống Mỹ Donald Trump (phải) v&agrave; ứng vi&ecirc;n tổng thống đảng D&acirc;n chủ Joe Biden. Ảnh:&nbsp;<em>AFP</em>.</p>\r\n\r\n<p>Để t&aacute;i đắc cử, Trump cần th&ecirc;m 53 phiếu đại cử tri. Để c&oacute; số phiếu n&agrave;y, &ocirc;ng cần thắng tại Pennsylvania v&agrave; th&ecirc;m ba bang kh&aacute;c. Tuy nhi&ecirc;n, tỷ lệ phiếu bầu khổng lồ cho đảng D&acirc;n chủ vẫn đang được kiểm ở c&aacute;c hạt Philadelphia v&agrave; Pittsburgh, đồng nghĩa Trump c&oacute; thể gặp kh&oacute; khăn trong việc duy tr&igrave; ưu thế tại Pennsylvania, Georgia v&agrave; Bắc Carolina.</p>\r\n\r\n<p>Biden rộng cửa đến với chiến thắng hơn, đặc biệt nếu &ocirc;ng thắng ở Pennsylvania, bang c&oacute; 20 phiếu đại cử tri. Nếu thua ở Pennsylvania, Biden vẫn c&oacute; thể gi&agrave;nh chiến thắng bằng c&aacute;ch thắng ở Nevada, nơi &ocirc;ng đang dẫn trước hơn 11.000 phiếu, đồng thời kh&ocirc;ng bị Trump &quot;lật ngược t&igrave;nh thế&quot; ở bang Arizona.</p>\r\n\r\n<p>Tổng thống Mỹ li&ecirc;n tục c&aacute;o buộc c&oacute; gian lận bầu cử tại c&aacute;c bang n&agrave;y v&agrave; y&ecirc;u cầu dừng qu&aacute; tr&igrave;nh kiểm phiếu bầu qua thư. Chiến dịch của &ocirc;ng đ&atilde; đệ đơn kiện bang Pennsylvania, Michigan v&agrave; Georgia, nhưng bị thẩm ph&aacute;n ở c&aacute;c bang b&aacute;c bỏ.</p>\r\n\r\n<p><strong>264</strong></p>\r\n\r\n<p><strong>Joe Biden</strong>Đảng D&acirc;n chủ</p>\r\n\r\n<p><a href=\"javascript:;\">270 phiếu để thắng&nbsp;</a></p>\r\n\r\n<p><strong>214</strong></p>\r\n\r\n<p><strong>Donald Trump</strong>Đảng Cộng h&ograve;a</p>\r\n\r\n<p><strong>264</strong><strong>214</strong></p>\r\n\r\n<p>VA 13PA 20TN 11WV 5NV 6TX 38NH 4NY 29HI 4VT 3NM 5NC 15ND 3NE 5LA 8SD 3FL 29CT 7WA 12KS 6WI 10OR 7KY 8ME 4OH 18OK 7ID 4WY 3UT 6IN 11IL 20AK 3NJ 14CO 9MA 11AL 9MO 10MN 10CA 55IA 6MI 16GA 16AZ 11MT 3MS 6SC 9AR 6</p>\r\n\r\n<p>+</p>\r\n\r\n<p>&minus;</p>\r\n\r\n<p><a href=\"javascript:;\">D&acirc;n chủ</a></p>\r\n\r\n<p><a href=\"javascript:;\">Chưa c&oacute; kết quả</a></p>\r\n\r\n<p><a href=\"javascript:;\">Chia phiếu</a></p>\r\n\r\n<p><a href=\"javascript:;\">Cộng h&ograve;a</a></p>\r\n\r\n<p>Nguồn:&nbsp;<em>AP, Fox News</em></p>', 73, 0, 'changelog', 'public', 0, 0, 0, '2020-11-06 07:24:02', '2020-11-12 01:21:24'),
(108, '123', NULL, NULL, 58, 0, 'roadmaps', 'public', 0, 0, 1, '2020-11-09 02:23:08', '2020-11-20 08:49:06'),
(118, 'sffsa', NULL, NULL, 58, 0, 'roadmaps', 'verified', 0, 0, 0, '2020-11-10 05:00:10', '2020-11-21 01:15:45'),
(124, 'HLV Chung Hae Seong trở lại, Minh Phương rời TP HCM', NULL, '<p>test</p>', 58, 0, 'changelog', 'public', 0, 0, 0, '2020-11-11 02:01:53', '2020-11-11 03:13:22'),
(125, 'test changelog', NULL, '<p>hmmmm?</p>', 58, 0, 'changelog', 'private', 0, 0, 0, '2020-11-11 05:01:11', '2020-11-13 06:51:24'),
(126, 'changelog hmmmm', NULL, '<p>changelog hmmmm</p>', 58, 0, 'changelog', 'pending', 0, 0, 0, '2020-11-11 07:18:14', '2020-11-19 01:57:40'),
(128, '12312321421', NULL, NULL, 58, 0, 'roadmaps', 'private', 0, 0, 0, '2020-11-12 04:25:58', '2020-11-21 01:15:37'),
(129, 'test post verified', NULL, '<p>test post verified</p>', 58, 0, 'boards', 'pending', 0, 2, 0, '2020-11-13 02:21:50', '2020-11-18 10:17:26'),
(131, 'Hiện trạng rừng ở Việt Nam', NULL, '<p>Chuy&ecirc;n gia nhận định Việt Nam đ&atilde; ho&agrave;n th&agrave;nh tốt vai tr&ograve; chủ tịch ASEAN, đồng thời tạo cầu nối giữa khối v&agrave; c&aacute;c nước đối t&aacute;c tr&ecirc;n thế giới.</p><p>Tại lễ bế bạc Hội nghị Cấp cao ASEAN lần thứ 37 chiều 15/11, Thủ tướng Nguyễn Xu&acirc;n Ph&uacute;c đ&atilde; trao b&uacute;a gỗ đại diện chức chủ tịch ASEAN cho Đại sứ Brunei tại Việt Nam, đ&aacute;nh dấu chuyển giao chức chủ tịch ASEAN năm 2021 cho nước n&agrave;y. 2020 l&agrave; một năm nhiều kh&oacute; khăn, th&aacute;ch thức đối với thế giới n&oacute;i chung v&agrave; ASEAN n&oacute;i ri&ecirc;ng, khi Covid-19 g&acirc;y khủng hoảng &quot;tứ bề&quot;.</p><p>&quot;Chưa bao giờ ASEAN gặp th&aacute;ch thức như vậy, khi phải đối mặt với cuộc khủng hoảng song tr&ugrave;ng cả về y tế, kinh tế v&agrave; x&atilde; hội&quot;, cựu đại sứ Việt Nam tại Mỹ Phạm Quang Vinh chia sẻ với&nbsp;<em>VnExpress.</em>&nbsp;Điều n&agrave;y đ&atilde; khiến Việt Nam phải đối mặt với rất nhiều kh&oacute; khăn để thực hiện vai tr&ograve; chủ tịch của ASEAN.</p><p>Tuy nhi&ecirc;n, &ocirc;ng Vinh cho rằng Việt Nam vẫn ho&agrave;n th&agrave;nh tốt vai tr&ograve; của m&igrave;nh khi &quot;duy tr&igrave; hoạt động của ASEAN, kh&ocirc;ng chỉ ứng ph&oacute; với những chuyện cấp b&aacute;ch như dịch bệnh, y tế, m&agrave; vẫn bảo đảm được ưu ti&ecirc;n của 2020 đ&atilde; đề ra như về li&ecirc;n kết, vai tr&ograve; trung t&acirc;m của ASEAN, quan hệ đối t&aacute;c hay xử l&yacute; đa th&aacute;ch thức&quot;.</p>', 73, 0, 'boards', 'public', 0, 3, 0, '2020-11-17 04:04:16', '2020-11-18 03:09:54'),
(137, 'Bồ Đào Nha thắng ngược nhờ cú đúp của trung vệ', NULL, '<p>Ruben Dias hai lần lập c&ocirc;ng khi Bồ Đ&agrave;o Nha thắng Croatia 3-2 ở lượt trận cuối bảng A3 Nations League, tối 17/11.</p>', 73, 0, 'boards', 'public', 3, 1, 0, '2020-11-18 02:29:56', '2020-11-23 02:55:44'),
(138, 'Oanh tạc cơ Mỹ áp sát ADIZ Trung Quốc áp đặt', NULL, '<p>Hai oanh tạc cơ B-1B Lancer của kh&ocirc;ng qu&acirc;n Mỹ tiến v&agrave;o v&ugrave;ng nhận dạng ph&ograve;ng kh&ocirc;ng Trung Quốc &aacute;p đặt tr&ecirc;n biển Hoa Đ&ocirc;ng.</p><p>Theo dữ liệu của Aircraft Spots, chuy&ecirc;n trang theo d&otilde;i m&aacute;y bay tr&ecirc;n thế giới, hai oanh tạc cơ B-1B Mỹ xuất ph&aacute;t từ căn cứ kh&ocirc;ng qu&acirc;n Andersen tr&ecirc;n đảo Guam s&aacute;ng nay, sau đ&oacute; tiến v&agrave;o v&ugrave;ng nhận dạng ph&ograve;ng kh&ocirc;ng (ADIZ) Trung Quốc &aacute;p đặt tr&ecirc;n biển Hoa Đ&ocirc;ng. C&aacute;c oanh tạc cơ Mỹ tiếp nhi&ecirc;n liệu tr&ecirc;n kh&ocirc;ng trong qu&aacute; tr&igrave;nh thực hiện nhiệm vụ n&agrave;y.</p><p>Theo quy tắc quốc tế, m&aacute;y bay nước ngo&agrave;i đi qua ADIZ của nước n&agrave;o cần th&ocirc;ng b&aacute;o lịch tr&igrave;nh bay từ trước cho cơ quan li&ecirc;n quan nước đ&oacute;, nhưng Mỹ v&agrave; Nhật Bản đều kh&ocirc;ng c&ocirc;ng nhận ADIZ Trung Quốc đơn phương tuy&ecirc;n bố tr&ecirc;n biển Hoa Đ&ocirc;ng.</p>', 73, 0, 'boards', 'public', 0, 1, 0, '2020-11-18 02:56:37', '2020-11-20 09:25:33'),
(139, 'Tổng bí thư, Chủ tịch nước: \'Đại đoàn kết dân tộc có ý nghĩa sống còn\'', NULL, '<p>Đại đo&agrave;n kết d&acirc;n tộc l&agrave; chủ trương chiến lược, c&oacute; &yacute; nghĩa sống c&ograve;n v&agrave; quyết định sự th&agrave;nh bại của c&aacute;ch mạng, theo Tổng b&iacute; thư, Chủ tịch nước Nguyễn Ph&uacute; Trọng.</p><p>S&aacute;ng 18/11, ph&aacute;t biểu tại lễ kỷ niệm 90 năm Ng&agrave;y th&agrave;nh lập Mặt trận D&acirc;n tộc thống nhất Việt Nam - Ng&agrave;y truyền thống Mặt trận Tổ quốc Việt Nam (18/11/1930-18/11/2020), Tổng b&iacute; thư, Chủ tịch nước Nguyễn Ph&uacute; Trọng nhấn mạnh đo&agrave;n kết l&agrave; truyền thống qu&yacute; b&aacute;u, l&agrave;m n&ecirc;n sức mạnh của d&acirc;n tộc Việt Nam.</p><p>&quot;Suốt 90 năm qua, dưới sự l&atilde;nh đạo của Đảng, Mặt trận D&acirc;n tộc Thống nhất Việt Nam đ&atilde; ra sức hoạt động, khơi dậy tinh thần y&ecirc;u nước, ph&aacute;t huy sức mạnh vĩ đại của khối đại đo&agrave;n kết d&acirc;n tộc, kết hợp với sức mạnh của thời đại, g&oacute;p sức đưa con thuyền c&aacute;ch mạng Việt Nam đi từ thắng lợi n&agrave;y đến thắng lợi kh&aacute;c&quot;, Tổng b&iacute; thư, Chủ tịch nước n&ecirc;u r&otilde;.</p><p>Biểu dương những bước ph&aacute;t triển của Mặt trận qua c&aacute;c chặng đường lịch sử, tuy nhi&ecirc;n, Tổng b&iacute; thư, Chủ tịch nước cũng thẳng thắn nh&igrave;n nhận sức mạnh đại đo&agrave;n kết to&agrave;n d&acirc;n tộc chưa được ph&aacute;t huy đầy đủ; hoạt động của Mặt trận v&agrave; c&aacute;c đo&agrave;n thể nh&acirc;n d&acirc;n c&aacute;c cấp c&oacute; l&uacute;c, c&oacute; nơi chưa s&acirc;u s&aacute;t...</p>', 73, 0, 'boards', 'pending', 0, 0, 0, '2020-11-18 10:27:00', '2020-11-18 10:34:53'),
(140, 'Đoàn Văn Hậu', NULL, NULL, 73, 0, 'roadmaps', 'public', 0, 0, 0, '2020-11-20 08:46:17', '2020-11-20 08:48:41'),
(141, 'Biden cam kết không đóng cửa nền kinh tế Mỹ', NULL, '<p>Joe Biden cam kết kh&ocirc;ng đ&oacute;ng cửa nền kinh tế khi Mỹ tiếp tục chiến đấu với đại dịch Covid-19, nhưng c&oacute; thể &aacute;p lệnh đeo khẩu trang to&agrave;n quốc.</p><p>&quot;T&ocirc;i sẽ kh&ocirc;ng đ&oacute;ng cửa nền kinh tế, chấm hết. T&ocirc;i sẽ chặn đứng Covid-19. Đ&oacute; l&agrave; những g&igrave; t&ocirc;i sẽ ngăn chặn&quot;, Tổng thống đắc cử Joe Biden ph&aacute;t biểu trong cuộc họp b&aacute;o ở th&agrave;nh phố Wilmington, bang Delaware, h&ocirc;m 19/11. &quot;Sẽ kh&ocirc;ng c&oacute; đ&oacute;ng cửa to&agrave;n quốc, v&igrave; mỗi v&ugrave;ng, mỗi khu vực, mỗi cộng đồng c&oacute; thể kh&aacute;c nhau. V&igrave; thế sẽ kh&ocirc;ng c&oacute; chuyện t&ocirc;i xem x&eacute;t y&ecirc;u cầu đ&oacute;ng cửa to&agrave;n quốc ho&agrave;n to&agrave;n. T&ocirc;i nghĩ điều đ&oacute; sẽ phản t&aacute;c dụng&quot;.</p><p>Biden cảnh b&aacute;o Mỹ vẫn đang ở trong khủng hoảng Covid-19 v&agrave; &quot;một m&ugrave;a đ&ocirc;ng đen tối vẫn ở ph&iacute;a trước&quot;. Nước n&agrave;y l&agrave; v&ugrave;ng dịch lớn nhất thế giới với hơn 12 triệu ca nhiễm nCoV, trong đ&oacute; hơn 250.000 người tử vong.</p><p>&quot;C&oacute; những chiếc ghế trống tại b&agrave;n ăn tối, vốn l&agrave; chỗ của những người th&acirc;n y&ecirc;u, gia đ&igrave;nh v&agrave; bạn b&egrave;, những người cười đ&ugrave;a v&agrave; tr&ograve; chuyện c&ugrave;ng nhau chỉ c&aacute;ch đ&acirc;y v&agrave;i ng&agrave;y hay v&agrave;i tuần. Jill v&agrave; t&ocirc;i xin gửi y&ecirc;u thương v&agrave; nguyện cầu đến những gia đ&igrave;nh v&agrave; bạn b&egrave; bị bỏ lại ph&iacute;a sau&quot;.</p>', 73, 0, 'boards', 'public', 0, 1, 0, '2020-11-20 09:28:21', '2020-11-20 09:28:26');

-- --------------------------------------------------------

--
-- Table structure for table `terms`
--

CREATE TABLE `terms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `term_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `show` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `terms`
--

INSERT INTO `terms` (`id`, `name`, `slug`, `term_description`, `type`, `parent`, `image`, `status`, `show`, `created_at`, `updated_at`) VALUES
(1, 'new', 'new', '#00bd09', 'status', 0, NULL, 'public', 0, '2020-11-07 08:38:33', '2020-11-07 08:38:33'),
(45, 'chiến a', 'chien-a', '', 'tag', 0, NULL, '', 0, '2020-10-21 19:04:33', '2020-10-21 19:04:33'),
(69, 'tổng thống', 'tong-thong', '', 'tag', 0, NULL, '', 0, '2020-10-22 21:33:16', '2020-10-22 21:33:16'),
(86, 'champions league', 'champions-league', '', 'tag', 0, NULL, '', 0, '2020-10-27 18:27:16', '2020-10-27 18:27:16'),
(97, 'đà lạt', 'da-lat', '', 'tag', 0, NULL, '', 0, '2020-10-29 18:30:57', '2020-10-29 18:30:57'),
(98, 'lừa đảo', 'lua-dao', '', 'tag', 0, NULL, '', 0, '2020-10-29 18:30:57', '2020-10-29 18:30:57'),
(99, 'default boards', 'default-categories', '', 'category', 0, '2020/10/61Gh-4LQXSL._SS210_.jpg', 'public', 1, '2020-10-29 19:44:02', '2020-10-29 20:33:24'),
(107, 'status test', 'status-test', '#fad000', 'status', 0, NULL, 'public', 0, '2020-11-09 05:03:58', '2020-11-12 03:29:01'),
(118, 'markus davis', 'markus-davis', '', 'category', 0, '2020/11/nganh-chinh-tri-hoc.jpg', 'verified', 1, '2020-11-10 08:45:51', '2020-11-20 09:05:58'),
(121, 'new', 'new', '#00bd09', 'category', 99, NULL, 'active', 0, '2020-11-10 09:37:27', '2020-11-10 09:37:27'),
(123, 'fixed', 'fixed', '#E69C9A', 'category', 99, NULL, 'public', 0, '2020-11-10 09:45:09', '2020-11-10 09:49:18'),
(124, 'improved', 'improved', '#8FC6DC', 'category', 99, NULL, 'public', 0, '2020-11-10 09:45:16', '2020-11-10 09:49:12'),
(125, 'announced', 'announced', '#A19FE0', 'category', 99, NULL, 'public', 0, '2020-11-10 09:46:18', '2020-11-10 09:46:47'),
(128, '2lsc', '2lsc', '#f250ae', 'status', 0, NULL, 'public', 0, '2020-11-13 07:36:02', '2020-11-13 07:36:02'),
(129, 'abcd', 'abcd', NULL, 'category', 0, NULL, 'public', 1, '2020-11-18 03:36:30', '2020-11-20 09:23:04'),
(130, 'changelog', 'changelog', 'changelog', 'changelog', 0, NULL, 'verified', 0, '2020-11-18 04:03:38', '2020-11-18 04:03:38');

-- --------------------------------------------------------

--
-- Table structure for table `term_relationships`
--

CREATE TABLE `term_relationships` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `term_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `term_relationships`
--

INSERT INTO `term_relationships` (`id`, `post_id`, `term_id`) VALUES
(401, 105, 121),
(402, 105, 69),
(403, 124, 121),
(404, 124, 45),
(465, 125, 123),
(519, 65, 107),
(520, 65, 86),
(528, 131, 69),
(539, 137, 99),
(540, 137, 1),
(541, 138, 99),
(542, 138, 1),
(546, 65, 99),
(547, 131, 99),
(555, 64, 118),
(556, 64, 1),
(557, 63, 118),
(558, 63, 1),
(559, 66, 129),
(560, 66, 128),
(571, 129, 118),
(572, 129, 1),
(575, 139, 99),
(576, 139, 1),
(577, 68, 129),
(578, 68, 107),
(589, 126, 125),
(590, 126, 98),
(597, 140, 1),
(598, 140, 107),
(599, 140, 128),
(609, 108, 1),
(610, 108, 107),
(611, 108, 99),
(612, 108, 118),
(613, 141, 99),
(614, 141, 1),
(615, 128, 1),
(616, 128, 107),
(617, 128, 99),
(618, 118, 1),
(619, 118, 107),
(620, 118, 128),
(621, 118, 99),
(622, 118, 118),
(623, 118, 129);

-- --------------------------------------------------------

--
-- Table structure for table `usermeta`
--

CREATE TABLE `usermeta` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `usermeta`
--

INSERT INTO `usermeta` (`id`, `user_id`, `meta_key`, `meta_value`) VALUES
(5, 58, 'provider_name', 'google'),
(6, 58, 'provider_id', '116300729521988274614'),
(19, 69, 'provider_name', 'google'),
(20, 69, 'provider_id', '116150522917285606733'),
(24, 73, 'vote_post', '66'),
(32, 71, 'vote_post', '129'),
(38, 122, 'vote_post', '131'),
(39, 71, 'vote_post', '131'),
(40, 73, 'vote_post', '68'),
(48, 73, 'vote_post', '131'),
(49, 73, 'vote_post', '129'),
(54, 33, 'vote_post', '64'),
(55, 33, 'vote_post', '66'),
(57, 33, 'vote_post', '137'),
(69, 73, 'vote_post', '64'),
(70, 73, 'vote_post', '138'),
(71, 73, 'vote_post', '141'),
(72, 73, 'vote_post', '65');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` int(11) DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(1) DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `confirmed` tinyint(1) DEFAULT NULL,
  `confirmation_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `address`, `avatar`, `role`, `status`, `remember_token`, `confirmed`, `confirmation_code`, `created_at`, `updated_at`) VALUES
(33, 'cấn văn chiến', 'c@gmail.com', '$2y$10$ERosbpsM3YMuNkJUSMKV8eHGvg3yo2qlSzcK0svGrCKkR3W7qshRe', 347214898, 'thach that ha noi', '', 0, 1, NULL, 0, 'afe029fb536e8533aac8dd5010736351', '2020-10-12 18:48:58', '2020-11-21 07:20:08'),
(58, 'chiến cấn', 'canchien0112@gmail.com', '$2y$10$pmsggrX0DIRiVMbqaI/Ar.fY.7EGoFI3fn/Ii5wcNtJ0aTltuz8hO', NULL, NULL, '2020/11/test.jpg', 1, 1, 'v41gTtx1qBCPVHuTljWIxwmhE1RxzBTRTInmtpKdy5mryAeVGQY8Yrgw6Fy5', 1, 'fd55aac15d01680b4cbdca9e774e066b', '2020-10-26 20:50:29', '2020-11-21 03:55:36'),
(69, 'chiến', 'canchien123@gmail.com', '$2y$10$x/qd6mUyplPfCQU9fGfsceyXeYYRZ.7iv4fyqhk0C2Fj2bWk3U6zW', 347214898, NULL, '', 0, 1, 'fCpecjHe7AO09QeuPH3b9EclSvnziYBNQL7opiHD7bQg2buBi9mFtzw1l1Sl', 1, '2241eed86333c6c79186f8619f36b8df', '2020-10-29 19:17:05', '2020-11-21 03:55:35'),
(71, 'Cristiano Ronaldo', 'g@gmail.com', '$2y$10$H5i5RecWzomOxwRpcKnW..fkiI1WuexPbuvu1/iS6X.QFpqvp48kC', NULL, NULL, '2020/11/skysports-cristiano-ronaldo-51-7794-6910-1603840369.jpg', 0, 0, NULL, 1, '7642ebc801443c6e65557df3585bf6c6', '2020-10-30 02:14:03', '2020-11-21 07:20:12'),
(73, 'cấn văn chiến', 'admin@gmail.com', '$2y$10$qEJG4kdllYxuiKOtVnFRKejBbA6Ra/PfOwF9XDe/U5f5tDPpnjhSS', NULL, NULL, '2020/11/messi_cuvn.jpg', 2, 1, NULL, 1, '2ff4355ffb1862733c9bb109412aaac3', '2020-10-30 02:17:51', '2020-11-23 01:42:46'),
(122, 'fsaf', 'chiena99@gmail.com', '$2y$10$FSewxRx991.dJ3Eo18MZD.dxvhDMh8CLxm28y7D8/A36rOIpe8JpS', NULL, NULL, NULL, 0, 1, '4vxNuv6FUPMF9JFBK3ftWyYfxVBI1fiWTLWtktx9nNBs8NNWFOiU0XopcsCY', 1, '6348d282d6c56ef4930356bd77bd29ad', '2020-11-16 07:22:17', '2020-11-21 03:55:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_post_id_foreign` (`post_id`),
  ADD KEY `comments_author_foreign` (`author`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `postmeta`
--
ALTER TABLE `postmeta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `postmeta_post_id_foreign` (`post_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author` (`author`);

--
-- Indexes for table `terms`
--
ALTER TABLE `terms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `term_relationships`
--
ALTER TABLE `term_relationships`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `term_id` (`term_id`);

--
-- Indexes for table `usermeta`
--
ALTER TABLE `usermeta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usermeta_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `postmeta`
--
ALTER TABLE `postmeta`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;

--
-- AUTO_INCREMENT for table `terms`
--
ALTER TABLE `terms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- AUTO_INCREMENT for table `term_relationships`
--
ALTER TABLE `term_relationships`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=624;

--
-- AUTO_INCREMENT for table `usermeta`
--
ALTER TABLE `usermeta`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_author_foreign` FOREIGN KEY (`author`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `comments_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`);

--
-- Constraints for table `postmeta`
--
ALTER TABLE `postmeta`
  ADD CONSTRAINT `postmeta_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`author`) REFERENCES `users` (`id`) ON DELETE NO ACTION;

--
-- Constraints for table `term_relationships`
--
ALTER TABLE `term_relationships`
  ADD CONSTRAINT `term_relationships_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE NO ACTION,
  ADD CONSTRAINT `term_relationships_ibfk_3` FOREIGN KEY (`term_id`) REFERENCES `terms` (`id`);

--
-- Constraints for table `usermeta`
--
ALTER TABLE `usermeta`
  ADD CONSTRAINT `usermeta_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 07-03-2019 a las 12:42:57
-- Versión del servidor: 5.7.25-0ubuntu0.16.04.2
-- Versión de PHP: 7.0.33-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `BaseBD`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Account`
--

CREATE TABLE `Account` (
  `AccountID` int(11) NOT NULL,
  `AuditDate` datetime DEFAULT NULL,
  `AuditUser` varchar(16) DEFAULT NULL,
  `AuditMessage` text,
  `IsActive` tinyint(4) DEFAULT NULL,
  `ParentAccount` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `Account`
--

INSERT INTO `Account` (`AccountID`, `AuditDate`, `AuditUser`, `AuditMessage`, `IsActive`, `ParentAccount`) VALUES
(207, '2017-07-26 00:00:00', 'User', NULL, 1, NULL),
(212, '2019-03-07 12:35:03', 'System', 'New User', 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Agency`
--

CREATE TABLE `Agency` (
  `AgencyID` int(11) NOT NULL,
  `FirstName` varchar(32) DEFAULT NULL,
  `LastName` varchar(32) DEFAULT NULL,
  `Address1` varchar(128) DEFAULT NULL,
  `Address2` varchar(128) DEFAULT NULL,
  `BusinessPhone` varchar(16) DEFAULT NULL,
  `Extension` varchar(8) DEFAULT NULL,
  `Country` int(11) DEFAULT NULL,
  `City` varchar(16) DEFAULT NULL,
  `State` char(2) DEFAULT NULL,
  `CompanyName` varchar(32) DEFAULT NULL,
  `CompanyWebSite` varchar(256) DEFAULT NULL,
  `ZipCode` char(8) DEFAULT NULL,
  `AccountID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `Agency`
--

INSERT INTO `Agency` (`AgencyID`, `FirstName`, `LastName`, `Address1`, `Address2`, `BusinessPhone`, `Extension`, `Country`, `City`, `State`, `CompanyName`, `CompanyWebSite`, `ZipCode`, `AccountID`) VALUES
(1, 'Carlos', 'Gonzalez', 'direccion1 ', 'direccion2', '12325', '213215', 232, '', 've', 'Compania', 'google', '12354', 212);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Country`
--

CREATE TABLE `Country` (
  `CountryID` int(11) NOT NULL,
  `Abbreviation` varchar(2) NOT NULL,
  `Name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `Country`
--

INSERT INTO `Country` (`CountryID`, `Abbreviation`, `Name`) VALUES
(1, 'AF', 'Afganistán'),
(2, 'AX', 'Islas Gland'),
(3, 'AL', 'Albania'),
(4, 'DE', 'Alemania'),
(5, 'AD', 'Andorra'),
(6, 'AO', 'Angola'),
(7, 'AI', 'Anguilla'),
(8, 'AQ', 'Antártida'),
(9, 'AG', 'Antigua y Barbuda'),
(10, 'AN', 'Antillas Holandesas'),
(11, 'SA', 'Arabia Saudí'),
(12, 'DZ', 'Argelia'),
(13, 'AR', 'Argentina'),
(14, 'AM', 'Armenia'),
(15, 'AW', 'Aruba'),
(16, 'AU', 'Australia'),
(17, 'AT', 'Austria'),
(18, 'AZ', 'Azerbaiyán'),
(19, 'BS', 'Bahamas'),
(20, 'BH', 'Bahréin'),
(21, 'BD', 'Bangladesh'),
(22, 'BB', 'Barbados'),
(23, 'BY', 'Bielorrusia'),
(24, 'BE', 'Bélgica'),
(25, 'BZ', 'Belice'),
(26, 'BJ', 'Benin'),
(27, 'BM', 'Bermudas'),
(28, 'BT', 'Bhután'),
(29, 'BO', 'Bolivia'),
(30, 'BA', 'Bosnia y Herzegovina'),
(31, 'BW', 'Botsuana'),
(32, 'BV', 'Isla Bouvet'),
(33, 'BR', 'Brasil'),
(34, 'BN', 'Brunéi'),
(35, 'BG', 'Bulgaria'),
(36, 'BF', 'Burkina Faso'),
(37, 'BI', 'Burundi'),
(38, 'CV', 'Cabo Verde'),
(39, 'KY', 'Islas Caimán'),
(40, 'KH', 'Camboya'),
(41, 'CM', 'Camerún'),
(42, 'CA', 'Canadá'),
(43, 'CF', 'República Centroafricana'),
(44, 'TD', 'Chad'),
(45, 'CZ', 'República Checa'),
(46, 'CL', 'Chile'),
(47, 'CN', 'China'),
(48, 'CY', 'Chipre'),
(49, 'CX', 'Isla de Navidad'),
(50, 'VA', 'Ciudad del Vaticano'),
(51, 'CC', 'Islas Cocos'),
(52, 'CO', 'Colombia'),
(53, 'KM', 'Comoras'),
(54, 'CD', 'República Democrática del Congo'),
(55, 'CG', 'Congo'),
(56, 'CK', 'Islas Cook'),
(57, 'KP', 'Corea del Norte'),
(58, 'KR', 'Corea del Sur'),
(59, 'CI', 'Costa de Marfil'),
(60, 'CR', 'Costa Rica'),
(61, 'HR', 'Croacia'),
(62, 'CU', 'Cuba'),
(63, 'DK', 'Dinamarca'),
(64, 'DM', 'Dominica'),
(65, 'DO', 'República Dominicana'),
(66, 'EC', 'Ecuador'),
(67, 'EG', 'Egipto'),
(68, 'SV', 'El Salvador'),
(69, 'AE', 'Emiratos Árabes Unidos'),
(70, 'ER', 'Eritrea'),
(71, 'SK', 'Eslovaquia'),
(72, 'SI', 'Eslovenia'),
(73, 'ES', 'España'),
(74, 'UM', 'Islas ultramarinas de Estados Unidos'),
(75, 'US', 'Estados Unidos'),
(76, 'EE', 'Estonia'),
(77, 'ET', 'Etiopía'),
(78, 'FO', 'Islas Feroe'),
(79, 'PH', 'Filipinas'),
(80, 'FI', 'Finlandia'),
(81, 'FJ', 'Fiyi'),
(82, 'FR', 'Francia'),
(83, 'GA', 'Gabón'),
(84, 'GM', 'Gambia'),
(85, 'GE', 'Georgia'),
(86, 'GS', 'Islas Georgias del Sur y Sandwich del Sur'),
(87, 'GH', 'Ghana'),
(88, 'GI', 'Gibraltar'),
(89, 'GD', 'Granada'),
(90, 'GR', 'Grecia'),
(91, 'GL', 'Groenlandia'),
(92, 'GP', 'Guadalupe'),
(93, 'GU', 'Guam'),
(94, 'GT', 'Guatemala'),
(95, 'GF', 'Guayana Francesa'),
(96, 'GN', 'Guinea'),
(97, 'GQ', 'Guinea Ecuatorial'),
(98, 'GW', 'Guinea-Bissau'),
(99, 'GY', 'Guyana'),
(100, 'HT', 'Haití'),
(101, 'HM', 'Islas Heard y McDonald'),
(102, 'HN', 'Honduras'),
(103, 'HK', 'Hong Kong'),
(104, 'HU', 'Hungría'),
(105, 'IN', 'India'),
(106, 'ID', 'Indonesia'),
(107, 'IR', 'Irán'),
(108, 'IQ', 'Iraq'),
(109, 'IE', 'Irlanda'),
(110, 'IS', 'Islandia'),
(111, 'IL', 'Israel'),
(112, 'IT', 'Italia'),
(113, 'JM', 'Jamaica'),
(114, 'JP', 'Japón'),
(115, 'JO', 'Jordania'),
(116, 'KZ', 'Kazajstán'),
(117, 'KE', 'Kenia'),
(118, 'KG', 'Kirguistán'),
(119, 'KI', 'Kiribati'),
(120, 'KW', 'Kuwait'),
(121, 'LA', 'Laos'),
(122, 'LS', 'Lesotho'),
(123, 'LV', 'Letonia'),
(124, 'LB', 'Líbano'),
(125, 'LR', 'Liberia'),
(126, 'LY', 'Libia'),
(127, 'LI', 'Liechtenstein'),
(128, 'LT', 'Lituania'),
(129, 'LU', 'Luxemburgo'),
(130, 'MO', 'Macao'),
(131, 'MK', 'ARY Macedonia'),
(132, 'MG', 'Madagascar'),
(133, 'MY', 'Malasia'),
(134, 'MW', 'Malawi'),
(135, 'MV', 'Maldivas'),
(136, 'ML', 'Malí'),
(137, 'MT', 'Malta'),
(138, 'FK', 'Islas Malvinas'),
(139, 'MP', 'Islas Marianas del Norte'),
(140, 'MA', 'Marruecos'),
(141, 'MH', 'Islas Marshall'),
(142, 'MQ', 'Martinica'),
(143, 'MU', 'Mauricio'),
(144, 'MR', 'Mauritania'),
(145, 'YT', 'Mayotte'),
(146, 'MX', 'México'),
(147, 'FM', 'Micronesia'),
(148, 'MD', 'Moldavia'),
(149, 'MC', 'Mónaco'),
(150, 'MN', 'Mongolia'),
(151, 'MS', 'Montserrat'),
(152, 'MZ', 'Mozambique'),
(153, 'MM', 'Myanmar'),
(154, 'NA', 'Namibia'),
(155, 'NR', 'Nauru'),
(156, 'NP', 'Nepal'),
(157, 'NI', 'Nicaragua'),
(158, 'NE', 'Níger'),
(159, 'NG', 'Nigeria'),
(160, 'NU', 'Niue'),
(161, 'NF', 'Isla Norfolk'),
(162, 'NO', 'Noruega'),
(163, 'NC', 'Nueva Caledonia'),
(164, 'NZ', 'Nueva Zelanda'),
(165, 'OM', 'Omán'),
(166, 'NL', 'Países Bajos'),
(167, 'PK', 'Pakistán'),
(168, 'PW', 'Palau'),
(169, 'PS', 'Palestina'),
(170, 'PA', 'Panamá'),
(171, 'PG', 'Papúa Nueva Guinea'),
(172, 'PY', 'Paraguay'),
(173, 'PE', 'Perú'),
(174, 'PN', 'Islas Pitcairn'),
(175, 'PF', 'Polinesia Francesa'),
(176, 'PL', 'Polonia'),
(177, 'PT', 'Portugal'),
(178, 'PR', 'Puerto Rico'),
(179, 'QA', 'Qatar'),
(180, 'GB', 'Reino Unido'),
(181, 'RE', 'Reunión'),
(182, 'RW', 'Ruanda'),
(183, 'RO', 'Rumania'),
(184, 'RU', 'Rusia'),
(185, 'EH', 'Sahara Occidental'),
(186, 'SB', 'Islas Salomón'),
(187, 'WS', 'Samoa'),
(188, 'AS', 'Samoa Americana'),
(189, 'KN', 'San Cristóbal y Nevis'),
(190, 'SM', 'San Marino'),
(191, 'PM', 'San Pedro y Miquelón'),
(192, 'VC', 'San Vicente y las Granadinas'),
(193, 'SH', 'Santa Helena'),
(194, 'LC', 'Santa Lucía'),
(195, 'ST', 'Santo Tomé y Príncipe'),
(196, 'SN', 'Senegal'),
(197, 'CS', 'Serbia y Montenegro'),
(198, 'SC', 'Seychelles'),
(199, 'SL', 'Sierra Leona'),
(200, 'SG', 'Singapur'),
(201, 'SY', 'Siria'),
(202, 'SO', 'Somalia'),
(203, 'LK', 'Sri Lanka'),
(204, 'SZ', 'Suazilandia'),
(205, 'ZA', 'Sudáfrica'),
(206, 'SD', 'Sudán'),
(207, 'SE', 'Suecia'),
(208, 'CH', 'Suiza'),
(209, 'SR', 'Surinam'),
(210, 'SJ', 'Svalbard y Jan Mayen'),
(211, 'TH', 'Tailandia'),
(212, 'TW', 'Taiwán'),
(213, 'TZ', 'Tanzania'),
(214, 'TJ', 'Tayikistán'),
(215, 'IO', 'Territorio Británico del Océano Índico'),
(216, 'TF', 'Territorios Australes Franceses'),
(217, 'TL', 'Timor Oriental'),
(218, 'TG', 'Togo'),
(219, 'TK', 'Tokelau'),
(220, 'TO', 'Tonga'),
(221, 'TT', 'Trinidad y Tobago'),
(222, 'TN', 'Túnez'),
(223, 'TC', 'Islas Turcas y Caicos'),
(224, 'TM', 'Turkmenistán'),
(225, 'TR', 'Turquía'),
(226, 'TV', 'Tuvalu'),
(227, 'UA', 'Ucrania'),
(228, 'UG', 'Uganda'),
(229, 'UY', 'Uruguay'),
(230, 'UZ', 'Uzbekistán'),
(231, 'VU', 'Vanuatu'),
(232, 'VE', 'Venezuela'),
(233, 'VN', 'Vietnam'),
(234, 'VG', 'Islas Vírgenes Británicas'),
(235, 'VI', 'Islas Vírgenes de los Estados Unidos'),
(236, 'WF', 'Wallis y Futuna'),
(237, 'YE', 'Yemen'),
(238, 'DJ', 'Yibuti'),
(239, 'ZM', 'Zambia'),
(240, 'ZW', 'Zimbabue'),
(241, 'UK', 'unknown');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Menu`
--

CREATE TABLE `Menu` (
  `MenuID` int(11) NOT NULL,
  `MenuName` varchar(74) NOT NULL,
  `ClassIcon` varchar(74) NOT NULL,
  `ControllerUse` varchar(74) NOT NULL,
  `Type` int(11) NOT NULL,
  `Path` varchar(74) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `Menu`
--

INSERT INTO `Menu` (`MenuID`, `MenuName`, `ClassIcon`, `ControllerUse`, `Type`, `Path`) VALUES
(1, 'Cofigurar Cuentas', 'fa-group', 'usuario', 0, NULL),
(4, 'Configurar Menú', 'fa-bars', 'menu', 1, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `MenuByRole`
--

CREATE TABLE `MenuByRole` (
  `MenuByRoleID` int(11) NOT NULL,
  `RoleID` int(11) NOT NULL,
  `MenuID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `MenuByRole`
--

INSERT INTO `MenuByRole` (`MenuByRoleID`, `RoleID`, `MenuID`) VALUES
(55, 1, 1),
(65, 1, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Page`
--

CREATE TABLE `Page` (
  `PageID` int(11) NOT NULL,
  `MenuID` int(11) NOT NULL,
  `PageName` varchar(64) DEFAULT NULL,
  `PagePath` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `Page`
--

INSERT INTO `Page` (`PageID`, `MenuID`, `PageName`, `PagePath`) VALUES
(93, 1, 'Cuentas', ''),
(94, 1, 'Roles', 'roles');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Role`
--

CREATE TABLE `Role` (
  `RoleID` int(11) NOT NULL,
  `RoleName` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `Role`
--

INSERT INTO `Role` (`RoleID`, `RoleName`) VALUES
(1, 'Rol Super Admin'),
(2, 'Moderador Pro'),
(18, 'Moderator Regular');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `TypeUsers`
--

CREATE TABLE `TypeUsers` (
  `TypeUsersID` int(11) NOT NULL,
  `Name` varchar(64) NOT NULL,
  `Layout` varchar(64) NOT NULL,
  `UserHome` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `TypeUsers`
--

INSERT INTO `TypeUsers` (`TypeUsersID`, `Name`, `Layout`, `UserHome`) VALUES
(1, 'Administrador', '/admin', 'homeadmin'),
(2, 'Moderador', '/moderador', 'homemod'),
(3, 'Default', '/main', 'homeguest');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `UserAccount`
--

CREATE TABLE `UserAccount` (
  `UserName` varchar(64) NOT NULL,
  `AccountID` int(11) NOT NULL,
  `UserPassword` varchar(256) DEFAULT NULL,
  `IsActive` tinyint(4) DEFAULT NULL,
  `AuditDate` datetime DEFAULT NULL,
  `AuditUser` varchar(16) DEFAULT NULL,
  `AuditMessage` text,
  `IsAdminUser` tinyint(4) DEFAULT NULL,
  `TypeUser` int(2) NOT NULL,
  `IsRootUser` tinyint(4) DEFAULT NULL,
  `PhotoUrl` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `UserAccount`
--

INSERT INTO `UserAccount` (`UserName`, `AccountID`, `UserPassword`, `IsActive`, `AuditDate`, `AuditUser`, `AuditMessage`, `IsAdminUser`, `TypeUser`, `IsRootUser`, `PhotoUrl`) VALUES
('admin', 207, '827ccb0eea8a706c4c34a16891f84e7b', 1, '2017-07-26 00:00:00', 'User', NULL, 1, 1, 1, 'Wikipedia_User-ICON_byNightsight_72b9df.png'),
('moderador', 212, '827ccb0eea8a706c4c34a16891f84e7b', 0, NULL, NULL, NULL, NULL, 2, NULL, 'inversiones andrea_ec9a6b.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `UserByRole`
--

CREATE TABLE `UserByRole` (
  `UserByRoleID` int(11) NOT NULL,
  `UserName` varchar(64) NOT NULL,
  `RoleID` int(11) NOT NULL,
  `AuditUser` varchar(16) DEFAULT NULL,
  `AuditDate` datetime DEFAULT NULL,
  `AuditMessage` text,
  `IsActive` tinyint(4) DEFAULT NULL,
  `IsDefault` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `UserByRole`
--

INSERT INTO `UserByRole` (`UserByRoleID`, `UserName`, `RoleID`, `AuditUser`, `AuditDate`, `AuditMessage`, `IsActive`, `IsDefault`) VALUES
(1, 'admin', 1, NULL, '2017-08-09 00:00:00', 'usuario registrado desde la base de datos', 1, NULL),
(4, 'moderador', 1, 'jc', '2017-08-12 00:00:00', 'test', 1, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Account`
--
ALTER TABLE `Account`
  ADD PRIMARY KEY (`AccountID`);

--
-- Indices de la tabla `Agency`
--
ALTER TABLE `Agency`
  ADD PRIMARY KEY (`AgencyID`),
  ADD KEY `RefAccount3` (`AccountID`),
  ADD KEY `CountryID` (`Country`) USING BTREE;

--
-- Indices de la tabla `Country`
--
ALTER TABLE `Country`
  ADD PRIMARY KEY (`CountryID`);

--
-- Indices de la tabla `Menu`
--
ALTER TABLE `Menu`
  ADD PRIMARY KEY (`MenuID`);

--
-- Indices de la tabla `MenuByRole`
--
ALTER TABLE `MenuByRole`
  ADD PRIMARY KEY (`MenuByRoleID`),
  ADD KEY `RoleID` (`RoleID`),
  ADD KEY `MenuID` (`MenuID`);

--
-- Indices de la tabla `Page`
--
ALTER TABLE `Page`
  ADD PRIMARY KEY (`PageID`),
  ADD KEY `RefMenu14` (`MenuID`);

--
-- Indices de la tabla `Role`
--
ALTER TABLE `Role`
  ADD PRIMARY KEY (`RoleID`);

--
-- Indices de la tabla `TypeUsers`
--
ALTER TABLE `TypeUsers`
  ADD PRIMARY KEY (`TypeUsersID`);

--
-- Indices de la tabla `UserAccount`
--
ALTER TABLE `UserAccount`
  ADD PRIMARY KEY (`UserName`),
  ADD KEY `RefAccount15` (`AccountID`),
  ADD KEY `TypeUser` (`TypeUser`);

--
-- Indices de la tabla `UserByRole`
--
ALTER TABLE `UserByRole`
  ADD PRIMARY KEY (`UserByRoleID`),
  ADD KEY `userName` (`UserName`),
  ADD KEY `Rol` (`RoleID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `Account`
--
ALTER TABLE `Account`
  MODIFY `AccountID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=213;
--
-- AUTO_INCREMENT de la tabla `Agency`
--
ALTER TABLE `Agency`
  MODIFY `AgencyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `Country`
--
ALTER TABLE `Country`
  MODIFY `CountryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=242;
--
-- AUTO_INCREMENT de la tabla `Menu`
--
ALTER TABLE `Menu`
  MODIFY `MenuID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `MenuByRole`
--
ALTER TABLE `MenuByRole`
  MODIFY `MenuByRoleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;
--
-- AUTO_INCREMENT de la tabla `Page`
--
ALTER TABLE `Page`
  MODIFY `PageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;
--
-- AUTO_INCREMENT de la tabla `Role`
--
ALTER TABLE `Role`
  MODIFY `RoleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT de la tabla `TypeUsers`
--
ALTER TABLE `TypeUsers`
  MODIFY `TypeUsersID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `UserByRole`
--
ALTER TABLE `UserByRole`
  MODIFY `UserByRoleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `Agency`
--
ALTER TABLE `Agency`
  ADD CONSTRAINT `Agency_ibfk_1` FOREIGN KEY (`AccountID`) REFERENCES `Account` (`AccountID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `C64ntryqw` FOREIGN KEY (`Country`) REFERENCES `Country` (`CountryID`);

--
-- Filtros para la tabla `MenuByRole`
--
ALTER TABLE `MenuByRole`
  ADD CONSTRAINT `MenuByRole_ibfk_1` FOREIGN KEY (`RoleID`) REFERENCES `Role` (`RoleID`) ON DELETE CASCADE,
  ADD CONSTRAINT `MenuByRole_ibfk_2` FOREIGN KEY (`MenuID`) REFERENCES `Menu` (`MenuID`) ON DELETE CASCADE;

--
-- Filtros para la tabla `Page`
--
ALTER TABLE `Page`
  ADD CONSTRAINT `RefMenu14` FOREIGN KEY (`MenuID`) REFERENCES `Menu` (`MenuID`) ON DELETE CASCADE;

--
-- Filtros para la tabla `UserAccount`
--
ALTER TABLE `UserAccount`
  ADD CONSTRAINT `UserAccount_ibfk_1` FOREIGN KEY (`AccountID`) REFERENCES `Account` (`AccountID`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `UserAccount_ibfk_2` FOREIGN KEY (`TypeUser`) REFERENCES `TypeUsers` (`TypeUsersID`) ON DELETE NO ACTION;

--
-- Filtros para la tabla `UserByRole`
--
ALTER TABLE `UserByRole`
  ADD CONSTRAINT `UserByRole_ibfk_1` FOREIGN KEY (`UserName`) REFERENCES `UserAccount` (`UserName`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `UserByRole_ibfk_2` FOREIGN KEY (`RoleID`) REFERENCES `Role` (`RoleID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

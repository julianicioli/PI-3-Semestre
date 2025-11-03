-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 19/10/2025 às 19:09
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `aquasensedb`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `cadastrocidadao`
--

CREATE TABLE `cadastrocidadao` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cep` varchar(9) DEFAULT NULL,
  `estado` varchar(50) DEFAULT 'SP',
  `cidade` varchar(50) DEFAULT 'Itapira',
  `cpf` varchar(11) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `senha` varchar(255) NOT NULL,
  `data_cadastro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cadastrocidadao`
--

INSERT INTO `cadastrocidadao` (`id`, `nome`, `cep`, `estado`, `cidade`, `cpf`, `email`, `senha`, `data_cadastro`) VALUES
(1, 'cavenaghi', '13973-274', 'SP', 'Itapira', '128.379.128', 'cavenas@gmail', '2189639812', '2025-10-19 17:09:05');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `cadastrocidadao`
--
ALTER TABLE `cadastrocidadao`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cpf` (`cpf`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `cadastrocidadao`
--
ALTER TABLE `cadastrocidadao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

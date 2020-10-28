<?php

	require_once "conexao.php";

	$conexao = novaConexao(null);

	$sql = 'CREATE DATABASE crud_php';

	$a = $conexao->query($sql);

	if($a) {
		echo "deu certo";
	} else {
		echo "não deu";
	}

	$conexao->close();